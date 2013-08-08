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

//SPOTTER
$mari = '1oT7yYrpfZ'; //MARI
$FLAVYCAP = 'oN7Pcp2lxf'; //FLAVYCAP 
$Kessingtong = '2OgmANcYaT'; //Kessingtong
//JAMMER
$ROSESINBLOOM = 'uMxy47jSjg'; //ROSESINBLOOM
$Stanis = 'HdqSpIhiXo'; //Stanis
$LDF = '7fes1RyY77'; //LDF
//Venue
$ZonaPlayed = '2K5Lv7qxzw'; //ZonaPlayed  
$Ultrasuono = 'iovioSH5mq'; //Ultrasuono 
$jump = 'wrpgRuSgRA'; //jump rock club


$album_start = microtime();
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST ALBUM BOX-------------------------------------------<br />';
echo '<br />TEST ALBUM BOX SPOTTER<br />';
echo '<br />TEST ALBUM BOX MARI<br />';
$album_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($mari);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album_stop = microtime();
echo '<br />TEST ALBUM BOX MARI<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX FLAVYCAP<br />';
$album1_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($FLAVYCAP);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album1_stop = microtime();
echo '<br />TEST ALBUM BOX FLAVYCAP<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Kessingtong<br />';
$album2_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($Kessingtong);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album2_stop = microtime();
echo '<br />TEST ALBUM BOX Kessingtong<br />';
echo '<br />FINE TEST ALBUM BOX SPOTTER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX JAMMER<br />';
echo '<br />TEST ALBUM BOX ROSESINBLOOM<br />';
$album3_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($ROSESINBLOOM);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album3_stop = microtime();
echo '<br />TEST ALBUM BOX ROSESINBLOOM<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX STANIS<br />';
$album4_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($Stanis);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album4_stop = microtime();
echo '<br />TEST ALBUM BOX STANIS<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX LDF<br />';
$album5_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($LDF);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album5_stop = microtime();
echo '<br />TEST ALBUM BOX LDF<br />';
echo '<br /FINE TEST ALBUM BOX JAMMER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br /TEST ALBUM BOX VENUE<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX ZonaPlayed<br />';
$album6_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($ZonaPlayed);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album6_stop = microtime();
echo '<br />TEST ALBUM BOX ZonaPlayed<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Ultrasuono<br />';
$album7_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($Ultrasuono);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album7_stop = microtime();
echo '<br />TEST ALBUM BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Jump<br />';
$album8_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($jump);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX Jump<br />';
$album8_stop = microtime();
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
echo 'Tempo recupero ultimi 4 album ' . executionTime($album6_start, $album6_stop) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album7_start, $album7_stop) . '<br />';
echo 'Tempo recupero ultimi 4 album ' . executionTime($album8_start, $album8_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>