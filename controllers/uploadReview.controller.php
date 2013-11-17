<?php
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CONTROLLERS_DIR . 'utilsController.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

class uploadReviewController extends REST {

    public $recordId;
    public $record;
    public $recordInfo;

    public function init() {
        session_start();

        if (!isset($_SESSION['currentUser'])) {
            die("Non sei collegato.");
        }

        if (isset($_GET["recordId"]) && strlen($_GET["recordId"]) > 0) {
            $this->recordId = $_GET["recordId"];
            $this->record = $this->getRecord($this->recordId);
            if ($this->record instanceof Error || is_null($this->record)) {
                die("Nessun record trovato con questo ID : " . $this->recordId);
            }
            $this->recordInfo = array();
            $this->recordInfo["title"] = $this->record->getTitle();
            $this->recordInfo["thumbnail"] = $this->getRecordThumbnailURL($this->record->getFromUser(), $this->record->getThumbnailCover());
            $this->recordInfo["rating"] = $this->getRecordRating();
            $this->recordInfo["tagGenere"] = $this->getRecordTagGenre();
            $this->recordInfo["featuringInfoArray"] = $this->getRecordFeaturingInfoArray();
            $this->recordInfo["author"] = $this->getRecordAuthor();
            $this->recordInfo["authorThumbnail"] = $this->getUserThumbnailURL($this->record->getFromUser());
        } else {
            //PER IL TEST
            ?>
            <a href="<?php echo VIEWS_DIR . "uploadReview.php?recordId=OoW5rEt94b" ?>">Test link</a>
            <br>
            <br>
            <?php
            die("Devi specificare un album Id ");
        }
    }

    public function publish() {
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser']) ||
                (!isset($this->request['record']) || is_null($this->request['record']) || !(strlen($this->request['record']) > 0)) ||
                (!isset($this->request['rating']) || is_null($this->request['rating']) || !(strlen($this->request['rating']) > 0 )) ||
                (!isset($this->request['review']) || is_null($this->request['review']) || !(strlen($this->request['review']) > 0 ))) {
            $this->response('', 406);
        }

        $currentUser = $_SESSION['currentUser'];
        $reviewRequest = json_decode(json_encode($this->request), false);
        $this->recordId = $reviewRequest->record;
        $this->record = $this->getRecord($this->recordId);
        if ($this->record instanceof Error || is_null($this->record)) {
            $this->response('', 406);
        }
        if ($this->record->getFromUser() == $currentUser->getObjectId()) {
            //non puoi commentare i tuoi stessi album
            $this->response('', 406);
        }

        $review = new Comment();
        $review->setActive(true);
        $review->setAlbum(null);
        $review->setComment(null);
        $review->setCommentCounter(0);
        $review->setCommentators(null);
        $review->setComments(null);
        $review->setCounter(0);
        $review->setFromUser($currentUser->getObjectId());
        $review->setImage(null);
        $review->setLocation(null);
        $review->setLoveCounter(0);
        $review->setLovers(null);
        $review->setShareCounter(0);
        $review->setSong(null);
        $review->setStatus(null);
        $review->setTags(null);
//        $review->setTitle(parse_encode_string($reviewRequest->title));
        $review->setText(parse_encode_string($reviewRequest->review));
        $review->setToUser($this->record->getFromUser());
        $review->setVideo(null);
        $review->setVote(null);

//        $this->sendMailNotification();
        
        $review->setRecord($this->record->getObjectId());
        $review->setType('RR');
        $commentParse = new CommentParse();
        $resRev = $commentParse->saveComment($review);
        if ($resRev instanceof Error) {
            $this->response(array('NOSAVEDREVIEW'), 503);
        }

        if(!$this->saveActivityForNewRecordReview()){
            $this->rollback($resRev->getObjectId());            
        }
//        $this->response(array($controllers['REWSAVED']), 200);
        $this->response(array("res" => "OK"), 200);
    }

    private function getUserEmail($objectId) {
        $pUser = new UserParse();
        $user = $pUser->getUser($objectId);
        if ($user instanceof Error || is_null($user)) {
            return "";
        }
        $email = $user->getEmail();
        return $email;
    }

    private function saveActivityForNewRecordReview() {
        $currentUser = $_SESSION['currentUser'];
        $activity = new Activity();
        $activity->setActive(true);
        $activity->setCounter(0);
        $activity->setFromUser($currentUser->getObjectId());
        $activity->setRead(false);
        $activity->setRecord($this->record->getObjectId());
        $activity->setStatus('A');
        $activity->setToUser($this->record->getFromUser());
        $activity->setType("NEWRECORDREVIEW");
        $activityParse = new ActivityParse();
        $resActivity = $activityParse->saveActivity($activity);
        if ($resActivity instanceof Error) {
            return false;
        }
        else
            return true;
    }

    private function rollback($objectId) {
//        global $controllers;
        $commentParse = new CommentParse();
        $res = $commentParse->deleteComment($objectId);
        if ($res instanceof Error) {
            $this->response(array($controllers['ROLLKO']), 503);
        } else {
            $this->response(array($controllers['ROLLOK']), 503);
        }
    }

    private function sendMailNotification() {
        $subject = $controllers['SBJR'];
        $html = file_get_contents(STDHTML_DIR . $mail_files['RECORDREVIEWEMAIL']);
        require_once SERVICES_DIR . 'mail.service.php';
        $mail = new MailService(true);
        $mail->IsHTML(true);
        $mail->AddAddress($this->getUserEmail($this->record->getToUser()));
        $mail->Subject = $subject;
        $mail->MsgHTML($html);
        $resMail = $mail->Send();
        if ($resMail instanceof phpmailerException) {
            $this->response(array('status' => $controllers['NOMAIL']), 403);
        }
        $mail->SmtpClose();
        unset($mail);
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

    private function getUserThumbnailURL($userId) {
        $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultAvatarThumb.jpg";

        if (!is_null($userId) && strlen($userId) > 0) {

            $pAuthor = new UserParse();
            $author = $pAuthor->getUser($userId);

            if (!$author instanceof Error && !is_null($author)) {
                $thumbId = $author->getProfileThumbnail();
                $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicturethumb" . DIRECTORY_SEPARATOR . $thumbId;
                if (!file_exists($path)) {
                    $path = MEDIA_DIR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "defaultAvatarThumb.jpg";
                }
            }
        }
        return $path;
    }

    private function getRecordThumbnailURL($userId, $recordCoverThumb) {
        $path = "";
        if (!is_null($recordCoverThumb) && strlen($recordCoverThumb) > 0 && !is_null($userId) && strlen($userId) > 0) {
            $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $recordCoverThumb;
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
