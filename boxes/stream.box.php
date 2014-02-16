<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo	        	        
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	StreamBox class
 * \details	box class to pass info to the view for timelinePage
 */
class StreamBox {

    public $activitiesArray;
    public $config;
    public $error;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "streamBox.config.json"), false);
    }

    /**
     * \fn	init
     * \brief	timeline init
     * \param	$limit, $skip
     * \todo
     */
    public function init($limit = DEFAULTQUERY, $skip = null) {
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$currentUser = $_SESSION['currentUser'];
	$this->error = null;
	$this->activitiesArray = array();
    }

    /**
     * \fn	createActivityArray($userType)
     * \brief	private funtion for creating the activity type array based on the user type
     * \param	$userType
     * \todo
     */
    private function createActivityArray($userType) {
	$sharedActivities = $this->config->sharedActivities;
	switch ($userType) {
	    case 'SPOTTER':
		$specificActivities = $this->config->spotterActivities;
		break;
	    case 'VENUE':
		$specificActivities = $this->config->venueActivities;
		break;
	    case 'JAMMER':
		$specificActivities = $this->config->jammerActivities;
		break;
	}
	$actArray = array_merge($sharedActivities, $specificActivities);
	return $actArray;
    }

    /**
     * \fn	errorManagement($errorMessage = null)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessage
     */
    private function errorManagement($errorMessage = null) {
	$this->activitiesArray = array();
	$this->config = null;
	$this->error = $errorMessage;
    }

}
?>