<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * CommentBox class, box class to pass info to the view,
 * Recupera le informazioni del commento e le mette in oggetto commentBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class CommentBox {

    /**
     * @property array Array di comment
     */
    public $commentArray = array();

    /**
     * @property string stringa di errore
     */
    public $error = null;

    /**
     * CommentBox instance all over the website
     * @param   int $id for object that has been commented
     * @param	$className for the instance of the class that has been commented
     * @param   int $limit, number of album to display
     * @param   int $skip, number of comments to skip
     */
    public function init($id, $classname, $limit = DEFAULTQUERY, $skip = 0) {
	$startTimer = microtime();
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to connect"');
	    $this->error = 'Unable to connect';
	}
	$comments = selectComments($connection, null, array($classname => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($comments === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during init "Unable to perform selectComments"');
	    $this->error = 'Unable to perform selectComments';
	}
	$this->commentArray = $comments;
    }

}

?>