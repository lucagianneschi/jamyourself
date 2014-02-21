<?php

/* ! \par                Info Generali:
 * \author                Luca Gianneschi
 * \version                1.0
 * \date                2013
 * \copyright                Jamyourself.com 2013
 * \par                        Info Classe:
 * \brief                box caricamento review event
 * \details                Recupera le informazioni sulla review dell'event, le inserisce in un array da passare alla view
 * \par                        Commenti:
 * \warning
 * \bug
 * \todo                
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'db.service.php';

/**
 * \brief        ReviewBox class
 * \details        box class to pass info to the view
 */
class ReviewBox {

    public $config;
    public $error = null;
    public $mediaInfo = null;
    public $reviewArray = array();

    /**
     * \fn        initForMediaPage($id, $className, $limit, $skip)
     * \brief        Init ReviewBox instance for Media Page
     * \param        $id of the review to display information, Event or Record class
     * \param   $className, $limit, $skip,$currentUserId
     * \todo        
     */
    public function initForMediaPage($id, $className, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $classNameString = strtolower($className);
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->mediaInfo = $results;
		$this->reviewArray = $results;
	    }
	}
    }

    /**
     * \fn        initForPersonalPage($id, $type, $className)
     * \brief        Init ReviewBox instance for Personal Page
     * \param        $id of the user who owns the page, $type of user, $className Record or Event class
     * \param   $type, $className
     */
    function initForPersonalPage($id, $type, $className, $limit = 3, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {

	    $classNameString = strtolower($className);
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->mediaInfo = $results;
		$this->reviewArray = $results;
	    }
	}
    }

    /**
     * \fn        initForUploadReviewPage($id, $className)
     * \brief        Init REviewBox instance for Upload Review Page
     * \param        $id for the event or record, $className Record or Event
     * \todo    
     */
    public function initForUploadReviewPage($id, $className) {
	require_once SERVICES_DIR . 'utils.service.php';
	$currentUserId = sessionChecker();
	if (is_null($currentUserId)) {
	    $this->errorManagement(ONLYIFLOGGEDIN);
	    return;
	}
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {

	    $classNameString = strtolower($className);
	    $sql = "SELECT * FROM record WHERE user=" . $id . " LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->mediaInfo = $results;
		$this->reviewArray = $results;
	    }
	}
    }

}

?>