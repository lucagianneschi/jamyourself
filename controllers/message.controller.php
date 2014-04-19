<?php

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'select.service.php';
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
		$this -> config = json_decode(file_get_contents(CONFIG_DIR . "messageController.config.json"), false);
	}

	/**
	 * private function to delete activity class instance
	 *
	 * @todo gestione di caso di errore di cancellazione parziale
	 */
	public function deleteConversation() {
		$startTimer = microtime();
		global $controllers;
		try {
			if ($this -> get_request_method() != "POST") {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "No POST action"');
				$this -> response(array('status' => $controllers['NOPOSTREQUEST']), 405);
			} elseif (!isset($_SESSION['id'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "No User in session"');
				$this -> response(array('status' => $controllers['USERNOSES']), 403);
			} elseif (!isset($this -> request['toUser'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "No touser set"');
				$this -> response(array('status' => $controllers['NOTOUSER']), 403);
			}
			$connectionService = new ConnectionService();
			$connection = $connectionService -> connect();
			if ($connection === false) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "Unable to connect"');
				$this -> response(array('status' => $controllers['CONNECTION ERROR']), 403);
			}
			$where = array("touser" => $this -> request['toUser'], "fromuser" => $_SESSION['id']);
			$messages = selectMessages($connection, null, $where);
			if (!$messages) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "Unable to perform selectMessages"');
				$this -> response(array('status' => $controllers['NOSPAM']), 401);
			} elseif (count($messages) > 0) {
				$errors = array();
				foreach ($messages as $messages) {
					$resDelete = delete($connection, 'comment', $messages -> getId());
					if ($resDelete == false) {
						array_push($errors, $messages -> getId());
					}
				}
			}
			if (count($errors) == 0) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] deleteConversation executed');
				$this -> response(array($controllers['CONVERSATION_DEL']), 200);
			} else {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] deleteConversation error');
				$this -> response(array($controllers['CONVERSATION_DEL']), 200);
			}
		} catch (Exception $e) {
			$endTimer = microtime();
			jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during deleteConversation "Exception" => ' . $e -> getMessage());
			$this -> response(array('status' => $e -> getMessage()), 503);
		}
	}

	/**
	 * save a message an the related activity
	 *
	 * @todo    testare, possibilità di invio a utenti multipli, controllo della relazione, notifica
	 */
	public function message() {
		global $controllers;
		$startTimer = microtime();
		try {
			if ($this -> get_request_method() != "POST") {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No POST action"');
				$this -> response(array('status' => $controllers['NOPOSTREQUEST']), 405);
			} elseif (!isset($_SESSION['id'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No User in session"');
				$this -> response(array('status' => $controllers['USERNOSES']), 403);
			} elseif (!isset($this -> request['toUser'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No touser set"');
				$this -> response(array('status' => $controllers['NOTOUSER']), 403);
			} elseif (!isset($this -> request['toUserType'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No tousertype set"');
				$this -> response(array('status' => $controllers['NOTOUSERTYPE']), 403);
			} elseif (!isset($this -> request['message'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "No message text set"');
				$this -> response(array('status' => $controllers['NOMESSAGE']), 403);
			}
			$currentUserId = $_SESSION['id'];
			$currentUserType = $_SESSION['type'];
			$toUserId = $this -> request['toUser'];
			$toUserType = $this -> request['toUserType'];
			$text = $this -> request['message'];
			$connectionService = new ConnectionService();
			$connection = $connectionService -> connect();
			if ($connection === false) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "Unable to connect"');
				$this -> response(array('status' => $controllers['CONNECTION ERROR']), 403);
			}
			if ($currentUserType == 'VENUE' || $currentUserType == 'JAMMER') {
				$relationType = ($toUserType == 'SPOTTER') ? 'FOLLOWING' : 'COLLABORATION';
				$relation = existsRelation($connectionService, 'user', $currentUserId, 'user', $toUserId, $relationType);
			} else {
				$relationType = ($toUserType == 'SPOTTER') ? 'FRIENDSHIP' : 'FOLLOWING';
				$relation = existsRelation($connectionService, 'user', $currentUserId, 'user', $toUserId, $relationType);
			}
			if (!$relation) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "someone trying to spam"');
				$this -> response(array('status' => $controllers['NOSPAM']), 401);
			}
			if (strlen($text) < $this -> config -> minMessageSize) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "message too short"');
				$this -> response(array('status' => $controllers['SHORTMESSAGE'] . strlen($text)), 406);
			}
			require_once CLASSES_DIR . 'comment.class.php';
			$message = new Comment();
			$message -> setActive(1);
			$message -> setAlbum(null);
			$message -> setCommentcounter(0);
			$message -> setEvent(null);
			$message -> setFromuser($currentUserId);
			$message -> setImage(null);
			$message -> setLatitude(null);
			$message -> setLongitude(null);
			$message -> setLovecounter(0);
			$message -> setSharecounter(0);
			$message -> setText($text);
			$message -> setTitle(null);
			$message -> setTouser($toUserId);
			$message -> setType('M');
			$message -> setVideo(null);
			$message -> setVote(null);
			$resMess = insertComment($connection, $message);
			$message1 = new Comment();
			$message1 -> setActive(1);
			$message1 -> setAlbum(null);
			$message1 -> setCommentcounter(0);
			$message1 -> setEvent(null);
			$message1 -> setFromuser($toUserId);
			$message1 -> setImage(null);
			$message1 -> setLatitude(null);
			$message1 -> setLongitude(null);
			$message1 -> setLovecounter(0);
			$message1 -> setSharecounter(0);
			$message1 -> setText($text);
			$message1 -> setTitle(null);
			$message1 -> setTouser($currentUserId);
			$message1 -> setType('M');
			$message1 -> setVideo(null);
			$message1 -> setVote(null);
			$connection -> autocommit(false);
			$connectionService -> autocommit(false);
			$resMess1 = insertComment($connection, $message);
			if ($resMess === false || $resMess1 === false) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "unable to perform insertComment"');
				$this -> response(array('status' => $controllers['COMMENTERR']), 503);
			} else {
				$connection -> commit();
				$connectionService -> commit();
			}			
			global $mail_files;
			require_once CLASSES_DIR . 'user.class.php';
			$users = selectUsers($connection, $currentUserId);
			if($users === false){
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "unable to perform selectUsers"');
				$this -> response(array('status' => $controllers['COMMENTERR']), 503);
			}
			else{
				$connection -> commit();
				$connectionService -> commit();
			}
			$user = $users[$currentUserId];
			$address = $user -> getEmail();
			$subject = $controllers['SBJMESSAGE'];
			$html = $mail_files['MESSAGEEMAIL'];
			sendMailForNotification($address, $subject, $html);
			$endTimer = microtime();
			$connectionService -> disconnect($connection);
			jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] message executed');
			$this -> response(array($controllers['MESSAGESAVED']), 200);
		} catch (Exception $e) {
			$endTimer = microtime();
			jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during message "Exception" => ' . $e -> getMessage());
			$this -> response(array('status' => $e -> getMessage()), 503);
		}
	}

	/**
	 * update activity for the current read message
	 *
	 * @todo    testare e settare la notifica
	 */
	public function read() {
		$startTimer = microtime();
		global $controllers;
		try {
			if ($this -> get_request_method() != "POST") {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "No POST action"');
				$this -> response(array('status' => $controllers['NOPOSTREQUEST']), 405);
			} elseif (!isset($_SESSION['id'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "No User in session"');
				$this -> response(array('status' => $controllers['USERNOSES']), 403);
			} elseif (!isset($this -> request['id'])) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "No message id set"');
				$this -> response(array('status' => $controllers['NOOBJECTID']), 403);
			}
			$userId = $this -> request['id'];
			$messageId = $this -> request['messageId'];
			$connectionService = new ConnectionService();
			$connection = $connectionService -> connect();
			if ($connection === false) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "Unable to connect"');
				$this -> response(array('status' => $controllers['CONNECTION ERROR']), 403);
			}
			$connection -> autocommit(false);
			$connectionService -> autocommit(false);
			$read = update($connection, 'comment', array('updatedat' => date('Y-m-d H:i:s'), 'read' => 1), null, null, $messageId);
			if ($read === false) {
				$endTimer = microtime();
				jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "Unable to update"');
				$this -> response(array('status' => $controllers['COMMENTERR']), 503);
			} else {
				$connection -> commit();
				$connectionService -> commit();
			}
			$connectionService -> disconnect($connection);
			$endTimer = microtime();
			jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] read executed');
			$this -> response(array($controllers['MESSAGEREAD']), 200);
		} catch (Exception $e) {
			$endTimer = microtime();
			jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during read "Exception" => ' . $e -> getMessage());
			$this -> response(array('status' => $e -> getMessage()), 503);
		}
	}

}
?>