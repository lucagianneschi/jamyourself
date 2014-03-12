<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		0.3
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento playlist utente
 * \details		Recupera la playlist utente
 * \par			Commenti:
 * @warning
 * @bug
 * @todo		comprendere i profili premium
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';

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

    public $error = null;
    public $playlistArray = array();

    /**
     * PlaylistInfoBox init
     */
    public function init() {
	$userId = $_SESSION['id'];
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$playlists = selectPlaylists($connection, null, array('fromuser' => $userId));
	if ($playlists === false) {
	    $this->error = 'Errore nella query';
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

    public $error = null;
    public $songArray = array();

    /**
     * Init PlaylistSongBox instance
     * @param	int $playlistId
     */
    public function init($playlistId) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$songs = selectSongsInPlaylist($connection, $playlistId, 20, 0);
	if ($songs === false) {
	    $this->error = 'Errore nella query';
	}
	$this->songArray = $songs;
    }

}

?>
