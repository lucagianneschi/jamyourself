<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
ini_set('max_execution_time', 0);

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

$objectId = null;
$accepted = true;
$active = true;

$pAlbum = new AlbumParse();
$album = $pAlbum->getAlbum("iH2oruHDLk");

$pComment = new CommentParse();
$comment = $pComment->getComment("JEMROjxGB7");


$pEvent = new EventParse();
$event = $pEvent->getEvent("19OuVtOhfJ");

$pFromUser = new UserParse();
$fromUser = $pFromUser->getUser("sDqka2c1WB");

$pImage = new ImageParse();
$image = $pImage->getImage("Sahxw6cA54");

$pPlaylist = new PlaylistParse();
$playlist = $pPlaylist->getPlaylist("s1eWGF8rkU");

$pQuestion = new QuestionParse();
$question = $pQuestion->getQuestion("YvGtWTXV0O");

$read = false;

$pRecord = new RecordParse();
$record = $pRecord->getRecord("dHzayJzbKZ");

$pSong = new SongParse();
$song = $pSong->getSong("otkv0QlSOs");

$status = "Test su Activity";

$pUser = new UserParse();
$toUser = $pUser->getUser("1l9es3F5WO");

$type = "TEST_ACTIVITY_SAVE";

$pStatus = new StatusParse();
$userStatus = $pStatus->getStatus("1WZPRyq39Z");

$pVideo = new VideoParse();
$video = $pVideo->getVideo("ihcPvm6BIv");

$ACL = new parseACL();
$ACL->setPublicWriteAccess(true);

$activity = new Activity();

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

echo "Stampo Activity prima del salvataggio: <br/>";
echo $activity;

?>
