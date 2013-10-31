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
require_once BOXES_DIR . 'userInfo.box.php';
require_once PARSE_DIR . 'parse.php';
$i_end = microtime();

//SPOTTER
$karl01 = '7wi6AvviK4'; //karl01
//JAMMER
$LDF = '7fes1RyY77'; //LDF
//Venue
$Ultrasuono = 'iovioSH5mq'; //Ultrasuono 

echo '<br />------------------------- TEST INFO BOX-------------------------------------------<br />';
echo '<br />TEST INFO BOX  LDF<br />';
$t1_start = microtime();
$infoBoxP1 = new UserInfoBox();
$info1 = $infoBoxP1->initForPersonalPage($LDF);
$t1_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX karl01<br />';
$t2_start = microtime();
$infoBoxP2 = new UserInfoBox();
$info2 = $infoBoxP2->initForPersonalPage($karl01);
$t2_stop = microtime();
print "<pre>";
print_r($info2);
print "</pre>";
echo '<br />TEST INFO BOX Ultrasuono<br />';
$t3_start = microtime();
$infoBoxP3 = new UserInfoBox();
$info3 = $infoBoxP3->initForPersonalPage($Ultrasuono);
$t3_stop = microtime();
print "<pre>";
print_r($info3);
print "</pre>";
echo '<br />TEST ERRORE<br />';
$t4_start = microtime();
$infoBoxP4 = new UserInfoBox();
$info4 = $infoBoxP4->initForPersonalPage('pippopuzza');
$t4_stop = microtime();
print "<pre>";
print_r($info4);
print "</pre>";
echo '<br />TEST INFO BOX ERRORE<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />------------------------- FINE TEST INFO BOX-------------------------------------------<br />';

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo LDF JAMMER ' . executionTime($t1_start, $t1_stop) . '<br />';
echo 'Tempo KARL01 SPOTTER ' . executionTime($t2_start, $t2_stop) . '<br />';
echo 'Tempo ULTRASUONO VENUE ' . executionTime($t3_start, $t3_stop) . '<br />';
echo 'Tempo ERRORE ' . executionTime($t4_start, $t4_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>