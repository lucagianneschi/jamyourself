<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';

$record = new Record();

$record->setActive(true);
$record->setBuyLink('Un buy link');
$record->setCommentCounter(10);
$record->setCommentators(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$record->setComments(array ('2gMM3NmUYY', '5zw3I5d9Od'));
$record->setCounter(10);
$record->setCover('Una cover');
//$record->setCoverFile();
$record->setDescription('Una descrizione');
$record->setDuration(120);
$record->setFeaturing(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$record->setFromUser('GuUAj83MGH');
$record->setGenre('Un genere');
$record->setLabel('Un label');
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$record->setLocation($parseGeoPoint);
$record->setLocationName('Puppa');
$record->setLoveCounter(100);
$record->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$record->setShareCounter(666);
$record->setThumbnailCover('Un thumbnail cover');
$record->setTitle('Un titolo');
$record->setTracklist(array('nBF3KVDGxZ', 'MSJfcWb9Qk'));
$record->setYear('2013');
//$record->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO IL Record APPENA CREATA<br />';
echo $record;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL Record APPENA CREATA<br />';

$recordParse = new RecordParse();
$resSave = $recordParse->saveRecord($record);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL Record APPENA CREATA<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Record<br /><br />';

$recordParse = new RecordParse();
$resGet = $recordParse->getRecord($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Record<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Record<br />';

$recordParse = new RecordParse();
$resDelete = $recordParse->deleteRecord($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Record DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Record<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Record<br />';

$recordParse = new RecordParse();
$recordParse->whereExists('objectId');
$recordParse->orderByDescending('createdAt');
$recordParse->setLimit(5);
$resGets = $recordParse->getRecords();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $record) {
		echo '<br />' . $record->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Record<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Record<br />';

$recordParse = new RecordParse();
$record = $recordParse->getRecord($resSave->getObjectId());
$record->setCounter(99);
$resUpdate = $recordParse->saveRecord($record);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Record UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Record<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />INIZIO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DEL RECORD<br />';

$recordParse = new RecordParse();

$recordParse->updateField($resSave->getObjectId(), 'active', true);
echo 'Aggiornato un campo boolean<br />';
$recordParse->updateField($resSave->getObjectId(), 'title', 'Un titolo modificato');
echo 'Aggiornato un campo string<br />';
$recordParse->updateField($resSave->getObjectId(), 'counter', 100000000);
echo 'Aggiornato un campo number<br />';


$parseGeoPoint = new parseGeoPoint('56.78', '12.34');
$recordParse->updateField($resSave->getObjectId(), 'location', toParseGeoPoint($parseGeoPoint));
echo 'Aggiornato un campo GeoPoint<br />';

$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$recordParse->updateField($resSave->getObjectId(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';

$recordParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';

$recordParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';

echo '<br />FINITO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DEL RECORD<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>