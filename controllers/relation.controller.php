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
require_once SERVICES_DIR . 'select.service.php';

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
     * @todo    modificare il campo di accettazione della richiesta
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
	    $currentUserType = $_SESSION['type'];
	    $id = $this->request['id'];
	    $toUserId = $this->request['toUserId'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $touser = selectUsers($connection, $toUserId);
	    if ($currentUserId == $touser->getId()) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }
	    if ($currentUserType == 'SPOTTER' && $touser->getType() == 'SPOTTER') {
		$relationType = 'FRIENDSHIP';
	    } elseif ($currentUserType != 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$relationType = 'COLLABORATION';
	    } else {
		$relationType = 'FOLLOWING';
	    }
	    if (!existsRelation('user', $currentUserId, 'user', $touser->getId(), $relationType)) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }
	    // devi fare prima update della richiesta e mandarla ad Accettata
	    if ($currentUser->getType() == 'SPOTTER' && $touser->getType() == 'SPOTTER') {
		$resToUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), array('friendshipcounter' => 1), null, $toUserId);
		$resFromUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), array('friendshipcounter' => 1), null, $currentUserId);
		$relation = createRelation($connectionService, 'user', $toUserId, 'user', $currentUserId, 'FRIENDSHIP');
		$HTMLFile = $mail_files['FRIENDSHIPACCEPTEDEMAIL'];
	    } elseif ($currentUser->getType() != 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$counter = ($touser->getType() == 'VENUE') ? 'venuecounter' : 'jammercounter';
		$resToUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), array('collaborationcounter' => 1, $counter => 1), null, $toUserId);
		$resFromUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), array('collaborationcounter' => 1, $counter => 1), null, $currentUserId);
		$relation = createRelation($connectionService, 'user', $toUserId, 'user', $currentUserId, 'COLLABORATION');
		$HTMLFile = $mail_files['COLLABORATIONACCEPTEDEMAIL'];
	    }
	    if ($resToUserF === false || $relation === false || $resFromUserF === false) {
		$this->response(array('status' => $controllers['ACCEPTRELERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
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
	    $currentUserType = $_SESSION['type'];
	    $id = $this->request['id'];
	    $toUserId = $this->request['toUserId'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $touser = selectUsers($connection, $toUserId);
	    if ($currentUserId == $touser->getId()) {
		$this->response(array('status' => $controllers['SELF']), 503);
	    }
	    if ($currentUserType == 'SPOTTER' && $touser->getType() == 'SPOTTER') {
		$relationType = 'FRIENDSHIP';
	    } elseif ($currentUserType != 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$relationType = 'COLLABORATION';
	    } else {
		$relationType = 'FOLLOWING';
	    }
	    if (!existsRelation('user', $currentUserId, 'user', $touser->getId(), $relationType)) {
		$this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
	    }
	    if ($currentUserType == 'SPOTTER' && $touser->getType() == 'SPOTTER') {
		$resToUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), null, array('friendshipcounter' => 1), $toUserId);
		$resFromUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), null, array('friendshipcounter' => 1), $currentUserId);
		$relation = deleteRelation($connectionService, 'user', $toUserId, 'user', $currentUserId, 'FRIENDSHIP');
	    } elseif ($currentUserType != 'SPOTTER' && $touser->getType() != 'SPOTTER') {
		$counter = ($touser->getType() == 'VENUE') ? 'venuecounter' : 'jammercounter';
		$resToUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), null, array('collaborationcounter' => 1, $counter => 1), $toUserId);
		$resFromUserF = update($connection, 'user', array('updatedat' => date('Y-m-d H:i:s')), null, array('collaborationcounter' => 1, $counter => 1), $currentUserId);
		$relation = deleteRelation($connectionService, 'user', $toUserId, 'user', $currentUserId, 'COLLABORATION');
	    }
	    if ($resToUserF === false || $relation === false || $resFromUserF === false) {
		$this->response(array('status' => $controllers['DELETERELERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
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