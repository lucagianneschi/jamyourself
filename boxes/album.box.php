<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
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
require_once SERVICES_DIR . 'select.service.php';

/**
 * \brief	AlbumBox class 
 * \details	box class to pass info to the view 
 */
class AlbumBox {

    public $albumArray = array();
    public $error = null;
    public $imageArray = array();

    /**
     * \fn	init($id, $limit = 3, $skip = 0, $upload = false)
     * \brief	Init AlbumBox instance for Personal Page or UploadPage
     * \param	$id for user that owns the page, $limit, $skip, $upload
     * \todo    
     */
    public function init($id, $limit = 3, $skip = 0, $upload = false) {
	if ($upload == true) {
	    require_once SERVICES_DIR . 'utils.service.php';
	    $currentUserId = sessionChecker();
	    if (is_null($currentUserId)) {
		$this->error = ONLYIFLOGGEDIN;
		return;
	    }
	}
	$albums = selectAlbums(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($albums instanceof Error) {
	    $this->error = $albums->getErrorMessage();
	}
	$this->albumArray = $albums;
    }

    /**
     * \fn	initForDetail($id $limit - optional, $skip - optional)
     * \brief	Init AlbumBox instance for Personal Page, detailed view
     * \param	$id of the album to display information,$limit, $skip
     * \todo    
     */
    public function initForDetail($id, $limit = 15, $skip = 0) {
	$images = selectImages(null, array('album' => $id), array('createad' => 'DESC'), $limit, $skip);
	if ($images instanceof Error) {
	    $this->error = $images->getErrorMessage();
	}
	$this->imageArray = $images;
    }

}

?>