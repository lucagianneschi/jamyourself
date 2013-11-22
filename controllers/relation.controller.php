<?php

/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di invio/ricezione delle relazioni
 * \details		incrementa/decrementa il loveCounter di una classe e istanza corrispondente activity
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		 terminare funzioni, verificare che siano state istanziate tutte le activity
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
 * \brief	RelationController class
 * \details	controller per invio e ricezione relazioni
 * \todo        introdurre le rollback per le varie funzioni
 */
class RelationController extends REST {

    /**
     * \fn	acceptRelationRequest()
     * \brief   accept relationship request
     * \todo    test
     */
    public function acceptRelationRequest() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['activityId'])) {
		$this->response(array('status' => $controllers['NOACTIVITYID']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $activityId = $this->request['activityId'];
	    $toUserId = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    require_once SERVICES_DIR . 'relationChecker.service.php';
	    if ($this->relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserType, $toUserId)) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }
	    $toUserP = new UserParse();
	    $toUser = $toUserP->getUser($toUserId);
	    $sessionTokenA = $currentUser->getSessionToken();
	    $sessionTokenB = $toUserP->getSessionToken();
	    if ($toUser instanceof Error) {
		$this->response(array('status' => $controllers['USERNOTFOUND']), 503);
	    } elseif (!isset($sessionTokenB)) {
		$this->response(array('status' => $controllers['NOSESSIONTOKEN']), 503);
	    }
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $fromUserA = new UserParse();
	    if ($currentUser->getType() == 'SPOTTER' && $toUserType == 'SPOTTER') {
		$type = 'FRIENDSHIPACCEPTED';
		$HTMLFile = $mail_files['FRIENDSHIPACCEPTEDEMAIL'];
		$field = 'friendship';
		$resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'add', '_User');
		$counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'friendshipCounter', ($currentUser->getFriedshipCounter() + 1));
		$resB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'add', '_User');
		$counterB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'friendshipCounter', ($toUser->getFriedshipCounter() + 1));
		if ($resA instanceof Error || $resB instanceof Error) {
		    $this->response(array('status' => $controllers['NOFRIENDSHIPUPDATE']), 503);
		} elseif ($counterA instanceof Error || $counterB instanceof Error) {
		    $this->response(array('status' => $controllers['NOFRIENDSHIPCOUNTERUPDATE']), 503);
		}
	    } else {
		$type = 'COLLABORATIONACCEPTED';
		$field = 'collaboration';
		$HTMLFile = $mail_files['COLLABORATIONACCEPTEDEMAIL'];
		//aggiungo alla relazione collaboration per entrambi e aumento il contatore collaboration per entrambi
		$counterCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'collaborationCounter', ($currentUser->getFriedshipCounter() + 1));
		$counterCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'collaborationCounter', ($toUser->getFriedshipCounter() + 1));
		$resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'add', '_User');
		$resB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'add', '_User');
		if ($resA instanceof Error || $resB instanceof Error) {
		    $this->response(array('status' => $controllers['NOCOLLABORATIONUPDATE']), 503);
		} elseif ($counterCollaborationA instanceof Error || $counterCollaborationB instanceof Error) {
		    $this->response(array('status' => $controllers['NOCOLLABORATIONCOUNTERUPDATE']), 503);
		}
		if ($currentUser->getType() == 'VENUE' && $toUserType == 'VENUE') {
		    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'venueCounter', ($currentUser->getVenueCounter() + 1));
		    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'venueCounter', ($toUser->getVenueCounter() + 1));
		} elseif ($currentUser->getType() == 'JAMMER' && $toUserType == 'JAMMER') {
		    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'jammerCounter', ($currentUser->getJammerCounter() + 1));
		    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'jammerCounter', ($toUser->getJammerCounter() + 1));
		} elseif ($currentUser->getType() == 'VENUE' && $toUserType == 'JAMMER') {
		    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'jammerCounter', ($currentUser->getJammerCounter() + 1));
		    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'venueCounter', ($toUser->getVenueCounter() + 1));
		} elseif ($currentUser->getType() == 'JAMMER' && $toUserType == 'VENUE') {
		    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'venueCounter', ($currentUser->getVenueCounter() + 1));
		    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'jammerCounter', ($toUser->getJammerCounter() + 1));
		}
		if ($specificCollaborationA instanceof Error || $specificCollaborationB instanceof Error) {
		    $this->response(array('status' => $controllers['NOSPECIFICCOLLABORATIONCOUNTERUPDATE']), 503);
		}
		require_once CLASSES_DIR . 'activityParse.class.php';
		$activityP = new ActivityParse();
		$res = $activityP->updateField($activityId, 'status', 'A');
		$res1 = $activityP->updateField($activityId, 'read', true);
		if ($res instanceof Error || $res1 instanceof Error) {
		    $this->response(array('status' => $controllers['NOACTUPDATE']), 503);
		}
		$this->sendMailNotification($toUser->getEmail(), $controllers['SBJOK'], file_get_contents(STDHTML_DIR . $HTMLFile));
		$activity = $this->createActivity($type, $toUser, $currentUser->getObjectId(), 'A');
		require_once CLASSES_DIR . 'activityParse.class.php';
		$activityP1 = new ActivityParse();
		$act = $activityP1->saveActivity($activity);
		if ($act instanceof Error) {
		    $this->response(array('status' => $controllers['NOACSAVE']), 503);
		}
		$this->response(array($controllers['RELACCEPTED']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	declineRelationRequest()
     * \brief   decline relationship request
     * \todo    test
     */
    public function declineRelationRequest() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['activityId'])) {
		$this->response(array('status' => $controllers['NOACTIVITYID']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $toUser = $this->request['toUser'];
	    $activityId = $this->request['activityId'];
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ActivityParse();
	    $res = $activityP->updateField($activityId, 'status', 'R');
	    $res1 = $activityP->updateField($activityId, 'read', true);
	    if ($res instanceof Error || $res1 instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }
	    $activity = $this->createActivity('RELDECLINED', $toUser, $currentUser->getObjectId(), 'A');
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP1 = new ActivityParse();
	    $res2 = $activityP1->saveActivity($activity);
	    if ($res2 instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 403);
	    }
	    $this->response(array('RELDECLINED'), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	removeRelationship ()
     * \brief   remove an existing relationship
     * \todo    test    
     */
    public function removeRelationship() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $toUserId = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    $fromUserType = $currentUser->getType();
	    require_once SERVICES_DIR . 'relationChecker.service.php';
	    if (!relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserId, $toUserType)) {
		$this->response(array('status' => $controllers['NORELFOUNDFORREMOVING']), 503);
	    }
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $toUserB = new UserParse();
	    $toUser = $toUserB->getUser($toUserId);
	    $sessionTokenA = $currentUser->getSessionToken();
	    $sessionTokenB = $toUserB->getSessionToken();
	    $fromUserA = new UserParse();
	    $userA = $fromUserA->getUser($currentUser->getObjectId());
	    if ($toUser instanceof Error || $userA instanceof Error) {
		$this->response(array('status' => $controllers['USERNOTFOUND']), 503);
	    } elseif (!isset($sessionTokenB) || !isset($sessionTokenA)) {
		$this->response(array('status' => $controllers['NOSESSIONTOKEN']), 503);
	    }
	    if ($fromUserType == 'SPOTTER' && $toUserType == 'SPOTTER') {
		$field = 'friendship';
		$type = 'FRIENDSHIPREMOVED';
		$resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'remove', '_User');
		$counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'friendshipCounter', ($currentUser->getFriedshipCounter() - 1));
		$resB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'remove', '_User');
		$counterB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, 'friendshipCounter', ($toUser->getFriedshipCounter() - 1));
	    } elseif ($fromUserType == 'SPOTTER' && $toUserType != 'SPOTTER') {
		$field = 'followers';
		$field1 = 'following';
		$type = 'FOLLOWINGREMOVED';
		$resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'remove', '_User');
		$counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'followingCounter', ($currentUser->getFollowingCounter() - 1));
		$resB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, $field1, $currentUser->getObjectId(), true, 'remove', '_User');
		$counterB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, 'followersCounter', ($toUser->getFollowersCounter() - 1));
	    } elseif ($fromUserType != 'SPOTTER') {
		$field = 'collaboration';
		$type = 'COLLABORATIONREMOVED';
		$resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'remove', '_User');
		$counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'collaborationCounter', ($currentUser->getCollaborationCounter() - 1));
		$resB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'remove', '_User');
		$counterB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, 'collaborationCounter', ($toUser->getCollaborationCounter() - 1));
	    }//prevedere delle rollback
	    if ($resA instanceof Error || $resB instanceof Error || $counterA instanceof Error || $counterB instanceof Error) {
		$this->response(array('status' => $controllers['ERROREMOVINGREL']), 503);
	    }
	    $activity = $this->createActivity($type, $toUser, $currentUser->getObjectId(), 'A');
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ActivityParse();
	    $res = $activityP->saveActivity($activity);
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 503);
	    }
	    $this->response(array($controllers['RELDELETED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	sendRelationRequest()
     * \brief   send request for relationships
     * \todo    test
     */
    public function sendRelationRequest() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $toUserId = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    if ($currentUser->getObjectId() == $toUserId) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }
	    require_once SERVICES_DIR . 'relationChecker.service.php';
	    if (relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserId, $toUserType)) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }
	    if ($currentUser->getType() == 'SPOTTER') {
		if ($toUserType == 'SPOTTER') {
		    $type = "FRIENDSHIPREQUEST";
		    $HTMLFile = $mail_files['FRIENDSHIPREQUESTEMAIL'];
		} else {
		    $type = "FOLLOWING";
		    $HTMLFile = $mail_files['FOLLOWINGEMAIL'];
		}
	    } else {
		if ($toUserType == 'SPOTTER') {
		    $this->response(array('status' => $controllers['RELDENIED']), 401);
		} else {
		    $type = "COLLABORATIONREQUEST";
		    $HTMLFile = $mail_files['COLLABORATIONREQUESTEMAIL'];
		}
	    }
	    $activity = $this->createActivity($type, $toUserId, $currentUser->getObjectId(), 'P');
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 503);
	    } else {
		require_once CLASSES_DIR . 'userParse.class.php';
		$userP = new UserParse();
		$user = $userP->getUser($toUserId);
		if ($user instanceof Error) {
		    $this->response(array('status' => $controllers['NOTOUSER']), 503);
		}
		$this->sendMailNotification($toUserId->getEmail(), $controllers['SBJ'], file_get_contents(STDHTML_DIR . $HTMLFile)); //devi prima richiamare lo user
		$this->response(array($controllers['RELSAVED']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
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

    private function createActivity($type, $toUserId, $currentUserId, $status) {
	require_once CLASSES_DIR . 'activity.class.php';
	$activity = new Activity();
	$activity->setActive(true);
	$activity->setAlbum(null);
	$activity->setComment(null);
	$activity->setCounter(0);
	$activity->setEvent(null);
	$activity->setFromUser($currentUserId);
	$activity->setImage(null);
	$activity->setPlaylist(null);
	$activity->setQuestion(null);
	$activity->setRecord(null);
	$activity->setRead(false);
	$activity->setSong(null);
	$activity->setStatus($status);
	$activity->setToUser($toUserId);
	$activity->setType($type);
	$activity->setUserStatus(null);
	$activity->setVideo(null);
	return $activity;
    }

}

?>