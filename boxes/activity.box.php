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

class AlbumInfoForPersonalPage {

    public $imageArray;
    public $imageCounter;
    public $title;

    function __construct($imageArray, $imageCounter, $title) {
	is_null($imageArray) ? $this->imageArray = NODATA : $this->imageArray = $imageArray;
	is_null($imageCounter) ? $this->imageCounter = NODATA : $this->imageCounter = $imageCounter;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

Class EventInfoForPersonalPage {

    public $address;
    public $city;
    public $eventDate;
    public $locationName;
    public $thumbnail;
    public $title;

    function __construct($address, $city, $eventDate, $locationName, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class RecordInfoForPersonalPage {

    public $fromUserInfo;
    public $thumbnailCover;
    public $title;

    function __construct($fromUserInfo, $thumbnailCover, $title) {
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class ImageInfoForPersonalPage {

    public $thumbnail;

    function __construct($thumbnail) {
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
    }

}

class ActivityBox {

    public $albumInfo;
    public $eventInfo;
    public $recordInfo;
    public $relationInfo;

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
	switch ($type) {
	    case 'SPOTTER':
		break;
	    case 'JAMMER':
		$recordP = new RecordParse();
		$recordP->setLimit(1);
		$recordP->wherePointer('fromUser', '_User', $objectId);
		$recordP->where('active', true);
		$recordP->orderByDescending('updatedAt');
		$records = $recordP->getAlbums();
		if (get_class($records) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $records->getErrorMessage() . '<br/>';
		} else {
		    foreach ($records as $record) {
			$fromUserId = $record->getFromUser();
			$fromUserP = new UserParse();
			$fromUser = $fromUserP->getUser($fromUserId);

			$thumbnail = $fromUser->getThumbnail();
			$type = $fromUser->getType();
			$username = $fromUser->getUsername();
			$fromUserInfo = new UserInfo($thumbnail, $type, $username);

			$thumbnailCover = $record->getThumbnailCover();
			$title = $record->getTitle();

			$recordInfo = new RecordInfoForPersonalPage($fromUserInfo, $thumbnailCover, $title);
		    }
		    $activityBox->recordInfo = $recordInfo;
		}
		break;
	    case 'VENUE':
		break;
	    default :
		break;
	}
	return $activityBox;
    }

}

?>
