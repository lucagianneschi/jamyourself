<?php

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CONTROLLERS_DIR . 'utilsController.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

class uploadRecordController extends REST {

    public $recordId;
    public $record;
    public $recordInfo;

    public function init() {
        session_start();

        if (isset($_GET["recordId"]) && strlen($_GET["recordId"]) > 0) {
            $this->recordId = $_GET["recordId"];
            $this->record = $this->getRecord($this->recordId);
            $this->recordInfo = array();
            $this->recordInfo["title"] = $this->record->getTitle();
            $this->recordInfo["thumbnail"] = $this->getRecordThumbnailURL($this->record->getFromUser(),$this->recordId);
            $this->recordInfo["rating"] = $this->getRecordRating();
            $this->recordInfo["tagGenere"] = $this->getRecordTagGenre();
            $this->recordInfo["featuringInfoArray"] = $this->getRecordFeaturingInfoArray();
            $this->recordInfo["author"] = $this->getRecordAuthor();
        } else {
            //PER IL TEST
            
            ?>
            <a href="<?php echo VIEWS_DIR."uploadReview.php?recordId=MSUtmBy6T4" ?>">Test link</a>
            <br>
            <br>
            <?php

            die("Devi specificare un album Id ");
        }
    }

    public function publish(){
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }
        
        
        
    }
    
////////////////////////////////////////////////////////////////////////////////
//
//          Funzioni private per il recupero delle Info per la View
//
////////////////////////////////////////////////////////////////////////////////
    private function getRecord($recordId) {
        $pRecord = new RecordParse();
        $record = $pRecord->getRecord($recordId);

        if ($record instanceof Error || $record == null) {
            return null;
        }
        else
            return $record;
    }

    private function getRecordFeaturingInfoArray() {
        $info = array();
        $featuringIds = $this->record->getFeaturing();

        if (count($featuringIds) > 0) {
            $pUser = new UserParse();
            foreach ($featuringIds as $userId) {
                $featurinUser = $pUser->getUser($userId);
                if (!($featurinUser instanceof Error) && (!is_null($featurinUser))) {
                    $username = $featurinUser->getUsername();
                    $featuringUserId = $featurinUser->getObjectId();
                    $featuringThumbnail = $this->getUserThumbnailURL($featuringUserId, $featurinUser->getProfileThumbnail());
                    array_push($info, array("featuringThumbnail" => $featuringThumbnail, "featuringUsername" => $username, "featuringUserId" => $featuringUserId));
                }
            }
        }
        return $info;
    }

    private function getUserThumbnailURL($userId, $thumbId) {
        $path = "";
        if (!is_null($thumbId) && strlen($thumbId) > 0 && !is_null($userId) && strlen($userId) > 0) {
            $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicturethumb" . DIRECTORY_SEPARATOR . $thumbId;
            if (!file_exists($path)) {
                $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultAvatarThumb.jpg";
            }
        } else {
            //immagine di default con path realtivo rispetto alla View
            //"http://socialmusicdiscovering.com/media/images/default/defaultAvatarThumb.jpg";              
            $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultAvatarThumb.jpg";
        }

        return $path;
    }

    private function getRecordThumbnailURL($userId, $recordId) {
        $path = "";
        if (!is_null($recordId) && strlen($recordId) > 0 && !is_null($userId) && strlen($userId) > 0) {
            $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $recordId;
            if (!file_exists($path)) {
                $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultEventThumb.jpg";
            }
        } else {
            //immagine di default con path realtivo rispetto alla View
            //http://socialmusicdiscovering.com/media/images/default/defaultEventThumb.jpg
            $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultEventThumb.jpg";
        }

        return $path;
    }

    private function getRecordRating() {
        //@Todo
        $recordId = $this->record->getObjectId();
        return 3;
    }

    private function getRecordTagGenre() {
        if (!is_null($this->record)) {
            return $this->record->getGenre();
        } else {
            return "";
        }
    }

    private function getRecordAuthor() {
        if (!is_null($this->record)) {
            $authorId = $this->record->getFromUser();
            $pUser = new UserParse();
            $author = $pUser->getUser($authorId);
            if (!($author instanceof Error) && !is_null($author)) {
                return $author->getUsername();
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

}
?>
