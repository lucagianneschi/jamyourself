<?php

/* ! \par		Info Generali:
 * @author		Daniele Caldelli
 * @version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di love/unlove 
 * \details		incrementa/decrementa il loveCounter di una classe e istanza corrispondente activity
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	LoveController class 
 * \details	controller di love/unlove
 */
class LoveController extends REST {

    /**
     * \fn		incrementLove()
     * \brief   increments loveCounter property of an istance of a class
     * \todo    usare la sessione, prendere il toUser per la incrementLove, poichè il propietario del media deve avere notifica
     */
    public function incrementLove() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    $classTypeAdmitted = array('Album', 'Comment', 'Event', 'Image', 'Record', 'Song', 'Video');
	    if (!isset($this->request['classType'])) {
		$this->response(array('status' => 'NOCLASSTYPE'), 400);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => 'NOOBJECTID'), 400);
	    } elseif (!in_array($this->request['classType'], $classTypeAdmitted)) {
		$this->response(array('status' => 'CLASSTYPEKO'), 400);
	    } elseif (!isset($this->request['objectIdUser'])) {
		$this->response(array('status' => 'NOUSERID'), 400);
	    }
	    $fromuser = $_SESSION['currentUser'];
	    $classType = $this->request['classType'];
	    $id = $this->request['id'];
	    $toUserObjectId = $this->request['objectIdUser'];

	    //controllo se non ho già lovvato
	    if ($this->isLoved($fromuser->getId(), $id, $classType)) {
		$this->response(array('status' => 'ALREADYLOVED'), 500);
	    }
	    //CREO ACTIVITY DI LOVE CHE LEGA UTENTE e oggetto
	    //INCREMENTO LOVECOUNTER DELL'OGGETTO LOVVATO
	    switch ($classType) {
		case 'Album':


		    break;
		case 'Comment':

		    break;
		case 'Event':

		    break;
		case 'Image':

		    break;
		case 'Record':

		    break;
		case 'Song':

		    break;
		case 'Video':

		    break;
	    }
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['LOVEPLUSERR']), 503);
	    } else {
		
	    }
	    $this->response(array('status' => $res), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * \fn		decrementLove()
     * \brief   decrements loveCounter property of an istance of a class
     * \todo    usare la sessione
     */
    public function decrementLove() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    $classTypeAdmitted = array('Album', 'Comment', 'Event', 'Image', 'Record', 'Song', 'Video');
	    if (!isset($this->request['classType'])) {
		$this->response(array('status' => 'NOCLASSTYPE'), 400);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => 'NOOBJECTID'), 400);
	    } elseif (!in_array($this->request['classType'], $classTypeAdmitted)) {
		$this->response(array('status' => 'CLASSTYPEKO'), 400);
	    } elseif (!isset($this->request['objectIdUser'])) {
		$this->response(array('status' => 'NOUSERID'), 400);
	    }
	    $fromuser = $_SESSION['currentUser'];
	    $classType = $this->request['classType'];
	    $id = $this->request['id'];
	    $toUserObjectId = $this->request['objectIdUser'];
	    //elimino ACTIVITY DI LOVE CHE LEGA UTENTE e oggetto
	    //deCREMENTO LOVECOUNTER DELL'OGGETTO LOVVATO
	    
	    
	    #TODO
	    //devo farmi passare questo per poter avere la notifica
	    //$touser = $this->request['toUser'];
	    //controllo se non ho già lovvato
	    if (!$this->isLoved($fromuser->getId(), $id, $classType)) {
		$this->response(array('status' => 'NOLOVE'), 400);
	    }
	    switch ($classType) {
		case 'Album':

		    break;
		case 'Comment':

		    break;
		case 'Event':

		    break;
		case 'Image':

		    break;
		case 'Record':

		    break;
		case 'Song':

		    break;
		case 'Video':

		    break;
	    }
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['LOVEMINUSERR']), 503);
	    } else {
		
	    }
	    $this->response(array('status' => $res), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    private function isLoved($objectIdUser, $id, $classType) {
	switch ($classType) {
	    case 'Album':

		break;
	    case 'Comment':

		break;
	    case 'Event':

		break;
	    case 'Image':

		break;
	    case 'Record':

		break;
	    case 'Song':

		break;
	    case 'Video':

		break;
	}
	$loved = in_array(array()) ? true : false;
	return $loved;
    }

}

?>