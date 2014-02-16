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
require_once SERVICES_DIR . 'connection.service.php';

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
     * \todo    inserire orderby
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
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM album WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->albumArray = $results;
	    }
	}
    }

    /**
     * \fn	initForDetail($id $limit - optional, $skip - optional)
     * \brief	Init AlbumBox instance for Personal Page, detailed view
     * \param	$id of the album to display information,$limit, $skip
     * \todo    inserire orderby
     */
    public function initForDetail($id, $limit = 15, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM image WHERE album=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->imageArray = $results;
	    }
	}
    }

}
?>