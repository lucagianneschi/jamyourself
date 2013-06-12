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
?>