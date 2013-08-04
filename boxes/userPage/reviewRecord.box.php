<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento review record
 * \details		Recupera le informazioni sulal review del record, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class ReviewInfoRecord {

    public $avatarThumb; //fromUser del comment
    public $commentCounter; //comment
    public $loveCounter; //comment
    public $rating; //comment
    public $reviewCounter; //comment
    public $shareCounter; //comment
    public $text; //comment
    public $title; //record
    public $thumbnailCover; //record
    public $username; //fromUser del comment

    function __construct($avatarThumb, $commentCounter, $loveCounter, $rating, $reviewCounter, $shareCounter, $text, $thumbnailCover, $title, $username) {
	is_null($avatarThumb) ? $this->avatarThumb = NODATA : $this->avatarThumb = $avatarThumb;
	is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($rating) ? $this->rating = NODATA : $this->rating = $rating;
	is_null($reviewCounter) ? $this->reviewCounter = NODATA : $this->reviewCounter = $reviewCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($text) ? $this->text = NODATA : $this->text = $text;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($username) ? $this->username = NODATA : $this->username = $username;
    }

}

class ReviewRecordBox {

    public $reviewRecordArray;
    public $reviewRecordCounter;

    public function init($objectId, $type) {
	$info = array();
	$counter = 0;
	$reviewRecordBox = new ReviewRecordBox();
	$recordReview = new ActivityParse();
	$recordReview->where('type', 'RECORDREVIEW');
	switch ($type) {
	    case 'SPOTTER':
		$field = 'fromUser';
		break;
	    default :
		$field = 'toUser';
		break;
	}
	$recordReview->wherePointer($field, '_User', $objectId);
	$recordReview->where('active', true);
	$recordReview->orderByDescending('createdAt');
	$activities = $recordReview->getActivities();
	if ($activities != 0) {
	    if (get_class($activities) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
	    } else {
		foreach ($activities as $activity) {
		    $counter = ++$counter;

		    $reviewP = new CommentParse();
		    $review = $reviewP->getComment($activity->getComment());
		    
		    $recordP = new RecordParse();
		    $record = $recordP->getRecord($activity->getRecord());
		    
		    $userP = new UserParse();
		    $user = $userP->getUser($record->getFromUser());
		    
		    $avatarThumb = $user->getProfileThumbnail();
		    $commentCounter = $review->getCommentCounter();
		    $loveCounter = $review->getLoveCounter();
		    $rating = $review->getVote();
		    $reviewCounter = $recordReview->getCount();
		    $shareCounter = $review->getShareCounter();
		    $text = $review->getText();
		    $thumbnailCover = $record->getThumbnailCover();
		    $title = $record->getTitle();
		    $userName = $user->getUsername();

		    $infoReviewRecord = new ReviewInfoRecord($avatarThumb, $commentCounter, $loveCounter, $rating, $reviewCounter, $shareCounter, $text, $thumbnailCover, $title, $userName);
		    array_push($info, $infoReviewRecord);
		}
	    }
	}
	$reviewRecordBox->reviewRecordArray = $info;
	$reviewRecordBox->reviewRecordCounter = $counter;
	return $reviewRecordBox;
    }

}

?>