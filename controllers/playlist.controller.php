<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'delete.service.php';

/**
 * PlaylistController class 
 * gestisce l'inserimento e la cancellazione di una song dalla tracklist di una playlist
 * 
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class PlaylistController extends REST {

    public $config;

    /**
     * load config file for the controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "playlistController.config.json"), false);
    }

    /**
     * add song to playlist
     * @todo    prevedere rollback e testare
     */
    public function addSong() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    } elseif (!isset($this->request['playlistId'])) {
		$this->response(array('status' => $controllers['NOPLAYLISTID']), 403);
	    }
	    $playlistId = $this->request['playlistId'];
	    $songId = $this->request['songId'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $song = insertSongInPlayslist($connection, $songId, $playlistId);
	    $songCounter = update($connection, 'playlist', array('updatedat' => date('Y-m-d H:i:s')), array('songcounter' => 1), null, $playlistId);
	    $relation = createRelation($connectionService, 'song', $songId, 'playlist', $playlistId, 'ADDTOPLAYLIST');
	    if ($song === false || $relation === false || $songCounter === false) {
		$this->response(array('status' => $controllers['PLAYLISTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * remove song to playlist 
     * @todo   
     */
    public function removeSong() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    }
	    $playlistId = $this->request['playlistId'];
	    $songId = $this->request['songId'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $song = false;
	    $songCounter = update($connection, 'playlist', array('updatedat' => date('Y-m-d H:i:s')), null, array('songcounter' => 1), $playlistId);
	    $relation = deleteRelation($connection, 'song', $songId, 'playlist', $playlistId, 'ADDTOPLAYLIST');
	    if ($song === false || $relation === false || $songCounter === false) {
		$this->response(array('status' => $controllers['PLAYLISTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>