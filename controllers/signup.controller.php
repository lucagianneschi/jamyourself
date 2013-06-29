<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

class SignupController {

    private $session;
    private $post;
    private $get;

    function __construct() {
        
    }

    public function signup(User $user) {
        $isValid = true;
        require_once 'CLASSES_DIR' . 'userParse.class.php';

        if (is_null($user) || is_null($user->getType()))
            return throwError(new Exception("Invalid parameter"), __CLASS__, __FUNCTION__, func_get_args());
        //verifica che i parametri dell'utente siano corretti

        $this->post = $_POST;


        //recupero le variabili
        switch ($user->getType()) {
            case "SPOTTER" :
                $isValid = $this->checkSpotter($user);
                break;
            case "JAMMER" :
                $isValid = $this->checkVenue($user);
                break;
            case "VENUE" :
                $isValid = $this->checkJammer($user);
                break;
            default :
                //errore                
                break;
        }

        if ($isValid == false)
            return throwError(new Exception("Invalid User"), __CLASS__, __FUNCTION__, func_get_args());

        //tenta di effettuare il salvataggio
        $pUser = new UserParse();
        $result = $pUser->saveUser($user);

        if (is_a($result, "Error")) {
            //result è un errore e contiene il motivo dell'errore
            return $result;
        }

        $user = $result;
        
        //se va a buon fine salvo una nuova activity
        $this->saveSignupActivity($user->getObjectId());

        //aggiorno l'oggetto User in sessione
        session_start();
        $_SESSION['currentUser'] = $user;
        //restituire true o lo user....
    }
    
    private function checkSpotter($user) {
        //controllo dei parametri specifici per Spotter
    }

    private function checkVenue($user) {
        //controllo dei parametri specifici per Venue
    }

    private function checkJammer($user) {
        //controllo dei parametri specifici per Jammer
    }
    
    private function saveSignupActivity($userId){
        $pActivity = new ActivityParse();
        $activity = new Activity();
        $activity->setFromUser($userId);
        $activity->setType("SIGNUP");
        $pActivity->saveActivity($activity);
    }

}

?>