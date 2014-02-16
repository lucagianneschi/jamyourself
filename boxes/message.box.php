<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento messaggi
 * \details		Recupera le informazioni dei messaggi per la pagina messaggi
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once SERVICES_DIR . 'connection.service.php';

/**
 * \brief	ElementList
 * \details	contains info for message to be displayed in Message Page
 */
class ElementList {

    public $userInfo;
    public $read;

    /**
     * \fn	__construct($read,$userInfo)
     * \brief	construct for the ElementList
     * \param	$read,$userInfo
     */
    function __construct($read, $userInfo) {
	is_null($read) ? $this->read = false : $this->read = $read;
	is_null($userInfo) ? $this->userInfo = null : $this->userInfo = $userInfo;
    }

}

/**
 * \brief	MessageInfo class 
 * \details	contains info for message to be displayed in Message Page
 */
class MessageInfo {

    public $activityId;
    public $createdat;
    public $id;
    public $read;
    public $send;
    public $text;

    /**
     * \fn	__construct($createdat, $id, $send, $text)
     * \brief	construct for the MessageInfo class
     * \param	$createdat, $id, $send, $text, $title
     */
    function __construct($activityId, $createdat, $id, $read, $send, $text) {
	is_null($activityId) ? $this->activityId = null : $this->activityId = $activityId;
	is_null($createdat) ? $this->createdat = null : $this->createdat = $createdat;
	is_null($id) ? $this->id = null : $this->id = $id;
	is_null($read) ? $this->read = false : $this->read = $read;
	is_null($send) ? $this->send = 'S' : $this->send = $send;
	is_null($text) ? $this->text = null : $this->text = $text;
    }

}

/**
 * \brief	MessageBox class 
 * \details	box class to pass info to the view for messagePage 
 */
class MessageBox {

    public $config;
    public $error;
    public $messageArray;
    public $userInfoArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "messageBox.config.json"), false);
    }

    /**
     * \fn	initForUserList($id, $otherId, $limit, $skip)
     * \brief	Init MessageBox instance for Message Page, left column
     * \param	$id for user that owns the page $limit, $skip
     * \todo    
     * \return	MessageBox, error in case of error
     */
    public function initForUserList() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	require_once CLASSES_DIR . 'activity.class.php';
	require_once CLASSES_DIR . 'activityParse.class.php';
	$userList = array();
	$value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $currentUserId)),
	    array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $currentUserId)));
	$activityP = new ActivityParse();
	$activityP->whereOr($value);
	$activityP->where('type', 'MESSAGESENT');
	$activityP->where('active', true);
	$activityP->whereNotEqualTo('status', 'D');
	$activityP->whereInclude('fromUser,toUser,comment');
	$activityP->setLimit(MAX);
	$activityP->orderByDescending('createdat');
	$activities = $activityP->getActivities();
	if ($activities instanceof Error) {
	    $this->errorManagement($activities->getErrorMessage());
	    return;
	} elseif (is_null($activities)) {
	    $this->errorManagement();
	    return;
	} else {
	    foreach ($activities as $act) {
		if (!is_null($act->getFromuser()) && !is_null($act->getTouser()) && !is_null($act->getComment())) {
		    $send = ($act->getComment()->getFromuser() == $currentUserId) ? 'S' : 'R';
		    if (($send == 'S' && $act->getComment()->getFromuser() == $act->getFromuser()->getId()) || ($send == 'R' && $act->getComment()->getTouser() == $act->getFromuser()->getId())) {
			$user = ($act->getFromuser()->getId() == $currentUserId) ? $act->getTouser() : $act->getFromuser();
			$userId = $user->getId();
			$thumbnail = $user->getThumbnail();
			$type = $user->getType();
			$username = $user->getUsername();
			$userInfo = new UserInfo($userId, $thumbnail, $type, $username);
			$read = $act->getRead();
			$elementList = new ElementList($read, $userInfo);
			if ($read == false) {
			    $userList[$userId] = $elementList;
			} elseif (array_key_exists($userId, $userList) == false) {
			    $userList[$userId] = $elementList;
			}
		    }
		}
	    }
	}
	$this->error = null;
	$this->messageArray = array();
	$this->userInfoArray = $userList;
    }

    /**
     * \fn	initForMessageList($id, $otherId, $limit, $skip)
     * \brief	Init MessageBox instance for Message Page, right column
     * \param	$id for user that owns the page, $otherId the id if the user who the currentUser is messaging with, $limit, $skip
     * \todo    
     * \return	MessageBox, error in case of error
     */
    public function initForMessageList($otherId, $limit = null, $skip = null) {

	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	require_once CLASSES_DIR . 'comment.class.php';
	require_once CLASSES_DIR . 'commentParse.class.php';
	$compoundQuery = array(
	    array('id' => array('$select' => array('query' => array('where' => array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $currentUserId), 'toUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $otherId)), 'className' => 'Comment'), 'key' => 'id'))),
	    array('id' => array('$select' => array('query' => array('where' => array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $otherId), 'toUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $currentUserId)), 'className' => 'Comment'), 'key' => 'id'))));
	$messageP = new CommentParse();
	$messageP->whereOr($compoundQuery);
	$messageP->where('type', 'M');
	$messageP->where('active', true);
	$messageP->whereInclude('fromUser,toUser');
	$messageP->orderByDescending('createdat');
	$messageP->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitMessagesForMessagePage);
	$messageP->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
	$messages = $messageP->getComments();
	if ($messages instanceof Error) {
	    $this->errorManagement($messages->getErrorMessage());
	    return;
	} elseif (is_null($messages)) {
	    $this->errorManagement();
	    return;
	} else {
	    $messagesArray = array();
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    foreach ($messages as $message) {
		if (!is_null($message->getFromuser())) {
		    $activity = new ActivityParse();
		    $activity->wherePointer('comment', 'Comment', $message->getId());
		    $activity->whereNotEqualTo('status', 'D');
		    $activity->where('active', true);
		    $activity->whereInclude('id,fromUser');
		    $msg = $activity->getActivities();
		    if ($msg instanceof Error) {
			$this->errorManagement($msg->getErrorMessage());
			return;
		    } elseif (!is_null($msg)) {
			foreach ($msg as $value) {
			    $send = ($message->getFromuser()->getId() == $currentUserId) ? 'S' : 'R';
			    if (($send == 'S' && $message->getFromuser()->getId() == $value->getFromuser()->getId()) || ($send == 'R' && $message->getTouser()->getId() == $value->getFromuser()->getId())) {
				$activityId = $value->getId();
				$createdat = $message->getCreatedat();
				$messageId = $message->getId();
				$read = $value->getRead();
				$text = $message->getText();
				$messageInfo = new MessageInfo($activityId, $createdat, $messageId, $read, $send, $text);
				array_push($messagesArray, $messageInfo);
			    }
			}
		    }
		}
	    }
	}

	$this->error = null;
	$this->messageArray = $messagesArray;
	$this->userInfoArray = array();
    }

    /**
     * \fn	function errorManagement($errorMessage)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessafe
     * \todo    
     */
    private function errorManagement($errorMessage = null) {
	$this->config = null;
	$this->error = $errorMessage;
	$this->messageArray = array();
	$this->userInfoArray = array();
    }

}

?>