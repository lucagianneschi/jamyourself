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
     * ACTION :  GET
     * DATA: non c'è bisogno di inviare nulla
     * 
     */
    public function onLoad() {
        // Verifico che sia una GET altrimenti restituisco un codice di Errore 
        // "Not Acceptable"
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        
        //ad esempio si può inizializzare un utente a NULL
        $_SESSION['currentUser'] = null;
        
        //restituisco messaggio di conferma
        $this->response(array("OK"),200);
    }

    /**
     * Effettua l'iscrizione di un utente al sito
     * 
     * ACTION :  POST
     * DATA: tra i parametri mi aspetto un "newUser"
     * 
     */
    public function signup() {
        
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        //controllo che l'utente sia già collegato
        if(!isset($_SESSION['currentUser'])){
        // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Unauthorized", "msg" => "User already Logged");
            $this->response($this->json($error), 401);
        }
        
        if(!isset($this->request['newUser'])){
          // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No new user specified");
            $this->response($this->json($error), 400);          
        }
        
        //recupero le variabili
        if ($this->checkUser($user) == false){
          // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "Invalid new user");
            $this->response($this->json($error), 400);  
        }
            

        //tenta di effettuare il salvataggio
        $pUser = new UserParse();
        $user = $pUser->saveUser($user);

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

    private function checkUser($user) {
        //controllo dei parametri specifici per Spotter
        //comune a tutti
        if (is_null($user) || !is_a($user, "User") || is_null($user->getEmail()) || is_null($user->getUsername()) ||
                is_null($user->getPassword()) || is_null($user->getCity()) || is_null($user->getCountry()) || is_null($user->getType()))
            return false;

        else {
            switch ($user->getType()) {
                case "VENUE":
                    if (is_null($user->getDescription()) || is_null($user->getLocalType()))
                        return false;

                    break;
                case "JAMMER":
                    if (is_null($user->getJammerType()) || is_null($user->getDescription()) || is_null($user->getMusic()))
                        return false;

                    break;
                default:
                    break;
            }
        }
        return true;
    }

}

////////////////////////////////////////////////////////////////////////////////
//
// ESECUZIONE DELLO SCRIPT 
//  
//////////////////////////////////////////////////////////////////////////////// 

//inizializza la sessione
session_start();

// Initiiate Library
$controller = new SignupController();
$controller->processApi();

?>