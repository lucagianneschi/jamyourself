<?php
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'mail.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CONTROLLERS_DIR . 'rollBackUtils.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once BOXES_DIR . 'review.box.php';

class UploadReviewController extends REST {

    public $reviewedId;
    public $reviewed;
    public $reviewedFeaturing;
    public $reviewedClassType;
    public $reviewedFromUser; 

    public function init() {

        if (!isset($_SESSION['currentUser'])) {
            /* This will give an error. Note the output
             * above, which is before the header() call */
            header('Location: login.php?from=uploadReview.php');
            exit;
        }


        if (isset($_GET["rewiewId"]) && strlen($_GET["rewiewId"]) > 0 && (isset($_GET["type"]) && strlen($_GET["type"]) > 0) && ( ($_GET["type"] == "Event" ) || ($_GET["type"] == "Record" ))) {
            $this->reviewedId = $_GET["rewiewId"];
            $this->reviewedClassType = $_GET["type"];

            $revieBox = new ReviewBox();
            $revieBox->initForUploadReviewPage($this->reviewedId, $this->reviewedClassType);

            if (!is_null($revieBox->error) ) {   
                //errore @todo
                
            }
            elseif(is_null($revieBox->mediaInfo)){
                // errore @todo

            }else{
                $this->reviewed = $revieBox->mediaInfo[0];
                $this->reviewedFeaturing = getRelatedUsers($this->reviewedId, "featuring", $this->reviewedClassType);
                $this->reviewedFromUser = $this->reviewed->getFromUser();
                
                
                if($this->reviewedFeaturing instanceof Error){
                    //errore parse
                    
                }
            }
            
        } else {
            //PER IL TEST
            ?>
            <a href="<?php echo VIEWS_DIR . "uploadReview.php?rewiewId=OoW5rEt94b&type=Record" ?>">Test link</a>
            <br>
            <br>
            <?php
            die("Devi specificare un Id ");
        }
    }

    public function publish() {
        global $controllers;

        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif ((!isset($this->request['record']) || is_null($this->request['record']) || !(strlen($this->request['record']) > 0))) {
                $this->response(array('status' => $controllers['NOOBJECTID']), 403);
            } elseif ((!isset($this->request['review']) || is_null($this->request['review']) || !(strlen($this->request['review']) > 0 ))) {
                $this->response(array('status' => $controllers['NOREW']), 403);
            } elseif ((!isset($this->request['rating']) || is_null($this->request['rating']) || !(strlen($this->request['rating']) > 0 ))) {
                $this->response(array('status' => $controllers['NORATING']), 403);
            } elseif ((!isset($this->request['type']) || is_null($this->request['type']) || !(strlen($this->request['type']) > 0 ))) {
                $this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
            }



            $currentUser = $_SESSION['currentUser'];
            $reviewRequest = json_decode(json_encode($this->request), false);
            $this->reviewedId = $reviewRequest->record;
            $this->reviewed = $this->getRecord($this->reviewedId);
            $this->reviewedClassType = $reviewRequest->type;
            $rating = intval($this->request['rating']);
            if ($this->reviewed instanceof Error || is_null($this->reviewed)) {
                $this->response(array("status" => $controllers['NODATA']), 406);
            }
            if ($this->reviewed->getFromUser() == $currentUser->getObjectId()) {
                //non puoi commentare i tuoi stessi album
                $this->response(array("status" => $controllers['NOSELFREVIEW']), 403);
            }

            $review = new Comment();
            $review->setActive(true);

            switch (strtolower($this->reviewedClassType)) {
                case 'event' :
                    $review->setEvent($this->reviewedId);
                    $review->setAlbum(null);
                    break;
                case 'record';
                    $review->setAlbum($this->reviewedId);
                    $review->setEvent(null);
                    break;
                default:
                    //che classe si sta commentanto??
                    $this->response(array("status" => $controllers['CLASSTYPEKO']), 403);
            }

            $review->setComment(null);
            $review->setCommentCounter(0);
            $review->setCommentators(null);
            $review->setComments(null);
            $review->setCounter(0);
            $review->setFromUser($currentUser->getObjectId());
            $review->setImage(null);
            $review->setLocation(null);
            $review->setLoveCounter(0);
            $review->setLovers(array());
            $review->setShareCounter(0);
            $review->setSong(null);
            $review->setStatus(null);
            $review->setTags(null);
            $review->setTitle(null);
            $review->setText($reviewRequest->review);
            $review->setToUser($this->reviewed->getFromUser());
            $review->setVideo(null);
            $review->setVote($rating);
//            $review->setACL($ACL);

            $this->sendMailNotification();

            $review->setRecord($this->reviewed->getObjectId());
            $review->setType('RR');
            $commentParse = new CommentParse();
            $resRev = $commentParse->saveComment($review);
            if ($resRev instanceof Error) {
                $this->response(array("status" => $controllers['NOSAVEDREVIEW']), 503);
            }

            if (!$this->saveActivityForNewRecordReview()) {
                rollbackUploadReviewController($resRev->getObjectId());
            }
            $this->response(array("status" => $controllers['REWSAVED']), 200);
        } catch (Exception $e) {
            $this->response(array("status" => $controllers['NODATA']), 503);
        }
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
        $activity->setRecord($this->reviewed->getObjectId());
        $activity->setStatus('A');
        $activity->setToUser($this->reviewed->getFromUser());
        $activity->setType("NEWRECORDREVIEW");
        $activityParse = new ActivityParse();
        $resActivity = $activityParse->saveActivity($activity);
        if ($resActivity instanceof Error) {
            return false;
        }
        else
            return true;
    }

    private function sendMailNotification() {
        global $controllers;
        global $mail_files;
        $subject = $controllers['SBJR'];
        $html = file_get_contents(STDHTML_DIR . $mail_files['RECORDREVIEWEMAIL']);
        $mail = mailService();
        $mail->IsHTML(true);
        $mail->AddAddress($this->getUserEmail($this->reviewed->getFromUser()));
        $mail->Subject = $subject;
        $mail->MsgHTML($html);
        $resMail = $mail->Send();
        if ($resMail instanceof phpmailerException) {
            $this->response(array('status' => $controllers['NOMAIL']), 403);
        }
        $mail->SmtpClose();
        unset($mail);
    }

}
?>
