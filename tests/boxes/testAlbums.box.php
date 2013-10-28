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
$karl01 = '7wi6AvviK4'; //karl01
$LDF = '7fes1RyY77'; //LDF 
$Ultrasuono = 'iovioSH5mq'; //Ultrasuono 
echo '<br />-------------------------TEST ALBUM PERSONALPAGE-------------------------------------------<br />';
$album_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($karl01);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album_stop = microtime();
$album1_start = microtime();
$albumBoxP1 = new AlbumBox();
$albumBox1 = $albumBoxP1->initForPersonalPage($LDF);
print "<pre>";
print_r($albumBox1);
print "</pre>";
$album1_stop = microtime();
$album2_start = microtime();
$albumBoxP2 = new AlbumBox();
$albumBox2 = $albumBoxP2->initForPersonalPage($Ultrasuono);
print "<pre>";
print_r($albumBox2);
print "</pre>";
$album2_stop = microtime();
$album3_start = microtime();
echo '<br />----------------------INITFORDETAIL----------------------------------------------<br />';
echo '<br />----------------------ALBUM_LDF_206_FOTO----------------------------------------------<br />';
$albumBoxP3 = new AlbumBox();
$albumBox3 = $albumBoxP3->initForDetail('6nl9mn8a4I');//
print "<pre>";
print_r($albumBox3);
print "</pre>";
echo '<br />----------------------ALBUM_132_FOTO----------------------------------------------<br />';
$album3_stop = microtime();
$album4_start = microtime();
$albumBoxP4 = new AlbumBox();
$albumBox4 = $albumBoxP4->initForDetail('uhRY8ULFNR');
print "<pre>";
print_r($albumBox4);
print "</pre>";
$album4_stop = microtime();
$album5_start = microtime();
$albumBoxP5 = new AlbumBox();
$albumBox5 = $albumBoxP5->initForDetail('VMeoQds3TU');
print "<pre>";
print_r($albumBox5);
print "</pre>";
$album5_stop = microtime();
echo '<br />FINE TEST ALBUM BOX<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album_start, $album_stop) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album1_start, $album1_stop) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album2_start, $album2_stop) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album3_start, $album3_stop) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album4_start, $album4_stop) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album5_start, $album5_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>