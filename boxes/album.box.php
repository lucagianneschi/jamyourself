<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * AlbumBox  class 
 * Box class to pass info to the view, Recupera le informazioni degli album dell'utente
 * 
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class AlbumBox {

    /**
     * @property array Array di album
     */
    public $albumArray = array();

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di image
     */
    public $imageArray = array();

    /**
     * Init AlbumBox instance for Personal Page or UploadPage
     * @param	int $id ,for user that owns the page
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip
     * @todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$albums = selectAlbums($connection, null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($albums === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectAlbums"');
	    $this->error = 'Unable to perform selectAlbums';
	}
	$this->albumArray = $albums;
    }

    /**
     * Init AlbumBox instance for Personal Page, detailed view
     * @param	int $id , of the album to display information
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip
     * @todo    
     */
    public function initForDetail($id, $limit = 15, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForDetail "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$images = selectImages($connection, null, array('album' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($images === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForDetail "Unable to perform selectImages"');
	    $this->error = 'Unable to perform selectImages';
	}
	$this->imageArray = $images;
    }

}

?>