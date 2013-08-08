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
require_once BOXES_DIR . 'review.box.php';
$i_end = microtime();

$objectId = 'GuUAj83MGH'; //spatafora
$objectId1 = 'nXvzqUuPHW'; //disinteresse
	
$reviewRecord_start = microtime();
$reviewRecordBoxP = new ReviewBox();
$reviewRecordBox = $reviewRecordBoxP->initForPersonalPage($objectId,'SPOTTER','Record');
print "<pre>";
print_r($reviewRecordBox);
print "</pre>";
$reviewRecord_stop = microtime();


$reviewRecord1_start = microtime();
$reviewRecordBoxP = new ReviewBox();
$reviewRecordBox = $reviewRecordBoxP->initForPersonalPage($objectId1,'JAMMER','Record');
print "<pre>";
print_r($reviewRecordBox);
print "</pre>";
$reviewRecord1_stop = microtime();


$reviewEvent_start = microtime();
$reviewEventBoxP = new ReviewBox();
$reviewEventBox = $reviewEventBoxP->initForPersonalPage($objectId,'SPOTTER','Event');
print "<pre>";
print_r($reviewEventBox);
print "</pre>";
$reviewEvent_stop = microtime();

$reviewEvent1_start = microtime();
$reviewEventBoxP = new ReviewBox();
$reviewEventBox = $reviewEventBoxP->initForPersonalPage($objectId1,'JAMMER','Event');
print "<pre>";
print_r($reviewEventBox);
print "</pre>";
$reviewEvent1_stop = microtime();

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo review record' . executionTime($reviewRecord_start, $reviewRecord_stop) . '<br />';
echo 'Tempo review record' . executionTime($reviewRecord1_start, $reviewRecord1_stop) . '<br />';
echo 'Tempo review event' . executionTime($reviewEvent_start, $reviewEvent_stop) . '<br />';
echo 'Tempo review event' . executionTime($reviewEvent1_start, $reviewEvent1_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>