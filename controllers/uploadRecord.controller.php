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

class uploadRecordController extends REST {

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
//caching dell'array dei featuring
        $_SESSION['currentUserFeaturingArray'] = $this->getFeaturingArray();

        $recordBox = new RecordBox();
        $recordBox->initForUploadRecordPage($currentUser->getObjectId());
        $this->viewRecordList = $recordBox->recordArray;
       
    }

    public function albumCreate() {

        global $controllers;

        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }

        $albumJSON = $this->request;
        $newAlbum = json_decode(json_encode($albumJSON), false);

//        
//            "albumTitle": $("#albumTitle").val(),
//            "description": $("#description").val(),
//            "tags": getTagsAlbumCreate()        

        if (!isset($newAlbum->albumTitle) || is_null($newAlbum->albumTitle) || !(strlen($newAlbum->albumTitle) > 0) ||
                !isset($newAlbum->description) || is_null($newAlbum->description) || !(strlen($newAlbum->description) > 0) ||
                !isset($newAlbum->tags) || is_null($newAlbum->tags) || !is_array($newAlbum->tags) || !(count($newAlbum->tags) > 0)
        ) {
            $error = array('status' => "Bad Request", "msg" => "Invalid new album");
            $this->response($error, 400);
        }

        $user = $_SESSION['currentUser'];
        $userId = $user->getObjectId();

        if ($user->getType() != "JAMMER") {
            $error = array('status' => "Bad Request", "msg" => "Invalid user type");
            $this->response($error, 400);
        }

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
            $error = array('status' => "Service Unavailable", "msg" => $newRecord->getErrorMessage());
            $this->response($error, 503);
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

        $this->response(array("res" => "OK", "recordId" => $newRecord->getObjectId()), 200);
    }

    private function getTags($list) {
        return implode(",", $list);
    }

    private function createFolderForRecord($userId, $albumId) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $albumId, 0, true);

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

    public function publishRecords() {
        global $controllers;
        if ($this->get_request_method() != "POST") {
            $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
        } elseif (!isset($_SESSION['currentUser'])) {
            $this->response(array('status' => $controllers['USERNOSES']), 403);
        } elseif (!isset($this->request['list'])) {
            $this->response(array('status' => $controllers['NOOBJECTID']), 403);
        } elseif (!isset($this->request['recordId'])) {
            $this->response(array('status' => $controllers['NOMP3LIST']), 403);
        } 

        $currentUser = $_SESSION['currentUser'];
        $recordId = $this->request['recordId'];
        $songList = $this->request['list'];

        if (count($songList) > 0) {
            $pSong = new SongParse();
            
            foreach ($songList as $element) {          
                
                $src = $element['src'];
                $tags = $element['tags'];
                $featuring = $element['featuring'];
                $title = $element['songTitle'];
                $duration = $element['duration'];
         
                $song = new Song();
                $song->setDuration($duration);
                $song->setTitle($title);
                $song->setFeaturing($featuring);
                $song->setGenre($tags);
                $song->setFilePath($src);
                             
                if($pSong->saveSong($jamSong) instanceof Error){
                    //errore
                } 
                
                $this->saveMp3($currentUser->getObjectId(), $recordId, $src);
                
//                salvataggio actitivy
            }
        }

        $this->response(array($controllers['RECORDSAVED']), 200);
    }

    private function saveMp3($userId, $recordId, $songId) {
        if (file_exists(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $songId)) {
            $dir = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $recordId;
            if (!is_dir($dir)) {
                mkdir($dir, 0, true);
            }

            if (!is_null($userId) && !is_null($recordId) && !is_null($songId)) {
                rename(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $songId, $dir . DIRECTORY_SEPARATOR . $songId);
            }
        }
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

}

?>
