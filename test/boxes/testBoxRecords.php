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
require_once BOXES_DIR . 'record.box.php';
$i_end = microtime();

//JAMMER
$SPATAFORA = 'GuUAj83MGH';
$glam = '5bZoNsZq7M';
$camera133 = 'tYSECCWBcy';

echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RECORD BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
$record1_start = microtime();
$recordBoxP = new RecordBox();
$recordBox = $recordBoxP->initForPersonalPage($SPATAFORA);
print "<pre>";
print_r($recordBox);
print "</pre>";
$record1_stop = microtime();
echo '<br />-------------------------FINE TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST RECORD BOX -------------------------------------------<br />';
$record2_start = microtime();
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />------------------------- TEST RECORD BOX GLAM-------------------------------------------<br />';
$recordBoxP = new RecordBox();
$recordBox = $recordBoxP->initForPersonalPage($glam);
print "<pre>";
print_r($recordBox);
print "</pre>";
$record2_stop = microtime();
echo '<br />-------------------------FINE TEST RECORD BOX GLAM-------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />------------------------- TEST RECORD BOX CAMERA133-------------------------------------------<br />';
$record3_start = microtime();
$recordBoxP = new RecordBox();
$recordBox = $recordBoxP->initForPersonalPage($camera133);
print "<pre>";
print_r($recordBox);
print "</pre>";
$record3_stop = microtime();
echo '<br />-------------------------FINE TEST RECORD BOX CAMERA133-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST RECORD BOX -------------------------------------------<br />';

$idR = 'b8r9q9b5se';
$record_start = microtime();
echo '<br />TEST  INFO RECORD MEDIA PAGE<br />';
$recordBoxPM = new RecordBox();
$recordBoxMP = $recordBoxPM->initForMediaPage($idR);
print "<pre>";
print_r($recordBoxMP);
print "</pre>";
echo '<br />FINE TEST  INFO RECORD MEDIA PAGE<br />';
$record_stop = microtime();
$idR = 'b8r9q9b5se';
$record_start = microtime();
echo '<br />TEST  INFO RECORD REVIEW UPLOAD PAGE<br />';
$recordBoxPM = new RecordBox();
$recordBoxMP = $recordBoxPM->initForUploadReviewPage($idR);
print "<pre>";
print_r($recordBoxMP);
print "</pre>";
echo '<br />FINE TEST INFO RECORD REVIEW UPLOAD PAGE<br />';
$record_stop = microtime();

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo ultimi 4 record ' . executionTime($record1_start, $record1_stop) . '<br />';
echo 'Tempo ultimi 4 record ' . executionTime($record2_start, $record2_stop) . '<br />';
echo 'Tempo ultimi 4 record ' . executionTime($record3_start, $record3_stop) . '<br />';
echo 'Tempo RECORD PAGINA MEDIA ' . executionTime($record_start, $record_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>