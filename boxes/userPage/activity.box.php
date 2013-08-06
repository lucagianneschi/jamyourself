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
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class ActivityInfo {

    public $address; //event
    public $city; //event
    public $eventDate; //event
    public $images; //album
    public $imageCounter; //album
    public $locationName; //event
    public $recordTitle;
    public $thumbnail; //record o event
    public $title; //record o event o album

    function __construct($address, $city, $images, $eventDate,$imageCounter, $locationName, $recordTitle, $thumbnail, $title) {
	is_null($address) ? $this->address = NODATA : $this->address = $address;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($eventDate) ? $this->eventDate = NODATA : $this->eventDate = $eventDate;
	is_null($images) ? $this->images = NODATA : $this->images = $images;
	is_null($imageCounter) ? $this->imageCounter = NODATA : $this->imageCounter = $imageCounter;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($recordTitle) ? $this->recordTitle = NODATA : $this->recordTitle = $recordTitle;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class ActivityBox {

    public $albumInfo;
    public $eventInfo;
    public $recordInfo;

    public function init($objectId, $type) {
	$activityBox = new ActivityBox();
	$relationArray = array();

	$albumInfo = new ActivityInfo();
	$albumInfo->avatar = null;
	$albumInfo->address = null;
	$albumInfo->city = null;
	$albumInfo->eventDate = null;
	$albumInfo->locationName = null;
	$albumInfo->recordTitle = null;
	$albumInfo->thumbnail = null;
	$albumInfo->username = null;

	$images = array();
	$albumUpdated = new ActivityParse();
	$albumUpdated->setLimit(1);
	$albumUpdated->where('type', 'ALBUMUPDATED');
	$albumUpdated->wherePointer('fromUser', '_User', $objectId);
	$albumUpdated->where('active', true);
	$albumUpdated->whereInclude('album');
	$albumUpdated->orderByDescending('createdAt');
	$lastAlbumUpdated = $albumUpdated->getActivities();
	if ($lastAlbumUpdated != 0) {
	    if (get_class($lastAlbumUpdated) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastAlbumUpdated->getErrorMessage() . '<br/>';
	    } else {
		foreach ($lastAlbumUpdated->album as $album) {
		    $albumInfo->imageCounter = $album->imageCounter;
		    $albumInfo->title = $album->title;
		}
		$imagesP = new ImageParse();
		$imagesP->setLimit(4);
		$imagesP->wherePointer('album', 'Album', $lastAlbumUpdated->album);
		$imagesP->where('active', true);
		$imagesP->orderByDescending('updatedAt');
		$images = $imagesP->getImages();
		for ($i = 1; $i < count($images); ++$i) {
		    $image = $images[i];
		    $imageAddress = $image->filePath; //verifica nome property
		    array_push($images, $imageAddress);
		}
		$albumInfo->images = $images;
	    }
	}

	$recordInfo = new ActivityInfo();
	$recordInfo->avatar = null;
	$recordInfo->address = null;
	$recordInfo->city = null;
	$recordInfo->eventDate = null;
	$recordInfo->locationName = null;
	$recordInfo->thumbnail = null;

	$eventInfo = new ActivityInfo();
	$eventInfo->username = null;
	$eventInfo->recordTitle = null;

	switch ($type) {
	    case 'SPOTTER':
		$lastSongListenedP = new ActivityParse();
		$lastSongListenedP->setLimit(1);
		$lastSongListenedP->where('type', 'SONGLISTENED');
		$lastSongListenedP->wherePointer('fromUser', '_User', $objectId);
		$lastSongListenedP->where('active', true);
		$lastSongListenedP->whereInclude('song');
		$lastSongListenedP->whereInclude('record'); //vedere se possibile fare 2 include
		$lastSongListened = $lastSongListenedP->getActivities();
		if ($lastSongListened != 0) {
		    if (get_class($lastSongListened) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastSongListened->getErrorMessage() . '<br/>';
		    } else {
			foreach ($lastSongListened->song as $song) { ///controllare se ok
			    $recordInfo->title = $song->getTitle();
			}
			foreach ($lastSongListened->record as $record) {///controllare se ok
			    $recordInfo->recordTitle = $record->getTitle();
			    $recordInfo->thumbnail = $record->getThumbnailcover();

			    $userP = new UserParse();
			    $user = $userP->getUser($record->fromUser);
			    $recordInfo->username = $user->username;
			}
		    }
		}
		$lastEventAttendedP = new ActivityParse();
		$lastEventAttendedP->setLimit(1);
		$lastEventAttendedP->where('type', 'INVITED');
		$lastEventAttendedP->wherePointer('toUser', '_User', $objectId);
		$lastEventAttendedP->where('status', 'A');
		$lastEventAttendedP->where('active', true);
		$lastEventAttendedP->whereInclude('event');
		$lastEventAttended = $lastEventAttendedP->getActivities();
		if ($lastEventAttended != 0) {
		    if (get_class($lastEventAttended) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastEventAttended->getErrorMessage() . '<br/>';
		    } else {

		    }
		}
		break;
	    case 'VENUE':
		break;
	    default:
		break;
	}









	return $activityBox;
    }

}

?>
