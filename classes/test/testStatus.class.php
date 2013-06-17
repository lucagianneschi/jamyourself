<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
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

//$status->setComment(Comment $comment);

$commentators = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$status->setCommentators($commentators);
$comments = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "Comment", "objectId" => "2gMM3NmUYY"),
		array("__type" => "Pointer", "className" => "Comment", "objectId" => "5zw3I5d9Od")
	)
);
$status->setComments($comments);
$status->setCounter(10);
//$status->setEvent(Event $event);
//$status->setFromUser(User $fromUser);
//$status->setImage(Image $image);
//$status->setImageFile($imageFile);
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$status->setLocation($parseGeoPoint->location);
$status->setLoveCounter(100);
$lovers = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$status->setLovers($lovers);
//$status->setSong(Song $song);
$taggedUsers = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$status->setTaggedUsers($taggedUsers);

$status->setText('Il testo dello status');

$dateTime = new DateTime();
$status->setCreatedAt($dateTime);
$status->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicWriteAccess(true);
$acl->setPublicReadAccess(true);
$status->setACL($acl);

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL status APPENA CREATO<br />';
echo $status;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL status APPENA CREATO<br />';

$statusParse = new StatusParse();
$resSave = $statusParse->saveComment($status);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL status APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Comment<br /><br />';

$statusParse = new StatusParse();
$resGet = $statusParse->getStatus('Wa5P1x4qrc');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Status<br />';

$statusParse1 = new StatusParse();
$resDelete = $statusParse1->deleteComment('AOPyno3s8m');
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Comment<br />';

$statusParse2 = new StatusParse();
$statusParse2->whereExists('objectId');
$statusParse2->orderByDescending('createdAt');
$statusParse2->setLimit(5);
$resGets = $statusParse2->getStatuses();
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

$statusParse3 = new StatusParse();
$status1 = new Comment();
$status1->setObjectId('AOPyno3s8m');
$status1->setCounter(9955);
$resUpdate = $statusParse->saveStatus($status);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>