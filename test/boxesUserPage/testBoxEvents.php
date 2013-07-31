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
    define('ROOT_DIR', '../../');

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
$id = 'HDgcsTLpEx';


$eventParse = new EventParse();
$eventParse->wherePointer('fromUser', '_User', $id);
$eventParse->where('active', true);
$eventParse->setLimit(1000);
$eventParse->orderByDescending('createdAt');
$events = $eventParse->getEvents();
if ($events != 0) {
    if (get_class($events) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
    } else {
	foreach ($events as $event) {
	    echo '<br />[thumbnail] => ' . $event->getThumbnail() . '<br />';
	    echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
	    echo '<br />[title] => ' . $event->getTitle() . '<br />';
	    if ($event->getTags() != 0) {
		foreach ($event->getTags() as $tags) {
		    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		    $string .= '[tags] => ' . $tags . '<br />';
		    echo $string;
		}
	    }
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('featuring', 'Event', $id);
	    $parseUser->where('active', true);
	    $featuring = $parseUser->getUsers();
	    if (count($featuring) != 0) {
		foreach ($featuring as $user) {
		    echo '<br />[username] => ' . $user->getUsername() . '<br />';
		}
	    }
	    echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
	    echo '<br />[city] => ' . $event->getCity() . '<br />';
	    echo '<br />[address] => ' . $event->getAddress() . '<br />';
	    echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
	    echo '<br />[reviewCounter] => ' . $event->getReviewCounter() . '<br />';
	}
    }
}

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>