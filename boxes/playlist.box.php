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
require_once SERVICES_DIR . 'connection.service.php';

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
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->error = ONLYIFLOGGEDIN;
	    return;
	}
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT id,
		               createdat,
		               updatedat,
		               active,
		               fromuser,
		               name,
		               songcounter,
		               songs,
		               unlimited
               FROM album a, user_album ua
               WHERE ua.id_user = " . $currentUserId . "
               AND ua.id_album = a.id
               LIMIT " . 0 . ", " . 1;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows[] = $row;
	    $playlists = array();
	    foreach ($rows as $row) {
		require_once 'playlist.class.php';
		$playlist = new Playlist();
		$playlist->setId($row['id']);
		$playlist->setActive($row['active']);
		$playlist->setCreatedat($row['createdat']);
		$playlist->setFromuser($row['fromuser']);
		$playlist->setName($row['name']);
		$playlist->setSongcounter($row['songcounter']);
		$playlist->setSongs($row['songs']);
		$playlist->setUnlimited($row['unlimited']);
		$playlist->setUpdatedat($row['updatedat']);
	    }
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->playlistArray = $playlists;
	    }
	}
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
     */
    public function init($id) {
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->error = ONLYIFLOGGEDIN;
	    return;
	}
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT id,
		               createdat,
		               updatedat,
		               active,
		               commentcounter,
		               counter,
		               duration,
		               fromuser,
		               genre,
		               latitude,
		               longitude,
		               lovecounter,
		               path,
		               position,
		               record,
		               sharecounter,
		               title
                 FROM album a, user_album ua
                WHERE ua.id_user = " . $id . "
                  AND ua.id_album = a.id
                LIMIT " . 0 . ", " . 20;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows[] = $row;
	    $songs = array();
	    foreach ($rows as $row) {
		require_once 'song.class.php';
		$song = new Song();
		$song->setId($row['id']);
		$song->setActive($row['active']);
		$song->setCommentcounter($row['commentcounter']);
		$song->setCounter($row['counter']);
		$song->setCreatedat($row['createdat']);
		$song->setDuration($row['duration']);
		$song->setFromuser($row['fromuser']);
		$song->setGenre($row['genre']);
		$song->setLatitude($row['latitude']);
		$song->setLongitude($row['longitude']);
		$song->getLovecounter($row['lovecounter']);
		$song->setPath($row['path']);
		$song->setPosition($row['position']);
		$song->setRecord($row['record']);
		$song->setSharecounter($row['sharecounter']);
		$song->setTitle($row['title']);
		$song->setUpdatedat($row['updatedat']);
	    }
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->songArray = $songs;
	    }
	}
    }

}

?>