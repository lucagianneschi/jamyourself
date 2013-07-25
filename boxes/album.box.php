<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info album
 * \details		Recupera le informazioni dell'album, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';

class albumInfo {

    public $commentCounter;
    public $imageCounter;
    public $loveCounter;
    public $shareCounter;
    public $thumbnailCover;
    public $title;

    function __construct($commentCounter, $imageCounter, $loveCounter, $shareCounter, $thumbnailCover, $title) {
	$this->commentCounter = $commentCounter;
	$this->imageCounter = $imageCounter;
	$this->loveCounter = $loveCounter;
	$this->shareCounter = $shareCounter;
	$this->thumbnailCover = $thumbnailCover;
	$this->title = $title;
    }

}

class albumBox {

    public $albumInfoArray;
    public $albumCounter;

    public function init($objectId) {
	$albumBox = new albumBox();
	$info = array();
	$counter = 0;
	$album = new AlbumParse();
	$album->wherePointer('fromUser', '_User', $objectId);
	$album->where('active', true);
	$album->setLimit(1000);
	$album->orderByDescending('createdAt');
	$albums = $album->getAlbums();
	if (count($albums) != 0) {
	    if (get_class($albums) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $albums->getErrorMessage() . '<br/>';
	    } else {
		foreach ($albums as $album) {
		    $counter = ++$counter;
		    $commentCounter = $album->getCommentCounter();
		    $imageCounter = $album->getImageCounter();
		    $loveCounter = $album->getLoveCounter();
		    $shareCounter = $album->getShareCounter();
		    $thumbnailCover = $album->getThumbnailCover();
		    $title = $album->getTitle();
		    $albumInfo = new albumInfo($commentCounter, $imageCounter, $loveCounter, $shareCounter, $thumbnailCover, $title);
		    array_push($info, $albumInfo);
		}
		$albumBox->albumInfoArray = $info;
		$albumBox->albumCounter = $counter;
	    }
	}
	return $albumBox;
    }

}

?>
