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
    public $objectId;
    public $title;

    /**
     * \fn	__construct($imageArray, $imageCounter, $objectId, $title)
     * \brief	construct for the AlbumInfoForPersonalPage class
     * \param	$imageArray, $imageCounter, $objectId, $title
     */
    function __construct($imageArray, $imageCounter, $objectId, $title) {
	is_null($imageArray) ? $this->imageArray = NODATA : $this->imageArray = $imageArray;
	is_null($imageCounter) ? $this->imageCounter = 0 : $this->imageCounter = $imageCounter;
	is_null($objectId) ? $this->objectId = NODATA : $this->objectId = $objectId;
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
    public $objectId;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($address, $city, $eventDate, $locationName, $objectId, $thumbnail, $title)
     * \brief	construct for the ImageInfoForPersonalPage class
     * \param	$address, $city, $eventDate, $locationName, $objectId, $thumbnail, $title
     */
    function __construct($address, $city, $eventDate, $locationName, $objectId, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($objectId) ? $this->objectId = NODATA : $this->objectId = $objectId;
	is_null($thumbnail) ? $this->thumbnail = DEFEVENTTHUMB : $this->thumbnail = $thumbnail;
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
    public $objectId;
    public $songTitle;
    public $thumbnailCover;
    public $title;

    /**
     * \fn	__construct($fromUserInfo, $objectId, $songTitle, $thumbnailCover, $title)
     * \brief	construct for the RecordInfoForPersonalPage class
     * \param	$fromUserInfo, $objectId, $songTitle, $thumbnailCover, $title
     */
    function __construct($fromUserInfo, $objectId, $songTitle, $thumbnailCover, $title) {
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($objectId) ? $this->objectId = NODATA : $this->objectId = $objectId;
	is_null($songTitle) ? $this->songTitle = NODATA : $this->songTitle = $songTitle;
	is_null($thumbnailCover) ? $this->thumbnailCover = DEFRECORDTHUMB : $this->thumbnailCover = $thumbnailCover;
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
	    return $albums;
	} else {
	    foreach ($albums as $album) {
		$imageCounter = $album->getImageCounter();
		$objectId = $album->getObjectId();
		$encodedTitle = $album->getTitle();
		$title = parse_decode_string($encodedTitle);

		$imageArray = array();
		$imageP = new ImageParse();
		$imageP->wherePointer('album', 'Album', $album->getObjectId());
		$imageP->where('active', true);
		$imageP->setLimit(4);
		$imageP->orderByDescending('updatedAt');
		$images = $imageP->getImages();
		if (get_class($images) == 'Error') {
		    return $images;
		} else {
		    foreach ($images as $image) {
			$thumbnail = $image->getThumbnail();
			$imageInfo = new ImageInfoForPersonalPage($thumbnail);
			array_push($imageArray, $imageInfo);
		    }
		}
		if (empty($imageArray)) {
		    $imageArray = NOIMGS;
		}
		$albumInfo = new AlbumInfoForPersonalPage($imageArray, $imageCounter, $objectId, $title);
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
		return $lastSong;
	    } else {
		foreach ($lastSong as $activity) {
		    $songId = $activity->getSong();
		    $songP = new SongParse();
		    $song = $songP->getSong($songId);
		    if (get_class($song) == 'Error') {
			return $song;
		    } elseif ($song->getActive() == true) {
			$encodedTitle = $song->getTitle();
			$songTitle = parse_decode_string($encodedTitle);

			$recordId = $activity->getRecord();
			$recordP = new RecordParse();
			$record = $recordP->getRecord($recordId);
			if (get_class($record) == 'Error') {
			    return $record;
			} else {
			    $thumbnailCover = $record->getThumbnailCover();
			    $objectId = $record->getObjectId();
			    $encodedRecTitle = $record->getTitle();
			    $title = parse_decode_string($encodedRecTitle);
			    $fromUserId = $record->getFromUser();
			    $fromUserP = new UserParse();
			    $user = $fromUserP->getUser($fromUserId);
			    if (get_class($user) == 'Error') {
				return $user;
			    } else {
				$objectIdUser = $fromUserP->getObjectId();
				$thumbnail = $user->getProfileThumbnail();
				$type = $user->getType();
				$encodedUsername = $user->getUsername();
				$username = parse_decode_string($encodedUsername);
				$fromUserInfo = new UserInfo($objectIdUser, $thumbnail, $type, $username);
			    }
			    $recordInfo = new RecordInfoForPersonalPage($fromUserInfo, $objectId, $songTitle, $thumbnailCover, $title);
			}
		    } else {
			$recordInfo = NOLSNGLST;
		    }
		}
	    }
	    $activityBox->recordInfo = $recordInfo;

	    $lastEventP = new ActivityParse();
	    $lastEventP->setLimit(1);
	    $lastEventP->wherePointer('fromUser', '_User', $objectId);
	    $lastEventP->where('type', 'EVENTCONFIRMED');
	    $lastEventP->where('active', true);
	    $lastEventP->orderByDescending('createdAt');
	    $lastEvent = $lastEventP->getActivities();
	    if (get_class($lastEvent) == 'Error') {
		return $lastEvent;
	    } else {
		foreach ($lastEvent as $activity) {
		    $eventId = $activity->getEvent();
		    $eventP = new EventParse();
		    $event = $eventP->getEvent($eventId);
		    if (get_class($event) == 'Error') {
			return $event;
		    } elseif ($event->getActive() == true) {
			$encodedAddress = $event->getAddress();
			$address = parse_decode_string($encodedAddress);
			$encodedCity = $event->getCity();
			$city = parse_decode_string($encodedCity);
			$eventDate = $event->getEventDate();
			$encodedLocationName = $event->getLocationName();
			$locationName = parse_decode_string($encodedLocationName);
			$thumbnail = $event->getThumbnail();
			$encodedTitle = $event->getTitle();
			$title = parse_decode_string($encodedTitle);
			$objectId = $event->getObjectId();
			$eventInfo = new EventInfoForPersonalPage($address, $city, $eventDate, $locationName, $objectId, $thumbnail, $title);
		    } else {
			$eventInfo = NOLSTEVNT;
		    }
		}
	    }
	    $activityBox->eventInfo = $eventInfo;
	} else {
	    $activityBox->recordInfo = IAL;
	    $activityBox->eventInfo = IAL;
	}
	return $activityBox;
    }

}
?>