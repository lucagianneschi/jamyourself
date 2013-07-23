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
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();

//JAMMER
//$id = 'uMxy47jSjg';//ROSESINBLOOM
//$id = ' HdqSpIhiXo';//Stanis
$id = '7fes1RyY77'; //LDF

$record_start = microtime();
$record = new RecordParse();
$record->wherePointer('fromUser','_User', $id);
$record->where('active', true);
$record->setLimit(1000);
$record->orderByDescending('createdAt');
$resGets = $record->getRecords();
if ($resGets != 0) {
    if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
    } else {
	foreach ($resGets as $record) {
	    echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
	    echo '<br />[title] => ' . $record->getTitle() . '<br />';
	    echo '<br />[loveCounter] => ' . $record->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $record->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $record->getShareCounter() . '<br />';
	    echo '<br />[year] => ' . $record->getYear() . '<br />';
	    echo '<br />[songCounter] => ' . $record->getSongCounter() . '<br />';
	    echo '<br />[genre] => ' . $record->getGenre() . '<br />';
	}
    }
}


$record_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo ultimi 4 record ' . executionTime($record_start, $record_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>