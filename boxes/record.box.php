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
    public $reviewCounter;
    public $tracklist;
    public $title;
    public $year;

    function __construct($buylink,$city, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $reviewCounter, $tracklist, $title, $year) {
	is_null($buylink) ? $this->buylink = NODATA : $this->buylink = $buylink;
	is_null($city) ? $this->city = NODATA : $this->city = $city;
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($cover) ? $this->cover = NODATA : $this->cover = $cover;
	is_null($description) ? $this->description = NODATA : $this->description = $description;
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	is_null($genre) ? $this->genre = NODATA : $this->genre = $genre;
	is_null($label) ? $this->label = NODATA : $this->label = $label;
	is_null($locationName) ? $this->locationName = NODATA : $this->locationName = $locationName;
	is_null($reviewCounter) ? $this->reviewCounter = 0 : $this->reviewCounter = $reviewCounter;
	is_null($tracklist) ? $this->tracklist = NODATA : $this->tracklist = $tracklist;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
	is_null($year) ? $this->year = NODATA : $this->year = $year;
    }

}

class RecordInfoForPersonalPage {

    public $counters;
    public $genre;
    public $reviewCounter;
    public $songCounter;
    public $thumbnailCover;
    public $title;
    public $year;

    function __construct($counters, $genre, $reviewCounter, $songCounter, $thumbnailCover, $title, $year) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($genre) ? $this->genre = NODATA : $this->genre = $genre;
	is_null($reviewCounter) ? $this->reviewCounter = NODATA : $this->reviewCounter = $reviewCounter;
	is_null($songCounter) ? $this->songCounter = NODATA : $this->songCounter = $songCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
	is_null($year) ? $this->year = NODATA : $this->year = $year;
    }

}

class RecordInfoForUploadRecordPage {

    public $songCounter;
    public $thumbnailCover;
    public $title;

    function __construct($songCounter, $thumbnailCover, $title) {
	is_null($songCounter) ? $this->songCounter = NODATA : $this->songCounter = $songCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class RecordInfoForUploadReviewPage {

    public $featuring;
    public $genre;

    function __construct($featuring, $genre) {
	is_null($featuring) ? $this->featuring = NODATA : $this->featuring = $featuring;
	is_null($genre) ? $this->genre = NODATA : $this->genre = $genre;
    }

}

class SongInfo {

    public $counters;
    public $duration;
    public $title;

    function __construct($counters, $duration, $title) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($duration) ? $this->duration = NODATA : $this->duration = $duration;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class RecordBox {

    public $fromUserInfo;
    public $recordCounter;
    public $recordInfoArray;

    public function initForMediaPage($objectId) {

	require_once CLASSES_DIR . 'song.class.php';
	require_once CLASSES_DIR . 'songParse.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	require_once CLASSES_DIR . 'userParse.class.php';

	$recordBox = new RecordBox();
	$recordP = new RecordParse();
	$record = $recordP->getRecord($objectId);
	if (get_class($record) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $record->getErrorMessage() . '<br/>';
	} elseif ($record->getActive() == true) {
	    $buylink = $record->getBuylink();
	    $commentCounter = $record->getCommentCounter();
	    $loveCounter = $record->getLoveCounter();
	    $shareCounter = $record->getShareCounter();
	    $counters = new Counters($commentCounter, $loveCounter, $shareCounter);

	    $cover = $record->getCover();
	    $description = $record->getDescription();

	    $featuring = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('featuring', 'Record', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $feats = $parseUser->getUsers();
	    if (get_class($feats) == 'Error') {
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
	    $label = $record->getLabel();
	    $locationName = $record->getLocationName();
	    $reviewCounter = $record->getReviewCounter();
	    $title = $record->getTitle();
	    $year = $record->getYear();

	    $tracklist = array();
	    $parseSong = new SongParse();
	    $parseSong->wherePointer('record', 'Record', $objectId);
	    $parseSong->where('active', true);
	    $parseSong->setLimit(50);
	    $songs = $parseSong->getSongs();
	    if (get_class($songs) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $songs->getErrorMessage() . '<br/>';
	    } else {
		foreach ($songs as $song) {
		    $duration = $song->getDuration();
		    $title = $song->getTitle();
		    $commentCounter = $song->getCommentCounter();
		    $loveCounter = $song->getLoveCounter();
		    $shareCounter = $song->getShareCounter();
		    $counters = new Counters($commentCounter, $loveCounter, $shareCounter);
		    $songInfo = new SongInfo($counters, $duration, $title);
		    array_push($tracklist, $songInfo);
		}
	    }
	    $recordInfo = new RecordInfoForMediaPage($buylink, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $reviewCounter, $tracklist, $title, $year);

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
	    $recordBox->fromUserInfo = $userInfo;
	    $recordBox->recordCounter = NDB;
	    $recordBox->recordInfoArray = $recordInfo;
	}
	return $recordBox;
    }

    public function initForPersonalPage($objectId) {
	$recordBox = new RecordBox();

	$info = array();
	$counter = 0;
	$record = new RecordParse();
	$record->wherePointer('fromUser', '_User', $objectId);
	$record->where('active', true);
	$record->setLimit(1000);
	$record->orderByDescending('createdAt');
	$records = $record->getRecords();
	if (get_class($records) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $records->getErrorMessage() . '<br/>';
	} else {
	    foreach ($records as $record) {
		$counter = ++$counter;

		$commentCounter = $record->getCommentCounter();
		$genre = $record->getGenre();
		$loveCounter = $record->getLoveCounter();
		$reviewCounter = $record->getReviewCounter();
		$shareCounter = $record->getShareCounter();
		$songCounter = $record->getSongCounter();
		$thumbnailCover = $record->getThumbnailCover();
		$title = $record->getTitle();
		$year = $record->getYear();
		$counters = new Counters($commentCounter, $loveCounter, $shareCounter);
		$recordInfo = new RecordInfoForPersonalPage($counters, $genre, $reviewCounter, $songCounter, $thumbnailCover, $title, $year);
		array_push($info, $recordInfo);
	    }
	    $recordBox->fromUserInfo = NDB;
	    $recordBox->recordCounter = $counter;
	    $recordBox->recordInfoArray = $info;
	}

	return $recordBox;
    }

    public function initForUploadRecordPage($objectId) {
	$recordBox = new RecordBox();

	$info = array();
	$counter = 0;
	$record = new RecordParse();
	$record->wherePointer('fromUser', '_User', $objectId);
	$record->where('active', true);
	$record->setLimit(1000);
	$record->orderByDescending('createdAt');
	$records = $record->getRecords();
	if (get_class($records) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $records->getErrorMessage() . '<br/>';
	} else {
	    foreach ($records as $record) {
		$counter = ++$counter;

		$songCounter = $record->getSongCounter();
		$thumbnailCover = $record->getThumbnailCover();
		$title = $record->getTitle();
		$recordInfo = new RecordInfoForUploadRecordPage($songCounter, $thumbnailCover, $title);
		array_push($info, $recordInfo);
	    }
	    $recordBox->fromUserInfo = NDB;
	    $recordBox->recordCounter = $counter;
	    $recordBox->recordInfoArray = $info;
	}
	return $recordBox;
    }

    public function initForUploadReviewPage($objectId) {
	$recordBox = new RecordBox();
	$recordBox->recordCounter = NDB;

	$recordP = new RecordParse();
	$record = $recordP->getRecord($objectId);
	if (get_class($record) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $record->getErrorMessage() . '<br/>';
	} else {
	    $featuring = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('featuring', 'Record', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $feats = $parseUser->getUsers();
	    if (get_class($feats) == 'Error') {
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
	    $recordInfo = new RecordInfoForUploadReviewPage($featuring, $genre);
	    $recordBox->recordInfoArray = $recordInfo;

	    $fromUserP = new UserParse();
	    $fromUser = $fromUserP->getUser($record->getFromUser());
	    $thumbnail = $fromUser->getProfileThumbnail();
	    $type = $fromUser->getType();
	    $username = $fromUser->getUsername();
	    $userInfo = new UserInfo($thumbnail, $type, $username);
	    $recordBox->fromUserInfo = $userInfo;
	}
	return $recordBox;
    }

}

?>