<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * PlaylistInfoBox class, box to display user's playlist info in each page of the website
 * Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class PlaylistInfoBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di playlist
     */
    public $playlistArray = array();

    /**
     * PlaylistInfoBox init
     */
    public function init() {
	$startTimer = microtime();
	$userId = $_SESSION['id'];
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$playlists = selectPlaylists($connection, null, array('fromuser' => $userId));
	if ($playlists === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectPlaylists"');
	    $this->error = 'Unable to perform selectPlaylists';
	}
	$this->playlistArray = $playlists;
    }

}

/**
 * PlaylistSongBox class, box to display user's playlist info in each page of the website
 * Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class PlaylistSongBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di song
     */
    public $songArray = array();

    /**
     * Init PlaylistSongBox instance
     * @param	int $playlistId
     */
    public function init($playlistId) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$songs = selectSongsInPlaylist($connection, $playlistId, 20, 0);
	if ($songs === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectSongsInPlaylist"');
	    $this->error = 'Unable to perform selectSongsInPlaylist';
	}
	$this->songArray = $songs;
    }

}

?>