<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Comment
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
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

$cmt = new Comment();

$cmt->setActive(true);
//$cmt->setAlbum(Album $album);
//$cmt->setComment(Comment $comment);
$cmt->setCommentators(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$cmt->setComments(array ('nJr1ulgfVo', 'M8Abw83aVG'));
$cmt->setCounter(10);
//$cmt->setEvent(Event $event);
$cmt->setFromUser('GuUAj83MGH');
//$cmt->setImage(Image $image);
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$cmt->setLocation($parseGeoPoint);
$cmt->setLoveCounter(100);
$cmt->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
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
$cmt->setACL($parseACL);

/*
echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />TEST<br />';

$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(true);
echo '<br />STAMPO IL parseACL<br />';
var_dump($parseACL);

echo '<br />APPLICO IL toParseACL<br />';
$toParseACL = toParseACL($parseACL);
var_dump($toParseACL);

echo '<br />APPLICO IL fromParseACL<br />';
$fromParseACL = fromParseACL($toParseACL);
var_dump($fromParseACL);
/*
$parseGeoPoint = new parseGeoPoint(12.35, 12.34);echo '<br />STAMPO IL parseACL<br />';
var_dump($parseGeoPoint);

echo '<br />APPLICO IL toParseGeoPoint<br />';
$toParseGeoPoint = toParseGeoPoint($parseGeoPoint);
var_dump($toParseGeoPoint);

echo '<br />APPLICO IL fromParseGeoPoint<br />';
$fromParseGeoPoint = fromParseGeoPoint($toParseGeoPoint);
var_dump($fromParseGeoPoint);

echo '<br />TEST<br />';
*/
echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL Comment APPENA CREATO<br />';
echo $cmt;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL Comment APPENA CREATO<br />';

$cmtParse = new CommentParse();
$resSave = $cmtParse->saveComment($cmt);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL Comment APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Comment<br /><br />';

$cmtParse = new CommentParse();
$resGet = $cmtParse->getComment($resSave->getObjectId());
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
$resUpdate = $cmtParse->saveComment($cmt);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>