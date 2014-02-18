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

    public $error = null;
    public $eventArray = array();

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
	    $sql = "SELECT <tutti i campi>
                      FROM event e, user_event ue
                     WHERE ua.id_event = " . $id . "
                     LIMIT " . 0 . ", " . 1;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows[] = $row;
	    $events = array();
	    foreach ($rows as $row) {
		require_once 'event.class.php';
		$event = new Event();
		$event->setId($row['id']);
		$event->setActive($row['active']);
		$event->setAddress($row['address']);
		$event->setAttendeecounter($row['attendeecounter']);
		$event->setCancelledcounter($row['cancelledcounter']);
		$event->setCity($row['city']);
		$event->setCommentcounter($row['commentcounter']);
		$event->setCounter($row['counter']);
		$event->setCover($row['cover']);
		$event->setCreatedat($row['createdat']);
		$event->setDescription($row['description']);
		$event->setEventdate($row['eventdate']);
		$event->setFromuser($row['fromuser']);
		$event->setGenre($row['genre']);
		$event->setInvitedCounter($row['invitedCounter']);
		$event->setLatitude($row['locationlat']);
		$event->setLocationname($row['locationname']);
		$event->setLongitude($row['locationlong']);
		$event->setLovecounter($row['lovecounter']);
		$event->setRefusedcounter($row['refusedcounter']);
		$event->setReviewcounter($row['reviewcounter']);
		$event->setSharecounter($row['sharecounter']);
		$event->setTag($row['tag']);
		$event->setThumbnail($row['thumbnail']);
		$event->setTitle($row['title']);
		$event->setUpdatedat($row['updatedat']);
		$events[$row['id']] = $event;
	    }
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
	    $sql = "SELECT <tutti i campi>
                      FROM event e, user_event ue
                     WHERE ua.id_user = " . $id . "
                       AND ua.id_event = e.id
                     LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows[] = $row;
	    $events = array();
	    foreach ($rows as $row) {
		require_once 'event.class.php';
		$event = new Event();
		$event->setId($row['id']);
		$event->setActive($row['active']);
		$event->setAddress($row['address']);
		$event->setAttendeecounter($row['attendeecounter']);
		$event->setCancelledcounter($row['cancelledcounter']);
		$event->setCity($row['city']);
		$event->setCommentcounter($row['commentcounter']);
		$event->setCounter($row['counter']);
		$event->setCover($row['cover']);
		$event->setCreatedat($row['createdat']);
		$event->setDescription($row['description']);
		$event->setEventdate($row['eventdate']);
		$event->setFromuser($row['fromuser']);
		$event->setGenre($row['genre']);
		$event->setInvitedCounter($row['invitedCounter']);
		$event->setLatitude($row['locationlat']);
		$event->setLocationname($row['locationname']);
		$event->setLongitude($row['locationlong']);
		$event->setLovecounter($row['lovecounter']);
		$event->setRefusedcounter($row['refusedcounter']);
		$event->setReviewcounter($row['reviewcounter']);
		$event->setSharecounter($row['sharecounter']);
		$event->setTag($row['tag']);
		$event->setThumbnail($row['thumbnail']);
		$event->setTitle($row['title']);
		$event->setUpdatedat($row['updatedat']);
		$events[$row['id']] = $event;
	    }
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