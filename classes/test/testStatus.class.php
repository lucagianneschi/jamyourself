<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'status.class.php';

require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'event.class.php';
# require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';

$status = new Status();

$status->setActive(true);
$status->setCommentators(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$status->setComments(array ('2gMM3NmUYY', '5zw3I5d9Od'));
$status->setCounter(10);
$status->setEvent('FOhLk9wFoD');
$status->setFromUser('GuUAj83MGH');
$status->setImage('5yJMK9dyQh');
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$status->setLocation($parseGeoPoint);
$status->setLoveCounter(100);
$status->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$status->setSong('SdJx4roDEs');
$status->setTaggedUsers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$status->setText('Il testo dello status');
//$status->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL status APPENA CREATO<br />';
echo $status;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL status APPENA CREATO<br />';

$statusParse = new StatusParse();
$resSave = $statusParse->saveStatus($status);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL status APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNO Status<br /><br />';

$statusParse = new StatusParse();
$resGet = $statusParse->getStatus($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNO Status<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UNO Status<br />';

$statusParse = new StatusParse();
$resDelete = $statusParse->deleteStatus($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UNO Status<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Status<br />';

$statusParse = new StatusParse();
$statusParse->whereExists('objectId');
$statusParse->orderByDescending('createdAt');
$statusParse->setLimit(5);
$resGets = $statusParse->getStatuses();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $status) {
		echo '<br />' . $status->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Status<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UNO Status<br />';

$statusParse = new StatusParse();
$status = $statusParse->getStatus($resSave->getObjectId());
$status->setCounter(9955);
$resUpdate = $statusParse->saveStatus($status);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Status UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UNO Status<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>