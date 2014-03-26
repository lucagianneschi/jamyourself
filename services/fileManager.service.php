<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

/**
 * 
 * servizio di gestione delle cartelle, valido in fase di creazione e reperimento path e URL
 * 
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */

/**
 * Classe dedicata alla realizzazione delle cartelle, a reperire path di immagini e mp3
 */
class FileManagerService {

    /**
     * @property int permessi cartella
     */
    private $access = 0777;

    /**
     * @property string nome cartella
     */
    private $usersFolder = "users";

    /**
     * @property string nome cartella
     */
    private $imagesFolder = "images";

    /**
     * @property string nome cartella
     */
    private $songsFolder = "songs";

    /**
     * @property string nome cartella
     */
    private $photosFolder = "photos";

    /**
     * @property string nome cartella
     */
    private $eventsPhotosFolder = "events";

    /**
     * @property string nome cartella
     */
    private $recordsPhotosFolder = "records";

    /**
     * create users/images/photos/images/events/ folder in the filesystem
     * 
     * @return  users/USERID/images/events/ dir
     */
    public function createEventPhotoDir($userId) {
	return mkdir(USERS_DIR .  DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder, $this->access, true);
    }

    /**
     * create users/images folder in the filesystem
     * 
     * @return  users/USERID/images dir
     */
    public function createImagesDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder, $this->access, true);
    }

    /**
     * create users/images/photos folder in the filesystem
     * 
     * @return  users/USERID/images/photos/ dir
     */
    public function createPhotoDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder, $this->access, true);
    }

    /**
     * create  users/USERID/images/records/ folder in the filesystem
     * 
     * @return  users/USERID/images/records/ dir
     */
    public function createRecordPhotoDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder, $this->access, true);
    }

    /**
     * create users/images/photos folder in the filesystem
     * 
     * @return  users/USERID/images/records/ dir
     */
    public function createSongsDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder, $this->access, true);
    }

    /**
     * create users/ folder in the filesystem
     * 
     * @return  users/USERID dir
     */
    public function createUserDir($userId) {
	return mkdir(USERS_DIR . $userId, $this->access, true);
    }

    /**
     * get event cover path
     * 
     * @return  path if found
     */
    public function getEventPhotoPath($userId, $photoId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($path)) {
	    return $path;
	} else {
	    return "";
	}
    }

    /**
     * get domain name
     * 
     * @return  domain name
     */
    public function getDomainName() {
	return $_SERVER['SERVER_NAME'];
    }

    /**
     * get event photo URL
     * 
     * @return  URL if found
     */
    public function getEventPhotoURL($userId, $photoId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	$url = $this->getDomainName() . "/" . $this->usersFolder . "/" . $userId . "/" . $this->imagesFolder . "/" . $this->eventsPhotosFolder . "/" . $photoId;
	if (file_exists($path)) {
	    return $url;
	} else {
	    return "";
	}
    }

    /**
     * get photo path
     * 
     * @return  path if found
     */
    public function getPhotoPath($userId, $photoId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($path)) {
	    return $path;
	} else {
	    return "";
	}
    }

    /**
     * get photo URL
     * 
     * @return  URL if found
     */
    public function getPhotoURL($userId, $photoId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder . DIRECTORY_SEPARATOR . $photoId;
	$url = $this->getDomainName() . "/" . $this->usersFolder . "/" . $userId . "/" . $this->imagesFolder . "/" . $this->photosFolder . "/" . $photoId;
	if (file_exists($path)) {
	    return $url;
	} else {
	    return "";
	}
    }

    /**
     * get record cover path
     * 
     * @return  path if found
     */
    public function getRecordPhotoPath($userId, $photoId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($path)) {
	    return $path;
	} else {
	    return "";
	}
    }

    /**
     * get record photo URL
     * 
     * @return  URL if found
     */
    public function getRecordPhotoURL($userId, $photoId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	$url = $this->getDomainName() . "/" . $this->usersFolder . "/" . $userId . "/" . $this->imagesFolder . "/" . $this->recordsPhotosFolder . "/" . $photoId;

	if (file_exists($path)) {
	    return $url;
	} else {
	    return "";
	}
    }

    /**
     * get song path
     * 
     * @return  path if found
     */
    public function getSongPath($userId, $songId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder . DIRECTORY_SEPARATOR . $songId;
	if (file_exists($path)) {
	    return $path;
	} else {
	    return "";
	}
    }

    /**
     * get song URL
     * 
     * @return  URL if found
     */
    public function getSongURL($userId, $songId) {
	$path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder . DIRECTORY_SEPARATOR . $songId;
	$url = $this->getDomainName() . "/" . $this->usersFolder . "/" . $userId . "/" . $this->songsFolder . "/" . $songId;

	if (file_exists($path)) {
	    return $url;
	} else {
	    return "";
	}
    }

    /**
     * save photo in the image folder
     */
    public function saveEventPhoto($userId, $photoId) {
	$src = CACHE_DIR . $photoId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($src) && $this->checkEventPhotoDir($userId)) {
	    return copy($src, $dest);
	}
    }

    /**
     * save photo in the image folder
     */
    public function savePhoto($userId, $photoId) {
	$src = CACHE_DIR . $photoId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($src) && $this->checkPhotoDir($userId)) {
	    return rename($dest, $src);
	}
    }

    /**
     * save photo in the image folder
     */
    public function saveRecordPhoto($userId, $photoId) {
	$src = CACHE_DIR . $photoId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($src) && $this->checkRecordPhotoDir($userId)) {
	    return rename($dest, $src);
	}
    }

    /**
     * save song (mp3) in the songs folder
     */
    public function saveSong($userId, $songId) {
	$src = CACHE_DIR . $songId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder . DIRECTORY_SEPARATOR . $songId;
	if (file_exists($src) && $this->checkSongsDir($userId)) {
	    return rename($dest, $src);
	}
    }

    /**
     * check if the images/events/ exists
     */
    private function checkEventPhotoDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder))
	    return true;
	else
	    return $this->createEventPhotoDir($userId);
    }

    /**
     * check if the images/photos/ exists
     */
    private function checkPhotoDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->photosFolder))
	    return true;
	else
	    return $this->createPhotoDir($userId);
    }

    /**
     * check if the images/record/ exists
     */
    private function checkRecordPhotoDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder))
	    return true;
	else
	    return $this->createRecordPhotoDir($userId);
    }

    /**
     * check if the songs/ exists
     */
    private function checkSongsDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder))
	    return true;
	else
	    return $this->createSongsDir($userId);
    }

}

?>