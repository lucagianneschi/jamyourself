<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

$jamObj = new Activity();

$accepted = null;
$active = null;  
$album = null;   
$comment = null; 
$event = null;   
$fromUser = null;
$image = null;   
$playlist = null; 
$question = null;
$read = null;   
$record = null;  
$song = null;    
$status = null;  
$toUser = null;  
$type = null;  
$userStatus = null;
$video = null;     
$ACL;   
//inizializzazione coi setters

$accepted = true;
$active = true;

$album = (new AlbumParse)->parseToAlbum((new parseObject("Album"))->get("K3wVfjk1p5"));
        
$comment = (new CommentParse)->parseToAlbum((new parseObject("temp"))->get("VvX5nyboaH"));
$event = (new EventParse)->parseToAlbum((new parseObject("temp"))->get("19OuVtOhfJ"));
$fromUser = (new UserParse)->parseToAlbum((new parseObject("temp"))->get("dcIDVIh6FY"));
$image = (new ImageParse)->parseToAlbum((new parseObject("temp"))->get("OrBTtExxMp"));
$playlist = (new PlaylistParse)->parseToAlbum((new parseObject("temp"))->get("cJZLb3BfMW"));
$question = (new QuestionParse)->parseToAlbum((new parseObject("temp"))->get("YvGtWTXV0O"));
$read = false;
$record = (new RecordParse)->parseToAlbum((new parseObject("temp"))->get("QmhKrALo5P"));
$song = (new SongParse)->parseToAlbum((new parseObject("temp"))->get("68eX5oxAOe"));
$status = "Test status";
$toUser = (new AlbumParse)->parseToAlbum((new parseObject("temp"))->get("oCXTbUvMpw"));
$type = "TEST_ACTIVITY";
$userStatus = (new UserParse)->parseToAlbum((new parseObject("temp"))->get("6dvbdcScnm"));
$video = (new VideoParse)->parseToAlbum((new parseObject("temp"))->get("MQbqTvCo7O"));

$jamObj->setAccepted($accepted);
$jamObj->setActive($active);
$jamObj->setAlbum($album);
$jamObj->setComment($comment);
$jamObj->setEvent($event);
$jamObj->setFromUser($fromUser);
$jamObj->setImage($image);
$jamObj->setPlaylist($playlist);
$jamObj->setQuestion($question);
$jamObj->setRead($read);
$jamObj->setRecord($record);
$jamObj->setSong($song);
$jamObj->setStatus($status);
$jamObj->setToUser($toUser);
$jamObj->setType($type);
$jamObj->setUserStatus($userStatus);
$jamObj->setVideo($video);

$dateTime = new DateTime();
$jamObj->setCreatedAt($dateTime);
$jamObj->setUpdatedAt($dateTime);

$acl = new parseACL();
$acl->setPublicWriteAccess(true);
$jamObj->setACL($acl);

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL COMMENTO APPENA CREATO<br />';
echo $jamObj;

//echo '<br />-------------------------------------------------------------------------------<br />';
//
//echo '<br />INIZIO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';
//
//$jamParse = new ActivityParse();
//$resSave = $jamParse->saveActivity($jamObj);
//if (get_class($resSave) == 'Error') {
//    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
//} else {
//    echo '<br />Comment SAVED<br />' . $resSave . '<br />';
//}
//
//echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';
//
//echo '<br />-------------------------------------------------------------------------------<br />';
//
//echo '<br />INIZIO IL RECUPERO DI UN Comment<br /><br />';
//
//$jamParse = new ActivityParse();
//$resGet = $jamParse->getActivity('6XuFv1BRX2');
//if (get_class($resGet) == 'Error') {
//    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
//} else {
//    echo $resGet;
//}
//
//echo '<br />FINITO IL RECUPERO DI UN Comment<br />';
//
//echo '<br />-------------------------------------------------------------------------------<br />';
//
//echo '<br />INIZIO LA CANCELLAZIONE DI UN Comment<br />';
//
//$jamParse = new ActivityParse();
//$resDelete = $jamParse->deleteActivity('AOPyno3s8m');
//if (get_class($resDelete)) {
//    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
//} else {
//    echo '<br />Comment DELETED<br />';
//}
//
//echo '<br />FINITO LA CANCELLAZIONE DI UN Comment<br />';
//
//echo '<br />-------------------------------------------------------------------------------<br />';
//
//echo '<br />INIZIO IL RECUPERO DI PIU\' Comment<br />';
//
//$cmtParse = new CommentParse();
//$cmtParse->whereExists('objectId');
//$cmtParse->orderByDescending('createdAt');
//$cmtParse->setLimit(5);
//$resGets = $cmtParse->getComments();
//if (get_class($resGets) == 'Error') {
//    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
//} else {
//    foreach ($resGets as $cmt) {
//        echo '<br />' . $cmt->getObjectId() . '<br />';
//    }
//}
//
//echo '<br />FINITO IL RECUPERO DI PIU\' Comment<br />';
//
//echo '<br />-------------------------------------------------------------------------------<br />';
//
//echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Comment<br />';
//
//$cmtParse = new CommentParse();
//$cmt = new Comment();
//$cmt->setObjectId('AOPyno3s8m');
//$cmt->setCounter(99);
//$resUpdate = $cmtParse->saveComment($cmt);
//if (get_class($resUpdate)) {
//    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
//} else {
//    echo '<br />Comment UPDATED<br />';
//}
//
//echo '<br />FINITO L\'AGGIORNAMENTO DI UN Comment<br />';
//
//echo '<br />-------------------------------------------------------------------------------<br />';
?>
