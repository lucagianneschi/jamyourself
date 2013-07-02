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

    /**
     * \fn	string signup($user)
     * \brief	Return the new registred user
     * \return	string
     */
    public function signup($user) {

        //recupero le variabili
        if ($this->checkUser($user) == false)
            return throwError(new Exception("Invalid User"), __CLASS__, __FUNCTION__, func_get_args());

        //tenta di effettuare il salvataggio
        $pUser = new UserParse();
        $user = $pUser->saveUser($user);

        if (is_a($user, "Error")) {
            //result è un errore e contiene il motivo dell'errore
            return $user;
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
        session_start();
        $_SESSION['currentUser'] = $user;
        //restituire true o lo user....
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

?>