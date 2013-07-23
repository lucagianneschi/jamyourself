<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento ultimi 4 eventi caricati
 * \details		Recupera le informazioni ultimi 4 eventi caricati
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		utilizzare variabili di sessione
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();

//$id = '7fes1RyY77';LDF
//$id = 'uMxy47jSjg';//ROSESINBLOOM
$id = '1oT7yYrpfZ';
$user_start = microtime();
$userParse = new UserParse();
$user = $userParse->getUser($id);
$user_stop = microtime(); 

$type = $user->getType();
$event_start = microtime();
switch ($type) {
     case 'VENUE':
		$eventParse = new EventParse();
		$eventParse->setLimit(4);
		$eventParse->wherePointer('fromUser', '_User', $id);
		$eventParse->where('active', true);
		$eventParse->orderByDescending('createdAt');
		$events = $eventParse->getEvents();
		if ($events != 0) {
			if (get_class($events) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
			} else {
			foreach ($events as $event) {
				echo '<br />[title] => ' . $event->getTitle() . '<br />';
				echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
				echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
				echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
				echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
				echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
				$geopoint = $event->getLocation();
				$string = '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
				echo $string;
				if ($event->getFeaturing() != 0) {
				echo '<br />----------------------!=0---------------------------<br />';
				foreach ($event->getFeaturing() as $user) {
					$userParse = new UserParse();
					$feat = $userParse->getUser($user);
					echo '<br />[feat] => ' . $feat->getUsername() . '<br />';
				}
				}
			}
			}
		}
		break;
	case 'JAMMER':
		$eventParse = new EventParse();
		$eventParse->setLimit(4);
		$eventParse->wherePointer('fromUser', '_User', $id);
		$eventParse->where('active', true);
		$eventParse->orderByDescending('createdAt');
		$events = $eventParse->getEvents();
		if ($events != 0) {
			if (get_class($events) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
			} else {
			foreach ($events as $event) {
				echo '<br />[title] => ' . $event->getTitle() . '<br />';
				echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
				echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
				echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
				echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
				echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
				if ($event->getFeaturing() != 0) {
				echo '<br />----------------------!=0---------------------------<br />';
				foreach ($event->getFeaturing() as $user) {
					$userParse = new UserParse();
					$feat = $userParse->getUser($user);
					echo '<br />[feat] => ' . $feat->getUsername() . '<br />';
				}
				}
			}
			}
		}
		break;
	default:
		break;
	}
$event_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero User proprietario pagina ' . executionTime($user_start, $user_stop) . '<br />';
echo 'Tempo recupero ultimi 4 eventi ' . executionTime($event_start, $event_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>