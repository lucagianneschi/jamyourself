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
 * \todo		
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	EventController class 
 * \details	gestisce le azioni di invio, rifiuto e accettazione delle richieste di partecipazione ad event
 */
class EventController extends REST {

    /**
     * \fn	declineRelationRequest()
     * \brief   decline relationship request
     * \todo    test
     */
    public function declineInvitation() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }

	    $objectId = $this->request['objectId'];
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resStatus = $activityParse->updateField($objectId, 'status', 'R');
	    $resRead = $activityParse->updateField($objectId, 'read', true);
	    if ($resStatus instanceof Error || $resRead instanceof Error ) {
		//rollback
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }
	    $this->response(array('RELDECLINED'), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	declineInvitationRequest()
     * \brief   decline invitation request
     * \todo    test, in caso di partecipazione aggiungere all'event lo user che partecipa
     */
    public function removeAttendee() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['eventId'])) {
		$this->response(array('status' => $controllers['NOEVENTID']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $eventId = $this->request['eventId'];
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	declineInvitationRequest()
     * \brief   decline invitation request
     * \todo    test, in caso di partecipazione aggiungere all'event lo user che partecipa
     */
    public function acceptInvitation() {
	global $controllers;
	try {
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
	    $res = $activityP->getActivity($objectId);
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['ACTNOTFOUND']), 403);
	    } elseif (is_null($res->getEvent())) {
		$this->response(array('status' => $controllers['NOEVENTFOUND']), 503);
	    } elseif ($this->checkUserInEventRelation($currentUser->getObjectId(), $res->getEvent()->getObjectId(), 'invited') ||
		    $this->checkUserInEventRelation($currentUser->getObjectId(), $res->getEvent()->getObjectId(), 'refused') ||
		    $this->checkUserInEventRelation($currentUser->getObjectId(), $res->getEvent()->getObjectId(), 'attendee')) {
		$this->response(array('status' => $controllers['NOAVAILABLEACCEPTINVITATION']), 503);
	    }
	    $statusUpdate = $activityP->updateField($objectId, 'status', 'A');
	    $readUpdate = $activityP->updateField($objectId, 'read', true);
	    if ($statusUpdate instanceof Error || $readUpdate instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }
            require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventP = new EventParse();
	    $event = $eventP->updateField($event->getObjectId(), 'attendee', $currentUser->getObjectId(), true, 'add', '_User');
	    if ($event instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackEventManagementController($objectId, 'managementRequest');
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array($controllers['INVITATIONACCEPTED']), 200);
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
	global $controllers;
	global $mail_files;
	try {
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
	    if ($this->checkUserInEventRelation($currentUser->getObjectId(), $eventId, 'invited') ||
		    $this->checkUserInEventRelation($currentUser->getObjectId(), $eventId, 'refused') ||
		    $this->checkUserInEventRelation($currentUser->getObjectId(), $eventId, 'attendee')) {
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
		$HTMLFile = $mail_files['EVENTINVITATION'];
		$this->sendMailNotification($toUser->getEmail(), $controllers['INVITATIONMAILSBJ'], file_get_contents(STDHTML_DIR . $HTMLFile));
		$this->response(array($controllers['INVITATIONSENT']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    private function checkUserInEventRelation($userId, $eventId, $field) {
	require_once CLASSES_DIR . 'eventParse.class.php';
	$eventP = new EventParse();
	$eventP->where('objectId', $eventId);
	$eventP->whereRelatedTo($field, '_User', $userId);
	$check = $eventP->getCount();
	return ($check != 0) ? true : false;
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
	$activity->setUserStatus(null);
	$activity->setVideo(null);
	return $activity;
    }

    private function sendMailNotification($address, $subject, $html) {
	global $controllers;
	require_once SERVICES_DIR . 'mail.service.php';
	$mail = mailService();
	$mail->AddAddress($address);
	$mail->Subject = $subject;
	$mail->MsgHTML($html);
	$resMail = $mail->Send();
	if ($resMail instanceof phpmailerException) {
	    $this->response(array('status' => $controllers['NOMAIL']), 403);
	}
	$mail->SmtpClose();
	unset($mail);
	return true;
    }

}
?>