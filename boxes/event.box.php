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
require_once SERVICES_DIR . 'select.service.php';

/**
 * \brief	EventBox class
 * \details	box class to pass info to the view
 */
class EventBox {

    public $error = null;
    public $eventArray = array();

    /**
     * \fn	init($id)
     * \brief	Init EventBox instance for Personal Page
     * \param	$id for user that owns the page
     * \todo    inserire orderby
     */
    public function init($id, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$events = selectEvents(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($events === false) {
	    $this->error = 'Errore nella query';
	}
	$this->eventArray = $events;
    }

    /**
     * \fn	initForMediaPage($id)
     * \brief	Init EventBox instance for Media Page
     * \param	$id for event
     */
    public function initForMediaPage($id) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$events = selectEvents($id);
	if ($events === false) {
	    $this->error = 'Errore nella query';
	}
	$this->eventArray = $events;
    }

    /**
     * \fn	init($city = null, $type = null, $eventDate = null, $limit = null, $skip = null)
     * \brief	Init EventFilter instance for TimeLine
     * \param	$city = null, $type = null, $eventDate = null, $limit = null, $skip = null;
     * \todo    reimplementare $tags al momento in cui vengono implementati nella vista stream
     */
    public function initForStream($lat = null, $long = null, $city = null, $country = null, $tags = null, $eventDate = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {
	
    }

}

?>