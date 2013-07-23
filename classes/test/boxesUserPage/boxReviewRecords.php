<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box review
 * \details		Recupera review dei record legate al profilo selezionato
 * \par			Commenti:
 * \warning
 * \bug
 * \todo                
 *
 */

$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
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

$i_end = microtime();

//SPOTTER
//$id = '1oT7yYrpfZ';//MARI
//$id = 'oN7Pcp2lxf';//FLAVYCAP 
//$id = '2OgmANcYaT';//Kessingtong


//$id = '7fes1RyY77'; //LDF 
$id = 'GuUAj83MGH';


$user_start = microtime();
$userParse = new UserParse();
$user = $userParse->getUser($id);
$user_stop = microtime();
$type = $user->getType();
$review_start = microtime();
switch ($type) {
    case 'SPOTTER':
	$parseReviewRecord = new ActivityParse();
	$parseReviewRecord->where('type', 'RECORDREVIEW');
	$parseReviewRecord->wherePointer('fromUser', '_User', $id);
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
		    echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
		    echo '<br />[title] => ' . $record->getTitle() . '<br />';

		    $userP = new UserParse();
		    $user = $userP->getUser($record->getFromUser());
		    echo '<br />[userName autore Record] => ' . $user->getUsername() . '<br />';

		    $reviewP = new CommentParse();
		    $review = $reviewP->getComment($activity->getComment());

		    echo '<br />[rating review] => ' . $review->getVote() . '<br />';
		    echo '<br />[testo review] => ' . $review->getText() . '<br />';
		    echo '<br />[loveCounter review] => ' . $review->getLoveCounter() . '<br />';
		    echo '<br />[commentCounter review] => ' . $review->getCommentCounter() . '<br />';
		    echo '<br />[shareCounter review] => ' . $review->getShareCounter() . '<br />';
		}
	    }
	}
	$activitiesCounter = $parseReviewRecord->getCount();
	break;
    case 'JAMMER':
	$parseReviewRecord = new ActivityParse();
	$parseReviewRecord->wherePointer('toUser', '_User', $id);
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

		    echo '<br />[rating review] => ' . $review->getVote() . '<br />';
		    echo '<br />[testo review] => ' . $review->getText() . '<br />';
		    echo '<br />[loveCounter review] => ' . $review->getLoveCounter() . '<br />';
		    echo '<br />[commentCounter review] => ' . $review->getCommentCounter() . '<br />';
		    echo '<br />[shareCounter review] => ' . $review->getShareCounter() . '<br />';

		    $userP = new UserParse();
		    $user = $userP->getUser($activity->getFromUser());
		    echo '<br />[userName autore Review] => ' . $user->getUsername() . '<br />';
		    echo '<br />[thumb autore Review] => ' . $user->getProfileThumbnail() . '<br />';


		    $recordP = new RecordParse();
		    $record = $recordP->getRecord($activity->getRecord());
		    echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
		    echo '<br />[title] => ' . $record->getTitle() . '<br />';
		}
	    }
	}
	$activitiesCounter = $parseReviewRecord->getCount();
	break;
    default:
	break;
}
$review_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero User proprietario pagina ' . executionTime($user_start, $user_stop) . '<br />';
echo 'Tempo review' . executionTime($review_start, $review_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>