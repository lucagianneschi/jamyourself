<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box informazioni event
 * \details		Recupera le informazioni da mostrare per la pagina dell'event
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'eventInfo.box.php';
$i_end = microtime();

$id = 'AdPPB6Rcao';
$event_start = microtime();
echo '<br />TEST  INFO EVENT MEDIA PAGE<br />';
$eventBoxP = new EventInfoBox();
$eventBox = $eventBoxP->init($id);
print "<pre>";
print_r($eventBox);
print "</pre>";
echo '<br />FINE TEST  INFO EVENT MEDIA PAGE<br />';
$event_stop = microtime();

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero info record ' . executionTime($event_start, $event_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>