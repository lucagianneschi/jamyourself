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
 * \todo		sistemare il campo featuring,suo whereInclude
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

class RecordInfoForMediaPage {

    public $buylink;
    public $city;
    public $counters;
    public $cover;
    public $description;
    public $featuring;
    public $genre;
    public $label;
    public $locationName;
    public $tracklist;
    public $title;
    public $year;

    /**
     * \fn	__construct($buylink, $city, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $title, $year)
     * \brief	construct for the RecordInfoForMediaPage class
     * \param	$buylink, $city, $counters, $cover, $description, $featuring, $genre, $label, $locationName,  $title, $year
     */
    function __construct($buylink, $city, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $title, $tracklist, $year) {
	global $boxes;
	global $default_img;
	is_null($buylink) ? $this->buylink = $boxes['NODATA'] : $this->buylink = $buylink;
	is_null($city) ? $this->city = $boxes['NODATA'] : $this->city = $city;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($cover) ? $this->cover = $default_img['DEFRECORDCOVER'] : $this->cover = $cover;
	is_null($description) ? $this->description = $boxes['NODATA'] : $this->description = $description;
	is_null($featuring) ? $this->featuring = $boxes['NODATA'] : $this->featuring = $featuring;
	is_null($genre) ? $this->genre = $boxes['NODATA'] : $this->genre = $genre;
	is_null($label) ? $this->label = $boxes['NODATA'] : $this->label = $label;
	is_null($locationName) ? $this->locationName = $boxes['NODATA'] : $this->locationName = $locationName;
	is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
	is_null($tracklist) ? $this->tracklist = $boxes['NOTRACK'] : $this->tracklist = $tracklist;
	is_null($year) ? $this->year = $boxes['NODATA'] : $this->year = $year;
    }

}

class RecordInfoForPersonalPage {

    public $counters;
    public $genre;
    public $objectId;
    public $songCounter;
    public $thumbnailCover;
    public $title;
    public $year;

    /**
     * \fn	__construct($counters, $genre,$objectId, $songCounter, $thumbnailCover, $title, $year)
     * \brief	construct for the RecordInfoForPersonalPage class
     * \param	$counters, $genre,$objectId, $songCounter, $thumbnailCover, $title, $year
     */
    function __construct($counters, $genre, $objectId, $songCounter, $thumbnailCover, $title, $year) {
	global $boxes;
	global $default_img;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($genre) ? $this->genre = $boxes['NODATA'] : $this->genre = $genre;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($songCounter) ? $this->songCounter = 0 : $this->songCounter = $songCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = $default_img['DEFRECORDTHUMB'] : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
	is_null($year) ? $this->year = $boxes['NODATA'] : $this->year = $year;
    }

}

class RecordInfoForUploadRecordPage {

    public $songCounter;
    public $thumbnailCover;
    public $title;

    /**
     * \fn	__construct($songCounter, $thumbnailCover, $title)
     * \brief	construct for the RecordInfoForUploadRecordPage class
     * \param	$songCounter, $thumbnailCover, $title
     */
    function __construct($songCounter, $thumbnailCover, $title) {
	global $boxes;
	global $default_img;
	is_null($songCounter) ? $this->songCounter = 0 : $this->songCounter = $songCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = $default_img['DEFRECORDTHUMB'] : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

class RecordInfoForUploadReviewPage {

    public $featuring;
    public $genre;

    /**
     * \fn	__construct($featuring, $genre)
     * \brief	construct for the RecordInfoForUploadReviewPage class
     * \param	$featuring, $genre
     */
    function __construct($featuring, $genre) {
	global $boxes;
	is_null($featuring) ? $this->featuring = $boxes['NODATA'] : $this->featuring = $featuring;
	is_null($genre) ? $this->genre = $boxes['NODATA'] : $this->genre = $genre;
    }

}

class SongInfo {

    public $counters;
    public $duration;
    public $objectId;
    public $title;

    /**
     * \fn	__construct($counters, $duration,$objectId, $title)
     * \brief	construct for the SongInfo class
     * \param	$counters, $duration,$objectId, $title
     */
    function __construct($counters, $duration, $objectId, $title) {
	global $boxes;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($duration) ? $this->duration = '0:00' : $this->duration = $duration;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

class RecordBox {

    public $config;
    public $fromUserInfo;
    public $recordCounter;
    public $recordInfoArray;
    public $tracklist;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/record.config.json"), false);
    }

    /**
     * \fn	initForDetail($objectId)
     * \brief	init for detailed view in personal page for the record box object
     * \param	$objectId of the record to display info
     */
    public function initForDetail($objectId) {
	global $boxes;
	$recordBox = new RecordBox();
	$recordBox->fromUserInfo = $boxes['NDB'];
	$recordBox->recordCounter = $boxes['NDB'];
	$recordBox->recordInfoArray = $boxes['NDB'];
	$tracklist = array();
	$song = new SongParse();
	$song->wherePointer('record', 'Record', $objectId);
	$song->where('active', true);
	$song->setLimit($this->config->limitRecordForDetail);
	$songs = $song->getSongs();
	if (get_class($songs) == 'Error') {
	    return $songs;
	} elseif (count($songs) == 0) {
	    $recordBox->tracklist = $boxes['NOTRACK'];
	} else {
	    foreach ($songs as $song) {
		$duration = $song->getDuration();
		$objectId = $song->getObjectId();
		$encodedTitle = $song->getTitle();
		$title = parse_decode_string($encodedTitle);
		$commentCounter = $song->getCommentCounter();
		$loveCounter = $song->getLoveCounter();
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $song->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$songInfo = new SongInfo($counters, $duration, $objectId, $title);
		array_push($tracklist, $songInfo);
	    }
	    $recordBox->tracklist = $tracklist;
	}
	return $recordBox;
    }

    /**
     * \fn	initForMediaPage($objectId)
     * \brief	init for Media Page
     * \param	$objectId of the record to display in MEdia Page
     */
    public function initForMediaPage($objectId) {
	global $boxes;
	$recordBox = new RecordBox();
	$recordBox->recordCounter = $boxes['NDB'];
	$recordP = new RecordParse();
	$recordP->where('objectId', $objectId);
	$recordP->where('active', true);
	$recordP->setLimit($this->config->limitRecordForMediaPage);
	$records = $recordP->getRecords();
	if (get_class($records) == 'Error') {
	    return $records;
	} elseif (count($records) == 0) {
	    $recordBox->recordInfoArray = $boxes['NODATA'];
	    $recordBox->tracklist = $boxes['NOTRACK'];
	    $recordBox->fromUserInfo = $boxes['NODATA'];
	    return $recordBox;
	} else {
	    foreach ($records as $record) {
		$buylink = $record->getBuylink();
		$commentCounter = $record->getCommentCounter();
		$loveCounter = $record->getLoveCounter();
		$reviewCounter = $record->getReviewCounter();
		$shareCounter = $record->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$cover = $record->getCover();
		$encodedDescription = $record->getDescription();
		$description = parse_decode_string($encodedDescription);
		require_once CLASSES_DIR . 'user.class.php';
		require_once CLASSES_DIR . 'userParse.class.php';
		$featuring = array();
		$parseUser = new UserParse();
		$parseUser->whereRelatedTo('featuring', 'Record', $objectId);
		$parseUser->where('active', true);
		$parseUser->setLimit($this->confing->limitFeaturingForMediaPage);
		$feats = $parseUser->getUsers();
		if (get_class($feats) == 'Error') {
		    return $feats;
		} elseif (count($feats) == 0) {
		    foreach ($feats as $user) {
			$objectId = $user->getObjectId();
			$thumbnail = $user->getProfileThumbnail();
			$type = $user->getType();
			$encodedUsername = $user->getUsername();
			$username = parse_decode_string($encodedUsername);
			$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			array_push($featuring, $userInfo);
		    }
		}
		$genre = $record->getGenre();
		$encodedLabel = $record->getLabel();
		$label = parse_decode_string($encodedLabel);
		$encodedLocationName = $record->getLocationName();
		$locationName = parse_decode_string($encodedLocationName);
		$encodedTitle = $record->getTitle();
		$title = parse_decode_string($encodedTitle);
		$year = $record->getYear();
		require_once CLASSES_DIR . 'song.class.php';
		require_once CLASSES_DIR . 'songParse.class.php';
		$tracklist = array();
		$parseSong = new SongParse();
		$parseSong->wherePointer('record', 'Record', $objectId);
		$parseSong->where('active', true);
		$parseSong->setLimit(50);
		$songs = $parseSong->getSongs();
		if (get_class($songs) == 'Error') {
		    return $songs;
		} elseif (count($songs) == 0) {
		    $recordBox->tracklist = $boxes['NOTRACK'];
		} else {
		    foreach ($songs as $song) {
			$duration = $song->getDuration();
			$objectId = $song->getObjectId();
			$encodedTitle = $song->getTitle();
			$title = parse_decode_string($encodedTitle);
			$commentCounter = $song->getCommentCounter();
			$loveCounter = $song->getLoveCounter();
			$shareCounter = $song->getShareCounter();
			$counters = new Counters($commentCounter, $loveCounter, $shareCounter);
			$songInfo = new SongInfo($counters, $duration, $objectId, $title);
			array_push($tracklist, $songInfo);
		    }
		}
		$recordInfo = new RecordInfoForMediaPage($buylink, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $tracklist, $title, $year);
		$objectIdUser = $record->getFromUser()->getObjectId();
		$thumbnail = $record->getFromUser()->getProfileThumbnail();
		$type = $record->getFromUser()->getType();
		$encodedUsername = $record->getFromUser()->getUsername();
		$username = parse_decode_string($encodedUsername);
		$userInfo = new UserInfo($objectIdUser, $thumbnail, $type, $username);
	    }
	    $recordBox->fromUserInfo = $userInfo;
	    $recordBox->recordInfoArray = $recordInfo;
	}
	return $recordBox;
    }

    /**
     * \fn	initForPersonalPage($objectId)
     * \brief	init for recordBox for personal Page
     * \param	$objectId of the user who owns the page
     */
    public function initForPersonalPage($objectId) {
	global $boxes;
	$info = array();
	$counter = 0;
	$recordBox = new RecordBox();
	$recordBox->fromUserInfo = $boxes['NDB'];
	$recordBox->tracklist = $boxes['NDB'];
	$record = new RecordParse();
	$record->wherePointer('fromUser', '_User', $objectId);
	$record->where('active', true);
	$record->setLimit($this->config->limitRecordForPersonalPage);
	$record->orderByDescending('createdAt');
	$records = $record->getRecords();
	if (get_class($records) == 'Error') {
	    return $records;
	} elseif (count($records) == 0) {
	    $recordBox->recordInfoArray = $boxes['NODATA'];
	} else {
	    foreach ($records as $record) {
		$counter = ++$counter;
		$commentCounter = $record->getCommentCounter();
		$genre = $record->getGenre();
		$loveCounter = $record->getLoveCounter();
		$objectId = $record->getObjectId();
		$reviewCounter = $record->getReviewCounter();
		$shareCounter = $record->getShareCounter();
		$songCounter = $record->getSongCounter();
		$thumbnailCover = $record->getThumbnailCover();
		$title = $record->getTitle();
		$year = $record->getYear();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$recordInfo = new RecordInfoForPersonalPage($counters, $genre, $objectId, $songCounter, $thumbnailCover, $title, $year);
		array_push($info, $recordInfo);
	    }
	    $recordBox->recordCounter = $counter;
	    $recordBox->recordInfoArray = $info;
	}
	return $recordBox;
    }

    /**
     * \fn	initForUploadRecordPage($objectId)
     * \brief	init for recordBox for upload record page
     * \param	$objectId of the user who owns the record
     */
    public function initForUploadRecordPage($objectId) {
	global $boxes;
	$recordBox = new RecordBox();
	$recordBox->tracklist = $boxes['NDB'];

	$info = array();
	$counter = 0;
	$record = new RecordParse();
	$record->wherePointer('fromUser', '_User', $objectId);
	$record->where('active', true);
	$record->setLimit(10);
	$record->orderByDescending('createdAt');
	$records = $record->getRecords();
	if (get_class($records) == 'Error') {
	    return $records;
	} else {
	    foreach ($records as $record) {
		$counter = ++$counter;
		$songCounter = $record->getSongCounter();
		$thumbnailCover = $record->getThumbnailCover();
		$title = $record->getTitle();
		$recordInfo = new RecordInfoForUploadRecordPage($songCounter, $thumbnailCover, $title);
		array_push($info, $recordInfo);
	    }
	    $recordBox->fromUserInfo = $boxes['NDB'];
	    $recordBox->recordCounter = $counter;
	    if (empty($info)) {
		$recordBox->recordInfoArray = $boxes['NODATA'];
	    } else {
		$recordBox->recordInfoArray = $info;
	    }
	}
	return $recordBox;
    }

    /**
     * \fn	initForUploadReviewPage($objectId)
     * \brief	init for recordBox for upload review page
     * \param	$objectId of the user who owns the review
     * \todo    utilizzare whereInclude
     */
    public function initForUploadReviewPage($objectId) {
	global $boxes;
	$recordBox = new RecordBox();
	$recordBox->recordCounter = $boxes['NDB'];
	$recordBox->tracklist = $boxes['NDB'];
	$recordP = new RecordParse();
	$recordP->where('objectId', $objectId);
	$recordP->setLimit(1);
	$recordP->whereInclude('fromUser');
	$records = $recordP->getRecords();
	if (get_class($records) == 'Error') {
	    return $records;
	} else {
	    if (count($records) == 0) {
		$recordBox->recordInfoArray = $boxes['NODATA'];
		$recordBox->fromUserInfo = $boxes['NODATA'];
	    } else {
		foreach ($records as $record) {
		    $featuring = array();
		    $parseUser = new UserParse();
		    $parseUser->whereRelatedTo('featuring', 'Record', $objectId);
		    $parseUser->where('active', true);
		    $parseUser->setLimit(10);
		    $feats = $parseUser->getUsers();
		    if (get_class($feats) == 'Error') {
			return $feats;
		    } else {
			foreach ($feats as $user) {
			    $objectId = $user->getObjectId();
			    $thumbnail = $user->getProfileThumbnail();
			    $type = $user->getType();
			    $username = $user->getUsername();
			    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			    array_push($featuring, $userInfo);
			}
		    }
		    $genre = $record->getGenre();
		    $recordInfo = new RecordInfoForUploadReviewPage($featuring, $genre);
		    $recordBox->recordInfoArray = $recordInfo;
		}
	    }
	    $objectIdUser = $record->getFromUser()->getObjectId();
	    $thumbnail = $record->getFromUser()->getProfileThumbnail();
	    $type = $record->getFromUser()->getType();
	    $username = $record->getFromUser()->getUsername();
	    $userInfo = new UserInfo($objectIdUser, $thumbnail, $type, $username);
	    $recordBox->fromUserInfo = $userInfo;
	}
	return $recordBox;
    }

}

?>