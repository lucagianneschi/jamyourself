<?php
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

$cmt = new Comment();

$cmt->setActive(true);
//$cmt->setAlbum(Album $album);
//$cmt->setComment(Comment $comment);

$commentators = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "_User", "objectId" => "n1TXVlIqHw"),
		array("__type" => "Pointer", "className" => "_User", "objectId" => "GuUAj83MGH")
	)
);
$cmt->setCommentators($commentators);

$comments = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "Comment", "objectId" => "2gMM3NmUYY"),
		array("__type" => "Pointer", "className" => "Comment", "objectId" => "5zw3I5d9Od")
	)
);
$cmt->setComments($comments);

$cmt->setCounter(10);
//$cmt->setEvent(Event $event);
//$cmt->setFromUser(User $fromUser);
//$cmt->setImage(Image $image);
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$cmt->setLocation($parseGeoPoint->location);
$cmt->setLoveCounter(100);
//$cmt->setLovers(array $lovers);
$cmt->setOpinions(array('opinions1', 'opinions2'));
//$cmt->setRecord(Record $record);
//$cmt->setSong(Song $song);
//$cmt->setStatus(Status $status);
$cmt->setTags(array('tag1', 'tag2'));
$cmt->setText('Il testo del commento');
//$cmt->setToUser(User $toUser);
$cmt->setType('Il tipo del commento');
//$cmt->setVideo(Video $video);
$cmt->setVote(1000);
$dateTime = new DateTime();
$cmt->setCreatedAt($dateTime);
$cmt->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicWriteAccess(true);
$cmt->setACL($acl);

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL COMMENTO APPENA CREATO<br />';
echo $cmt;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

$cmtParse = new CommentParse();
$resSave = $cmtParse->saveComment($cmt);
if (get_class($resSave)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED con objectId => ' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Comment<br /><br />';

$cmtParse = new CommentParse();
$resGet = $cmtParse->getComment('hAL9WyoQh0');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Comment<br />';

$cmtParse = new CommentParse();
$resDelete = $cmtParse->deleteComment('AOPyno3s8m');
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Comment<br />';

$cmtParse = new CommentParse();
$cmtParse->whereExists('objectId');
$cmtParse->orderByDescending('createdAt');
$cmtParse->setLimit(5);
$resGets = $cmtParse->getComments();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $cmt) {
		echo '<br />' . $cmt->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Comment<br />';

$cmtParse = new CommentParse();
$cmt = new Comment();
$cmt->setObjectId('AOPyno3s8m');
$cmt->setCounter(99);
$resUpdate = $cmtParse->saveComment($cmt);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>