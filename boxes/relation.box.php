<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * CollaboratorsBox, box class to pass info to the view
 * Recupera le informazioni degli utenti in collaborazione
 * @author		Luca Gianneschi
 * @author		Daniele Caldelli
 * @author		Maria Laura Fresu
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class CollaboratorsBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di venue
     */
    public $venueArray = array();

    /**
     * @property array Array di jammer
     */
    public $jammerArray = array();

    /**
     * Init CollaboratorsBox 
     * @param	$id for user that owns the page
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo    
     */
    public function init($id, $limit = 100, $skip = 0) {
	try {
	    $venueArray = array();
	    $jammerArray = array();
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    $data = getRelatedNodes($connectionService, 'user', $id, 'user', 'COLLABORATION', $skip, $limit);
		if(count($data) > 0){
		    $users = selectUsers($connection, null, array('id' => $data));
		    foreach ($users as $user) {
			($user->getType() == 'VENUE') ? array_push($venueArray, $user) : array_push($jammerArray, $user);
		    }
		}
	    $this->venueArray = $venueArray;
	    $this->jammerArray = $jammerArray;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

/**
 * FollowersBox class, box class to pass info to the view
 * Recupera le informazioni del post e le mette in oggetto postBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class FollowersBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di followers (jammer/venue - spotter)
     */
    public $followersArray = array();

    /**
     * Init CollaboratorsBox 
     * @param	$id for user that owns the page $limit, $skip
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo 
     */
    public function init($id, $limit = 4, $skip = 0) {
	try {
	    $followers = array();
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    $data = getRelatedNodes($connectionService, 'user', $id, 'user', 'FOLLOWING', $skip, $limit);
		if(count($data) > 0){
			$users = selectUsers($connection, null, array('id' => $data));
			if(!is_array($users)) return $followers;
		    foreach ($users as $user) {
				array_push($followers, $user);
		    }
		}	    
	    $this->followersArray = $followers;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

/**
 * FollowingsBox class, box class to pass info to the view
 * Recupera le informazioni del post e le mette in oggetto postBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class FollowingsBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di venue
     */
    public $venueArray = array();

    /**
     * @property array Array di jammer
     */
    public $jammerArray = array();

    /**
     * Init CollaboratorsBox 
     * @param	$id for user that owns the page $limit, $skip
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo   
     */
    public function init($id, $limit = 100, $skip = 0) {
	try {
	    $venueArray = array();
	    $jammerArray = array();
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    $data = getRelatedNodes($connectionService, 'user', $id, 'user', 'FOLLOWING', $skip, $limit);
		if(count($data) > 0){
		    $users = selectUsers($connection, null, array('id' => $data));
		    foreach ($users as $user) {
			($user->getType() == 'VENUE') ? array_push($venueArray, $user) : array_push($jammerArray, $user);
		    }
		}
	    $this->venueArray = $venueArray;
	    $this->jammerArray = $jammerArray;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

/**
 * FriendsBox class, box class to pass info to the view
 * Recupera le informazioni del post e le mette in oggetto postBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class FriendsBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di frinds (spotter - spotter)
     */
    public $friendsArray = array();

    /**
     * Init FriendsBox 
     * @param	$id for user that owns the page $limit, $skip
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo   
     */
    public function init($id, $limit = 4, $skip = 0) {
	try {
	    $followings = array();
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    $data = getRelatedNodes($connectionService, 'user', $id, 'user', 'FRIENDSHIP', $skip, $limit);
		if(count($data) > 0){
		    $users = selectUsers($connection, null, array('id' => $data));
		    foreach ($users as $user) {
			array_push($followings, $user);
	    }
		}
	    $this->followersArray = $followings;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

?>