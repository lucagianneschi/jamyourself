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
 * \todo		sistemare il campo featuring	
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
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
    public $tags;
    public $title;

    /**
     * \fn	__construct($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $tags, $title)
     * \brief	construct for the EventInfoForMediaPage class
     * \param	$address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $tags, $title
     */
    function __construct($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $tags, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($attendee) ? $this->attendee = NODATA : $this->attendee = $attendee;
	$this->attendeeCounter = count($attendee);
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($description) ? $this->description = NODATA : $this->description = $description;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	$this->featuringCounter = count($featuring);
	is_null($image) ? $this->image = DEFEVENTIMAGE : $this->image = $image;
	is_null($invited) ? $this->invited = NODATA : $this->invited = $invited;
	$this->invitedCounter = count($invited);
	is_null($location) ? $this->location = NODATA : $this->location = $location;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
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
    public $fromUserInfo;
    public $locationName;
    public $objectId;
    public $tags;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($address, $city, $counters, $eventDate, $fromUserInfo, $featuring, $locationName, $tags, $thumbnail, $title)
     * \brief	construct for the EventInfoForPersonalPage class
     * \param	$address, $city, $counters, $eventDate, $fromUserInfo, $featuring, $locationName, $tags, $thumbnail, $title
     */
    function __construct($address, $city, $counters, $eventDate, $fromUserInfo, $featuring, $locationName, $objectId, $tags, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($objectId) ? $this->objectId = NODATA : $this->objectId = $objectId;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($thumbnail) ? $this->thumbnail = DEFEVENTTHUMB : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	EventInfoForUploadReviewPage class 
 * \details	contains info for event to be displayed in the upload review
 */
class EventInfoForUploadReviewPage {

    public $address;
    public $city;
    public $eventDate;
    public $featuring;
    public $locationName;
    public $tags;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($address, $city, $eventDate, $featuring, $locationName, $tags, $thumbnail, $title)
     * \brief	construct for the EventInfoForUploadReviewPage class
     * \param	$address, $city, $eventDate, $featuring, $locationName, $tags, $thumbnail, $title
     */
    function __construct($address, $city, $eventDate, $featuring, $locationName, $tags, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	EventBox class 
 * \details	box class to pass info to the view 
 */
class EventBox {

    public $eventCounter;
    public $eventInfoArray;
    public $fromUserInfo;

    /**
     * \fn	initForMediaPage($objectId)
     * \brief	Init EventBox instance for Media Page
     * \param	$objectId for event
     * \return	eventBox
     */
    public function initForMediaPage($objectId) {
	$eventBox = new EventBox();
	$eventP = new EventParse();
	$event = $eventP->getEvent($objectId);
	if (get_class($event) == 'Error') {
	    return $event;
	} elseif ($event->getActive() == true) {
	    $encodedAddress = $event->getAddress();
	    $address = parse_decode_string($encodedAddress);
	    $attendee = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('attendee', 'Event', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $att = $parseUser->getUsers();
	    if (get_class($att) == 'Error') {
		return $att;
	    } else {
		foreach ($att as $user) {
		    $objectId = $user->getObjectId();
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $encodedUsername = $user->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		    array_push($attendee, $userInfo);
		}
	    }
	    $encodedCity = $event->getCity();
	    $city = parse_decode_string($encodedCity);
	    $commentCounter = $event->getCommentCounter();
	    $encodedDescription = $event->getDescription();
	    $description = parse_decode_string($encodedDescription);
	    $eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
	    $featuring = array();
	    $parseUser1 = new UserParse();
	    $parseUser1->whereRelatedTo('featuring', 'Event', $objectId);
	    $parseUser1->where('active', true);
	    $parseUser1->setLimit(1000);
	    $feats = $parseUser1->getUsers();
	    if (get_class($feats) == 'Error') {
		return $feats;
	    } else {
		foreach ($feats as $user) {
		    $objectId = $user->getObjectId();
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $encodedUsername = $user->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		    array_push($featuring, $userInfo);
		}
	    }
	    $image = $event->getImage();
	    $invited = array();
	    $parseUser2 = new UserParse();
	    $parseUser2->whereRelatedTo('invited', 'Event', $objectId);
	    $parseUser2->where('active', true);
	    $parseUser2->setLimit(1000);
	    $inv = $parseUser2->getUsers();
	    if (get_class($inv) == 'Error') {
		return $inv;
	    } else {
		foreach ($inv as $user) {
		    $objectId = $user->getObjectId();
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $encodedUsername = $user->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		    array_push($invited, $userInfo);
		}
	    }
	    $geopoint = $event->getLocation();
	    $location = array('latitude' => $geopoint->location['latitude'], 'longitude' => $geopoint->location['longitude']);
	    $encodedLocationName = $event->getLocationName();
	    $locationName = parse_decode_string($encodedLocationName);
	    $loveCounter = $event->getLoveCounter();
	    $reviewCounter = $event->getReviewCounter();
	    $shareCounter = $event->getShareCounter();
	    $tags = $event->getTags();
	    $encodedTitle = $event->getTitle();
	    $title = parse_decode_string($encodedTitle);
	    $counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
	    if (empty($attendee)) {
		$attendee = NOATTENDEE;
	    } elseif (empty($featuring)) {
		$featuring = NOFEATEVE;
	    } elseif (empty($invited)) {
		$invited = NOINVITED;
	    }
	    $eventInfo = new EventInfoForMediaPage($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $reviewCounter, $tags, $title);

	    $fromUserId = $event->getFromUser();
	    $userP = new UserParse();
	    $fromUser = $userP->getUser($fromUserId);
	    if (get_class($fromUser) == 'Error') {
		return $fromUser;
	    } else {
		$objectId = $user->getObjectId();
		$thumbnail = $user->getProfileThumbnail();
		$type = $user->getType();
		$encodedUsername = $user->getUsername();
		$username = parse_decode_string($encodedUsername);
		$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
	    }
	    $eventBox->eventCounter = NDB;
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

	$eventBox = new EventBox();
	$info = array();
	$counter = 0;
	$event = new EventParse();
	$event->wherePointer('fromUser', '_User', $objectId);
	$event->where('active', true);
	$event->setLimit(1000);
	$event->orderByDescending('createdAt');
	$events = $event->getEvents();
	if (get_class($events) == 'Error') {
	    return $events;
	} else {
	    foreach ($events as $event) {
		$counter = ++$counter;

		$encodedAddress = $event->getAddress();
		$address = parse_decode_string($encodedAddress);
		$encodedCity = $event->getCity();
		$city = parse_decode_string($encodedCity);
		$commentCounter = $event->getCommentCounter();
		$loveCounter = $event->getLoveCounter();
		$reviewCounter = $event->getReviewCounter();
		$shareCounter = $event->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$eventDate = $event->getEventDate()->format('d-m-Y H:i:s');

		$featuring = array();
		$parseUser = new UserParse();
		$parseUser->whereRelatedTo('featuring', 'Event', $objectId);
		$parseUser->where('active', true);
		$parseUser->setLimit(1000);
		$feats = $parseUser->getUsers();
		if (get_class($feats) == 'Error') {
		    return $feats;
		} else {
		    foreach ($feats as $user) {
			$objectId = $user->getObjectId();
			$thumbnail = $user->getProfileThumbnail();
			$type = $user->getType();
			$encodedUsername = $user->getUsername();
			$username = parse_decode_string($encodedUsername);
			$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			array_push($featuring, $userInfo);
		    }
		}
		$fromUserInfo = null;
		$encodedLocationName = $event->getLocationName();
		$locationName = parse_decode_string($encodedLocationName);

		$objectId = $event->getObjectId();

		$tags = array();
		if (count($event->getTags()) > 0 && $event->getTags() != null) {
		    foreach ($event->getTags() as $tag) {
			$tag = parse_decode_string($tag);
			array_push($tags, $tag);
		    }
		}
		$thumbnail = $event->getThumbnail();
		$encodedTitle = $event->getTitle();
		$title = parse_decode_string($encodedTitle);
		if (empty($featuring)) {
		    $featuring = NOFEATEVE;
		}
		$eventInfo = new EventInfoForPersonalPage($address, $city, $counters, $eventDate, $fromUserInfo, $featuring, $locationName, $objectId, $tags, $thumbnail, $title);
		array_push($info, $eventInfo);
	    }
	    $eventBox->eventCounter = $counter;
	    $eventBox->eventInfoArray = $info;
	    $eventBox->fromUserInfo = NDB;
	}
	return $eventBox;
    }

    /**
     * \fn	initForUploadReviewPage($objectId)
     * \brief	Init EventBox instance for Upload Review Page
     * \param	$objectId for the event
     * \return	eventBox
     */
    public function initForUploadReviewPage($objectId) {
	$eventBox = new EventBox();
	$eventBox->eventCounter = NDB;

	$recordP = new EventParse();
	$event = $recordP->getEvent($objectId);
	if (get_class($event) == 'Error') {
	    return $event;
	} else {

	    $encodedAddress = $event->getAddress();
	    $address = parse_decode_string($encodedAddress);
	    $encodedCity = $event->getCity();
	    $city = parse_decode_string($encodedCity);
	    $eventDate = $event->getEventDate();
	    $featuring = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('featuring', 'Event', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $feats = $parseUser->getUsers();
	    if (get_class($feats) == 'Error') {
		return $feats;
	    } else {
		foreach ($feats as $user) {
		    $objectId = $user->getObjectId();
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $encodedUsername = $user->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		    array_push($featuring, $userInfo);
		}
	    }
	    $encodedLocationName = $event->getLocationName();
	    $locationName = parse_decode_string($encodedLocationName);
	    $tags = array();
	    if (count($event->getTags()) > 0 && $event->getTags() != null) {
		foreach ($event->getTags() as $tag) {
		    $tag = parse_decode_string($tag);
		    array_push($tags, $tag);
		}
	    }
	    $thumbnail = $event->getThumbnail();
	    $encodedTitle = $event->getTitle();
	    $title = parse_decode_string($encodedTitle);
	    if (empty($featuring)) {
		$featuring = NOFEATEVE;
	    }
	    $eventInfo = new EventInfoForUploadReviewPage($address, $city, $eventDate, $featuring, $locationName, $tags, $thumbnail, $title);
	    $eventBox->recordInfoArray = $eventInfo;

	    $fromUserP = new UserParse();
	    $fromUser = $fromUserP->getUser($event->getFromUser());
	    if (get_class($fromUser) == 'Error') {
		return $fromUser;
	    }
	    $objectIdUser = $fromUser->getObjectId();
	    $thumbnailUser = $fromUser->getProfileThumbnail();
	    $type = $fromUser->getType();
	    $encodedUsername = $fromUser->getUsername();
	    $username = parse_decode_string($encodedUsername);
	    $userInfo = new UserInfo($objectIdUser, $thumbnailUser, $type, $username);
	    $eventBox->fromUserInfo = $userInfo;
	}
	return $eventBox;
    }

}

?>