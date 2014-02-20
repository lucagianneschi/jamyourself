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
    public $tracklist = array();

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
	$records = selectRecords(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($records instanceof Error) {
	    $this->error = $records->getErrorMessage();
	}
	$this->recordArray = $records;
    }

    /**
     * \fn	initForMediaPage($id)
     * \brief	init for Media Page
     * \param	$id of the record to display in Media Page
     * \todo
     */
    public function initForMediaPage($id) {
	$records = selectRecords($id);
	if ($records instanceof Error) {
	    $this->error = $records->getErrorMessage();
	}
	$this->recordArray = $records;
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
	$tracklist = selectSongs(null, array('record' => $id), array('position' => 'ASC'));
	if ($tracklist instanceof Error) {
	    $this->error = $tracklist->getErrorMessage();
	}
	$this->tracklist = $tracklist;
    }

}

?>