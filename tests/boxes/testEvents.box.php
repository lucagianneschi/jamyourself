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

$id1 = '7fes1RyY77';//LDF

echo '<br />-------------------------TEST EVENT LDF-------------------------------------------<br />';
$event1_start = microtime();
$eventBoxP = new EventBox();
$eventBox = $eventBoxP->initForPersonalPage($id1);
print "<pre>";
print_r($eventBox);
print "</pre>";
$event1_stop = microtime();
$event_start = microtime();
echo '<br />TEST  INFO EVENT MEDIA PAGE<br />';
$eventBoxP = new EventBox;
$eventBox = $eventBoxP->initForMediaPage($id1);
print "<pre>";
print_r($eventBox);
print "</pre>";
echo '<br />FINE TEST  INFO EVENT MEDIA PAGE<br />';
$event_stop = microtime();
$event3_start = microtime();
echo '<br />TEST  INFO EVENT UPLOADREVIEW PAGE<br />';
$eventBoxP = new EventBox;
$eventBox = $eventBoxP->initForUploadReviewPage($id1);
print "<pre>";
print_r($eventBox);
print "</pre>";
echo '<br />FINE TEST  INFO EVENT UPLOADREVIEW PAGE<br />';
$event3_stop = microtime();

echo '<br />-------------------------FINE TEST EVENT BOX-------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo event personal page:  ' . executionTime($event1_start, $event1_stop) . '<br />';
echo 'Tempo event media page:  ' . executionTime($event_start, $event_stop) . '<br />';
echo 'Tempo event uploadRrview:  ' . executionTime($event3_start, $event3_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>