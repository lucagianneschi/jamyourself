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
 * \todo		 terminare funzioni, verificare che siano state istanziate tutte le activity, fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CONTROLLERS_DIR . 'utilsController.php';
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

	    if ($currentUser->getObjectId() == $toUser->getObjectId()) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }

	    require_once SERVICES_DIR . 'relationChecker.service.php';
	    if (relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType())) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }

	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();

	    //update status activity
	    $resStatus = $activityParse->updateField($objectId, 'status', 'A');
	    if ($resStatus instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }

	    //update read activity
	    $resRead = $activityParse->updateField($objectId, 'read', true);
	    if ($resRead instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackAcceptRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$this->response(array('status' => $message), 503);
	    }

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    //update relation
	    if ($currentUser->getType() == 'SPOTTER' && $toUser->getType() == 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUser->getObjectId(), 'friendship', array($currentUser->getObjectId()), true, 'add', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getObjectId(), 'friendship', array($toUser->getObjectId()), true, 'add', '_User');
		$HTMLFile = $mail_files['FRIENDSHIPACCEPTEDEMAIL'];
	    } elseif ($currentUser->getType() != 'SPOTTER' && $toUser->getType() != 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUser->getObjectId(), 'collaboration', array($currentUser->getObjectId()), true, 'add', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getObjectId(), 'collaboration', array($toUser->getObjectId()), true, 'add', '_User');
		$HTMLFile = $mail_files['COLLABORATIONACCEPTEDEMAIL'];
	    }
	    if ($resToUserF instanceof Error ||
		    $resFromUserF instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackAcceptRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$message2 = rollbackAcceptRelation('rollbackActivityRead', $objectId, 'read', false, '', '', '', '');
		$message3 = rollbackAcceptRelation('rollbackRelation', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER') {
		if ($toUser->getType() == 'SPOTTER') {
		    $resToRelationCounter = null;
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'friendshipCounter', 1);
		} elseif ($toUser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->incrementUser($toUser->getObjectId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->incrementUser($toUser->getObjectId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		$resToRelationCounter = $userParse->incrementUser($toUser->getObjectId(), 'collaborationCounter', 1);
		if ($toUser->getType() == 'VENUE') {
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'jammerCounter', 1);
		}
	    }
	    if ($resToUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackAcceptRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$message2 = rollbackAcceptRelation('rollbackActivityRead', $objectId, 'read', false, '', '', '', '');
		$message3 = rollbackAcceptRelation('rollbackRelation', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER') {
		if ($toUser->getType() == 'SPOTTER') {
		    $resToRelationCounter = null;
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'friendshipCounter', 1);
		} elseif ($toUser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->incrementUser($toUser->getObjectId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->incrementUser($toUser->getObjectId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		$resToRelationCounter = $userParse->incrementUser($toUser->getObjectId(), 'collaborationCounter', 1);
		if ($toUser->getType() == 'VENUE') {
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->incrementUser($toUser->getObjectId(), 'jammerCounter', 1);
		}
	    }

	    if ($resFromUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackAcceptRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$message2 = rollbackAcceptRelation('rollbackActivityRead', $objectId, 'read', false, '', '', '', '');
		$message3 = rollbackAcceptRelation('rollbackRelation', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
		$message4 = rollbackAcceptRelation('rollbackIncrementToUser', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO'] ||
			$message4 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }

	    #TODO
	    sendMailForNotification('ghilarducci.alessandro@gmail.com'/* $toUser->getEmail() */, $controllers['SBJOK'], file_get_contents(STDHTML_DIR . $HTMLFile)); //devi prima richiamare lo user
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

	    $objectId = $this->request['objectId'];

	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();

	    $resStatus = $activityParse->updateField($objectId, 'status', 'R');
	    if ($resStatus instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }

	    $resRead = $activityParse->updateField($objectId, 'read', true);
	    if ($resRead instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackDeclineRelation($objectId, 'status', 'P');
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
     * \todo    test
     */
    public function removeRelation() {
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
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $objectId = $this->request['objectId'];
	    $toUserId = $this->request['toUserId'];

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $toUser = $userParse->getUser($toUserId);

	    require_once SERVICES_DIR . 'relationChecker.service.php';
	    if (!relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType())) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();

	    //update status activity
	    $resStatus = $activityParse->updateField($objectId, 'status', 'C');
	    if ($resStatus instanceof Error) {
		$this->response(array('status' => $controllers['NOACTUPDATE']), 503);
	    }

	    //update read activity
	    $resRead = $activityParse->updateField($objectId, 'read', true);
	    if ($resRead instanceof Error) {
		#TODO
		//rollback
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackRemoveRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$this->response(array('status' => $message), 503);
	    }
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();

	    //update relation: devo rimuovere anche il following
	    if ($currentUser->getType() == 'SPOTTER' && $toUser->getType() == 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUser->getObjectId(), 'friendship', array($currentUser->getObjectId()), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getObjectId(), 'friendship', array($toUser->getObjectId()), true, 'remove', '_User');
	    } elseif ($currentUser->getType() != 'SPOTTER' && $toUser->getType() != 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUser->getObjectId(), 'collaboration', array($currentUser->getObjectId()), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getObjectId(), 'collaboration', array($toUser->getObjectId()), true, 'remove', '_User');
	    } elseif ($currentUser->getType() == 'SPOTTER' && $toUser->getType() != 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUser->getObjectId(), 'following', array($currentUser->getObjectId()), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUser->getObjectId(), 'followers', array($toUser->getObjectId()), true, 'remove', '_User');
	    }
	    if ($resToUserF instanceof Error || $resFromUserF instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackRemoveRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$message2 = rollbackRemoveRelation('rollbackActivityRead', $objectId, 'read', false, '', '', '', '');
		$message3 = rollbackRemoveRelation('rollbackRelation', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }
	    //decrement toUser counter
	    if ($currentUser->getType() == 'SPOTTER') {
		if ($toUser->getType() == 'SPOTTER') {
		    $resToRelationCounter = null;
		    $resToUserFC = $userParse->decrementUser($toUser->getObjectId(), 'friendshipCounter', 1);
		} elseif ($toUser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->decrementUser($toUser->getObjectId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->decrementUser($toUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->decrementUser($toUser->getObjectId(), 'followingCounter', 1);
		    $resToUserFC = $userParse->decrementUser($toUser->getObjectId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		$resToRelationCounter = $userParse->decrementUser($toUser->getObjectId(), 'collaborationCounter', 1);
		if ($toUser->getType() == 'VENUE') {
		    $resToUserFC = $userParse->decrementUser($toUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->decrementUser($toUser->getObjectId(), 'jammerCounter', 1);
		}
	    }
	    if ($resToUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackRemoveRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$message2 = rollbackRemoveRelation('rollbackActivityRead', $objectId, 'read', false, '', '', '', '');
		$message3 = rollbackRemoveRelation('rollbackRelation', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
		$message = ($message1 == $controllers['ROLLKO'] ||
			$message2 == $controllers['ROLLKO'] ||
			$message3 == $controllers['ROLLKO']) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
		$this->response(array('status' => $message), 503);
	    }
	    //increment currentUser counter
	    if ($currentUser->getType() == 'SPOTTER') {
		$resToRelationCounter = null;
		if ($toUser->getType() == 'SPOTTER') {
		    $resFromUserFC = $userParse->decrementUser($currentUser->getObjectId(), 'friendshipCounter', 1);
		} elseif ($toUser->getType() == 'VENUE') {
		    $resFromUserFC = $userParse->decrementUser($currentUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToUserFC = $userParse->decrementUser($toUser->getObjectId(), 'jammerCounter', 1);
		}
	    } elseif ($currentUser->getType() != 'SPOTTER') {
		if ($toUser->getType() == 'SPOTTER') {
		    $resFromUserFC = $userParse->decrementUser($currentUser->getObjectId(), 'followersCounter', 1);
		} elseif ($toUser->getType() == 'VENUE') {
		    $resToRelationCounter = $userParse->decrementUser($currentUser->getObjectId(), 'collaborationCounter', 1);
		    $resToUserFC = $userParse->decrementUser($$currentUser->getObjectId(), 'venueCounter', 1);
		} else {
		    $resToRelationCounter = $userParse->decrementUser($currentUser->getObjectId(), 'collaborationCounter', 1);
		    $resToUserFC = $userParse->decrementUser($currentUser->getObjectId(), 'jammerCounter', 1);
		}
	    }
	    if ($resFromUserFC instanceof Error || $resToRelationCounter instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message1 = rollbackRemoveRelation('rollbackActivityStatus', $objectId, 'status', 'P', '', '', '', '');
		$message2 = rollbackRemoveRelation('rollbackActivityRead', $objectId, 'read', false, '', '', '', '');
		$message3 = rollbackRemoveRelation('rollbackRelation', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
		$message4 = rollbackRemoveRelation('rollbackDecrementToUser', '', '', '', $currentUser->getObjectId(), $currentUser->getType(), $toUser->getObjectId(), $toUser->getType());
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
		$this->response(array('status' => 'XXXXX'), 503);
	    }

	    if ($currentUser->getType() == 'SPOTTER' && $toUser->getType() != 'SPOTTER') {
		$resFromUser = $userParse->updateField($currentUser->getObjectId(), 'following', array($toUser->getObjectId()), true, 'add', '_User');
	    }

	    if ($resFromUser instanceof Error) {
		#TODO
		require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		$message = rollbackSendRelation($currentUser->getObjectId(), $toUser->getObjectId());
		$this->response(array('status' => $message), 503);
	    }

	    #TODO
	    sendMailForNotification('ghilarducci.alessandro@gmail.com'/* $toUser->getEmail() */, $controllers['SBJ'], file_get_contents(STDHTML_DIR . $HTMLFile)); //devi prima richiamare lo user
	    debug('', 'debug.txt', '6');
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
	$activity->setToUser($toUserId);
	$activity->setFromUser($currentUserId);
	$activity->setStatus($status);
	$activity->setRead(false);
	return $activity;
    }

}

?>