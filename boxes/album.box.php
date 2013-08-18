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
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	AlbumInfo class 
 * \details	contains info for album to be displayed 
 */
class AlbumInfo {

    public $counters;
    public $imageCounter;
    public $thumbnailCover;
    public $title;

    function __construct($counters, $imageCounter, $thumbnailCover, $title) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($imageCounter) ? $this->imageCounter = NODATA : $this->imageCounter = $imageCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	AlbumBox class 
 * \details	box class to pass info to the view 
 */
class AlbumBox {

    public $albumInfoArray;
    public $albumCounter;

    /**
     * \fn	initForPersonalPage($objectId, $type)
     * \brief	Init ActivityBox instance for Personal Page
     * \param	$objectId for user that owns the page
     * \return	albumBox
     */
    public function initForPersonalPage($objectId) {
	$albumBox = new AlbumBox();
	$info = array();
	$counter = 0;
	$album = new AlbumParse();
	$album->wherePointer('fromUser', '_User', $objectId);
	$album->where('active', true);
	$album->setLimit(1000);
	$album->orderByDescending('createdAt');
	$albums = $album->getAlbums();
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

		$counters = new Counters($commentCounter, $loveCounter, $shareCounter);
		$albumInfo = new AlbumInfo($counters, $imageCounter, $thumbnailCover, $title);
		array_push($info, $albumInfo);
	    }
	    $albumBox->albumInfoArray = $info;
	    $albumBox->albumCounter = $counter;
	}
	return $albumBox;
    }

}

?>