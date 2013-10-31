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
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
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
	global $boxes;
	global $default_img;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($imageCounter) ? $this->imageCounter = 0 : $this->imageCounter = $imageCounter;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($thumbnailCover) ? $this->thumbnailCover = $default_img['DEFALBUMTHUMB'] : $this->thumbnailCover = $thumbnailCover;
	is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
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
	global $boxes;
	global $default_img;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($description) ? $this->description = $boxes['NODATA'] : $this->description = $description;
	is_null($filePath) ? $this->filePath = $boxes['NODATA'] : $this->filePath = $filePath;
	is_null($location) ? $this->location = $boxes['NODATA'] : $this->location = $location;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($tags) ? $this->tags = $boxes['NOTAG'] : $this->tags = $tags;
	is_null($thumbnail) ? $this->thumbnail = $default_img['DEFIMAGETHUMB'] : $this->thumbnail = $thumbnail;
    }

}

/**
 * \brief	AlbumBox class 
 * \details	box class to pass info to the view 
 */
class AlbumBox {

    public $albumInfoArray;
    public $albumCounter;
    public $config;
    public $imageArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/album.config.json"), false);
    }

    /**
     * \fn	initForDetail($objectId)
     * \brief	Init AlbumBox instance for Personal Page, detailed view
     * \param	$objectId of the album to display information
     * \return	albumBox
     */
    public function initForDetail($objectId) {
	require_once CLASSES_DIR . 'image.class.php';
	require_once CLASSES_DIR . 'imageParse.class.php';
	global $boxes;
	$albumBox = new AlbumBox();
	$albumBox->albumCounter = $boxes['NDB'];
	$albumBox->albumInfoArray = $boxes['NDB'];
	$info = array();
	$image = new ImageParse();
	$image->wherePointer('album', 'Album', $objectId);
	$image->where('active', true);
	$image->setLimit($this->config->limitForDetail);
	$image->orderByDescending('createdAt');
	$images = $image->getImages();
	if ($images instanceof Error) {
	    return $images;
	} elseif (is_null($images)) {
	    $albumBox->imageArray = $boxes['NODATA'];
	    return $albumBox;
	} else {
	    foreach ($images as $image) {
		$commentCounter = $image->getCommentCounter();
		$loveCounter = $image->getLoveCounter();
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $image->getShareCounter();
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$encodedDescription = $image->getDescription();
		$description = parse_decode_string($encodedDescription);
		$filePath = $image->getFilePath();
		$location = $image->getLocation();
		$imageId = $image->getObjectId();
		$tags = array();
		if (count($image->getTags()) > 0) {
		    foreach ($image->getTags() as $tag) {
			$tag = parse_decode_string($tag);
			array_push($tags, $tag);
		    }
		}
		$thumbnail = $image->getThumbnail();
		$imageInfo = new ImageInfo($counters, $description, $filePath, $location, $imageId, $tags, $thumbnail);
		array_push($info, $imageInfo);
	    }
	    $albumBox->imageArray = $info;
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
	require_once CLASSES_DIR . 'album.class.php';
	require_once CLASSES_DIR . 'albumParse.class.php';
	global $boxes;
	$albumBox = new AlbumBox();
	$albumBox->imageArray = $boxes['NDB'];
	$info = array();
	$counter = 0;
	$album = new AlbumParse();
	$album->wherePointer('fromUser', '_User', $objectId);
	$album->where('active', true);
	$album->setLimit($this->config->limitForPersonalPage);
	$album->orderByDescending('createdAt');
	$albums = $album->getAlbums();
	if ($albums instanceof Error) {  
	    return $albums;
	} elseif (is_null($albums)) {
	    $albumBox->albumInfoArray = $boxes['NODATA'];
	    $albumBox->albumCounter = $boxes['NODATA'];
	    return $albumBox;
	} else {
	    foreach ($albums as $album) {
		$counter = ++$counter;
		$commentCounter = $album->getCommentCounter();
		$imageCounter = $album->getImageCounter();
		$loveCounter = $album->getLoveCounter();
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $album->getShareCounter();
		$albumId = $album->getObjectId();
		$thumbnailCover = $album->getThumbnailCover();
		$encodedTitle = $album->getTitle();
		$title = parse_decode_string($encodedTitle);
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$albumInfo = new AlbumInfo($counters, $imageCounter, $albumId, $thumbnailCover, $title);
		array_push($info, $albumInfo);
	    }
	    $albumBox->albumInfoArray = $info;
	    $albumBox->albumCounter = $counter;
	}
	return $albumBox;
    }

}

?>