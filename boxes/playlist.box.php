<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento playlist utente
 * \details		Recupera la playlist utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo	    comprendere i profili premium, uso whereInclude	
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

/**
 * \brief	SongInfo class 
 * \details	info for the song to be displayed in the playlistBox 
 */
class SongInfo {

    public $author;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($author, $thumbnail,$title)
     * \brief	construct for the SongInfo class
     * \param	$author, $thumbnail,$title
     */
    function __construct($author, $thumbnail, $title) {
	is_null($author) ? $this->author = null : $this->author = $author;
	is_null($thumbnail) ? $this->thumbnail = DEFSONGTHUMB : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = null : $this->title = $title;
    }

}

/**
 * \brief	PlaylistBox class 
 * \details	box to display user's playlist in each page of the website 
 */
class PlaylistBox {

    public $config;
    public $error;
    public $name;
    public $tracklist;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/playlist.config.json"), false);
    }

    /**
     * \fn	init($objectId)
     * \brief	Init Playslist Box instance
     * \param	$objectId
     * \return	playlistBox
     * \todo    implementare la differenziazione della lunghezza della query in base alla proprety premium dell'utente, usa una variabile in più $premium che deve essere un BOOL
     */
    public function init() {
	global $boxes;
	$tracklist = array();
	$currentUserObjectId = sessionChecker();
	if ($currentUserObjectId == $boxes['NOID']) {
	    $this->errorManagement($boxes['ONLYIFLOGGEDIN']);
	    return;
	}
	$playlist = new PlaylistParse();
	$playlist->wherePointer('fromUser', '_User', $currentUserObjectId);
	$playlist->where('active', true);
	$playlist->orderByDescending('createdAt');
	$playlist->setLimit($this->config->limitForPlaylist);
	$playlists = $playlist->getPlaylists();
	if ($playlists instanceof Error) {
	    $this->errorManagement($playlists->getErrorMessage());
	    return;
	} elseif (is_null($playlists)) {
	    $this->errorManagement(null);
	    return;
	} else {
	    foreach ($playlists as $playlist) {
		require_once CLASSES_DIR . 'song.class.php';
		require_once CLASSES_DIR . 'songParse.class.php';
		$this->name = ($playlist->getName());
		$song = new SongParse();
		$song->whereRelatedTo('songs', 'Playlist', $playlist->getObjectId());
		$song->where('active', true);
		$song->orderByDescending('createdAt');
		$song->setLimit($this->config->limitForTracklist);
		$song->whereInclude('fromUser,record');
		$songs = $song->getSongs();
		if ($songs instanceof Error) {
		    $this->errorManagement($songs->getErrorMessage());
		    return;
		} elseif (is_null($songs)) {
		    $this->errorManagement(null);
		    return;
		} else {
		    foreach ($songs as $song) {
			$title = $song->getTitle();
			$songId = $song->getFromUser()->getObjectId();
			$thumbnail = $song->getFromUser()->getProfileThumbnail();
			$type = $song->getFromUser()->getType();
			$username = $song->getFromUser()->getUsername();
			$author = new UserInfo($songId, $thumbnail, $type, $username);
			$thumbnailRec = $song->getRecord()->getThumbnailCover();
			$newSong = new SongInfo($author, $thumbnailRec, $title);
			array_push($tracklist, $newSong);
		    }
		}
	    }
	    $this->error = null;
	    $this->tracklist = $tracklist;
	}
    }

    /**
     * \fn	function errorManagement($errorMessage)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessafe
     * \todo    
     */
    private function errorManagement($errorMessage) {
	$this->error = $errorMessage;
	$this->name = null;
	$this->tracklist = null;
    }

}

?>