<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione delle azioni di invito per event
 * \details		gestisce le azioni di invio, rifiuto e accettazione delle richieste di partecipazione ad event
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		test di funzionamento, fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'eventChecker.service.php';

/**
 * \brief	EventController class 
 * \details	gestisce le azioni di invio, rifiuto e accettazione delle richieste di partecipazione ad event
 */
class EventController extends REST {

    /**
     * \fn	declineInvitationRequest()
     * \brief   decline invitation request
     * \todo    test, in caso di partecipazione aggiungere all'event lo user che partecipa
     */
    public function acceptInvitation() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUserId'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => $controllers['NOACTIVITYID']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $toUserId = $this->request['toUserId'];
	    $objectId = $this->request['objectId'];
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $toUser = $userParse->getUser($toUserId);
	    if ($toUser instanceof Error) {
		$this->response(array('status' => $controllers['USERNOTFOUND']), 403);
	    }
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ActivityParse();
	    $activityP->where('objectId', $objectId);
	    $activityP->whereInclude('event');
	    $activityP->setLimit(1);
	    $res = $activityP->getActivities();
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['ACTNOTFOUND']), 403);
	    } elseif (is_null($res->getEvent())) {
		$this->response(array('status' => $controllers['NOEVENTFOUND']), 503);
	    } elseif ((checkUserInEventRelation($currentUser->getObjectId(), $res->getEvent()->getObjectId(), 'invited') == true) ||
		    (checkUserInEventRelation($currentUser->getObjectId(), $res->getEvent()->getObjectId(), 'refused') == true) ||
		    (checkUserInEventRelation($currentUser->getObjectId(), $res->getEvent()->getObjectId(), 'attendee') == true)) {
		$this->response(array('status' => $controllers['NOAVAILABLEACCEPTINVITATION']), 503);
	    }
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventP = new EventParse();
	    $event = $eventP->updateField($event->getObjectId(), 'attendee', $currentUser->getObjectId(), true, 'add', '_User');
	    $statusUpdate = $activityP->updateField($objectId, 'status', 'A');
	    $readUpdate = $activityP->updateField($objectId, 'read', true);
	    if ($statusUpdate instanceof Error || $readUpdate instanceof Error || $event instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackEventManagementController($objectId, 'acceptInvitation', $currentUser->getObjectId(), $event->getObjectId());
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array($controllers['INVITATIONACCEPTED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	attendEvent()
     * \brief   set the currentUser as an attendee
     * \todo    test
     */
    public function attendEvent() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUserId'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $eventId = $this->request['objectId'];
	    if (checkUserInEventRelation($currentUser->getObjectId(), $eventId, 'attendee') == true) {
		$this->response(array('status' => $controllers['NOAVAILABLEACCEPTINVITATION']), 503);
	    }
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventP = new EventParse();
	    $event = $eventP->updateField($eventId, 'attendee', $currentUser->getObjectId(), true, 'add', '_User');
	    if ($event instanceof Error) {
		$this->response(array('status' => $controllers['ERRORUPDATINGEVENTATTENDEE']), 503);
	    }
	    $activity = $this->createActivity("INVITED", null, $currentUser->getObjectId(), 'A', $eventId, true);
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ActivityParse();
	    $activitySave = $activityP->saveActivity($activity);
	    if ($activitySave instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackEventManagementController(null, 'declineInvitation', $currentUser->getObjectId(), $eventId);
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array($controllers['DIRECTATTENDEE']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	declineRelationRequest()
     * \brief   decline relationship request
     * \todo    test
     */
    public function declineInvitation() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $objectId = $this->request['objectId'];
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ActivityParse();
	    $activityP->where('objectId', $objectId);
	    $activityP->whereInclude('event');
	    $activityP->setLimit(1);
	    $resAct = $activityP->getActivities();
	    if ($resAct instanceof Error) {
		$this->response(array('status' => $controllers['NOACT']), 503);
	    } elseif (is_null($resAct->getEvent())) {
		$this->response(array('status' => $controllers['NOEVENTFOUND']), 503);
	    }
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventP = new EventParse();
	    $resAdd = $eventP->updateField($resAct->getEvent()->getObjectId(), 'refused', $currentUser->getObjectId(), true, 'add', '_User');
	    $resStatus = $activityP->updateField($objectId, 'status', 'R');
	    $resRead = $activityP->updateField($objectId, 'read', true);
	    if ($resStatus instanceof Error || $resRead instanceof Error || $resAdd instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackEventManagementController($objectId, 'declineInvitation', $resAct->getEvent()->getObjectId(), $resAct->getEvent());
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array('INVITATIONDECLINED'), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	declineInvitationRequest()
     * \brief   decline invitation request
     * \todo    test
     */
    public function removeAttendee() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => $controllers['NOACTIVITYID']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $objectId = $this->request['objectId'];
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $activityParse->where('objectId', $objectId);
	    $activityParse->whereInclude('event');
	    $activityParse->setLimit(1);
	    $res = $activityParse->getActivities();
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOACTIVITYID']), 403);
	    } elseif (is_null($res->getEvent())) {
		$this->response(array('status' => $controllers['NOEVENTFOUND']), 403);
	    }
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventParse = new EventParse();
	    $attendeeRemove = $eventParse->updateField($res->getEvent()->getObjectId(), 'attendee', array($currentUser->getObjectId()), true, 'remove', '_User');
	    if ($attendeeRemove instanceof Error) {
		$this->response(array('status' => $controllers['ERRORREMOVING']), 403);
	    }
	    $refusedAdd = $eventParse->updateField($res->getEvent()->getObjectId(), 'refused', array($currentUser->getObjectId()), true, 'add', '_User');
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $activityParse1 = new ActivityParse();
	    $resUpdate = $activityParse1->updateField($objectId, 'status', 'D');
	    if ($resUpdate instanceof Error || $refusedAdd instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackEventManagementController($objectId, 'removeAttendee');
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array('status' => $controllers['NOEVENTFOUND']), 403);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	sendRelationRequest()
     * \brief   send request for relationships
     * \todo    test
     */
    public function sendInvitation() {
	try {
	    global $controllers;
	    global $mail_files;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['eventId'])) {
		$this->response(array('status' => $controllers['NOEVENTID']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $toUserId = $this->request['toUser'];
	    $eventId = $this->request['eventId'];
	    if ($currentUser->getObjectId() == $toUserId) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }
	    if ((checkUserInEventRelation($currentUser->getObjectId(), $eventId, 'invited') == true) ||
		    (checkUserInEventRelation($currentUser->getObjectId(), $eventId, 'refused') == true) ||
		    (checkUserInEventRelation($currentUser->getObjectId(), $eventId, 'attendee') == true)) {
		$this->response(array('status' => $controllers['NOAVAILABLEFORINVITATION']), 503);
	    }
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $toUser = $userParse->getUser($toUserId);
	    if (!relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserId, $toUser->getType())) {
		$this->response(array('status' => $controllers['NOTINRELATION']), 503);
	    }
	    $activity = $this->createActivity("INVITED", $toUserId, $currentUser->getObjectId(), 'P', $eventId, false);
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 503);
	    } else {
		sendMailForNotification($toUser->getEmail(), $controllers['INVITATIONMAILSBJ'], file_get_contents(STDHTML_DIR . $mail_files['EVENTINVITATION']));
		$this->response(array($controllers['INVITATIONSENT']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn      createActivity($type, $toUserId, $currentUserId, $status, $eventId, $readr)
     * \brief   private function to create ad hoc activity
     * \param   $type, $toUserId, $currentUserId, $status, $eventId, $read
     */
    private function createActivity($type, $toUserId, $currentUserId, $status, $eventId, $read) {
	require_once CLASSES_DIR . 'activity.class.php';
	$activity = new Activity();
	$activity->setActive(true);
	$activity->setAlbum(null);
	$activity->setComment(null);
	$activity->setCounter(0);
	$activity->setEvent($eventId);
	$activity->setFromUser($currentUserId);
	$activity->setImage(null);
	$activity->setPlaylist(null);
	$activity->setQuestion(null);
	$activity->setRecord(null);
	$activity->setRead($read);
	$activity->setSong(null);
	$activity->setStatus($status);
	$activity->setToUser($toUserId);
	$activity->setType($type);
	$activity->setVideo(null);
	return $activity;
    }

}

?>