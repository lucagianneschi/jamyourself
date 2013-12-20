<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Image
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';

$image = new Image();

$image->setActive(true);
$image->setAlbum('lK0bNWIi7k');
$image->setCommentCounter(10);
$image->setCounter(10);
$image->setDescription('Una descrizione');
$image->setFeaturing(array('n1TXVlIqHw', 'GuUAj83MGH'));
$image->setFilePath('Un path del file');
$image->setFromUser('GuUAj83MGH');
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$image->setLocation($parseGeoPoint);
$image->setLoveCounter(100);
$image->setLovers(array('n1TXVlIqHw', 'GuUAj83MGH'));
$image->setTags(array('tag1', 'tag2'));
$image->setThumbnail('path for thumbnail');
$image->setShareCounter(100000);
//$image->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO L\'Image APPENA CREATA<br />';
echo $image;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELL\'Image APPENA CREATO<br />';

$imageParse = new ImageParse();
$resSave = $imageParse->saveImage($image);
if (get_class($resSave) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
    echo '<br />Image SAVED<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELL\'Image COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNA Image<br /><br />';

$imageParse = new ImageParse();
$resGet = $imageParse->getImage($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
    echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNA Image<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UNA Image<br />';

$iamgeParse = new ImageParse();
$resDelete = $imageParse->deleteImage($resSave->getObjectId());
if (get_class($resDelete)) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
    echo '<br />Image DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UNA Image<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Image<br />';

$imageParse = new ImageParse();
$imageParse->whereExists('objectId');
$imageParse->orderByDescending('createdAt');
$imageParse->setLimit(5);
$resGets = $imageParse->getImages();
if (get_class($resGets) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
    foreach ($resGets as $image) {
	echo '<br />' . $image->getObjectId() . '<br />';
    }
}

echo '<br />FINITO IL RECUPERO DI PIU\' Image<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UNA Image<br />';

$imageParse = new ImageParse();
$image = $imageParse->getImage($resSave->getObjectId());
$image->setCounter(99);
$resUpdate = $imageParse->saveImage($image);
if (get_class($resUpdate)) {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
    echo '<br />Image UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UNA Image<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />INIZIO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DELL\'IMAGE<br />';

$imageParse = new ImageParse();

$imageParse->updateField($resSave->getObjectId(), 'active', true);
echo 'Aggiornato un campo boolean<br />';
$imageParse->updateField($resSave->getObjectId(), 'description', 'Una descrizione modificata');
echo 'Aggiornato un campo string<br />';
$imageParse->updateField($resSave->getObjectId(), 'counter', 666);
echo 'Aggiornato un campo number<br />';
$imageParse->updateField($resSave->getObjectId(), 'tags', array('op1', 'op2'));
echo 'Aggiornato un campo array<br />';

$imageParse->updateField($resSave->getObjectId(), 'album', toParsePointer('Album', 'eY7nxiEJNy'));
echo 'Aggiornato un campo Pointer<br />';

$parseGeoPoint = new parseGeoPoint('56.78', '12.34');
$imageParse->updateField($resSave->getObjectId(), 'location', toParseGeoPoint($parseGeoPoint));
echo 'Aggiornato un campo GeoPoint<br />';

$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$imageParse->updateField($resSave->getObjectId(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';

echo '<br />FINITO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DELL\'IMAGE<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>