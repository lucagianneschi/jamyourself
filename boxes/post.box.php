<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Post
 * \details		Recupera gli ultimi 3 post attivi (valido per ogni tipologia di utente)
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
 * \brief	PostBox class 
 * \details	box class to pass info to the view for personal page
 */
class PostBox {

    public $config;
    public $error;
    public $postArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "postBox.config.json"), false);
    }

    /**
     * \fn	init($id)
     * \brief	Init PostBox instance for Personal Page
     * \param	$id for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * \return	postBox
     * \todo
     */
    public function init($id, $limit = null, $skip = null) {
	$this->config = null;
	$this->error = null;
	$this->postArray = array();
    }

    /**
     * \fn	initForPersonalPage($id, $limit, $skip, $currentUserId)
     * \brief	Init PostBox instance for Personal Page
     * \param	$id for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * \return	postBox
     * \todo
     */
    public function initForStream($id, $limit) {
	$this->config = null;
	$this->error = null;
	$this->postArray = array();
    }

}

?>