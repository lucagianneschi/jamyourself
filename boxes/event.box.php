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
 * \todo		sistemare il campo featuring, uso whereInclude	
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	EventInfoForMediaPage class 
 * \details	contains info for event to be displayed in the media page
 */
class EventInfoForMediaPage {

    public $address;
    public $attendee;
    public $attendeeCounter;
    public $city;
    public $counters;
    public $description;
    public $eventDate;
    public $featuring;
    public $featuringCounter;
    public $image;
    public $invited;
    public $invitedCounter;
    public $location;
    public $locationName;
    public $showLove;
    public $tags;
    public $title;

    /**
     * \fn	__construct($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $tags, $title)
     * \brief	construct for the EventInfoForMediaPage class
     * \param	$address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $tags, $title
     */
    function __construct($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $showLove, $tags, $title) {
        global $boxes;
        is_null($address) ? $this->address = $boxes['NODATA'] : $this->address = $address;
        is_null($attendee) ? $this->attendee = $boxes['NOATTENDEE'] : $this->attendee = $attendee;
        ($this->attendee === $boxes['NOATTENDEE']) ? $this->attendeeCounter = 0 : $this->attendeeCounter = count($attendee);
        is_null($city) ? $this->city = $boxes['NODATA'] : $this->city = $city;
        is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
        is_null($description) ? $this->description = $boxes['NODATA'] : $this->description = $description;
        is_null($eventDate) ? $this->eventDate = $boxes['NODATA'] : $this->eventDate = $eventDate;
        is_null($featuring) ? $this->featuring = $boxes['NOFEATEVE'] : $this->featuring = $featuring;
        ($this->featuring === $boxes['NOFEATEVE']) ? $this->featuringCounter = 0 : $this->featuringCounter = count($featuring);
        is_null($image) ? $this->image = DEFEVENTIMAGE : $this->image = $image;
        is_null($invited) ? $this->invited = $boxes['NOINVITED'] : $this->invited = $invited;
        ($this->invited === $boxes['NOINVITED']) ? $this->invitedCounter = 0 : $this->invitedCounter = count($invited);
        is_null($location) ? $this->location = $boxes['NODATA'] : $this->location = $location;
        is_null($locationName) ? $this->locationName = $boxes['NODATA'] : $this->locationName = $locationName;
        is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
        is_null($tags) ? $this->tags = $boxes['NOTAG'] : $this->tags = $tags;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

/**
 * \brief	EventInfoForPersonalPage class 
 * \details	contains info for event to be displayed in the personal page
 */
class EventInfoForPersonalPage {

    public $address;
    public $city;
    public $counters;
    public $eventDate;
    public $featuring;
    public $locationName;
    public $objectId;
    public $showLove;
    public $tags;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($address, $city, $counters, $eventDate, $fromUserInfo, $featuring, $locationName, $tags, $thumbnail, $title)
     * \brief	construct for the EventInfoForPersonalPage class
     * \param	$address, $city, $counters, $eventDate, $featuring, $locationName, $tags, $thumbnail, $title
     */
    function __construct($address, $city, $counters, $eventDate, $featuring, $locationName, $objectId, $showLove, $tags, $thumbnail, $title) {
        global $boxes;
        is_null($address) ? $this->address = $boxes['NODATA'] : $this->address = $address;
        is_null($city) ? $this->city = $boxes['NODATA'] : $this->city = $city;
        is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
        is_null($eventDate) ? $this->eventDate = $boxes['NODATA'] : $this->eventDate = $eventDate;
        is_null($featuring) ? $this->featuring = $boxes['NOFEATEVE'] : $this->featuring = $featuring;
        is_null($locationName) ? $this->locationName = $boxes['NODATA'] : $this->locationName = $locationName;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
        is_null($tags) ? $this->tags = $boxes['NOTAG'] : $this->tags = $tags;
        is_null($thumbnail) ? $this->thumbnail = DEFEVENTTHUMB : $this->thumbnail = $thumbnail;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

/**
 * \brief	EventBox class 
 * \details	box class to pass info to the view 
 */
class EventBox {

    public $config;
    public $eventCounter;
    public $eventInfoArray;
    public $fromUserInfo;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/event.config.json"), false);
    }

//    /**
//     * \fn	getRelatedUsers($objectId, $field, $all, $page)
//     * \brief	Convenience method to get all kind of related User to the event for each page
//     * \param	$objectId for event, $field to be related to, $all BOOL: Yes to retrieve all related users or using the limit from config file, $page the page which calls the method
//     * \return	userArray array of userInfo object
//     */
//    public function getRelatedUsers($objectId, $field, $all, $page) {
//	global $boxes;
//	$userArray = array();
//	require_once CLASSES_DIR . 'user.class.php';
//	require_once CLASSES_DIR . 'userParse.class.php';
//	$parseUser = new UserParse();
//	$parseUser->whereRelatedTo($field, 'Event', $objectId);
//	$parseUser->where('active', true);
//	if ($all == true) {
//	    $parseUser->setLimit(1000);
//	} else {
//	    switch ($page) {
//		case 'Media':
//		    switch ($field) {
//			case 'attendee':
//			    $parseUser->setLimit($this->config->limitAttendeeForMediaPage);
//			    break;
//			case 'featuring':
//			    $parseUser->setLimit($this->config->limitFeaturingForMediaPage);
//			    break;
//			case 'invited':
//			    $parseUser->setLimit($this->config->limitInvitedForMediaPage);
//			    break;
//		    }
//		    break;
//		case 'Personal':
//		    $parseUser->setLimit($this->config->limitFeaturingForPersonalPage);
//		    break;
//	    }
//	}
//	$users = $parseUser->getUsers();
//	if ($users instanceof Error) {
//	    return $users;
//	} elseif (is_null($users)) {
//	    switch ($field) {
//		case 'attendee':
//		    $users = $boxes['NOATTENDEE'];
//		    break;
//		case 'featuring':
//		    $users = $boxes['NOFEATEVE'];
//		    break;
//		case 'invited':
//		    $users = $boxes['NOINVITED'];
//		    break;
//	    }
//	    return $users;
//	} else {
//	    foreach ($users as $user) {
//		$userId = $user->getObjectId();
//		$thumbnail = $user->getProfileThumbnail();
//		$type = $user->getType();
//		$encodedUsername = $user->getUsername();
//		$username = parse_decode_string($encodedUsername);
//		$userInfo = new UserInfo($userId, $thumbnail, $type, $username);
//		array_push($userArray, $userInfo);
//	    }
//	}
//	return $userArray;
//    }

    /**
     * \fn	initForMediaPage($objectId)
     * \brief	Init EventBox instance for Media Page
     * \param	$objectId for event
     * \return	eventBox
     * todo utilizzate whereInclude
     */
    public function initForMediaPage($objectId) {
	global $boxes;
	$currentUserId = sessionChecker();
	$eventBox = new EventBox();
	$eventP = new EventParse();
	$eventBox->eventCounter = $boxes['NDB'];
	$eventP->where('objectId', $objectId);
	$eventP->where('active', true);
	$eventP->whereInclude('fromUser');
	$eventP->setLimit($this->config->limitEventForMediaPage);
	$events = $eventP->getEvents();
	if ($events instanceof Error) {
	    return $events;
	} elseif (is_null($events)) {
	    $eventBox->eventInfoArray = $boxes['NODATA'];
	    $eventBox->fromUserInfo = $boxes['NODATA'];
	    return $eventBox;
	} else {
	    require_once CLASSES_DIR . 'user.class.php';
	    require_once CLASSES_DIR . 'userParse.class.php';
	    foreach ($events as $event) {
		$showLove = true;
		$address = parse_decode_string($event->getAddress());
		$attendee = getRelatedUsers($event->getObjectId(), 'attendee', 'Event', false, $this->config->limitAttendeeForMediaPage);
		//$attendee = $eventBox->getRelatedUsers($event->getObjectId(), 'attendee', false, 'Media');
		$city = parse_decode_string($event->getCity());
		$commentCounter = $event->getCommentCounter();
		$description = parse_decode_string($event->getDescription());
		$eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
		$featuring = getRelatedUsers($event->getObjectId(), 'featuring', 'Event', false, $this->config->limitFeaturingForMediaPage);
		//$featuring = $eventBox->getRelatedUsers($event->getObjectId(), 'featuring', false, 'Media');
		$image = $event->getImage();
		$invited = getRelatedUsers($event->getObjectId(), 'invited', 'Event', false, $this->config->limitInvitedForMediaPage);
		//$invited = $eventBox->getRelatedUsers($event->getObjectId(), 'invited', false, 'Media');
		$geopoint = $event->getLocation();
		$location = array('latitude' => $geopoint->location['latitude'], 'longitude' => $geopoint->location['longitude']);
		$locationName = parse_decode_string($event->getLocationName());
		$loveCounter = $event->getLoveCounter();
		$reviewCounter = $event->getReviewCounter();
		$shareCounter = $event->getShareCounter();
		$tags = array();
		if (count($event->getTags()) > 0) {
		    foreach ($event->getTags() as $tag) {
			$tag = parse_decode_string($tag);
			array_push($tags, $tag);
		    }
		}
		$title = parse_decode_string($event->getTitle());
		$lovers = $event->getLovers();
		if (in_array($currentUserId, $lovers)) {
		    $showLove = false;
		}
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$eventInfo = new EventInfoForMediaPage($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $showLove, $tags, $title);
		$userId = $event->getFromUser()->getObjectId();
		$thumbnail = $event->getFromUser()->getProfileThumbnail();
		$type = $event->getFromUser()->getType();
		$username = parse_decode_string($event->getFromUser()->getUsername());
		$userInfo = new UserInfo($userId, $thumbnail, $type, $username);
	    }
	    $eventBox->eventInfoArray = $eventInfo;
	    $eventBox->fromUserInfo = $userInfo;
	}
	return $eventBox;
    }

    /**
     * \fn	initForPersonalPage($objectId)
     * \brief	Init EventBox instance for Personal Page
     * \param	$objectId for user that owns the page
     * \return	eventBox
     */
    public function initForPersonalPage($objectId) {
	global $boxes;
	$currentUserId = sessionChecker();
	$info = array();
	$counter = 0;
	$eventBox = new EventBox();
	$eventBox->fromUserInfo = $boxes['NDB'];
	$event = new EventParse();
	$event->wherePointer('fromUser', '_User', $objectId);
	$event->where('active', true);
	$event->setLimit($this->config->limitEventForPersonalPage);
	$event->orderByDescending('eventDate');
	$events = $event->getEvents();
	if ($events instanceof Error) {
	    return $events;
	} elseif (is_null($events)) {
	    $eventBox->eventInfoArray = $boxes['NODATA'];
	    $eventBox->eventCounter = $boxes['NODATA'];
	    return $eventBox;
	} else {
	    require_once CLASSES_DIR . 'user.class.php';
	    require_once CLASSES_DIR . 'userParse.class.php';
	    foreach ($events as $event) {
		$counter = ++$counter;
		$showLove = true;
		$address = parse_decode_string($event->getAddress());
		$city = parse_decode_string($event->getCity());
		$commentCounter = $event->getCommentCounter();
		$loveCounter = $event->getLoveCounter();
		$reviewCounter = $event->getReviewCounter();
		$shareCounter = $event->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
		$featuring = getRelatedUsers($event->getObjectId(), 'featuring', 'Event', false, $this->config->limitFeaturingForPersonalPage);
		//$featuring = $eventBox->getRelatedUsers($event->getObjectId(), 'featuring', false, 'Personal');
		$locationName = parse_decode_string($event->getLocationName());
		$eventId = $event->getObjectId();
		$tags = array();
		if (count($event->getTags()) > 0) {
		    foreach ($event->getTags() as $tag) {
			$tag = parse_decode_string($tag);
			array_push($tags, $tag);
		    }
		}
		$thumbnail = $event->getThumbnail();
		$title = parse_decode_string($event->getTitle());
		$lovers = $event->getLovers();
		if (in_array($currentUserId, $lovers)) {
		    $showLove = false;
		}
		$eventInfo = new EventInfoForPersonalPage($address, $city, $counters, $eventDate, $featuring, $locationName, $eventId, $showLove, $tags, $thumbnail, $title);
		array_push($info, $eventInfo);
	    }
	    $eventBox->eventCounter = $counter;
	    $eventBox->eventInfoArray = $info;
	}
	return $eventBox;
    }

}

?>