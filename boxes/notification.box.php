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
	is_null($createdAt) ? $this->createdAt = NODATA : $this->createdAt = $createdAt;
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
    }

}
/**
 * \brief	NotificationBox class 
 * \details	box class to pass info to the view for the notification
 */
 
class NotificationBox {

    public $notificationArray;
    public $invitationCounter;
    public $messageArray;
    public $messageCounter;



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

   /**
     * \fn	initForMessageList($objectId,$type)
     * \brief	Init NotificationBox instance for message list
     * \param	$objectId
     * \return	infoBox
     */
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
			
			$objectId = $user->getObjectId();
			$thumbnail = $user->getProfileThumbnail();
			$type = $user->getType();
			$username = $user->getUsername();
			$userInfo = new UserInfo($objectId,$thumbnail, $type, $username);
			
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
	
	public function initForEventList($objectId){
		$notificationBox = new NotificationBox();
		
		$notificationBox->invitationCounter = NDB;
		$notificationBox->messageCounter = NDB;
		$notificationBox->relationCounter = NDB;
		
		$invitationArray = array();
	
	    $activity = new ActivityParse();
	    $activity->wherePointer('toUser', 'User', $objectId);
	    $activity->where('type', 'INVITED');
	    $activity->where('active', true);
	    $invitations = $activity->getActivity();	
	    if (get_class($invitation) == 'Error') {
	        echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $invitations->getErrorMessage() . '<br/>';
	    } else {
	        foreach($invitations as $invitation){
				$createdAt = $invitation->getCreatedAt();
				$userId = $invitation->getFromUser();
				$userP = new UserParse();
				$user = $userP->getUser($userId);
				
				$objectId = $user->getObjectId();
				$thumbnail = $user->getProfileThumbnail();
				$type = $user->getType();
				$username = $user->getUsername();
				$userInfo = new UserInfo($objectId,$thumbnail, $type, $username);
				$notificationInfo = new NotificationForDetailedList($createdAt, $userInfo);
				array_push($invitationArray, $notificationInfo);
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
	
	 public function initForRelationList($objectId,$type) {
	  $notificationBox = new NotificationBox();
	  
	  $notificationBox->invitationCounter = NDB;
	  $notificationBox->messageCounter = NDB;
	  $notificationBox->relationCounter = NDB;
	  
	  $relationArray = array();
	  
	  $activity = new ActivityParse();
	  $activity->wherePointer('toUser', '_User', $objectId);
	  switch ($type) {
		case 'SPOTTER':
			$activity->where('type', 'FRIENDREQUEST');
		break;
		default:
			$activityTypes = array(array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
			$activity->whereOr($activityTypes);
		break;
		}
	  $activity->where('status', 'W');
	  $activity->where('active', true);
	  $relations = $activity->getActivities();
		if (get_class($relations) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $relations->getErrorMessage() . '<br/>';
		} else {
		    foreach($relations as $relation){
				$createdAt = $relation->getCreatedAt();
				$userId = $relation->getFromUser();
				$userP = new UserParse();
				$user = $userP->getUser($userId);
				
				
				$objectId = $user->getObjectId();
				$thumbnail = $user->getProfileThumbnail();
				$type = $user->getType();
				$username = $user->getUsername();
				$userInfo = new UserInfo($objectId,$thumbnail, $type, $username);
				$notificationInfo = new NotificationForDetailedList($createdAt, $userInfo);
				array_push($relationArray, $notificationInfo);
			}
			$notificationBox->notificationArray = $relationArray;
		}
		return $notificationBox;
	  }	
}

?>