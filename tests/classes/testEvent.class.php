<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 *
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Event
 *
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
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';

$event = new Event();

$event->setActive(true);
$event->setAttendee(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$event->setActive(true);
$event->setAddress('Via delle Fia,18');
$event->setCity('Pupporina');
$event->setCommentCounter(1000);
$event->setCounter(10);
$event->setDescription('Una descrizione');
$eventDate = new DateTime();
$event->setEventDate($eventDate);
$event->setFeaturing(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$event->setFromUser('GuUAj83MGH');
$event->setImage('Un link ad Image');
//$event->setImageFile(Image $imageFile);
$event->setInvited(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$event->setLocation($parseGeoPoint);
$event->setLocationName('Una localita');
$event->setLoveCounter(100);
$event->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$event->setReviewCounter(10000987492387928374928734);
$event->setShareCounter(1000);
$event->setRefused(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$event->setTags(array('tag1', 'tag2'));
$event->setThumbnail('Un link thumbnail');
$event->setTitle('Un titolo');
//$event->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO L\'Event APPENA CREATO<br />';
echo $event;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELL\'Event APPENA CREATO<br />';

$eventParse = new EventParse();
$resSave = $eventParse->saveEvent($event);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELL\'Event APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Event<br /><br />';

$eventParse = new EventParse();
$resGet = $eventParse->getEvent($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Event<br />';

$eventParse = new EventParse();
$resDelete = $eventParse->deleteEvent($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Event<br />';

$eventParse = new EventParse();
$eventParse->whereExists('objectId');
$eventParse->orderByDescending('createdAt');
$eventParse->setLimit(5);
$resGets = $eventParse->getEvents();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $event) {
		echo '<br />' . $event->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Event<br />';

$eventParse = new EventParse();
$event = $eventParse->getEvent($resSave->getObjectId());
$event->setCounter(9999999999999);
$resUpdate = $eventParse->saveEvent($event);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />INIZIO L\'AGGIORNAMENTO DEI SINGOLI CAMPI EVENT<br />';

$eventParse = new EventParse();

$eventParse->updateField($resSave->getObjectId(), 'active', true);
echo 'Aggiornato un campo boolean<br />';
$eventParse->updateField($resSave->getObjectId(), 'description', 'Un descrizione modificata');
echo 'Aggiornato un campo string<br />';
$eventParse->updateField($resSave->getObjectId(), 'counter', 666);
echo 'Aggiornato un campo number<br />';
$eventParse->updateField($resSave->getObjectId(), 'tags', array('tag1', 'tag2'));
echo 'Aggiornato un campo array<br />';

$eventParse->updateField($resSave->getObjectId(), 'fromUser', toParsePointer('_User', 'HDgcsTLpEx'));
echo 'Aggiornato un campo Pointer<br />';

$parseGeoPoint = new parseGeoPoint('56.78', '12.34');
$eventParse->updateField($resSave->getObjectId(), 'location', toParseGeoPoint($parseGeoPoint));
echo 'Aggiornato un campo GeoPoint<br />';

$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$eventParse->updateField($resSave->getObjectId(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';

$eventParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';

$eventParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';

echo '<br />FINITO L\'AGGIORNAMENTO DEI SINGOLI CAMPI  EVENT<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>