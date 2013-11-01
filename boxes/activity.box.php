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
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
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
        global $boxes;
        is_null($imageArray) ? $this->imageArray = $boxes['NODATA'] : $this->imageArray = $imageArray;
        is_null($imageCounter) ? $this->imageCounter = 0 : $this->imageCounter = $imageCounter;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
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
        global $boxes;
        global $default_img;
        is_null($address) ? $this->address = $boxes['NODATA'] : $this->address = $address;
        is_null($city) ? $this->city = $boxes['NODATA'] : $this->city = $city;
        is_null($eventDate) ? $this->eventDate = $boxes['NODATA'] : $this->eventDate = $eventDate;
        is_null($locationName) ? $this->locationName = $boxes['NODATA'] : $this->locationName = $locationName;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($thumbnail) ? $this->thumbnail = $default_img['DEFEVENTTHUMB'] : $this->thumbnail = $thumbnail;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
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
        global $default_img;
        is_null($thumbnail) ? $this->thumbnail = $default_img['DEFIMAGETHUMB'] : $this->thumbnail = $thumbnail;
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
        global $boxes;
        global $default_img;
        is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($songTitle) ? $this->songTitle = $boxes['NODATA'] : $this->songTitle = $songTitle;
        is_null($thumbnailCover) ? $this->thumbnailCover = $default_img['DEFRECORDTHUMB'] : $this->thumbnailCover = $thumbnailCover;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

/**
 * \brief	ActivityBox class 
 * \details	box class to pass info to the view 
 */
class ActivityBox {

    public $albumInfo;
    public $config;
    public $eventInfo;
    public $recordInfo;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/activity.config.json"), false);
    }

    /**
     * \fn	initForPersonalPage($objectId, $type)
     * \brief	Init ActivityBox instance for Personal Page
     * \param	$objectId for user that owns the page, $type of user that owns the page
     * \return	activityBox
     */
    public function initForPersonalPage($objectId, $type) {
        global $boxes;
        $activityBox = new ActivityBox();
        $albumUpdated = new AlbumParse();
        $albumUpdated->setLimit($this->config->limitAlbumForPersonalPage);
        $albumUpdated->wherePointer('fromUser', '_User', $objectId);
        $albumUpdated->where('active', true);
        $albumUpdated->orderByDescending('updatedAt');
        $albums = $albumUpdated->getAlbums();
        if ($albums instanceof Error) {
            return $albums;
        } elseif (is_null($albums)) {
            $activityBox->albumInfo = $boxes['NODATA'];
        } else {
            foreach ($albums as $album) {
                require_once CLASSES_DIR . 'image.class.php';
                require_once CLASSES_DIR . 'imageParse.class.php';
                $imageCounter = $album->getImageCounter();
                $albumId = $album->getObjectId();
                $encodedTitle = $album->getTitle();
                $title = parse_decode_string($encodedTitle);
                $imageArray = array();
                $imageP = new ImageParse();
                $imageP->wherePointer('album', 'Album', $albumId);
                $imageP->where('active', true);
                $imageP->setLimit($this->config->limitImagesForPersonalPage);
                $imageP->orderByDescending('updatedAt');
                $images = $imageP->getImages();
                if ($images instanceof Error) {
                    return $images;
                } elseif (is_null($images)) {
                    $imageArray = $boxes['NOIMGS'];
                } else {
                    foreach ($images as $image) {
                        $thumbnail = $image->getThumbnail();
                        $imageInfo = new ImageInfoForPersonalPage($thumbnail);
                        array_push($imageArray, $imageInfo);
                    }
                }
                $albumInfo = new AlbumInfoForPersonalPage($imageArray, $imageCounter, $albumId, $title);
            }
        }
        $activityBox->albumInfo = $albumInfo;
        if ($type == 'SPOTTER') {
            $lastSongP = new ActivityParse();
            $lastSongP->wherePointer('fromUser', '_User', $objectId);
            $lastSongP->where('type', 'SONGLISTENED');
            $lastSongP->where('active', true);
            $lastSongP->setLimit($this->config->limitSongListenedForPersonalPage);
            $lastSongP->whereInclude('record,record.fromUser,song');
            $lastSongP->orderByDescending('createdAt');
            $activities = $lastSongP->getActivities();
            if ($activities instanceof Error) {
                return $activities;
            } elseif (is_null($activities)) {
                $activityBox->recordInfo = $boxes['NOLSNGLST'];
            } else {
                foreach ($activities as $activity) {
                    $encodedTitle = $activity->getSong()->getTitle();
                    $songTitle = parse_decode_string($encodedTitle);
                    $thumbnailCover = $activity->getRecord()->getThumbnailCover();
                    $recordId = $activity->getRecord()->getObjectId();
                    $encodedRecTitle = $activity->getRecord()->getTitle();
                    $title = parse_decode_string($encodedRecTitle);
                    $fromUser = $activity->getRecord()->getFromUser();
                    $userId = $fromUser->getObjectId();
                    $thumbnail = $fromUser->getProfileThumbnail();
                    $userType = $fromUser->getType();
                    $encodedUsername = $fromUser->getUsername();
                    $username = parse_decode_string($encodedUsername);
                    $fromUserInfo = new UserInfo($userId, $thumbnail, $userType, $username);
                }
            }
            $recordInfo = new RecordInfoForPersonalPage($fromUserInfo, $recordId, $songTitle, $thumbnailCover, $title);
            $activityBox->recordInfo = $recordInfo;
            $lastEventP = new ActivityParse();
            $lastEventP->setLimit($this->config->limitEventConfirmedForPersonalPage);
            $lastEventP->wherePointer('fromUser', '_User', $objectId);
            $lastEventP->where('type', 'EVENTCONFIRMED');
            $lastEventP->where('active', true);
            $lastEventP->whereInclude('event');
            $lastEventP->orderByDescending('createdAt');
            $acts = $lastEventP->getActivities();
            if ($acts instanceof Error) {
                return $acts;
            } elseif (is_null($acts)) {
                $activityBox->eventInfo = $boxes['NOLSTEVNT'];
            } else {
                foreach ($acts as $act) {
                    $encodedAddress = $act->getEvent()->getAddress();
                    $address = parse_decode_string($encodedAddress);
                    $encodedCity = $act->getEvent()->getCity();
                    $city = parse_decode_string($encodedCity);
                    $eventDate = $act->getEvent()->getEventDate();
                    $encodedLocationName = $act->getEvent()->getLocationName();
                    $locationName = parse_decode_string($encodedLocationName);
                    $thumbnail = $act->getEvent()->getThumbnail();
                    $encodedTitle = $act->getEvent()->getTitle();
                    $title = parse_decode_string($encodedTitle);
                    $eventId = $act->getEvent()->getObjectId();
                }
            }
            $eventInfo = new EventInfoForPersonalPage($address, $city, $eventDate, $locationName, $eventId, $thumbnail, $title);
            $activityBox->eventInfo = $eventInfo;
        } else {
            $activityBox->recordInfo = $boxes['IAL'];
            $activityBox->eventInfo = $boxes['IAL'];
        }
        return $activityBox;
    }

}

?>