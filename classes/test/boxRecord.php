<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Box Album
 * \details		Box per mostrare gli ultimi album inseriti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';


$id = 'EfjGDL1hct';
echo '<br />----------------------BOX------------RECORD---------------------------<br />';
$record = new RecordParse();
$record->wherePointer('fromUser', '_User', $id);
$record->setLimit(4);
$record->orderByDescending('updatedAt');
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
	}
    }
}
echo '<br />----------------FINE------BOX------------RECORD---------------------------------<br />';
?>
