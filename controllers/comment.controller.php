<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');


//qua includere tutti i file necessari
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';


////////////////////////////////////////////////////////////////////////////////
//
// DEFINIZIONE DELLE FUNZIONI DEL CONTROLLER PER I COMMENTI
//  
//////////////////////////////////////////////////////////////////////////////// 
//Domain Name:	socialmusicdiscovering.com


class CommentController extends REST {

    public $config;

    function __construct() {
        parent::__construct();
        //carica il json di configurazione
        $this->config = json_decode(file_get_contents(CONTROLLERS_DIR . "comment/comment.config.json"), false);
    }

    /**
     * Viene chiamata al caircamento della View Signup.php e inizializza 
     * in sessione tutte le informazioni che possono essere necessarie
     * poter essere visualizzata correttamente
     * 
     */
    public function init() {

        //inizializzo la sessione
        session_start();
        //return qualcosa se c'è qualcosa da ritornare...
        //}
    }

    public function comment() {
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
//        $currentUser = $_SESSION['currentUser'];

        //verifico che ci siano i parametri necessari per salvare il commento
        //succpongo serva un commento: comment e il riferimento a cosa è stato commentato: da aggiungere        
        if (!isset($this->request['comment'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No comment specified");
            $this->response($error, 400);
        }
        $comment = $this->request['comment'];
        //valido il commento (cosi vedi anche come usare il JSON di configurazione)
        if(strlen($comment)<$this->config->minCommentSize || strlen($comment)>$this->config->maxCommentSize){
            $this->response(array("Dimensione commento troppo corta | lungh: ".strlen($comment)), 200);  
        }
        
        
        //da implementare la parte in cui si salvano i cmmenti e l'activity relativa


        //gestione risposta alla view:
        if (true) {
            $messaggioDiRispostaSuccesso = "success"; //può essere anche un json con varie informazioni                                       
            $this->response(array("Commento ricevuto: ".$comment), 200);
        } else {
            //errore: 200 perché la richiesta è arrivata corretta, ma è successo qualcosa che non va..
            $this->response(array("Can't save your comment right now"), 200);
        }
                
        
        } catch (Exception $e) {
            //mettere sempre il catch perché se no come risposta arriva
            //tutta la pagina creata in PHP e non si capisce niente
            $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
            $this->response($error, 503);
        }
    }
}

?>