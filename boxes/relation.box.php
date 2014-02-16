<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Relations
 * \details		Recupera le ultime relazioni per tipologia di utente
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
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	CollaboratorsBox class 
 * \details	box class to pass info to the view for personal page for JAMMER & VENUE 
 */
class CollaboratorsBox {

    public $config;
    public $error = null;
    public $venueArray = array();
    public $jammerArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "relationBox.config.json"), false);
    }

    /**
     * \fn	init($id)
     * \brief	Init CollaboratorsBox 
     * \param	$id for user that owns the page $limit, $skip
     * \todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->jammerArray = $results;
		$this->venueArray = $results;
	    }
	}
    }

}

/**
 * \brief	FollowersBox class 
 * \details	box class to pass info to the view for personal page for JAMMER & VENUE 
 */
class FollowersBox {

    public $config;
    public $error = null;
    public $followersArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "relationBox.config.json"), false);
    }

    /**
     * \fn	init($id)
     * \brief	Init FollowersBox 
     * \param	$id for user that owns the page 
     * \todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->followersArray = $results;

	    }
	}
    }

}

/**
 * \brief	FollowingsBox class 
 * \details	box class to pass info to the view for personal page for SPOTTER 
 */
class FollowingsBox {

    public $config;
    public $error = null;
    public $venueArray = array();
    public $jammerArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "relationBox.config.json"), false);
    }

    /**
     * \fn	init($id)
     * \brief	Init FollowingsBox
     * \param	$id for user that owns the page 
     * \todo    
     */
    public function init($id,$limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->venueArray = $results;
		$this->jammerArray = $results;

	    }
	}
    }

}

/**
 * \brief	FriendsBox class 
 * \details	box class to pass info to the view for personal page for SPOTTER 
 */
class FriendsBox {

    public $config;
    public $error = null;
    public $friendsArray = array();

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "relationBox.config.json"), false);
    }

    /**
     * \fn	init($id)
     * \brief	Init FriendsBox
     * \param	$id for user that owns the page 
     * \todo    
     */
    public function init($id,$limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->friendsArray = $results;
	    }
	}
    }

}

?>