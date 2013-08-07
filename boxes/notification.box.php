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

class NotificationInfo{
    public $eventTitle;
	public $sender;
	public $createdAt;
	}

	
class NotificationBox {

    public $invitationCounter;
    public $messageCounter;
	public $relationCounter;

    /**
     * \fn	init($objectId,$type)
     * \brief	Init NotificationBox instance
	 * \param	$objectId
	 * \param	$type
     * \return	infoBox
     */
    public function init($objectId,$type) {
	
    $notificationBox = new NotificationBox();
	$invitations = array();
	$messages = array();
	$relations = array();
	
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
			if (get_class($invitations) == 'Error') {
				echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $relationCounter->getErrorMessage() . '<br/>';
			} else {
				$notificationBox->relationCounter = $relationCounter;
			}
			break;
		default:
			$activityTypes = array(array('type' => 'COLLABORATIONREQUEST'),array('type' => 'FOLLOWING'));
			$activity2 = new ActivityParse();
			$activity2->wherePointer('toUser', '_User', $objectId);
			$activity2->whereOr($activityTypes);
			$activity2->where('status', 'W');
			$activity2->where('read', false);
			$activity2->where('active', true);
			$relations = $activity2->getCount();
			if (get_class($invitations) == 'Error') {
				echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $relations->getErrorMessage() . '<br/>';
			} else {
				$notificationBox->relationCounter = $relations;
			}
			break;
		}
	}
}

?>