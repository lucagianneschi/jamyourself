<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		File di caricamento informazioni pagina Jammer
 * \details		Recupera le informazioni da mostrare per il profilo selezionato
 * \par			Commenti:
 * \warning
 * \bug
 *
 */

$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'activity.box.php';

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

$i_end = microtime();
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST ACTIVITY BOX-------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX SPOTTER<br />';
echo '<br />TEST ACTIVITY BOX MARI<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($mari,"SPOTTER");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX MARI<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX FLAVYCAP<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($FLAVYCAP,"SPOTTER");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX FLAVYCAP<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX Kessingtong<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($Kessingtong,"SPOTTER");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX Kessingtong<br />';
echo '<br />FINE TEST ACTIVITY BOX SPOTTER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX JAMMER<br />';
echo '<br />TEST ACTIVITY BOX ROSESINBLOOM<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($ROSESINBLOOM,"JAMMER");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX ROSESINBLOOM<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX STANIS<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($Stanis,"JAMMER");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX STANIS<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX LDF<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($LDF,"JAMMER");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX LDF<br />';
echo '<br /FINE TEST ACTIVITY BOX JAMMER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br /TEST ACTIVITY BOX VENUE<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX ZonaPlayed<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($ZonaPlayed,"VENUE");
print "<pre>";
print_r($activityBox);
print "</pre>";
'<br />TEST ACTIVITY BOX ZonaPlayed<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX Ultrasuono<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($Ultrasuono,"VENUE");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX Jump<br />';
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($jump,"VENUE");
print "<pre>";
print_r($activityBox);
print "</pre>";
echo '<br />TEST ACTIVITY BOX Jump<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>