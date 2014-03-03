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

    public $error = null;
    public $venueArray = array();
    public $jammerArray = array();

    /**
     * \fn	init($id)
     * \brief	Init CollaboratorsBox 
     * \param	$id for user that owns the page $limit, $skip
     * \todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $venueArray = array();
	    $jammerArray = array();
	    $connectionService = new ConnectionService();
	    $data = $connectionService->curl($query, $params);
	    foreach ($data as $id) {
		$user = selectUsers($id);
		($user->getType() == 'VENUE') ? array_push($venueArray, $user) : array_push($jammerArray, $user);
	    }
	    $this->venueArray = $venueArray;
	    $this->jammerArray = $jammerArray;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

/**
 * \brief	FollowersBox class 
 * \details	box class to pass info to the view for personal page for JAMMER & VENUE 
 */
class FollowersBox {

    public $error = null;
    public $followersArray = array();

    /**
     * \fn	init($id)
     * \brief	Init CollaboratorsBox 
     * \param	$id for user that owns the page $limit, $skip
     * \todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $users = array();
	    $connectionService = new ConnectionService();
	    $data = $connectionService->curl($query, $params);
	    foreach ($data as $id) {
		$user = selectUsers($id);
		array_push($users, $user);
	    }
	    $this->followersArray = $users;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

/**
 * \brief	FollowingsBox class 
 * \details	box class to pass info to the view for personal page for SPOTTER 
 */
class FollowingsBox {

    public $error = null;
    public $venueArray = array();
    public $jammerArray = array();

    /**
     * \fn	init($id)
     * \brief	Init CollaboratorsBox 
     * \param	$id for user that owns the page $limit, $skip
     * \todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $venueArray = array();
	    $jammerArray = array();
	    $connectionService = new ConnectionService();
	    $data = $connectionService->curl($query, $params);
	    foreach ($data as $id) {
		$user = selectUsers($id);
		($user->getType() == 'VENUE') ? array_push($venueArray, $user) : array_push($jammerArray, $user);
	    }
	    $this->venueArray = $venueArray;
	    $this->jammerArray = $jammerArray;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

/**
 * \brief	FriendsBox class 
 * \details	box class to pass info to the view for personal page for SPOTTER 
 */
class FriendsBox {

    public $error = null;
    public $friendsArray = array();

    /**
     * \fn	init($id)
     * \brief	Init CollaboratorsBox 
     * \param	$id for user that owns the page $limit, $skip
     * \todo    
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $users = array();
	    $connectionService = new ConnectionService();
	    $data = $connectionService->curl($query, $params);
	    foreach ($data as $id) {
		$user = selectUsers($id);
		array_push($users, $user);
	    }
	    $this->friendsArray = $users;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

?>