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

class AlbumInfo {

    public $commentCounter;
    public $imageCounter;
    public $loveCounter;
    public $shareCounter;
    public $thumbnailCover;
    public $title;

    function __construct($commentCounter, $imageCounter, $loveCounter, $shareCounter, $thumbnailCover, $title) {
	is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
	is_null($imageCounter) ? $this->imageCounter = NODATA : $this->imageCounter = $imageCounter;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class AlbumBox {

    public $albumInfoArray;
    public $albumCounter;

    public function init($objectId) {
	$albumBox = new AlbumBox();
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
		    $albumInfo = new AlbumInfo($commentCounter, $imageCounter, $loveCounter, $shareCounter, $thumbnailCover, $title);
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