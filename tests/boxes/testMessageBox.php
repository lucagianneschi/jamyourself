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
$fromUser = '7fes1RyY77'; //spatafora
echo '<br />----------------------PAGINA MESSAGGI DI LDF---------------------------------------------------------------------<br />';
echo '<br />TEST MESSAGE BOX<br />';
$jammer_start = microtime();
$activityBoxP = new MessageBox();
$activityBoxP->initForUserList(5, 0);
print "<pre>";
print_r($activityBoxP);
print "</pre>";
$activityBoxP->initForMessageList($fromUser, 5, 0);
print "<pre>";
print_r($activityBoxP);
print "</pre>";
$jammer_stop = microtime();
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo JAMMER ' . executionTime($jammer_start, $jammer_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>


