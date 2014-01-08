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
            } elseif (!isset($this->request['albumTitle']) || is_null($this->request['albumTitle']) || !(strlen($this->request['albumTitle']) > 0)) {
                $this->response(array('status' => $controllers['NOALBUMTITLE']), 403);
            } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
                $this->response(array('status' => $controllers['NOALBUMDESCRIPTION']), 404);
            } elseif (!isset($this->request['city']) || is_null($this->request['city'])) {
                $this->response(array('status' => $controllers['NOALBUMLOCATION']), 405);
            } elseif (!isset($this->request['images']) || is_null($this->request['images']) || !is_array($this->request['images']) || !(count($this->request['images']) > 0) || !$this->validateAlbumImages($this->request['images'])) {
                $this->response(array('status' => $controllers['NOALBUMLOCATION']), 406);
            }

            $currentUser = $_SESSION['currentUser'];

            $album = new Album();
            $album->setActive(true);
            $album->setCommentCounter(0);
            $album->setCounter(0);
            $album->setCover(DEFALBUMCOVER);
            $album->setDescription($this->request['description']);
            if (isset($this->request['featuring']) && is_array($this->request['featuring']) && count($this->request['featuring']) > 0) {
                $album->setFeaturing($this->request['featuring']);
            }
            $album->setFromUser($currentUser->getObjectId());
            $album->setImageCounter(0);
            $infoLocation = GeocoderService::getCompleteLocationInfo($this->request['city']);
            $parseGeoPoint = new parseGeoPoint($infoLocation["latitude"], $infoLocation["longitude"]);
            $album->setLocation($parseGeoPoint);
            $album->setLoveCounter();
            $album->setLovers(array());
            $album->setShareCounter(0);
            $album->setTags(array());
            $album->setThumbnailCover(DEFALBUMTHUMB);
            $album->setTitle($this->request['albumTitle']);

            $albumParse = new AlbumParse();
            $albumSaved = $albumParse->saveAlbum($album);
            if ($albumSaved instanceof Error) {
                //@todo rollback
                
                $this->response(array('status' => $controllers['ALBUMNOTSAVED']), 407);
            }
            $albumId = $albumSaved->getObjectId();

            //creo le cartelle dell'album
            if (!$this->createFolderForAlbum($currentUser->getObjectId(), $albumId)) {
                //@todo rollback
                $this->response(array("status" => $controllers['ALBUMNOTSAVED']), 408);                
            }
            //activity per l'album
            $resActivity = $this->createActivity($currentUser->getObjectId(), $albumId);
            if ($resActivity instanceof Error) {
                //@todo rollback
                $this->response(array("status" => $controllers['ALBUMNOTSAVED']), 409);
            }
            //ora devo aggiungere tutte le foto
            $errorImages = array();
            foreach ($this->request['images'] as $image) {
                $resImage = $this->saveImage($image['src'], $image['description'], $image['featuring'], $albumId);
                if ($resImage instanceof Error || $resImage instanceof Exception || is_null($resImage)) {
                    array_push($errorImages, $image);
                } else {
                    //se l'immagine è quella scelta come cover:
                    if ($image['isCover'] == "true") {
                        $albumParseUpdate = new AlbumParse();
                        $resUpdateCover = $albumParseUpdate->updateField($albumId, "cover", $resImage->getFilePath());
                        if ($resUpdateCover instanceof Error) {
                            //@todo rollback
                            array_push($errorImages, $image);
                            continue;
                        }
                        $resUpdateThumb = $albumParseUpdate->updateField($albumId, "thumbnailCover", $resImage->getThumbnail());
                        if ($resUpdateThumb instanceof Error) {
                            //@todo rollback
                            array_push($errorImages, $image);
                            continue;
                        }
                    }
                    //in ogni caso:
                    $resRelation = $this->addImageToAlbum($albumSaved, $resImage->getObjectid());
                    if ($resRelation instanceof Error || $resRelation instanceof Exception || is_null($resRelation)) {
                        //@todo rollback
                        array_push($errorImages, $image);
                        continue;
                    }
                }
            }
            if (count($errorImages) == count($this->request['images'])) {
                //nessuna immagine salvata, ma album creato
                $this->response(array("status" => $controllers['ALBUMSAVENOIMGSAVED'], "id" => $albumSaved->getObjectId()), 200);
            } elseif (count($errorImages) > 0) {
                //immagini salvate, ma non tutte....
                $this->response(array("status" => $controllers['ALBUMSAVEDWITHERRORS'], "id" => $albumSaved->getObjectId()), 200);
            } else {
                //tutto OK
                $this->response(array("status" => $controllers['ALBUMSAVED'], "id" => $albumSaved->getObjectId()), 200);
            }
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
        $activity->setAlbum($albumId);
        $activity->setCounter(0);
        $activity->setEvent(null);
        $activity->setFromUser($fromUser);
        $activity->setImage(null);
        $activity->setPlaylist(null);
        $activity->setQuestion(null);
        $activity->setRead(true);
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
            $filter = null;

            if (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 400);
            }
            if (isset($this->request['force']) && !is_null($this->request['force']) && $this->request['force'] == "true") {
                $force = true;
            }
            if (isset($this->request['term']) && !is_null($this->request['term']) && (strlen($this->request['term']) > 0)) {
                $filter = $this->request['term'];
            }
            $currentUserFeaturingArray = null;
            if ($force == false && isset($_SESSION['currentUserFeaturingArray']) && !is_null($_SESSION['currentUserFeaturingArray'])) {//caching dell'array
                $currentUserFeaturingArray = $_SESSION['currentUserFeaturingArray'];
            } else {
                require_once CONTROLLERS_DIR . 'utilsController.php';
                $currentUserFeaturingArray = getFeaturingArray();
                $_SESSION['currentUserFeaturingArray'] = $currentUserFeaturingArray;
            }

            if (!is_null($filter)) {
                require_once CONTROLLERS_DIR . 'utilsController.php';
                echo json_encode(filterFeaturingByValue($currentUserFeaturingArray, $filter));
            } else {
                echo json_encode($currentUserFeaturingArray);
            }
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
            $this->response(array("status" => $controllers['COUNTALBUMOK'], "imageList" => $returnInfo, "count" => count($imagesList)), 200);
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
                return $pImage->saveImage($image);
            }
        } catch (Exception $e) {
            return $e;
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
                return null;
            }
            //aggiorno la relazione album/image
            $res = $pAlbum->updateField($albumId, 'images', array($imageId), true, 'add', 'Image');
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
        }
        else
            return false;
    }

    public function getAlbums() {
        global $controllers;
        if ($this->get_request_method() != "POST") {
            $this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
        } elseif (!isset($_SESSION['currentUser'])) {
            $this->response($controllers['USERNOSES'], 402);
        }

        require_once BOXES_DIR . "album.box.php";
        $albumBox = new AlbumBox();
        $albumBox->initForUploadAlbumPage();

        $albumList = array();
        if (is_null($albumBox->error) && count($albumBox->albumArray) > 0) {
            foreach ($albumBox->albumArray as $album) {
                $retObj = array();
                $retObj["thumbnail"] = $this->getAlbumThumbnailURL(sessionChecker(), $album->getThumbnailCover());
                $retObj["title"] = $album->getTitle();
                $retObj["images"] = $album->getImageCounter();
                $retObj["albumId"] = $album->getObjectId();
                $albumList[] = $retObj;
            }
        }

        $this->response(array("status" => $controllers['GETALBUMSSOK'], "albumList" => $albumList, "count" => count($albumList)), 200);
    }

    private function getAlbumThumbnailURL($userId, $albumCoverThumb) {
        try {
            if (!is_null($albumCoverThumb) && strlen($albumCoverThumb) > 0 && !is_null($userId) && strlen($userId) > 0) {
                $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcoverthumb" . DIRECTORY_SEPARATOR . $albumCoverThumb;
                if (!file_exists($path)) {
                    return DEFALBUMTHUMB;
                } else {
                    return "../users/" . $userId . "/images/recordcoverthumb/" . $albumCoverThumb;
                }
            } else {
                $path = DEFALBUMTHUMB;
            }
            return DEFALBUMTHUMB;
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    private function validateAlbumImages($imageList) {
        if (is_array($imageList) && count($imageList) > 0) {
            foreach ($imageList as $elem) {
                if (!isset($elem["description"]) || is_null($elem["description"]) || !( strlen($elem["description"]) > 0)) {
                    return false;
                }
                if (!isset($elem["src"]) || is_null($elem["src"]) || !( strlen($elem["src"]) > 0)) {
                    return false;
                }
                if (!isset($elem["featuring"]) || is_null($elem["featuring"]) || !is_array($elem["featuring"])) {
                    return false;
                }
                if (!isset($elem["isCover"]) || is_null($elem["isCover"]) || !(strlen($elem["isCover"]) > 0)) {
                    return false;
                }
            }
        }
        return true;
    }

}

?>