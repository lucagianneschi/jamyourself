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
    public $objectId;
    public $thumbnailCover;
    public $title;

    /**
     * \fn	__construct($counters, $imageCounter, $objectId, $thumbnailCover, $title)
     * \brief	construct for the AlbumInfo class
     * \param	$counters, $imageCounter, $objectId, $thumbnailCover, $title
     */
    function __construct($counters, $imageCounter, $objectId, $thumbnailCover, $title) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($imageCounter) ? $this->imageCounter = 0 : $this->imageCounter = $imageCounter;
	is_null($objectId) ? $this->objectId = NODATA : $this->objectId = $objectId;
	is_null($thumbnailCover) ? $this->thumbnailCover = DEFALBUMTHUMB : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	ImageInfo class 
 * \details	contains info for image to be displayed 
 */
class ImageInfo {

    public $counters;
    public $description;
    public $filePath;
    public $location;
    public $objectId;
    public $tags;
    public $thumbnail;

    /**
     * \fn	__construct($counters, $description, $filePath, $location, $objectId, $tags, $thumbnail)
     * \brief	construct for the ImageInfo class
     * \param	$counters, $description, $filePath, $objectId, $tags, $thumbnail
     */
    function __construct($counters, $description, $filePath, $location, $objectId, $tags, $thumbnail) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($description) ? $this->description = NODATA : $this->description = $description;
	is_null($filePath) ? $this->filePath = NODATA : $this->filePath = $filePath;
	is_null($location) ? $this->location = NODATA : $this->location = $location;
	is_null($objectId) ? $this->objectId = NODATA : $this->objectId = $objectId;
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

    /**
     * \fn	initForDetail($objectId)
     * \brief	Init AlbumBox instance for Personal Page, detailed view
     * \param	$objectId of the album to display information
     * \return	albumBox
     */
    public function initForDetail($objectId) {
	$albumBox = new AlbumBox();
	$albumBox->albumCounter = NDB;
	$albumBox->albumInfoArray = NDB;
	$info = array();

	$image = new ImageParse();
	$image->wherePointer('album', 'Album', $objectId);
	$image->where('active', true);
	$image->setLimit(1000);
	$image->orderByDescending('createdAt');
	$images = $image->getImages();
	if (get_class($images) == 'Error') {
	    return $images;
	} else {
	    foreach ($images as $image) {

		$commentCounter = $image->getCommentCounter();
		$loveCounter = $image->getLoveCounter();
		$reviewCounter = NDB;
		$shareCounter = $image->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);

		$encodedDescription = $image->getDescription();
		$description = parse_decode_string($encodedDescription);
		$filePath = $image->getFilePath();
		$location = $image->getLocation();
		$objectId = $image->getObjectId();
		$tags = $image->getTags();
		if (empty($tags)) {
		    $tags = 'NO TAGS TO DISPLAY';
		}
		$thumbnail = $image->getThumbnail();

		$imageInfo = new ImageInfo($counters, $description, $filePath, $location, $objectId, $tags, $thumbnail);
		array_push($info, $imageInfo);
	    }
	    if (empty($info)) {
		$albumBox->imageArray = NODATA;
	    } else {
		$albumBox->imageArray = $info;
	    }
	}
	return $albumBox;
    }

    /**
     * \fn	initForPersonalPage($objectId, $type)
     * \brief	Init AlbumBox instance for Personal Page
     * \param	$objectId for user that owns the page
     * \return	albumBox
     */
    public function initForPersonalPage($objectId) {
	$albumBox = new AlbumBox();
	$albumBox->imageArray = NDB;

	$info = array();
	$counter = 0;
	$album = new AlbumParse();
	$album->wherePointer('fromUser', '_User', $objectId);
	$album->where('active', true);
	$album->setLimit(1000);
	$album->orderByDescending('createdAt');
	$albums = $album->getAlbums();
	if (get_class($albums) == 'Error') {
	    return $albums;
	} else {
	    foreach ($albums as $album) {
		$counter = ++$counter;

		$commentCounter = $album->getCommentCounter();
		$imageCounter = $album->getImageCounter();
		$loveCounter = $album->getLoveCounter();
		$reviewCounter = NDB;
		$shareCounter = $album->getShareCounter();
		$objectId = $album->getObjectId();
		$thumbnailCover = $album->getThumbnailCover();
		$encodedTitle = $album->getTitle();
		$title = parse_decode_string($encodedTitle);

		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$albumInfo = new AlbumInfo($counters, $imageCounter, $objectId, $thumbnailCover, $title);
		array_push($info, $albumInfo);
	    }
	    if (empty($info)) {
		$albumBox->albumInfoArray = NODATA;
	    } else {
		$albumBox->albumInfoArray = $info;
	    }
	    $albumBox->albumCounter = $counter;
	}
	return $albumBox;
    }

}

?>