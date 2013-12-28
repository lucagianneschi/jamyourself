<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento info event * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view * \par			Commenti: * \warning * \bug * \todo			 * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once CLASSES_DIR . 'event.class.php';require_once CLASSES_DIR . 'eventParse.class.php';/** * \brief	EventBox class  * \details	box class to pass info to the view  */class EventBox {    public $config;    public $error;    public $eventArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/event.config.json"), false);    }    /**     * \fn	initForMediaPage($objectId)     * \brief	Init EventBox instance for Media Page     * \param	$objectId for event     */    public function initForMediaPage($objectId) {	$eventP = new EventParse();	$eventP->where('objectId', $objectId);	$eventP->where('active', true);	$eventP->whereInclude('fromUser');	$eventP->setLimit(MIN);	$events = $eventP->getEvents();	if ($events instanceof Error) {	    $this->errorManagement($events->getErrorMessage());	    return;	} elseif (is_null($events)) {	    $this->errorManagement();	    return;	} else {	    $this->error = null;	    $this->eventArray = $events;	}    }    /**     * \fn	initForPersonalPage($objectId)     * \brief	Init EventBox instance for Personal Page     * \param	$objectId for user that owns the page     * \todo         */    public function initForPersonalPage($objectId, $updatedAt = false, $limit = null, $skip = null) {	$event = new EventParse();	$event->wherePointer('fromUser', '_User', $objectId);	$event->where('active', true);	$event->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : DEFAULTQUERY);	$event->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);	($updatedAt == false) ? $event->orderByDescending('eventDate') : $event->orderByDescending('updatedAt');	$events = $event->getEvents();	if ($events instanceof Error) {	    $this->errorManagement($events->getErrorMessage());	    return;	} elseif (is_null($events)) {	    $this->errorManagement();	    return;	} else {	    $this->error = null;	    $this->eventArray = $events;	}    }    /**     * \fn	init($city = null, $type = null, $eventDate = null, $limit = null, $skip = null)     * \brief	Init EventFilter instance for TimeLine     * \param	$city = null, $type = null, $eventDate = null, $limit = null, $skip = null;     * \todo         */    public function initForStream($lat = null, $long = null, $city = null, $country = null, $tags = null, $genres = null, $eventDate = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {	$currentUserId = sessionChecker();	if (is_null($currentUserId)) {	    $this->errorManagement(ONLYIFLOGGEDIN);	    return;	}	$event = new EventParse();        if (!is_null($lat) && !is_null($long)) {	    $event->whereNearSphere($lat, $long, (is_null($distance) || !is_numeric($distance)) ? $this->config->distanceLimitForEvent : $distance, ($unit == 'km') ? $unit : 'mi');	} elseif (!is_null($city) || !is_null($country)) {	    $locations = findLocationCoordinates($city, $country);	    if (!($locations instanceof Error) && !is_null($locations)) {		$lat = current($locations)->getGeopoint()->location['latitude'];		$long = current($locations)->getGeopoint()->location['longitude'];	    }	    $event->whereNearSphere($lat, $long, (is_null($distance) || !is_numeric($distance)) ? $this->config->distanceLimitForEvent : $distance, ($unit == 'km') ? $unit : 'mi');	}	if (!is_null($tags)) {	    $orConditionArrayTags = array();	    foreach ($tags as $tag) {		array_push($orConditionArrayTags, array('tags' => $tag));	    }	    $event->whereOr($orConditionArrayTags);	}	if (!is_null($genres)) {	    $orConditionArrayGenre = array();	    foreach ($genres as $genre) {		array_push($orConditionArrayGenre, array('genre' => $genre));	    }	    $event->whereOr($orConditionArrayGenre);	}	if (!is_null($eventDate)) {	    $event->whereGreaterThanOrEqualTo('eventDate', $eventDate);	}	$event->whereExists('createdAt');	$event->whereInclude('fromUser');	$event->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitEventForTimeline);	$event->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);        if (((is_null($lat) && is_null($long)) && (is_null($city)) && is_null($country))) {            $event->orderByDescending($field);        }	$events = $event->getEvents();	if ($events instanceof Error) {	    $this->errorManagement($events->getErrorMessage());	    return;	} elseif (is_null($events)) {	    $this->errorManagement();	    return;	} else {	    $this->error = null;	    $this->eventArray = $events;	}    }    /**     * \fn	errorManagement($errorMessage = null)     * \brief	set values in case of error or nothing to send to the view     * \param	$errorMessage     */    private function errorManagement($errorMessage = null) {	$this->config = null;	$this->error = $errorMessage;	$this->eventArray = array();    }}?>