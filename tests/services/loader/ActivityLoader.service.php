<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');
ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'loader.service.php';

echo '<br />---------------------TEST ACTIVITY----------------------------<br />';
$activity = new Activity();
$activity->setActive(true);
$activity->setAlbum('lK0bNWIi7k');
$activity->setComment('nJr1ulgfVo');
$activity->setCounter(66666);
$activity->setEvent('TnYLd1XF8O');
$activity->setFromUser('GuUAj83MGH');
$activity->setImage('5yJMK9dyQh');
$activity->setPlaylist('EWlkBSXQJt');
$activity->setQuestion('W86XzbYWqF');
$activity->setRead(true);
$activity->setSong('nBF3KVDGxZ');
$activity->setStatus('Uno stato');
$activity->setToUser('GuUAj83MGH');
$activity->setType('Un tipo');
$activity->setUserStatus('uqhjnzu3sJ');
$activity->setVideo('MQbqTvCo7O');
echo '<br />STAMPO L\'Activity APPENA CREATO<br />';
echo $activity;
echo '<br />---------------------TEST ACTIVITYPARSE---SAVE-------------------------<br />';
$activityParse = new ActivityParse();
$resSave = $activityParse->saveActivity($activity);
if ($resSave instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
    echo '<br />Activity SAVED<br />' . $resSave . '<br />';
}
echo '<br />---------------------TEST ACTIVITYPARSE---GET-------------------------<br />';
$resGet = $activityParse->getActivity($resSave->getObjectId());
if ($resGet instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
    echo $resGet;
}
echo '<br />---------------------TEST ACTIVITYPARSE---DELETE-------------------------<br />';
$resDelete = $activityParse->deleteActivity($resSave->getObjectId());
if ($resDelete instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
    echo '<br />Activity DELETED<br />';
}
echo '<br />---------------------TEST ACTIVITYPARSE---GETS-------------------------<br />';
$activityParse1 = new ActivityParse();
$activityParse1->whereExists('objectId');
$activityParse1->orderByDescending('createdAt');
$activityParse1->setLimit(5);
$resGets = $activityParse1->getActivities();
if ($resGets instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
    foreach ($resGets as $album) {
	echo '<br />' . $album->getObjectId() . '<br />';
    }
}
echo '<br />---------------------TEST ACTIVITYPARSE---UPDATEFIELD-------------------------<br />';
$activityParse2 = new ActivityParse();
$activityParse2->updateField($resSave->getObjectId(), 'active', true);
echo 'Aggiornato un campo boolean<br />';
$activityParse2->updateField($resSave->getObjectId(), 'counter', 10000);
echo 'Aggiornato un campo number<br />';
$activityParse2->updateField($resSave->getObjectId(), 'image', toParsePointer('Image', 'MuTAFCZIKd'));
echo 'Aggiornato un campo Pointer<br />';
$activityParse2->updateField($resSave->getObjectId(), 'status', 'STATUS AGGIORNATO');
echo 'Aggiornato un campo string<br />';
$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$activityParse2->updateField($resSave->getObjectId(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';
?>