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
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
	session_start();
    }

    /**
     * \fn		linkSocialAccount()
     * \brief   link con l'account social
     * \todo    usare la sessione
     */
    public function linkSocialAccount() {
	try {
	    require_once PARSE_DIR . 'parse.php';
	    global $controllers;
	    
	    $objectId = $this->request['objectId'];
	    $userP = new UserParse();
	    $user = $userP->getUser($objectId);
	    if (get_class($user) == 'Error') {
		$this->response(array($user), 503);
	    } else {
		$sessionToken = $user->getSessionToken();
		$userLib = new parseUser();
		$userLib->linkAccounts($objectId, $sessionToken);

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
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		passwordReset()
     * \brief   esegue una richiesta di reset della password
     * \todo    usare la sessione
     */
    public function passwordReset() {
	try {
	    require_once PARSE_DIR . 'parse.php';
	    global $controllers;

	    $email = $this->request['email'];
	    
	    $userP = new UserParse();
	    $userP->where('email', $email);
	    $userP->where('active', true);
	    $userP->setLimit(1);
	    $user = $userP->getUsers();
	    if (get_class($user) == 'Error') {
		$this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	    } else {
		$userLib = new parseUser();
		$userLib->requestPasswordReset($email);

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
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		unLinkSocialAccount()
     * \brief   elimina il link con l'account social
     * \todo    usare la sessione
     */
    public function unLinkSocialAccount() {
	try {
	    require_once PARSE_DIR . 'parse.php';
	    global $controllers;
	    
	    $objectId = $this->request['objectId'];
	    $userP = new UserParse();
	    $user = $userP->getUser($objectId);
	    if (get_class($user) == 'Error') {
		$this->response(array($user), 503);
	    } else {
		$sessionToken = $user->getSessionToken();
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
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		public function updateSetting()
     * \brief   effettua l'update dell'array dei settings
     * \todo    usare la sessione
     */
    public function updateSetting() {
	try {
	    //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
		$this->response('', 406);
	    }
	    $userId = $this->request['objectId'];
	    $settings = $this->request['setting'];

	    $userP = new UserParse();
	    $user = $userP->getuser($userId);
	    if (get_class($user) == 'Error') {
		$this->response(array('Error: ' . $user->getMessage()), 503);
	    }
	    $res = $userP->updateField($userId, 'settings', array($settings));
	    if (get_class($res) == 'Error') {
		$this->response(array('Error: ' . $res->getMessage()), 503);
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
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

}

?>