<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento ultimi 4 eventi caricati
 * \details		Recupera le informazioni ultimi 4 eventi caricati
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
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'event.box.php';
$i_end = microtime();

$id1 = '7fes1RyY77'; //LDF
$idEvent = 'Imx9idjTGj';
echo '<br />-------------------------TEST EVENT LDF-------------------------------------------<br />';
$event1_start = microtime();
$eventBoxP1 = new EventBox();
$eventBox1 = $eventBoxP1->initForPersonalPage($id1);
print "<pre>";
print_r($eventBox1);
print "</pre>";
$event1_stop = microtime();
$event2_start = microtime();
echo '<br />TEST  INFO EVENT MEDIA PAGE<br />';
$eventBoxP2 = new EventBox;
$eventBox2 = $eventBoxP2->initForMediaPage($idEvent);
print "<pre>";
print_r($eventBox2);
print "</pre>";
echo '<br />TEST  VIEWALL MEDIA PAGE<br />';
$eventBox3 = $eventBoxP2->getRelatedUsers($idEvent, 'featuring', true, 'Media');
print "<pre>";
print_r($eventBox3);
print "</pre>";
echo '<br />FINE TEST  INFO EVENT MEDIA PAGE<br />';
$event2_stop = microtime();
$event3_start = microtime();
echo '<br />TEST  INFO EVENT UPLOADREVIEW PAGE<br />';
$eventBoxP4 = new EventBox;
$eventBox4 = $eventBoxP4->initForUploadReviewPage($idEvent);
$event3_stop = microtime();
print "<pre>";
print_r($eventBox4);
print "</pre>";
echo '<br />FINE TEST  INFO EVENT UPLOADREVIEW PAGE<br />';
echo '<br />ERRORE PERSONAL PAGE<br />';
$error1_start = microtime();
$errorBoxP = new EventBox();
$errorBox = $errorBoxP->initForPersonalPage('pipopopopopopopo');
print "<pre>";
print_r($errorBox);
print "</pre>";
$error1_stop = microtime();
echo '<br />ERRORE MEDIA PAGE<br />';
$error2_start = microtime();
$errorBoxP2 = new EventBox();
$errorBox2 = $errorBoxP2->initForMediaPage('ciaciaciaoicoai');
print "<pre>";
print_r($errorBox2);
print "</pre>";
$error2_stop = microtime();
echo '<br />ERRORE UPLOAD PAGE<br />';
$error3_start = microtime();
$errorBoxP3 = new EventBox();
$errorBox3 = $errorBoxP3->initForUploadReviewPage('erroroerer');
print "<pre>";
print_r($errorBox3);
print "</pre>";
$error3_stop = microtime();
echo '<br />-------------------------FINE TEST EVENT BOX-------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo event personal page:  ' . executionTime($event1_start, $event1_stop) . '<br />';
echo 'Tempo event media page:  ' . executionTime($event2_start, $event2_stop) . '<br />';
echo 'Tempo event uploadReview:  ' . executionTime($event3_start, $event3_stop) . '<br />';
echo 'Tempo event ERRORE PERSONALPAGE:  ' . executionTime($error1_start, $error1_stop) . '<br />';
echo 'Tempo event ERRORE MEDIAPAGE:  ' . executionTime($error2_start, $error2_stop) . '<br />';
echo 'Tempo event ERRORE UPLOADPAGE:  ' . executionTime($error3_start, $error3_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>