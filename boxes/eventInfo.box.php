<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event per pagina event
 * \details		Recupera le informazioni dell'evento, le inserisce in un oggetto e le passa alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		trattare attendee ed invited	
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

class EventInfoBox {

    public $address;
    public $attendee;
    public $attendeeCounter;
    public $city;
    public $commentCounter;
    public $description;
    public $eventDate;
    public $featuring;
    public $featuringCounter;
    public $image;
    public $invited;
    public $invitedCounter;
    public $location;
    public $locationName;
    public $loveCounter;
    public $reviewCounter;
    public $shareCounter;
    public $tags;
    public $thumbnail;
    public $title;
    public $type;
    public $username;

    public function init($objectId) {

	$eventInfoBox = new EventInfoBox ();

	$eventP = new EventParse();
	$event = $eventP->getEvent($objectId);
	if ($event->getActive() == true) {
	    is_null($event->getAddress()) ? $eventInfoBox->address = NODATA : $eventInfoBox->address = $event->getAddress();
	    is_null($event->getCity()) ? $eventInfoBox->city = NODATA : $eventInfoBox->city = $event->getCity();
	    is_null($event->getCommentCounter()) ? $eventInfoBox->commentCounter = NODATA : $eventInfoBox->commentCounter = $event->getCommentCounter();
	    is_null($event->getDescription()) ? $eventInfoBox->description = NODATA : $eventInfoBox->description = $event->getDescription();
	    is_null($event->getEventDate()) ? $eventInfoBox->eventDate = NODATA : $eventInfoBox->eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
	    is_null($event->getFeaturing()) ? $eventInfoBox->featuring = NODATA : $eventInfoBox->featuring = $event->getFeaturing();
	    is_null($event->getLocation()) ? $eventInfoBox->location = NODATA : $eventInfoBox->location = $event->getLocation();
	    is_null($event->getLocationName()) ? $eventInfoBox->locationName = NODATA : $eventInfoBox->locationName = $event->getLocationName();
	    is_null($event->getLoveCounter()) ? $eventInfoBox->loveCounter = NODATA : $eventInfoBox->loveCounter = $event->getLoveCounter();
	    is_null($event->getReviewCounter()) ? $eventInfoBox->reviewCounter = NODATA : $eventInfoBox->reviewCounter = $event->getReviewCounter();
	    is_null($event->getShareCounter()) ? $eventInfoBox->shareCounter = NODATA : $eventInfoBox->shareCounter = $event->getShareCounter();
	    is_null($event->getTags()) ? $eventInfoBox->tags = NODATA : $eventInfoBox->tags = $event->getTags();
	    is_null($event->getTitle()) ? $eventInfoBox->title = NODATA : $eventInfoBox->title = $event->getTitle();

	    $fromUserP = new UserParse();
	    $fromUser = $fromUserP->getUser($event->getFromUser);
	    if ($fromUser != null) {
		is_null($fromUser->profilePictureThumbnail) ? $eventInfoBox->thumbnail = NODATA : $eventInfoBox->thumbnail = $fromUser->profilePictureThumbnail;
		is_null($fromUser->type) ? $eventInfoBox->type = NODATA : $eventInfoBox->type = $fromUser->type;
		is_null($fromUser->username) ? $eventInfoBox->username = NODATA : $eventInfoBox->username = $fromUser->username;
		
	    }
	    $featuring = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('featuring', 'Event', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $feats = $parseUser->getUsers();
	    if (count($feats) == 0) {
		$eventInfoBox->featuring = NODATA;
	    } elseif (get_class($feats) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $feats->getErrorMessage() . '<br/>';
	    } else {
		$featuringCounter = 0;
		foreach ($feats as $user) {
		    $featuringCounter = ++$featuringCounter;
		    $username = $user->getUsername();
		    array_push($featuring, $username);
		}
		$eventInfoBox->featuringCounter = $featuringCounter;
		$eventInfoBox->featuring = $featuring;
	    }
	}
	return $eventInfoBox;
    }

}

?>