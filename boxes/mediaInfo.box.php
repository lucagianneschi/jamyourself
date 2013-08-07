<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info media per pagina media
 * \details		Recupera le informazioni del media, le inserisce in un oggetto e le passa alla view
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
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utils.box.php';

class EventInfo {

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
    public $title;

    function __construct($address, $attendee, $city, $commentCounter, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $loveCounter, $reviewCounter, $shareCounter, $tags, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($attendee) ? $this->attendee = NODATA : $this->attendee = $attendee;
	$this->attendeeCounter = count($attendee);
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
	is_null($description) ? $this->description = NODATA : $this->description = $description;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	$this->featuringCounter = count($featuring);
	is_null($image) ? $this->image = NODATA : $this->image = $image;
	is_null($invited) ? $this->invited = NODATA : $this->invited = $invited;
	$this->invitedCounter = count($invited);
	is_null($location) ? $this->location = NODATA : $this->location = $location;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($reviewCounter) ? $this->reviewCounter = NODATA : $this->reviewCounter = $reviewCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class RecordInfo {

    public $buylink;
    public $cover;
    public $description;
    public $featuring;
    public $genre;
    public $locationName;
    public $loveCounter;
    public $reviewCounter;
    public $shareCounter;
    public $tracklist;
    public $tags;
    public $title;
    public $year;

    function __construct($buylink, $cover, $description, $featuring, $genre, $locationName, $loveCounter, $reviewCounter, $shareCounter, $tracklist, $tags, $title, $year) {
	is_null($buylink) ? $this->buylink = NODATA : $this->buylink = $buylink;
	is_null($cover) ? $this->cover = NODATA : $this->cover = $cover;
	is_null($description) ? $this->description = NODATA : $this->description = $description;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	is_null($genre) ? $this->genre = NODATA : $this->genre = $genre;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($reviewCounter) ? $this->reviewCounter = NODATA : $this->reviewCounter = $reviewCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($tracklist) ? $this->tracklist = NODATA : $this->tracklist = $tracklist;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
	is_null($year) ? $this->year = NODATA : $this->year = $year;
    }

}

class SongInfo {

    public $duration;
    public $loveCounter;
    public $shareCounter;
    public $title;

    function __construct($duration, $loveCounter, $shareCounter, $title) {
	is_null($duration) ? $this->duration = NODATA : $this->duration = $duration;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class MediaInfoBox {

    public $fromUserInfo;
    public $mediaInfo;

    public function init($objectId, $className) {
	$mediaInfoBox = new MediaInfoBox();
	switch ($className) {
	    case 'Event':
		require_once CLASSES_DIR . 'event.class.php';
		require_once CLASSES_DIR . 'eventParse.class.php';
		$eventP = new EventParse();
		$event = $eventP->getEvent($objectId);
		if (get_class($event) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $event->getErrorMessage() . '<br/>';
		} elseif ($event->getActive() == true) {
		    $address = $event->getAddress();
		    $attendee = $event->getAttendee();
		    $city = $event->getCity();
		    $commentCounter = $event->getCommentCounter();
		    $description = $event->getDescription();
		    $eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
		    $featuring = $event->getFeaturing();
		    $image = $event->getImage();
		    $invited = $event->getInvited();
		    $location = $event->getLocation();
		    $locationName = $event->getLocationName();
		    $loveCounter = $event->getLoveCounter();
		    $reviewCounter = $event->getReviewCounter();
		    $shareCounter = $event->getShareCounter();
		    $tags = $event->getTags();
		    $title = $event->getTitle();

		    $eventInfo = new EventInfo($address, $attendee, $city, $commentCounter, $description, $eventDate, $featuring, $image, $invited, $location, $locationName, $loveCounter, $reviewCounter, $shareCounter, $tags, $title);
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
		}
		$mediaInfoBox->mediaInfo = $eventInfo;
		$mediaInfoBox->fromUserInfo = $userInfo;
		break;
	    case 'Record':
		require_once CLASSES_DIR . 'record.class.php';
		require_once CLASSES_DIR . 'recordParse.class.php';
		require_once CLASSES_DIR . 'song.class.php';
		require_once CLASSES_DIR . 'songParse.class.php';

		$recordP = new RecordParse();
		$record = $recordP->getRecord($objectId);
		if (get_class($record) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $record->getErrorMessage() . '<br/>';
		} elseif ($record->getActive() == true) {
		    $buylink = $record->getBuylink();
		    $cover = $record->getCover();
		    $description = $record->getDescription();

		    $featuring = array();
		    $parseUser = new UserParse();
		    $parseUser->whereRelatedTo('featuring', 'Record', $objectId);
		    $parseUser->where('active', true);
		    $parseUser->setLimit(1000);
		    $feats = $parseUser->getUsers();
		    if (count($feats) == 0) {
			$featuring = NODATA;
		    } elseif (get_class($feats) == 'Error') {
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

		    $genre = $record->getGenre();
		    $title = $record->getTitle();

		    $tracklist = array();
		    $parseSong = new SongParse();
		    $parseSong->wherePointer('record', 'Record', $objectId);
		    $parseSong->where('active', true);
		    $parseSong->setLimit(50);
		    $songs = $parseSong->getSongs();
		    if (count($songs) == 0) {
			$tracklist = NODATA;
		    } elseif (get_class($songs) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $songs->getErrorMessage() . '<br/>';
		    } else {
			foreach ($songs as $song) {
			    $duration = $song->getDuration();
			    $title = $song->getTitle();
			    $loveCounter = $song->getLoveCounter();
			    $shareCounter = $song->getShareCounter();
			    $songInfo = new SongInfo($duration, $loveCounter, $shareCounter, $title);
			    array_push($tracklist, $songInfo);
			}
		    }
		    $year = $record->getYear();
		    $recordInfo = new RecordInfo($buylink, $cover, $description, $featuring, $genre, $locationName, $loveCounter, $reviewCounter, $shareCounter, $tracklist, $tags, $title, $year);

		    $fromUserId = $record->getFromUser();
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
		}
		$mediaInfoBox->mediaInfo = $recordInfo;
		$mediaInfoBox->fromUserInfo = $userInfo;
		break;
	    case 'Album':
		break;
	    default:
		break;
	}
	return $mediaInfoBox;
    }

}

?>