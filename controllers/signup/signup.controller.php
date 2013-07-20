<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CONTROLLERS_DIR . 'restController.php';

////////////////////////////////////////////////////////////////////////////////
//
// DEFINIZIONE DELLE FUNZIONI DEL CONTROLLER PER LA REGISTRAZIONE
//  
//////////////////////////////////////////////////////////////////////////////// 

class SignupController extends REST {

    /**
     * Viene chiamata al caircamento della View Signup.php e inizializza 
     * in sessione tutte le informazioni che possono essere necessarie
     * poter essere visualizzata correttamente
     * 
     */
    public function init() {
        
        //inizializzo la sessione
        session_start();

        if (!isset($_SESSION['currentUser']))
            //dovrei inizializzarlo vuoto... ma il costruttore non  me lo permette.. :(
            $sessionUser = new User("SPOTTER");
            $sessionUser->setType(null);
            $_SESSION['currentUser'] = $sessionUser;
        
            //return qualcosa se c'è qualcosa da ritornare...
    }

    /**
     * Effettua l'iscrizione di un utente al sito
     * 
     * ACTION :  POST
     * DATA: tra i parametri mi aspetto un "newUser"
     * 
     */
    public function signup() {

// variabili del metodo       
//        $newUser = null;
//        $pUser = null;
//        $user = null;
//        $activity = null; 
//        $pActivity = null;
                
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }
        
        //verifico che ci sia il nuovo utente nei paraemtri
        if (!isset($this->request['newUser'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No new user specified");
            $this->response($this->json($error), 400);
        }

        //recupero l'utente passato come parametro nella request
        $newUser = $this->request['newUser'];
        
        //verifico la validit� dell'utente
        if ($this->checkUser($newUser) == false) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "Invalid new user");
            $this->response($this->json($error), 400);
        }


        //tenta di effettuare il salvataggio
        $pUser = new UserParse();
        $user = $pUser->saveUser($newUser);

        if (is_a($user, "Error")) {
            //result è un errore e contiene il motivo dell'errore
            $error = array('status' => "Service Unavailable", "msg" => "Cannot create a new user");
            $this->response($this->json($error), 503);
        }

        //se va a buon fine salvo una nuova activity       
        $activity = new Activity();
        $activity->setAccepted(true);
        $activity->setActive(true);
        $activity->setFromUser($user->getObjectId());
        $activity->setRead(true);
        $activity->setStatus("A");
        $activity->setType("SIGNEDUP");
        $activity->setACL(toParseDefaultACL());

        $pActivity = new ActivityParse();
        $pActivity->saveActivity($activity);

        //aggiorno l'oggetto User in sessione
        $_SESSION['currentUser'] = $user;
        //restituire true o lo user....
        $this->response($this->json(array("OK")), 200);
    }
}
?>