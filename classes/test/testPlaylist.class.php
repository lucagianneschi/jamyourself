<?php
/* ! \par Info Generali:
* \author Luca Gianneschi
* \version 1.0
* \date 2013
* \copyright Jamyourself.com 2013
*
* \par Info Classe:
* \brief Classe di test
* \details Classe di test per la classe playlist
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

$playlist = new playlist();
$playlist->setObjectId('aAbBcCdD');
$playlist->setActive(true);
$playlist->setFromUser('GuUAj83MGH');
$playlist->setName('nome della playlist');
$playlist->setSongs(array('2gMM3NmUYY','2gMM3NmUYY'));
$playlist->setUnlimited(false);
$dateTime = new DateTime();
$playlist->setCreatedAt($dateTime);
$playlist->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$playlist->setACL($acl);

echo 'STAMPO LA playlist APPENA CREATO  <br>';
echo $playlist;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DELLa playlist APPENA CREATO<br />';

$playlistParse = new PlaylistParse();
if (get_class($playlistParse->savePlaylist($playlist))) {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $playlistParse->savePlaylist($playlist)->getErrorMessage() . '<br/>';
}
echo 'FINITO IL SALVATAGGIO DEL playlist APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />INIZIO IL RECUPERO DI UN Playlist<br /><br />';

$playlistParse1 = new PlaylistParse();
$resGet = $playlistParse1->getPlaylist('Wa5P1x4qrc');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Playlist<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UN Playlist<br />';

$playlistParse2 = new PlaylistParse();
$resDelete = $playlistParse2->deletePlaylist('AOPyno3s8m');
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Comment<br />';

$playlistParse3 = new PlaylistParse();
$playlistParse3->whereExists('objectId');
$playlistParse3->orderByDescending('createdAt');
$playlistParse3->setLimit(5);
$resGets = $playlistParse3->getPlaylists();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $status) {
		echo '<br />' . $status->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Playlist<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Playlist<br />';

$playlistParse4 = new PlaylistParse();
$playlist2 = new Comment();
$playlist2->setObjectId('AOPyno3s8m');
$playlist2->setCounter(9955);
$resUpdate = $playlistParse4->savePlaylist($playlist2);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>