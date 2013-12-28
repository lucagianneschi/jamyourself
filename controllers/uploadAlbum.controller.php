<?php

/* ! \par		Info Generali:
 * \author		Stefano Muscas
 * \version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di upload album 
 * \details		si collega al form di upload di un album, effettua controlli, scrive su DB
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
 * \brief	UploadAlbumController class 
 * \details	controller di upload album
 */
class UploadAlbumController extends REST {

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
     * \modificare il nome in createAlbum
     */
    public function createAlbum() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response($controllers['USERNOSES'], 402);
            } elseif (!isset($this->request['title']) || is_null($this->request['title']) || !(strlen($this->request['title']) > 0)) {
                $this->response(array('status' => $controllers['NOALBUMTITLE']), 400);
            } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
                $this->response(array('status' => $controllers['NOALBUMDESCRIPTION']), 400);
            }

//            title
//            description
//            featuring
//            city

            $albumJSON = $this->request;
            $newAlbum = json_decode(json_encode($albumJSON), false);

            $user = $_SESSION['currentUser'];
            $userId = $user->getObjectId();

            $this->response(array("status" => $controllers['RECORDSAVED'], "id" => $savedAlbum->getObjectId()), 200);
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
        $activity->setAlbum($albumId);
        $activity->setSong($imageId);
        $activity->setStatus(null);
        $activity->setToUser(null);
        $activity->setType($type);
        $activity->setVideo(null);
        $pActivity = new ActivityParse();
        return $pActivity->saveActivity($activity);
    }

    /**
     * \fn	createFolderForAlbum($userId, $albumId)
     * \brief   funzione per creazione filesystem dopo aggiunta album
     * \param   $userId, $albumId
     */
    private function createFolderForAlbum($userId, $albumId) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                //creazione cartella del album
                if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $albumId, 0777, true)) {
                    return false;
                }
                //creazione cartella delle cover del album
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcover")) {
                    //se la cartella non esiste la creo
                    if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcover", 0777, true)) {
                        return false;
                    }
                }
                //creazione cartella delle thumbnail del album                
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcoverthumb")) {
                    //se la cartella non esiste la creao
                    if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcoverthumb", 0777, true)) {
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
            global $controllers;
            error_reporting(E_ALL ^ E_NOTICE);
            $force = false;
            if (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 400);
            }
            if (isset($this->request['force']) && !is_null($this->request['force']) && $this->request['force'] == "true") {
                $force = true;
            }
            $currentUserFeaturingArray = null;
            if ($force == false && isset($_SESSION['currentUserFeaturingArray']) && !is_null($_SESSION['currentUserFeaturingArray'])) {//caching dell'array
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

    public function getImagesList() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response($controllers['USERNOSES'], 403);
            } elseif (!isset($this->request['albumId']) || is_null($this->request['albumId']) || !(strlen($this->request['albumId']) > 0)) {
                $this->response(array("status" => $controllers['NOOBJECTID']), 403);
            }
            $albumId = $this->request['albumId'];
            $imagesList = imagelistGenerator($albumId);
            if ($imagesList instanceof Error) {
                $this->response(array("status" => $controllers['NODATA']), 200);
            } elseif (is_null($imagesList) || count($imagesList) == 0) {
                $this->response(array("status" => $controllers['NOIMAGEFORALBUM'], "imageList" => null, "count" => 0), 200);
            }
            $returnInfo = array();
            foreach ($imagesList as $image) {
// info utili
// mi serve: id, src, 
                $returnInfo[] = json_encode(array("id" => $image->getObjectId(), "src" => $image->getFilePath()));
            }
            $this->response(array("status" => $controllers['COUNTSONGOK'], "imageList" => $returnInfo, "count" => count($imagesList)), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    private function saveImage($src, $description, $featuringArray, $albumId) {
        try {
            $currentUser = $_SESSION['currentUser'];
            $cachedFile = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $src;
            if (!file_exists($cachedFile)) {
                return null;
            } else {
                if (!$this->moveFile($currentUser->getObjectId(), $albumId, $src)) {
                    return null;
                }
                $image = new Image();
                $image->setActive(true);
                $image->setAlbum($albumId);
                $image->setCommentCounter(0);
                $image->setCounter(0);
                $image->setDescription($description);
                if (is_array($featuringArray) && count($featuringArray) > 0) {
                    $image->setFeaturing($featuringArray);
                } else {
                    $image->setFeaturing(null);
                }
                $image->setFilePath($src);
                $image->setFromUser($currentUser->getObjectId());
                $image->setLocation(null);
                $image->setLoveCounter(0);
                $image->setLovers(array());
                $image->setShareCounter(0);
                $image->setTags(null);
                $image->setThumbnail(null);
                $pImage = new ImageParse();
                $savedImage = $pImage->saveImage($image);
                return $savedImage;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    private function addImageToAlbum($album, $imageId) {
        try {
            $currentUser = $_SESSION['currentUser'];
            $pAlbum = new AlbumParse();
            $albumId = $album->getObjectId();
            //recupero la tracklist
            $images = $album->getImages();
            if (is_null($images) || !is_array($images)) {
                $images = array();
            }
            //verifico che la canzone non sia gia' presente nella tracklist
            if (in_array($imageId, $images)) {
                return false;
            }
            //aggiorno la relazione album/song
            $res = $pAlbum->updateField($albumId, 'images', array($imageId), true, 'add', 'Song');
            if ($res instanceof Error) {
                return $res;
            }
            //creo l'activity specifica 
            require_once CLASSES_DIR . 'activityParse.class.php';
            $resActivity = $this->createActivity($currentUser->getObjectId(), $albumId, "IMAGEADDEDTOALBUM", $imageId);
            if ($resActivity instanceof Error) {
                return $resActivity;
            }
            //aggiorno il contatore del album
            $resIncr = $pAlbum->incrementAlbum($albumId, "imageCounter", 1);
            if ($resIncr instanceof Error) {
                return $resIncr;
            }
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function moveFile($userId, $albumId, $fileInCache) {
        if (file_exists(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $fileInCache)) {
            $dir = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $albumId;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (!is_null($userId) && !is_null($albumId) && !is_null($fileInCache)) {
                $oldName = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $fileInCache;
                $newName = $dir . DIRECTORY_SEPARATOR . $fileInCache;
                return rename($oldName, $newName);
            }
        } else
            return false;
    }

}
?>