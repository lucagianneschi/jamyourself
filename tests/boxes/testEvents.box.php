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
require_once BOXES_DIR . 'utilsBox.php';
$i_end = microtime();

$objectId = '7fes1RyY77'; //LDF
$idEvent = 'Imx9idjTGj';





$eventBoxP3 = new EventBox;
$eventBoxP3->initForTimeLine();
print "<pre>";
print_r($eventBoxP3);
print "</pre>";








echo '<br />-------------------------TEST EVENT LDF-------------------------------------------<br />';
$event1_start = microtime();
$eventBoxP1 = new EventBox();
$eventBoxP1->initForPersonalPage($objectId);
print "<pre>";
print_r($eventBoxP1);
print "</pre>";
$event1_stop = microtime();
$event2_start = microtime();
echo '<br />TEST  INFO EVENT MEDIA PAGE<br />';
$eventBoxP2 = new EventBox;
$eventBoxP2->initForMediaPage($idEvent);
print "<pre>";
print_r($eventBoxP2);
print "</pre>";
echo '<br />FINE TEST  INFO EVENT MEDIA PAGE<br />';
$event2_stop = microtime();




echo '<br />-------------------------FINE TEST EVENT BOX-------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo event personal page:  ' . executionTime($event1_start, $event1_stop) . '<br />';
echo 'Tempo event media page:  ' . executionTime($event2_start, $event2_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>