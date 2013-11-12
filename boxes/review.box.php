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

/**
 * \brief	MediaInfoForUploadReviewPage
 * \details	contains info for event or record to be displayed in the upload review
 */
class MediaInfoForUploadReviewPage {

    public $address; //event
    public $city; //event
    public $className; //record o  event
    public $eventDate; // event
    public $featuring; //record o  event
    public $fromUserInfo; //record o  event
    public $genre; //record
    public $locationName; //event
    public $objectId; //record o  event
    public $tags; //record o  event
    public $thumbnail; //record o  event
    public $title; //record o  event

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
            is_null($featuring) ? $this->featuring = $boxes['NOFEATEVE'] : $this->featuring = $featuring;
            is_null($locationName) ? $this->locationName = $boxes['NODATA'] : $this->locationName = $locationName;
            is_null($objectId) ? $this->objectId = $boxes['NOBOJECTID'] : $this->objectId = $objectId;
            is_null($tags) ? $this->tags = $boxes['NOTAG'] : $this->tags = $tags;
            is_null($thumbnail) ? $this->thumbnail = DEFEVENTHUMB : $this->thumbnail = $thumbnail;
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
     * \fn	getRelatedUsers($objectId, $field, $all, $page)
     * \brief	Convenience method to get all kind of related User to the record or event
     * \param	$objectId for event, $all BOOL: Yes to retrieve all related users or using the limit from config file, $page the page which calls the method
     * \return	userArray array of userInfo object
     */
    public function getFeaturedUsers($objectId, $all, $className) {
        global $boxes;
        $userArray = array();
        require_once CLASSES_DIR . 'user.class.php';
        require_once CLASSES_DIR . 'userParse.class.php';
        $parseUser = new UserParse();
        $parseUser->whereRelatedTo('featuring', $className, $objectId);
        $parseUser->where('active', true);
        if ($all == true) {
            $parseUser->setLimit(1000);
        } else {
            $parseUser->setLimit($this->config->limitFeaturingForUploadReviewPage);
        }
        $users = $parseUser->getUsers();
        if ($users instanceof Error) {
            return $users;
        } elseif (is_null($users)) {
            $users = $boxes['NOFEATRECORD'];
            return $users;
        } else {
            foreach ($users as $user) {
                $userId = $user->getObjectId();
                $thumbnail = $user->getProfileThumbnail();
                $type = $user->getType();
                $username = parse_decode_string($user->getUsername());
                $userInfo = new UserInfo($userId, $thumbnail, $type, $username);
                array_push($userArray, $userInfo);
            }
        }
        return $userArray;
    }

    /**
     * \fn	initForDetail($objectId)
     * \brief	Init ReviewBox instance for Personal Page, detailed view
     * \param	$objectId of the review to display information
     * \return	reviewBox
     * \todo	
     */
    public function initForDetail($objectId) {
        global $boxes;
        $currentUserId = sessionChecker();
        $info = array();
        $reviewBox = new ReviewBox();
        $reviewBox->reviewCounter = $boxes['NDB'];
        $reviewBox->mediaInfo = $boxes['NDB'];
        $review = new CommentParse();
        $review->where('objectId', $objectId);
        $review->where('active', true);
        $review->whereInclude('fromUser');
        $review->setLimit($this->config->limitForDetail);
        $review->orderByDescending('createdAt');
        $reviews = $review->getComments();
        if ($reviews instanceof Error) {
            return $reviews;
        } elseif (is_null($reviews)) {
            $reviewBox->reviewArray = $boxes['NODATA'];
            return $reviewBox;
        } else {
            foreach ($reviews as $review) {
                $showLove = true;
                $userId = $review->getFromUser()->getObjectId();
                $thumbnail = $review->getFromUser()->getProfileThumbnail();
                $type = $review->getFromUser()->getType();
                $username = parse_decode_string($review->getFromUser()->getUserName());
                $fromUserInfo = new UserInfo($userId, $thumbnail, $type, $username);
                $reviewId = $review->getObjectId();
                $rating = $review->getVote();
                $commentCounter = $review->getCommentCounter();
                $loveCounter = $review->getLoveCounter();
                $reviewCounter = $boxes['NDB'];
                $shareCounter = $review->getShareCounter();
                $counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
                $text = parse_decode_string($review->getText());
                $thumbnailCover = $boxes['NDB'];
                $title = parse_decode_string($review->getTitle());
                $lovers = $review->getLovers();
                if (in_array($currentUserId, $lovers)) {
                    $showLove = false;
                }
                $reviewInfo = new ReviewInfo($counters, $fromUserInfo, $reviewId, $rating, $text, $thumbnailCover, $title);
                array_push($info, $reviewInfo);
            }
            $reviewBox->reviewArray = $info;
        }
        return $reviewBox;
    }

    /**
     * \fn	initForMediaPage($objectId, $className, $limit, $skip)
     * \brief	Init ReviewBox instance for Media Page
     * \param	$objectId of the review to display information, Event or Record class
     * \param   $className, $limit, $skip,$currentUserId
     * \return	reviewBox
     * \todo	usare whereInclude per il fromUSer per evitare di fare una ulteriore get
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
                $showLove = true;
                $counter = ++$counter;
                $userId = $review->getFromUser()->getObjectId();
                $thumbnail = $review->getFromUser()->getProfileThumbnail();
                $type = $review->getFromUser()->getType();
                $username = parse_decode_string($review->getFromUser()->getUserName());
                $fromUserInfo = new UserInfo($userId, $thumbnail, $type, $username);
                $commentCounter = $review->getCommentCounter();
                $loveCounter = $review->getLoveCounter();
                $lovers = $review->getLovers();
                if (in_array($currentUserId, $lovers)) {
                    $showLove = false;
                }
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
                $showLove = true;
                $counter = ++$counter;
                $commentCounter = $review->getCommentCounter();
                $loveCounter = $review->getLoveCounter();
                $lovers = $review->getLovers();
                if (in_array($currentUserId, $lovers)) {
                    $showLove = false;
                }
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
    public function initForUploadReviewPage($objectId, $className) {
        global $boxes;
        $currentUserId = sessionChecker(); //
        $reviewBox = new ReviewBox();
        $reviewBox->reviewArray = $boxes['NDB'];
        $reviewBox->reviewCounter = $boxes['NDB'];
        if ($className == 'Event') {
            $eventP = new EventParse();
            $eventP->where('objectId', $objectId);
            $eventP->setLimit($this->config->limitEventForUploadReviewPage);
            $eventP->whereInclude('fromUser');
            $events = $eventP->getEvents();
            if ($events instanceof Error) {
                return $events;
            } elseif (is_null($events)) {
                $reviewBox->mediaInfo = $boxes['NODATA'];
                return $reviewBox;
            } else {
                foreach ($events as $event) {
                    $className = 'Event';
                    $address = parse_decode_string($event->getAddress());
                    $city = parse_decode_string($event->getCity());
                    $eventDate = $event->getEventDate();
                    $featuring = $this->getFeaturedUsers($event->getObjectId(), false, $className);
                    $locationName = parse_decode_string($event->getLocationName());
                    $tags = array();
                    if (count($event->getTags()) > 0) {
                        foreach ($event->getTags() as $tag) {
                            $tag = parse_decode_string($tag);
                            array_push($tags, $tag);
                        }
                    }
                    $thumbnail = $event->getThumbnail();
                    $title = parse_decode_string($event->getTitle());
                    $fromUser = $event->getFromUser();
                }
            }
        } else {
            $recordP = new RecordParse();
            $recordP->where('objectId', $objectId);
            $recordP->setLimit($this->config->limitRecordForUploadReviewPage);
            $recordP->whereInclude('fromUser');
            $records = $recordP->getRecords();
            if ($records instanceof Error) {
                return $records;
            } elseif (is_null($records)) {
                $reviewBox->mediaInfo = $boxes['NODATA'];
                return $reviewBox;
            } else {
                foreach ($records as $record) {
                    $className = 'Record';
                    $featuring = $this->getFeaturedUsers($record->getObjectId(), false, $className);
                    $genre = $record->getGenre();
                    $title = parse_decode_string($record->getTitle());
                    $fromUser = $record->getFromUser();
                    $thumbnail = $record->getThumbnailCover();
                }
            }
        }
        $userId = $fromUser->getObjectId();
        $thumbnailUser = $fromUser->getProfileThumbnail();
        $userType = $fromUser->getType();
        $username = parse_decode_string($fromUser->getUsername());
        $fromUserInfo = new UserInfo($userId, $thumbnailUser, $userType, $username);
        $this->mediaInfo = new MediaInfoForUploadReviewPage($address, $city, $className, $eventDate, $featuring, $fromUserInfo, $genre, $featuring, $locationName, $objectId, $tags, $thumbnail, $title);
        return $reviewBox;
    }

}

?>