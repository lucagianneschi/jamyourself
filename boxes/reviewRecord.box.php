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
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class reviewRecordsBox {

    public function sendInfo($objectId) {
	$resultArray = array();
	$userParse = new UserParse();
	$user = $userParse->getUser($objectId);
	$type = $user->getType();
	switch ($type) {
	    case 'SPOTTER':
		$parseReviewRecord = new ActivityParse();
		$parseReviewRecord->where('type', 'RECORDREVIEW');
		$parseReviewRecord->wherePointer('fromUser', '_User', $objectId);
		$parseReviewRecord->where('active', true);
		$parseReviewRecord->orderByDescending('createdAt');
		$activities = $parseReviewRecord->getActivities();
		if ($activities != 0) {
		    if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
		    } else {
			foreach ($activities as $activity) {
			    $recordP = new RecordParse();
			    $record = $recordP->getRecord($activity->getRecord());
			    $thumbnailCover = $record->getThumbnailCover();
			    $title = $record->getTitle();

			    $userP = new UserParse();
			    $user = $userP->getUser($record->getFromUser());
			    $userName = $user->getUsername();

			    $reviewP = new CommentParse();
			    $review = $reviewP->getComment($activity->getComment());
			    $rating = $review->getVote();
			    $text = $review->getText();
			    $loveCounter = $review->getLoveCounter();
			    $commentCounter = $review->getCommentCounter();
			    $shareCounter = $review->getShareCounter();
			    $reviewCounter = $parseReviewRecord->getCount();
			    $reviewRecordInfo = array('thumbnailCover' => $thumbnailCover,
				'title' => $title,
				'userName' => $userName,
				'rating' => $rating,
				'text' => $text,
				'loveCounter' => $loveCounter,
				'commentCounter' => $commentCounter,
				'shareCounter' => $shareCounter,
				'reviewCounter' => $reviewCounter);
			    array_push($resultArray, $reviewRecordInfo);
			}
		    }
		}
		break;
	    case 'JAMMER':
		$parseReviewRecord = new ActivityParse();
		$parseReviewRecord->wherePointer('toUser', '_User', $objectId);
		$parseReviewRecord->where('type', 'RECORDREVIEW');
		$parseReviewRecord->where('active', true);
		$parseReviewRecord->setLimit(1000);
		$parseReviewRecord->orderByDescending('createdAt');
		$activities = $parseReviewRecord->getActivities();
		if ($activities != 0) {
		    if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
		    } else {
			foreach ($activities as $activity) {

			    $reviewP = new CommentParse();
			    $review = $reviewP->getComment($activity->getComment());
			    $rating = $review->getVote();
			    $text = $review->getText();
			    $loveCounter = $review->getLoveCounter();
			    $commentCounter = $review->getCommentCounter();
			    $shareCounter = $review->getShareCounter();

			    $userP = new UserParse();
			    $user = $userP->getUser($activity->getFromUser());
			    $username = $user->getUsername();
			    $thumbnail = $user->getProfileThumbnail();

			    $recordP = new RecordParse();
			    $record = $recordP->getRecord($activity->getRecord());
			    $thumbnailCover = $record->getThumbnailCover();
			    $title = $record->getTitle();
			    $reviewCounter = $parseReviewRecord->getCount();
			    $reviewRecordInfo = array(
				'rating' => $rating,
				'text' => $text,
				'loveCounter' => $loveCounter,
				'commentCounter' => $commentCounter,
				'shareCounter' => $shareCounter,
				'username' => $username,
				'thumbnail' => $thumbnail,
				'title' => $title,
				'thumbnailCover' => $thumbnailCover,
				'reviewCounter' => $reviewCounter);
			    array_push($resultArray, $reviewRecordInfo);
			}
		    }
		}
		break;
	    default:
		break;
	}
	return $resultArray;
    }

}

?>
