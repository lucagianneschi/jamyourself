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
require_once SERVICES_DIR . 'select.service.php';

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

    public $error = null;
    public $messageArray = array();

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
	    $this->error = ONLYIFLOGGEDIN;
	    return;
	}
	require_once CLASSES_DIR . 'comment.class.php';
	$messages = selectMessages($currentUserId, $otherId, null, $where, array('createad' => 'DESC'), $limit, $skip);
	if ($messages instanceof Error) {
	    $this->error = $messages->getErrorMessage();
	}
	$this->messageArray = $messages;
    }

//	$compoundQuery = array(
//	    array('id' => array('$select' => array('query' => array('where' => array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $currentUserId), 'toUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $otherId)), 'className' => 'Comment'), 'key' => 'id'))),
//	    array('id' => array('$select' => array('query' => array('where' => array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $otherId), 'toUser' => array('__type' => 'Pointer', 'className' => '_User', 'id' => $currentUserId)), 'className' => 'Comment'), 'key' => 'id'))));
//	$messageP = new CommentParse();
//	$messageP->whereOr($compoundQuery);
//	$messageP->where('type', 'M');
//	$messageP->where('active', true);
//	$messageP->whereInclude('fromUser,toUser');
//	$messageP->orderByDescending('createdat');
//	$messageP->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitMessagesForMessagePage);
//	$messageP->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
//	$messages = $messageP->getComments();
//	if ($messages instanceof Error) {
//	    $this->errorManagement($messages->getErrorMessage());
//	    return;
//	} elseif (is_null($messages)) {
//	    $this->errorManagement();
//	    return;
//	} else {
//	    $messagesArray = array();
//	    require_once CLASSES_DIR . 'activityParse.class.php';
//	    foreach ($messages as $message) {
//		if (!is_null($message->getFromuser())) {
//		    $activity = new ActivityParse();
//		    $activity->wherePointer('comment', 'Comment', $message->getId());
//		    $activity->whereNotEqualTo('status', 'D');
//		    $activity->where('active', true);
//		    $activity->whereInclude('id,fromUser');
//		    $msg = $activity->getActivities();
//		    if ($msg instanceof Error) {
//			$this->errorManagement($msg->getErrorMessage());
//			return;
//		    } elseif (!is_null($msg)) {
//			foreach ($msg as $value) {
//			    $send = ($message->getFromuser()->getId() == $currentUserId) ? 'S' : 'R';
//			    if (($send == 'S' && $message->getFromuser()->getId() == $value->getFromuser()->getId()) || ($send == 'R' && $message->getTouser()->getId() == $value->getFromuser()->getId())) {
//				$activityId = $value->getId();
//				$createdat = $message->getCreatedat();
//				$messageId = $message->getId();
//				$read = $value->getRead();
//				$text = $message->getText();
//				$messageInfo = new MessageInfo($activityId, $createdat, $messageId, $read, $send, $text);
//				array_push($messagesArray, $messageInfo);
//			    }
//			}
//		    }
//		}
//	    }
//	}
//
//	$this->error = null;
//	$this->messageArray = $messagesArray;
//	$this->userInfoArray = array();
//    }
}

?>