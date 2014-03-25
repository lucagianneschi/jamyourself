<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'update.service.php';

/**
 * LoveController class
 * controller di love/unlove
 * 
 * @author		Daniele Caldelli
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */

/**
 * LoveController class 
 * controller di love/unlove
 */
class LoveController extends REST {

    /**
     * increments loveCounter property of an istance of a class
     * @todo    invio mail? creazione notifica per proprietario media
     */
    public function incrementLove() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
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
	    $fromuserId = $_SESSION['id'];
	    $classType = $this->request['classType'];
	    $id = $this->request['id'];
	    $toUserObjectId = $this->request['objectIdUser']; //serve per la notifica
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    if (existsRelation($connection, 'user', $fromuserId, strtolower($classType), $id, 'LOVE')) {
		$this->response(array('status' => 'ALREADYLOVED'), 400);
	    }
	    $loveCounter = update($connection, strtolower($classType), array('updatedat' => date('Y-m-d- H:i:s')), array('lovecounter' => 1), null, $id);
	    if (!$loveCounter) {
		$this->response(array('status' => $controllers['LOVEPLUSERR']), 503);
	    }
	    $relation = createRelation($connectionService, 'user', $fromuserId, strtolower($classType), $id, 'LOVE');
	    if (!$relation) {
		$this->response(array('status' => $controllers['LOVEPLUSERR']), 503);
	    }
	    $connectionService->disconnect($connection);
	    $this->response(array('status' => $controllers['LOVE']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * decrements loveCounter property of an istance of a class
     * @todo    eliminare la relazione tra user e oggetto lovvato
     */
    public function decrementLove() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
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
	    $fromuserId = $_SESSION['id'];
	    $classType = $this->request['classType'];
	    $id = $this->request['id'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    if (!existsRelation($connectionService, 'user', $fromuserId, strtolower($classType), $id, 'LOVE')) {
		$this->response(array('status' => 'NOLOVE'), 400);
	    }
	    $loveCounter = update($connection, strtolower($classType), array('updatedat' => date('Y-m-d- H:i:s')), null, array('lovecounter' => 1), $id);
	    if (!$loveCounter) {
		$this->response(array('status' => $controllers['LOVEPLUSERR']), 503);
	    }
	    //@todo eliminare rekazione tra utente e oggetto lovvato
	    $relation = createRelation($connectionService, 'user', $fromuserId, strtolower($classType), $id, 'LOVE');
	    if (!$relation) {
		$this->response(array('status' => $controllers['LOVEPLUSERR']), 503);
	    }
	    $connectionService->disconnect($connection);
	    $this->response(array('status' => $controllers['UNLOVE']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

}

?>