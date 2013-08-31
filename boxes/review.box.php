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
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
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
    public $rating;
    public $text;
    public $title;
    public $thumbnailCover;

    /**
     * \fn	__construct($counters, $fromUserInfo, $rating, $text, $thumbnailCover, $title)
     * \brief	construct for the ReviewInfo class
     * \param	$counters, $fromUserInfo, $rating, $text, $thumbnailCover, $title
     */
    function __construct($counters, $fromUserInfo, $rating, $text, $thumbnailCover, $title) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($rating) ? $this->rating = NODATA : $this->rating = $rating;
	is_null($text) ? $this->text = NODATA : $this->text = $text;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
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
     */
    public function initForDetail($objectId, $className) {//objetId record/event
	$reviewBox = new ReviewBox();
	$reviewBox->reviewCounter = NDB;
	$info = array();

	$review = new CommentParse();
	switch ($className) {
	    case 'Event':
		require_once CLASSES_DIR . 'event.class.php';
		require_once CLASSES_DIR . 'eventParse.class.php';
		$review->where('type', 'RE');
		$field = "event";
		break;
	    case 'Record':
		require_once CLASSES_DIR . 'record.class.php';
		require_once CLASSES_DIR . 'recordParse.class.php';
		$review->where('type', 'RR');
		$field = "record";
		break;
	    default:
		break;
	}
	$review->wherePointer($field, $className, $objectId);
	$review->where('active', true);
	$review->setLimit(1000);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if (get_class($reviews) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $reviews->getErrorMessage() . '<br/>';
	} else {
	    foreach ($reviews as $review) {

		$userP = new UserParse();
		$user = $userP->getUser($review->getFromUser());
		$thumbnail = $user->getProfileThumbnail();
		$type = $user->getType();
		$username = $user->getUsername();
		$fromUserInfo = new UserInfo($thumbnail, $type, $username);
		$rating = $review->getVote();

		$commentCounter = $review->getCommentCounter();
		$loveCounter = $review->getLoveCounter();
		$reviewCounter = NULL;
		$shareCounter = $review->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);

		$text = $review->getText();
		$title = $review->getTitle();
		$thumbnailCover = NULL;

		$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $rating, $text, $thumbnailCover, $title);
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
     */
    public function initForMediaPage($objectId, $className) {
	$reviewBox = new ReviewBox();
	$counter = 0;
	$info = array();

	$review = new CommentParse();
	switch ($className) {
	    case 'Event':
		require_once CLASSES_DIR . 'event.class.php';
		require_once CLASSES_DIR . 'eventParse.class.php';
		$review->where('type', 'RE');
		$field = 'event';
		break;
	    case 'Record':
		require_once CLASSES_DIR . 'record.class.php';
		require_once CLASSES_DIR . 'recordParse.class.php';
		$review->where('type', 'RR');
		$field = 'record';
		break;
	    default:
		break;
	}
	$review->wherePointer($field, $className, $objectId);
	$review->where('active', true);
	$review->setLimit(1000);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if (get_class($reviews) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $reviews->getErrorMessage() . '<br/>';
	} else {
	    foreach ($reviews as $review) {
		$counter = ++$counter;

		$userP = new UserParse();
		$user = $userP->getUser($review->getFromUser());
		if (get_class($user) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $user->getErrorMessage() . '<br/>';
		} else {
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $fromUserInfo = new UserInfo($thumbnail, $type, $username);
		}

		$commentCounter = $review->getCommentCounter();
		$loveCounter = $review->getLoveCounter();
		$reviewCounter = NDB;
		$shareCounter = $review->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);

		$rating = $review->getVote();

		$text = $review->getText();
		$thumbnailCover = NDB;

		$title = $review->getTitle();

		$reviewInfo = new ReviewInfo($counters, $fromUserInfo, $rating, $text, $thumbnailCover, $title);
		array_push($info, $reviewInfo);
	    }
	    $reviewBox->reviewArray = $info;
	    $reviewBox->reviewCounter = $counter;
	}
	return $reviewBox;
    }

    /**
     * \fn	initForPersonalPage($objectId, $type, $className)
     * \brief	Init ReviewBox instance for Media Page
     * \param	$objectId of the user who owns the page, $type of user, $className Record or Event class
     * \return	reviewBox
     */
    function initForPersonalPage($objectId, $type, $className) {
	$info = array();
	$counter = 0;
	switch ($type) {
	    case 'SPOTTER':
		$field = 'fromUser';
		break;
	    case 'JAMMER':
		$field = 'toUser';
		break;
	    default :
		break;
	}

	$reviewBox = new ReviewBox();
	$review = new CommentParse();
	switch ($className) {
	    case 'Event':
		require_once CLASSES_DIR . 'event.class.php';
		require_once CLASSES_DIR . 'eventParse.class.php';
		$review->where('type', 'RE');
		break;
	    case 'Record':
		require_once CLASSES_DIR . 'record.class.php';
		require_once CLASSES_DIR . 'recordParse.class.php';
		$review->where('type', 'RR');
		break;
	    default:
		break;
	}
	$review->wherePointer($field, '_User', $objectId);
	$review->where('active', true);
	$review->setLimit(1000);
	$review->orderByDescending('createdAt');
	$reviews = $review->getComments();
	if (count($reviews) != 0) {
	    if (get_class($reviews) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $reviews->getErrorMessage() . '<br/>';
	    } else {
		foreach ($reviews as $review) {
		    $counter = ++$counter;
		    switch ($className) {
			case 'Event':
			    $id = $review->getEvent();
			    $eventP = new EventParse();
			    $event = $eventP->getEvent($id);
			    switch ($type) {
				case 'SPOTTER':
				    $userId = $event->getFromUser();
				    break;
				case 'JAMMER':
				    $userId = $review->getFromUser();
				    break;
				default:
				    break;
			    }
			    $reviewCounter = $event->getReviewCounter();
			    $thumbnailCover = $event->getThumbnail();
			    $title = $event->getTitle();
			    break;
			case 'Record':
			    $id = $review->getRecord();
			    $recordP = new RecordParse();
			    $record = $recordP->getRecord($id);
			    switch ($type) {
				case 'SPOTTER':
				    $userId = $record->getFromUser();
				    break;
				case 'JAMMER':
				    $userId = $review->getFromUser();
				    break;
				default :
				    break;
			    }
			    $reviewCounter = $record->getReviewCounter();
			    $thumbnailCover = $record->getThumbnailCover();
			    $title = $record->getTitle();
			    break;
			default:
			    break;
		    }
		    $commentCounter = $review->getCommentCounter();
		    $loveCounter = $review->getLoveCounter();
		    $rating = $review->getVote();
		    $shareCounter = $review->getShareCounter();
		    $text = $review->getText();

		    $counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);

		    $userP = new UserParse();
		    $user = $userP->getUser($userId);
		    if (get_class($user) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $user->getErrorMessage() . '<br/>';
		    } else {
			$thumbnail = $user->getProfileThumbnail();
			$type = $user->getType();
			$username = $user->getUsername();
			$fromUserInfo = new UserInfo($thumbnail, $type, $username);
		    }
		    $reviewInfo = new ReviewInfo($counters, $fromUserInfo, $rating, $text, $thumbnailCover, $title);
		    array_push($info, $reviewInfo);
		}
		$reviewBox->reviewArray = $info;
		$reviewBox->reviewCounter = $counter;
	    }
	}
	return $reviewBox;
    }

}

?>