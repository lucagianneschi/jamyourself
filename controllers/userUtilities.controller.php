<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di operazioni legate all'utente
 * \details		controller di utilities riferite alla classe utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		Fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');



require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	UserUtilitiesController class 
 * \details	controller di utilities riferite alla classe utente
 */
class UserUtilitiesController extends REST {

    /**
     * \fn      createActivity($type, $fromUser)
     * \brief   private function to create ad hoc activity
     * \param   $type, $fromUser
     */
    private function createActivity($type, $fromUser) {
	require_once CLASSES_DIR . 'activity.class.php';
	$activity = new Activity();
	$activity->setActive(true);
	$activity->setAlbum(null);
	$activity->setComment(null);
	$activity->setCounter(0);
	$activity->setEvent(null);
	$activity->setFromUser($fromUser);
	$activity->setImage(null);
	$activity->setPlaylist(null);
	$activity->setQuestion(null);
	$activity->setRecord(null);
	$activity->setRead(true);
	$activity->setSong(null);
	$activity->setStatus('A');
	$activity->setToUser(null);
	$activity->setType($type);
	$activity->setVideo(null);
	return $activity;
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
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userP = new UserParse();
	    $user = $userP->passwordReset($email);
	    if ($user instanceof Error) {
		$this->response(array('status' => $controllers['USERNOTFOUNDFORPASSRESET']), 503);
	    }
	    $activity = $this->createActivity('PASSWORDRESETREQUEST', $user->getObjectId());
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $res = $activityParse->saveActivity($activity);
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 503);
	    }
	    $this->response(array($controllers['OKPASSWORDRESETREQUEST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	public function updateSetting()
     * \brief   effettua l'update dell'array dei settings
     * \todo    
     */
    public function updateSetting() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($_SESSION['setting'])) {
		$this->response(array('status' => $controllers['NOSETTING']), 403);
	    }
	    $currentUser = $this->request['currentUser'];
	    $settings = $this->request['setting'];
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userP = new UserParse();
	    $res = $userP->updateField($currentUser->getObjectId(), 'settings', array($settings));
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOSETTINGUPDATE']), 503);
	    }
	    $activity = $this->createActivity("USERSETTINGSUPDATED", $currentUser->getObjectId());
	    $activityParse = new ActivityParse();
	    $resAct = $activityParse->saveActivity($activity);
	    if ($resAct instanceof Error) {
		$this->response(array('status' => $controllers['NOACSAVE']), 503); //ROLLBACK??
	    }
	    $this->response(array('SETTINGUPDATED'), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>