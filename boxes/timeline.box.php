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
 * \todo	        corretta gestione di skip e limit sia per query interna che esterna, correggere whereInclude,implementare plugin per ricerca spaziale e fare ricerca con whereInSphere nota la località 	        
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	EventFilter class
 * \details	box class to pass info to the view for timelinePage
 */
class EventFilter {

    public $config;
    public $error;
    public $eventArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/timeline.config.json"), false);
    }

    /**
     * \fn	init($city = null, $type = null, $eventDate = null, $limit = null, $skip = null)
     * \brief	Init EventFilter instance for TimeLine
     * \param	$city = null, $type = null, $eventDate = null, $limit = null, $skip = null;
     * \todo    introdurre la ricerca in abse alall geolocalizzazione, fai query su locationParse, poi cerchi l'evento più vicino
     */
    public function init($city = null, $tags = array(), $eventDate = null, $time = null, $limit = null, $skip = null, $distance = null, $unit = 'km') {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	require_once CLASSES_DIR . 'event.class.php';
	require_once CLASSES_DIR . 'eventParse.class.php';
	$event = new EventParse();
	if (!is_null($city)) {
	    require_once CLASSES_DIR . 'location.class.php';
	    require_once CLASSES_DIR . 'locationParse.class.php';
	    $location = new LocationParse();
	    $location->where('city', $city);
	    $location->setLimit($this->config->limitLocation);
	    $locations = $location->getLocations();
	    if ($locations instanceof Error) {
		$event->where('city', $city);
	    } elseif (is_null($locations)) {
		$this->errorManagement(LOCATIONNOTFOUND);
		return;
	    } else {
		foreach ($locations as $loc) {
		    $event->whereNearSphere($loc->getGeopoint()->location['latitude'], $loc->getGeopoint()->location['longitude'], (is_null($distance) && !is_numeric($distance)) ? $this->config->distanceLimitForEvent : $distance, ($unit == 'km') ? $unit : 'mi');
		}
	    }
	} elseif (count($tags) != 0) {
	    $orConditionArray = array();
	    foreach ($tags as $tag) {
		array_push($orConditionArray, array('tags' => $tag));
	    }
	    $event->whereOr($orConditionArray);
	} elseif (!is_null($eventDate)) {
	    $event->whereGreaterThanOrEqualTo('eventDate', $eventDate);
	}
	$event->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitEventForTimeline);
	$event->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
	if (!is_null($time)) {
	    $event->orderByAscending('eventDate');
	}
	$events = $event->getEvents();
	if ($events instanceof Error) {
	    $this->errorManagement($events->getErrorMessage());
	    return;
	} elseif (is_null($events)) {
	    $this->errorManagement();
	    return;
	} else {
	    $this->error = null;
	    $this->eventArray = $events;
	}
    }

    /**
     * \fn	errorManagement($errorMessage = null)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessage
     */
    private function errorManagement($errorMessage = null) {
	$this->error = $errorMessage;
	$this->eventArray = array();
    }

}

/**
 * \brief	RecordFilter class
 * \details	box class to pass info to the view for timelinePage
 */
class RecordFilter {

    public $config;
    public $error;
    public $recordArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/timeline.config.json"), false);
    }

    /**
     * \fn	init($genre = null, $limit = null, $skip = null)
     * \brief	Init RecordFilter instance for TimeLine
     * \param	$genre = null, $limit = null, $skip = null
     * \todo
     */
    public function init($genre = array(), $city = null, $time = null, $limit = null, $skip = null, $distance = null, $unit = 'km') {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	require_once CLASSES_DIR . 'record.class.php';
	require_once CLASSES_DIR . 'recordParse.class.php';
	$record = new RecordParse();
	if (!is_null($city)) {
	    require_once CLASSES_DIR . 'location.class.php';
	    require_once CLASSES_DIR . 'locationParse.class.php';
	    $location = new LocationParse();
	    $location->where('city', $city);
	    $location->setLimit($this->config->limitLocation);
	    $locations = $location->getLocations();
	    if ($locations instanceof Error) {
		$this->errorManagement($locations->getErrorMessage());
		return;
	    } elseif (is_null($locations)) {
		$this->errorManagement(LOCATIONNOTFOUND);
		return;
	    } else {
		foreach ($locations as $loc) {
		    $record->whereNearSphere($loc->getGeopoint()->location['latitude'], $loc->getGeopoint()->location['longitude'], (is_null($distance) && !is_numeric($distance)) ? $this->config->distanceLimitForRecord : $distance, ($unit == 'km') ? $unit : 'mi');
		}
	    }
	} elseif (count($genre) != 0) {
	    $record->whereContainedIn('genre', $genre);
	}
	$record->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitRecordForTimeline);
	$record->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
	if (!is_null($time)) {
	    $record->orderByDescending('createdAt');
	}
	$records = $record->getRecords();
	if ($records instanceof Error) {
	    $this->errorManagement($records->getErrorMessage());
	    return;
	} elseif (is_null($records)) {
	    $this->errorManagement();
	    return;
	} else {
	    $this->error = null;
	    $this->recordArray = $records;
	}
    }

    /**
     * \fn	errorManagement($errorMessage = null)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessage
     */
    private function errorManagement($errorMessage = null) {
	$this->error = $errorMessage;
	$this->recordArray = array();
    }

}

/**
 * \brief	StreamBox class
 * \details	box class to pass info to the view for timelinePage
 */
class StreamBox {

    public $activitesArray;
    public $config;
    public $error;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/timeline.config.json"), false);
    }

    /**
     * \fn	init
     * \brief	timeline init
     * \param	$limit, $skip
     * \todo
     */
    public function init($limit = DEFAULTQUERY, $skip = null) {
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$currentUser = $_SESSION['currentUser'];
	$actArray = $this->createActivityArray($currentUser->getType());
	if (($currentUser->getType() == SPOTTER)) {
	    $ciclesFollowing = ceil($currentUser->getFollowingCounter() / MAX);
	    $ciclesFriendship = ceil($currentUser->getFriendshipCounter() / MAX);
	    if ($ciclesFollowing == 0 && $ciclesFriendship == 0) {
		$this->errorManagement();
		return;
	    }
	    $partialActivities = $this->query('following', $currentUser->getObjectId(), $ciclesFollowing, $actArray, $limit, $skip);
	    $partialActivities1 = $this->query('friendship', $currentUser->getObjectId(), $ciclesFriendship, $actArray, $limit, $skip);
	    $activities = array_merge($partialActivities, $partialActivities1);
	    $this->error = (count($activities) == 0 || !ksort($activities)) ? 'TIMELINERROR' : null;
	    $this->activitesArray = $activities;
	    return;
	} else {
	    $cicles = ceil($currentUser->getCollaborationCounter() / MAX);
	    if ($cicles == 0) {
		$this->errorManagement();
		return;
	    }
	    $activities = $this->query('collaboration', $currentUser->getObjectId(), $cicles, $actArray, $limit, $skip);
	};
	$this->error = (count($activities) == 0 || !ksort($activities)) ? 'TIMELINERROR' : null;
	$this->activitesArray = $activities;
    }

    /**
     * \fn	query($field, $currentUserId, $cicles, $limit = null, $skip = null)
     * \brief	private funtion for query
     * \param	$limit, $skip per la query estena, ccioè sulle activities
     * \todo    mettere i corretti whereInclude in funzione delle tipologie di activities
     */
    private function query($field, $currentUserId, $cicles, $actArray, $limit, $skip) {
	$activities = array();
	for ($i = 0; $i < $cicles; ++$i) {
	    $parseQuery = new parseQuery('Activity');
	    $pointer = $parseQuery->dataType('pointer', array('_User', $currentUserId));
	    $related = $parseQuery->dataType('relatedTo', array($pointer, $field));
	    $select = $parseQuery->dataType('query', array('_User', array('$relatedTo' => $related), 'objectId', MAX * $i, MAX));
	    $parseQuery->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : DEFAULTQUERY);
	    $parseQuery->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
	    $parseQuery->whereSelect('fromUser', $select);
	    $parseQuery->whereInclude('album,event,comment,record,song,video,fromUser,toUser');
	    $parseQuery->where('active', true);
	    $parseQuery->whereContainedIn('type', $actArray);
	    $res = $parseQuery->find();
	    if (is_array($res->results) && count($res->results) > 0) {
		$partialActivities = $this->activitiesChecker($res);
	    }
	    $activities = $activities + $partialActivities;
	}
	return $activities;
    }

    /**
     * \fn	activitiesChecker($res)
     * \brief	private funtion for check if the activity on DB is correct
     * \param	$res, resul for the query
     * \retun   $activities array, filtered array with correct activities
     * \todo    fare controllo con i corretti whereInclude
     */
    private function activitiesChecker($res) {
	$activities = array();
	require_once CLASSES_DIR . 'activityParse.class.php';
	foreach ($res->results as $obj) {
	    $actP = new ActivityParse();
	    $activity = $actP->parseToActivity($obj);
	    if (!is_null($activity->getFromUser())) {
		$collaborationRequest = ($activity->getType() == 'COLLABORATIONREQUEST' && $activity->getStatus('A') && !is_null($activity->getToUser())); //OK
		$commentedOnAlbum = ($activity->getType() == 'COMMENTEDONALBUM' && !is_null($activity->getAlbum() && !is_null($activity->getComment()) && !is_null($activity->getToUser())));
		$commentedOnEvent = ($activity->getType() == 'COMMENTEDONEVENT' && !is_null($activity->getEvent() && !is_null($activity->getComment()) && !is_null($activity->getToUser())));
		$commentedOnImage = ($activity->getType() == 'COMMENTEDONIMAGE' && !is_null($activity->getImage() && !is_null($activity->getComment()) && !is_null($activity->getToUser())));
		$commentedOnEventReview = ($activity->getType() == 'COMMENTEDONEVENTREVIEW' && !is_null($activity->getEvent()) && !is_null($activity->getComment()) && !is_null($activity->getToUser()));
		$commentedOnRecord = ($activity->getType() == 'COMMENTEDONRECORD' && !is_null($activity->getRecord()) && !is_null($activity->getComment()) && !is_null($activity->getToUser()));
		$commentedOnRecordReview = ($activity->getType() == 'COMMENTEDONRECORDREVIEW' && !is_null($activity->getRecord()) && !is_null($activity->getComment()) && !is_null($activity->getToUser())); //serve toUser??
		$commentedOnPost = ($activity->getType() == 'COMMENTEDONPOST' && !is_null($activity->getComment()) && !is_null($activity->getComment()) && !is_null($activity->getToUser()));
		$commentedOnVideo = ($activity->getType() == 'COMMENTEDONVIDEO' && !is_null($activity->getVideo()) && !is_null($activity->getComment()) && !is_null($activity->getToUser()));
		$createdAlbum = (($activity->getType() == 'ALBUMCREATED' || $activity->getType() == 'DEFAULTALBUMCREATED' ) && !is_null($activity->getAlbum()));
		$createdEvent = ($activity->getType() == 'EVENTCREATED' && !is_null($activity->getEvent()));
		$createdRecord = (($activity->getType() == 'RECORDCREATED' || $activity->getType() == 'DEFAULTRECORDCREATED') && !is_null($activity->getRecord()));
		$friendshipRequest = ($activity->getType() == 'FRIENDSHIPREQUEST' && $activity->getStatus('A') && !is_null($activity->getToUser())); //OK
		$following = ($activity->getType() == 'FOLLOWING' && !is_null($activity->getToUser()) ); //OK
		$imageUploaded = ($activity->getType() == 'IMAGEUPLOADED' && !is_null($activity->getImage())); //OK
		$invited = ($activity->getType() == 'INVITED' && !is_null($activity->getEvent()) && !is_null($activity->getEvent()->getFromUser()) && $activity->getStatus('A') );
		$newLevel = ($activity->getType() == 'NEWLEVEL');
		$newBadge = ($activity->getType() == 'NEWBADGE');
		$newEventReview = ($activity->getType() == 'NEWEVENTREVIEW' && !is_null($activity->getComment()) && !is_null($activity->getFromUser()) && !is_null($activity->getEvent()) && !is_null($activity->getEvent()->getFromUser()));
		$newRecordReview = ($activity->getType() == 'NEWRECORDREVIEW' && !is_null($activity->getComment()) && !is_null($activity->getFromUser()) && !is_null($activity->getRecord()) && !is_null($activity->getRecord()->getFromUser()));
		$posted = ($activity->getType() == 'POSTED' && !is_null($activity->getComment()) && !is_null($activity->getToUser()));
		$sharedImage = ($activity->getType() == 'SHAREDIMAGE' );
		$sharedSong = ($activity->getType() == 'SHAREDSONG' );
		$songUploaded = ($activity->getType() == 'SONGUPLOADED' && !is_null($activity->getSong())); //OK
		$testArray = array($collaborationRequest, $commentedOnAlbum, $commentedOnEvent, $commentedOnEventReview, $commentedOnImage, $commentedOnPost, $commentedOnRecord, $commentedOnRecordReview, $commentedOnVideo, $createdAlbum, $createdEvent, $createdRecord, $friendshipRequest, $following, $imageUploaded, $invited, $newBadge, $newEventReview, $newLevel, $newRecordReview, $posted, $sharedImage, $sharedSong, $songUploaded);
		if (in_array(true, $testArray))
		    $activities[$activity->getCreatedAt()->format('YmdHis')] = $activity;
	    }
	}

	return $activities;
    }

    /**
     * \fn	createActivityArray($userType)
     * \brief	private funtion for creating the activity type array based on the user type
     * \param	$userType
     * \todo
     */
    private function createActivityArray($userType) {
	$sharedActivities = $this->config->sharedActivities;
	switch ($userType) {
	    case 'SPOTTER':
		$specificActivities = $this->config->spotterActivities;
		break;
	    case 'VENUE':
		$specificActivities = $this->config->venueActivities;
		break;
	    case 'JAMMER':
		$specificActivities = $this->config->jammerActivities;
		break;
	}
	$actArray = array_merge($sharedActivities, $specificActivities);
	return $actArray;
    }

    /**
     * \fn	errorManagement($errorMessage = null)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessage
     */
    private function errorManagement($errorMessage = null) {
	$this->error = $errorMessage;
	$this->activitesArray = array();
    }

}
?>