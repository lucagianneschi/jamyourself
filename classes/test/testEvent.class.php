<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

$event = new Event();

$event->setActive(true);
$attendee = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$event->setAttendee($attendee);
$commentators = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$event->setCommentators($commentators);

$comments = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "Event", "objectId" => "2gMM3NmUYY"),
		array("__type" => "Pointer", "className" => "Event", "objectId" => "5zw3I5d9Od")
	)
);
$event->setComments($comments);
$event->setCounter(10);
$event->setDescription('Questo è un Evento Bellissimo');
$eventDate = new DateTime();
$event->setEventDate($eventDate);
$featuring = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$event->setFeatuting($featuring);
//$event->setFromUser(User $fromUser);
//$event->setImage(Image $image);
//$event->setImageFile(Image $imageFile);
$invited = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$event->setInvited($invited);
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$event->setLocation($parseGeoPoint->location);
$event->setLoveCounter(100);
$lovers =  array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$event->setLovers($lovers);
$refused = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$event->setRefused($refused);
$event->setTags(array('tag1', 'tag2'));
$event->setThumbnail('thumbnail');
$event->setTitle('title');

// TODO - da eliminare
//$dateTime = new DateTime('now', new DateTimeZone('Europe/London'));
$dateTime = new DateTime();
$dateTime->add(new DateInterval('P1D'));
$event->setTestDate($dateTime);
// TODO

$dateTime1 = new DateTime();
$event->setCreatedAt($dateTime1);
$event->setUpdatedAt($dateTime1);
$acl = new parseACL();
$acl->setPublicWriteAccess(true);
$event->setACL($acl);

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL EVENT APPENA CREATO<br />';
echo $event;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL EVENT APPENA CREATO<br />';

$eventParse = new EventParse();
$resSave = $eventParse->saveEvent($event);
if (get_class($resSave)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event SAVED con objectId => ' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Event<br /><br />';

$eventParse1 = new EventParse();
$resGet = $eventParse1->getEvent('m1kKjWVOAf');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Event<br />';

$eventParse2 = new EventParse();
$resDelete = $eventParse2->deleteEvent('Mk6MJs4jUh');
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Event<br />';

$eventParse3 = new EventParse();
$eventParse3->whereExists('objectId');
$eventParse3->orderByDescending('createdAt');
$eventParse3->setLimit(5);
$resGets = $eventParse3->getEvents();
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

$eventParse4 = new EventParse();
$event1 = new Event();
$event1->setObjectId('m1kKjWVOAf');
$event1->setCounter(9999999999999);
$resUpdate = $eventParse4->saveEvent($event1);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>