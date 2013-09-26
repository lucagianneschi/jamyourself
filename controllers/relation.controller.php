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
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
define('RELDENIED', 'You are not allowed to send a relationship request to this user!');
define('SELF', 'Don&apos;t be shy, ask someone else to be your friend or your collaborator!');
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
	public function acceptRelationRequest(){
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
			$this->response(array($res), 200);
						
		} catch (Exception $e) {
			$this->response(array($e), 503);
		}
	}
	
	/**
	 * \fn		sendRelationRequest()
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
			$this->response(array($res), 200);
						
		} catch (Exception $e) {
			$this->response(array($e), 503);
		}
	}
	
	/**
	 * \fn		removeRelationship ()
	 * \brief   remove an existing relationship 
	 * \todo    usare la sessione
	 */
	public function removeRelationship () {
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
			$this->response(array($res), 200);
						
		} catch (Exception $e) {
			$this->response(array($e), 503);
		}
	}
	
	/**
	 * \fn		sendRelationRequest()
	 * \brief   send request for relationships
	 * \todo    usare la sessione
	 */
    public function sendRelationRequest() {
		
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
			if ($fromUserObjectId == $toUserObjectId ){
				$this->response(array(SELF), 200); 
			}
			
            $activity = new Activity();
            $activity->setAccepted(true);
            $activity->setActive(true);
			$activity->setCounter(0);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setRead(true);
            $activity->setStatus("P");
            
			switch($fromUserType){
				case 'SPOTTER':
					if($toUserType == 'SPOTTER'){
						$activity->setType("FRIENDSHIPREQUEST");
					} else {
						$activity->setType("FOLLOWING");	
					}
				break;
				default : //le relazioni saranno uguali come richiesta per VENUE e JAMMER
					if($toUserType == 'SPOTTER'){
						$this->response(array(RELDENIED), 200);
					} else {
						$activity->setType("COLLABORATIONREQUEST");
					}
				break;
			}
			
			if (get_class($res) == 'Error') {
				$this->response(array($res), 503);
			}
			
			$activityParse = new ActivityParse();
			$resActivity = $activityParse->saveActivity($activity);
			
			if (get_class($resActivity) == 'Error') {
				$this->response(array($resActivity), 503);
			}
							
			$this->response(array($res), 200);
						
		} catch (Exception $e) {
			$this->response(array($e), 503);
		}
    }
		
}
?>