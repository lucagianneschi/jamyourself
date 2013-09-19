<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.php';
require_once CLASSES_DIR . 'activityParse.php';
require_once CLASSES_DIR . 'comment.php';
require_once CLASSES_DIR . 'commentParse.php';
require_once CLASSES_DIR . 'user.php';
require_once CLASSES_DIR . 'userParse.php';
require_once CONTROLLERS_DIR . 'restController.php';

class MessageController extends REST {

    public $config;

    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONTROLLERS_DIR . "message/message.config.json"), false);
    }

    public function init() {
        session_start();
    }

	public function readMessage(){
		try{
		
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
		
		//devo controllare che il currentUser sia il toUser
		
		
		
		$activityId = $_REQUEST['activityId'];
		$parseActivity = new ActivityParse();
		$activity = $parseActivity->getActivity($activityId);
		$activity->read = true;
		$parseActivity->saveActivity($activity);
		
		
		
		}catch (Exception $e) {
            $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
            $this->response($error, 503);
        }
	}
	
	
	
	
	
	
	
	
	
	
	
    public function sendMessage() {
        try{
            
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
        } elseif(!isset($this->request['toUser'])){
            $error = array('status' => "Bad Request", "msg" => "No toUser specified");
            $this->response($error, 400);
		} elseif(!isset($this->request['fromUser'])){
            $error = array('status' => "Bad Request", "msg" => "No fromUser specified");
            $this->response($error, 400);
		}
		
		$text = $_REQUEST['text'];
		
        if(strlen($text)<$this->config->minPostSize){
			$this->response(array("Dimensione messaggio troppo corta | lungh: ".strlen($text)), 200);
		} elseif(strlen($text)>$this->config->maxPostSize){
			$this->response(array("Dimensione messaggio troppo lunga | lungh: ".strlen($text)), 200);
		} 
		
		//imposto i valori per il salvataggio del commento
		$cmt = new parseObject('Comment');
		$cmt->active = true;
		$cmt->commentators = null;
		$cmt->comments = null;
		$cmt->counter = 0;
		//$cmt->fromUser = $currentUser;
		$cmt->location = null;
		$cmt->loveCounter = 0;
		$cmt->lovers = null;
		$cmt->opinions = null;
		$cmt->shareCounter = 0;
		$cmt->tags = null;
		$cmt->title = null;
		$cmt->type = 'M';
		$cmt->vote = null;
		
		//imposto i valori per il salvataggio dell'activity collegata al commento
		$activity = new parseObject('Activity');
		$activity->active = true;
		$activity->accepted = true;
		$activity->counter = 0;
		//$activity->fromUser = $currentUser;
		$activity->loveCounter = 0;
		$activity->playlist = null;
		$activity->question = null;
		$activity->read = false;
		$activity->status = 'A';
		
		$parseUser = new UserParse();
		$toUser = $parseUser->getUser($this->request['fromUser']);
	
		$cmt->album =   null;
		$cmt->comment = null;
		$cmt->event =   null;
		$cmt->image =   null;
		$cmt->record =  null;
		$cmt->song =    null;
		$cmt->status =  null;
		$cmt->toUser = $toUser;
		$cmt->video =   null;
		 
	    $activity->album =   null;
		$activity->comment = null;
		$activity->event =   null;
		$activity->image =   null;
		$activity->record =  null;
		$activity->song =    null;
		$activity->status =  null;
		$activity->toUser =  null;
		$activity->type =    'MESSAGESENT';
 		$activity->video =   null;
		
		//salvo commento
		$parseComment = new CommentParse();
		$parseComment->saveComment($cmt);
		//salvo activity
		$parseActivity = new ActivityParse();
		$parseActivity->saveActivity($activity);
		
		//qui va fatto il 
		        //gestione risposta alla view:
        // if (true) {
            // $messaggioDiRispostaSuccesso = "success"; //può essere anche un json con varie informazioni                                       
            // $this->response(array("Commento ricevuto: ".$comment), 200);
        // } else {
            // errore: 200 perché la richiesta è arrivata corretta, ma è successo qualcosa che non va..
            // $this->response(array("Can't save your comment right now"), 200);
        // }
		
		
		$this->response(array('Your message has been sent'), 200);
		}
	catch (Exception $e) {
            $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
            $this->response($error, 503);
        }
    }
}

?>