<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');
ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'loader.service.php';

$album = new Album();
$album->setActive(true);
$album->setCommentCounter(10);
$album->setCommentators(array('n1TXVlIqHw', 'GuUAj83MGH'));
$album->setComments(array('nJr1ulgfVo', 'M8Abw83aVG'));
$album->setCounter(10);
$album->setCover('Una cover');
$album->setDescription('Una descrizione');
$album->setFeaturing(array('n1TXVlIqHw', 'GuUAj83MGH'));
$album->setFromUser('GuUAj83MGH');
$album->setCommentCounter(11);
$album->setImages(array('5yJMK9dyQh', '6WV6bqPNR9'));
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$album->setLocation($parseGeoPoint);
$album->setLoveCounter(100);
$album->setLovers(array('n1TXVlIqHw', 'GuUAj83MGH'));
$album->setShareCounter(10);
$album->setTags(array('tag1', 'tag2'));
$album->setThumbnailCover('Un link al thumbnail cover');
$album->setTitle('Un titolo');
echo '<br />STAMPO L\'Album APPENA CREATO<br />';
echo $album;
echo '<br />INIZIO IL SALVATAGGIO DELL\'Album APPENA CREATO<br />';
$albumParse1 = new AlbumParse();
$resSave = $albumParse1->saveAlbum($album);
if ($resSave instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
    echo '<br />Album SAVED<br />' . $resSave . '<br />';
}
echo '<br />INIZIO IL RECUPERO DI UN Album<br /><br />';
$albumParse2 = new AlbumParse();
$resGet = $albumParse2->getAlbum($resSave->getObjectId());
if ($resGet instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
    echo $resGet;
}
echo '<br />INIZIO LA CANCELLAZIONE DI UN Album<br />';
$albumParse3 = new AlbumParse();
$resDelete = $albumParse3->deleteAlbum($resSave->getObjectId());
if ($resDelete instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
    echo '<br />Album DELETED<br />';
}
echo '<br />INIZIO IL RECUPERO DI PIU\' Album<br />';
$albumParse4 = new AlbumParse();
$albumParse4->whereExists('objectId');
$albumParse4->orderByDescending('createdAt');
$albumParse4->setLimit(3);
$resGets = $albumParse4->getAlbums();
if ($resGets instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
    foreach ($resGets as $album) {
	echo '<br />' . $album->getObjectId() . '<br />';
    }
}
echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Album<br />';
$albumParse5 = new AlbumParse();
$album2 = $albumParse5->getAlbum($resSave->getObjectId());
$album2->setCounter(99);
$resUpdate = $albumParse5->saveAlbum($album2);
if ($resUpdate instanceof Error) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
    echo '<br />Album UPDATED<br />';
}
echo '<br />INIZIO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DELL\'ALBUM<br />';
$albumParse = new AlbumParse();
$albumParse->updateField($resSave->getObjectId(), 'active', true);
echo 'Aggiornato un campo boolean<br />';
$albumParse->updateField($resSave->getObjectId(), 'title', 'Un titolo modificato');
echo 'Aggiornato un campo string<br />';
$albumParse->updateField($resSave->getObjectId(), 'counter', 100000);
echo 'Aggiornato un campo number<br />';
$albumParse->updateField($resSave->getObjectId(), 'tags', array('op1', 'op2'));
echo 'Aggiornato un campo array<br />';
$albumParse->updateField($resSave->getObjectId(), 'fromUser', toParsePointer('_User', 'HDgcsTLpEx'));
echo 'Aggiornato un campo Pointer<br />';
$parseGeoPoint1 = new parseGeoPoint('56.78', '12.34');
$albumParse->updateField($resSave->getObjectId(), 'location', toParseGeoPoint($parseGeoPoint1));
echo 'Aggiornato un campo GeoPoint<br />';
$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$albumParse->updateField($resSave->getObjectId(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';
$albumParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';
$albumParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';
?>