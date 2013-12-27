<?php

/* ! \par		Info Generali:
 * \author		Stefano Muscas
 * \version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di upload record 
 * \details		si collega al form di upload di un record, effettua controlli, scrive su DB
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once BOXES_DIR . "utilsBox.php";


/**
 * \brief	UploadRecordController class 
 * \details	controller di upload record
 */
class UploadAlbumController extends REST {

    public $viewRecordList;

    /**
     * \fn	init()
     * \brief   inizializzazione della pagina
     */
    public function init() {
//utente non loggato

        if (!isset($_SESSION['currentUser'])) {
            /* This will give an error. Note the output
             * above, which is before the header() call */
            header('Location: login.php?from=uploadAlbum.php');
            exit;
        }
    }

    /**
     * \fn	createAlbum()
     * \brief   funzione per pubblicazione dell'event
     * \modificare il nome in createRecord
     */
    public function createAlbum() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response($controllers['USERNOSES'], 402);
            } 
            
//            albumTitle
//            description
//            featuring
//            city
            
            $albumJSON = $this->request;
            $newAlbum = json_decode(json_encode($albumJSON), false);

            $user = $_SESSION['currentUser'];
            $userId = $user->getObjectId();

            
            
            
            
            $this->response(array("status" => $controllers['RECORDSAVED'], "id" => $savedRecord->getObjectId()), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }
    /**
     * \fn	createActivity($fromUser, $albumId, $type = 'ALBUMUPLOADED', $imageId = null)
     * \brief   funzione per creazione activity per questo controller
     * \param   $fromUser, $albumId, $type = 'ALBUMUPLOADED', $imageId = null
     */
    private function createActivity($fromUser, $albumId, $type = 'ALBUMUPLOADED', $imageId = null) {
        require_once CLASSES_DIR . 'activity.class.php';
        require_once CLASSES_DIR . 'activityParse.class.php';
        $activity = new Activity();
        $activity->setActive(true);
        $activity->setAlbum(null);
        $activity->setCounter(0);
        $activity->setEvent(null);
        $activity->setFromUser($fromUser);
        $activity->setImage(null);
        $activity->setPlaylist(null);
        $activity->setQuestion(null);
        $activity->setRead(true);
        $activity->setRecord($albumId);
        $activity->setSong($imageId);
        $activity->setStatus(null);
        $activity->setToUser(null);
        $activity->setType($type);
        $activity->setVideo(null);
        $pActivity = new ActivityParse();
        return $pActivity->saveActivity($activity);
    }

    /**
     * \fn	createFolderForRecord($userId, $albumId)
     * \brief   funzione per creazione filesystem dopo aggiunta record
     * \param   $userId, $albumId
     */
    private function createFolderForAlbum($userId, $albumId) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                //creazione cartella del record
                if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $albumId, 0777, true)) {
                    return false;
                }
                //creazione cartella delle cover del record
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover")) {
                    //se la cartella non esiste la creo
                    if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover", 0777, true)) {
                        return false;
                    }
                }
                //creazione cartella delle thumbnail del record                
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb")) {
                    //se la cartella non esiste la creao
                    if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb", 0777, true)) {
                        return false;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * \fn	getFeaturingJSON() 
     * \brief   funzione per il recupero dei featuring per l'event
     * \todo check possibilità utilizzo di questa funzione come pubblica e condivisa tra più controller
     */
    public function getFeaturingJSON() {
        try {
            $currentUserFeaturingArray = null;
            if (isset($_SESSION['currentUserFeaturingArray']) && !is_null($_SESSION['currentUserFeaturingArray'])) {//caching dell'array
                $currentUserFeaturingArray = $_SESSION['currentUserFeaturingArray'];
            } else {
                require_once CONTROLLERS_DIR . 'utilsController.php';
                $currentUserFeaturingArray = getFeaturingArray();
                $_SESSION['currentUserFeaturingArray'] = $currentUserFeaturingArray;
            }
            echo json_encode($currentUserFeaturingArray);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	$userId, $albumId, $imageId
     * \brief   funzione per il salvataggio di un mp3
     * param   $userId, $albumId, $imageId
     */
    private function saveImage($userId, $albumId, $imageId) {
        if (file_exists(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $imageId)) {
            $dir = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $albumId;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (!is_null($userId) && !is_null($albumId) && !is_null($imageId)) {
                $oldName = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $imageId;
                $newName = $dir . DIRECTORY_SEPARATOR . $imageId;
                return rename($oldName, $newName);
            }
        } else
            return false;
    }

}

?>