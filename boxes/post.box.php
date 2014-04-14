<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * PostBox class, box class to pass info to the view
 * Recupera le informazioni del post e le mette in oggetto postBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class PostBox {

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * @property array Array di post
     */
    public $postArray = array();

    /**
     * Init PostBox instance for Personal Page
     * @param	$id for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip
     */
    public function init($id, $limit = 5, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$posts = selectPosts($connection, null, array('touser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($posts === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectPosts"');
	    $this->error = 'Unable to perform selectPosts';
	}
	$this->postArray = $posts;
    }

    /**
     * Init PostBox instance for Personal Page
     * @param	$id for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * @param   int $limit, number of album to display
     * @param   int $skip, number of album to skip
     */
    public function initForStream($id, $limit = 1, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForStream "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$posts = selectPosts($connection, null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($posts === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during initForStream "Unable to perform selectPosts"');
	    $this->error = 'Unable to perform selectPosts';
	}
	$this->postArray = $posts;
    }

}

?>