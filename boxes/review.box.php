<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento review event
 * \details		Recupera le informazioni sulla review dell'event, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	MediaInfoForUploadReviewPage
 * \details	contains info for event or record to be displayed in the upload review
 */
class MediaInfoForUploadReviewPage {

    public $address;
    public $city;
    public $className;
    public $eventDate;
    public $featuring;
    public $fromUserInfo;
    public $genre;
    public $locationName;
    public $objectId;
    public $tags;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($address, $city, $className, $eventDate, $featuring, $fromUserInfo, $genre, $featuring, $locationName, $objectId, $tags, $thumbnail, $title)
     * \brief	construct for the MediaInfo class
     * \param	$address, $city, $className, $eventDate, $featuring, $fromUserInfo, $genre, $featuring, $locationName, $objectId, $tags, $thumbnail, $title
     * \todo    
     */
    function __construct($address, $city, $className, $eventDate, $featuring, $fromUserInfo, $genre, $featuring, $locationName, $objectId, $tags, $thumbnail, $title) {
	global $boxes;
	if ($className == 'Event') {
	    is_null($address) ? $this->address = $boxes['NODATA'] : $this->address = $address;
	    is_null($city) ? $this->city = $boxes['NODATA'] : $this->city = $city;
	    $this->className = $className;
	    is_null($eventDate) ? $this->eventDate = $boxes['NODATA'] : $this->eventDate = $eventDate;
	    is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	    $this->genre = $boxes['NDB'];
	    $this->featuring = $boxes['NDB'];
	    is_null($locationName) ? $this->locationName = $boxes['NODATA'] : $this->locationName = $locationName;
	    is_null($objectId) ? $this->objectId = $boxes['NOBOJECTID'] : $this->objectId = $objectId;
	    is_null($tags) ? $this->tags = $boxes['NOTAG'] : $this->tags = $tags;
	    is_null($thumbnail) ? $this->thumbnail = DEFEVENTTHUMB : $this->thumbnail = $thumbnail;
	    is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
	} else {
	    $this->address = $boxes['NDB'];
	    $this->city = $boxes['NDB'];
	    $this->className = $className;
	    $this->eventDate = $boxes['NDB'];
	    is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	    is_null($genre) ? $this->genre = $boxes['NODATA'] : $this->genre = $genre;
	    is_null($featuring) ? $this->featuring = $boxes['NOFEATREC'] : $this->featuring = $featuring;
	    $this->locationName = $boxes['NDB'];
	    is_null($objectId) ? $this->objectId = $boxes['NOBOJECTID'] : $this->objectId = $objectId;
	    is_null($tags) ? $this->tags = $boxes['NOTAG'] : $this->tags = $tags;
	    is_null($thumbnail) ? $this->thumbnail = DEFRECORDTHUMB : $this->thumbnail = $thumbnail;
	    is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
	}
    }

}

/**
 * \brief	ReviewInfo class
 * \details	contains info for review to be displayed
 */
class ReviewInfo {

    public $counters;
    public $fromUserInfo;
    public $objectId;
    public $rating;
    public $showLove;
    public $text;
    public $title;
    public $thumbnailCover;

    /**
     * \fn	__construct($counters, $fromUserInfo, $objectId, $rating, $showLove, $text, $thumbnailCover, $title)
     * \brief	construct for the ReviewInfo class
     * \param	$counters, $fromUserInfo, $objectId, $rating, $showLove, $text, $thumbnailCover, $title
     * \todo    
     */
    function __construct($counters, $fromUserInfo, $objectId, $rating, $showLove, $text, $thumbnailCover, $title) {
	global $boxes;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($rating) ? $this->rating = 0 : $this->rating = $rating;
	is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
	is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = $text;
	is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
	is_null($thumbnailCover) ? $this->thumbnailCover = $boxes['NODATA'] : $this->thumbnailCover = $thumbnailCover;
    }

}

/**
 * \brief	ReviewBox class
 * \details	box class to pass info to the view
 */
class ReviewBox {

    public $config;
    public $reviewArray;
    public $reviewCounter;
    public $mediaInfo;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/review.config.json"), false);
    }

    /**
     * \fn	initForMediaPage($objectId, $className, $limit, $skip)
     * \brief	Init ReviewBox instance for Media Page
     * \param	$objectId of the review to display information, Event or Record class
     * \param   $className, $limit, $skip,$currentUserId
     * \return	reviewBox
     * \todo	
     */
    public function initForMediaPage($objectId, $className, $limit, $skip) {
	global $boxes;
	$currentUserId = sessionChecker();
	$counter = 0;
	$info = array();
	$reviewBox = new ReviewBox();
	$reviewBox->mediaInfo = $boxes['NDB'];
	$review = new CommentParse();
	if ($className == 'Event') {
	    $review->wherePointer('event', $className, $objectId);
	} else {
	    $review->wherePointer('record', $className, $objectId);
	}
	$review->where('active', true);
	$review->whereInclude('fromUser');
	$review->setLimit($limit);
	$review->setSkip($skip);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if ($reviews instanceof Error) {
	    return $reviews;
	} elseif (is_null($reviews)) {
	    $reviewBox->reviewArray = $boxes['NODATA'];
	    $reviewBox->reviewCounter = $boxes['NODATA'];
	    return $reviewBox;
	} else {
	    foreach ($reviews as $review) {
		$counter = ++$counter;
		$userId = $review->getFromUser()->getObjectId();
		$thumbnail = $review->getFromUser()->getProfileThumbnail();
		$type = $review->getFromUser()->getType();
		$username = parse_decode_string($review->getFromUser()->getUserName());
		$fromUserInfo = new UserInfo($userId, $thumbnail, $type, $username);
		$commentCounter = $review->getCommentCounter();
		$loveCounter = $review->getLoveCounter();
		$showLove = in_array($currentUserId, $review->getLovers()) ? false : true;
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $review->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$reviewId = $review->getObjectId();
		$rating = $review->getVote();
		$text = parse_decode_string($review->getText());
		$thumbnailCover = $boxes['NDB'];
		$title = parse_decode_string($review->getTitle());
		$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $reviewId, $rating, $showLove, $text, $thumbnailCover, $title);
		array_push($info, $reviewInfo);
	    }
	    $reviewBox->reviewArray = $info;
	    $reviewBox->reviewCounter = $counter;
	}
	return $reviewBox;
    }

    /**
     * \fn	initForPersonalPage($objectId, $type, $className)
     * \brief	Init ReviewBox instance for Personal Page
     * \param	$objectId of the user who owns the page, $type of user, $className Record or Event class
     * \param   $type, $className
     * \todo	
     * \return	reviewBox
     */
    function initForPersonalPage($objectId, $type, $className) {
	global $boxes;
	$currentUserId = sessionChecker();
	$info = array();
	$counter = 0;
	$reviewBox = new ReviewBox();
	$reviewBox->mediaInfo = $boxes['NDB'];
	$reviewP = new CommentParse();
	$reviewP->where('active', true);
	if ($type == 'SPOTTER' && $className == 'Event') {
	    $field = 'fromUser';
	    $thumbnailCover = DEFEVENTTHUMB;
	    $reviewP->where('type', 'RE');
	    $reviewP->whereInclude('event,event.fromUser');
	} elseif ($type == 'SPOTTER' && $className == 'Record') {
	    $field = 'fromUser';
	    $thumbnailCover = DEFRECORDTHUMB;
	    $reviewP->where('type', 'RR');
	    $reviewP->whereInclude('record,record.fromUser');
	} elseif ($type != 'SPOTTER' && $className == 'Event') {
	    $field = 'toUser';
	    $thumbnailCover = DEFEVENTTHUMB;
	    $reviewP->where('type', 'RE');
	    $reviewP->whereInclude('event,fromUser');
	} elseif ($type != 'SPOTTER' && $className == 'Record') {
	    $field = 'toUser';
	    $thumbnailCover = DEFRECORDTHUMB;
	    $reviewP->where('type', 'RR');
	    $reviewP->whereInclude('record,fromUser');
	}
	$reviewP->wherePointer($field, '_User', $objectId);
	$reviewP->setLimit($this->config->limitForPersonalPage);
	$reviewP->orderByDescending('createdAt');
	$reviews = $reviewP->getComments();
	if ($reviews instanceof Error) {
	    return $reviews;
	} elseif (is_null($reviews)) {
	    $reviewBox->reviewArray = $boxes['NODATA'];
	    $reviewBox->reviewCounter = $boxes['NODATA'];
	    return $reviewBox;
	} else {
	    foreach ($reviews as $review) {
		$counter = ++$counter;
		$commentCounter = $review->getCommentCounter();
		$loveCounter = $review->getLoveCounter();
		$showLove = in_array($currentUserId, $review->getLovers()) ? false : true;
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $review->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$reviewId = $review->getObjectId();
		$rating = $review->getVote();
		$text = parse_decode_string($review->getText());
		$title = parse_decode_string($review->getTitle());
		if ($type == 'SPOTTER') {
		    $fromUserInfo = $boxes['ND'];
		} else {
		    $userId = $review->getFromUser()->getObjectId();
		    $thumbnail = $review->getFromUser()->getProfileThumbnail();
		    $userType = $review->getFromUser()->getType();
		    $encodedUsername = $review->getFromUser()->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $fromUserInfo = new UserInfo($userId, $thumbnail, $userType, $username);
		}
		if (!is_null($review->getEvent()) && !is_null($review->getEvent()->getThumbnail())) {
		    $thumbnailCover = $review->getEvent()->getThumbnail();
		}
		if (!is_null($review->getRecord()) && !is_null($review->getRecord()->getThumbnailCover())) {
		    $thumbnailCover = $review->getRecord()->getThumbnailCover();
		}
		$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $reviewId, $rating, $showLove, $text, $thumbnailCover, $title);
		array_push($info, $reviewInfo);
	    }
	}
	$reviewBox->reviewArray = $info;
	$reviewBox->reviewCounter = $counter;
	return $reviewBox;
    }

    /**
     * \fn	initForUploadReviewPage($objectId, $className)
     * \brief	Init REviewBox instance for Upload Review Page
     * \param	$objectId for the event or record, $className Record or Event
     * \todo    
     * \return	reviewBox
     */
    public function initForUploadReviewPage($objectId, $className, $limit) {
	global $boxes;
	$reviewBox = new ReviewBox();
	$reviewBox->reviewArray = $boxes['NDB'];
	$reviewBox->reviewCounter = $boxes['NDB'];
	if ($className == 'Event') {
	    require_once CLASSES_DIR . 'event.class.php';
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $event = new EventParse();
	    $event->where('objectId', $objectId);
	    $event->where('active', true);
	    $event->whereInclude('fromUser');
	    $event->setLimit($limit);
	    $events = $event->getEvents();
	    if ($events instanceof Error) {
		return $events;
	    } elseif (is_null($events)) {
		$reviewBox->mediaInfo = $boxes['NODATA'];
		return $reviewBox;
	    } else {
		foreach ($events as $event) {
		    $address = parse_decode_string($event->getAddress());
		    $city = parse_decode_string($event->getCity());
		    $className = 'Event';
		    $eventDate = $event->getEventDate();
		    $featuring = $boxes['NDB'];
		    $fromUser = $event->getFromUser();
		    $genre = $boxes['NDB'];
		    $locationName = parse_decode_string($event->getLocationName());
		    $objectId = $event->getObjectId();
		    $tags = array();
		    if (count($event->getTags()) > 0) {
			foreach ($event->getTags() as $tag) {
			    array_push($tags, parse_decode_string($tag));
			}
		    }
		    $thumbnail = $event->getThumbnail();
		    $title = parse_decode_string($event->getTitle());
		}
	    }
	} else {
	    require_once CLASSES_DIR . 'record.class.php';
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $record = new RecordParse();
	    $record->where('objectId', $objectId);
	    $record->where('active', true);
	    $record->setLimit($limit);
	    $record->whereInclude('fromUser');
	    $records = $record->getRecords();
	    if ($records instanceof Error) {
		return $records;
	    } elseif (is_null($records)) {
		$reviewBox->mediaInfo = $boxes['NODATA'];
	    } else {
		foreach ($records as $record) {
		    $address = $boxes['NDB'];
		    $city = $boxes['NDB'];
		    $className = 'Record';
		    $eventDate = $boxes['NDB'];
		    $featuring = getRelatedUsers($objectId, 'featuring', 'Record', false, $this->config->limitFeaturingForUploadReviewPage,0);
		    $fromUser = $record->getFromUser();
		    $genre = $record->getGenre();
		    $locationName = $boxes['NDB'];
		    $objectId = $record->getObjectId();
		    $tags = $boxes['NDB'];
		    $thumbnail = $record->getThumbnailCover();
		    $title = parse_decode_string($record->getTitle());
		}
	    }
	}
	$userId = $fromUser->getObjectId();
	$userThumbnail = $fromUser->getProfileThumbnail();
	$type = $fromUser->getType();
	$username = parse_decode_string($fromUser->getUsername());
	$fromUserInfo = new UserInfo($userId, $userThumbnail, $type, $username);
	$mediaInfo = new MediaInfoForUploadReviewPage($address, $city, $className, $eventDate, $featuring, $fromUserInfo, $genre, $featuring, $locationName, $objectId, $tags, $thumbnail, $title);
	$reviewBox->mediaInfo = $mediaInfo;
	return $reviewBox;
    }

}

?>