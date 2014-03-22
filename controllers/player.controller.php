<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'insert.service.php';
/**
 * PlayerController class
 * controller di inserimento commenti
 * 
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */

/**
 * controller del player musicale
 */
class PlayerController extends REST {

    /**
     * add song to playlist  
     */
    public function play() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    }
	    $songId = $this->request['id'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    $relation = createRelation($connection, 'user', $_SESSION['id'], 'song', $songId, 'PLAY');
	    if (!$relation) {
		$this->response(array('status' => $controllers['NODEERROR']), 503);
	    }
	    $connectionService->disconnect($connection);
	    $this->response(array($controllers['SONGPLAYED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>