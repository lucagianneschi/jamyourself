<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box review
 * \details		Recupera review dei record legate al profilo selezionato
 * \par			Commenti:
 * \warning
 * \bug
 * \todo                
 *
 */

$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'reviewRecord.box.php';
$i_end = microtime();

$objectId = 'GuUAj83MGH';
$objectId1 = 'nXvzqUuPHW';
	
$reviewRecord_start = microtime();
$reviewRecordBoxP = new ReviewRecordBox();
$reviewRecordBox = $reviewRecordBoxP->init($objectId,'SPOTTER');
print "<pre>";
print_r($reviewRecordBox);
print "</pre>";
$reviewRecord_stop = microtime();


$reviewRecord1_start = microtime();
$reviewRecordBoxP = new ReviewRecordBox();
$reviewRecordBox = $reviewRecordBoxP->init($objectId1,'JAMMER');
print "<pre>";
print_r($reviewRecordBox);
print "</pre>";
$reviewRecord1_stop = microtime();


$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo review' . executionTime($reviewRecord_start, $reviewRecord_stop) . '<br />';
echo 'Tempo review' . executionTime($reviewRecord1_start, $reviewRecord1_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>