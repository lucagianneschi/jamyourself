<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
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
$dateTime = new DateTime();
$status->setCreatedAt($dateTime);
$status->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicWriteAccess(true);
$acl->setPublicReadAccess(true);
$status->setACL(toParseACL($acl));

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

echo '<br />INIZIO IL RECUPERO DI UN Status<br /><br />';

$statusParse1 = new StatusParse();
$resGet = $statusParse1->getStatus('Wa5P1x4qrc');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Status<br />';

$statusParse2 = new StatusParse();
$resDelete = $statusParse2->deleteComment('AOPyno3s8m');
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Comment<br />';

$statusParse3 = new StatusParse();
$statusParse3->whereExists('objectId');
$statusParse3->orderByDescending('createdAt');
$statusParse3->setLimit(5);
$resGets = $statusParse3->getStatuses();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $status) {
		echo '<br />' . $status->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Status<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Status<br />';

$statusParse4 = new StatusParse();
$status2 = new Comment();
$status2->setObjectId('AOPyno3s8m');
$status2->setCounter(9955);
$resUpdate = $statusParse4->saveStatus($status);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>