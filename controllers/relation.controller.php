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
    public function acceptRelation() {
		global $controllers;
		global $mail_files;
		try {
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
			$objectId = $this->request['objectId'];
			$toUserId = $this->request['toUserId'];
			
			require_once CLASSES_DIR . 'userParse.class.php';
			$userParse = new UserParse();
			$toUser = $userParse->getUser($toUserId);
			
			require_once SERVICES_DIR . 'relationChecker.service.php';
			if (relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType())) {
				$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
			}
			
			require_once CLASSES_DIR . 'activityParse.class.php';
			$activityParse = new ActivityParse();
			$resStatus = $activityParse->updateField($objectId, 'status', 'A');
			if ($resStatus instanceof Error) {
				$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
			}
			$resRead = $activityParse->updateField($objectId, 'read', true);
			if ($resRead instanceof Error) {
				#TODO
				//rollback
				$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
			}
			
			require_once CLASSES_DIR . 'userParse.class.php';
			$userParse = new UserParse();
			if ($currentUser->getType() == 'SPOTTER' && $toUser->getType() == 'SPOTTER') {
				$resToUserF = $userParse->updateField($toUser->getObjectId(), 'friendship', array($currentUser->getObjectId()), true, 'add', '_User');
				$resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'friendshipCounter', 1);
				$resFromUserF = $userParse->updateField($currentUser->getObjectId(), 'friendship', array($toUser->getObjectId()), true, 'add', '_User');
				$resFromUserFC = $userParse->incrementUser($currentUser->getObjectId(), 'friendshipCounter', 1);
				$HTMLFile = $mail_files['FRIENDSHIPACCEPTEDEMAIL'];
			} elseif ($currentUser->getType() != 'SPOTTER' && $toUser->getType() != 'SPOTTER') {
				$resToUserF = $userParse->updateField($toUser->getObjectId(), 'collaboration', array($currentUser->getObjectId()), true, 'add', '_User');
				$resFromUserF = $userParse->updateField($currentUser->getObjectId(), 'collaboration', array($toUser->getObjectId()), true, 'add', '_User');
				if ($currentUser->getType() == 'JAMMER' && $toUser->getType() == 'JAMMER') {
					$resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'jammerCounter', 1);
					$resFromUserFC = $userParse->incrementUser($currentUser->getObjectId(), 'jammerCounter', 1);
				} elseif ($currentUser->getType() == 'JAMMER' && $toUser->getType() == 'VENUE') {
					$resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'venueCounter', 1);
					$resFromUserFC = $userParse->incrementUser($currentUser->getObjectId(), 'jammerCounter', 1);
				} elseif ($currentUser->getType() == 'VENUE' && $toUser->getType() == 'JAMMER') {
					$resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'jammerCounter', 1);
					$resFromUserFC = $userParse->incrementUser($currentUser->getObjectId(), 'venueCounter', 1);
				} elseif ($currentUser->getType() == 'VENUE' && $toUser->getType() == 'VENUE') {
					$resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'venueCounter', 1);
					$resFromUserFC = $userParse->incrementUser($currentUser->getObjectId(), 'venueCounter', 1);
				}
				$HTMLFile = $mail_files['COLLABORATIONACCEPTEDEMAIL'];
			}
			if ($resToUserF instanceof Error ||
				$resFromUserF instanceof Error ||
				$resToUserFC instanceof Error ||
				$resFromUserFC instanceof Error) {
				#TODO
				//rollback
				$this->response(array('status' => 'Errore nell\'aggiornamento di un Utente'), 503);
			}
			
			#TODO
			$this->sendMailNotification('daniele.caldelli@gmail.com'/*$toUser->getEmail()*/, $controllers['SBJOK'], file_get_contents(STDHTML_DIR . $HTMLFile));
			
			$this->response(array($controllers['RELACCEPTED']), 200);
		} catch (Exception $e) {
			$this->response(array('status' => $e->getMessage()), 503);
		}
    }

    /**
     * \fn	declineRelationRequest()
     * \brief   decline relationship request
     * \todo    test
     */
    public function declineRelation() {
		global $controllers;
		try {
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
			$activityParse = new ActivityParse();
			
			$resStatus = $activityParse->updateField($objectId, 'status', 'R');
			if ($resStatus instanceof Error) {
				#TODO
				//rollback
				$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
			}
			
			$resRead = $activityParse->updateField($objectId, 'read', true);
			if ($resRead instanceof Error) {
				#TODO
				//rollback
				$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
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
    public function sendRelation() {
		global $controllers;
		global $mail_files;
		try {
			if ($this->get_request_method() != "POST") {
				$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
			} elseif (!isset($_SESSION['currentUser'])) {
				$this->response(array('status' => $controllers['USERNOSES']), 403);
			} elseif (!isset($this->request['toUser'])) {
				$this->response(array('status' => $controllers['NOTOUSER']), 403);
			}
			
			$currentUser = $_SESSION['currentUser'];
			$toUserId = $this->request['toUser'];
			if ($currentUser->getObjectId() == $toUserId) {
				$this->response(array('status' => $controllers['SELF']), 503);
			}
			
			require_once CLASSES_DIR . 'userParse.class.php';
			$userParse = new UserParse();
			$toUser = $userParse->getUser($toUserId);
			
			require_once SERVICES_DIR . 'relationChecker.service.php';
			if (relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType())) {
				$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
			}
			
			if ($currentUser->getType() == 'SPOTTER') {
				if ($toUser->getType() == 'SPOTTER') {
					$type = 'FRIENDSHIPREQUEST';
					$status = 'P';
					$HTMLFile = $mail_files['FRIENDSHIPREQUESTEMAIL'];
				} else {
					$type = 'FOLLOWING';
					$status = 'A';
					$HTMLFile = $mail_files['FOLLOWINGEMAIL'];
				}
			} else {
				if ($toUser->getType() == 'SPOTTER') {
					$this->response(array('status' => $controllers['RELDENIED']), 401);
				} else {
					$type = 'COLLABORATIONREQUEST';
					$status = 'P';
					$HTMLFile = $mail_files['COLLABORATIONREQUESTEMAIL'];
				}
			}
			
			$activity = $this->createActivity($type, $toUser->getObjectId(), $currentUser->getObjectId(), $status);
			require_once CLASSES_DIR . 'activityParse.class.php';
			$activityParse = new ActivityParse();
			$resActivity = $activityParse->saveActivity($activity);
			if ($resActivity instanceof Error) {
				$this->response(array('status' => $controllers['NOACSAVE']), 503);
			} 

			if ($currentUser->getType() == 'SPOTTER' && $toUser->getType() != 'SPOTTER') {
				$resToUser = $userParse->updateField($toUser->getObjectId(), 'followers', array($currentUser->getObjectId()), true, 'add', '_User');
			}
			if ($resToUser instanceof Error) {
				#TODO
				//rollback
				$this->response(array('status' => 'XXXXX'), 503);
			}
			
			if ($currentUser->getType() == 'SPOTTER' && $toUser->getType() != 'SPOTTER') {
				$resFromUser = $userParse->updateField($currentUser->getObjectId(), 'following', array($toUser->getObjectId()), true, 'add', '_User');
			}
			if ($resFromUser instanceof Error) {
				#TODO
				//rollback
				$this->response(array('status' => 'XXXXX'), 503);
			}
			
			#TODO
			$this->sendMailNotification('daniele.caldelli@gmail.com'/*$toUser->getEmail()*/, $controllers['SBJ'], file_get_contents(STDHTML_DIR . $HTMLFile)); //devi prima richiamare lo user
			$this->response(array($controllers['RELSAVED']), 200);
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
		$activity->setType($type);
		$activity->setToUser($toUserId);
		$activity->setFromUser($currentUserId);
		$activity->setStatus($status);
		$activity->setRead(false);
		return $activity;
    }

}

?>