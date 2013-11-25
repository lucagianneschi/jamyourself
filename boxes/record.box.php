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
 * \todo		
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
    public $showLove;
    public $tracklist;
    public $title;
    public $year;

    /**
     * \fn	__construct($buylink, $city, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $showLove, $title, $tracklist, $year)
     * \brief	construct for the RecordInfoForMediaPage class
     * \param	$buylink, $city, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $showLove, $title, $tracklist, $year
     */
    function __construct($buylink, $city, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $showLove, $title, $tracklist, $year) {
        global $boxes;
        is_null($buylink) ? $this->buylink = $boxes['NODATA'] : $this->buylink = $buylink;
        is_null($city) ? $this->city = $boxes['NODATA'] : $this->city = $city;
        is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
        is_null($cover) ? $this->cover = DEFRECORDCOVER : $this->cover = $cover;
        is_null($description) ? $this->description = $boxes['NODATA'] : $this->description = $description;
        is_null($featuring) ? $this->featuring = $boxes['NOFEATRECORD'] : $this->featuring = $featuring;
        is_null($genre) ? $this->genre = $boxes['NODATA'] : $this->genre = $genre;
        is_null($label) ? $this->label = $boxes['NODATA'] : $this->label = $label;
        is_null($locationName) ? $this->locationName = $boxes['NODATA'] : $this->locationName = $locationName;
        is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
        is_null($tracklist) ? $this->tracklist = $boxes['NOTRACK'] : $this->tracklist = $tracklist;
        is_null($year) ? $this->year = $boxes['NODATA'] : $this->year = $year;
    }

}

class RecordInfoForPersonalPage {

    public $counters;
    public $genre;
    public $objectId;
    public $showLove;
    public $songCounter;
    public $thumbnailCover;
    public $title;
    public $year;

    /**
     * \fn	__construct($counters, $genre, $objectId, $showLove, $songCounter, $thumbnailCover,$tracklist, $title, $year)
     * \brief	construct for the RecordInfoForPersonalPage class
     * \param	$counters, $genre, $objectId, $showLove, $songCounter, $thumbnailCover,$tracklist, $title, $year
     */
    function __construct($counters, $genre, $objectId, $showLove, $songCounter, $thumbnailCover, $title, $year) {
        global $boxes;
        is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
        is_null($genre) ? $this->genre = $boxes['NODATA'] : $this->genre = $genre;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
        is_null($songCounter) ? $this->songCounter = 0 : $this->songCounter = $songCounter;
        is_null($thumbnailCover) ? $this->thumbnailCover = DEFRECORDTHUMB : $this->thumbnailCover = $thumbnailCover;
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
    function __construct($recordId, $songCounter, $thumbnailCover, $title) {
        global $boxes;
        is_null($recordId) ? $this->recordId = 0 : $this->recordId = $recordId;
        is_null($songCounter) ? $this->songCounter = 0 : $this->songCounter = $songCounter;
        is_null($thumbnailCover) ? $this->thumbnailCover = DEFRECORDTHUMB : $this->thumbnailCover = $thumbnailCover;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

class SongInfo {

    public $counters;
    public $duration;
    public $objectId;
    public $showLove;
    public $title;

    /**
     * \fn	__construct($counters, $duration,$objectId, $title)
     * \brief	construct for the SongInfo class
     * \param	$counters, $duration,$objectId, $title
     */
    function __construct($counters, $duration, $objectId, $showLove, $title) {
        global $boxes;
        is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
        is_null($duration) ? $this->duration = '0:00' : $this->duration = $duration;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

class RecordBox {

    public $config;
    public $fromUserInfo;
    public $recordCounter;
    public $recordInfoArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/record.config.json"), false);
    }

    /**
     * \fn	tracklistGenerator($objectId)
     * \brief	retrives info for generating a tracklist
     * \param	$objectId of the 
     * \return  $tracklist, array of Songinfo objects    
     */
    function tracklistGenerator($objectId, $currentUserId, $limit) {
        require_once CLASSES_DIR . 'song.class.php';
        require_once CLASSES_DIR . 'songParse.class.php';
        global $boxes;
        $tracklist = array();
        $song = new SongParse();
        $song->wherePointer('record', 'Record', $objectId);
        $song->where('active', true);
        $song->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->limitSongsForMediaPage : $limit);
        $song->orderByDescending('createdAt');
        $songs = $song->getSongs();
        if ($songs instanceof Error) {
            return $songs;
        } elseif (is_null($songs)) {
            $tracklist = $boxes['NOTRACK'];
            return $tracklist;
        } else {
            foreach ($songs as $song) {
                $duration = $song->getDuration();
                $songId = $song->getObjectId();
                $title = $song->getTitle();
                $commentCounter = $song->getCommentCounter();
                $loveCounter = $song->getLoveCounter();
                $reviewCounter = $boxes['NDB'];
                $shareCounter = $song->getShareCounter();
                $counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
                $showLove = in_array($currentUserId, $song->getLovers()) ? false : true;
                $songInfo = new SongInfo($counters, $duration, $songId, $showLove, $title);
                array_push($tracklist, $songInfo);
            }
        }
        return $tracklist;
    }

    /**
     * \fn	initForMediaPage($objectId)
     * \brief	init for Media Page
     * \param	$objectId of the record to display in Media Page
     * \todo    
     */
    public function initForMediaPage($objectId) {
        global $boxes;
        $currentUserId = sessionChecker();
        $recordBox = new RecordBox();
        $recordBox->recordCounter = $boxes['NDB'];
        $recordP = new RecordParse();
        $recordP->where('objectId', $objectId);
        $recordP->where('active', true);
        $recordP->whereInclude('fromUser');
        $recordP->setLimit($this->config->limitRecordForMediaPage);
        $records = $recordP->getRecords();
        if ($records instanceof Error) {
            return $records;
        } elseif (is_null($records)) {
            $recordBox->recordInfoArray = $boxes['NODATA'];
            $recordBox->tracklist = $boxes['NOTRACK'];
            $recordBox->fromUserInfo = $boxes['NODATA'];
            return $recordBox;
        } else {
            foreach ($records as $record) {
                if (!is_null($record->getFromUser())) {
                    $buylink = $record->getBuylink();
                    $city = $record->getFromUser()->getCity();
                    $commentCounter = $record->getCommentCounter();
                    $loveCounter = $record->getLoveCounter();
                    $reviewCounter = $record->getReviewCounter();
                    $shareCounter = $record->getShareCounter();
                    $counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
                    $cover = $record->getCover();
                    $description = $record->getDescription();
                    $featuring = getRelatedUsers($record->getObjectId(), 'featuring', 'Record', false, $this->config->limitFeaturingForMediaPage, 0);
                    $genre = $record->getGenre();
                    $label = $record->getLabel();
                    $showLoveRecord = in_array($currentUserId, $record->getLovers()) ? false : true;
                    $locationName = $record->getLocationName();
                    $title = $record->getTitle();
                    $year = $record->getYear();
                    $tracklist = $this->tracklistGenerator($objectId, $currentUserId, $this->config->limitSongsForMediaPage);
                    $recordInfo = new RecordInfoForMediaPage($buylink, $city, $counters, $cover, $description, $featuring, $genre, $label, $locationName, $showLoveRecord, $title, $tracklist, $year);
                    $userId = $record->getFromUser()->getObjectId();
                    $thumbnail = $record->getFromUser()->getProfileThumbnail();
                    $type = $record->getFromUser()->getType();
                    $username = $record->getFromUser()->getUsername();
                    $userInfo = new UserInfo($userId, $thumbnail, $type, $username);
                }
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
     * \todo	
     */
    public function initForPersonalPage($objectId) {
        global $boxes;
        $currentUserId = sessionChecker();
        $info = array();
        $counter = 0;
        $recordBox = new RecordBox();
        $recordBox->fromUserInfo = $boxes['NDB'];
        $record = new RecordParse();
        $record->wherePointer('fromUser', '_User', $objectId);
        $record->where('active', true);
        $record->setLimit($this->config->limitRecordForPersonalPage);
        $record->orderByDescending('createdAt');
        $records = $record->getRecords();
        if ($records instanceof Error) {
            return $records;
        } elseif (is_null($records)) {
            $recordBox->recordInfoArray = $boxes['NODATA'];
            $recordBox->recordCounter = $boxes['NODATA'];
            return $recordBox;
        } else {
            foreach ($records as $record) {
                $counter = ++$counter;
                $commentCounter = $record->getCommentCounter();
                $genre = $record->getGenre();
                $loveCounter = $record->getLoveCounter();
                $recordId = $record->getObjectId();
                $reviewCounter = $record->getReviewCounter();
                $shareCounter = $record->getShareCounter();
                $songCounter = $record->getSongCounter();
                $thumbnailCover = $record->getThumbnailCover();
                $title = $record->getTitle();
                $year = $record->getYear();
                $counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
                $showLove = in_array($currentUserId, $record->getLovers()) ? false : true;
                $recordInfo = new RecordInfoForPersonalPage($counters, $genre, $recordId, $showLove, $songCounter, $thumbnailCover, $title, $year);
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
        $info = array();
        $counter = 0;
        $recordBox = new RecordBox();
        $recordBox->fromUserInfo = $boxes['NDB'];
        $record = new RecordParse();
        $record->wherePointer('fromUser', '_User', $objectId);
        $record->where('active', true);
        $record->setLimit($this->config->limitRecordForUploadRecordPage);
        $record->orderByDescending('createdAt');
        $records = $record->getRecords();
        if ($records instanceof Error) {
            return $records;
        } elseif (is_null($records)) {
            $recordBox->recordInfoArray = $boxes['NODATA'];
            $recordBox->recordCounter = $boxes['NODATA'];
            return $recordBox;
        } else {
            foreach ($records as $record) {
                $counter = ++$counter;
                $songCounter = $record->getSongCounter();
                $thumbnailCover = $record->getThumbnailCover();
                $title = $record->getTitle();
                $recordId = $record->getObjectId();
                $recordInfo = new RecordInfoForUploadRecordPage($recordId, $songCounter, $thumbnailCover, $title);
                array_push($info, $recordInfo);
            }
            $recordBox->recordCounter = $counter;
            $recordBox->recordInfoArray = $info;
        }
        return $recordBox;
    }

}

?>