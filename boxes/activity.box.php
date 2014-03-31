<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';

/**
 * ActivitySongBox  class 
 * Box class to pass info to the view Recupera le informazioni delle ultime activities dell'utente
 * 
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                Realizzare metodo init
 */
class ActivitySongBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di song
     */
    public $songArray = array();

    /**
     * Init ActivitySongBox instance for Personal Page
     * @param	 int $id for user that owns the page
     */
    public function init($id) {
	
    }

}

/**
 * ActivityEventBox class  class 
 * Box class to pass info to the view Recupera le informazioni delle ultime activities dell'utente
 * 
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                Realizzare metodo init
 */
class ActivityEventBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di event
     */
    public $eventArray = array();

    /**
     * Init ActivityEventBox instance for Personal Page
     * @param	int $id for user that owns the page
     */
    public function init($id) {
	
    }

}

?>