<?php

/**
 * RelationController class
 * controller di invio/ricezione delle relazioni
 * 
 * @author		Daniele Caldelli
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'connection.service.php';

/**
 * Controller per invio e ricezione relazioni
 * 
 * @todo        introdurre le rollback per le varie funzioni
 */
class RelationController extends REST {

    /**
     * accept relationship request
     * fa update della richiesta di relazione e la mette accettata
     * scrive la relazione sul DB a grafo con il tipo corrispondente
     * 
     * @todo    test
     */
    public function acceptRelation() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUserId'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }

	    $currentUserId = $_SESSION['id'];
	    $id = $this->request['id'];
	    $toUserId = $this->request['toUserId'];

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $touser = $userParse->getUser($toUserId);

	    if ($currentUserId == $touser->getId()) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }
	    require_once SERVICES_DIR . 'select.service.php';
	    //definire il relationType
	    if (!existsRelation('user', $currentUser->getId(), 'user', $touser->getId(), $relationType)) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
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
     * decline relationship request
     * fa update della richiesta di relazione e la mette a declinata
     * non scrive niente sul DB a grafo
     * 
     * @todo    test
     */
    public function declineRelation() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }

	    $id = $this->request['id'];

	    //metti la relazione a RIFIUTATA e non fai altro

	    $this->response(array('status' => $controllers['RELDECLINED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * remove an existing relationship
     * fa update della richiesta di relazione e la mette cancellata
     * cancella la relazione sul DB a grafo con il tipo corrispondente
     * 
     * @todo    test
     */
    public function removeRelation() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUserId'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $currentUserId = $_SESSION['id'];
	    $id = $this->request['id'];
	    $toUserId = $this->request['toUserId'];


	    if (!existsRelation('user', $currentUserId, 'user', $touser->getId(), $relationType)) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }




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
     * send request for relationships;
     * scrive su apposita tabella una richiesta di relazione in formato pending,
     * invia mail al destinatario della richiesta;
     * se sono 2 SPOTTER manda richiesta di friendship, 
     * se sono SPOTTER e PROFESSIONAL effettua following,
     * se sono già in relazione genera errore,
     * se sono PROFESSIONAL e PROFESSIONAL effettua collaboration
     * 
     * @todo    devi mettere sulla tabella la realzione richiesta come pending
     */
    public function sendRelation() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $currentUserId = $_SESSION['id'];
	    $currentUserType = $_SESSION['type'];
	    $toUserId = $this->request['toUser'];
	    if ($currentUserId == $toUserId) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    $touser = selectUsers($connection, $toUserId);
	    if ($currentUserType == 'SPOTTER') {
		if ($touser->getType() == 'SPOTTER') {
		    $type = 'FRIENDSHIPREQUEST';
		    $relationType = 'friend';
		    $status = 'P';
		    $HTMLFile = $mail_files['FRIENDSHIPREQUESTEMAIL'];
		} else {
		    $type = 'FOLLOWING';
		    $relationType = 'following';
		    $status = 'A';
		    $HTMLFile = $mail_files['FOLLOWINGEMAIL'];
		}
	    } else {
		if ($touser->getType() == 'SPOTTER') {
		    $this->response(array('status' => $controllers['RELDENIED']), 401);
		} else {
		    $type = 'COLLABORATIONREQUEST';
		    $relationType = 'collaboration';
		    $status = 'P';
		    $HTMLFile = $mail_files['COLLABORATIONREQUESTEMAIL'];
		}
	    }
	    if (!existsRelation('user', $currentUserId, 'user', $toUserId, $relationType)) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    //scrivo sul DB relazionale la relazione in formato pending
	    $relationRequest = false;
	    if ($relationRequest === false) {
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    sendMailForNotification($touser->getEmail(), $controllers['SBJ'], file_get_contents(STDHTML_DIR . $HTMLFile)); //devi prima richiamare lo user
	    $this->response(array($controllers['RELREQUESTSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>