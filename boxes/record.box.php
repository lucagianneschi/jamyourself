<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
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

    public $config;
    public $error = null;
    public $recordArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "recordBox.config.json"), false);
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
	    $sql = "SELECT * FROM record WHERE id=" . $id . " LIMIT " . 0 . ", " . 1;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->recordArray = $results;
	    }
	}
    }

    /**
     * \fn	initForPersonalPage($id)
     * \brief	init for recordBox for personal Page
     * \param	$id of the user who owns the page
     * \todo	
     */
    public function initForPersonalPage($id, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
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
	    $this->error = ONLYIFLOGGEDIN ;
	    return;
	}

    }

    /**
     * \fn	initForUploadRecordPage($id)
     * \brief	init for recordBox for upload record page
     * \param	$id of the user who owns the record
     */
    public function initForUploadRecordPage() {
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->error = ONLYIFLOGGEDIN;
	    return;
	}
    }


}

?>