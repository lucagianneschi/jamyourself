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

    public $config;
    public $reviewArray;
    public $reviewCounter;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/review.config.json"), false);
    }

    /**
     * \fn	initForDetail($objectId)
     * \brief	Init ReviewBox instance for Personal Page, detailed view
     * \param	$objectId of the review to display information
     * \return	reviewBox
     * \todo	usare whereInclude per il fromUser per evitare di fare una ulteriore get
     */
    public function initForDetail($objectId) {//objetId record/event
	global $boxes;
	$info = array();
	$reviewBox = new ReviewBox();
	$reviewBox->reviewCounter = $boxes['NDB'];
	$review = new CommentParse();
	$review->where('objectId',$objectId);
	$review->where('active', true);
	$review->whereInclude('fromUser');
	$review->setLimit($this->config->limitForDetail);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if (get_class($reviews) == 'Error') {
	    return $reviews;
	} elseif (count($reviews) == 0) {
	    $reviewBox->reviewArray = $boxes['NODATA'];
	} else {
	    foreach ($reviews as $review) {
		$userId = $review->getFromUser()->getObjectId();
		$thumbnail = $review->getFromUser()->getProfileThumbnail();
		$type = $review->getFromUser()->getType();
		$encodedUsername = $review->getFromUser()->getUserName();
		$username = parse_decode_string($encodedUsername);
		$fromUserInfo = new UserInfo($userId, $thumbnail, $type, $username);
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
	    $reviewBox->reviewArray = $info;
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
    public function initForMediaPage($objectId) {
	global $boxes;
	$counter = 0;
	$info = array();
	$reviewBox = new ReviewBox();
	$review = new CommentParse();
	$review->where('objectId',$objectId);
	$review->where('active', true);
	$review->whereInclude('fromUser');
	$review->setLimit($this->config->limitForMediaPage);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if (get_class($reviews) == 'Error') {
	    return $reviews;
	} elseif (count($reviews) == 0) {
	    $reviewBox->reviewArray = $boxes['NODATA'];
	    $reviewBox->reviewCounter = $boxes['NODATA'];
	} else {
	    foreach ($reviews as $review) {
		$counter = ++$counter;
		$userId = $review->getFromUser()->getObjectId();
		$thumbnail = $review->getFromUser()->getProfileThumbnail();
		$type = $review->getFromUser()->getType();
		$encodedUsername = $review->getFromUser()->getUserName();
		$username = parse_decode_string($encodedUsername);
		$fromUserInfo = new UserInfo($userId, $thumbnail, $type, $username);
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
	    $reviewBox->reviewArray = $info;
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
	$info = array();
	$counter = 0;
	if ($type == 'SPOTTER') {
	    $field = 'fromUser';
	} else {
	    $field = 'toUser';
	}
	$reviewBox = new ReviewBox();
	$reviewP = new CommentParse();
	if ($className == 'Event') {
	    $reviewP->where('type', 'RE');
	} else {
	    $reviewP->where('type', 'RR');
	}
	$reviewP->wherePointer($field, '_User', $objectId);
	$reviewP->where('active', true);
	if($type == 'SPOTTER' && $className == 'Event'){
		$reviewP->whereInclude('event,event.fromUser');
	} elseif($type == 'SPOTTER' && $className == 'Record'){
		$reviewP->whereInclude('record,record.fromUser');
	} elseif($type != 'SPOTTER' && $className == 'Event'){
			$reviewP->whereInclude('event,fromUser');
	} else {
		$reviewP->whereInclude('record,fromUser');
	}
	$reviewP->setLimit($this->config->limitForPersonalPage);
	$reviewP->orderByDescending('createdAt');
	$reviews = $reviewP->getComments();
	if (get_class($reviews) == 'Error') {
	    return $reviews;
	} elseif (count($reviews) == 0) {
	    $reviewBox->reviewArray = $boxes['NODATA'];
	    $reviewBox->reviewCounter = $boxes['NODATA'];
	} else {
	    foreach ($reviews as $review) {
			$counter = ++$counter;
			$commentCounter = $review->getCommentCounter();
			$loveCounter = $review->getLoveCounter();
			$reviewCounter = $boxes['NDB'];
			$shareCounter = $review->getShareCounter();
			$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
			$reviewId = $review->getObjectId();
			$rating = $review->getVote();
			$encodedText = $review->getText();
			$text = parse_decode_string($encodedText);
			$encodedTitle = $review->getTitle();
			$title = parse_decode_string($encodedTitle);
			
			if($type == 'SPOTTER'){
				$fromUserInfo = $boxes['ND'];
			} else {
				$userId = $review->getFromUser()->getObjectId();
				$thumbnail = $review->getFromUser()->getProfileThumbnail();
				$userType = $review->getFromUser()->getType();
				$encodedUsername = $review->getFromUser()->getUsername();
				$username = parse_decode_string($encodedUsername);
				$fromUserInfo = new UserInfo($userId, $thumbnail, $userType, $username);
			}
			// if ($className == 'Event') {
				// $thumbnailCover = $review->getEvent()->getThumbnail();
			// } else {
				// $thumbnailCover = $review->getRecord()->getThumbnailCover();
			// }
			$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $reviewId , $rating, $text, $thumbnailCover, $title);
			array_push($info, $reviewInfo);
	    }
	    $reviewBox->reviewArray = $info;
	    $reviewBox->reviewCounter = $counter;
	}
	return $reviewBox;
    }

}

?>