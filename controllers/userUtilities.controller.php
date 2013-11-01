<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di operazioni lgate all'utente
 * \details		controller di utilities riferite alla classe utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once DEBUG_DIR . 'debug.php';

/**
 * \brief	UserUtilitiesController class 
 * \details	controller di utilities riferite alla classe utente
 */
class UserUtilitiesController extends REST {

    /**
     * \fn		linkSocialAccount()
     * \brief   link con l'account social
     * \todo    usare la sessione
     */
    public function linkSocialAccount() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $objectId = $currentUser->getObjectId();
	    $sessionToken = $currentUser->getSessionToken();
	    $userP = new UserParse();
	    $user = $userP->getUser($objectId);
	    if ($user instanceof Error) {//questo controllo posso ometterlo, se l'utente è in sessione esiste
		$this->response(array('status' => $controllers['USERNOTFOUND']), 503);
	    } else {
		require_once PARSE_DIR . 'parse.php';
		$userLib = new parseUser();
		$link = $userLib->linkAccounts($objectId, $sessionToken);
		if ($link instanceof ParseLibraryException) {
		    $this->response(array('NOLINK'), 503);
		}
		$activity = new Activity();
		$activity->setActive(true);
		$activity->setAlbum(null);
		$activity->setComment(null);
		$activity->setCounter(0);
		$activity->setEvent(null);
		$activity->setFromUser($objectId);
		$activity->setImage(null);
		$activity->setPlaylist(null);
		$activity->setQuestion(null);
		$activity->setRecord(null);
		$activity->setRead(true);
		$activity->setSong(null);
		$activity->setStatus('A');
		$activity->setToUser(null);
		$activity->setType('SOCIALACCOUNTLINKED');
		$activity->setUserStatus(null);
		$activity->setVideo(null);
		$activityParse = new ActivityParse();
		$activityParse->saveActivity($activity);
		$this->response(array($controllers['OKSOCIALLINK']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * \fn		passwordReset()
     * \brief   esegue una richiesta di reset della password
     * \todo    usare la sessione
     */
    public function passwordReset() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['email'])) {
		$this->response(array('status' => $controllers['NOEMAILFORRESETPASS']), 403);
	    }
	    $email = $this->request['email'];
	    $userP = new UserParse();
	    $user = $userP->passwordReset($email);
	    if ($user instanceof Error) {
		$this->response(array('status' => $controllers['USERNOTFOUNDFORPASSRESET']), 503);
	    }
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($user->getObjectId());
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRecord(null);
	    $activity->setRead(true);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType('PASSWORDRESETREQUEST');
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $activityParse->saveActivity($activity);
	    $this->response(array($controllers['OKPASSWORDRESETREQUEST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * \fn		unLinkSocialAccount()
     * \brief   elimina il link con l'account social
     * \todo    usare la sessione
     */
    public function unLinkSocialAccount() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $objectId = $currentUser->getObjectId();
	    $sessionToken = $currentUser->getSessionToken();
	    //spostare questa funzione dentro la userParse
	    require_once PARSE_DIR . 'parse.php';
	    $userLib = new parseUser();
	    $userLib->unlinkAccounts($objectId, $sessionToken, null);
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($objectId);
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRecord(null);
	    $activity->setRead(true);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType('SOCIALACCOUNTUNLINKED');
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $activityParse->saveActivity($activity);
	    $this->response(array($controllers['OKSOCIALUNLINK']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * \fn		public function updateSetting()
     * \brief   effettua l'update dell'array dei settings
     * \todo    usare la sessione
     */
    public function updateSetting() {
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    $userId = $this->request['objectId'];
	    $settings = $this->request['setting'];

	    $userP = new UserParse();
	    $user = $userP->getuser($userId);
	    if ($user instanceof Error) {
		$this->response(array('Error: ' . $user->getMessage()), 503);
	    }
	    $res = $userP->updateField($userId, 'settings', array($settings));
	    if ($res instanceof Error) {
		$this->response(array('NOSETTINGUPDATE'), 503);
	    }

	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($userId);
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRead(true);
	    $activity->setRecord(null);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType("USERSETTINGSUPDATED");
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    // if (get_class($resActivity) == 'Error') {
	    // $this->rollback($playlistId, $songId, 'remove');
	    // }
	    $this->response(array($resActivity), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}



?>