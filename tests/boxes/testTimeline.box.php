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

echo (is_int(MAX))? "INTERO": "NON INTERO";
echo (is_int(MIN))? "INTERO": "NON INTERO";
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'timeline.box.php';
require_once PARSE_DIR . 'parse.php';

echo '<br />------------------------- TEST TIMELINE LDF-------------------------------------------<br />';

$timeline = new TimelineBox();
$timeline->init(10,0);
print "<pre>";
print_r($timeline);
print "</pre>";

?>