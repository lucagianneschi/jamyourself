<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di mesaggio
 * \details		invia il messaggio e corrispondente activity;legge il messaggio
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once DEBUG_DIR . 'debug.php';

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
     * \fn		readMessage()
     * \brief   update activity for the current read message
     * \todo    usare la sessione
     */
    public function readMessage() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif ($this->request['objectId']) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }
	    //require_once CLASSES_DIR . 'activity.class.php'; si può non importate
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $objectId = $this->request['objectId'];
	    $activityP = new ActivityParse();
	    $activity = $activityP->getActivity($objectId);
	    if ($activity instanceof Error) {
		$this->response(array($controllers['NOACTFORREADMESS']), 503);
	    } else {
		if ($activity->getRead() == false) {
		    $res = $activityP->updateField($objectId, 'read', true);
		    if ($res instanceof Error) {
			$this->response(array($controllers['NOREAD']), 503);
		    }
		} else {
		    $this->response(array($controllers['MESSAGEREAD']), 200);
		}
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		sendMessage()
     * \brief   save a message an the related activity
     * \todo    usare la sessione
     */
    public function sendMessage() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['text'])) {
		$this->response(array('status' => $controllers['NOMESSAGE']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSER']), 400);
	    }
	    $fromUser = $_SESSION['currentUser'];
	    $toUserId = $this->request['toUser'];
	    $text = $this->request['text'];
	    if (strlen($text) < $this->config->minMessageSize) {
		$this->response(array($controllers['SHORTMESSAGE'] . strlen($text)), 400);
	    }
	    require_once CONTROLLERS_DIR . 'utilsController.php';
	    require_once CLASSES_DIR . 'comment.class.php';
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $message = new Comment();
	    $message->setActive(true);
	    $message->setAlbum(null);
	    $message->setComment(null);
	    $message->setCommentCounter(0);
	    $message->setCommentators(null);
	    $message->setComments(null);
	    $message->setCounter(0);
	    $message->setEvent(null);
	    $message->setFromUser($fromUser->getObjectId());
	    $message->setImage(null);
	    $message->setLocation(null);
	    $message->setLoveCounter(0);
	    $message->setLovers(null);
	    $message->setRecord(null);
	    $message->setShareCounter(0);
	    $message->setStatus(null);
	    $message->setTags(null);
	    $encodedText = parse_encode_string($text);
	    $message->setText($encodedText);
	    $message->setTitle(null);
	    $message->setToUser($toUserId);
	    $message->setType('M');
	    $message->setVideo(null);
	    $message->setVote(null);
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($fromUser->getObjectId());
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
	    $commentParse = new CommentParse();
	    $resCmt = $commentParse->saveComment($message);
	    if ($resCmt instanceof Error) {
		$this->response(array('NOSAVEMESS'), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error) {
		    $this->rollback($resCmt->getObjectId());
		}
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
	    $this->response(array($controllers['ROLLKO']), 503);
	} else {
	    $this->response(array($controllers['ROLLOK']), 503);
	}
    }

}

?>