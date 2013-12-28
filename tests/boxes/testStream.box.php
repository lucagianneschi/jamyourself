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
require_once BOXES_DIR . 'stream.box.php';
require_once BOXES_DIR . 'event.box.php';
require_once BOXES_DIR . 'record.box.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'userParse.class.php';

//$t_start = microtime();
//$userP = new UserParse();
//$userP->whereNearSphere(43, 10);
//$userP->setLimit(10);
//$userP->getUsers();
//$t_stop = microtime(); //timer tempo totale
//echo 'Tempo totale ' . executionTime($t_start, $t_stop) . '<br />';


echo '<br />------------------------- TEST TIMELINE LDF-------------------------------------------<br />';
echo '<br />------------------------- EVENTFILTER-------------------------------------------------<br />';
$t_start = microtime(); //timer tempo totale
$eventFilter = new EventBox();
$eventFilter->initForStream(array(), 'Viareggio');
$t_stop = microtime(); //timer tempo totale
echo 'Tempo totale ' . executionTime($t_start, $t_stop) . '<br />';
print "<pre>";
print_r($eventFilter);
print "</pre>";
echo count($eventFilter->eventArray);

echo '<br />------------------------- RECORDFILTER-------------------------------------------------<br />';
$t_start = microtime(); //timer tempo totale
$recordFilter = new RecordBox();
$recordFilter->initForStream(array(), null, null, array('Uncatogorized', 'Rock'));
$t_stop = microtime(); //timer tempo totale
echo 'Tempo totale ' . executionTime($t_start, $t_stop) . '<br />';
print "<pre>";
print_r($recordFilter);
print "</pre>";
echo count($recordFilter->recordArray);

echo '<br />------------------------- STREAM-------------------------------------------------<br />';
$t_start = microtime(); //timer tempo totale
$timeline = new StreamBox();
$timeline->init(10, 0);
$t_stop = microtime(); //timer tempo totale
echo 'Tempo totale ' . executionTime($t_start, $t_stop) . '<br />';
print "<pre>";
print_r($timeline);
print "</pre>";
echo count($timeline->activitesArray);


?>