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
    public $recordArray = array();

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
	    $sql = "SELECT <tutti i campi>
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
		$record->setFromuser($row['fromuser']);
		$record->setGenre($row['genre']);
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
	    $sql = "SELECT <tutti i campi>
                      FROM record r, user_record ur
                     WHERE ur.id_user = " . $id . "
                       AND ur.id_record = r.id
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

}

?>