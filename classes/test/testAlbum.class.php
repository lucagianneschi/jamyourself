<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 *
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Album
 *
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
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';

$album = new Album();

$album->setActive(true);
$album->setCommentators(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$album->setComments(array ('nJr1ulgfVo', 'M8Abw83aVG'));
$album->setCounter(10);
$album->setCover('Una cover');
# TODO
# $album->setCoverFile();
$album->setDescription('Una descrizione');
$album->setFeaturing(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$album->setFromUser('GuUAj83MGH');
$album->setImages(array ('5yJMK9dyQh', '6WV6bqPNR9'));
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$album->setLocation($parseGeoPoint);
$album->setLoveCounter(100);
$album->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$album->setTags(array('tag1', 'tag2'));
$album->setThumbnailCover('Un link al thumbnail cover');
$album->setTitle('Un titolo');
//$album->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO L\'Album APPENA CREATO<br />';
echo $album;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELL\'Album APPENA CREATO<br />';

$albumParse = new AlbumParse();
$resSave = $albumParse->saveAlbum($album);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Album SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELL\'Album APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Album<br /><br />';

$albumParse = new AlbumParse();
$resGet = $albumParse->getAlbum($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Album<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Album<br />';

$albumParse = new AlbumParse();
$resDelete = $albumParse->deleteAlbum($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Album DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Album<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Album<br />';

$albumParse = new AlbumParse();
$albumParse->whereExists('objectId');
$albumParse->orderByDescending('createdAt');
$albumParse->setLimit(5);
$resGets = $albumParse->getAlbums();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $album) {
		echo '<br />' . $album->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Album<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Album<br />';

$albumParse = new AlbumParse();
$album = $albumParse->getAlbum($resSave->getObjectId());
$album->setCounter(99);
$resUpdate = $albumParse->saveAlbum($album);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Album UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Album<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>