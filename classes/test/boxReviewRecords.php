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
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

$i_end = microtime();

$id = '7fes1RyY77';//LDF

$user_start = microtime();
$userParse = new UserParse();
$user = $userParse->getUser($id);
$user_stop = microtime();
$type = $user->getType();
$review_start = microtime();
switch ($type) {
    case 'SPOTTER':	
		$parseReviewRecord = new ActivityParse();
		$parseReviewRecord->where('type','RECORDREVIEW');
		$parseReviewRecord->wherePointer('fromUser', '_User', $id);
		$parseReviewRecord->where('active', true);
		$parseReviewRecord->whereInclude('record');
		$parseReviewRecord->orderByDescending('createdAt');
		$activities = $parseReviewRecord->getActivities();
		if ($activities != 0) {
			if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
				foreach ($activities->record as $record) {
					echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
					echo '<br />[title] => ' . $record->getTitle() . '<br />';
					echo '<br />[loveCounter] => ' . $record->getLoveCounter() . '<br />';
					echo '<br />[commentCounter] => ' . $record->getCommentCounter() . '<br />';
					echo '<br />[shareCounter] => ' . $record->getShareCounter() . '<br />';
					echo '<br />[year] => ' . $record->getYear() . '<br />';
					echo '<br />[songCounter] => ' . $record->getSongCounter() . '<br />';
					}
				}
			}
		$activitiesCounter = $parseReviewRecord->getCount();	
		break;
	case 'VENUE':
		$parseReviewRecord = new ActivityParse();
		$parseReviewRecord->wherePointer('toUser', '_User', $id);
		$parseReviewRecord->where('type','RECORDREVIEW');
		$parseReviewRecord->where('active', true);
		$parseReviewRecord->whereInclude('event');
		$parseReviewRecord->orderByDescending('createdAt');
		$activities = $parseReviewRecord->getActivities();
		if ($activities != 0) {
			if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
				foreach ($activities->record as $record) {
					echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
					echo '<br />[title] => ' . $record->getTitle() . '<br />';
					echo '<br />[loveCounter] => ' . $record->getLoveCounter() . '<br />';
					echo '<br />[commentCounter] => ' . $record->getCommentCounter() . '<br />';
					echo '<br />[shareCounter] => ' . $record->getShareCounter() . '<br />';
					echo '<br />[year] => ' . $record->getYear() . '<br />';
					echo '<br />[songCounter] => ' . $record->getSongCounter() . '<br />';
					}
				}
			}
		$activitiesCounter = $parseReviewRecord->getCount();
		break;
	case 'JAMMER':	
		$parseReviewRecord = new ActivityParse();
		$parseReviewRecord->wherePointer('toUser', '_User', $id);
		$parseReviewRecord->where('type','RECORDREVIEW');
		$parseReviewRecord->where('active', true);
		$parseReviewRecord->whereInclude('event');
		$parseReviewRecord->orderByDescending('createdAt');
		$activities = $parseReviewRecord->getActivities();
		if ($activities != 0) {
			if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
				foreach ($activities->record as $record) {
					echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
					echo '<br />[title] => ' . $record->getTitle() . '<br />';
					echo '<br />[loveCounter] => ' . $record->getLoveCounter() . '<br />';
					echo '<br />[commentCounter] => ' . $record->getCommentCounter() . '<br />';
					echo '<br />[shareCounter] => ' . $record->getShareCounter() . '<br />';
					echo '<br />[year] => ' . $record->getYear() . '<br />';
					echo '<br />[songCounter] => ' . $record->getSongCounter() . '<br />';
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