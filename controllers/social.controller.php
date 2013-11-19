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
     * \fn		addShare()
     * \brief   increment the shareCounter of an object
     * \todo
     */
    public function addShare() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }

	    if (!isset($this->request['classType'])) {
		$this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }

	    require_once CLASSES_DIR . 'userParse.class.php';
	    $fromUser = $_SESSION['currentUser'];

	    $classType = $this->request['classType'];
	    $objectId = $this->request['objectId'];
	    $toUserObjectId = $this->request['toUser'];

	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $read = $fromUser->getObjectId() == $toUserObjectId ? true : false;
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setCounter(0);
	    $activity->setFromUser($fromUser->getObjectId());
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRead($read);
	    $activity->setStatus('A');
	    $activity->setToUser($toUserObjectId);
	    switch ($classType) {
		case 'Album':
		    require_once CLASSES_DIR . 'albumParse.class.php';
		    $albumParse = new AlbumParse();
		    $res = $albumParse->incrementAlbum($objectId, 'shareCounter', 1);
		    $activity->setAlbum($objectId);
		    $activity->setType('SHAREDALBUM');
		    break;
		case 'AlbumReview':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $res = $commentParse->incrementComment($objectId, 'shareCounter', 1);
		    $activity->setComment($objectId);
		    $activity->setType('SHAREDALBUMREVIEW');
		    break;
		case 'Event':
		    require_once CLASSES_DIR . 'eventParse.class.php';
		    $eventParse = new EventParse();
		    $res = $eventParse->incrementEvent($objectId, 'shareCounter', 1);
		    $activity->setEvent($objectId);
		    $activity->setType('SHAREDEVENT');
		    break;
		case 'EventReview':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $res = $commentParse->incrementComment($objectId, 'shareCounter', 1);
		    $activity->setComment($objectId);
		    $activity->setType('SHAREDEVENTREVIEW');
		    break;
		case 'Image':
		    require_once CLASSES_DIR . 'imageParse.class.php';
		    $imageParse = new ImageParse();
		    $res = $imageParse->incrementImage($objectId, 'shareCounter', 1);
		    $activity->setImage($objectId);
		    $activity->setType('SHAREDIMAGE');
		    break;
		case 'Record':
		    require_once CLASSES_DIR . 'recordParse.class.php';
		    $recordParse = new RecordParse();
		    $res = $recordParse->incrementRecord($objectId, 'shareCounter', 1);
		    $activity->setRecord($objectId);
		    $activity->setType('SHAREDRECORD');
		    break;
		case 'Song':
		    require_once CLASSES_DIR . 'songParse.class.php';
		    $songParse = new SongParse();
		    $res = $songParse->incrementSong($objectId, 'shareCounter', 1);
		    $activity->setSong($objectId);
		    $activity->setType('SHAREDSONG');
		    break;
	    }
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOUPDATESHARE']), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error) {
		    require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		    $message = rollbackSocialController($classType, $objectId);
		    $this->response(array('status' => $message), 503);
		}
	    }
	    $this->response(array($controllers['OKSHARECOUNTER']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

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

    private function rollback($classType, $objectId) {
	global $controllers;
	switch ($classType) {
	    case 'Album':
		require_once CLASSES_DIR . 'albumParse.class.php';
		$albumParse = new AlbumParse();
		$res = $albumParse->decrementAlbum($objectId, 'shareCounter', 1);
		break;
	    case 'AlbumReview':
		require_once CLASSES_DIR . 'commentParse.class.php';
		$commentParse = new CommentParse();
		$res = $commentParse->decrementComment($objectId, 'shareCounter', 1);
		break;
	    case 'Event':
		require_once CLASSES_DIR . 'eventParse.class.php';
		$eventParse = new EventParse();
		$res = $eventParse->decrementEvent($objectId, 'shareCounter', 1);
		break;
	    case 'EventReview':
		require_once CLASSES_DIR . 'commentParse.class.php';
		$commentParse = new CommentParse();
		$res = $commentParse->decrementComment($objectId, 'shareCounter', 1);
		break;
	    case 'Image':
		require_once CLASSES_DIR . 'imageParse.class.php';
		$imageParse = new ImageParse();
		$res = $imageParse->decrementImage($objectId, 'shareCounter', 1);
		break;
	    case 'Record':
		require_once CLASSES_DIR . 'recordParse.class.php';
		$recordParse = new RecordParse();
		$res = $recordParse->decrementRecord($objectId, 'shareCounter', 1);
		break;
	    case 'Song':
		require_once CLASSES_DIR . 'songParse.class.php';
		$songParse = new SongParse();
		$res = $songParse->decrementSong($objectId, 'shareCounter', 1);
		break;
	}
	if ($res instanceof Error) {
	    $this->response(array('status' => $controllers['ROLLKO']), 503);
	} else {
	    $this->response(array('status' => $controllers['ROLLOK']), 503);
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