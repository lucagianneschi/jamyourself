<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

class SignupController {
        private $session;
        private $post;
        private $get;
        
        function __construct() {
            $this->session = $_SESSION;
            $this->post = $_POST;
            $this->get = $_GET;
        }

        
    public function signup(User $user) {
        
        if(is_null($user) || is_null($user->getType()))
            throwError (new Exception("Invalid parameter"), __CLASS__, __FUNCTION__, func_get_args());
        //verifica che i parametri dell'utente siano corretti
        
        //tenta di effettuare il salvataggio
        
        //se va a buon fine salvo una nuova activity
        
        //aggiorno l'oggetto User in sessione
        
        //restituire true o lo user....
        
    }

}

?>
