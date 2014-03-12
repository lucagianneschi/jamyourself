<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * CollaboratorsBox, box class to pass info to the view
 * Recupera le informazioni del post e le mette in oggetto postBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class CollaboratorsBox {

    public $error = null;
    public $venueArray = array();
    public $jammerArray = array();

    /**
     * Init CollaboratorsBox 
     * @param	$id for user that owns the page
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo implementare $limit e $skip   
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $venueArray = array();
	    $jammerArray = array();
	    $data = getRelatedNodes('user', $id, 'user', 'collaboration');
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

    public $error = null;
    public $followersArray = array();

    /**
     * Init CollaboratorsBox 
     * @param	$id for user that owns the page $limit, $skip
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo implementare $limit e $skip
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $followers = array();
	    $data = getRelatedNodes('user', $id, 'user', 'followers');
	    foreach ($data as $id) {
		$user = selectUsers($id);
		array_push($followers, $user);
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

    public $error = null;
    public $venueArray = array();
    public $jammerArray = array();

    /**
     * Init CollaboratorsBox 
     * @param	$id for user that owns the page $limit, $skip
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo implementare $limit e $skip  
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $venueArray = array();
	    $jammerArray = array();
	    $data = getRelatedNodes('user', $id, 'user', 'following');
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

    public $error = null;
    public $friendsArray = array();

    /**
     * Init FriendsBox 
     * @param	$id for user that owns the page $limit, $skip
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip 
     * @todo implementare $limit e $skip  
     */
    public function init($id, $limit = 3, $skip = 0) {
	try {
	    $followings = array();
	    $data = getRelatedNodes('user', $id, 'user', 'following');
	    foreach ($data as $id) {
		$user = selectUsers($id);
		array_push($followings, $user);
	    }
	    $this->followersArray = $followings;
	} catch (Exception $e) {
	    $this->error = $e->getMessage();
	}
    }

}

?>