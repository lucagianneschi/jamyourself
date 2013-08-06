<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box informazioni record
 * \details		Recupera le informazioni da mostrare per la pagina del record
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
require_once BOXES_DIR . 'recordInfo.box.php';
$i_end = microtime();


$id = 'b8r9q9b5se';
$record_start = microtime();
echo '<br />TEST  INFO RECORD MEDIA PAGE<br />';
$recordBoxP = new RecordInfoBox();
$recordBox = $recordBoxP->init($id);
print "<pre>";
print_r($recordBox);
print "</pre>";
echo '<br />FINE TEST  INFO RECORD MEDIA PAGE<br />';
$record_stop = microtime();

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero info record ' . executionTime($record_start, $record_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>