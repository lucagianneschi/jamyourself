<?php
/* ! \par		Info Generali:
* \author		Luca Gianneschi
* \version		1.0
* \date			2013
* \copyright	Jamyourself.com 2013
*
* \par			Info Classe:
* \brief		Classe di test
* \details		Classe di test per la classe playlist
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
require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';

$playlist = new Playlist();
$playlist->setActive(true);
$playlist->setFromUser('GuUAj83MGH');
$playlist->setName('Nome della playlist');
$playlist->setSongs(array('nBF3KVDGxZ', 'MSJfcWb9Qk'));
$playlist->setUnlimited(false);
//$playlist->setACL();

echo 'STAMPO LA Playlist APPENA CREATA  <br>';
echo $playlist;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DELLA Playlist APPENA CREATA<br />';

$playlistParse = new PlaylistParse();
$resSave = $playlistParse->savePlaylist($playlist);
if (get_class($resSave) == 'Error') {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Playlist SAVED<br />' . $resSave . '<br />';
}

echo 'FINITO IL SALVATAGGIO DELA Playlist APPENA CREATA<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNA Playlist<br /><br />';

$playlistParse = new PlaylistParse();
$resGet = $playlistParse->getPlaylist($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNA Playlist<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UNA Playlist<br />';

$playlistParse = new PlaylistParse();
$resDelete = $playlistParse->deletePlaylist($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />Playlist DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UNA Playlist<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Playlist<br />';

$playlistParse = new PlaylistParse();
$playlistParse->whereExists('objectId');
$playlistParse->orderByDescending('createdAt');
$playlistParse->setLimit(5);
$resGets = $playlistParse->getPlaylists();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $status) {
		echo '<br />' . $status->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Playlist<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UNA Playlist<br />';

$playlistParse = new PlaylistParse();
$playlist = $playlistParse->getPlaylist($resSave->getObjectId());
$playlist->setSongs(array('q1fVHDRD7V', 'SdJx4roDEs'));
$resUpdate = $playlistParse->savePlaylist($playlist);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Playlist UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UNA Playlist<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>