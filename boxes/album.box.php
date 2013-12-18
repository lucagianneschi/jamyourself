<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box caricamento info album * \details		Recupera le informazioni dell'album, le inserisce in un array da passare alla view * \par			Commenti: * \warning * \bug * \todo		 * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';/** * \brief	AlbumBox class  * \details	box class to pass info to the view  */class AlbumBox {    public $albumArray;    public $config;    public $error;    public $imageArray;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/album.config.json"), false);    }    /**     * \fn	initForPersonalPage($objectId, $type)     * \brief	Init AlbumBox instance for Personal Page     * \param	$objectId for user that owns the page, $type     * \todo         */    public function init($objectId, $limit = null, $skip = null) {        require_once CLASSES_DIR . 'albumParse.class.php';        $this->imageArray = array();        $album = new AlbumParse();        $album->wherePointer('fromUser', '_User', $objectId);        $album->where('active', true);        $album->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : DEFAULTQUERY);        $album->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);        $album->orderByDescending('createdAt');        $albums = $album->getAlbums();        if ($albums instanceof Error) {            $this->errorManagement($albums->getErrorMessage());            return;        } elseif (is_null($albums)) {            $this->errorManagement();            return;        } else {            $this->error = null;            $this->albumArray = $albums;        }    }    /**     * \fn	initForDetail($objectId $limit - optional, $skip - optional)     * \brief	Init AlbumBox instance for Personal Page, detailed view     * \param	$objectId of the album to display information      */    public function initForDetail($objectId, $limit = null, $skip = null, $updatedAt = false) {        require_once CLASSES_DIR . 'imageParse.class.php';        $this->albumArray = array();        $imagesArray = array();        $image = new ImageParse();        $image->wherePointer('album', 'Album', $objectId);        $image->where('active', true);        $image->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);        if ($updatedAt == false) {            $image->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitForDetail);            $image->orderByDescending('createdAt');        } else {            $image->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitForActivityBox);            $image->orderByDescending('updatedAt');            $image->whereInclude('album');        }        $images = $image->getImages();        if ($images instanceof Error) {            $this->errorManagement($images->getErrorMessage());            return;        } elseif (is_null($images)) {            $this->errorManagement();            return;        } else {            foreach ($images as $image) {                if (!is_null($image->getAlbum()))                    array_push($imagesArray, $image);            }            $this->error = null;            $this->imageArray = $imagesArray;        }    }    /**     * \fn	initForUploadRecordPage($objectId)     * \brief	init for recordBox for upload record page     * \param	$objectId of the user who owns the record     */    public function initForUploadAlbumPage() {        require_once BOXES_DIR . 'utilsBox.php';        $currentUserId = sessionChecker();        if (is_null($currentUserId)) {            $this->errorManagement(ONLYIFLOGGEDIN);            return;        }        $album = new AlbumParse();        $album->wherePointer('fromUser', '_User', $currentUserId);        $album->where('active', true);        $album->setLimit($this->config->limitAlbumForUploadPage);        $album->orderByDescending('createdAt');        $albums = $album->getAlbums();        if ($albums instanceof Error) {            $this->errorManagement($albums->getErrorMessage());            return;        } elseif (is_null($albums)) {            $this->errorManagement();            return;        } else {            $this->error = null;            $this->albumArray = $albums;        }    }    /**     * \fn	errorManagement($errorMessage = null)     * \brief	set values in case of error or nothing to send to the view     * \param	$errorMessage     */    private function errorManagement($errorMessage = null) {        $this->albumArray = array();        $this->config = null;        $this->error = $errorMessage;        $this->imageArray = array();    }}?>