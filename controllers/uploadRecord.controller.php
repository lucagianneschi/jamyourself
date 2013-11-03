<?php

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'cropImage.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CONTROLLERS_DIR . 'utilsController.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

class uploadRecordController extends REST {

    public function init() {
        session_start();
    }

    public function albumCreate() {

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

//            "label": $("#label").val(),
//            "urlBuy": $("#urlBuy").val(),
//            "albumFeaturing": $("#albumFeaturing").val(),
//            "year": $("#year").val(),
//            "city": $("#city").val(),           

        $user = $_SESSION['currentUser'];
        $userId = $user->getObjectId();

        $pRecord = new RecordParse();
        $record = new Record();

        $record->setActive(true);
        $record->setBuyLink($newAlbum->urlBuy);
        $record->setCommentCounter(0);
        $record->setCounter(0);
//        $record->setCover("una cover");
//$record->setCoverFile();

        $imgInfo = $this->getImages($newAlbum);
        $record->setCover($imgInfo['RecordPicture']);
        $record->setThumbnailCover($imgInfo['RecordThumbnail']);

        $record->setDescription(parse_encode_string($newAlbum->albumTitle));
        $record->setDuration(0);
        $record->setFeaturing($this->getFeaturing($newAlbum->albumFeaturing));
        $record->setFromUser($userId);
        $record->setGenre($this->getTags($newAlbum->tags));
        $record->setLabel(parse_encode_string($newAlbum->label));

        if ($location = GeocoderService::getLocation($newAlbum->city)) {
            $parseGeoPoint = new parseGeoPoint($location);
            $record->setLocation($parseGeoPoint);
        }

        $record->setLoveCounter(0);
        $record->setReviewCounter(0);
        $record->setShareCounter(0);
//        $record->setThumbnailCover('Un thumbnail cover');
        $record->setTitle($newAlbum->albumTitle);
        $record->setYear($newAlbum->year);

        $newRecord = $pRecord->saveRecord($record);

        if (is_a($newRecord, "Error")) {
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

        $this->response(array("OK"), 200);
    }

    private function getFeaturing($list) {
//        @todo
//        if ($list != null && is_array($list) && count($list) > 0) {
//            $return = array();
//            foreach($list as $username)
//            $pUser = new UserParse();
//            $pUser->where("username", $username);
//            $feat = $pUser->getUsers();
//            if($feat!=null){
//                $return[] = $feat->getObjectId(); 
//            }
//        }
//        else
        return null;

        return array();
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

}

?>
