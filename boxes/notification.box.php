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
 * \todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

class NotificationForMessageList {

    public $createdAt;
    public $fromUserInfo;

    function __construct($createdAt, $fromUserInfo) {
	is_null($createdAt) ? $this->createdAt = NODATA : $this->createdAt = $createdAt;
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
    }

}

class NotificationBox {

    public $notificationArray;
    public $invitationCounter;
    public $messageArray;
    public $messageCounter;

    public function initForMessageList($objectId) {
	$notificationBox = new NotificationBox();

	$notificationBox->invitationCounter = NDB;
	$notificationBox->messageCounter = NDB;
	$notificationBox->relationCounter = NDB;

	$messageArray = array();

	$activity = new ActivityParse();
	$activity->wherePointer('toUser', 'User', $objectId);
	$activity->where('type', 'MESSAGESENT');
	$activity->where('read', false);
	$activity->where('active', true);
	$messages = $activity->getActivities();
	if (get_class($messages) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $messages->getErrorMessage() . '<br/>';
	} else {
	    foreach ($messages as $message) {
		$createdAt = $message->getCreatedAt();
		$userId = $message->getFromUser();
		$userP = new UserParse();
		$user = $userP->getUser($userId);

		$thumbnail = $user->getProfileThumbnail();
		$type = $user->getType();
		$username = $user->getUsername();
		$userInfo = new UserInfo($thumbnail, $type, $username);
		
		$notificationInfo = new NotificationForMessageList($createdAt, $userInfo);
		array_push($messageArray, $notificationInfo);
	    }
	    $notificationBox->messageArray = $messageArray;
	}
	return $notificationBox;
    }

    /**
     * \fn	init($objectId,$type)
     * \brief	Init NotificationBox instance
     * \param	$objectId
     * \param	$type
     * \return	infoBox
     */
    public function init($objectId, $type) {

	$notificationBox = new NotificationBox();

	$activity0 = new ActivityParse();
	$activity0->wherePointer('toUser', 'User', $objectId);
	$activity0->where('type', 'INVITED');
	$activity0->where('read', false);
	$activity0->where('active', true);
	$invitationCounter = $activity0->getCount();
	if (get_class($invitationCounter) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $invitationCounter->getErrorMessage() . '<br/>';
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
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $messageCounter->getErrorMessage() . '<br/>';
	} else {
	    $notificationBox->messageCounter = $messageCounter;
	}
	switch ($type) {
	    case 'SPOTTER':
		$activity2 = new ActivityParse();
		$activity2->wherePointer('toUser', '_User', $objectId);
		$activity2->where('type', 'FRIENDREQUEST');
		$activity2->where('status', 'W');
		$activity2->where('read', false);
		$activity2->where('active', true);
		$relationCounter = $activity2->getCount();
		if (get_class($relationCounter) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $relationCounter->getErrorMessage() . '<br/>';
		} else {
		    $notificationBox->relationCounter = $relationCounter;
		}
		break;
	    default:
		$activityTypes = array(array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
		$activity2 = new ActivityParse();
		$activity2->wherePointer('toUser', '_User', $objectId);
		$activity2->whereOr($activityTypes);
		$activity2->where('status', 'W');
		$activity2->where('read', false);
		$activity2->where('active', true);
		$relationCounter = $activity2->getCount();
		if (get_class($relationCounter) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $relationCounter->getErrorMessage() . '<br/>';
		} else {
		    $notificationBox->relationCounter = $relationCounter;
		}
		break;
	}
	$notificationBox->notificationArray = NDB;
	return $notificationBox;
    }

}

?>