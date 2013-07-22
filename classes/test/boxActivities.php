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
 * \todo                creare counter per Jammer e Venue separati, evita di fare una count, che prende circa 0,5 s;
 * \todo                modificare il box activities per lo spotter, prendendo un'activity per la quale è un fromUser per INVITED e non un toUser, così puoi fare una OR, risparmi 0,5 s
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
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();

$id = '7fes1RyY77';//LDF

$user_start = microtime();
$userParse = new UserParse();
$user = $userParse->getUser($id);

$type = $user->getType();
switch ($type) {
    case 'SPOTTER':
	$include_start = microtime();
	$include_stop = microtime();


	$activitySpotter_start = microtime();
	$activity = new ActivityParse;
	$activity->setLimit(1);
	$activity->wherePointer('toUser', '_User', $id);
	$activity->where('type', 'INVITED'); //potremmo creare altra activity collegata in cui lo SPOTTER è fromUser, così si fa una compoundquery doppia
	$activity->where('status', 'A');
	$activity->whereInclude('event');
	$activity->orderByDescending('updatedAt');
	$lastEventUpdated = $activity->getActivities();
	if ($lastEventUpdated != 0) {
	    if (get_class($lastEventUpdated) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastEventUpdated->getErrorMessage() . '<br/>';
	    } else {
		foreach ($lastEventUpdated as $event) {
		    echo '<br />[title] => ' . $event->getTitle() . '<br />';
		    echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
		    echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
		    echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
		    echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
		    echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
		    $geopoint = $event->getLocation();
		    $string = '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
		    echo $string;
		}
	    }
	}

	$activity1 = new ActivityParse;
	$activity1->setLimit(1);
	$activity1->wherePointer('fromUser', '_User', $id);
	$activity1->where('type', 'ALBUMUPDATED');
	$activity1->whereInclude('album');
	$activity1->orderByDescending('updatedAt');
	$lastAlbumUpdated = $activity1->getActivities();
	if ($lastAlbumUpdated != 0) {
	    if (get_class($lastAlbumUpdated) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastAlbumUpdated->getErrorMessage() . '<br/>';
	    } else {
		foreach ($lastAlbumUpdated as $album) {
		    echo '<br />[thumbnailCover] => ' . $album->getThumbnailCover() . '<br />';
		    echo '<br />[title] => ' . $album->getTitle() . '<br />';
		    echo '<br />[loveCounter] => ' . $album->getLoveCounter() . '<br />';
		    echo '<br />[commentCounter] => ' . $album->getCommentCounter() . '<br />';
		    echo '<br />[shareCounter] => ' . $album->getShareCounter() . '<br />';
		}
	    }
	}
	$activitySpotter__stop = microtime();
	echo '<br />----------------------SPOTTER---------------------------<br />';
	break;
    case 'VENUE':
	$include_start = microtime();
	require_once CLASSES_DIR . 'event.class.php';
	require_once CLASSES_DIR . 'eventParse.class.php';
	$include_stop = microtime();

	$activityVenue_start = microtime();
	$updatedEvent = 'EVENTUPDATED';
	$updatedAlbum = 'ALBUMUPDATED';
	$activitiesType = array($updatedAlbum, $updatedEvent);
	$parseActivity1 = new parseQuery('Activity');
	$parseActivity1->wherePointer('fromUser', '_User', $id);
	$parseActivity1->where('$or', $activitiesType);
	$parseActivity1->whereInclude('album');
	$parseActivity1->whereInclude('event');
	$parseActivity1->setLimit(3);
	$parseActivity1->orderByDescending('updatedAt');
	$last3activities = $parseActivity1->getActivities();
	if ($last3activities != 0) {
	    if (get_class($last3activities) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last3activities->getErrorMessage() . '<br/>';
	    } else {
		foreach ($last3activities as $activity) {
		    if ($activity->event != null) {
			$event = $activity->event;
			echo '<br />[title] => ' . $event->getTitle() . '<br />';
			echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
			echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
			echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
			echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
			echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
		    } elseif ($activity->album != null) {
			$album = $activity->album;
			echo '<br />[thumbnailCover] => ' . $album->getThumbnailCover() . '<br />';
			echo '<br />[title] => ' . $album->getTitle() . '<br />';
			echo '<br />[loveCounter] => ' . $album->getLoveCounter() . '<br />';
			echo '<br />[commentCounter] => ' . $album->getCommentCounter() . '<br />';
			echo '<br />[shareCounter] => ' . $album->getShareCounter() . '<br />';
		    }
		}
	    }
	}
	$activityVenue_stop = microtime();
	echo '<br />----------------------VENUE---------------------------<br />';
	break;
    case 'JAMMER':
	$include_start = microtime();
	require_once CLASSES_DIR . 'event.class.php';
	require_once CLASSES_DIR . 'eventParse.class.php';
	require_once CLASSES_DIR . 'record.class.php';
	require_once CLASSES_DIR . 'recordParse.class.php';
	$include_stop = microtime();
	


	$activityJammer_start = microtime();
	$updatedEvent = 'EVENTUPDATED';
	$updatedAlbum = 'ALBUMUPDATED';
	$updatedRecord = 'RECORDUPDATED';
	$activitiesType = array($updatedAlbum, $updatedEvent, $updatedRecord);
	$parseActivity1 = new parseQuery('Activity');
	$parseActivity1->wherePointer('fromUser', '_User', $id);
	$parseActivity1->where('$or', $activitiesType);
	$parseActivity1->whereInclude('album');
	//$parseActivity1->whereInclude('event');
	//$parseActivity1->whereInclude('record');
	$parseActivity1->setLimit(3);
	$parseActivity1->orderByDescending('updatedAt');
	$last3activities = $parseActivity1->getActivities();
	if ($last3activities != 0) {
	    if (get_class($last3activities) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last3activities->getErrorMessage() . '<br/>';
	    } else {
		foreach ($last3activities as $activity) {
		    if ($activity->event != null) {
			$event = $activity->event;
			echo '<br />[title] => ' . $event->getTitle() . '<br />';
			echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
			echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
			echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
			echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
			echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
		    } elseif ($activity->album != null) {
			$album = $activity->album;
			echo '<br />[thumbnailCover] => ' . $album->getThumbnailCover() . '<br />';
			echo '<br />[title] => ' . $album->getTitle() . '<br />';
			echo '<br />[loveCounter] => ' . $album->getLoveCounter() . '<br />';
			echo '<br />[commentCounter] => ' . $album->getCommentCounter() . '<br />';
			echo '<br />[shareCounter] => ' . $album->getShareCounter() . '<br />';
		    } elseif ($activity->record != null) {
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
	}
	$activityJammer_stop = microtime();
	echo '<br />----------------------JAMMER---------------------------<br />';
	break;
    default:
	break;
}
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero User proprietario pagina ' . executionTime($user_start, $user_stop) . '<br />';
echo 'Tempo include specifico ' . executionTime($include_start, $include_stop) . '<br />';
switch ($type) {
    case 'SPOTTER':
	echo '<br />----------------------SPOTTER---------------------------<br />';
	echo 'Tempo activity ' . executionTime($activitySpotter_start, $activitySpotter__stop) . '<br />';
	break;
    case 'VENUE':
	echo '<br />----------------------VENUE---------------------------<br />';
	echo 'Tempo activity ' . executionTime($activityVenue_start, $activityVenue_stop) . '<br />';
	break;
    case 'JAMMER':
	echo '<br />----------------------JAMMER---------------------------<br />';
	echo 'Tempo activity ' . executionTime($activityJammer_start, $activityJammer_stop) . '<br />';
	break;
    default:
	break;
}
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>



