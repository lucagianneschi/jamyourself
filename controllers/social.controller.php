<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di operazioni social legate all'utente
 * \details		controller di utilities riferite alle operazioni di tipo social sulla classe utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	SocialController class 
 * \details	controller di utilities riferite alla classe utente
 */
class SocialController extends REST {

    /**
     * \fn		linkUser()
     * \brief   link the user account with a Social Network
     * \todo
     */
    public function linkUser() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            }

            //controllo i parametri
            $socialNetworkAdmitted = array('facebook');
            if (!isset($this->request['socialNetworkType'])) {
                $this->response(array('status' => $controllers['NOSOCIALNETUNSPECIFIED']), 403);
            } elseif (!in_array($this->request['socialNetworkType'], $socialNetworkAdmitted)) {
                $this->response(array('status' => $controllers['INVALIDSOCIALNET']), 403);
            } elseif (!isset($this->request['userID'])) {
                $this->response(array('status' => $controllers['NOUSERID']), 403);
            } elseif (!isset($this->request['accessToken'])) {
                $this->response(array('status' => $controllers['NOSESSIONTOKEN']), 403);
            } elseif (!isset($this->request['expiresIn'])) {
                $this->response(array('status' => $controllers['NOEXPIRED']), 403);
            }

            require_once CLASSES_DIR . 'userParse.class.php';

            $currentUser = $_SESSION['currentUser'];
            $socialNetworkType = $this->request['socialNetworkType'];
            $id = $this->request['userID'];
            $access_token = $this->request['accessToken'];
            $expiresIn = $this->request['expiresIn'];
            $expiration_date = date('Y-m-d\TH:i:s\Z', time() + $expiresIn);
            $authData = array('type' => $socialNetworkType,
                'authData' => array('id' => $id,
                    'access_token' => $access_token,
                    'expiration_date' => $expiration_date));
            $userParse = new UserParse();
            $res = $userParse->linkUser($currentUser, $authData);
            if ($res instanceof Error) {
                $this->response(array('status' => $controllers['NOLINK']), 503);
            }

            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRecord(null);
            $activity->setRead(true);
            $activity->setSong(null);
            $activity->setStatus('A');
            $activity->setToUser(null);
            $activity->setType('ACCOUNTLINKED');
            $activity->setUserStatus(null);
            $activity->setVideo(null);
            $activityParse = new ActivityParse();
            $resAct = $activityParse->saveActivity($activity);
            if ($resAct instanceof Error) {
                $this->response(array($controllers['NOACSAVE']), 503);
            }
            $this->response(array($controllers['OKSOCIALLINK']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    /**
     * \fn		loginUser()
     * \brief   login the user with a Social Network account
     * \todo
     */
    public function loginUser() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            }

            //controllo i parametri
            $socialNetworkAdmitted = array('facebook');
            if (!isset($this->request['socialNetworkType'])) {
                $this->response(array('status' => $controllers['NOSOCIALNETUNSPECIFIED']), 403);
            } elseif (!in_array($this->request['socialNetworkType'], $socialNetworkAdmitted)) {
                $this->response(array('status' => $controllers['INVALIDSOCIALNET']), 403);
            } elseif (!isset($this->request['userID'])) {
                $this->response(array('status' => $controllers['NOUSERID']), 403);
            } elseif (!isset($this->request['accessToken'])) {
                $this->response(array('status' => $controllers['NOSESSIONTOKEN']), 403);
            } elseif (!isset($this->request['expiresIn'])) {
                $this->response(array('status' => $controllers['NOEXPIRED']), 403);
            }

            require_once CLASSES_DIR . 'userParse.class.php';

            $currentUser = $_SESSION['currentUser'];
            $socialNetworkType = $this->request['socialNetworkType'];
            $id = $this->request['userID'];
            $access_token = $this->request['accessToken'];
            $expiresIn = $this->request['expiresIn'];
            $expiration_date = date('Y-m-d\TH:i:s\Z', time() + $expiresIn);
            $authData = array('type' => $socialNetworkType,
                'authData' => array('id' => $id,
                    'access_token' => $access_token,
                    'expiration_date' => $expiration_date));
            $userParse = new UserParse();
            $res = $userParse->socialLoginUser($authData);
            if ($res instanceof Error) {
                $this->response(array('status' => $res->getErrorMessage()), 503);
            }

            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
            $activity->setFromUser($currentUser->getObjectId());
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
            $resAct = $activityParse->saveActivity($activity);
            if ($resAct instanceof Error) {
                $this->response(array($controllers['NOACSAVE']), 503);
            }
            $this->response(array($controllers['OKLOGINSOCIAL']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    /**
     * \fn		unlinkUser()
     * \brief   unlink the user account from a Social Network
     * \todo
     */
    public function unlinkUser() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            }

            $socialNetworkAdmitted = array('facebook');
            if (!isset($this->request['socialNetworkType'])) {
                $this->response(array('status' => $controllers['NOSOCIALNETUNSPECIFIED']), 403);
            } elseif (!in_array($this->request['socialNetworkType'], $socialNetworkAdmitted)) {
                $this->response(array('status' => $controllers['INVALIDSOCIALNET']), 403);
            } 

            require_once CLASSES_DIR . 'userParse.class.php';

            $currentUser = $_SESSION['currentUser'];
            $socialNetworkType = $this->request['socialNetworkType'];
            $authData = array('type' => $socialNetworkType,
                'authData' => null);
            $userParse = new UserParse();
            $res = $userParse->unlinkUser($currentUser, $authData);
            if ($res instanceof Error) {
                $this->response(array('status' => $controllers['NOUNLINK']), 503);
            }
            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
            $activity->setFromUser($currentUser->getObjectId());
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
            $resAct = $activityParse->saveActivity($activity);
            if ($resAct instanceof Error) {
                $this->response(array($controllers['NOACSAVE']), 503);
            }
            $this->response(array($controllers['OKSOCIALUNLINK']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

}

?>