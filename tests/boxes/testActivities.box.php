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

$i_end = microtime();
//SPOTTER
$Karl01 = '7wi6AvviK4'; //Karl01

//JAMMER
$LDF = '7fes1RyY77'; //LDF
//Venue  
$Ultrasuono = 'iovioSH5mq'; //Ultrasuono 

echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX LDF<br />';
$jammer_start = microtime();
$activityBoxP = new ActivityBox();
$activityBox = $activityBoxP->initForPersonalPage($LDF,"JAMMER");
print "<pre>";
print_r($activityBox);
print "</pre>";
$jammer_stop = microtime();
echo '<br />TEST ACTIVITY BOX LDF<br />';
echo '<br />TEST ACTIVITY BOX Ultrasuono<br />';
$venue_start = microtime();
$activityBoxP1 = new ActivityBox();
$activityBox1 = $activityBoxP1->initForPersonalPage($Ultrasuono,"VENUE");
print "<pre>";
print_r($activityBox1);
print "</pre>";
$venue_stop = microtime();
echo '<br />TEST ACTIVITY BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ACTIVITY BOX Karl01<br />';
$spotter_start = microtime();
$activityBoxP2 = new ActivityBox();
$activityBox2 = $activityBoxP2->initForPersonalPage($Karl01,"SPOTTER");
print "<pre>";
print_r($activityBox2);
print "</pre>";
$spotter_stop = microtime();
echo '<br />TEST ACTIVITY BOX Karl01<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
//echo 'Tempo JAMMER ' . executionTime($jammer_start, $jammer_stop) . '<br />';
//echo 'Tempo VENUE ' . executionTime($venue_start, $venue_stop) . '<br />';
echo 'Tempo SPOTTER ' . executionTime($spotter_start, $spotter_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>


