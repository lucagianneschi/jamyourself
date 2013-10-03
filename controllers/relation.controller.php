<?php

/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di invio/ricezione delle relazioni
 * \details		incrementa/decrementa il loveCounter di una classe e istanza corrispondente activity
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once SERVICES_DIR . 'mail.service.php';



/**
 * \brief	RelationController class 
 * \details	controller per invio e ricezione relazioni
 */
class RelationController extends REST {

    /**
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
	session_start();
    }

    /**
     * \fn		acceptRelationRequest()
     * \brief   accept relationship request
     * \todo    usare la sessione
     */
    public function acceptRelationRequest() {
	require_once SERVICES_DIR . 'mail.service.php';
	#TODO
	//simulo che l'utente in sessione sia GuUAj83MGH

	$currentUser = new User('SPOTTER');
	$currentUser->setObjectId('GuUAj83MGH');

	try {
	    //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
		$this->response('', 406);
	    }
	    $activityId = $_REQUEST['objectId'];
	    $fromUserObjectId = $_REQUEST['objectId'];
	    $toUserObjectId = $_REQUEST['objectId'];
	    $fromUserType = $_REQUEST['fromUserType']; //passo diretto o ci risalgo a posteriori?	
	    $toUserType = $_REQUEST['toUserType'];
	    $sessionToken = $_REQUEST['$sessionToken']; //NB posso aggiornare solo l'utente che accetta la richiesta

	    $activityP = new ParseActivity();
	    $activityP->updateField($activityId, 'status', 'A'); //passa da pending a accettata
	    $activityP->updateField($activityId, 'read', true); //passa da non letta  a letta

	    $fromUserP = new UserParse();
	    $fromUser = $fromUserP->getUser($fromUserObjectId);
	    $toUserP = new UserParse();
	    $toUser = $toUserP->getUser($toUserObjectId);

	    switch ($fromUserType) {
		case 'SPOTTER':
		    if ($toUserType == 'SPOTTER') {
			//friendship
			$HTMLFile = 'friendshipRequestAccepted';
		    }
		    break;
		default : //le relazioni saranno uguali come richiesta per VENUE e JAMMER
		    if ($toUserType == 'SPOTTER') {
			$this->response(array(RELDENIED), 200);
		    } else {
			$HTMLFile = 'collaborationRequestAccepted';
		    }
		    break;
	    }
	    try {
		$mail = new MailService(true);
		$mail->IsHTML(true);

		$mail->AddAddress('luca.gianneschi@gmail.com');
		//$mail->AddAddress($toUser->getEmail());
		$mail->Subject = SBJOK;
		$mail->MsgHTML(file_get_contents(STDHTML_DIR . $HTMLFile));
		$mail->Send();
	    } catch (phpmailerException $e) {//OK??
		throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	    } catch (Exception $e) {
		throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	    }
	    $mail->SmtpClose();
	    unset($mail);
	    $this->response(array(RELDENIED), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		declineRelationRequest()
     * \brief   decline relationship request
     * \todo    usare la sessione
     */
    public function declineRelationRequest() {
	#TODO
	//simulo che l'utente in sessione sia GuUAj83MGH
	require_once CLASSES_DIR . 'user.class.php';
	$currentUser = new User('SPOTTER');
	$currentUser->setObjectId('GuUAj83MGH');

	try {
	    //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
		$this->response('', 406);
	    }
	    $activityId = $_REQUEST['objectId'];
	    $activityP = new ParseActivity();
	    $activityP->updateField($activityId, 'status', 'R'); //passa da pending a refused
	    $activityP->updateField($activityId, 'read', true); //passa da non letta  a letta
	    $this->response(array($res), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		removeRelationship ()
     * \brief   remove an existing relationship 
     * \todo    usare la sessione
     */
    public function removeRelationship() {
	#TODO
	//simulo che l'utente in sessione sia GuUAj83MGH
	require_once CLASSES_DIR . 'user.class.php';
	$currentUser = new User('SPOTTER');
	$currentUser->setObjectId('GuUAj83MGH');

	try {
	    //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
		$this->response('', 406);
	    }
	    $activityId = $_REQUEST['objectId'];
	    $fromUserObjectId = $_REQUEST['objectId'];
	    $toUserObjectId = $_REQUEST['objectId'];
	    $fromUserType = $_REQUEST['fromUserType'];
	    $toUserType = $_REQUEST['toUserType'];
	    $sessionToken = $_REQUEST['$sessionToken'];

	    switch ($fromUserType) {
		case 'SPOTTER':
		    if ($toUserType == 'SPOTTER') {
			//rimuovi friendship
		    } else {
			//rimuovi following
		    }
		    break;
		default : //le relazioni saranno uguali come richiesta per VENUE e JAMMER
		    if ($toUserType == 'VENUE' || $toUserType == 'JAMMER') {
			//rimuovi collaboration
		    } else {
			$this->response(array(NORELDEL), 200);
		    }
		    break;
	    }
	    $this->response(array($res), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		sendRelationRequest()
     * \brief   send request for relationships
     * \todo    usare la sessione
     */
    public function sendRelationRequest() {
	require_once SERVICES_DIR . 'mail.service.php';
	#TODO
	//simulo che l'utente in sessione sia GuUAj83MGH

	$currentUser = new User('SPOTTER');
	$currentUser->setObjectId('GuUAj83MGH');

	try {
	    //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
		$this->response('', 406);
	    }
	    $fromUserObjectId = $_REQUEST['objectId'];
	    $toUserObjectId = $_REQUEST['objectId'];
	    $fromUserType = $_REQUEST['fromUserType'];
	    $toUserType = $_REQUEST['toUserType'];

	    //se l'utente cerca di avere relazione con se stesso esco con risposta a schermo
	    if ($fromUserObjectId == $toUserObjectId) {
		$this->response(array(SELF), 200);
	    }

	    $activity = new Activity();
	    $activity->setAccepted(true); // a cosa serve? per ora è inutilizzato per qualsiasi contatore, se non se chiarisce utilizzo si elimina
	    $activity->setActive(true);
	    $activity->setCounter(0);
	    $activity->setFromUser($fromUserObjectId);
	    //$activity->setFromUser($currentUser->getObjectId());
	    $activity->setRead(false);
	    $activity->setStatus("P");

	    switch ($fromUserType) {
		case 'SPOTTER':
		    if ($toUserType == 'SPOTTER') {
			$activity->setType("FRIENDSHIPREQUEST");
			$HTMLFile = 'friendshipRequest.html';
		    } else {
			$activity->setType("FOLLOWING");
			$HTMLFile = 'following.html';
		    }
		    break;
		default : //le relazioni saranno uguali come richiesta per VENUE e JAMMER
		    if ($toUserType == 'SPOTTER') {
			$this->response(array(RELDENIED), 200);
		    } else {
			$activity->setType("COLLABORATIONREQUEST");
			$HTMLFile = 'collaborationRequest.html';
		    }
		    break;
	    }

	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if (get_class($resActivity) == 'Error') {
		$this->response(array($resActivity), 503);
	    } else {
		try {
		    $mail = new MailService(true);
		    $mail->IsHTML(true);

		    $mail->AddAddress('luca.gianneschi@gmail.com');
		    //$mail->AddAddress($toUser->getEmail());
		    $mail->Subject = SBJ;
		    $mail->MsgHTML(file_get_contents(STDHTML_DIR . $HTMLFile));
		    $mail->Send();
		} catch (phpmailerException $e) {//OK??
		    throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		} catch (Exception $e) {
		    throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
		$mail->SmtpClose();
		unset($mail);
		$this->response(array(RELSAVED), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

}

?>