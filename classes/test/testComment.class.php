<?php
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

$cmt = new Comment();

$cmt->setObjectId('aAbBcCdD');
$cmt->setActive(true);
//$cmt->setAlbum(Album $album);
//$cmt->setComment(Comment $comment);
//$cmt->setCommentators(array $commentators);
//$cmt->setComments(array $comments);
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
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$cmt->setACL($acl);

echo 'STAMPO IL COMMENTO APPENA CREATO<br>';
echo $cmt;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';
$cmtParse = new CommentParse();
if (get_class($cmtParse->saveComment($cmt))) {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $cmtParse->saveComment($cmt)->getErrorMessage() . '<br/>';
}
echo 'FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>