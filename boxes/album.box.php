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
require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';
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

    /**
     * \fn	__construct($counters, $imageCounter, $thumbnailCover, $title)
     * \brief	construct for the AlbumInfo class
     * \param	$counters, $imageCounter, $thumbnailCover, $title
     */
    function __construct($counters, $imageCounter, $thumbnailCover, $title) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($imageCounter) ? $this->imageCounter = NODATA : $this->imageCounter = $imageCounter;
	is_null($thumbnailCover) ? $this->thumbnailCover = NODATA : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class ImageInfo {

    public $counters;
    public $description;
    public $filePath;
    public $tags;
    public $thumbnail;

    function __construct($counters, $description,$filePath, $tags, $thumbnail) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($description) ? $this->description = NODATA : $this->description = $description;
	is_null($filePath) ? $this->filePath = NODATA : $this->filePath = $filePath;
	is_null($tags) ? $this->tags = NODATA : $this->tags = $tags;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
    }

}

/**
 * \brief	AlbumBox class 
 * \details	box class to pass info to the view 
 */
class AlbumBox {

    public $albumInfoArray;
    public $albumCounter;
    public $imageArray;
    
    public function initForDetail($objectId) {//id dell'album
	$albumBox = new AlbumBox();
	$albumBox->albumCounter = NULL;
	$albumBox->albumInfoArray = NULL;
	$info = array();

	$image = new ImageParse();
	$image->wherePointer('album', 'Album', $objectId);
	$image->where('active', true);
	$image->setLimit(1000);
	$image->orderByDescending('createdAt');
	$images = $image->getImages();
	if (get_class($images) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $images->getErrorMessage() . '<br/>';
	} else {
	    foreach ($images as $image) {

		$commentCounter = $image->getCommentCounter();
		$loveCounter = $image->getLoveCounter();
		$shareCounter = $image->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $shareCounter);

		$description = $image->getDescription();
		$filePath = $image->getFilePath();
		$tags = $image->getTags();
		$thumbnail = $image->getThumbnail();

		$imageInfo = new ImageInfo($counters, $description, $filePath, $tags, $thumbnail);
		array_push($info, $imageInfo);
	    }
	    $albumBox->imageArray = $info;
	}
    }

    /**
     * \fn	initForPersonalPage($objectId, $type)
     * \brief	Init ActivityBox instance for Personal Page
     * \param	$objectId for user that owns the page
     * \return	albumBox
     */
    public function initForPersonalPage($objectId) {
	$albumBox = new AlbumBox();
	$albumBox->imageArray = NULL;

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