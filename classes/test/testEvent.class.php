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
$cmt->setEventDate($eventDate);
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
//$event->setLovers(array $lovers);
$refused = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$event->setRefused($refused);
$event->setTags(array('tag1', 'tag2'));
$event->setThumbnail($thumbnail);
$event->setTitle($title);

// TODO - da eliminare
//$dateTime = new DateTime('now', new DateTimeZone('Europe/London'));
$dateTime = new DateTime();
$event->setTestDate($dateTime);
// TODO

$dateTime = new DateTime();
$event->setCreatedAt($dateTime);
$event->setUpdatedAt($dateTime);
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

$eventParse = new EventParse();
$resGet = $eventParse->getEvent('m1kKjWVOAf');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Event<br />';

$eventParse = new EventParse();
$resDelete = $eventParse->deleteEvent('Mk6MJs4jUh');
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
$event = new Event();
$event->setObjectId('m1kKjWVOAf');
$event->setCounter(9999999999999);
$resUpdate = $eventParse->saveEvent($event);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Event UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Event<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>