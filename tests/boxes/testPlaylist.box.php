<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		test box caricamento playslit
 * \details		Recupera le informazioni della playlist dell'utente
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
require_once BOXES_DIR . 'playlist.box.php';
require_once PARSE_DIR . 'parse.php';
$i_end = microtime();
echo '<br />------------------------- TEST PLAYLIST BOX SPATAFORA-------------------------------------------<br />';
$t1_start = microtime();
$info1BoxP = new PlaylistBox();
$info1 = $info1BoxP->init('GuUAj83MGH');
$t1_stop = microtime();
print "<pre>";
print_r($info1);
print "</pre>";
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo totale ' . executionTime($t1_start, $t1_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>