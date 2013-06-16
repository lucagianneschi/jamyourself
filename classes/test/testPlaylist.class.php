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

ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';

$playlist = new playlist();
$playlist->setObjectId('aAbBcCdD');
$playlist->setActive(true);
//$playlist->setFromUser(User $fromUser);
$playlist->setName('nome della playlist');
$songs = array (
	"__op" => "AddRelation",
	"objects" => array(
		array("__type" => "Pointer", "className" => "Song", "objectId" => "2gMM3NmUYY"),//inserire valori 2 song
		array("__type" => "Pointer", "className" => "Song", "objectId" => "5zw3I5d9Od")
	)
);
$playlist->setComments($songs);
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
$playlistParse = new playlistParse();
if (get_class($playlistParse->savePlaylist($playlist))) {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $playlistParse->savePlaylist($playlist)->getErrorMessage() . '<br/>';
}
echo 'FINITO IL SALVATAGGIO DEL playlist APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>