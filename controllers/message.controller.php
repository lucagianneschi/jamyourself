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
require_once ROOT_DIR . 'string.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'utils.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once DEBUG_DIR . 'debug.php';

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
	//in questa fase di debug, il fromUser lo passo staticamente e non lo recupero dalla session
	//questa sezione prima del try-catch dovrà sparire
	$fromUser = new User('SPOTTER');
	$fromUser->setObjectId('GuUAj83MGH');

	try {

	    //controllo la richiesta
	    //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != "POST") {
		$this->response('', 406);
	    }

	    //recupero l'utente che effettua il commento
	    //$currentUser = $_SESSION['currentUser'];
	    //controllo i parametri
	    if (!isset($this->request['text'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOMESSAGE']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSER']), 400);
	    } elseif (!isset($this->request['fromUser'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOFROMUSER']), 400);
	    }

	    $text = $_REQUEST['text'];
	    $toUserObjectId = $this->request['toUser'];
	    $fromUserObjectId = $this->request['fromUser'];

	    if (strlen($text) < $this->config->minMessageSize) {
		$this->response(array($controllers['SHORTMESSAGE'] . strlen($text)), 200);
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
	    $encodedText = parse_encode_string($text);
	    $message->setText($encodedText);
	    $message->setTitle(null);
	    $message->setType('M');
	    $message->setVideo(null);
	    $message->setVote(null);

	    #TODO
	    //$message->setFromUser($currentUser);
	    $message->setFromUser($fromUserObjectId);

	    //$userParse = new UserParse();
	    //$toUser = $userParse->getUser($this->request['fromUser']);
	    $message->setToUser($toUserObjectId);

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
	    $activity->setToUser($toUserObjectId);
	    $activity->setType('MESSAGESENT');
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);

	    //salvo post
	    $commentParse = new CommentParse();
	    $resCmt = $commentParse->saveComment($message);
	    if (get_class($resCmt) == 'Error') {
		$this->response(array($resCmt), 503);
	    } else {
		//salvo activity
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if (get_class($resActivity) == 'Error') {
		    $this->rollback($resCmt->getObjectId());
		}
	    }
	    $this->response(array($controllers['MESSAGESAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    private function rollback($objectId) {
	$commentParse = new CommentParse();
	$res = $commentParse->deleteComment($objectId);
	if (get_class($res) == 'Error') {
	    $this->response(array($controllers['ROLLKO']), 503);
	} else {
	    $this->response(array($controllers['ROLLOK']), 503);
	}
    }

}

?>