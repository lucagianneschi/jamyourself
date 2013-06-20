<?php
/* ! \par Info Generali:
* \author Luca Gianneschi
* \version 1.0
* \date 2013
* \copyright Jamyourself.com 2013
*
* \par Info Classe:
* \brief Classe di test
* \details Classe di test per la classe Video
*
* \par Commenti:
* \warning
* \bug
* \todo modificare require_once
*
*/
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'utils.class.php';

$video = new Video();
$video->setObjectId('aAbBcCdD');
$video->setActive(true);
$video->setAuthor('Autore del video');
$video->setCommentators(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$video->setComments(array ('2gMM3NmUYY', '5zw3I5d9Od'));
$video->setCounter(100);
$video->setDescription('Descrizione del video');
$video->setDuration(120);
$video->setFromUser('GuUAj83MGH');
$video->setLoveCounter(100);
$video->setLovers(array ('n1TXVlIqHw', 'GuUAj83MGH'));
$video->setTags(array('tag1', 'tag2'));
$video->setThumbnail('indirizzo del thumbnail');
$video->setTitle('titolo del video');
$dateTime = new DateTime();
$video->setCreatedAt($dateTime);
$video->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$video->setACL(toParseACL($acl));
echo 'STAMPO IL VIDEO APPENA CREATO  <br>';
echo $video;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DEL VIDEO APPENA CREATO<br />';
$videoParse = new VideoParse();
if (get_class($videoParse->saveVideo($video))) {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $videoParse->saveVideo($video)->getErrorMessage() . '<br/>';
}
echo 'FINITO IL SALVATAGGIO DEL VIDEO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

$videoParse1 = new VideoParse();
$resSave = $videoParse1->saveVideo($video);
if (get_class($resSave)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED con objectId => ' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Comment<br /><br />';

$videoParse2 = new VideoParse();
$resGet = $videoParse2->getVideo('ihcPvm6BIv');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN VIDEO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Video<br />';

$videoParse3 = new VideoParse();
$resDelete = $videoParse3->deleteVideo('ihcPvm6BIv');
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Video DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Video<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Video<br />';

$videoParse4 = new VideoParse();
$videoParse4->whereExists('objectId');
$videoParse4->orderByDescending('createdAt');
$videoParse4->setLimit(5);
$resGets = $videoParse4->getVideos();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $video) {
		echo '<br />' . $video->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Video<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Video<br />';

$videoParse5 = new VideoParse();
$video1 = new Video();
$video1->setObjectId('AOPyno3s8m');
$video1->setCounter(99);
$resUpdate = $videoParse5->saveVideo($video1);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Video UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Video<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>