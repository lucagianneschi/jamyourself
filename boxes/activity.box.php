<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento ultime activities dell'utente
 * \details		Recupera le informazioni delle ultime activities dell'utente
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
 * \brief	ActivitySongBox  class 
 * \details	box class to pass info to the view 
 */
class ActivitySongBox {

    public $config;
    public $error = null;
    public $songArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "activityBox.config.json"), false);
    }

    /**
     * \fn	init($id)
     * \brief	Init ActivitySongBox instance for Personal Page
     * \param	$id for user that owns the page
     */
    public function init($id) {
    }

}

/**
 * \brief	ActivityEventBox class 
 * \details	box class to pass info to the view 
 */
class ActivityEventBox {

    public $config;
    public $error = null;
    public $eventArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "activityBox.config.json"), false);
    }

    /**
     * \fn	init($id)
     * \brief	Init ActivityEventBox instance for Personal Page
     * \param	$id for user that owns the page
     */
    public function init($id) {

    }

}

?>