<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'cropImage.service.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once BOXES_DIR . "record.box.php";
require_once BOXES_DIR . "utilsBox.php";
require_once SERVICES_DIR . 'mp3.service.php';

class UploadRecordController extends REST {

    public $viewRecordList;

    public function init() {
//utente non loggato

        if (!isset($_SESSION['currentUser'])) {
            /* This will give an error. Note the output
             * above, which is before the header() call */
            header('Location: login.php?from=uploadRecord.php');
            exit;
        }

        $currentUser = $_SESSION['currentUser'];
//caching dell'array dei featuring: tolto per velocizzare la pagina, verra' chiamato
//in maniera asincrona
//        $_SESSION['currentUserFeaturingArray'] = $this->getFeaturingArray();

        $recordBox = new RecordBox();
        $recordBox->initForUploadRecordPage($currentUser->getObjectId());
        $this->viewRecordList = $recordBox->recordArray;
    }

    public function albumCreate() {

        global $controllers;

        if ($this->get_request_method() != "POST") {
            $this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
        } elseif (!isset($_SESSION['currentUser'])) {
            $this->response($controllers['USERNOSES'], 403);
        } elseif (!isset($this->request['albumTitle']) || is_null($this->request['albumTitle']) || !(strlen($this->request['albumTitle']) > 0)) {
            $this->response(array("status" => $controllers['NOTITLE']), 403);
        } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
            $this->response(array("status" => $controllers['NODESCRIPTION']), 403);
        } elseif (!isset($this->request['tags']) || is_null($this->request['tags']) || !is_array($this->request['tags']) || !(count($this->request['tags']) > 0)) {
            $this->response(array("status" => $controllers['NOTAGS']), 403);
        } elseif ($_SESSION['currentUser']->getType() != "JAMMER") {
            $this->response(array("status" => $controllers['CLASSTYPEKO']), 400);
        }

        $albumJSON = $this->request;
        $newAlbum = json_decode(json_encode($albumJSON), false);

        $user = $_SESSION['currentUser'];
        $userId = $user->getObjectId();


        $pRecord = new RecordParse();
        $record = new Record();

        $record->setActive(true);
        $record->setBuyLink($newAlbum->urlBuy);
        $record->setCommentCounter(0);
        $record->setCounter(0);
//$record->setCoverFile();
        $imgInfo = $this->getImages($newAlbum);
        $record->setCover($imgInfo['RecordPicture']);
        $record->setThumbnailCover($imgInfo['RecordThumbnail']);

        $record->setDescription($newAlbum->albumTitle);
        $record->setDuration(0);
        $record->setFeaturing($newAlbum->albumFeaturing);
        $record->setFromUser($userId);
        $record->setGenre($this->getTags($newAlbum->tags));
        $record->setLabel($newAlbum->label);

        if (($location = GeocoderService::getLocation($newAlbum->city))) {
            $parseGeoPoint = new parseGeoPoint($location['lat'], $location['lng']);
            $record->setLocation($parseGeoPoint);
        }

        $record->setLoveCounter(0);
        $record->setReviewCounter(0);
        $record->setShareCounter(0);
        $record->setTitle($newAlbum->albumTitle);
        $record->setYear($newAlbum->year);

        $newRecord = $pRecord->saveRecord($record);

        if ($newRecord instanceof Error) {
//result è un errore e contiene il motivo dell'errore
            $this->response(array("status" => $controllers['NODATA']), 503);
        }

//se va a buon fine salvo una nuova activity       
        $activity = new Activity();
        $activity->setActive(true);
        $activity->setFromUser($userId);
        $activity->setRead(true);
        $activity->setStatus("A");
        $activity->setType("CREATEDRECORD");
//            $activity->setACL(toParseDefaultACL());

        $pActivity = new ActivityParse();
        $pActivity->saveActivity($activity);

        $this->createFolderForRecord($userId, $newRecord->getObjectId());

        $dirThumbnailDest = USERS_DIR . $userId . "/images/recordcover";
        $dirCoverDest = USERS_DIR . $userId . "/images/recordcoverthumb";


//SPOSTO LE IMMAGINI NELLE RISPETTIVE CARTELLE         
        if (!is_null($record->getThumbnailCover()) && strlen($record->getThumbnailCover()) > 0 && strlen($record->getCover()) && !is_null($record->getCover())) {
            rename(MEDIA_DIR . "cache/" . $record->getThumbnailCover(), $dirThumbnailDest . DIRECTORY_SEPARATOR . $record->getThumbnailCover());
            rename(MEDIA_DIR . "cache/" . $record->getCover(), $dirCoverDest . DIRECTORY_SEPARATOR . $record->getCover());
        }

        unset($_SESSION['currentUserFeaturingArray']);

        $this->response(array("status" => $controllers[''], "id" => $newRecord->getObjectId()), 200);
    }

    private function getTags($list) {
        if (is_array($list) && count($list) > 0) {
            return implode(",", $list);
        }
        else
            return "";
    }

    private function createFolderForRecord($userId, $albumId) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $albumId, 0777, true);

                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images")) {
                    $bool = mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images");
                }
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover")) {
                    $bool = mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover");
                }
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb")) {
                    $bool = mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb");
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function publishSongs() {
        global $controllers;
        if ($this->get_request_method() != "POST") {
            $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
        } elseif (!isset($_SESSION['currentUser'])) {
            $this->response(array('status' => $controllers['USERNOSES']), 403);
        } elseif (!isset($this->request['list'])) {
            $this->response(array('status' => $controllers['NOOBJECTID']), 403);
        } elseif (!isset($this->request['recordId'])) {
            $this->response(array('status' => $controllers['NOMP3LIST']), 403);
        } elseif (!isset($this->request['count'])) {
            $this->response(array('status' => $controllers['NOCOUNT']), 403);
        }

        $currentUser = $_SESSION['currentUser'];
        $recordId = $this->request['recordId'];
        $songList = $this->request['list'];
        $counter = intval($this->request['count']);
        $songErrorList = array(); //lista canzoni non caricate
        $songSavedList = array();

        if (count($songList) > 0) {
            $pSong = new SongParse();

            foreach ($songList as $songIstance) {
                $element = json_decode(json_encode($songIstance), false);
                $cachedFile = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $element->src;
                if (!file_exists($cachedFile)) {
                    //errore... il file non e' piu' in cache... :(
                    $songErrorList[] = $element;
                } else {
                    $counter++;
                    $song = new Song();
                    $song->setActive(true);
                    $song->setCommentCounter(0);
                    $song->setCommentators(array());
                    $song->setComments(0);
                    $song->setCounter(0);
                    $song->setDuration($this->getRealLength($cachedFile));
                    if (isset($element->featuring))
                        $song->setFeaturing($element->featuring);
                    else
                        $song->setFeaturing(array());
                    $song->setFilePath($element->src);
                    $song->setFromUser($currentUser->getObjectId());
                    $song->setGenre(implode(",", $element->tags));
                    $song->setLocation(null);
                    $song->setLovers(array());
                    $song->setLoveCounter(0);
                    $song->setPosition($counter);
                    $song->setRecord($recordId);
                    $song->setCounter(0);
                    $song->setShareCounter(0);
                    $song->setTitle($element->title);

                    $savedSong = $pSong->saveSong($song);
                    if ($savedSong instanceof Error) {
                        //errore: inserire una rollback per la cancellazione di tutti gli mp3? 
                        //come gestire?
                        //idea: salvo una lista degli mp3 il cui salvataggio e' fallito
                        $songErrorList[] = $element;

                        //cancello l'mp3 dalla cache
                        unlink(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $element->src);
                    } else {
                        //salvo la struttura del file system
                        $result = $this->saveMp3($currentUser->getObjectId(), $recordId, $song->getFilePath());
                        if (!$result || !$this->savePublishSongActivity($savedSong)) {
                            //errore salvataggio activity-> rollback?
                        }

                        //aggiungo il songId alla lista degli elementi salvati
                        $element->id = $savedSong->getObjectId();
                        $songSavedList[] = $element;
                    }
                }
            }
            //aggiorno il counter del record
            $pRecord = new RecordParse();
            if ($pRecord->incrementRecord($recordId, "songCounter", $counter) instanceof Error) {
                $this->response(array("status" => $controllers['SONGSAVEDWITHERROR'], "errorList" => $songErrorList, "savedList" => $songSavedList), 200);                
            }
            //gestione risposte
            else if (count($songErrorList) == 0) {
                //nessun errore
                $this->response(array("status" => $controllers['ALLSONGSSAVED'], "errorList" => null, "savedList" => $songSavedList), 200);
            } elseif (count($songSavedList) == 0) {
                //nessuna canzone salvata => tutti errori  
                $this->response(array("status" => $controllers['NOSONGSAVED']), 403);
            } else {
                //salvate parzialmente, qualche errore
                $this->response(array("status" => $controllers['SONGSAVEDWITHERROR'], "errorList" => $songErrorList, "savedList" => $songSavedList), 200);
            }
        }
    }

    private function saveMp3($userId, $recordId, $songId) {
        if (file_exists(MEDIA_DIR . "cache" . "/" . $songId)) {
            $dir = USERS_DIR . $userId . "/" . "songs" . "/" . $recordId;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            if (!is_null($userId) && !is_null($recordId) && !is_null($songId)) {
                $oldName = MEDIA_DIR . "cache" . "/" . $songId;
                $newName = $dir . "/" . $songId;
                return rename($oldName, $newName);
            }
        }
        else
            return false;
    }

    private function getRealLength($cachedFile) {
        $mp3Analysis = new Mp3file($cachedFile);
        $metaData = $mp3Analysis->get_metadata();
        return (int) $metaData['Length'];
    }

    private function savePublishSongActivity(Song $song) {
        $activity = new Activity();

        $activity->setActive(true);
        $activity->setAlbum(null);
        $activity->setComment(null);
        $activity->setCounter(-1);
        $activity->setEvent(null);
        $activity->setFromUser($song->getFromUser());
        $activity->setImage(null);
        $activity->setPlaylist(null);
        $activity->setQuestion(null);
        $activity->setRead();
        $activity->setRecord($song->getRecord());
        $activity->setSong($song->getObjectId());
        $activity->setStatus(null);
        $activity->setToUser(null);
        $activity->setType(null);
        $activity->setUserStatus(null);
        $activity->setVideo(null);
//        $activity->setACL();

        $pActivity = new ActivityParse();
        if (($pActivity->saveActivity($activity)) instanceof Error)
            return false;
        else
            return true;
    }

    private function getImages($decoded) {
//in caso di anomalie ---> default
        if (!isset($decoded->crop) || is_null($decoded->crop) ||
                !isset($decoded->image) || is_null($decoded->image)) {
            return array("RecordPicture" => null, "RecordThumbnail" => null);
        }

        $PROFILE_IMG_SIZE = 300;
        $THUMBNAIL_IMG_SIZE = 150;

//recupero i dati per effettuare l'editing
        $cropInfo = json_decode(json_encode($decoded->crop), false);

        if (!isset($cropInfo->x) || is_null($cropInfo->x) || !is_numeric($cropInfo->x) ||
                !isset($cropInfo->y) || is_null($cropInfo->y) || !is_numeric($cropInfo->y) ||
                !isset($cropInfo->w) || is_null($cropInfo->w) || !is_numeric($cropInfo->w) ||
                !isset($cropInfo->h) || is_null($cropInfo->h) || !is_numeric($cropInfo->h)) {
            return array("RecordPicture" => null, "RecordThumbnail" => null);
        }
        $cacheDir = MEDIA_DIR . "cache/";
        $cacheImg = $cacheDir . $decoded->image;

//Preparo l'oggetto per l'editign della foto
        $cis = new CropImageService();

//gestione dell'immagine di profilo
        $coverId = $cis->cropImage($cacheImg, $cropInfo->x, $cropInfo->y, $cropInfo->w, $cropInfo->h, $PROFILE_IMG_SIZE);
        $coverUrl = $cacheDir . $coverId;

//gestione del thumbnail
        $thumbId = $cis->cropImage($coverUrl, 0, 0, $PROFILE_IMG_SIZE, $PROFILE_IMG_SIZE, $THUMBNAIL_IMG_SIZE);
        $thumbUrl = $cacheDir . $thumbId;

//CANCELLAZIONE DELLA VECCHIA IMMAGINE
        unlink($cacheImg);
//RETURN        
        return array('RecordPicture' => $coverId, 'RecordThumbnail' => $thumbId);
    }

    /**
     * Prepara la variabile di sessione contenente i featuring dell'utente per 
     * compilare il form, campo featuring
     * 
     */
    public function getFeaturingJSON() {

        $currentUserFeaturingArray = null;
        if (isset($_SESSION['currentUserFeaturingArray'])) {
//caching dell'array
            $currentUserFeaturingArray = $_SESSION['currentUserFeaturingArray'];
        } else {
            $currentUserFeaturingArray = $this->getFeaturingArray();
            $_SESSION['currentUserFeaturingArray'] = $currentUserFeaturingArray;
        }

        echo json_encode($currentUserFeaturingArray);
    }

    private function getFeaturingArray() {
        error_reporting(E_ALL ^ E_NOTICE);
        if (isset($_SESSION['currentUser'])) {
            $currentUser = $_SESSION['currentUser'];
            $currnetUserId = $currentUser->getObjectId();
            $parseUser = new UserParse();
            $parseUser->whereRelatedTo('collaboration', '_User', $currnetUserId);
            $parseUser->where('type', 'JAMMER');
            $parseUser->where('active', true);
            $parseUser->setLimit(1000);
            $users = $parseUser->getUsers();
            error_reporting(E_ALL);

            if (($users instanceof Error) || is_null($users)) {
                return array();
            } else {
                $userArray = array();
                foreach ($users as $user) {
                    $username = $user->getUsername();
                    $userId = $user->getObjectId();
                    array_push($userArray, array("key" => $userId, "value" => $username));
                }

                return $userArray;
            }
        }
        else
            return array();
    }

    public function getRecordThumbnailURL($userId, $recordCoverThumb) {
        $path = "";
        if (!is_null($recordCoverThumb) && strlen($recordCoverThumb) > 0 && !is_null($userId) && strlen($userId) > 0) {
            $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $recordCoverThumb;
            if (!file_exists($path)) {
                $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultRecordThumb.jpg";
            }
        } else {
//immagine di default con path realtivo rispetto alla View
//http://socialmusicdiscovering.com/media/images/default/defaultEventThumb.jpg
            $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultRecordThumb.jpg";
        }

        return $path;
    }

    public function getSongsList() {
        global $controllers;

        if ($this->get_request_method() != "POST") {
            $this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
        } elseif (!isset($_SESSION['currentUser'])) {
            $this->response($controllers['USERNOSES'], 403);
        } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || !(strlen($this->request['recordId']) > 0)) {
            $this->response(array("status" => $controllers['NOOBJECTID']), 403);
        } elseif ($_SESSION['currentUser']->getType() != "JAMMER") {
            $this->response(array("status" => $controllers['CLASSTYPEKO']), 400);
        }

        $albumId = $this->request['recordId'];

        $songsList = tracklistGenerator($albumId);

        if ($songsList instanceof Error || is_null($songsList)) {
            $this->response(array("status" => $controllers['NODATA']), 503);
        } elseif (count($songsList) == 0) {
            $this->response(array("status" => $controllers['NOSONGFORRECORD'], "songList" => null, "count" => 0), 200);
        }
        $returnInfo = array();
        foreach ($songsList as $song) {
            // info utili
            // mi serve: titolo, durata, lista generi
            $title = $song->getTitle();
            $seconds = $song->getDuration();
            $hours = floor($seconds / 3600);
            $mins = floor(($seconds - ($hours * 3600)) / 60);
            $secs = floor($seconds % 60);

            $duration = $hours == 0 ? $mins . ":" . $secs : $hours . ":" . $mins . ":" . $secs;

            $genre = $song->getGenre();
            $returnInfo[] = json_encode(array("title" => $title, "duration" => $duration, "genre" => $genre));
        }

        $this->response(array("status" => $controllers['COUNTSONGOK'], "songList" => $returnInfo, "count" => count($songsList)), 200);
    }

}

?>
