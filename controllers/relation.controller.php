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
 * \todo		implementare i parametri di sessione (es currentUser), terminare funzioni, verificare che siano state istanziate tutte le activity
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	RelationController class
 * \details	controller per invio e ricezione relazioni
 */
class RelationController extends REST {

    /**
     * \fn	acceptRelationRequest()
     * \brief   accept relationship request
     * \todo    mancano da gestire i contatori di followers, jammer e venue
     */
    public function acceptRelationRequest() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['activityId'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOACTIVITYID']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSERTYPE']), 400);
	    }
	    $currentUser = $this->request['currentUser'];
	    $activityId = $this->request['activityId'];
	    $toUser = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    $fromUserType = $currentUser->getType();
	    require_once CLASSES_DIR . 'user.class.php';
	    require_once CLASSES_DIR . 'userParse.class.php';
	    require_once SERVICES_DIR . 'mail.service.php';
	    $toUserP = new UserParse();
	    $toUserB = $toUserP->getUser($toUser);
	    $sessionTokenA = $currentUser->getSessionToken();
	    $sessionTokenB = $toUserB->getSessionToken();
	    if ($toUserB instanceof Error) {
		$this->response(array('status' => $controllers['USERNOTFOUND']), 403);
	    } elseif (!isset($sessionTokenB)) {
		$this->response(array('status' => $controllers['NOSESSIONTOKEN']), 403);
	    }
	    switch ($fromUserType) {
		case 'SPOTTER':
		    $HTMLFile = $mail_files['FRIENDSHIPACCEPTEDEMAIL'];
		    break;
		default :
		    if ($toUserType == 'SPOTTER') {
			$this->response(array($controllers['RELDENIED']), 403);
		    } else {
			$HTMLFile = $mail_files['COLLABORATIONACCEPTEDEMAIL'];
		    }
		    break;
	    }
	    $resB = $toUserP->updateField($toUserB->getObjectId(), $sessionTokenB, 'friendship', $currentUser->getObjectId(), true, 'add', '_User');
	    if ($resB instanceof Error) {
		$this->response(array('status' => $controllers['NORELACC']), 403);
	    }
	    $fromUserP = new UserParse();
	    $add1 = $fromUserP->updateField($currentUser->getObjectId(), $sessionTokenA, 'friendship', $toUserB->getObjectId(), true, 'add', '_User');
	    if ($add1 instanceof Error) {
		$this->response(array('status' => $controllers['NORELACC']), 403);
	    }
	    $mail = new MailService(true);
	    $mail->IsHTML(true);
	    $mail->AddAddress($toUser->getEmail());
	    $mail->Subject = $controllers['SBJOK'];
	    $mail->MsgHTML(file_get_contents(STDHTML_DIR . $HTMLFile));
	    $resMail = $mail->Send();
	    if ($resMail instanceof phpmailerException) {
		$this->response(array('status' => $controllers['NOMAIL']), 403); 
	    }
	    $mail->SmtpClose();
	    unset($mail);
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ActivityParse();
	    $res = $activityP->updateField($activityId, 'status', 'A');
	    $res1 = $activityP->updateField($activityId, 'read', true);
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 403); //FINIRE
	    } elseif ($res1 instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 403); //FINIRE
	    }
	    $this->response(array($controllers['RELDENIED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	declineRelationRequest()
     * \brief   decline relationship request
     * \todo    
     */
    public function declineRelationRequest() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['activityId'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOACTIVITYID']), 400);
	    }
	    $activityId = $this->request['objectId'];
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ParseActivity();
	    $res = $activityP->updateField($activityId, 'status', 'R');
	    $res1 = $activityP->updateField($activityId, 'read', true);
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 403);
	    } elseif ($res1 instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 403);
	    }
	    $this->response(array('RELDECLINED'), 200); 
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	removeRelationship ()
     * \brief   remove an existing relationship
     * \todo    rimuovere un following,mancano da gestire i contatori di followers, jammer e venue
     * \todo    terminare funzione
     */
    public function removeRelationship() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['activityId'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOACTIVITYID']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSERTYPE']), 400);
	    }
	    $currentUser = $this->request['currentUser'];
	    $activityId = $this->request['activityId'];
	    $toUser = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    $fromUserType = $currentUser->getType();
	    require_once CLASSES_DIR . 'user.class.php';
	    require_once CLASSES_DIR . 'userParse.class.php';
	    require_once SERVICES_DIR . 'mail.service.php';
	    $toUserP = new UserParse();
	    $toUserB = $toUserP->getUser($toUser);
	    $sessionTokenA = $currentUser->getSessionToken();
	    $sessionTokenB = $toUserB->getSessionToken();
	    if ($toUserB instanceof Error) {
		$this->response(array('status' => $controllers['USERNOTFOUND']), 403);
	    } elseif (!isset($sessionTokenB)) {
		$this->response(array('status' => $controllers['NOSESSIONTOKEN']), 403);
	    }
	    if ($fromUserType == 'SPOTTER' && $toUserType == 'SPOTTER') {
		$field = 'friendship';
		$field1 = 'friendship';
	    } elseif ($fromUserType == 'SPOTTER' && $toUserType != 'SPOTTER') {
		$field = 'following';
		$field1 = 'followers';
	    } elseif ($fromUserType != 'SPOTTER') {
		$field = 'collaboration';
		$field1 = 'collaboration';
	    }
	    //////////////////////////////////////////


	    $resB = $toUserP->updateField($toUserB->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'add', '_User');
	    if ($resB instanceof Error) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403); //FINIRE
	    }
	    $fromUserP = new UserParse();
	    $add1 = $fromUserP->updateField($currentUser->getObjectId(), $sessionTokenA, 'friendship', $toUserB->getObjectId(), true, 'add', '_User');
	    if ($add1 instanceof Error) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403); //FINIRE
	    }

	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($currentUser->getObjectId());
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRecord(null);
	    $activity->setRead(true);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser($toUserB);
	    $activity->setType('RELREMOVED');
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityP = new ActivityParse();
	    $res = $activityP->saveActivity($activity);
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 403); //FINIRE
	    }
	    $this->response(array($controllers['RELDELETED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		sendRelationRequest()
     * \brief   send request for relationships
     * \todo    terminare funzione
     */
    public function sendRelationRequest() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }  elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSERTYPE']), 400);
	    }
	    $currentUser = $this->request['currentUser'];
	    $toUser = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    $fromUserType = $currentUser->getType();
	    if ($currentUser->getObjectId() == $toUser) {
		$this->response(array('status' => $controllers['SELF']), 403);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($currentUser->getObjectId());
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRecord(null);
	    $activity->setRead(true);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser($toUser);
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    switch ($fromUserType) {
		case 'SPOTTER':
		    if ($toUserType == 'SPOTTER') {
			$activity->setType("FRIENDSHIPREQUEST");
			$HTMLFile = $mail_files['FRIENDSHIPREQUESTEMAIL'];
		    } else {
			$activity->setType("FOLLOWING");
			$HTMLFile = $mail_files['FOLLOWINGEMAIL'];
		    }
		    break;
		default : 
		    if ($toUserType == 'SPOTTER') {
			$this->response(array($controllers['RELDENIED']), 200);
		    } else {
			$activity->setType("COLLABORATIONREQUEST");
			$HTMLFile = $mail_files['COLLABORATIONREQUESTEMAIL'];
		    }
		    break;
	    }
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->response(array('NOACSAVE'), 403);
	    } else {
		require_once SERVICES_DIR . 'mail.service.php';
		$mail = new MailService(true);
		$mail->IsHTML(true);
		$mail->AddAddress($toUser->getEmail());
		$mail->Subject = $controllers['SBJ'];
		$mail->MsgHTML(file_get_contents(STDHTML_DIR . $HTMLFile));
		$resMail = $mail->Send();
		if ($resMail instanceof phpmailerException) {
		    $this->response(array('status' => $controllers['NOMAIL']), 403);
		}
		$mail->SmtpClose();
		unset($mail);
		$this->response(array($controllers['RELSAVED']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

}

?>