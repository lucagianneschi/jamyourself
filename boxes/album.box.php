<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		0.3
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info album
 * \details		Recupera le informazioni dell'album, le inserisce in un array da passare alla view
 * \par			Commenti:
 * @warning
 * @bug
 * @todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';

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
     * @var array Array di album
     */
    public $albumArray = array();

    /**
     * @var string stringa di errore
     */
    public $error = null;

    /**
     * @var array Array di image
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
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$albums = selectAlbums($connection, null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($albums === false) {
	    $this->error = 'Errore nella query';
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
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$images = selectImages($connection, null, array('album' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($images === false) {
	    $this->error = 'Errore nella query';
	}
	$this->imageArray = $images;
    }

}

?>