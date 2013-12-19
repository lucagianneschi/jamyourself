<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di mesaggio
 * \details		invia il messaggio e corrispondente activity;legge il messaggio
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		testare
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'relationChecker.service.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	MessageController class 
 * \details	controller per l'invio di messaggi
 */
class MessageController extends REST {

    public $config;

    /**
     * \fn		construct()
     * \brief   load config file for the controller
     */
    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/message.config.json"), false);
    }

    /**
     * \fn	read()
     * \brief   update activity for the current read message
     * \todo    testare
     */
    public function read() {
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif ($this->request['objectId']) {
                $this->response(array('status' => $controllers['NOOBJECTID']), 403);
            }
            require_once CLASSES_DIR . 'activityParse.class.php';
            $objectId = $this->request['objectId'];
            $activityP = new ActivityParse();
            $activity = $activityP->getActivity($objectId);
            if ($activity instanceof Error) {
                $this->response(array('status' => $controllers['NOACTFORREADMESS']), 503);
            } elseif ($activity->getRead() != false) {
                $this->response(array('status' => $controllers['ALREADYREAD']), 503);
            } else {
                $res = $activityP->updateField($objectId, 'read', true);
                $res1 = $activityP->updateField($objectId, 'status', 'A');
            }
            if ($res instanceof Error || $res1 instanceof Error) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackMessageController($objectId, 'readMessage');
                $this->response(array('status' => $message), 503);
            }
            $this->response(array($controllers['MESSAGEREAD']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	message()
     * \brief   save a message an the related activity
     * \todo    testare, possibilità di invio a utenti multipli, controllo della relazione
     */
    public function message() {
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['message'])) {
                $this->response(array('status' => $controllers['NOMESSAGE']), 403);
            } elseif (!isset($this->request['toUser'])) {
                $this->response(array('status' => $controllers['NOTOUSER']), 403);
            } elseif (!isset($this->request['title'])) {
                $this->response(array('status' => $controllers['NOMESSAGETITLE']), 400);
            }
            $currentUser = $this->request['currentUser'];
            $toUserId = $this->request['toUser'];
            $toUserType = $this->request['toUserType'];
            if (relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserId, $toUserType)) {
                $this->response(array('status' => $controllers['NOSPAM']), 401);
            }
            $text = $this->request['message'];
            $title = $this->request['title'];
            if (strlen($text) < $this->config->minMessageSize) {
                $this->response(array('status' => $controllers['SHORTMESSAGE'] . strlen($text)), 406);
            } elseif (strlen($title) < $this->config->minTitleSize) {
                $this->response(array('status' => $controllers['SHORTTITLEMESSAGE'] . strlen($text)), 406);
            }
            require_once CLASSES_DIR . 'comment.class.php';
            require_once CLASSES_DIR . 'commentParse.class.php';
            $message = new Comment();
            $message->setActive(true);
            $message->setAlbum(null);
            $message->setComment(null);
            $message->setCommentCounter(0);
            $message->setCommentators(null);
            $message->setComments(null);
            $message->setCounter(0);
            $message->setEvent(null);
            $message->setFromUser($currentUser->getObjectId());
            $message->setImage(null);
            $message->setLocation(null);
            $message->setLoveCounter(0);
            $message->setLovers(array());
            $message->setRecord(null);
            $message->setShareCounter(0);
            $message->setStatus(null);
            $message->setTags(array());
            $message->setText($text);
            $message->setTitle($title);
            $message->setToUser($toUserId);
            $message->setType('M');
            $message->setVideo(null);
            $message->setVote(null);
            $commentParse = new CommentParse();
            $resCmt = $commentParse->saveComment($message);
            if ($resCmt instanceof Error) {
                $this->response(array('status' => 'NOSAVEMESS'), 503);
            }
            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRead(false);
            $activity->setRecord(null);
            $activity->setSong(null);
            $activity->setStatus('P');
            $activity->setToUser($toUserId);
            $activity->setType('MESSAGESENT');
            $activity->setVideo(null);
            $activityParse = new ActivityParse();
            $resActivity = $activityParse->saveActivity($activity);
            if ($resActivity instanceof Error) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackMessageController($resCmt->getObjectId(), 'sendMessage');
                $this->response(array('status' => $message), 503);
            }
            global $mail_files;
            require_once CLASSES_DIR . 'userParse.class.php';
            $userParse = new UserParse();
            $user = $userParse->getUser($toUserObjectId);
            #TODO
            //$address = $user->getEmail();
            $address = 'alesandro.ghilarducci@gmail.com';
            $subject = $controllers['SBJMESSAGE'];
            $html = $mail_files['MESSAGEEMAIL'];
            sendMailForNotification($address, $subject, $html);
            $this->response(array($controllers['MESSAGESAVED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

}

?>