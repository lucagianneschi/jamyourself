<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di operazioni social legate all'utente
 * \details		controller di utilities riferite alle operazioni di tipo social sulla classe utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		FAre API su Wiki; implementare
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
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
     * \brief   increment the sharecounter of an object
     * \todo
     */
    public function addShare() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    if (!isset($this->request['classType'])) {
		$this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $fromuser = $_SESSION['id'];
	    $classType = $this->request['classType'];
	    $id = $this->request['id'];
	    $toUserObjectId = $this->request['toUser'];
	    switch ($classType) {
		case 'Album':
		    require_once CLASSES_DIR . 'album.class.php';
		    $albumParse = new AlbumParse();
		    $res = $albumParse->incrementAlbum($id, 'sharecounter', 1);

		    break;
		case 'AlbumReview':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $res = $commentParse->incrementComment($id, 'sharecounter', 1);

		    break;
		case 'Event':
		    require_once CLASSES_DIR . 'eventParse.class.php';
		    $eventParse = new EventParse();
		    $res = $eventParse->incrementEvent($id, 'sharecounter', 1);

		    break;
		case 'EventReview':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $res = $commentParse->incrementComment($id, 'sharecounter', 1);

		    break;
		case 'Image':
		    require_once CLASSES_DIR . 'imageParse.class.php';
		    $imageParse = new ImageParse();
		    $res = $imageParse->incrementImage($id, 'sharecounter', 1);

		    break;
		case 'Record':
		    require_once CLASSES_DIR . 'recordParse.class.php';
		    $recordParse = new RecordParse();
		    $res = $recordParse->incrementRecord($id, 'sharecounter', 1);

		    break;
		case 'Song':
		    require_once CLASSES_DIR . 'songParse.class.php';
		    $songParse = new SongParse();
		    $res = $songParse->incrementSong($id, 'sharecounter', 1);

		    break;
	    }
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOUPDATESHARE']), 503);
	    } else {

	    }
	    $this->response(array('status' => $controllers['OKSHARECOUNTER']), 200);
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
	    } elseif (!isset($_SESSION['id'])) {
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

	    $this->response(array('status' => $controllers['OKSOCIALLINK']), 200);
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


	    $this->response(array('status' => $controllers['OKLOGINSOCIAL']), 200);
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
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }

	    $socialNetworkAdmitted = array('facebook');
	    if (!isset($this->request['socialNetworkType'])) {
		$this->response(array('status' => $controllers['NOSOCIALNETUNSPECIFIED']), 403);
	    } elseif (!in_array($this->request['socialNetworkType'], $socialNetworkAdmitted)) {
		$this->response(array('status' => $controllers['INVALIDSOCIALNET']), 403);
	    }


	    $this->response(array('status' => $controllers['OKSOCIALUNLINK']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

}

?>