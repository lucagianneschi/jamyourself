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

$objectId = '7fes1RyY77'; //JAMMER
$objectId1 = '7wi6AvviK4'; //SPOTTER
$objectId2 = 'iovioSH5mq'; //VENUE
//echo '<br />-------------------------------PERSONALPAGE-------------------------------------------<br />';
//$review1_start = microtime();
//$reviewBoxP1 = new ReviewBox();
//$reviewBox1 = $reviewBoxP1->initForPersonalPage($objectId, 'JAMMER', 'Event');
//print "<pre>";
//print_r($reviewBox1);
//print "</pre>";
//$reviewBoxR1 = new ReviewBox();
//$reviewBoxRe1 = $reviewBoxR1->initForPersonalPage($objectId, 'JAMMER', 'Record');
//print "<pre>";
//print_r($reviewBoxRe1);
//print "</pre>";
//$review1_stop = microtime();
//echo '<br />-------------------------------PERSONALPAGE-------------------------------------------<br />';
//$review2_start = microtime();
//$reviewBoxP2 = new ReviewBox();
//$reviewBox2 = $reviewBoxP2->initForPersonalPage($objectId1, 'SPOTTER', 'Event');
//print "<pre>";
//print_r($reviewBox2);
//print "</pre>";
//$review2_stop = microtime();
//echo '<br />-------------------------------PERSONALPAGE-------------------------------------------<br />';
//$reviewBoxP5 = new ReviewBox();
//$reviewBox5 = $reviewBoxP5->initForPersonalPage($objectId2, 'VENUE', 'Event');
//print "<pre>";
//print_r($reviewBox5);
//print "</pre>";
//echo '<br />-------------------------------MEDIAPAGE-------------------------------------------<br />';
//$idReview = 'Khlv07KRGH';
//$review3_start = microtime();
//$reviewBoxP3 = new ReviewBox();
//$reviewBox3 = $reviewBoxP3->initForMediaPage('FdNPf4yaxV', 'Event', 3, 1);
//
//print "<pre>";
//print_r($reviewBox3);
//print "</pre>";
//echo '<br />-------------------------------DETAIL-------------------------------------------<br />';
//$review3_stop = microtime();
//$review4_start = microtime();
//$reviewBox4 = $reviewBoxP3->initForDetail($idReview);
//print "<pre>";
//print_r($reviewBox4);
//print "</pre>";
//$review4_stop = microtime();
echo '<br />-------------------------------UPLOADREVIEWPAGE-------------------------------------------<br />';
//$review5_start = microtime();
$eventId = 'Imx9idjTGj';
$recordId = 'b8r9q9b5se';
$limit = 1;
$reviewBoxP6 = new ReviewBox();
$reviewBox6 = $reviewBoxP6->initForUploadReviewPage($eventId, 'Event',$limit);
$reviewBoxP7 = new ReviewBox();
$reviewBox7 = $reviewBoxP7->initForUploadReviewPage($recordId, 'Record',$limit);
echo '<br />-------------------------------EVENT-------------------------------------------<br />';
print "<pre>";
print_r($reviewBox6);
print "</pre>";
echo '<br />-------------------------------RECORD-------------------------------------------<br />';
print "<pre>";
print_r($reviewBox7);
print "</pre>";
//$review5_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
//echo 'Tempo review event' . executionTime($review1_start, $review1_stop) . '<br />';
//echo 'Tempo review event' . executionTime($review2_start, $review2_stop) . '<br />';
//echo 'Tempo review event' . executionTime($review3_start, $review3_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>