<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento ultime activities dell'utente
 * \details		Recupera le informazioni delle ultime activities dell'utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	AlbumInfoForPersonalPage class 
 * \details	contains info for album to be displayed in Personal Page
 */
class AlbumInfoForPersonalPage {

    public $imageArray;
    public $imageCounter;
    public $title;

    /**
     * \fn	__construct($imageArray, $imageCounter, $title)
     * \brief	construct for the AlbumInfoForPersonalPage class
     * \param	$imageArray, $imageCounter, $title
     */
    function __construct($imageArray, $imageCounter, $title) {
	is_null($imageArray) ? $this->imageArray = NODATA : $this->imageArray = $imageArray;
	is_null($imageCounter) ? $this->imageCounter = NODATA : $this->imageCounter = $imageCounter;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	EventInfoForPersonalPage class 
 * \details	contains info for event to be displayed in Personal Page
 */
class EventInfoForPersonalPage {

    public $address;
    public $city;
    public $eventDate;
    public $locationName;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($address, $city, $eventDate, $locationName, $thumbnail, $title)
     * \brief	construct for the ImageInfoForPersonalPage class
     * \param	$address, $city, $eventDate, $locationName, $thumbnail, $title
     */
    function __construct($address, $city, $eventDate, $locationName, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	ImageInfoForPersonalPage class 
 * \details	contains info for image to be displayed in Personal Page
 */
class ImageInfoForPersonalPage {

    public $thumbnail;

    /**
     * \fn	__construct($thumbnail)
     * \brief	construct for the ImageInfoForPersonalPage class
     * \param	$thumbnail
     */
    function __construct($thumbnail) {
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
    }

}

/**
 * \brief	RecordInfoForPersonalPage class 
 * \details	contains info for record to be displayed in Personal Page
 */
class RecordInfoForPersonalPage {

    public $fromUserInfo;
    public $songTitle;
    public $thumbnailCover;
    public $title;

    /**
     * \fn	__construct($fromUserInfo, $songTitle, $thumbnailCover, $title)
     * \brief	construct for the RecordInfoForPersonalPage class
     * \param	$fromUserInfo, $songTitle, $thumbnailCover, $title
     */
    function __construct($fromUserInfo, $songTitle, $thumbnailCover, $title) {
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($songTitle) ? $this->songTitle = NODATA : $this->songTitle = $songTitle;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	ActivityBox class 
 * \details	box class to pass info to the view 
 */
class ActivityBox {

    public $albumInfo;
    public $eventInfo;
    public $recordInfo;

    /**
     * \fn	initForPersonalPage($objectId, $type)
     * \brief	Init ActivityBox instance for Personal Page
     * \param	$objectId for user that owns the page, $type of user that owns the page
     * \return	activityBox
     */
    public function initForPersonalPage($objectId, $type) {
	$activityBox = new ActivityBox();

	$albumUpdated = new AlbumParse();
	$albumUpdated->setLimit(1);
	$albumUpdated->wherePointer('fromUser', '_User', $objectId);
	$albumUpdated->where('active', true);
	$albumUpdated->orderByDescending('updatedAt');
	$albums = $albumUpdated->getAlbums();
	if (get_class($albums) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $albums->getErrorMessage() . '<br/>';
	} else {
	    foreach ($albums as $album) {
		$imageCounter = $album->getImageCounter();
		$title = $album->getTitle();

		$imageArray = array();
		$imageP = new ImageParse();
		$imageP->wherePointer('album', 'Album', $album->getObjectId());
		$imageP->setLimit(4);
		$imageP->orderByDescending('updatedAt');
		$images = $imageP->getImages();
		if (get_class($images) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $images->getErrorMessage() . '<br/>';
		} else {
		    foreach ($images as $image) {
			$thumbnail = $image->getThumbnail();
			$imageInfo = new ImageInfoForPersonalPage($thumbnail);
			array_push($imageArray, $imageInfo);
		    }
		}
		$albumInfo = new AlbumInfoForPersonalPage($imageArray, $imageCounter, $title);
	    }
	    $activityBox->albumInfo = $albumInfo;
	}
	if ($type == 'SPOTTER') {
	    require_once CLASSES_DIR . 'event.class.php';
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    require_once CLASSES_DIR . 'record.class.php';
	    require_once CLASSES_DIR . 'recordParse.class.php';

	    $lastSongP = new ActivityParse();
	    $lastSongP->setLimit(1);
	    $lastSongP->wherePointer('fromUser', '_User', $objectId);
	    $lastSongP->where('type', 'SONGLISTENED');
	    $lastSongP->where('active', true);
	    $lastSongP->orderByDescending('createdAt');
	    $lastSong = $lastSongP->getActivities();
	    if (get_class($lastSong) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastSong->getErrorMessage() . '<br/>';
	    } else {
		foreach ($lastSong as $activity) {
		    $songId = $activity->getSong();

		    $songP = new SongParse();
		    $song = $songP->getSong($songId);
		    $songTitle = $song->getTitle();

		    $recordId = $activity->getRecord();
		    $recordP = new RecordParse();
		    $record = $recordP->getRecord($recordId);
		    $thumbnailCover = $record->getThumbnailCover();
		    $title = $record->getTitle();

		    $fromUserId = $record->getFromUser();
		    $fromUserP = new UserParse();
		    $user = $fromUserP->getUser($fromUserId);
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $fromUserInfo = new UserInfo($thumbnail, $type, $username);
		    $recordInfo = new RecordInfoForPersonalPage($fromUserInfo, $songTitle, $thumbnailCover, $title);
		}
		$activityBox->recordInfo = $recordInfo;
	    }
	    $lastEventP = new ActivityParse();
	    $lastEventP->setLimit(1);
	    $lastEventP->wherePointer('fromUser', '_User', $objectId);
	    $lastEventP->where('type', 'EVENTCONFIRMED');
	    $lastEventP->where('active', true);
	    $lastEventP->orderByDescending('createdAt');
	    $lastEvent = $lastEventP->getActivities();
	    if (get_class($lastSong) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastEvent->getErrorMessage() . '<br/>';
	    } else {
		foreach ($lastEvent as $activity) {
		    $eventId = $activity->getEvent();

		    $eventP = new EventParse();
		    $event = $eventP->getEvent($eventId);

		    $address = $event->getAddress();
		    $city = $event->getCity();
		    $eventDate = $event->getEventDate();
		    $locationName = $event->getLocationName();
		    $thumbnail = $event->getThumbnail();
		    $title = $event->getTitle();

		    $eventInfo = new EventInfoForPersonalPage($address, $city, $eventDate, $locationName, $thumbnail, $title);
		}
		$activityBox->eventInfo = $eventInfo;
	    }
	} else {
	    $activityBox->eventInfo = "INFO TO BE PASSED FROM USERINFO BOX, ALREADY LOADED";
	    $activityBox->recordInfo = "INFO TO BE PASSED FROM USERINFO BOX, ALREADY LOADED";
	}
	return $activityBox;
    }

}

?>