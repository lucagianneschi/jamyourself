<?php

/* ! \par		Info Generali:
 * @author		Daniele Caldelli
 * @version		1.0
 * @since		2013
 * @copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di invio/ricezione delle relazioni
 * \details		incrementa/decrementa il loveCounter di una classe e istanza corrispondente activity
 * \par			Commenti:
 * @warning
 * @bug
 * @todo		 terminare funzioni, verificare che siano state istanziate tutte le activity, fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
 

/**
 * \brief	RelationController class
 * \details	controller per invio e ricezione relazioni
 * @todo        introdurre le rollback per le varie funzioni
 */
class RelationController extends REST {

    /**
     * \fn	acceptRelationRequest()
     * \brief   accept relationship request
     * @todo    test
     */
    public function acceptRelation() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUserId'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }

	    $currentUser = $_SESSION['currentUser'];
	    $id = $this->request['id'];
	    $toUserId = $this->request['toUserId'];

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $touser = $userParse->getUser($toUserId);

	    if ($currentUser->getId() == $touser->getId()) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }
	    require_once SERVICES_DIR . 'select.service.php';
	    //definire il relationType
	    if(!existsRelation('user', $currentUser->getId(), 'user', $touser->getId(), $relationType)){
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }

	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();

	    //update status activity
	    $resStatus = $activityParse->updateField($id, 'status', 'A');
	    if ($resStatus instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }

	    //update read activity
	    $resRead = $activityParse->updateField($id, 'read', true);
	    if ($resRead instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackAcceptRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$this->response(array('status' => $message), 503);
	    }

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    //update relation
	    if ($currentUser->getType() == 'SPOTTER' && $touser->getType() == 'SPOTTER') {
		$resToUserF = $userParse->updateField($touser->getId(), 'friendship', array($currentUser->getId()), true, 'add', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getId(), 'friendship', array($touser->getId()), true, 'add', '_User');
		$HTMLFile = $mail_files['FRIENDSHIPACCEPTEDEMAIL'];
	    } elseif ($currentUser->getType() != 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$resToUserF = $userParse->updateField($touser->getId(), 'collaboration', array($currentUser->getId()), true, 'add', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getId(), 'collaboration', array($touser->getId()), true, 'add', '_User');
		$HTMLFile = $mail_files['COLLABORATIONACCEPTEDEMAIL'];
	    }
	    if ($resToUserF instanceof Error ||
		    $resFromUserF instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackAcceptRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$message2 = rollbackAcceptRelation('rollbackActivityRead', $id, 'read', false, '', '', '', '');
		$message3 = rollbackAcceptRelation('rollbackRelation', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER') {
		if ($touser->getType() == 'SPOTTER') {
		    $resToRelationCounter = null;
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'friendshipCounter', 1);
		} elseif ($touser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->incrementUser($touser->getId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->incrementUser($touser->getId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		$resToRelationCounter = $userParse->incrementUser($touser->getId(), 'collaborationCounter', 1);
		if ($touser->getType() == 'VENUE') {
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'jammerCounter', 1);
		}
	    }
	    if ($resToUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackAcceptRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$message2 = rollbackAcceptRelation('rollbackActivityRead', $id, 'read', false, '', '', '', '');
		$message3 = rollbackAcceptRelation('rollbackRelation', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER') {
		if ($touser->getType() == 'SPOTTER') {
		    $resToRelationCounter = null;
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'friendshipCounter', 1);
		} elseif ($touser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->incrementUser($touser->getId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->incrementUser($touser->getId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		$resToRelationCounter = $userParse->incrementUser($touser->getId(), 'collaborationCounter', 1);
		if ($touser->getType() == 'VENUE') {
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->incrementUser($touser->getId(), 'jammerCounter', 1);
		}
	    }

	    if ($resFromUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackAcceptRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$message2 = rollbackAcceptRelation('rollbackActivityRead', $id, 'read', false, '', '', '', '');
		$message3 = rollbackAcceptRelation('rollbackRelation', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message4 = rollbackAcceptRelation('rollbackIncrementToUser', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO'] ||
			$message4 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }

	    #TODO
	    sendMailForNotification($touser->getEmail(), $controllers['SBJOK'], file_get_contents(STDHTML_DIR . $HTMLFile)); //devi prima richiamare lo user
	    $this->response(array($controllers['RELACCEPTED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	declineRelationRequest()
     * \brief   decline relationship request
     * @todo    test
     */
    public function declineRelation() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }

	    $id = $this->request['id'];

	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();

	    $resStatus = $activityParse->updateField($id, 'status', 'R');
	    if ($resStatus instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }

	    $resRead = $activityParse->updateField($id, 'read', true);
	    if ($resRead instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackDeclineRelation($id, 'status', 'P');
		$this->response(array('status' => $message), 503);
	    }

	    $this->response(array('status' => $controllers['RELDECLINED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	removeRelationship ()
     * \brief   remove an existing relationship
     * @todo    test
     */
    public function removeRelation() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUserId'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $id = $this->request['id'];
	    $toUserId = $this->request['toUserId'];

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $touser = $userParse->getUser($toUserId);
	    //definire il relationType
	    if(!existsRelation('user', $currentUser->getId(), 'user', $touser->getId(), $relationType)){
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();

	    //update status activity
	    $resStatus = $activityParse->updateField($id, 'status', 'C');
	    if ($resStatus instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }

	    //update read activity
	    $resRead = $activityParse->updateField($id, 'read', true);
	    if ($resRead instanceof Error) {
		#TODO
		//rollback
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackRemoveRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$this->response(array('status' => $message), 503);
	    }
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();

	    //update relation: devo rimuovere anche il following
	    if ($currentUser->getType() == 'SPOTTER' && $touser->getType() == 'SPOTTER') {
		$resToUserF = $userParse->updateField($touser->getId(), 'friendship', array($currentUser->getId()), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getId(), 'friendship', array($touser->getId()), true, 'remove', '_User');
	    } elseif ($currentUser->getType() != 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$resToUserF = $userParse->updateField($touser->getId(), 'collaboration', array($currentUser->getId()), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getId(), 'collaboration', array($touser->getId()), true, 'remove', '_User');
	    } elseif ($currentUser->getType() == 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$resToUserF = $userParse->updateField($touser->getId(), 'following', array($currentUser->getId()), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getId(), 'followers', array($touser->getId()), true, 'remove', '_User');
	    }
	    if ($resToUserF instanceof Error || $resFromUserF instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackRemoveRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$message2 = rollbackRemoveRelation('rollbackActivityRead', $id, 'read', false, '', '', '', '');
		$message3 = rollbackRemoveRelation('rollbackRelation', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }
	    //decrement toUser counter
	    if ($currentUser->getType() == 'SPOTTER') {
		if ($touser->getType() == 'SPOTTER') {
		    $resToRelationCounter = null;
		    $resToUserFC = $userParse->decrementUser($touser->getId(), 'friendshipCounter', 1);
		} elseif ($touser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->decrementUser($touser->getId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->decrementUser($touser->getId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->decrementUser($touser->getId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->decrementUser($touser->getId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		$resToRelationCounter = $userParse->decrementUser($touser->getId(), 'collaborationCounter', 1);
		if ($touser->getType() == 'VENUE') {
		    $resToUserFC = $userParse->decrementUser($touser->getId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->decrementUser($touser->getId(), 'jammerCounter', 1);
		}
	    }
	    if ($resToUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackRemoveRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$message2 = rollbackRemoveRelation('rollbackActivityRead', $id, 'read', false, '', '', '', '');
		$message3 = rollbackRemoveRelation('rollbackRelation', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }
	    //increment currentUser counter
	    if ($currentUser->getType() == 'SPOTTER') {
		$resToRelationCounter = null;
		if ($touser->getType() == 'SPOTTER') {
		    $resFromUserFC = $userParse->decrementUser($currentUser->getId(), 'friendshipCounter', 1);
		} elseif ($touser->getType() == 'VENUE') {
		    $resFromUserFC = $userParse->decrementUser($currentUser->getId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->decrementUser($touser->getId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		if ($touser->getType() == 'SPOTTER') {
		    $resFromUserFC = $userParse->decrementUser($currentUser->getId(), 'followersCounter', 1);
		} elseif ($touser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->decrementUser($currentUser->getId(), 'collaborationCounter', 1);
		    $resToUserFC = $userParse->decrementUser($$currentUser->getId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->decrementUser($currentUser->getId(), 'collaborationCounter', 1);
		    $resToUserFC = $userParse->decrementUser($currentUser->getId(), 'jammerCounter', 1);
		}
	    }
	    if ($resFromUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackRemoveRelation('rollbackActivityStatus', $id, 'status', 'P', '', '', '', '');
		$message2 = rollbackRemoveRelation('rollbackActivityRead', $id, 'read', false, '', '', '', '');
		$message3 = rollbackRemoveRelation('rollbackRelation', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message4 = rollbackRemoveRelation('rollbackDecrementToUser', '', '', '', $currentUser->getId(), $currentUser->getType(), $touser->getId(), $touser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO'] ||
			$message4 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array($controllers['RELDELETED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	sendRelationRequest()
     * \brief   send request for relationships
     * @todo    test
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
	    if ($currentUser->getId() == $toUserId) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $touser = $userParse->getUser($toUserId);

	    //definire il relationType
	    if(!existsRelation('user', $currentUser->getId(), 'user', $touser->getId(), $relationType)){
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER') {
		if ($touser->getType() == 'SPOTTER') {
		    $type = 'FRIENDSHIPREQUEST';
		    $status = 'P';
		    $HTMLFile = $mail_files['FRIENDSHIPREQUESTEMAIL'];
		} else {
		    $type = 'FOLLOWING';
		    $status = 'A';
		    $HTMLFile = $mail_files['FOLLOWINGEMAIL'];
		}
	    } else {
		if ($touser->getType() == 'SPOTTER') {
		    $this->response(array('status' => $controllers['RELDENIED']), 401);
		} else {
		    $type = 'COLLABORATIONREQUEST';
		    $status = 'P';
		    $HTMLFile = $mail_files['COLLABORATIONREQUESTEMAIL'];
		}
	    }

	    $activity = $this->createActivity($type, $touser->getId(), $currentUser->getId(), $status);
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$resToUser = $userParse->updateField($touser->getId(), 'followers', array($currentUser->getId()), true, 'add', '_User');
	    }

	    if ($resToUser instanceof Error) {
		$this->response(array('status' => 'XXXXX'), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$resFromUser = $userParse->updateField($currentUser->getId(), 'following', array($touser->getId()), true, 'add', '_User');
	    }

	    if ($resFromUser instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackSendRelation($currentUser->getId(), $touser->getId());
		$this->response(array('status' => $message), 503);
	    }

	    #TODO
	    sendMailForNotification($touser->getEmail(), $controllers['SBJ'], file_get_contents(STDHTML_DIR . $HTMLFile)); //devi prima richiamare lo user
	    $this->response(array($controllers['RELSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	createActivity($type, $toUserId, $currentUserId, $status)
     * \brief   private function to create activity class instance
     * \param   $type, $toUserId, $currentUserId, $status
     */
    private function createActivity($type, $toUserId, $currentUserId, $status) {
	require_once CLASSES_DIR . 'activity.class.php';
	$activity = new Activity();
	$activity->setType($type);
	$activity->setTouser($toUserId);
	$activity->setFromuser($currentUserId);
	$activity->setStatus($status);
	$activity->setRead(false);
	return $activity;
    }

}

?>