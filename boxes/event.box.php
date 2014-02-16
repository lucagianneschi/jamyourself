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

/**
 * \brief	EventBox class 
 * \details	box class to pass info to the view 
 */
class EventBox {

    public $config;
    public $error = null;
    public $eventArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "eventBox.config.json"), false);
    }

    /**
     * \fn	initForMediaPage($id)
     * \brief	Init EventBox instance for Media Page
     * \param	$id for event
     */
    public function initForMediaPage($id) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM event WHERE id=" . $id . " LIMIT " . 0 . ", " . 1;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->eventArray = $results;
	    }
	}
    }

    /**
     * \fn	initForPersonalPage($id)
     * \brief	Init EventBox instance for Personal Page
     * \param	$id for user that owns the page
     * \todo    inserire orderby
     */
    public function initForPersonalPage($id, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM event WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->eventArray = $results;
	    }
	}
    }

    /**
     * \fn	init($city = null, $type = null, $eventDate = null, $limit = null, $skip = null)
     * \brief	Init EventFilter instance for TimeLine
     * \param	$city = null, $type = null, $eventDate = null, $limit = null, $skip = null;
     * \todo    reimplementare $tags al momento in cui vengono implementati nella vista stream
     */
    public function initForStream($lat = null, $long = null, $city = null, $country = null, $tags = null, $eventDate = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->error = ONLYIFLOGGEDIN;
	    return;
	}
    }



}

?>