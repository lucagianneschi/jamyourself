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
require_once BOXES_DIR . 'utils.box.php';

class EventInfo {

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

    function __construct($address, $city, $counters, $eventDate,$fromUserInfo, $featuring, $locationName, $reviewCounter, $tags, $thumbnail, $title) {
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
//rivedere se vengono mostrati diversi a seconda del profilo
class EventBox {

    public $eventInfoArray;
    public $eventCounter;

    public function init($objectId) {

	$eventBox = new EventBox();
	$info = array();
	$counter = 0;
	$event = new EventParse();
	$event->wherePointer('fromUser', '_User', $objectId);
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
		    $parseUser->whereRelatedTo('featuring', 'Event', $objectId);
		    $parseUser->where('active', true);
		    $parseUser->setLimit(1000);
		    $feats = $parseUser->getUsers();
		    if (count($feats) != 0) {
			if (get_class($feats) == 'Error') {
			    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
			} else {
			    foreach ($feats as $user) {
				//da verficare
				var_dump($user);
				//da verficare
				if ($user != null) {
				    $username = $user->getUsername();
				}
				else
				    $username = NODATA;
				array_push($featuring, $username);
			    }
			}
		    }
		    $locationName = $event->getLocationName();
		    $loveCounter = $event->getLoveCounter();
		    $reviewCounter = $event->getReviewCounter();
		    $shareCounter = $event->getShareCounter();
		    $counters = new Counters($commentCounter, $loveCounter, $shareCounter);
		    $tags = array();
		    if (count($event->getTags()) != 0 && $event->getTags() != null) {
			foreach ($event->getTags() as $tag) {
			    array_push($tags, $tag);
			}
		    }
		    $thumbnail = $event->getThumbnail();
		    $title = $event->getTitle();
		    $eventInfo = new EventInfo($address, $city, $counters, $eventDate, $featuring, $locationName,$reviewCounter, $tags, $thumbnail, $title);
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