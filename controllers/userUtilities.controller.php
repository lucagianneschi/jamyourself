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
	
    }

    /**
     * \fn		passwordReset()
     * \brief   esegue una richiesta di reset della password
     * \todo    usare la sessione
     */
    public function passwordReset() {
	
    }

    /**
     * \fn		unLinkSocialAccount()
     * \brief   elimina il link con l'account social
     * \todo    usare la sessione
     */
    public function unLinkSocialAccount() {
	
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
	    $userId = $_REQUEST['userId'];
	    $settings = $_REQUEST['settings'];

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
	    $activity->setAccepted(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($fromUserId);
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