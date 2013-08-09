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
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

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
    public $reviewCounter;
    public $tags;
    public $title;

    function __construct($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $reviewCounter, $tags, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($attendee) ? $this->attendee = NODATA : $this->attendee = $attendee;
	$this->attendeeCounter = count($attendee);
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($description) ? $this->description = NODATA : $this->description = $description;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	$this->featuringCounter = count($featuring);
	is_null($image) ? $this->image = NODATA : $this->image = $image;
	is_null($invited) ? $this->invited = NODATA : $this->invited = $invited;
	$this->invitedCounter = count($invited);
	is_null($location) ? $this->location = NODATA : $this->location = $location;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($reviewCounter) ? $this->reviewCounter = 0 : $this->reviewCounter = $reviewCounter;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class EventInfoForPersonalPage {

    public $address;
    public $city;
    public $counters;
    public $eventDate;
    public $featuring;
    public $fromUserInfo;
    public $locationName;
    public $reviewCounter;
    public $tags;
    public $thumbnail;
    public $title;

    function __construct($address, $city, $counters, $eventDate, $fromUserInfo, $featuring, $locationName, $reviewCounter, $tags, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($reviewCounter) ? $this->reviewCounter = NODATA : $this->reviewCounter = $reviewCounter;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class EventInfoForUploadReviewPage {

    public $address;
    public $city;
    public $eventDate;
    public $featuring;
    public $locationName;
    public $tags;
    public $thumbnail;
    public $title;

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

class EventBox {

    public $eventCounter;
    public $eventInfoArray;
    public $fromUserInfo;

    public function initForMediaPage($objectId) {
	$eventBox = new EventBox();
	$eventP = new EventParse();
	$event = $eventP->getEvent($objectId);
	if (get_class($event) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $event->getErrorMessage() . '<br/>';
	} elseif ($event->getActive() == true) {
	    $address = $event->getAddress();
	    $attendee = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('attendee', 'Event', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $att = $parseUser->getUsers();
	    if (get_class($att) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $att->getErrorMessage() . '<br/>';
	    } else {
		foreach ($att as $user) {
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
		    array_push($attendee, $userInfo);
		}
	    }
	    $city = $event->getCity();
	    $commentCounter = $event->getCommentCounter();
	    $description = $event->getDescription();
	    $eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
	    $featuring = array();
	    $parseUser1 = new UserParse();
	    $parseUser1->whereRelatedTo('featuring', 'Event', $objectId);
	    $parseUser1->where('active', true);
	    $parseUser1->setLimit(1000);
	    $feats = $parseUser1->getUsers();
	    if (get_class($feats) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $feats->getErrorMessage() . '<br/>';
	    } else {
		foreach ($feats as $user) {
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
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
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $inv->getErrorMessage() . '<br/>';
	    } else {
		foreach ($inv as $user) {
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
		    array_push($invited, $userInfo);
		}
	    }
	    $geopoint = $event->getLocation();
	    $location = array('latitude' => $geopoint->location['latitude'], 'longitude' => $geopoint->location['longitude']);
	    $locationName = $event->getLocationName();
	    $loveCounter = $event->getLoveCounter();
	    $reviewCounter = $event->getReviewCounter();
	    $shareCounter = $event->getShareCounter();
	    $tags = $event->getTags();
	    $title = $event->getTitle();
	    $counters = new Counters($commentCounter, $loveCounter, $shareCounter);
	    $eventInfo = new EventInfoForMediaPage($address, $attendee, $city, $counters, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $reviewCounter, $tags, $title);

	    $fromUserId = $event->getFromUser();
	    $userP = new UserParse();
	    $fromUser = $userP->getUser($fromUserId);
	    if (get_class($fromUser) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $fromUser->getErrorMessage() . '<br/>';
	    } else {
		$thumbnail = $fromUser->getProfileThumbnail();
		$type = $fromUser->getType();
		$username = $fromUser->getUsername();
		$userInfo = new UserInfo($thumbnail, $type, $username);
	    }
	    $eventBox->eventCounter = NDB;
	    $eventBox->eventInfoArray = $eventInfo;
	    $eventBox->fromUserInfo = $userInfo;
	}
	return $eventBox;
    }

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
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
	} else {
	    foreach ($events as $event) {
		$counter = ++$counter;

		$address = $event->getAddress();
		$city = $event->getCity();
		$commentCounter = $event->getCommentCounter();
		$loveCounter = $event->getLoveCounter();
		$reviewCounter = $event->getReviewCounter();
		$shareCounter = $event->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $shareCounter);
		$eventDate = $event->getEventDate()->format('d-m-Y H:i:s');

		$featuring = array();
		$parseUser = new UserParse();
		$parseUser->whereRelatedTo('featuring', 'Event', $objectId);
		$parseUser->where('active', true);
		$parseUser->setLimit(1000);
		$feats = $parseUser->getUsers();
		if (get_class($feats) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $feats->getErrorMessage() . '<br/>';
		} else {
		    foreach ($feats as $user) {
			$thumbnail = $user->getProfileThumbnail();
			$type = $user->getType();
			$username = $user->getUsername();
			$userInfo = new UserInfo($thumbnail, $type, $username);
			array_push($featuring, $userInfo);
		    }
		}
		$fromUserInfo = null;
		$locationName = $event->getLocationName();

		$tags = array();
		if (count($event->getTags()) != 0 && $event->getTags() != null) {
		    foreach ($event->getTags() as $tag) {
			array_push($tags, $tag);
		    }
		}
		$thumbnail = $event->getThumbnail();
		$title = $event->getTitle();
		$eventInfo = new EventInfoForPersonalPage($address, $city, $counters, $eventDate, $fromUserInfo, $featuring, $locationName, $reviewCounter, $tags, $thumbnail, $title);
		array_push($info, $eventInfo);
	    }
	    $eventBox->eventCounter = $counter;
	    $eventBox->eventInfoArray = $info;
	    $eventBox->fromUserInfo = NDB;
	}
	return $eventBox;
    }

    public function initForUploadReviewPage($objectId) {
	$eventBox = new EventBox();
	$eventBox->eventCounter = NDB;

	$recordP = new EventParse();
	$event = $recordP->getEvent($objectId);
	if (get_class($event) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $event->getErrorMessage() . '<br/>';
	} else {
	    $address = $event->getAddress();
	    $city = $event->getCity();
	    $eventDate = $event->getEventDate();
	    $featuring = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('featuring', 'Event', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $feats = $parseUser->getUsers();
	    if (get_class($feats) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $feats->getErrorMessage() . '<br/>';
	    } else {
		foreach ($feats as $user) {
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
		    array_push($featuring, $userInfo);
		}
	    }
	    $locationName = $event->getLocationName();
	    $tags = array();
	    if (count($event->getTags()) != 0 && $event->getTags() != null) {
		foreach ($event->getTags() as $tag) {
		    array_push($tags, $tag);
		}
	    }
	    $thumbnail = $event->getThumbnail();
	    $title = $event->getTitle();
	    $eventInfo = new EventInfoForUploadReviewPage($address, $city, $eventDate, $featuring, $locationName, $tags, $thumbnail, $title);
	    $eventBox->recordInfoArray = $eventInfo;

	    $fromUserP = new UserParse();
	    $fromUser = $fromUserP->getUser($event->getFromUser());
	    $thumbnailUser = $fromUser->getProfileThumbnail();
	    $type = $fromUser->getType();
	    $username = $fromUser->getUsername();
	    $userInfo = new UserInfo($thumbnailUser, $type, $username);
	    $eventBox->fromUserInfo = $userInfo;
	}
	return $eventBox;
    }

}

?>