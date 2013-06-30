<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';

$song = new Song();

$song->setActive(true);
$song->setCommentators(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$song->setComments(array ('2gMM3NmUYY', '5zw3I5d9Od'));
$song->setCounter(10);
$song->setDuration(120);
$song->setFeaturing(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$song->setFilePath('Un path del file');
$song->setFromUser('GuUAj83MGH');
$song->setGenre('Un genere');
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$song->setLocation($parseGeoPoint);
$song->setLoveCounter(100);
$song->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$song->setRecord('4zD865KrXo');
$song->setTitle('un titolo');
//$song->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO LA Song APPENA CREATA<br />';
echo $song;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELLA Song APPENA CREATA<br />';

$songParse = new SongParse();
$resSave = $songParse->saveSong($song);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELLA Song APPENA CREATA<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNA Song<br /><br />';

$songParse = new SongParse();
$resGet = $songParse->getSong($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNA Song<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UNA Song<br />';

$songParse = new SongParse();
$resDelete = $songParse->deleteSong($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Song DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UNA Song<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Song<br />';

$songParse = new SongParse();
$songParse->whereExists('objectId');
$songParse->orderByDescending('createdAt');
$songParse->setLimit(5);
$resGets = $songParse->getSongs();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $cmt) {
		echo '<br />' . $cmt->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Song<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UNA Song<br />';

$songParse = new SongParse();
$song = $songParse->getSong($resSave->getObjectId());
$song->setCounter(99);
$resUpdate = $songParse->saveSong($song);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Song UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UNA Song<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>