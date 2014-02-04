<?php

/**
 * Description of fileManager
 *
 * @author Stefano
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

class FileManagerService {

    private $access = 0777; //diritti di lettura/scrittura
    private $usersFolder = "users";
    private $imagesFolder = "images"; //diritti di lettura/scrittura
    private $songsFolder = "songs"; //diritti di lettura/scrittura
    private $photosFolder = "photos"; //diritti di lettura/scrittura
    private $eventsPhotosFolder = "events"; //diritti di lettura/scrittura
    private $recordsPhotosFolder = "records"; //diritti di lettura/scrittura

////////////////////////////////////////////////////////////////////////////////////////
//
//      Sezione creazione cartelle
//
////////////////////////////////////////////////////////////////////////////////////////

    public function createUserDir($userId) {
        return mkdir(USERS_DIR . $userId, $this->access, true);
    }

    public function createImagesDir($userId) {
        return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder, $this->access, true);
    }

    public function createPhotoDir($userId) {
        return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder, $this->access, true);
    }

    public function createEventPhotoDir($userId) {
        return mkdir(USERS_DIR . $this->usersFolder . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder, $this->access, true);
    }

    public function createRecordPhotoDir($userId) {
        return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder, $this->access, true);
    }

    public function createSongsDir($userId) {
        return mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder, $this->access, true);
    }

////////////////////////////////////////////////////////////////////////////////////////
//
//      GETTERS
//
////////////////////////////////////////////////////////////////////////////////////////

    public function getPhotoURL($userId, $photoId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder . DIRECTORY_SEPARATOR . $photoId;
        $url = SERVER_NAME . "/" . $this->usersFolder . "/" . $userId . "/" . $this->imagesFolder . "/" . $this->photosFolder . "/" . $photoId;

        if (file_exists($path)) {
            return $url;
        } else {
            return "";
        }
    }

    public function getPhotoPath($userId, $photoId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->photosFolder . DIRECTORY_SEPARATOR . $photoId;
        if (file_exists($path)) {
            return $path;
        } else {
            return "";
        }
    }

    public function getSongURL($userId, $songId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder . DIRECTORY_SEPARATOR . $songId;
        $url = SERVER_NAME . "/" . $this->usersFolder . "/" . $userId . "/" . $this->songsFolder . "/" . $songId;

        if (file_exists($path)) {
            return $url;
        } else {
            return "";
        }
    }

    public function getSongPath($userId, $songId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder . DIRECTORY_SEPARATOR . $songId;
        if (file_exists($path)) {
            return $path;
        } else {
            return "";
        }
    }

    public function getEventPhotoPath($userId, $photoId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
        if (file_exists($path)) {
            return $path;
        } else {
            return "";
        }
    }

    public function getEventPhotoURL($userId, $photoId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
        $url = SERVER_NAME . "/" . $this->usersFolder . "/" . $userId . "/" . $this->imagesFolder . "/" . $this->eventsPhotosFolder . "/" . $photoId;
        if (file_exists($path)) {
            return $url;
        } else {
            return "";
        }
    }

    public function getRecordPhotoPath($userId, $photoId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
        if (file_exists($path)) {
            return $path;
        } else {
            return "";
        }
    }

    public function getRecordPhotoURL($userId, $photoId) {
        $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->imagesFolder . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder . DIRECTORY_SEPARATOR . $photoId;
        $url = SERVER_NAME . "/" . $this->usersFolder . "/" . $userId . "/" . $this->imagesFolder . "/" . $this->recordsPhotosFolder . "/" . $photoId;

        if (file_exists($path)) {
            return $url;
        } else {
            return "";
        }
    }

////////////////////////////////////////////////////////////////////////////////////////
//
//      SAVERS
//
////////////////////////////////////////////////////////////////////////////////////////


    public function savePhoto($userId, $photoId) {
        $src = CACHE_DIR.$photoId;
        $dest = USERS_DIR.$userId.DIRECTORY_SEPARATOR.$this->imagesFolder.DIRECTORY_SEPARATOR.$this->photosFolder.DIRECTORY_SEPARATOR.$photoId;
        if(file_exists($src) && $this->checkPhotoDir($userId)){
            return rename($dest, $src);
        }
        
    }

    public function saveEventPhtoto($userId, $photoId) {
        $src = CACHE_DIR.$photoId;
        $dest = USERS_DIR.$userId.DIRECTORY_SEPARATOR.$this->imagesFolder.DIRECTORY_SEPARATOR.$this->eventsPhotosFolder.DIRECTORY_SEPARATOR.$photoId;
        if(file_exists($src) && $this->checkEventPhtotoDir($userId)){
            return rename($dest, $src);
        }        
    }

    public function saveRecordPhoto($userId, $photoId) {
        $src = CACHE_DIR.$photoId;
        $dest = USERS_DIR.$userId.DIRECTORY_SEPARATOR.$this->imagesFolder.DIRECTORY_SEPARATOR.$this->recordsPhotosFolder.DIRECTORY_SEPARATOR.$photoId;
        if(file_exists($src) && $this->checkRecordPhotoDir($userId)){
            return rename($dest, $src);
        }         
    }

    public function saveSong($userId,$songId) {
        $src = CACHE_DIR.$songId;
        $dest = USERS_DIR.$userId.DIRECTORY_SEPARATOR.$this->songsFolder.DIRECTORY_SEPARATOR.$songId;
        if(file_exists($src) && $this->checkSongsDir($userId)){
            return rename($dest, $src);
        }          
    }

////////////////////////////////////////////////////////////////////////////////////////
//
//      CHECKERS
//
////////////////////////////////////////////////////////////////////////////////////////

    private function checkUserDir($userId) {
        if (file_exists(USERS_DIR . $userId))
            return true;
        else {
            return $this->createUserDir($userId);
        }
    }

    private function checkSongsDir($userId) {
        if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->songsFolder))
            return true;
        else
            return $this->createSongsDir($userId);
    }

    private function checkPhotoDir($userId) {
        if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->photosFolder))
            return true;
        else
            return $this->createPhotoDir($userId);
    }

    private function checkEventPhtotoDir($userId) {
        if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->eventsPhotosFolder))
            return true;
        else
            return $this->createEventPhotoDir($userId);
    }

    private function checkRecordPhotoDir($userId) {
        if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . $this->recordsPhotosFolder))
            return true;
        else
            return $this->createRecordPhotoDir($userId);
    }
    
}

?>
