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
 * \todo		uso whereIncude
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	ReviewInfo class
 * \details	contains info for review to be displayed
 */
class ReviewInfo {

    public $counters;
    public $fromUserInfo;
    public $objectId;
    public $rating;
    public $text;
    public $title;
    public $thumbnailCover;

    /**
     * \fn	__construct($counters, $fromUserInfo,$objectId, $rating, $text, $thumbnailCover, $title)
     * \brief	construct for the ReviewInfo class
     * \param	$counters, $fromUserInfo,$objectId, $rating, $text, $thumbnailCover, $title
     * \todo    si potrebbe mettere un thumbnail di default, ma solo dopo aver capito se la review è di un record o di un event
     */
    function __construct($counters, $fromUserInfo, $objectId, $rating, $text, $thumbnailCover, $title) {
	global $boxes;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($rating) ? $this->rating = 0 : $this->rating = $rating;
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

    public $reviewArray;
    public $reviewCounter;

    /**
     * \fn	initForDetail($objectId)
     * \brief	Init ReviewBox instance for Personal Page, detailed view
     * \param	$objectId of the review to display information
     * \return	reviewBox
     * \todo	usare whereInclude per il fromUSer per evitare di fare una ulteriore get
     */
    public function initForDetail($objectId, $className) {//objetId record/event
	global $boxes;
	$reviewBox = new ReviewBox();
	$reviewBox->reviewCounter = $boxes['NDB'];
	$info = array();

	$review = new CommentParse();
	if ($className == 'Event') {
	    require_once CLASSES_DIR . 'event.class.php';
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $review->where('type', 'RE');
	    $field = "event";
	} else {
	    require_once CLASSES_DIR . 'record.class.php';
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $review->where('type', 'RR');
	    $field = "record";
	}
	$review->wherePointer($field, $className, $objectId);
	$review->where('active', true);
	$review->setLimit(1000);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if (get_class($reviews) == 'Error') {
	    return $reviews;
	} else {
	    var_dump($reviews);
	    foreach ($reviews as $review) {
		$userP = new UserParse();
		$fromUserID = $review->getFromUser();
		$user = $userP->getUser($fromUserID);
		if (get_class($user) == 'Error') {
		    return $user;
		} else {
		    $objectIdUser = $fromUserID;
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $encodedUsername = $user->getUserName();
		    $username = parse_decode_string($encodedUsername);
		    $fromUserInfo = new UserInfo($objectIdUser, $thumbnail, $type, $username);
		}

		$objectId = $review->getObjectId();
		$rating = $review->getVote();

		$commentCounter = $review->getCommentCounter();
		$loveCounter = $review->getLoveCounter();
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $review->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);

		$encodedText = $review->getText();
		$text = parse_decode_string($encodedText);
		$thumbnailCover = $boxes['NDB'];
		$encodedTitle = $review->getTitle();
		$title = parse_decode_string($encodedTitle);

		$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $objectId, $rating, $text, $thumbnailCover, $title);
		array_push($info, $reviewInfo);
	    }
	    if (empty($info)) {
		$reviewBox->reviewArray = $boxes['NODATA'];
	    } else {
		$reviewBox->reviewArray = $info;
	    }
	}
	return $reviewBox;
    }

    /**
     * \fn	initForMediaPage($objectId, $className)
     * \brief	Init ReviewBox instance for Media Page
     * \param	$objectId of the review to display information, Event or Record class
     * \return	reviewBox
     * \todo	usare whereInclude per il fromUSer per evitare di fare una ulteriore get
     */
    public function initForMediaPage($objectId, $className) {

	global $boxes;
	$reviewBox = new ReviewBox();
	$counter = 0;
	$info = array();

	$review = new CommentParse();
	if ($className == 'Event') {
	    require_once CLASSES_DIR . 'event.class.php';
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $review->where('type', 'RE');
	    $field = "event";
	} else {
	    require_once CLASSES_DIR . 'record.class.php';
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $review->where('type', 'RR');
	    $field = "record";
	}
	$review->wherePointer($field, $className, $objectId);
	$review->where('active', true);
	$review->setLimit(1000);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if (get_class($reviews) == 'Error') {
	    return $review;
	} else {
	    foreach ($reviews as $review) {
		$counter = ++$counter;

		$userP = new UserParse();
		$user = $userP->getUser($review->getFromUser());
		if (get_class($user) == 'Error') {
		    return $user;
		} else {
		    $objectId = $user->getObjectId();
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $encodedUsername = $user->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $fromUserInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		}

		$commentCounter = $review->getCommentCounter();
		$loveCounter = $review->getLoveCounter();
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $review->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$objectId = $review->getObjectId();
		$rating = $review->getVote();

		$encodedText = $review->getText();
		$text = parse_decode_string($encodedText);
		$thumbnailCover = $boxes['NDB'];

		$encodedTitle = $review->getTitle();
		$title = parse_decode_string($encodedTitle);

		$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $objectId, $rating, $text, $thumbnailCover, $title);
		array_push($info, $reviewInfo);
	    }
	    if (empty($info)) {
		$reviewBox->reviewArray = $boxes['NODATA'];
	    } else {
		$reviewBox->reviewArray = $info;
	    }
	    $reviewBox->reviewCounter = $counter;
	}
	return $reviewBox;
    }

    /**
     * \fn	initForPersonalPage($objectId, $type, $className)
     * \brief	Init ReviewBox instance for Personal Page
     * \param	$objectId of the user who owns the page, $type of user, $className Record or Event class
     * \return	reviewBox
     */
    function initForPersonalPage($objectId, $type, $className) {
	global $boxes;
	$reviewBox = new ReviewBox();
	$info = array();
	$counter = 0;
	$reviewP = new CommentParse();
	if ($type === 'SPOTTER') {
	    $field = 'fromUser';
	    $reviewP->whereInclude('toUser');
	} else {
	    $field = 'toUser';
	    $reviewP->whereInclude('fromUser');
	}
	$reviewP->wherePointer($field, '_User', $objectId);
	if ($className == 'Event') {
	    require_once CLASSES_DIR . 'event.class.php';
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $reviewP->where('type', 'RE');
	    $reviewP->whereInclude('event');
	} else {
	    require_once CLASSES_DIR . 'record.class.php';
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $reviewP->where('type', 'RR');
	    $reviewP->whereInclude('record');
	}
	$reviewP->where('active', true);
	$reviewP->setLimit(1000);
	$reviewP->orderByDescending('createdAt');
	$reviews = $reviewP->getComments();
	if (get_class($reviews) == 'Error') {
	    return $reviews;
	} else {
	    foreach ($reviews as $review) {
		$counter = ++$counter;
		$commentCounter = $review->getCommentCounter();
		$loveCounter = $review->getLoveCounter();
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $review->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);

		$objectId = $review->getObjectId();
		$rating = $review->getVote();
		$encodedTitle = $review->getTitle();
		$title = parse_decode_string($encodedTitle);

		$encodedText = $review->getText();
		$text = parse_decode_string($encodedText);

		if ($type === 'VENUE' || $type === 'JAMMER') {
		    $user = $review->getFromUser();
		} else {
		    $user = $review->getToUser();
		}
		$userId = $user->getObjectId();
		$thumbnail = $user->getProfileThumbnail();
		$type = $user->getType();
		$encodedUsername = $user->getUsername();
		$username = parse_decode_string($encodedUsername);
		$fromUserInfo = new UserInfo($userId, $thumbnail, $type, $username);
		if ($className == 'Event') {
		    $event = $review->getEvent();
		    var_dump($event);
		    $thumbnailCover = $event->getThumbnail();
		} else {
		    $record = $review->getRecord();
		    $thumbnailCover = $record->getThumbnailCover();
		}
		$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $objectId, $rating, $text, $thumbnailCover, $title);
		array_push($info, $reviewInfo);
	    }
	    if (empty($info)) {
		$reviewBox->reviewArray = $boxes['NODATA'];
	    } else {
		$reviewBox->reviewArray = $info;
	    }
	    $reviewBox->reviewCounter = $counter;
	}
	return $reviewBox;
    }

}

?>