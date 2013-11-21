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
require_once BOXES_DIR . 'message.box.php';

$i_end = microtime();
//SPOTTER
$fromUser = '7wi6AvviK4'; //Karl01
//JAMMER
$toUser = '7fes1RyY77'; //LDF
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST MESSAGE BOX<br />';
$jammer_start = microtime();
$activityBoxP = new MessageBox();
$listUserBox = $activityBoxP->initForUserList($fromUser, 5, 0);
print "<pre>";
print_r($listUserBox);
print "</pre>";
$listMessage = $activityBoxP->initForMessageList($fromUser, $toUser, 10, 0);
print "<pre>";
print_r($listMessage);
print "</pre>";
$jammer_stop = microtime();
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST MESSAGE BOX<br />';
$jammer1_start = microtime();
$activityBoxP1 = new MessageBox();
$listUserBox1 = $activityBoxP1->initForUserList($toUser, 5, 0);
print "<pre>";
print_r($listUserBox1);
print "</pre>";
$listMessage1 = $activityBoxP1->initForMessageList($toUser, $fromUser, 10, 0);
print "<pre>";
print_r($listMessage1);
print "</pre>";
$jammer1_stop = microtime();
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST MESSAGE BOX<br />';
$jammer2_start = microtime();
$activityBoxP2 = new MessageBox();
$listUserBox2 = $activityBoxP1->initForUserList('pippopppoo', 5, 0);
print "<pre>";
print_r($listUserBox2);
print "</pre>";
$listMessage2 = $activityBoxP2->initForMessageList('poppopppo', 'cacacacacaca', 10, 0);
print "<pre>";
print_r($listMessage2);
print "</pre>";
$jammer2_stop = microtime();
echo '<br />-------------------------------------------------------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo JAMMER ' . executionTime($jammer_start, $jammer_stop) . '<br />';
echo 'Tempo JAMMER ' . executionTime($jammer1_start, $jammer1_stop) . '<br />';
echo 'Tempo ERRORE' . executionTime($jammer2_start, $jammer2_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>


