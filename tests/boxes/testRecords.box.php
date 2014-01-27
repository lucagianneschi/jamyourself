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
require_once BOXES_DIR . 'utilsBox.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();

//JAMMER
$SPATAFORA = '7fes1RyY77';
$idRec = 'zTbYqzySea';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RECORD BOX PERSONAL PAGE -------------------------------------------<br />';
echo '<br />------------------------- TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
$record1_start = microtime();
$recordBoxP = new RecordBox();
$recordBoxP->initForPersonalPage($SPATAFORA);
$songs = tracklistGenerator($idRec);
print "<pre>";
print_r($recordBoxP);
print "</pre>";
$record1_stop = microtime();
echo '<br />-------------------------FINE TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST RECORD BOX -------------------------------------------<br />';
$record2_start = microtime();
echo '<br />TEST  INFO RECORD MEDIA PAGE<br />';
$recordBoxP2 = new RecordBox();
$recordBox2 = $recordBoxP2->initForMediaPage($idRec);
print "<pre>";
print_r($recordBox2);
print "</pre>";
echo '<br />FINE TEST  INFO RECORD MEDIA PAGE<br />';
$record2_stop = microtime();
echo '<br />------------------------- TEST UPLOAD RECORD PAGE SPATAFORA-------------------------------------------<br />';
$record4_start = microtime();
$recordBoxP4 = new RecordBox();
$recordBox4 = $recordBoxP4->initForUploadRecordPage($SPATAFORA);
print "<pre>";
print_r($recordBox4);
print "</pre>";
$record4_stop = microtime();
echo '<br />-------------------------FINE TEST UPLOAD RECORD PAGE SPATAFORA-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST TEST METODO INITFORDETAIL-------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo TEST  RECORD BOX PERSONAL PAGE ' . executionTime($record1_start, $record1_stop) . '<br />';
echo 'Tempo TEST  INFO RECORD MEDIA PAGE ' . executionTime($record2_start, $record2_stop) . '<br />';
echo 'Tempo RECORD PAGINA MEDIA ' . executionTime($record4_start, $record4_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>