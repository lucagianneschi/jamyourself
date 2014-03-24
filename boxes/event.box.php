<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * EventBox class, box class to pass info to the view
 * Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class EventBox {

    /**
     * @var string stringa di errore
     */
    public $error = null;

    /**
     * @var array Array di event
     */
    public $eventArray = array();

    /**
     * Init EventBox instance for Personal Page
     * @param	$id for user that owns the page
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip
     * @todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$events = selectEvents($connection, null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($events === false) {
	    $this->error = 'Errore nella query';
	}
	$this->eventArray = $events;
    }

    /**
     * Init EventBox instance for Media Page
     * @param	int $id for event
     */
    public function initForMediaPage($id) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$events = selectEvents($connection, $id);
	if ($events === false) {
	    $this->error = 'Errore nella query';
	}
	$this->eventArray = $events;
    }

    /**
     * Init EventFilter instance for TimeLine
     * @param   float $lat = null, goal set for latitude
     * @param   float $long = null, goal set for longitude
     * @param	string $city = null, city to search event nearby
     * @param	string $country = null, country for the city
     * @param	array $tags = null, tags for event
     * @param   string $type = null, type of the event
     * @param   date $eventDate = null, date of the event
     * @param   float $distance, maximum distance fo the event
     * @param	string  $unit, 'km' (kilometers) or 'mi'(miles)
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @param   string $field, field for ordering results    
     */
    public function initForStream($lat = null, $long = null, $city = null, $country = null, $tags = null, $eventDate = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {
	
    }

}

?>