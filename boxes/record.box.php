<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * RecordBox class, box class to pass info to the view
 * Recupera le informazioni del post e le mette in oggetto postBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class RecordBox {

    public $error = null;
    public $recordArray = array();
    public $tracklist = array();

    /**
     * init for recordBox for personal Page
     * @param	$id of the user who owns the page
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip
     */
    public function init($id, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$records = selectRecords($connection, null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($records === false) {
	    $this->error = 'Errore nella query';
	}
	$this->recordArray = $records;
    }

    /**
     * init for Media Page
     * @param	int $id of the record to display in Media Page
     */
    public function initForMediaPage($id) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$records = selectRecords($connection, $id);
	if ($records === false) {
	    $this->error = 'Errore nella query';
	}
	$this->recordArray = $records;
    }

    /**
     * Init  RecordFilter instance for TimeLine
     * @param   float $lat = null, goal set for latitude
     * @param   float $long = null, goal set for longitude
     * @param	string $city = null, city to search record nearby
     * @param	string $country = null, country for the city
     * @param	array $genre = null, genre for record
     * @param   string $type = null, type of the record
     * @param   date $eventDate = null, date of the record
     * @param   float $distance, maximum distance fo the record
     * @param	string  $unit, 'km' (kilometers) or 'mi'(miles)
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @param   string $field, field for ordering results
     * @todo
     */
    public function initForStream($lat = null, $long = null, $city = null, $country = null, $genre = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {
	
    }

    /**
     * init for Tracklist
     * @param	$id of the record to display
     */
    public function initForTracklist($id) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$tracklist = selectSongs($connection, null, array('record' => $id), array('position' => 'ASC'));
	if ($tracklist === false) {
	    $this->error = 'Errore nella query';
	}
	$this->tracklist = $tracklist;
    }

}

?>