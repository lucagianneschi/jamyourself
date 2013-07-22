<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box review
 * \details		Recupera review degli eventi legate al profilo selezionato
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
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

$i_end = microtime();

$id = '7fes1RyY77';//LDF

$user_start = microtime();
$userParse = new UserParse();
$user_stop = microtime();
$user = $userParse->getUser($id);

$type = $user->getType();
$reviewEvent_start = microtime();
switch ($type) {
    case 'SPOTTER':	
		$parseReviewEvent = new ActivityParse();
		$parseReviewEvent->where('type','EVENTREVIEW');
		$parseReviewEvent->wherePointer('fromUser', '_User', $id);
		$parseReviewEvent->where('active', true);
		$parseReviewEvent->whereInclude('event');
		$parseReviewEvent->orderByDescending('createdAt');
		$activities = $parseReviewEvent->getActivities();
		if ($activities != 0) {
			if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
				foreach ($activities->event as $event) {
					echo '<br />[title] => ' . $event->getTitle() . '<br />';
					echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
					echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
					echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
					echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
					echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
					$geopoint = $event->getLocation();
					$string = '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
					}
				}
			}
		$activitiesCounter = $parseReviewEvent->getCount();	
			break;
	case 'VENUE':
		$parseReviewEvent = new ActivityParse();
		$parseReviewEvent->wherePointer('toUser', '_User', $id);
		$parseReviewEvent->where('type','EVENTREVIEW');
		$parseReviewEvent->where('active', true);
		$parseReviewEvent->whereInclude('event');
		$parseReviewEvent->orderByDescending('createdAt');
		$activities = $parseReviewEvent->getActivities();
		if ($activities != 0) {
			if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
				foreach ($activities->event as $event) {
					echo '<br />[title] => ' . $event->getTitle() . '<br />';
					echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
					echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
					echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
					echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
					echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
					$geopoint = $event->getLocation();
					$string = '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
					}
				}
			}
			$activitiesCounter = $parseReviewEvent->getCount();
			break;
	case 'JAMMER':	
		$parseReviewEvent = new ActivityParse();
		$parseReviewEvent->wherePointer('toUser', '_User', $id);
		$parseReviewEvent->where('type','EVENTREVIEW');
		$parseReviewEvent->where('active', true);
		$parseReviewEvent->whereInclude('event');
		$parseReviewEvent->orderByDescending('createdAt');
		$activities = $parseReviewEvent->getActivities();
		if ($activities != 0) {
			if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
				foreach ($activities->event as $event) {
					echo '<br />[title] => ' . $event->getTitle() . '<br />';
					echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
					echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
					echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
					echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
					echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
					$geopoint = $event->getLocation();
					$string = '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
					}
				}
			}
			$activitiesCounter = $parseReviewEvent->getCount();
		break;
	default:
		break;
	}
	$reviewEvent_stop = microtime();
	$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero User proprietario pagina ' . executionTime($user_start, $user_stop) . '<br />';
echo 'Tempo review' . executionTime($reviewEvent_start, $reviewEvent_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>