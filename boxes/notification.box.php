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

    function __construct($createdAt, $fromUserInfo) {
	global $boxes;
	is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
	is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
    }

}

/**
 * \brief	NotificationBox class 
 * \details	box class to pass info to the view for the notification
 */
class NotificationBox {

    public $invitationCounter;
    public $messageArray;
    public $messageCounter;
    public $notificationArray;

    /**
     * \fn	init($objectId,$type)
     * \brief	Init NotificationBox instance
     * \param	$objectId
     * \param	$type
     * \return	infoBox
     */
    public function init($objectId, $type) {
	global $boxes;
	$notificationBox = new NotificationBox();
	$activity0 = new ActivityParse();
	$activity0->wherePointer('toUser', 'User', $objectId);
	$activity0->where('type', 'INVITED');
	$activity0->where('read', false);
	$activity0->where('active', true);
	$invitationCounter = $activity0->getCount();
	if (get_class($invitationCounter) == 'Error') {
	    return $invitationCounter;
	} else {
	    $notificationBox->invitationCounter = $invitationCounter;
	}
	$activity1 = new ActivityParse();
	$activity1->wherePointer('toUser', 'User', $objectId);
	$activity1->where('type', 'MESSAGESENT');
	$activity1->where('read', false);
	$activity1->where('active', true);
	$messageCounter = $activity1->getCount();
	if (get_class($messageCounter) == 'Error') {
	    return $messageCounter;
	} else {
	    $notificationBox->messageCounter = $messageCounter;
	}
	switch ($type) {
	    case 'SPOTTER':
		$activity2 = new ActivityParse();
		$activity2->wherePointer('toUser', '_User', $objectId);
		$activity2->where('type', 'FRIENDSHIPREQUEST');
		$activity2->where('status', 'P'); //virificare se P o W
		$activity2->where('read', false);
		$activity2->where('active', true);
		$relationCounter = $activity2->getCount();
		if (get_class($relationCounter) == 'Error') {
		    return $relationCounter;
		} else {
		    $notificationBox->relationCounter = $relationCounter;
		}
		break;
	    default:
		$activityTypes = array(array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
		$activity2 = new ActivityParse();
		$activity2->wherePointer('toUser', '_User', $objectId);
		$activity2->whereOr($activityTypes);
		$activity2->where('status', 'P');
		$activity2->where('read', false);
		$activity2->where('active', true);
		$relationCounter = $activity2->getCount();
		if (get_class($relationCounter) == 'Error') {
		    return $relationCounter;
		} else {
		    $notificationBox->relationCounter = $relationCounter;
		}
		break;
	}
	$notificationBox->notificationArray = $boxes['NDB'];
	$notificationBox->messageArray = $boxes['NDB'];
	return $notificationBox;
    }

    /**
     * \fn	initForMessageList($objectId,$type)
     * \brief	Init NotificationBox instance for message list
     * \param	$objectId
     * \return	infoBox
     */
    public function initForMessageList($objectId) {
	global $boxes;
	$notificationBox = new NotificationBox();
	$notificationBox->invitationCounter = $boxes['NDB'];
	$notificationBox->messageCounter = $boxes['NDB'];
	$notificationBox->relationCounter = $boxes['NDB'];
	$notificationBox->notificationArray = $boxes['NDB'];
	$messageArray = array();
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', 'User', $objectId);
	$activity->where('type', 'MESSAGESENT');
	$activity->where('read', false);
	$activity->where('active', true);
	$activity->whereInclude('fromUser');
	$messages = $activity->getActivities();
	if (get_class($messages) == 'Error') {
	    return $messages;
	} else {
	    if (count($messages) == 0) {
		$notificationBox->messageArray = $boxes['NODATA'];
	    }
	    foreach ($messages as $message) {
		$createdAt = $message->getCreatedAt();
		$objectId = $message->getFromUser()->getObjectId();
		$thumbnail = $message->getFromUser()->getProfileThumbnail();
		$type = $message->getFromUser()->getType();
		$encodedUsername = $message->getFromUser()->getUsername();
		$username = parse_decode_string($encodedUsername);
		$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		$notificationInfo = new NotificationForDetailedList($createdAt, $userInfo);
		array_push($messageArray, $notificationInfo);
	    }

	    $notificationBox->messageArray = $messageArray;
	}
	return $notificationBox;
    }

    /**
     * \fn	initForEventList($objectId,$type)
     * \brief	Init NotificationBox instance for event list
     * \param	$objectId
     * \return	infoBox
     */
    public function initForEventList($objectId) {
	global $boxes;
	$notificationBox = new NotificationBox();
	$notificationBox->invitationCounter = $boxes['NDB'];
	$notificationBox->messageCounter = $boxes['NDB'];
	$notificationBox->messageArray = $boxes['NDB'];
	$notificationBox->relationCounter = $boxes['NDB'];
	$invitationArray = array();
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', 'User', $objectId);
	$activity->where('type', 'INVITED');
	$activity->where('active', true);
	$activity->whereInclude('fromUser');
	$invitations = $activity->getActivity();
	if (get_class($invitations) == 'Error') {
	    return $invitations;
	} else {
	    if (count($invitations) == 0) {
		$notificationBox->notificationArray = $boxes['NODATA'];
	    } else {
		foreach ($invitations as $invitation) {
		    $createdAt = $invitation->getCreatedAt();
		    $objectId = $invitation->getFromUser()->getObjectId();
		    $thumbnail = $invitation->getFromUser()->getProfileThumbnail();
		    $type = $invitation->getFromUser()->getType();
		    $encodedUsername = $invitation->getFromUser()->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		    $notificationInfo = new NotificationForDetailedList($createdAt, $userInfo);
		    array_push($invitationArray, $notificationInfo);
		}
	    }
	    $notificationBox->notificationArray = $invitationArray;
	}
	return $notificationBox;
    }

    /**
     * \fn	initForRelationList($objectId,$type)
     * \brief	Init NotificationBox instancef for relation list
     * \param	$objectId
     * \param	$type
     * \return	infoBox
     */
    public function initForRelationList($objectId, $type) {
	global $boxes;
	$notificationBox = new NotificationBox();
	$notificationBox->invitationCounter = $boxes['NDB'];
	$notificationBox->messageCounter = $boxes['NDB'];
	$notificationBox->messageArray = $boxes['NDB'];
	$notificationBox->relationCounter = $boxes['NDB'];
	$relationArray = array();
	$activity = new ActivityParse();
	$activity->wherePointer('toUser', '_User', $objectId);
	switch ($type) {
	    case 'SPOTTER':
		$activity->where('type', 'FRIENDSHIPREQUEST');
		break;
	    default:
		$activityTypes = array(array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
		$activity->whereOr($activityTypes);
		break;
	}
	$activity->where('status', 'W');
	$activity->where('active', true);
	$activity->whereInclude('fromUser');
	$relations = $activity->getActivities();
	if (get_class($relations) == 'Error') {
	    return $relations;
	} else {
	    if (count($relations) == 0) {
		$notificationBox->notificationArray = $boxes['NODATA'];
	    } else {
		foreach ($relations as $relation) {
		    $createdAt = $relation->getCreatedAt();
		    $objectId = $relation->getFromUser()->getObjectId();
		    $thumbnail = $relation->getFromUser()->getProfileThumbnail();
		    $type = $relation->getFromUser()->getType();
		    $encodedUsername = $relation->getFromUser()->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		    $notificationInfo = new NotificationForDetailedList($createdAt, $userInfo);
		    array_push($relationArray, $notificationInfo);
		}
		$notificationBox->notificationArray = $relationArray;
	    }
	}
	return $notificationBox;
    }

}

?>