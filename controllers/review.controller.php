<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di inserimento di una review 
 * \details		inserisce una review ad un evento o ad un record
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
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	ReviewController class 
 * \details	controller di inserimento di una review 
 */
class ReviewController extends REST {

    public $config;

    /**
     * \fn		construct()
     * \brief   load config file for the controller
     */
    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/review.config.json"), false);
    }

    /**
     * \fn		review()
     * \brief   save a review an the related activity
     * \todo    
     */
    public function sendReview() {
        global $controllers;
        global $mail_files;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($this->request['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif ($this->request['objectId']) {
                $this->response(array('status' => $controllers['NOOBJECTID']), 403);
            } elseif ($this->request['classType']) {
                $this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
            } elseif (!isset($this->request['text'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOREW']), 400);
            } elseif (!isset($this->request['objectId'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOOBJECTID']), 400);
            } elseif (!isset($this->request['classType'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOCLASSTYPE']), 400);
            } elseif (!isset($this->request['toUser'])) {
                $this->response(array('status' => $controllers['NOTOUSER']), 403);
            } elseif (!isset($this->request['title'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOTITLE']), 400);
            }
            $currentUser = $this->request['currentUser'];
            $classType = $this->request['classType'];
            $objectId = $this->request['objectId'];
            $text = $this->request['text']; //dovrò prendere questo da un form
            $title = $this->request['title'];//dovrò prendere questo da un form
            $toUser = $this->request['toUser'];
            if ($currentUser->getObjectId() === $toUser) {
                $this->response(array('NOSELFREVIEW'), 200);
            } elseif (strlen($text) < $this->config->minReviewSize) {
                $this->response(array($controllers['SHORTREW'] . strlen($text)), 200);
            } elseif (strlen($text) > $this->config->maxReviewSize) {
                $this->response(array($controllers['LONGREW'] . strlen($text)), 200);
            }
            require_once CLASSES_DIR . 'userParse.class.php';
            $userP = new UserParse();
            $user = $userP->getUser($toUser);
            if ($user instanceof Error) {
                $this->response(array('NOMAILFORREVIEW'), 503);
            }
            require_once CLASSES_DIR . 'comment.class.php';
            require_once CLASSES_DIR . 'commentParse.class.php';
            require_once CONTROLLERS_DIR . 'utilsController.php';
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
            $review->setTitle(parse_encode_string($title));
            $review->setText(parse_encode_string($text));
            $review->setToUser($toUser);
            $review->setVideo(null);
            $review->setVote(null);
            switch ($classType) {
                case 'Event':
                    $review->setEvent($objectId);
                    $review->setType('RE');
                    $eventId = $objectId;
                    $recordId = null;
                    $type = "NEWEVENTREVIEW";
                    $subject = $controllers['SBJE'];
                    $html = file_get_contents(STDHTML_DIR . $mail_files['EVENTREVIEWEMAIL']);
                    break;
                case 'Record':
                    $review->setRecord($objectId);
                    $review->setType('RR');
                    $eventId = null;
                    $recordId = $objectId ;
                    $type = "NEWRECORDREVIEW";
                    $subject = $controllers['SBJR'];
                    $html = file_get_contents(STDHTML_DIR . $mail_files['RECORDREVIEWEMAIL']);
                    break;
            }
            $commentParse = new CommentParse();
            $resRev = $commentParse->saveComment($review);
            if ($resRev instanceof Error) {
                $this->response(array('NOSAVEDREVIEW'), 503);
            }
            require_once SERVICES_DIR . 'mail.service.php';
            $mail = new MailService(true);
            $mail->IsHTML(true);
            $mail->AddAddress($user->getEmail());
            $mail->Subject = $subject;
            $mail->MsgHTML($html);
            $resMail = $mail->Send();
            if ($resMail instanceof phpmailerException) {
                $this->response(array('status' => $controllers['NOMAIL']), 403);
            }
            $mail->SmtpClose();
            unset($mail);
            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setCounter(0);
            $activity->setEvent($eventId);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRead(false);
            $activity->setRecord($recordId);
            $activity->setSong(null);
            $activity->setStatus('A');
            $activity->setToUser($toUser);
            $activity->setType($type);
            $activity->setUserStatus(null);
            $activity->setVideo(null);
            $activityParse = new ActivityParse();
            $resActivity = $activityParse->saveActivity($activity);
            if ($resActivity instanceof Error) {
                $this->rollback($resRev->getObjectId());
            }
            $this->response(array($controllers['REWSAVED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    private function rollback($objectId) {
        global $controllers;
        $commentParse = new CommentParse();
        $res = $commentParse->deleteComment($objectId);
        if ($res instanceof Error) {
            $this->response(array($controllers['ROLLKO']), 503);
        } else {
            $this->response(array($controllers['ROLLOK']), 503);
        }
    }

}

?>