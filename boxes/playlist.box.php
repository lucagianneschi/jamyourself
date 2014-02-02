<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
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
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	PlaylistBox class 
 * \details	box to display user's playlist in each page of the website 
 */
class PlaylistBox {

    public $config;
    public $error;
    public $name;
    public $objectId;
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
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	require_once CLASSES_DIR . 'playlist.class.php';
	require_once CLASSES_DIR . 'playlistParse.class.php';
	$tracklist = array();
	$playlist = new PlaylistParse();
	$playlist->wherePointer('fromUser', '_User', $currentUserId);
	$playlist->where('active', true);
	$playlist->orderByDescending('createdAt');
	$playlist->setLimit($this->config->limitForPlaylist);
	$playlists = $playlist->getPlaylists();
	if ($playlists instanceof Error) {
	    $this->errorManagement($playlists->getErrorMessage());
	    return;
	} elseif (is_null($playlists)) {
	    $this->errorManagement();
	    return;
	} else {
	    foreach ($playlists as $playlist) {
		require_once CLASSES_DIR . 'song.class.php';
		require_once CLASSES_DIR . 'songParse.class.php';
		$this->name = $playlist->getName();
		$this->objectId = $playlist->getObjectId();
		$song = new SongParse();
		$song->whereRelatedTo('songs', 'Playlist', $playlist->getObjectId());
		$song->where('active', true);
		$song->setLimit($this->config->limitForTracklist);
		$song->whereInclude('fromUser,record');
		$songs = $song->getSongs();
		//order the song by the songsArray property
		foreach (current($playlists)->getSongsArray() as $value) {
		    $unOrderedSongsID = array();
		    foreach ($songs as $song) {
			$id = $song->getObjectId();
			array_push($id, $unOrderedSongsID);
		    }
		    $toEliminate = array_diff($value, $unOrderedSongsID);
		    foreach ($toEliminate as $id) {
			$index = array_search($id, $value);
			unset($value[$index]);
			array_merge($value);
			$pPlaylist = new PlaylistParse();
			$updatedPlayslist = $pPlaylist->updateField(current($playlists)->getObjectId(), 'songs', $id, true, 'remove', 'Song');
		    }
		    $pPlaylistArray = new PlaylistParse();
		    $updatedPlayslist = $pPlaylistArray->updateField(current($playlists)->getObjectId(), 'songsArray', $value);
		    if ($updatedPlayslist instanceof Error) {
			$this->error = null;
			$this->tracklist = array();
			return;
		    }
		    $orderSongs[$value] = $songs[$value];
		}
		if ($songs instanceof Error) {
		    $this->errorManagement($songs->getErrorMessage());
		    return;
		} elseif (is_null($orderSongs)) {
		    $this->error = null;
		    $this->tracklist = array();
		    return;
		} else {
		    foreach ($orderSongs as $song) {
			if (!is_null($song->getFromUser()) && !is_null($song->getRecord()))
			    array_push($tracklist, $song);
		    }
		    $this->error = null;
		    $this->tracklist = $tracklist;
		}
	    }
	}
    }

    /**
     * \fn	function errorManagement($errorMessage)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessafe
     * \todo    
     */
    private function errorManagement($errorMessage = null) {
	$this->config = null;
	$this->error = $errorMessage;
	$this->name = null;
	$this->objectId = null;
	$this->tracklist = array();
    }

}

?>