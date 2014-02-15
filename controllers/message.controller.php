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
 * \todo		fare API su Wiki, eliminare TODO per invio mail
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'relationChecker.service.php';

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
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "messageController.config.json"), false);
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
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $id = $this->request['id'];
	    $activityP = new ActivityParse();
	    $activity = $activityP->getActivity($id);
	    if ($activity instanceof Error) {
		$this->response(array('status' => $controllers['NOACTFORREADMESS']), 503);
	    } elseif ($activity->getRead() != false) {
		$this->response(array('status' => $controllers['ALREADYREAD']), 503);
	    } else {
		$res = $activityP->updateField($id, 'read', true);
		$res1 = $activityP->updateField($id, 'status', 'A');
	    }
	    if ($res instanceof Error || $res1 instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackMessageController($id, 'readMessage');
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
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
	    } elseif (!isset($this->request['message'])) {
		$this->response(array('status' => $controllers['NOMESSAGE']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $toUserId = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    if (!relationChecker($currentUser->getId(), $currentUser->getType(), $toUserId, $toUserType)) {
		$this->response(array('status' => $controllers['NOSPAM']), 401);
	    }
	    $text = $this->request['message'];
	    if (strlen($text) < $this->config->minMessageSize) {
		$this->response(array('status' => $controllers['SHORTMESSAGE'] . strlen($text)), 406);
	    }
	    require_once CLASSES_DIR . 'comment.class.php';
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    $message = new Comment();
	    $message->setActive(true);
	    $message->setCommentcounter(0);
	    $message->setFromuser($currentUser->getId());
	    $message->setLocation(null);
	    $message->setLovecounter(0);
	    $message->setLovers(array());
	    $message->setSharecounter(0);
	    $message->setTag(array());
	    $message->setText($text);
	    $message->setTitle(null);
	    $message->setToUser($toUserId);
	    $message->setType('M');
	    $message->setVideo(null);
	    $message->setVote(null);
	    $commentParse = new CommentParse();
	    $resCmt = $commentParse->saveComment($message);
	    if ($resCmt instanceof Error) {
		$this->response(array('status' => 'NOSAVEMESS'), 503);
	    }
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $toActivity = $this->createActivity($currentUser->getId(), $toUserId, 'P', $resCmt->getId(), 'MESSAGESENT');
	    $fromActivity = $this->createActivity($toUserId, $currentUser->getId(), 'A', $resCmt->getId(), 'MESSAGESENT');
	    $activityParse = new ActivityParse();
	    $resToActivity = $activityParse->saveActivity($toActivity);
	    $resFromActivity = $activityParse->saveActivity($fromActivity);
	    if ($resToActivity instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackMessageController($resCmt->getId(), 'sendMessage');
		$this->response(array('status' => $message), 503);
	    }
	    if ($resFromActivity instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackMessageController($resCmt->getId(), 'sendMessage');
		$this->response(array('status' => $message), 503);
	    }
	    global $mail_files;
	    require_once CLASSES_DIR . 'userParse.class.php';
	    require_once CONTROLLERS_DIR . 'utilsController.php';
	    $userParse = new UserParse();
	    $user = $userParse->getUser($toUserId);
	    $address = $user->getEmail();
	    $subject = $controllers['SBJMESSAGE'];
	    $html = $mail_files['MESSAGEEMAIL'];
	    sendMailForNotification($address, $subject, $html);
	    $this->response(array($controllers['MESSAGESAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	createActivity($fromuser,$touser)
     * \brief   private function to delete activity class instance
     * \param   $id
     */
    public function deleteConversation() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $touser = $this->request['toUser'];
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new ActivityParse();
	    $activity->wherePointer('fromUser', '_User', $currentUser->getId());
	    $activity->wherePointer('toUser', '_User', $touser);
	    $activity->where('type', 'MESSAGESENT');
	    $activity->where('status', 'A');
	    $activity->where('active', true);
	    $conversation = $activity->getActivities();
	    if ($conversation instanceof Error) {
		$this->response(array('status' => 'ERROR_MSG'), 503);
	    } elseif (is_null($conversation)) {
		$this->response(array('status' => 'NO_DEL'), 503);
	    } else {
		foreach ($conversation as $message) {
		    $statusUpdate = $activity->updateField($message->getId(), 'status', 'D');
		    if ($statusUpdate instanceof Error) {
			$this->response(array('status' => 'ERROR_DEL_MSG'), 503);
		    }
		}
		$this->createActivity($currentUser, null, 'A', null, 'CONVERSATIONDELETED', true);
		$this->response(array($controllers['CONVERSATION_DEL']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	getFeaturingJSON() 
     * \brief   funzione per il recupero dei featuring per l'event
     * \todo check possibilità utilizzo di questa funzione come pubblica e condivisa tra più controller
     */
    public function getFeaturingJSON() {

	try {
	    global $controllers;
	    error_reporting(E_ALL ^ E_NOTICE);
	    $force = false;
	    $filter = null;

	    if (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 400);
	    }
	    if (isset($this->request['force']) && !is_null($this->request['force']) && $this->request['force'] == "true") {
		$force = true;
	    }
	    if (isset($this->request['term']) && !is_null($this->request['term']) && (strlen($this->request['term']) > 0)) {
		$filter = $this->request['term'];
	    }
	    $currentUserFeaturingArray = null;
	    if ($force == false && isset($_SESSION['currentUserFeaturingArray']) && !is_null($_SESSION['currentUserFeaturingArray'])) {//caching dell'array
		$currentUserFeaturingArray = $_SESSION['currentUserFeaturingArray'];
	    } else {
		require_once CONTROLLERS_DIR . 'utilsController.php';
		$currentUserFeaturingArray = getFeaturingArray();
		$_SESSION['currentUserFeaturingArray'] = $currentUserFeaturingArray;
	    }

	    if (!is_null($filter)) {
		require_once CONTROLLERS_DIR . 'utilsController.php';
		echo json_encode(filterFeaturingByValue($currentUserFeaturingArray, $filter));
	    } else {
		echo json_encode($currentUserFeaturingArray);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	createActivity($fromuser,$touser,$message)
     * \brief   private function to create activity class instance
     * \param   $fromuser,$touser
     */
    private function createActivity($fromuser, $touser, $status, $message, $type, $read = false) {
	require_once CLASSES_DIR . 'activity.class.php';
	$activity = new Activity();
	$activity->setActive(true);
	$activity->setAlbum(null);
	$activity->setComment($message);
	$activity->setCounter(0);
	$activity->setEvent(null);
	$activity->setFromuser($fromuser);
	$activity->setImage(null);
	$activity->setPlaylist(null);
	$activity->setQuestion(null);
	$activity->setRead($read);
	$activity->setRecord(null);
	$activity->setSong(null);
	$activity->setStatus($status);
	$activity->setToUser($touser);
	$activity->setType($type);
	$activity->setVideo(null);
	return $activity;
    }

}

?>