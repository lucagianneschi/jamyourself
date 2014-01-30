<?php
/* ! \par		Info Generali:
 * \author		Stefano Muscas
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di upload review 
 * \details		si collega al form di upload di una review, effettua controlli, scrive su DB
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once BOXES_DIR . 'review.box.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	UploadReviewController class 
 * \details	controller di upload review
 */
class UploadReviewController extends REST {

    public $reviewedId;
    public $reviewed;
    public $reviewedFeaturing;
    public $reviewedClassType;
    public $reviewedFromUser;

    /**
     * \fn	init()
     * \brief   inizializzazione della pagina
     */
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
            if (!is_null($revieBox->error)) {
                //errore @todo
            } elseif (is_null($revieBox->mediaInfo)) {
                // errore @todo
            } else {
                $this->reviewed = $revieBox->mediaInfo[0];
                $this->reviewedFeaturing = getRelatedUsers($this->reviewedId, "featuring", $this->reviewedClassType);
                $this->reviewedFromUser = $this->reviewed->getFromUser();
                if ($this->reviewedFeaturing instanceof Error) {
                    //errore parse
                }
            }
        } else {
            die("Errore");
        }
    }

    /**
     * \fn	publish()
     * \brief   funzione per pubblicazione review
     */
    public function publish() {
        global $controllers;
        global $mail_files;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif ((!isset($this->request['reviewedId']) || is_null($this->request['reviewedId']) || !(strlen($this->request['reviewedId']) > 0))) {
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
            $this->reviewedId = $reviewRequest->reviewedId;
            $this->reviewedClassType = $reviewRequest->type;
            $revieBox = new ReviewBox();
            $revieBox->initForUploadReviewPage($this->reviewedId, $this->reviewedClassType);
            if (!is_null($revieBox->error)) {
                $this->response(array('status' => $controllers['ERRORREVIEW']), 403);
            } elseif (count($revieBox->mediaInfo) == 0) {
                $this->response(array('status' => $controllers['ERRORREVIEW']), 403);
            } else {
                $this->reviewed = $revieBox->mediaInfo[0];
            }
            $rating = intval($this->request['rating']);
            $allowedForReview = array('Event', 'Record');
            if (!in_array($this->reviewedClassType, $allowedForReview)) {
                $this->response(array("status" => $controllers['CLASSTYPEKO']), 406);
            } elseif ($this->reviewed instanceof Error || is_null($this->reviewed)) {
                $this->response(array("status" => $controllers['NODATA']), 406);
            }
            $toUser = $this->reviewed->getFromUser();
            if ($toUser->getObjectId() == $currentUser->getObjectId()) {
                $this->response(array("status" => $controllers['NOSELFREVIEW']), 403);
            }
            require_once CLASSES_DIR . 'comment.class.php';
            require_once CLASSES_DIR . 'commentParse.class.php';
            $review = new Comment();
            $review->setActive(true);
            $review->setAlbum(null);
            $review->setCounter(0);
            $review->setFromUser($currentUser->getObjectId());
            $review->setImage(null);
            $review->setLocation(null);
            $review->setLoveCounter(0);
            $review->setLovers(array());
            $review->setShareCounter(0);
            $review->setSong(null);
            $review->setStatus(null);
            $review->setTags(array());
            $review->setTitle(null);
            $review->setText($reviewRequest->review);
            $review->setToUser($toUser->getObjectId());
            $review->setVideo(null);
            $review->setVote($rating);
            switch ($this->reviewedClassType) {
                case 'Event' :
                    $review->setEvent($this->reviewedId);
                    $review->setRecord(null);
                    $review->setType('RE');
                    $type = "NEWEVENTREVIEW";
                    $subject = $controllers['SBJE'];
                    $html = $mail_files['EVENTREVIEWEMAIL'];
                    break;
                case 'Record';
                    $review->setEvent(null);
                    $review->setRecord($this->reviewedId);
                    $review->setType('RR');
                    $type = "NEWRECORDREVIEW";
                    $subject = $controllers['SBJR'];
                    $html = $mail_files['RECORDREVIEWEMAIL'];
                    break;
            }
            require_once CONTROLLERS_DIR."utilsController.php";
            sendMailForNotification($toUser->getObjectId(), $subject, $html);
            $commentParse = new CommentParse();
            $resRev = $commentParse->saveComment($review);
            if ($resRev instanceof Error) {
                $this->response(array("status" => $controllers['NOSAVEDREVIEW']), 503);
            } elseif ($this->saveActivityForNewReview($type, $toUser->getObjectId()) instanceof Error) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackUploadReviewController($resRev->getObjectId());
                $this->response(array('status' => $message), 503);
            }
            $this->response(array("status" => $controllers['REWSAVED'], "id" => $resRev->getObjectId()), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }

    /**
     * \fn	getUserEmail($objectId)
     * \brief   funzione per il recupero della mail dell'utente a cui mandare la mail
     * \param   $objectId dello user per il recupero della usa email
     */
    private function getUserEmail($objectId) {
        require_once CLASSES_DIR . 'user.class.php';
        require_once CLASSES_DIR . 'userParse.class.php';
        $pUser = new UserParse();
        $user = $pUser->getUser($objectId);
        if ($user instanceof Error || is_null($user)) {
            return "";
        }
        $email = $user->getEmail();
        return $email;
    }

    /**
     * \fn	saveActivityForNewReview($type, $toUser)
     * \brief   funzione per il salvataggio dell'activity connessa all'inserimento della review
     * \todo    differenziare il caso event o record
     */
    private function saveActivityForNewReview($type, $toUser) {
        require_once CLASSES_DIR . 'user.class.php';
        require_once CLASSES_DIR . 'activity.class.php';
        require_once CLASSES_DIR . 'activityParse.class.php';
        $currentUser = $_SESSION['currentUser'];
        $activity = new Activity();
        $activity->setActive(true);
        $activity->setCounter(0);
        $activity->setFromUser($currentUser->getObjectId());
        $activity->setRead(false);
        $activity->setStatus('A');
        $activity->setType($type);
        $activity->setToUser($toUser);
        if ($type == "NEWEVENTREVIEW") {
            $activity->setEvent($this->reviewed->getObjectId());
            $activity->setRecord(null);
        } else {
            $activity->setEvent(null);
            $activity->setRecord($this->reviewed->getObjectId());
        }
        $activityParse = new ActivityParse();
        $resActivity = $activityParse->saveActivity($activity);
        return $resActivity;
    }

}
?>