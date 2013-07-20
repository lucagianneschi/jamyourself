<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		File di caricamento informazioni pagina Jammer
 * \details		Recupera le informazioni da mostrare per il profilo selezionato
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
$i_end = microtime();
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';


$id = '7fes1RyY77';
$userParse = new UserParse();
$user = $userParse->getUser($id);

$t_start = microtime(); //timer tempo totale
$notification1_start = microtime();
$notification1 = new ActivityParse();
$notification1->wherePointer('toUser', 'User', $id);
$notification1->where('type', 'MESSAGESENT');
$notification1->where('read', false);
$unreadMessages = $notification1->getCount();
echo '<br />[N° di messaggi da leggere] => ' . $unreadMessages . '<br />';
$notification1_stop = microtime();

$notification2_start = microtime();
$notification2 = new ActivityParse();
$notification2->wherePointer('toUser', 'User', $id);
$notification2->where('type', 'INVITED');
$notification2->where('read', false);
$invitations = $notification2->getCount();
echo '<br />[N° di inviti] => ' . $invitations . '<br />';
$notification2_stop = microtime();

$type = $user->getType();
switch ($type) {
    case 'SPOTTER':
	$notification3Spotter_start = microtime();
	$notification3Spotter = new ActivityParse();
	$notification3Spotter->wherePointer('toUser', '_User', $id);
	$notification3Spotter->where('type', 'FRIENDREQUEST');
	$notification3Spotter->where('status', 'W');
	$notification3Spotter->where('read', false);
	$invitations = $notification3Spotter->getCount();
	if ($invitations == 0) {
	    echo '<br />[N° di relazioni di interesse] => 0 <br />';
	} else {
	    if (get_class($invitations) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $invitations->getErrorMessage() . '<br/>';
	    } else {
		echo '<br />[N° di relazioni di interesse] => ' . $invitations . '<br />';
	    }
	}
	$notification3Spotter_stop = microtime();

	echo '<br />----------------------SPOTTER---------------------------<br />';
	break;
    case 'VENUE':
	$notification3Venue_start = microtime();
	$activity1 = 'COLLABORATIONREQUEST';
	$activity2 = 'FOLLOWING';
	$activityTypes = array($activity1, $activity2);
	$notification3Venue = new parseQuery('Activity');
	$notification3Venue->where('$or', $activityTypes);
	$notification3Venue->where('status', 'W');
	$notification3Venue->where('read', false);
	$invitations = $notification3Venue->count;
	echo '<br />[N° di relazioni di interesse] => ' . $invitations . '<br />';
	$notification3Venue_stop = microtime();
	echo '<br />----------------------VENUE---------------------------<br />';
	break;
    case 'JAMMER':
	$notification3Jammer_start = microtime();
	$activity1 = 'COLLABORATIONREQUEST';
	$activity2 = 'FOLLOWING';
	$activityTypes = array($activity1, $activity2);
	$notification3Jammer = new parseQuery('Activity');
	$notification3Jammer->where('$or', $activityTypes);
	$notification3Jammer->where('status', 'W');
	$notification3Jammer->where('read', false);
	$invitations = $notification3Jammer->count;
	if ($invitations == 0) {
	    echo '<br />[N° di relazioni di interesse] => 0 <br />';
	} else {
	    if (get_class($invitations) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $invitations->getErrorMessage() . '<br/>';
	    } else {
		echo '<br />[N° di relazioni di interesse] => ' . $invitations . '<br />';
	    }
	}
	$notification3Jammer_stop = microtime();
	echo '<br />----------------------JAMMER---------------------------<br />';
	break;
    default:
	break;
}
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo messaggi da leggere ' . executionTime($notification1_start, $notification1_stop) . '<br />';
echo 'Tempo inviti ' . executionTime($notification2_start, $notification2_stop) . '<br />';
switch ($type) {
    case 'SPOTTER':
	echo '<br />----------------------SPOTTER---------------------------<br />';
	echo 'Tempo relazioni di interesse ' . executionTime($notification3Spotter_start, $notification3Spotter_stop) . '<br />';
	break;
    case 'VENUE':
	echo '<br />----------------------VENUE---------------------------<br />';
	echo 'Tempo relazioni di interesse ' . executionTime($notification3Venue_start, $notification3Venue_stop) . '<br />';
	break;
    case 'JAMMER':
	echo '<br />----------------------JAMMER---------------------------<br />';
	echo 'Tempo relazioni di interesse ' . executionTime($notification3Jammer_start, $notification3Jammer_stop) . '<br />';
	break;
    default:
	break;
}
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>
