<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box informazioni event
 * \details		Recupera le informazioni da mostrare per la pagina dell'event
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
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

$id = 'AdPPB6Rcao';
$event_start = microtime();
$eventP = new EventParse();
$event = $eventP->getEvent($id);
$event_stop = microtime();

echo '<br />----------------------SX---------------------------<br />';
echo '<br />[title] => ' . $event->getTitle() . '<br />';
if ($event->getTags() != 0) {
    foreach ($event->getTags() as $tags) {
	$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$string .= '[tags] => ' . $tags . '<br />';
    }
}
echo '<br />[cover] => ' . $event->getImage() . '<br />';
echo '<br />[address] => ' . $event->getAddress() . '<br />';
echo '<br />[city] => ' . $event->getCity() . '<br />';
echo '<br />[cover] => ' . $event->getImage() . '<br />';
$string .= '[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
echo $string;
echo '<br />[description] => ' . $event->getDescription() . '<br />';
if (($geopoint = $event->getLocation()) != null) {
    $string .= '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
}

$fromUser_start = microtime();
$fromUserP = new UserParse();
$fromUser = $fromUserP->getUser($event->getFromUser());
echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
echo '<br />[thumbnail] => ' . $fromUser->getProfileThumbnail() . '<br />';
echo '<br />[type] => ' . $fromUser->getType() . '<br />';
$fromUser_stop = microtime();

$featuring_start = microtime();
$parseUser = new UserParse();
$parseUser->whereRelatedTo('featuring', '_User', $id);
$parseUser->where('active', true);
$featuring = $parseUser->getUsers();
if (count($featuring) != 0) {
    foreach ($featuring as $user) {
	echo '<br />----------------------PERFORMED--BY---------------------------<br />';
	echo '<br />[username] => ' . $user->getUsername() . '<br />';
	echo '<br />[thumbnail] => ' . $user->getProfileThumbnail() . '<br />';
	echo '<br />[type] => ' . $user->getType() . '<br />';
	echo '<br />----------------------PERFORMED--BY---------------------------<br />';
    }
}
$featuring_stop = microtime();

$attending_start = microtime();
$attendingP = new UserParse();
$attendingP->whereRelatedTo('attendee', 'Event', $id);
$attendingP->where('active', true);
$attending = $attendingP->getUsers();
if (count($attending) != 0) {
    foreach ($featuring as $user) {
	echo '<br />----------------------ATTENDING-----------------------------<br />';
	echo '<br />[username] => ' . $user->getUsername() . '<br />';
	echo '<br />[thumbnail] => ' . $user->getProfileThumbnail() . '<br />';
	echo '<br />[type] => ' . $user->getType() . '<br />';
	echo '<br />---------------------ATTENDING---------------------------<br />';
    }
}
$attendingCounter = $attendingP->getCount();//pensare a property counter
echo '<br />[attendingCounter] => ' . $attendingCounter . '<br />';
$attending_stop = microtime();

$invited_start = microtime();
$invitedP = new UserParse();
$invitedP->whereRelatedTo('invited', 'Event', $id);
$invitedP->where('active', true);
$invited = $invitedP->getUsers();
if (count($invited) != 0) {
    foreach ($invited as $user) {
	echo '<br />----------------------INVITED-----------------------------<br />';
	echo '<br />[username] => ' . $user->getUsername() . '<br />';
	echo '<br />[thumbnail] => ' . $user->getProfileThumbnail() . '<br />';
	echo '<br />[type] => ' . $user->getType() . '<br />';
	echo '<br />---------------------INVITED---------------------------<br />';
    }
}
$invitedCounter = $invitedP->getCount();//pensare a property counter
echo '<br />[invitedCounter] => ' . $invitedCounter . '<br />';
$invited_stop = microtime();

$t_end = microtime();
echo '<br />----------------------SX---------------------------<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero info event ' . executionTime($event_start, $event_stop) . '<br />';
echo 'Tempo recupero fromUser ' . executionTime($fromUser_start, $fromUser_stop) . '<br />';
echo 'Tempo featuring ' . executionTime($featuring_start, $featuring_stop) . '<br />';
echo 'Tempo attending ' . executionTime($attending_start, $attending_stop) . '<br />';
echo 'Tempo invited ' . executionTime($invited_start, $invited_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>