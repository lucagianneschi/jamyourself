<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di login e logout
 * \details		effettua operazioni di login e logut utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		terminare la funzione logout e socialLogin
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	ReviewController class 
 * \details	controller di inserimento di una review 
 */
class AccessController extends REST {

    /**
     * \fn		login()
     * \brief   user login
     * \todo    usare la sessione
     */
    public function login() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    }
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $usernameOrEmail = $this->request['usernameOrEmail'];
	    $password = $this->request['password'];
	    $userParse = new UserParse();
	    $resLogin = $userParse->loginUser($usernameOrEmail, $password);
	    if ($resLogin instanceof Error) {
		$this->response(array('status' => $resLogin->getErrorMessage()), 406);
	    } else {
		require_once CLASSES_DIR . 'activity.class.php';
		require_once CLASSES_DIR . 'activityParse.class.php';
		$activity = new Activity();
		$activity->setActive(true);
		$activity->setAlbum(null);
		$activity->setComment(null);
		$activity->setCounter(0);
		$activity->setEvent(null);
		$activity->setFromUser($resLogin->getObjectId());
		$activity->setImage(null);
		$activity->setPlaylist(null);
		$activity->setQuestion(null);
		$activity->setRecord(null);
		$activity->setRead(true);
		$activity->setSong(null);
		$activity->setStatus('A');
		$activity->setToUser(null);
		$activity->setType('LOGGEDIN');
		$activity->setUserStatus(null);
		$activity->setVideo(null);
		$activityParse = new ActivityParse();
		$activityParse->saveActivity($activity);
		$_SESSION['currentUser'] = $resLogin;
		$this->response(array($controllers['OKLOGIN']), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		logout()
     * \brief   user logout
     * \todo    usare la sessione
     */
    public function logout() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $currentUserId = $currentUser->getObjectId();
	    $_SESSION['currentUser'] = null;
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($currentUserId);
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRecord(null);
	    $activity->setRead(true);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType('LOGGEDOUT');
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $res = $activityParse->saveActivity($activity);
	    if ($res instanceof Error) {
		//rifaccio login??
	    }
	    $this->response(array($controllers['OKLOGOUT']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	sociaLogin()
     * \brief   login con account Social
     * \todo    implementare la sociaLogin nella UserParse
     */
    public function sociaLogin() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }

	    require_once PARSE_DIR . 'parse.php';
	    $userLib = new parseUser();
	    $logingSocial = $userLib->socialLogin();
	    if ($logingSocial instanceof ParseLibraryException) {
		$this->response(array('SOCIALLOGINERR'), 503);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser(null); //come faccio a ricavarlo da questa funzione??
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRecord(null);
	    $activity->setRead(true);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType('SOCIALLOGGEDIN');
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $res = $activityParse->saveActivity($activity);
	    if ($res instanceof Error) {
		$this->response(array($controllers['NOACSAVE']), 503);
	    }
	    $this->response(array($controllers['OKLOGINSOCIAL']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>