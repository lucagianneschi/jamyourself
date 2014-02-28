<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento playlist utente
 * \details		Recupera la playlist utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		comprendere i profili premium
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * \brief	PlaylistInfoBox class 
 * \details	box to display user's playlist info in each page of the website 
 */
class PlaylistInfoBox {

    public $error = null;
    public $playlistArray = array();

    /**
     * \fn	init()
     * \brief	Init PlaylistInfoBox instance
     * \return	playlistInfoBox
     */
    public function init() {
	$user = $_SESSION['currentUser'];
	$playlists = selectPlaylists(null, array('fromuser' => $user->getId()));
	if ($playlists instanceof Error) {
	    $this->error = $playlists->getErrorMessage();
	}
	$this->playlistArray = $playlists;
    }

}

/**
 * \brief	PlaylistSongBox class 
 * \details	box to display user's playlist song info 
 */
class PlaylistSongBox {

    public $error = null;
    public $songArray = array();

    /**
     * \fn	init($playlistId, $sonsArray)
     * \brief	Init PlaylistSongBox instance
     * \return	playlistSongBox
     * \todo	terminare funzione prendere songs che stanno dentro la playlist
     */
    public function init($playlistId) {
	$songs = selectSongsInPlaylist($playlistId, 20, 0);
	if ($songs instanceof Error) {
	    $this->error = $songs->getErrorMessage();
	}
	$this->songArray = $songs;
    }

}

?>