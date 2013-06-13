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
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'video.class.php';
require_once CLASSES_DIR . 'videoParse.class.php';

$video = new Video();
$video->setObjectId('aAbBcCdD');
$video->setActive(true);
$video->setAuthor('Autore del video');
//$video->setCommentators(array $commentators);
//$video->setComments(array $comments);
$video->setCounter(0);
$video->setDescription('Descrizione del video');
$video->setDuration(120);
//$video->setFromUser(User $fromUser);
$video->setLoveCounter(100);
//$video->setLovers(array $lovers);
$video->setTags(array('tag1', 'tag2'));
$video->setThumbnail('indirizzo del thumbnail');
$video->setTitle('titolo del video');
$dateTime = new DateTime();
$video->setCreatedAt($dateTime);
$video->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$video->setACL($acl);

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

$videoParse = new VideoParse();
$resSave = $videoParse->saveVideo($video);
if (get_class($resSave)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED con objectId => ' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Comment<br /><br />';

$videoParse = new VideoParse();
$resGet = $videoParse->getVideo('ihcPvm6BIv');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN VIDEO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Video<br />';

$videoParse = new VideoParse();
$resDelete = $videoParse->deleteVideo('ihcPvm6BIv');
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Video DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Video<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Video<br />';

$videoParse = new VideoParse();
$videoParse->whereExists('objectId');
$videoParse->orderByDescending('createdAt');
$videoParse->setLimit(5);
$resGets = $videoParse->getVideos();
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

$videoParse = new VideoParse();
$video = new Video();
$video->setObjectId('AOPyno3s8m');
$video->setCounter(99);
$resUpdate = $videoParse->saveVideo($video);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Video UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Video<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>