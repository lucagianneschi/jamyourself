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
                $this->response(array('status' =>$controllers['NOACTFORREADMESS']), 503);
            }
            if ($activity->getRead() == false) {
                $res = $activityP->updateField($objectId, 'read', true);
            }
            if ($res instanceof Error) {
                $this->response(array('status' =>$controllers['NOREAD']), 503);
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
            $text = $this->request['message'];
            $title = $this->request['title'];
            if (strlen($text) < $this->config->minMessageSize) {
                $this->response(array('status' =>$controllers['SHORTMESSAGE'] . strlen($text)), 406);
            } elseif (strlen($title) < $this->config->minTitleSize) {
                $this->response(array('status' =>$controllers['SHORTTITLEMESSAGE'] . strlen($text)), 406);
            }
            require_once CONTROLLERS_DIR . 'utilsController.php';
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
            $message->setLovers(null);
            $message->setRecord(null);
            $message->setShareCounter(0);
            $message->setStatus(null);
            $message->setTags(null);
            $message->setText(parse_encode_string($text));
            $message->setTitle(parse_encode_string($title));
            $message->setToUser($toUserId);
            $message->setType('M');
            $message->setVideo(null);
            $message->setVote(null);
            $commentParse = new CommentParse();
            $resCmt = $commentParse->saveComment($message);
            if ($resCmt instanceof Error) {
                $this->response(array('status' =>'NOSAVEMESS'), 503);
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
            $activity->setStatus('A');
            $activity->setToUser($toUserId);
            $activity->setType('MESSAGESENT');
            $activity->setUserStatus(null);
            $activity->setVideo(null);
            $activityParse = new ActivityParse();
            $resActivity = $activityParse->saveActivity($activity);
            if ($resActivity instanceof Error) {
                $this->rollback($resCmt->getObjectId());
            }
            $this->response(array($controllers['MESSAGESAVED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    private function rollback($objectId) {
        global $controllers;
        $commentParse = new CommentParse();
        $res = $commentParse->deleteComment($objectId);
        if ($res instanceof Error) {
            $this->response(array('status' =>$controllers['ROLLKO']), 503);
        } else {
            $this->response(array('status' =>$controllers['ROLLOK']), 503);
        }
    }

}

?>