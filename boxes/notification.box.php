<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento notifiche utente
 * \details		Recupera le notifiche da mostrare nell'header
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		uso whereIncude		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

/**
 * \brief	NotificationForDetailedList 
 * \details	contains info for detailed list to be displayed in the header 
 */
class NotificationForDetailedList {

    public $createdAt;
    public $fromUserInfo;
    public $objectId;
    public $text;
    public $type;

    /**
     * \fn	__construct($createdAt, $fromUserInfo, $text)
     * \brief	construct for NotificationForDetailedList
     * \param	$createdAt, $fromUserInfo, $text
     * \return	infoBox
     */
    function __construct($createdAt, $fromUserInfo, $objectId, $text, $type) {
	global $boxes;
	is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
	is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	is_null($objectId) ? $this->objectId = $boxes['NDB'] : $this->objectId = $objectId;
	is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = $text;
	is_null($type) ? $this->type = 'D' : $this->type = $type;
    }

}

/**
 * \brief	NotificationBox class 
 * \details	box class to pass info to the view for the notification
 */
class NotificationBox {

    public $config;
    public $invitationCounter;
    public $messageCounter;
    public $notificationArray;
    public $relationCounter;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/notification.config.json"), false);
    }

    /**
     * \fn	init($objectId,$type)
     * \brief	Init NotificationBox instance
     * \param	$objectId
     * \param	$type
     * \return	infoBox
     */
    public function initForCounter($objectId, $type) {
	global $boxes;
	$currentUserId = sessionChecker();
	$notificationBox = new NotificationBox();
	$notificationBox->notificationArray = $boxes['NDB'];
	if ($currentUserId == $boxes['NOID'] || $currentUserId != $objectId) {
	    $notificationBox->invitationCounter = $boxes['ONLYIFLOGGEDIN'];
	    $notificationBox->messageCounter = $boxes['ONLYIFLOGGEDIN'];
	    $notificationBox->relationCounter = $boxes['ONLYIFLOGGEDIN'];
	    return $notificationBox;
	}
	$activity0 = new ActivityParse();
	$activity0->wherePointer('toUser', '_User', $objectId);
	$activity0->where('type', 'INVITED');
	$activity0->where('read', false);
	$activity0->where('status', 'P');
	$activity0->where('active', true);
	$notificationBox->invitationCounter = $activity0->getCount();
	$activity1 = new ActivityParse();
	$activity1->wherePointer('toUser', '_User', $objectId);
	$activity1->where('type', 'MESSAGESENT');
	$activity1->where('status', 'P');
	$activity1->where('read', false);
	$activity1->where('active', true);
	$notificationBox->messageCounter = $activity1->getCount();
	if ($type == 'SPOTTER') {
	    $activity2 = new ActivityParse();
	    $activity2->wherePointer('toUser', '_User', $objectId);
	    $activity2->where('type', 'FRIENDSHIPREQUEST');
	    $activity2->where('status', 'P');
	    $activity2->where('read', false);
	    $activity2->where('active', true);
	    $notificationBox->relationCounter = $activity2->getCount();
	} else {
	    $activity2 = new ActivityParse();
	    $activity2->wherePointer('toUser', '_User', $objectId);
	    $activity2->where('type', 'COLLABORATIONREQUEST');
	    $activity2->where('status', 'P');
	    $activity2->where('read', false);
	    $activity2->where('active', true);
	    $collaborationNumber = $activity2->getCount();
	    $activity3 = new ActivityParse();
	    $activity3->wherePointer('toUser', '_User', $objectId);
	    $activity3->where('type', 'FOLLOWING');
	    $activity3->where('read', false);
	    $activity3->where('active', true);
	    $newFollowing = $activity3->getCount();
	    $notificationBox->relationCounter = $newFollowing + $collaborationNumber;
	}
	return $notificationBox;
    }

    /**
     * \fn	initForMessageList($objectId,$type)
     * \brief	Init NotificationBox instance for message list
     * \param	$objectId
     * \return	infoBox
     */
    public function initForDetailedList($objectId, $type) {
	global $boxes;
	$relatedId = null;
	$currentUserId = sessionChecker();
	$notificationBox = new NotificationBox();
	$notificationBox->invitationCounter = $boxes['NDB'];
	$notificationBox->messageCounter = $boxes['NDB'];
	$notificationBox->relationCounter = $boxes['NDB'];
	if ($currentUserId == $boxes['NOID'] || $currentUserId != $objectId) {
	    $notificationBox->messageArray = $boxes['ONLYIFLOGGEDIN'];
	    return $notificationBox;
	}
	$arrayTypes = ($type == 'SPOTTER') ? array(array('type' => 'MESSAGESENT'), array('type' => 'INVITED'), array('type' => 'FRIENDSHIPREQUEST')) : array(array('type' => 'MESSAGESENT'), array('type' => 'INVITED'), array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
	$notificationArray = array();
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $objectId);
	$activity->whereOr($arrayTypes);
	$activity->setLimit($notificationBox->config->limitForDetail);
	$activity->where('read', false);
	$activity->where('active', true);
	$activity->where('status', 'P');
	$activity->whereInclude('fromUser,comment,event');
	$messages = $activity->getActivities();
	if ($messages instanceof Error) {
	    return $messages;
	} elseif (is_null($messages)) {
	    $notificationBox->notificationArray = $boxes['NODATA'];
	    return $notificationBox;
	} else {
	    foreach ($messages as $message) {
		switch ($message->getType()) {
		    case 'MESSAGESENT':
			$text = $boxes['MESSAGEFORLIST'];
			$elementType = 'M';
			break;
		    case 'INVITED':
			$text = $boxes['EVENTFORLIST'];
			$relatedId = $message->getEvent()->getObjectId();
			$elementType = 'E';
			break;
		    case 'FRIENDSHIPREQUEST':
			$text = $boxes['FRIENDSHIPFORLIST'];
			$elementType = 'R';
			break;
		    case 'COLLABORATIONREQUEST':
			$text = $boxes['COLLABORATIONFORLIST'];
			$elementType = 'R';
			break;
		    case 'FOLLOWING':
			$text = $boxes['FOLLOWINGFORLIST'];
			$elementType = 'R';
			break;
		}
		$createdAt = $message->getCreatedAt();
		$fromUserId = $message->getFromUser()->getObjectId();
		$thumbnail = $message->getFromUser()->getProfileThumbnail();
		$type = $message->getFromUser()->getType();
		$username = $message->getFromUser()->getUsername();
		$fromUserInfo = new UserInfo($fromUserId, $thumbnail, $type, $username);
		$notificationInfo = new NotificationForDetailedList($createdAt, $fromUserInfo, $relatedId, $text, $elementType);
		array_push($notificationArray, $notificationInfo);
	    }
	}
	$notificationBox->notificationArray = $notificationArray;
	return $notificationBox;
    }

}

?>