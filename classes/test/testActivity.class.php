<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Activity
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

$activity = new Activity();

$activity->setAccepted(true);
$activity->setActive(true);
$activity->setAlbum('lK0bNWIi7k');
$activity->setComment('nJr1ulgfVo');
$activity->setEvent('TnYLd1XF8O');
$activity->setFromUser('GuUAj83MGH');
$activity->setImage('5yJMK9dyQh');
$activity->setPlaylist('EWlkBSXQJt');
$activity->setQuestion('W86XzbYWqF');
$activity->setRead(true);
$activity->setSong('nBF3KVDGxZ');
$activity->setStatus('Uno stato');
$activity->setToUser('GuUAj83MGH');
$activity->setType('Un tipo');
$activity->setUserStatus('uqhjnzu3sJ');
$activity->setVideo('MQbqTvCo7O');
//$activity->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO L\'Activity APPENA CREATO<br />';
echo $activity;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELL\'Activity APPENA CREATO<br />';

$activityParse = new ActivityParse();
$resSave = $activityParse->saveActivity($activity);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Activity SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELL\'Activity APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Activity<br /><br />';

$activityParse = new ActivityParse();
$resGet = $activityParse->getActivity($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Activity<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Activity<br />';

$activityParse = new ActivityParse();
$resDelete = $activityParse->deleteActivity($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Activity DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Activity<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Activity<br />';

$activityParse = new ActivityParse();
$activityParse->whereExists('objectId');
$activityParse->orderByDescending('createdAt');
$activityParse->setLimit(5);
$resGets = $activityParse->getActivities();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $album) {
		echo '<br />' . $album->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Activity<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Activity<br />';

$activityParse = new ActivityParse();
$activity = $activityParse->getActivity($resSave->getObjectId());
$activity->setStatus('Uno stato modificato');
$resUpdate = $activityParse->saveActivity($activity);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Activity UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Activity<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>