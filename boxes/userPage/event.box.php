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
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class EventInfo {

    public $address;
    public $city;
    public $commentCounter;
    public $eventDate;
    public $featuring;
    public $locationName;
    public $loveCounter;
    public $reviewCounter;
    public $shareCounter;
    public $tags;
    public $thumbnail;
    public $title;

    function __construct($address, $city, $commentCounter, $eventDate, $featuring, $locationName, $loveCounter, $reviewCounter, $shareCounter, $tags, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($reviewCounter) ? $this->reviewCounter = NODATA : $this->reviewCounter = $reviewCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class EventBox {

    public $eventInfoArray;
    public $eventCounter;

    public function init($objectId) {

	$eventBox = new EventBox();
	$info = array();
	$counter = 0;
	$event = new EventParse();
	$event->wherePointer('fromUser','_User', $objectId);
	$event->where('active', true);
	$event->setLimit(1000);
	$event->orderByDescending('createdAt');
	$events = $event->getEvents();
	if (count($events) != 0) {
	    if (get_class($events) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
	    } else {
		foreach ($events as $event) {
		    $counter = ++$counter;

		    $address = $event->getAddress();
		    $city = $event->getCity();
		    $commentCounter = $event->getCommentCounter();
		    $eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
		    $featuring = array();
		    $parseUser = new UserParse();
		    $parseUser->whereRelatedTo('featuring','Event', $objectId);
		    $parseUser->where('active', true);
		    $parseUser->setLimit(1000);
		    $feats = $parseUser->getUsers();
		    echo $feats;
		    if (get_class($feats) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
		    } elseif (count($feats) != 0) {
			foreach ($feats as $user) {
			    $username = $user->getUsername();
			    array_push($featuring, $username);
			}
		    }
		    $locationName = $event->getLocationName();
		    $loveCounter = $event->getLoveCounter();
		    $reviewCounter = $event->getReviewCounter();
		    $shareCounter = $event->getShareCounter();
		    $tags = array();
		    if ($event->getTags() != 0) {
			foreach ($event->getTags() as $tag) {
			    array_push($tags, $tag);
			}
		    }
		    $thumbnail = $event->getThumbnail();
		    $title = $event->getTitle();
		    $eventInfo = new EventInfo($address, $city, $commentCounter, $eventDate, $featuring, $locationName, $loveCounter, $reviewCounter, $shareCounter, $tags, $thumbnail, $title);
		    array_push($info, $eventInfo);
		}
		$eventBox->eventInfoArray = $info;
		$eventBox->eventCounter = $counter;
	    }
	}
	return $eventBox;
    }

}

?>