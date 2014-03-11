<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		0.3
 * @since		2013
 * @copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di mesaggio
 * \details		invia il messaggio e corrispondente activity;legge il messaggio
 * \par			Commenti:
 * @warning
 * @bug
 * @todo		fare API su Wiki, eliminare TODO per invio mail
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';

/**
 * \brief	MessageController class 
 * \details	controller per l'invio di messaggi
 */
class MessageController extends REST {

    public $config;

    /**
     * \fn		construct()
     * \brief   load config file for the controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "messageController.config.json"), false);
    }

    /**
     * \fn	deleteConversation()
     * \brief   private function to delete activity class instance
     * @param   $id
     */
    public function deleteConversation() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $touser = $this->request['toUser'];




	    $this->response(array($controllers['CONVERSATION_DEL']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	message()
     * \brief   save a message an the related activity
     * @todo    testare, possibilità di invio a utenti multipli, controllo della relazione
     */
    public function message() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['toUserType'])) {
		$this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
	    } elseif (!isset($this->request['message'])) {
		$this->response(array('status' => $controllers['NOMESSAGE']), 403);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $toUserId = $this->request['toUser'];
	    $toUserType = $this->request['toUserType'];
	    if (!relationChecker($currentUser->getId(), $currentUser->getType(), $toUserId, $toUserType)) {
		$this->response(array('status' => $controllers['NOSPAM']), 401);
	    }
	    $text = $this->request['message'];
	    if (strlen($text) < $this->config->minMessageSize) {
		$this->response(array('status' => $controllers['SHORTMESSAGE'] . strlen($text)), 406);
	    }
	    require_once CLASSES_DIR . 'comment.class.php';
	    $message = new Comment();
	    $message->setActive(1);
	    $message->setAlbum(null);
	    $message->setCommentcounter(0);
	    $message->setEvent(null);
	    $message->setFromuser($currentUser->getId());
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
	    $message_id = insertComment($message);
	    if ($message_id instanceof Error) {
		$this->response(array('status' => 'NOSAVEMESS'), 503);
	    }
	    $node = createNode('message', $message->getId());
	    if (!$node) {
		$this->response(array('status' => $controllers['NODEERROR']), 503);
	    }
	    global $mail_files;
	    require_once CLASSES_DIR . 'user.class.php';
	    require_once CONTROLLERS_DIR . 'utils.service.php';
	    $user = selectUsers($currentUser);
	    $address = $user->getEmail();
	    $subject = $controllers['SBJMESSAGE'];
	    $html = $mail_files['MESSAGEEMAIL'];
	    sendMailForNotification($address, $subject, $html);
	    $this->response(array($controllers['MESSAGESAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	read()
     * \brief   update activity for the current read message
     * @todo    testare
     */
    public function read() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }

	    $this->response(array($controllers['MESSAGEREAD']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>