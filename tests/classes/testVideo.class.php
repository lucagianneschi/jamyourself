<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date			2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Video
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
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'video.class.php';
require_once CLASSES_DIR . 'videoParse.class.php';

$video = new Video();

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
//$video->setACL();

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'STAMPO IL Video APPENA CREATO  <br>';
echo $video;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DEL Video APPENA CREATO<br />';
$videoParse = new VideoParse();

$resSave = $videoParse->saveVideo($video);

if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br />';
} else {
	echo '<br />Video SAVED<br />' . $resSave . '<br />';
}
echo 'FINITO IL SALVATAGGIO DEL Video APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Video<br /><br />';

$videoParse = new VideoParse();
$resGet = $videoParse->getVideo($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Video<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Video<br />';

$videoParse = new VideoParse();
$resDelete = $videoParse->deleteVideo($resSave->getObjectId());
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
$video = $videoParse->getVideo($resSave->getObjectId());
$video->setDuration(500);
$resUpdate = $videoParse->saveVideo($video);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Video UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Video<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />INIZIO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DEL VIDEO<br />';

$videoParse = new VideoParse();

$videoParse->updateField($resSave->getObjectId(), 'active', true);
echo 'Aggiornato un campo boolean<br />';
$videoParse->updateField($resSave->getObjectId(), 'author', 'Un author modificato');
echo 'Aggiornato un campo string<br />';
$videoParse->updateField($resSave->getObjectId(), 'counter', 100);
echo 'Aggiornato un campo number<br />';
$videoParse->updateField($resSave->getObjectId(), 'tags', array('op1', 'op2'));
echo 'Aggiornato un campo array<br />';

$videoParse->updateField($resSave->getObjectId(), 'fromUser', toParsePointer('_User', '3xqN97WJHj'));
echo 'Aggiornato un campo Pointer<br />';

$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$videoParse->updateField($resSave->getObjectId(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';

$videoParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';

$videoParse->updateField($resSave->getObjectId(), 'commentators', array('n1TXVlIqHw'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';

echo '<br />FINITO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DEL VIDEO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>