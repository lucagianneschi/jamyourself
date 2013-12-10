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
     * \fn	__construct($createdAt, $fromUserInfo, $objectId, $text, $type)
     * \brief	construct for NotificationForDetailedList
     * \param	$createdAt, $fromUserInfo, $objectId, $text, $type
     * \return	infoBox
     */
    function __construct($createdAt, $fromUserInfo, $objectId, $text, $type) {
        is_null($createdAt) ? $this->createdAt = null : $this->createdAt = $createdAt;
        is_null($fromUserInfo) ? $this->fromUserInfo = null : $this->fromUserInfo = $fromUserInfo;
        is_null($objectId) ? $this->objectId = null : $this->objectId = $objectId;
        is_null($text) ? $this->text = null : $this->text = $text;
        is_null($type) ? $this->type = 'D' : $this->type = $type;
    }

}

/**
 * \brief	NotificationBox class 
 * \details	box class to pass info to the view for the notification
 */
class NotificationBox {

    public $config;
    public $error;
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
     * \todo    prendere il type dalla sessione
     */
    public function initForCounter($type) {
        $currentUserId = sessionChecker();
        $this->notificationArray = null;
        global $boxes;
        if ($currentUserId == $boxes['NOID']) {
            $this->errorManagement($boxes['ONLYIFLOGGEDIN']);
            return;
        }
        $activity0 = new ActivityParse();
        $activity0->wherePointer('toUser', '_User', $currentUserId);
        $activity0->where('type', 'INVITED');
        $activity0->where('read', false);
        $activity0->where('status', 'P');
        $activity0->where('active', true);
        $this->invitationCounter = $activity0->getCount();
        $activity1 = new ActivityParse();
        $activity1->wherePointer('toUser', '_User', $currentUserId);
        $activity1->where('type', 'MESSAGESENT');
        $activity1->where('status', 'P');
        $activity1->where('read', false);
        $activity1->where('active', true);
        $this->error = null;
        $this->messageCounter = $activity1->getCount();
        if ($type == 'SPOTTER') {
            $activity2 = new ActivityParse();
            $activity2->wherePointer('toUser', '_User', $currentUserId);
            $activity2->where('type', 'FRIENDSHIPREQUEST');
            $activity2->where('status', 'P');
            $activity2->where('read', false);
            $activity2->where('active', true);
            $this->error = null;
            $this->relationCounter = $activity2->getCount();
        } else {
            $activity2 = new ActivityParse();
            $activity2->wherePointer('toUser', '_User', $currentUserId);
            $activity2->where('type', 'COLLABORATIONREQUEST');
            $activity2->where('status', 'P');
            $activity2->where('read', false);
            $activity2->where('active', true);
            $collaborationNumber = $activity2->getCount();
            $activity3 = new ActivityParse();
            $activity3->wherePointer('toUser', '_User', $currentUserId);
            $activity3->where('type', 'FOLLOWING');
            $activity3->where('read', false);
            $activity3->where('active', true);
            $newFollowing = $activity3->getCount();
            $this->error = null;
            $this->relationCounter = $newFollowing + $collaborationNumber;
        }
    }

    /**
     * \fn	initForMessageList($type)
     * \brief	Init NotificationBox instance for message list
     * \param	$type
     * \prendere il type dalla sessione
     * \return	infoBox
     */
    public function initForDetailedList($type) {
        $currentUserId = sessionChecker();
        global $boxes;
        if ($currentUserId == $boxes['NOID']) {
            $this->errorManagement($boxes['ONLYIFLOGGEDIN']);
            return;
        }
        $relatedId = null;
        $this->invitationCounter = null;
        $this->messageCounter = null;
        $this->relationCounter = null;
        $arrayTypes = ($type == 'SPOTTER') ? array(array('type' => 'MESSAGESENT'), array('type' => 'INVITED'), array('type' => 'FRIENDSHIPREQUEST')) : array(array('type' => 'MESSAGESENT'), array('type' => 'INVITED'), array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
        $notificationArray = array();
        $activityP = new ActivityParse();
        $activityP->wherePointer('toUser', '_User', $currentUserId);
        $activityP->whereOr($arrayTypes);
        $activityP->setLimit($this->config->limitForDetail);
        $activityP->where('read', false);
        $activityP->where('active', true);
        $activityP->where('status', 'P');
        $activityP->orderByDescending('createdAt');
        $activityP->whereInclude('fromUser,comment,event');
        $activities = $activityP->getActivities();
        if ($activities instanceof Error) {
            $this->errorManagement($activities->getErrorMessage());
            return;
        } elseif (is_null($activities)) {
            $this->errorManagement();
            return;
        } else {
            foreach ($activities as $activity) {
                switch ($activity->getType()) {
                    case 'MESSAGESENT':
                        $text = $boxes['MESSAGEFORLIST'];
                        $relatedId = is_null($activity->getComment()) ? $boxes['404'] : $activity->getComment()->getObjectId();
                        $elementType = 'M';
                        break;
                    case 'INVITED':
                        $text = $boxes['EVENTFORLIST'];
                        $relatedId = is_null($activity->getEvent()) ? $boxes['404'] : $activity->getEvent()->getObjectId();
                        $elementType = 'E';
                        break;
                    case 'FRIENDSHIPREQUEST':
                        $text = $boxes['FRIENDSHIPFORLIST'];
                        $relatedId = $activity->getObjectId();
                        $elementType = 'R';
                        break;
                    case 'COLLABORATIONREQUEST':
                        $text = $boxes['COLLABORATIONFORLIST'];
                        $relatedId = $activity->getObjectId();
                        $elementType = 'R';
                        break;
                    case 'FOLLOWING':
                        $text = $boxes['FOLLOWINGFORLIST'];
                        $relatedId = $activity->getObjectId();
                        $elementType = 'R';
                        break;
                }
                $createdAt = $activity->getCreatedAt();
                $fromUserId = $activity->getFromUser()->getObjectId();
                $thumbnail = $activity->getFromUser()->getProfileThumbnail();
                $type = $activity->getFromUser()->getType();
                $username = $activity->getFromUser()->getUsername();
                $fromUserInfo = new UserInfo($fromUserId, $thumbnail, $type, $username);
                $notificationInfo = new NotificationForDetailedList($createdAt, $fromUserInfo, $relatedId, $text, $elementType);
                array_push($notificationArray, $notificationInfo);
            }
        }
        $this->error = null;
        $this->notificationArray = $notificationArray;
    }

    /**
     * \fn	initForRelationList($type)
     * \brief	Init NotificationBox instancef for relation list
     * \param	$objectId
     * \param	$type
     * \return	infoBox
     */
    public function initForEventList() {
        $currentUserId = sessionChecker();
         global $boxes;
        if ($currentUserId == $boxes['NOID']) {
            $this->errorManagement($boxes['ONLYIFLOGGEDIN']);
            return;
        }
        $this->invitationCounter = null;
        $this->messageCounter = null;
        $this->relationCounter = null;
        $relationArray = array();
        $activity = new ActivityParse();
        $activity->wherePointer('toUser', '_User', $currentUserId);
        $activity->where('type', 'INVITED');
        $activity->where('read', false);
        $activity->where('status', 'P');
        $activity->where('active', true);
        $activity->setLimit($this->config->limitForMessageList);
        $activity->orderByDescending('createdAt');
        $activity->whereInclude('fromUser,event');
        $activities = $activity->getActivities();
        if ($activities instanceof Error) {
            $this->errorManagement($activities->getErrorMessage());
            return;
        } elseif (is_null($activities)) {
            $this->errorManagement();
            return;
        } else {
            foreach ($activities as $act) {
                if (!is_null($act->getFromUser()) && !is_null($act->getEvent())) {
                    $createdAt = $act->getCreatedAt();
                    $relationId = $act->getFromUser()->getObjectId();
                    $thumbnail = $act->getFromUser()->getProfileThumbnail();
                    $userType = $act->getFromUser()->getType();
                    $username = $act->getFromUser()->getUsername();
                    $fromUserInfo = new UserInfo($relationId, $thumbnail, $userType, $username);
                    $relationType = 'E';
                    $text = $boxes['EVENTFORLIST'];
                    $relatedId = is_null($act->getEvent()) ? $boxes['404'] : $act->getEvent()->getObjectId();
                    $notificationInfo = new NotificationForDetailedList($createdAt, $fromUserInfo, $relatedId, $text, $relationType);
                    array_push($relationArray, $notificationInfo);
                }
            }
        }
        $this->error = null;
        $this->notificationArray = $relationArray;
    }

    /**
     * \fn	initForMessageList()
     * \brief	Init NotificationBox instancef for relation list
     * \param	$objectId
     * \param	$type
     * \return	infoBox
     */
    public function initForMessageList() {
        $currentUserId = sessionChecker();
        global $boxes;
        if ($currentUserId == $boxes['NOID']) {
            $this->errorManagement($boxes['ONLYIFLOGGEDIN']);
            return;
        }
        $relationArray = array();
        $activity = new ActivityParse();
        $activity->wherePointer('toUser', '_User', $currentUserId);
        $activity->where('type', 'MESSAGESENT');
        $activity->where('read', false);
        $activity->where('status', 'P');
        $activity->where('active', true);
        $activity->setLimit($this->config->limitForEventList);
        $activity->orderByDescending('createdAt');
        $activity->whereInclude('fromUser');
        $activities = $activity->getActivities();
        if ($activities instanceof Error) {
            $this->errorManagement($activities->getErrorMessage());
            return;
        } elseif (is_null($activities)) {
            $this->errorManagement();
            return;
        } else {
            foreach ($activities as $act) {
                if (!is_null($act->getFromUser())) {
                    $createdAt = $act->getCreatedAt();
                    $relationId = $act->getFromUser()->getObjectId();
                    $thumbnail = $act->getFromUser()->getProfileThumbnail();
                    $type = $act->getFromUser()->getType();
                    $username = $act->getFromUser()->getUsername();
                    $fromUserInfo = new UserInfo($relationId, $thumbnail, $type, $username);
                    $relationType = 'M';
                    $text = $boxes['MESSAGEFORLIST'];
                    $relatedId = is_null($act->getComment()) ? $boxes['404'] : $act->getComment()->getObjectId();
                    $notificationInfo = new NotificationForDetailedList($createdAt, $fromUserInfo, $relatedId, $text, $relationType);
                    array_push($relationArray, $notificationInfo);
                }
            }
        }
        $this->error = null;
        $this->notificationArray = $relationArray;
    }

    /**
     * \fn	initForRelationList($objectId,$type)
     * \brief	Init NotificationBox instancef for relation list
     * \param	$type
     * \return	infoBox
     * \todo    prendere il type dalla sessione
     */
    public function initForRelationList($type) {
        $currentUserId = sessionChecker();
        global $boxes;
        if ($currentUserId == $boxes['NOID']) {
            $this->errorManagement($boxes['ONLYIFLOGGEDIN']);
            return;
        }
        $relationArray = array();
        $activity = new ActivityParse();
        $activity->wherePointer('toUser', '_User', $currentUserId);
        if ($type == 'SPOTTER') {
            $activity->where('type', 'FRIENDSHIPREQUEST');
        } else {
            $activityTypes = array(array('type' => 'COLLABORATIONREQUEST'), array('type' => 'FOLLOWING'));
            $activity->whereOr($activityTypes);
        }
        $activity->where('read', false);
        $activity->where('status', 'P');
        $activity->where('active', true);
        $activity->setLimit($this->config->limitForRelationList);
        $activity->orderByDescending('createdAt');
        $activity->whereInclude('fromUser');
        $activities = $activity->getActivities();
        if ($activities instanceof Error) {
            $this->errorManagement($activities->getErrorMessage());
            return;
        } elseif (is_null($activities)) {
            $this->errorManagement();
            return;
        } else {
            foreach ($activities as $act) {
                if (!is_null($act->getFromUser())) {
                    $createdAt = $act->getCreatedAt();
                    $relationId = $act->getFromUser()->getObjectId();
                    $thumbnail = $act->getFromUser()->getProfileThumbnail();
                    $type = $act->getFromUser()->getType();
                    $username = $act->getFromUser()->getUsername();
                    $fromUserInfo = new UserInfo($relationId, $thumbnail, $type, $username);
                    $relationType = 'R';
                    $text = ($type == 'SPOTTER') ? $boxes['FRIENDSHIPFORLIST'] : ($act->getType() == 'COLLABORATIONREQUEST') ? $boxes['COLLABORATIONFORLIST'] : $boxes['FOLLOWINGFORLIST'];
                    $relatedId = $act->getObjectId();
                    $notificationInfo = new NotificationForDetailedList($createdAt, $fromUserInfo, $relatedId, $text, $relationType);
                    array_push($relationArray, $notificationInfo);
                }
            }
        }
        $this->error = null;
        $this->notificationArray = $relationArray;
    }

    /**
     * \fn	function errorManagement($errorMessage)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessafe
     * \todo    
     */
    private function errorManagement($errorMessage = null) {
        $this->error = $errorMessage;
        $this->invitationCounter = null;
        $this->messageCounter = null;
        $this->notificationArray = array();
        $this->relationCounter = null;
    }

}

?>

