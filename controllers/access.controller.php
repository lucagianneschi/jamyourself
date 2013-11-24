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
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	ReviewController class 
 * \details	controller di inserimento di una review 
 */
class AccessController extends REST {

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
        $activity->setUserStatus(null);
        $activity->setVideo(null);
        return $activity;
    }

    /**
     * \fn      login()
     * \brief   user login
     * \todo    
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
            }
            $activity = $this->createActivity('LOGGEDIN', $resLogin->getObjectId());
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activityParse = new ActivityParse();
            $activityParse->saveActivity($activity);
            $_SESSION['currentUser'] = $resLogin;
            $this->response(array($controllers['OKLOGIN']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn      logout()
     * \brief   user logout
     * \todo    
     */
    public function logout() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            }
            $currentUser = $_SESSION['currentUser'];
            $currentUserId = $currentUser->getObjectId();
            session_unset();
			session_destroy();
            $activity = $this->createActivity('LOGGEDOUT', $currentUserId);
            require_once CLASSES_DIR . 'activityParse.class.php';
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

}

?>