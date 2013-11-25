<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

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
	global $boxes;
	is_null($read) ? $this->read = false : $this->read = $read;
	is_null($userInfo) ? $this->userInfo = $boxes['NODATA'] : $this->userInfo = $userInfo;
    }

}

/**
 * \brief	MessageInfo class 
 * \details	contains info for message to be displayed in Message Page
 */
class MessageInfo {

    public $createdAt;
    public $objectId;
    public $send;
    public $text;

    /**
     * \fn	__construct($createdAt, $objectId, $send, $text)
     * \brief	construct for the MessageInfo class
     * \param	$createdAt, $objectId, $send, $text, $title
     */
    function __construct($createdAt, $objectId, $send, $text) {
	global $boxes;
	is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($send) ? $this->send = 'S' : $this->send = $send;
	is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = $text;
    }

}

/**
 * \brief	MessageBox class 
 * \details	box class to pass info to the view for messagePage 
 */
class MessageBox {

    public $config;
    public $messageArray;
    public $userInfoArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/message.config.json"), false);
    }

    /**
     * \fn	initForUserList($objectId, $otherId, $limit, $skip)
     * \brief	Init MessageBox instance for Message Page, left column
     * \param	$objectId for user that owns the page $limit, $skip
     * \todo    
     * \return	MessageBox, error in case of error
     */
    public function initForUserList($objectId, $limit, $skip) {
	require_once CLASSES_DIR . 'activity.class.php';
	require_once CLASSES_DIR . 'activityParse.class.php';
	global $boxes;
	$messageBox = new MessageBox();
	$messageBox->messageArray = $boxes['NDB'];
	$currentUserId = sessionChecker();
	if ($currentUserId == $boxes['NOID']) {
	    $messageBox->userInfoArray = $boxes['ONLYIFLOGGEDIN'];
	    return $messageBox;
	}
	$userList = array();
	$messageBox->messageArray = $boxes['NDB'];
	$value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)),
	    array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)));
	$activityP = new ActivityParse();
	$activityP->whereOr($value);
	$activityP->where('type', 'MESSAGESENT');
	$activityP->where('active', true);
	$activityP->whereInclude('fromUser,toUser');
	$activityP->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->limitUsersForMessagePage : $limit);
	$activityP->setSkip((is_null($skip) && is_int($skip)) ? 0 : $skip);
	$activityP->orderByDescending('createdAt');
	$activities = $activityP->getActivities();
	if ($activities instanceof Error) {
	    return $activities;
	} elseif (is_null($activities)) {
	    $messageBox->userInfoArray = $boxes['NODATA'];
	    return $messageBox;
	} else {
		/*
	    $userIdArray = array();
	    foreach ($activities as $act) {
		$user = ($act->getFromUser()->getObjectId() == $objectId) ? $act->getToUser() : $act->getFromUser();
		$objectId = $user->getObjectId();
		if (!in_array($objectId, $userIdArray)) {
		    array_push($userIdArray, $objectId);
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		    $read = $act->getRead();
		    $elementList = new ElementList($read, $userInfo);
		    array_push($userList, $elementList);
		}
	    }
		*/
		foreach ($activities as $act) {
			$user = ($act->getFromUser()->getObjectId() == $objectId) ? $act->getToUser() : $act->getFromUser();
			$objectId = $user->getObjectId();
			$thumbnail = $user->getProfileThumbnail();
			$type = $user->getType();
			$username = $user->getUsername();
			$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			$read = $act->getRead();
			$elementList = new ElementList($read, $userInfo);
			if (array_key_exists($object, $userList)) {
				if (!$read) {
					$userList[$objectId] = $elementList
				}
			} else {
				$userList[$objectId] = $elementList
			}
	    }
	}
	$messageBox->userInfoArray = $userList;
	return $messageBox;
    }

    /**
     * \fn	initForMessageList($objectId, $otherId, $limit, $skip)
     * \brief	Init MessageBox instance for Message Page, right column
     * \param	$objectId for user that owns the page, $otherId the id if the user who the currentUser is messaging with, $limit, $skip
     * \todo    
     * \return	MessageBox, error in case of error
     */
    public function initForMessageList($objectId, $otherId, $limit, $skip) {
	global $boxes;
	require_once CLASSES_DIR . 'comment.class.php';
	require_once CLASSES_DIR . 'commentParse.class.php';
	$value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)),
	    array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)));
	$value1 = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $otherId)),
	    array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $otherId)));
	$messageBox = new MessageBox();
	$messageBox->userInfoArray = $boxes['NDB'];
	$currentUserId = sessionChecker();
	if ($currentUserId == $boxes['NOID']) {
	    $messageBox->messageArray = $boxes['ONLYIFLOGGEDIN'];
	    return $messageBox;
	}
	$messageP = new CommentParse();
	$messageP->whereOr($value);
	$messageP->whereOr($value1);
	$messageP->where('type', 'M');
	$messageP->where('active', true);
	$messageP->whereInclude('fromUser');
	$messageP->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->limitMessagesForMessagePage : $limit);
	$messageP->setSkip((is_null($skip) && is_int($skip)) ? 0 : $skip);
	$messageP->orderByDescending('createdAt');
	$messages = $messageP->getComments();
	if ($messages instanceof Error) {
	    return $messages;
	} elseif (is_null($messages)) {
	    $messageBox->messageArray = $boxes['NODATA'];
	    return $messageBox;
	} else {
	    $messagesArray = array();
	    foreach ($messages as $message) {
		$send = ($message->getFromUser()->getObjectId() == $objectId) ? 'S' : 'R';
		$createdAt = $message->getCreatedAt();
		$objectId = $message->getObjectId();
		$text = $message->getText();
		$messageInfo = new MessageInfo($createdAt, $objectId, $send, $text);
		array_push($messagesArray, $messageInfo);
	    }
	    $messageBox->messageArray = $messagesArray;
	}
	return $messageBox;
    }

}

?>