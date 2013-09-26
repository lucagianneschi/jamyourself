<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di mesaggio
 * \details		invia il messaggio e corrispondente activity;legge il messaggio
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'activity.php';
require_once CLASSES_DIR . 'activityParse.php';
require_once CLASSES_DIR . 'comment.php';
require_once CLASSES_DIR . 'commentParse.php';
require_once CLASSES_DIR . 'user.php';
require_once CLASSES_DIR . 'userParse.php';
require_once CONTROLLERS_DIR . 'restController.php';

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
	$this->config = json_decode(file_get_contents(CONTROLLERS_DIR . "config/message.config.json"), false);
    }

    /**
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
	session_start();
    }

    /**
     * \fn		sendMessage()
     * \brief   save a message an the related activity
     * \todo    usare la sessione
     */
    public function sendMessage() {
	#TODO
	//in questa fase di debug, il fromUser e il toUser sono uguali e passati staticamente
	//questa sezione prima del try-catch dovrà sparire
	$userParse = new UserParse();
	$fromUser = $userParse->getUser($this->request['fromUser']);
	$toUser = $fromUser;

	try {

	    //controllo che la chiamata sia una POST
	    //controllo che l'utente sia loggato: cioè se nella sessione è presente il currentUser 
//        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
//            //codice di errore
//            $this->response('', 406);
//        }
	    if ($this->get_request_method() != "POST") {
		//codice di errore
		$this->response('', 406);
	    }
	    //recupero l'utente che effettua il commento
	    //$currentUser = $_SESSION['currentUser'];

	    if (!isset($this->request['text'])) {
		$error = array('status' => "Bad Request", "msg" => "No message specified");
		$this->response($error, 400);
	    } elseif (!isset($this->request['toUser'])) {
		$error = array('status' => "Bad Request", "msg" => "No toUser specified");
		$this->response($error, 400);
	    } elseif (!isset($this->request['fromUser'])) {
		$error = array('status' => "Bad Request", "msg" => "No fromUser specified");
		$this->response($error, 400);
	    }

	    $text = $_REQUEST['text'];

	    if (strlen($text) < $this->config->minPostSize) {
		$this->response(array("Dimensione messaggio troppo corta | lungh: " . strlen($text)), 200);
	    } elseif (strlen($text) > $this->config->maxPostSize) {
		$this->response(array("Dimensione messaggio troppo lunga | lungh: " . strlen($text)), 200);
	    }

	    $message = new Comment();
	    $message->setActive(true);
	    $message->setAlbum(null);
	    $message->setComment(null);
	    $message->setCommentCounter(0);
	    $message->setCommentators(null);
	    $message->setComments(null);
	    $message->setCounter(0);
	    $message->setEvent(null);
	    $message->setImage(null);
	    $message->setcation(null);
	    $message->setLoveCounter(0);
	    $message->setLovers(null);
	    $message->setOpinions(null);
	    $message->setRecord(null);
	    $message->setShareCounter(0);
	    $message->setStatus(null);
	    $message->setTags(null);
	    $message->setTitle(null);
	    $message->setType('M');
	    $message->setVideo(null);
	    $message->setVote(null);

	    #TODO
	    //$message->setFromUser($currentUser);
	    $message->setFromUser($fromUser->getObjectId());

	    //$userParse = new UserParse();
	    //$toUser = $userParse->getUser($this->request['fromUser']);
	    $message->setToUser($toUser->getObjectId());

	    //imposto i valori per il salvataggio dell'activity collegata al post
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAccepted(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);

	    #TODO
	    //$activity->setFromUser($currentUser);
	    $activity->setFromUser($fromUser->getObjectId());
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRead(false);
	    $activity->setRecord(null);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType('MESSAGESENT');
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);

	    //salvo post
	    $messageParse = new CommentParse();
	    $res = $messageParse->saveComment($message);
	    if (get_class($res) == 'Error') {
		$this->response(array($res), 503);
	    }

	    //salvo activity
	    $activityParse = new ActivityParse();
	    $res = $activityParse->saveActivity($activity);
	    if (get_class($res) == 'Error') {
		$this->response(array($res), 503);
	    }

	    $this->response(array('Your message has been sent'), 200);
	} catch (Exception $e) {
	    $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
	    $this->response($error, 503);
	}
    }

}

?>