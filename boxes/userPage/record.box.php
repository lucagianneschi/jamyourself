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
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';

class RecordInfo {

    public $commentCounter;
    public $genre;
    public $loveCounter;
    public $shareCounter;
    public $songCounter;
    public $thumbnailCoverCover;
    public $title;
    public $year;

    function __construct($commentCounter, $genre, $loveCounter, $shareCounter, $songCounter, $thumbnailCover, $title, $year) {
	is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
	is_null($genre) ? $this->genre = NODATA : $this->genre = $genre;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($songCounter) ? $this->songCounter = NODATA : $this->songCounter = $songCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
	is_null($year) ? $this->year = NODATA : $this->year = $year;
    }

}

class RecordBox {

    public $recordInfoArray;
    public $recordCounter;

    public function init($objectId) {
	$recordBox = new RecordBox();
	$info = array();
	$counter = 0;
	$record = new RecordParse();
	$record->wherePointer('fromUser','_User', $objectId);
	$record->where('active', true);
	$record->setLimit(1000);
	$record->orderByDescending('createdAt');
	$records = $record->getRecords();
	if ($records != 0) {
	    if (get_class($records) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $records->getErrorMessage() . '<br/>';
	    } else {
		foreach ($records as $record) {
		    $counter = ++$counter;

		    $commentCounter = $record->getCommentCounter();
		    $genre = $record->getGenre();
		    $loveCounter = $record->getLoveCounter();
		    $shareCounter = $record->getShareCounter();
		    $songCounter = $record->getSongCounter();
		    $thumbnailCover = $record->getThumbnailCover();
		    $title = $record->getTitle();
		    $year = $record->getYear();
		    $recordInfo = new RecordInfo($commentCounter, $genre, $loveCounter, $shareCounter, $songCounter, $thumbnailCover, $title, $year);
		    array_push($info, $recordInfo);
		}
		$recordBox->recordInfoArray = $info;
		$recordBox->recordCounter = $counter;
	    }
	}
	return $recordBox;
    }

}

?>