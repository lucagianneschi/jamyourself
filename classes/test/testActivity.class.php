<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
ini_set('max_execution_time', 0);

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

$ACL = new parseACL();
$ACL->setPublicWriteAccess(true);

$activity = new Activity();

$activity->setAccepted(null);
$activity->setActive(null);        
$activity->setAlbum(null);
$activity->setComment(null);
$activity->setEvent(null);
$activity->setFromUser(null);
$activity->setImage(null);
$activity->setPlaylist(null);
$activity->setQuestion(null);
$activity->setRead(null);
$activity->setRecord(null);
$activity->setSong(null);
$activity->setStatus(null);
$activity->setToUser(null);
$activity->setType(null);
$activity->setUserStatus(null);
$activity->setVideo(null);
$activity->setACL($ACL);
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> Stampo Activity prima del salvataggio con valori NULL:  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> Stampo Activity restituita dal salvataggio con valori NULL:  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pActivity = new ActivityParse();

$activity = $pActivity->saveActivity($activity);

echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/>Recupero l'oggetto salvato su Parse: objectId: ". $activity->getObjectId() ."  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pActivity = new ActivityParse();
$activity = $pActivity->getActivity($activity->getObjectId());

echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />Inizializzo i valori <br />';
echo '<br />-------------------------------------------------------------------------------<br />';
$accepted = true;
$active = true;
$album = "iH2oruHDLk";
$comment = "JEMROjxGB7";
$event = "19OuVtOhfJ";
$fromUser = "sDqka2c1WB";
$image = "Sahxw6cA54";
$playlist = "s1eWGF8rkU";
$question = "YvGtWTXV0O";
$read = false;
$record = "dHzayJzbKZ";
$song = "otkv0QlSOs";
$status = "Test su Activity";
$toUser = "1l9es3F5WO";
$type = "TEST_ACTIVITY_SAVE";
$userStatus = "1WZPRyq39Z";
$video = "ihcPvm6BIv";
$activity->setAccepted($accepted);
$activity->setActive($active);        
$activity->setAlbum($album);
$activity->setComment($comment);
$activity->setEvent($event);
$activity->setFromUser($fromUser);
$activity->setImage($image);
$activity->setPlaylist($playlist);
$activity->setQuestion($question);
$activity->setRead($read);
$activity->setRecord($record);
$activity->setSong($song);
$activity->setStatus($status);
$activity->setToUser($toUser);
$activity->setType($type);
$activity->setUserStatus($userStatus);
$activity->setVideo($video);
$activity->setACL($ACL);
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> Stampo Activity prima del salvataggio:  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> Stampo Activity restituita dal salvataggio:  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pActivity = new ActivityParse();

$activity = $pActivity->getActivity($activity->getObjectId());

echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/>Recupero l'oggetto salvato su Parse: objectId: ". $activity->getObjectId() ."  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pActivity = new ActivityParse();
$activity = $pActivity->getActivity($activity->getObjectId());

echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> UPDATE dell'oggetto salvato su Parse: objectId: ". $activity->getObjectId() ."<br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pActivity = new ActivityParse();
$activity = $pActivity->getActivity($activity->getObjectId());
$activity->setType("TEST_ACTIVITY_UPDATED");
$pActivity->saveActivity($activity);
$activity = $pActivity->getActivity($activity->getObjectId());

echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> DELETE dell'oggetto salvato su Parse: objectId: ". $activity->getObjectId() ."<br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$ret = $pActivity->deleteActivity($activity->getObjectId());

echo "Fine delete";
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> DELETE Provo a recuperare l'oggetto cancellato (deve avere active = FALSE): ". $activity->getObjectId() ."<br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pActivity = new ActivityParse();
$activity = $pActivity->getActivity($activity->getObjectId());
echo $activity;
echo '<br />-------------------------------------------------------------------------------<br />';
?>
