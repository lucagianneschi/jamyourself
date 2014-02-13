<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.2
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

/**
 * \brief	PlaylistInfoBox class 
 * \details	box to display user's playlist info in each page of the website 
 */
class PlaylistInfoBox {

    public $config;
    public $error;
    public $playlists;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "playlistBox.config.json"), false);
    }

    /**
     * \fn	init()
     * \brief	Init PlaylistInfoBox instance
     * \return	playlistInfoBox
     */
    public function init() {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	require_once CLASSES_DIR . 'playlist.class.php';
	require_once CLASSES_DIR . 'playlistParse.class.php';
	$playlist = new PlaylistParse();
	$playlist->wherePointer('fromUser', '_User', $currentUserId);
	$playlist->where('active', true);
	$playlist->orderByDescending('createdAt');
	$playlist->setLimit($this->config->limitForPlaylist);
	$playlists = $playlist->getPlaylists();
	if ($playlists instanceof Error) {
	    $this->error = $playlists->getErrorMessage();
	    $this->playlists = array();
	    return;
	} elseif (is_null($playlists)) {
	    $this->error = null;
	    $this->playlists = array();
	    return;
	} else {
	    $this->error = null;
	    $this->playlists = $playlists;
	}
    }

}

/**
 * \brief	PlaylistSongBox class 
 * \details	box to display user's playlist song info 
 */
class PlaylistSongBox {

    public $config;
    public $error;
    public $tracklist;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/playlist.config.json"), false);
    }

    /**
     * \fn	init($playlistId, $sonsArray)
     * \brief	Init PlaylistSongBox instance
     * \return	playlistSongBox
     */
    public function init($playlistId, $sonsArray) {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	require_once CLASSES_DIR . 'song.class.php';
	require_once CLASSES_DIR . 'songParse.class.php';
	$song = new SongParse();
	$song->whereRelatedTo('songs', 'Playlist', $playlistId);
	$song->where('active', true);
	$song->setLimit($this->config->limitForTracklist);
	$song->whereInclude('fromUser,record');
	$songs = $song->getSongs();
	if ($songs instanceof Error) {
	    $this->error = $songs->getErrorMessage();
	    $this->tracklist = array();
	    return;
	} elseif (is_null($songs)) {
	    $this->error = null;
	    $this->tracklist = array();
	    return;
	} else {
	    foreach ($sonsArray as $value) {
		$orderSongs[$value] = $songs[$value];
	    }
	    if (is_null($orderSongs)) {
		$this->error = null;
		$this->tracklist = array();
		return;
	    } else {
		$tracklist = array();
		$this->error = null;
		foreach ($orderSongs as $song) {
		    if (!is_null($song->getFromUser()) && !is_null($song->getRecord()))
			array_push($tracklist, $song);
		}
	    }
	    $this->tracklist = $tracklist;
	}
    }

}
?>