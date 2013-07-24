<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		sistemare il campo featuring	
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';


class recordBox {

    public function sendInfo($objectId) {
	$resultArray = array();
	$record = new RecordParse();
	$record->wherePointer('fromUser','_User', $objectId);
	$record->where('active', true);
	$record->setLimit(1000);
	$record->orderByDescending('createdAt');
	$resGets = $record->getRecords();
	if ($resGets != 0) {
	    if (get_class($resGets) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
	    } else {
		foreach ($resGets as $record) {
		    $thumbnailCover = $record->getThumbnailCover();
		    $title = $record->getTitle();
		    $loveCounter = $record->getLoveCounter();
		    $commentCounter = $record->getCommentCounter();
		    $shareCounter = $record->getShareCounter();
		    $year = $record->getYear();
		    $songCounter = $record->getSongCounter();
		    $genre = $record->getGenre();
		    $recordInfo = array('thumbnailCover' => $thumbnailCover,
			'title' => $title,
			'loveCounter' => $loveCounter,
			'commentCounter' => $commentCounter,
			'shareCounter' => $shareCounter,
			'year' => $year,
			'songCounter' => $songCounter,
			'genre' => $genre);
		    array_push($resultArray,$recordInfo);
		}
	    }
	}
	return $resultArray;
    }

}

?>
