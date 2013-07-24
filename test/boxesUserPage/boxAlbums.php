<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Album
 * \details		Recupera gli ultimi 4 album attivi (valido per ogni tipologia di utente)
 * \par			Commenti:
 * \warning
 * \bug
 * \todo        utilizzare le variabili di sessione e non fare la get dello user
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
$i_end = microtime();

$id = '7fes1RyY77';//LDF

$album_start = microtime();
$album = new AlbumParse();
$album->wherePointer('fromUser', '_User', $id);
$album->where('active',true);
$album->setLimit(1000);
$album->orderByDescending('createdAt');
$albums = $album->getAlbums();
if ($albums != 0) {
    if (get_class($albums) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $albums->getErrorMessage() . '<br/>';
    } else {
	foreach ($albums as $album) {
	    echo '<br />[thumbnailCover] => ' . $album->getThumbnailCover() . '<br />';
	    echo '<br />[title] => ' . $album->getTitle() . '<br />';
	    echo '<br />[imageCounter] => ' . $album->getImageCounter() . '<br />';
	    echo '<br />[loveCounter] => ' . $album->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $album->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $album->getShareCounter() . '<br />';
	}
    }
}
$album_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album_start, $album_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>