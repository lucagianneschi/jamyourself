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
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class ReviewInfoRecord {

    public $commentCounter;
    public $loveCounter;
    public $profileThumbnail;
    public $rating;
    public $reviewCounter;
    public $shareCounter;
    public $text;
    public $title;
    public $thumbnailCover;
    public $username;

    function __construct($commentCounter, $loveCounter, $profileThumbnail, $rating, $reviewCounter, $shareCounter, $text, $thumbnailCover, $title, $username) {
	is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($profileThumbnail) ? $this->profileThumbnail = NODATA : $this->profileThumbnail = $profileThumbnail;
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

	$recordReview = new CommentParse();
	$recordReview->where('type','RR');
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
	$recordReview->wherePointer($field, '_User', $objectId);
	$recordReview->where('active', true);
	$recordReview->setLimit(1000);
	$recordReview->orderByDescending('createdAt');
	$reviews = $recordReview->getComments();
	if (count($reviews) != 0) {
	    if (get_class($reviews) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $reviews->getErrorMessage() . '<br/>';
	    } else {
		foreach ($reviews as $review) {
		    $counter = ++$counter;

		    $idRecord = $review->getRecord();

		    $recordP = new RecordParse();
		    $record = $recordP->getRecord($idRecord);

		    $userP = new UserParse();
		    switch ($type) {
			case 'SPOTTER':
			    $id = $record->getFromUser();
			    break;
			case 'JAMMER':
			    $id = $review->getFromUser();
			    break;
			default :
			    break;
		    }
		    $user = $userP->getUser($id);
		    if ($user != null) {
			$profileThumbnail = $user->getProfileThumbnail();
			$username = $user->getUsername();
		    } else {
			$profileThumbnail = null;
			$username = null;
		    }
		    $commentCounter = $review->getCommentCounter();
		    $loveCounter = $review->getLoveCounter();
		    $rating = $review->getVote();
		    $reviewCounter = $record->getReviewCounter();
		    $shareCounter = $review->getShareCounter();
		    $text = $review->getText();
		    $thumbnailCover = $record->getThumbnailCover();
		    $title = $record->getTitle();

		    $infoReviewRecord = new ReviewInfoRecord($commentCounter, $loveCounter, $profileThumbnail, $rating, $reviewCounter, $shareCounter, $text, $thumbnailCover, $title, $username);
		    array_push($info, $infoReviewRecord);
		}
		$reviewRecordBox->reviewRecordArray = $info;
		$reviewRecordBox->reviewRecordCounter = $counter;
	    }
	}
	return $reviewRecordBox;
    }

}

?>