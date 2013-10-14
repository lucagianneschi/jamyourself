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
 * \brief	ReviewController class 
 * \details	controller di inserimento di una review 
 */
class AccessController extends REST {

    /**
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
	session_start();
    }

    /**
     * \fn		login()
     * \brief   user login
     * \todo    usare la sessione
     */
    public function login() {

	global $controllers;
	#TODO
	//in questa fase di debug, il fromUser lo passo staticamente e non lo recupero dalla session
	//questa sezione prima del try-catch dovrà sparire
	require_once CLASSES_DIR . 'user.class.php';
	$currentUser = new User('SPOTTER');
	$currentUser->setObjectId('GuUAj83MGH');
	global $controllers;

	try {
		//if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
			$this->response('', 406);
	    }
	
		$usernameOrEmail = $_REQUEST['username'];
	    $password = $_REQUEST['password'];
		
		$activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAccepted(true);
		$activity->setAlbum(null);
		$activity->setComment(null);		
	    $activity->setCounter(0);
		$activity->setEvent(null);
	    $activity->setFromUser($currentUser);
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
		
		$userParse = new UserParse();
		$resLogin = $userParse->loginUser($usernameOrEmail, $password);
	    if (get_class($resLogin) == 'Error') {
			$this->response(array($controllers['KOLOGIN']), 503);
	    } else {
			$activityParse = new ActivityParse();
			$activityParse->saveActivity($activity);
	    }
	    $this->response(array($controllers['OKLOGIN']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}
    }

    /**
     * \fn		logout()
     * \brief   user logout
     * \todo    usare la sessione
     */
    public function logout() {

	global $controllers;
	#TODO
	//in questa fase di debug, il fromUser e il toUser sono uguali e passati staticamente
	//questa sezione prima del try-catch dovrà sparire
	$userParse = new UserParse();
	$fromUser = $userParse->getUser($this->request['fromUser']);
	$toUser = $fromUser;

	try {
		//if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
			$this->response('', 406);
	    }
	
		$userId = $_REQUEST['userId'];
		
		$activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAccepted(true);
		$activity->setAlbum(null);
		$activity->setComment(null);		
	    $activity->setCounter(0);
		$activity->setEvent(null);
	    $activity->setFromUser($currentUser);
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
	
	    $resLogout = logout($userId); //questa funzione deve essere messa nella classe user che per ora non c'è
	    if (get_class($resLogout) == 'Error') {
			$this->response(array($controllers['KOLOGOUT']), 503);
	    } else {
			$activityParse = new ActivityParse();
			$activityParse->saveActivity($activity);
	    }
	    $this->response(array($controllers['OKLOGOUT']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}
    }

	 /**
     * \fn		sociaLogin()
     * \brief   login con account Social
     * \todo    tutto
     */
	    public function sociaLogin() {
			try {
				$userLib = new parseUser();
				try{
					$socialLogin = $userLib->socialLogin();
					
					$activity = new Activity();
					$activity->setActive(true);
					$activity->setAccepted(true);
					$activity->setAlbum(null);
					$activity->setComment(null);		
					$activity->setCounter(0);
					$activity->setEvent(null);
					$activity->setFromUser(null);
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
					$activityParse->saveActivity($activity);
					$this->response(array($controllers['OKLOGIN']), 200);
				} catch (Exception $e){
					$this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
				}
			}
		} catch (Exception $e){
			$this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}
	}
	
}

?>