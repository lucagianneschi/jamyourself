<?php

/* ! \par		Info Generali:
 * \author		Stefano Muscas
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Funzione:
 * \brief		servizio di gestione delle cartelle, valido in fase di creazione e reperimento path e URL
 * \details		
 * \par			Commenti:
 * \warning
 * \bug			
 * \todo		
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

/**
 * \class   FileManagerService
 * \brief   Classe dedicata alla realizzazione delle cartelle, a reperire path di immagini e mp3
 */
class FileManagerService {

    private $access = 0777;
    private $usersFolder = "users";
    private $imagesFolder = "images";
    private $songsFolder = "songs";
    private $photosFolder = "photos";
    private $eventsPhotosFolder = "events";
    private $recordsPhotosFolder = "records";

    /**
     * \fn	createPhotoDir($userId)
     * \brief   crate users/images/photos/images/events/ folder in the filesystem
     * \return  users/USERID/images/events/ dir
     */
    public function createEventPhotoDir($userId) {
	return mkdir(USERS_DIR . $this->usersFolder . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder, $this->access, true);
    }

    /**
     * \fn	createImagesDir($userId)
     * \brief   crate users/images folder in the filesystem
     * \return  users/USERID/images dir
     */
    public function createImagesDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder, $this->access, true);
    }

    /**
     * \fn	createPhotoDir($userId)
     * \brief   crate users/images/photos folder in the filesystem
     * \return  users/USERID/images/photos/ dir
     */
    public function createPhotoDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder, $this->access, true);
    }

    /**
     * \fn	createRecordPhotoDir($userId)
     * \brief   crate  users/USERID/images/records/ folder in the filesystem
     * \return  users/USERID/images/records/ dir
     */
    public function createRecordPhotoDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder, $this->access, true);
    }

    /**
     * \fn	createSongsDir($userId)
     * \brief   crate users/images/photos folder in the filesystem
     * \return  users/USERID/images/records/ dir
     */
    public function createSongsDir($userId) {
	return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder, $this->access, true);
    }

    /**
     * \fn	createUserDir($userId)
     * \brief   crate users/ folder in the filesystem
     * \return  users/USERID dir
     */
    public function createUserDir($userId) {
	return mkdir(USERS_DIR . $userId, $this->access, true);
    }

    /**
     * \fn	getEventPhotoPath($userId, $photoId)
     * \brief   get event cover path
     * \return  path if found
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
     * \fn	getEventPhotoURL($userId, $photoId)
     * \brief   get event photo URL
     * \return  URL if found
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
     * \fn	getPhotoPath($userId, $photoId)
     * \brief   get photo path
     * \return  path if found
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
     * \fn	getPhotoURL($userId, $photoId)
     * \brief   get photo URL
     * \return  URL if found
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
     * \fn	getRecordPhotoPath($userId, $photoId)
     * \brief   get record cover path
     * \return  path if found
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
     * \fn	getRecordPhotoURL($userId, $photoId)
     * \brief   get record photo URL
     * \return  URL if found
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
     * \fn	getSongPath($userId, $songId)
     * \brief   get song path
     * \return  path if found
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
     * \fn	getSongURL($userId, $photoId)
     * \brief   get song URL
     * \return  URL if found
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
     * \fn	savesaveEventPhoto($userId, $photoId)
     * \brief   save photo in the image folder
     */
    public function saveEventPhoto($userId, $photoId) {
	$src = CACHE_DIR . $photoId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($src) && $this->checkEventPhotoDir($userId)) {
	    return rename($dest, $src);
	}
    }

    /**
     * \fn	savePhoto($userId, $photoId)
     * \brief   save photo in the image folder
     */
    public function savePhoto($userId, $photoId) {
	$src = CACHE_DIR . $photoId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($src) && $this->checkPhotoDir($userId)) {
	    return rename($dest, $src);
	}
    }

    /**
     * \fn	saveRecordPhoto($userId, $photoId)
     * \brief   save photo in the image folder
     */
    public function saveRecordPhoto($userId, $photoId) {
	$src = CACHE_DIR . $photoId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
	if (file_exists($src) && $this->checkRecordPhotoDir($userId)) {
	    return rename($dest, $src);
	}
    }

    /**
     * \fn	saveSong($userId, $songId)
     * \brief   save song (mp3) in the songs folder
     */
    public function saveSong($userId, $songId) {
	$src = CACHE_DIR . $songId;
	$dest = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder . DIRECTORY_SEPARATOR . $songId;
	if (file_exists($src) && $this->checkSongsDir($userId)) {
	    return rename($dest, $src);
	}
    }

    /**
     * \fn	checkEventPhotoDir($userId)
     * \brief   check if the images/events/ exists
     */
    private function checkEventPhotoDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder))
	    return true;
	else
	    return $this->createEventPhotoDir($userId);
    }

    /**
     * \fn	checkPhotoDir($userId)
     * \brief   check if the images/photos/ exists
     */
    private function checkPhotoDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->photosFolder))
	    return true;
	else
	    return $this->createPhotoDir($userId);
    }

    /**
     * \fn	checkRecordPhotoDir($userId)
     * \brief   check if the images/record/ exists
     */
    private function checkRecordPhotoDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder))
	    return true;
	else
	    return $this->createRecordPhotoDir($userId);
    }

    /**
     * \fn	checkSongsDir($userId)
     * \brief   check if the songs/ exists
     */
    private function checkSongsDir($userId) {
	if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder))
	    return true;
	else
	    return $this->createSongsDir($userId);
    }
    
        /**
     * \fn	getDomainName()
     * \brief   get domain name
     * \return  domain name
     */
    public function getDomainName(){
        return $_SERVER['SERVER_NAME'];
    }

}

?>
