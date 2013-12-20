<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');
ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'loader.service.php';
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
echo '<br />STAMPO L\'Event APPENA CREATO<br />';
echo $event;
echo '<br />INIZIO IL SALVATAGGIO DELL\'Event APPENA CREATO<br />';
$eventParse1 = new EventParse();
$resSave = $eventParse1->saveEvent($event);
if ($resSave instanceof Error) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event SAVED<br />' . $resSave . '<br />';
}
echo '<br />INIZIO IL RECUPERO DI UN Event<br /><br />';
$eventParse2 = new EventParse();
$resGet = $eventParse2->getEvent($resSave->getObjectId());
if ($resGet instanceof Error) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}
echo '<br />INIZIO LA CANCELLAZIONE DI UN Event<br />';
$eventParse3 = new EventParse();
$resDelete = $eventParse3->deleteEvent($resSave->getObjectId());
if ($resDelete instanceof Error) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event DELETED<br />';
}
echo '<br />INIZIO IL RECUPERO DI PIU\' Event<br />';
$eventParse4 = new EventParse();
$eventParse4->whereExists('objectId');
$eventParse4->orderByDescending('createdAt');
$eventParse4->setLimit(3);
$resGets = $eventParse4->getEvents();
if ($resGets instanceof Error) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $event) {
		echo '<br />' . $event->getObjectId() . '<br />';
	}
}
echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Event<br />';
$eventParse5 = new EventParse();
$event1 = $eventParse5->getEvent($resSave->getObjectId());
$event1->setCounter(9999999999999);
$resUpdate = $eventParse5->saveEvent($event);
if ($resUpdate instanceof Error) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event UPDATED<br />';
}
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
$parseGeoPoint1 = new parseGeoPoint('56.78', '12.34');
$eventParse->updateField($resSave->getObjectId(), 'location', toParseGeoPoint($parseGeoPoint1));
echo 'Aggiornato un campo GeoPoint<br />';
$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$eventParse->updateField($resSave->getObjectId(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';
$eventParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';
$eventParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';
?>