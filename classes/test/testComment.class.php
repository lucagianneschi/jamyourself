<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

$cmt = new Comment();

$cmt->setActive(true);
//$cmt->setAlbum(Album $album);
//$cmt->setComment(Comment $comment);
$cmt->setCommentators(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$cmt->setComments(array ('2gMM3NmUYY', '5zw3I5d9Od'));
$cmt->setCounter(10);
//$cmt->setEvent(Event $event);
//$cmt->setFromUser(User $fromUser);
//$cmt->setImage(Image $image);
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$cmt->setLocation($parseGeoPoint->location);
$cmt->setLoveCounter(100);
//commentato per testare i NULL
//$cmt->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$cmt->setOpinions(array('opinions1', 'opinions2'));
//$cmt->setRecord(Record $record);
//$cmt->setSong(Song $song);
//$cmt->setStatus(Status $status);
$cmt->setTags(array('tag1', 'tag2'));
$cmt->setText('Il testo del commento');
$cmt->setToUser('GuUAj83MGH');
$cmt->setType('Il tipo del commento');
//$cmt->setVideo(Video $video);
$cmt->setVote(1000);
$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(true);
$cmt->setACL(toParseACL($parseACL));

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL COMMENTO APPENA CREATO<br />';
echo $cmt;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

$cmtParse = new CommentParse();
$resSave = $cmtParse->saveComment($cmt);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Comment<br /><br />';

$cmtParse = new CommentParse();
$resGet = $cmtParse->getComment('R6Ikldjy0x');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Comment<br />';

$cmtParse = new CommentParse();
$resDelete = $cmtParse->deleteComment($resSave->getObjectId());
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
$cmt = $cmtParse->getComment($resSave->getObjectId());
$cmt->setCounter(99);
print_r($cmt);
$resUpdate = $cmtParse->saveComment($cmt);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>