<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * MessageController class 
 * invia il messaggio e corrispondente relation;legge il messaggio
 * 
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2014-03-17
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class MessageController extends REST {

    public $config;

    /**
     * load config file for the controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "messageController.config.json"), false);
    }

    /**
     * private function to delete activity class instance
     */
    public function deleteConversation() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "No POST action"');
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "No User in session"');
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "No touser set"');
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $currentUser = $_SESSION['id'];
	    $touser = $this->request['toUser'];

	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] deleteConversation executed');
	    $this->response(array($controllers['CONVERSATION_DEL']), 200);
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * save a message an the related activity
     * 
     * @todo    testare, possibilità di invio a utenti multipli, controllo della relazione
     */
    public function message() {
	global $controllers;
	$startTimer = microtime();
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No POST action"');
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No User in session"');
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No touser set"');
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No tousertype set"');
		$this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
	    } elseif (!isset($this->request['message'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No message text set"');
		$this->response(array('status' => $controllers['NOMESSAGE']), 403);
	    }
	    $currentUserId = $_SESSION['id'];
	    $currentUserType = $_SESSION['type'];
	    $toUserId = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    $text = $this->request['message'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    if ($currentUserType == 'VENUE' || $currentUserType == 'VENUE') {
		$relationType = ($toUserType == 'SPOTTER') ? 'FOLLOWING' : 'COLLABORATION';
		$relation = existsRelation($connectionService, 'user', $currentUserId, 'user', $toUserId, $relationType);
	    } else {
		$relation = existsRelation($connectionService, 'user', $currentUserId, 'user', $toUserId, 'friendship');
	    }
	    if (!$relation) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "someone trying to spam"');
		$this->response(array('status' => $controllers['NOSPAM']), 401);
	    }
	    if (strlen($text) < $this->config->minMessageSize) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "message too short"');
		$this->response(array('status' => $controllers['SHORTMESSAGE'] . strlen($text)), 406);
	    }
	    require_once CLASSES_DIR . 'comment.class.php';
	    $message = new Comment();
	    $message->setActive(1);
	    $message->setAlbum(null);
	    $message->setCommentcounter(0);
	    $message->setEvent(null);
	    $message->setFromuser($currentUserId);
	    $message->setImage(null);
	    $message->setLatitude(null);
	    $message->setLongitude(null);
	    $message->setLovecounter(0);
	    $message->setSharecounter(0);
	    $message->setText($text);
	    $message->setTitle(null);
	    $message->setTouser($toUserId);
	    $message->setType('M');
	    $message->setVideo(null);
	    $message->setVote(null);
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $resMess = insertComment($connection, $message);
	    if ($resMess === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "unable to perform insertComment"');
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    global $mail_files;
	    require_once CLASSES_DIR . 'user.class.php';
	    require_once CONTROLLERS_DIR . 'utils.service.php';
	    $user = selectUsers($currentUserId);
	    $address = $user->getEmail();
	    $subject = $controllers['SBJMESSAGE'];
	    $html = $mail_files['MESSAGEEMAIL'];
	    sendMailForNotification($address, $subject, $html);
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] message executed');
	    $this->response(array($controllers['MESSAGESAVED']), 200);
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * update activity for the current read message
     * 
     * @todo    testare
     */
    public function read() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "No POST action"');
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "No User in session"');
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "No message id set"');
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }
	    $userId = $this->request['id'];
	    $messageId = $this->request['messageId'];
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $read = update($connection, 'comment', array('updatedat' => date('Y-m-d H:i:s'), 'read' => 1), null, null, $messageId);
	    if ($read === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "Unable to update"');
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] read executed');
	    $this->response(array($controllers['MESSAGEREAD']), 200);
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>