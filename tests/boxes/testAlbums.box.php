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
require_once BOXES_DIR . 'album.box.php';

$i_end = microtime();



echo '<br />-------------------------TEST ALBUM UPLAODPAGE-------------------------------------------<br />';
$album3 = new AlbumBox();
$album3->initForUploadAlbumPage();

print "<pre>";
print_r($album3);
print "</pre>";
echo '<br />-------------------------TEST ALBUM PERSONALPAGE-------------------------------------------<br />';
$album_start = microtime();
$albumBoxP = new AlbumBox();
$albumBoxP->init('7fes1RyY77');
print "<pre>";
print_r($albumBoxP);
print "</pre>";
$album_stop = microtime();
echo '<br />----------------------INITFORDETAIL----------------------------------------------<br />';
echo '<br />----------------------ALBUM_LDF_206_FOTO----------------------------------------------<br />';
$album = '6nl9mn8a4I';

$albumBoxP3 = new AlbumBox();
$albumBoxP3->initForDetail($album, 10,0);
print "<pre>";
print_r($albumBoxP3);
print "</pre>";
$t_end = microtime();





?>