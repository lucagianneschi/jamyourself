<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento ultimi 4 eventi caricati
 * \details		Recupera le informazioni utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		utilizzare variabili di sessione
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'info.box.php';
require_once PARSE_DIR . 'parse.php';
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


echo '<br />------------------------- TEST INFO BOX-------------------------------------------<br />';
echo '<br />TEST INFO BOX SPOTTER<br />';
echo '<br />TEST INFO BOX OBJ MARI<br />';
$t1_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($mari);
$t1_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX OBJ MARI<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX OBJ FLAVYCAP<br />';
$t2_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($FLAVYCAP);
$t2_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX OBJ FLAVYCAP<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX OBJ MARI<br />';
echo '<br />TEST INFO BOX Kessingtong<br />';
$t3_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($Kessingtong);
$t3_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX Kessingtong<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX JAMMER<br />';
echo '<br />TEST INFO BOX ROSESINBLOOM<br />';
$t4_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($ROSESINBLOOM);
$t4_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX ROSESINBLOOM<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO Stanis<br />';
$t5_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($Stanis);
$t5_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO Stanis<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX OBJ LDF<br />';
$t6_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($LDF);
$t6_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX OBJ LDF<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX VENUE<br />';
echo '<br />TEST INFO BOX ZonaPlayed<br />';
$t7_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($ZonaPlayed);
$t7_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX ZonaPlayed<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX Ultrasuono<br />';
$t8_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($Ultrasuono);
$t8_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX Jump<br />';
$t9_start = microtime();
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($jump);
$t9_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX Jump<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />------------------------- FINE TEST INFO BOX-------------------------------------------<br />';

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo totale ' . executionTime($t1_start, $t1_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t2_start, $t2_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t3_start, $t3_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t4_start, $t4_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t5_start, $t5_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t6_start, $t6_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t7_start, $t7_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t8_start, $t8_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t9_start, $t9_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>