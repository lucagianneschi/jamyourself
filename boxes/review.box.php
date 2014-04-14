<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * ReviewEventBox class, box class to pass info to the view,
 * Recupera le informazioni del commento e le mette in oggetto commentBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class ReviewEventBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di review
     */
    public $reviewArray = array();

    /**
     * Init ReviewEventBox instance for Media Page
     * @param   int $id for object that has been commented
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip    
     */
    public function initForMediaPage($id, $limit = 3, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForMediaPage "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$reviews = selectComments($connection, null, array('event' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($reviews === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForMediaPage "Unable to perform selectComments"');
	    $this->error = 'Unable to perform selectComments';
	}
	$this->reviewArray = $reviews;
    }

    /**
     * Init ReviewEventBox instance for Personal Page
     * @param   int $id of the user who owns the page,
     * @param   string $type of user
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip    
     */
    function init($id, $type, $limit = 3, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	if ($type == 'SPOTTER') {
	    $reviews = selectReviewEvent($connection, null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	} else {
	    $reviews = selectReviewEvent($connection, null, array('touser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	}
	if ($reviews === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectReviewEvent"');
	    $this->error = 'Unable to perform selectReviewEvent';
	}
	$this->reviewArray = $reviews;
    }

}

/**
 * ReviewRecordBox class, box class to pass info to the view,
 * Recupera le informazioni del commento e le mette in oggetto commentBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class ReviewRecordBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di review
     */
    public $reviewArray = array();

    /**
     * Init ReviewRecordBox instance for Media Page
     * @param   int $id for object that has been commented
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip    
     */
    public function initForMediaPage($id, $limit = 3, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForMediaPage "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$reviews = selectComments($connection, null, array('record' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($reviews === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectComments"');
	    $this->error = 'Unable to perform selectComments';
	}
	$this->reviewArray = $reviews;
    }

    /**
     * Init ReviewRecordBox instance for Personal Page
     * @param   int $id of the user who owns the page,
     * @param   string $type of user
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip    
     */
    function initForPersonalPage($id, $type, $limit = 3, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForPersonalPage "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	if ($type == 'SPOTTER') {
	    $reviews = selectReviewRecord($connection, null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	} else {
	    $reviews = selectReviewRecord($connection, null, array('touser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	}
	if ($reviews === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectReviewRecord"');
	    $this->error = 'Unable to perform selectReviewRecord';
	}
	$this->reviewArray = $reviews;
    }

}

?>