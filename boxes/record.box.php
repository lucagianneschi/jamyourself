<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	RecordBox class
 * \details	box class to pass info to the view for personal page, media page & uploadRecord page
 */
class RecordBox {

    public $error = null;
    public $fromUser = null;
    public $recordArray = array();

    /**
     * \fn	init($id)
     * \brief	init for recordBox for personal Page
     * \param	$id of the user who owns the page
     * \todo
     */
    public function init($id, $limit = 3, $skip = 0, $upload = false) {
	if ($upload == true) {
	    require_once SERVICES_DIR . 'utils.service.php';
	    $currentUserId = sessionChecker();
	    if (is_null($currentUserId)) {
		$this->error = ONLYIFLOGGEDIN;
		return;
	    }
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
		               buylink,
		               city,
		               commentcounter,
		               counter,
		               cover,
		               description,
		               duration,
		               fromuser,
		               genre,
		               label,
		               latitude,
		               longitude,
		               lovecounter,
		               reviewCounter,
		               sharecounter,
		               songCounter,
		               thumbnail,
		               title,
		               tracklist,
		               year
                 FROM record r, user_record ur
                WHERE ur.id_record = " . $id . "
                LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows[] = $row;
	    $records = array();
	    foreach ($rows as $row) {
		require_once 'record.class.php';
		$record = new Record();
		$record->setId($row['id']);
		$record->setActive($row['active']);
		$record->setBuylink($row['buylink']);
		$record->setCity($row['city']);
		$record->setCommentcounter($row['commentcounter']);
		$record->setCounter($row['counter']);
		$record->setCover($row['cover']);
		$record->setCreatedat($row['createdat']);
		$record->setDescription($row['description']);
		$record->setDuration($row['duration']);
		$record->setFromuser($row['fromuser']);
		$record->setGenre($row['genre']);
		$record->setLabel($row['label']);
		$record->setLatitude($row['latitude']);
		$record->setLongitude($row['longitude']);
		$record->setLovecounter($row['lovecounter']);
		$record->setReviewCounter($row['reviewCounter']);
		$record->setSharecounter($row['sharecounter']);
		$record->setSongCounter($row['songCounter']);
		$record->setThumbnail($row['thumbnail']);
		$record->setTitle($row['title']);
		$record->setTracklist($row['tracklist']);
		$record->setUpdatedat($row['updatedat']);
		$record->setYear($row['year']);
		$records[$row['id']] = $record;
	    }
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->recordArray = $results;
	    }
	}
    }

    /**
     * \fn	initForMediaPage($id)
     * \brief	init for Media Page
     * \param	$id of the record to display in Media Page
     * \todo
     */
    public function initForMediaPage($id) {
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
		               buylink,
		               city,
		               commentcounter,
		               counter,
		               cover,
		               description,
		               duration,
		               fromuser,
		               genre,
		               label,
		               latitude,
		               longitude,
		               lovecounter,
		               reviewCounter,
		               sharecounter,
		               songCounter,
		               thumbnail,
		               title,
		               tracklist,
		               year
                 FROM record r, user_record ur
                WHERE ur.id_record = " . $id . "
                LIMIT " . 0 . ", " . 1;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows[] = $row;
	    $records = array();
	    foreach ($rows as $row) {
		require_once 'record.class.php';
		$record = new Record();
		$record->setId($row['id']);
		$record->setActive($row['active']);
		$record->setBuylink($row['buylink']);
		$record->setCity($row['city']);
		$record->setCommentcounter($row['commentcounter']);
		$record->setCounter($row['counter']);
		$record->setCover($row['cover']);
		$record->setCreatedat($row['createdat']);
		$record->setDescription($row['description']);
		$record->setDuration($row['duration']);
		$sql = "SELECT id,
			       username,
			       thumbnail,
			       type
                          FROM user
                         WHERE id = " . $row['fromuser'];
		$res = mysqli_query($connectionService->connection, $sql);
		$row_user = mysqli_fetch_array($res, MYSQLI_ASSOC);
		require_once 'user.class.php';
		$user = new User($row_user['type']);
		$user->setId($row_user['id']);
		$user->setThumbnail($row_user['thumbnail']);
		$user->setUsername($row_user['username']);
		$this->fromUser = $user;
		$record->setGenre($row['genre']);
		$sql = "SELECT tag
                          FROM record_genre
                         WHERE id = " . $row['id'];
		$results = mysqli_query($connectionService->connection, $sql);
		while ($row_genre = mysqli_fetch_array($results, MYSQLI_ASSOC))
		    $rows_genre[] = $row_genre;
		$genres = array();
		foreach ($rows_genre as $row_genre) {
		    $genres[] = $row_genre;
		}
		$record->setGenre($genres);
		$record->setLabel($row['label']);
		$record->setLatitude($row['locationlat']);
		$record->setLongitude($row['locationlon']);
		$record->setLovecounter($row['lovecounter']);
		$record->setReviewCounter($row['reviewCounter']);
		$record->setSharecounter($row['sharecounter']);
		$record->setSongCounter($row['songCounter']);
		$record->setThumbnail($row['thumbnail']);
		$record->setTitle($row['title']);
		$record->setTracklist($row['tracklist']);
		$record->setUpdatedat($row['updatedat']);
		$record->setYear($row['year']);
		$records[$row['id']] = $record;
	    }
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->recordArray = $results;
	    }
	}
    }

    /**
     * \fn	init($genre = null, $limit = null, $skip = null)
     * \brief	Init RecordFilter instance for TimeLine
     * \param	$genre = null, $limit = null, $skip = null
     * \todo
     */
    public function initForStream($lat = null, $long = null, $city = null, $country = null, $genre = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->error = ONLYIFLOGGEDIN;
	    return;
	}
    }

    /**
     * \fn	initForTracklist($id)
     * \brief	init for Tracklist
     * \param	$id of the record to display 
     * \todo
     */
    public function initForTracklist($id) {
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
                LIMIT " . 0 . ", " . 50;
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