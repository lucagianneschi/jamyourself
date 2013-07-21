<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'validateNewUser.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';

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

        if (!isset($_SESSION['currentUser'])) {
            //dovrei inizializzarlo vuoto... ma il costruttore non  me lo permette.. :(
            $sessionUser = new User("SPOTTER");
            $sessionUser->setType(null);
            $_SESSION['currentUser'] = $sessionUser;
        }
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

//        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser']) ||
//                !isset($_SESSION['recaptcha']) || !$_SESSION['recaptcha']) {
//            $this->response('', 406);
//        }
        //senza captcha:
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }
        //verifico che ci sia il nuovo utente nei paraemtri
        if (!isset($this->request['newUser'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No new user specified");
            $this->response($error, 400);
        }

        //recupero l'utente passato come parametro nella request
        $userJSON = $this->request['newUser'];

        //creo l'oggetto per la validazione dell'utente
        $userValidator = new ValidateNewUserService();

        //verifico la validit� dell'utente
        if ($userValidator->checkUser($userJSON) == false) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "Invalid new user");
            $this->response($error, 400);
        }

        //recupero i campi dell'utente
        switch ($userJSON->type) {
            case "SPOTTER" :
                $newUser = new User("SPOTTER");
                break;
            case "JAMMER" :
                $newUser = new User("JAMMER");
                break;
            case "VENUE" :
                $newUser = new User("VENUE");
                break;
        }

        //uguali per tutti gli utenti
        $newUser->setUsername($userJSON->username);
        $newUser->setPassword($userJSON->password);
        $newUser->setEmail($userJSON->email);

        //differenziazioni
        switch ($userJSON->type) {
            case "SPOTTER" :

                //step 2    
                if (isset($userJSON->firstname) && !_null($userJSON->firstname))
                    $newUser->setFirstname($userJSON->firstname);
                if (isset($userJSON->lastname) && !_null($userJSON->lastname))
                    $newUser->set($userJSON->lastname);
                $newUser->setGeoCoding(geocoder::getLocation($userJSON->location));
                $newUser->set($userJSON->music);
                //step 3
                $newUser->setDescription($userJSON->description);
                $newUser->setSex($userJSON->sex);
                if (isset($userJSON->birthday) && !_null($userJSON->birthday))
                    $newUser->setBirthDay(new DateTime($userJSON->birthday->year . " - " . $userJSON->birthday->month . " - " . $userJSON->birthday->day));
                break;
            case "JAMMER" :
                //step 2
                $newUser->setGeoCoding(geocoder::getLocation($userJSON->location));
                $newUser->setJammerType($userJSON->location);
                if (isset($userJSON->members) && !is_null($userJSON->members)) {
                    $members = array();
                    foreach ($userJSON->members as $member) {
                        $members[] = $member;
                    }
                }
                //step 3
                $newUser->setDescription($userJSON->description);
                $newUser->set($userJSON->music);

                break;
            case "VENUE" :

                //step2
                $venueLocation = $newUser->address . " , " . $newUser->number . " , ";
                $venueLocation .= $newUser->city + "( " . $newUser->province . " ) , ";
                $venueLocation .= $newUser->country;
                $newUser->setGeoCoding(geocoder::getLocation($venueLocation));
                //step 3
                $newUser->setDescription($userJSON->description);
                $newUser->set($userJSON->music);
                break;
        }

        //imposto i parametri social
        if (isset($userJSON->facebookId) && !is_null($userJSON->facebookId))
            $newUser->setFacebookId($userJSON->facebookId);
        if (isset($userJSON->fbPage) && !is_null($userJSON->fbPage))
            $newUser->setFbPage($userJSON->fbPage);
        if (isset($userJSON->twitterPage) && !is_null($userJSON->twitterPage))
            $newUser->setTwitterPage($userJSON->twitterPage);
//        if (isset($userJSON->gmail) && !_null($userJSON->gmail))$newUser->setGmail($userJSON->gmail); //gmail non era previsto nell'utente.... -.-
        if (isset($userJSON->youtubeChannel) && !is_null($userJSON->youtubeChannel))
            $newUser->setYoutubeChannel($userJSON->youtubeChannel);
        if (isset($userJSON->website) && !is_null($userJSON->website))
            $newUser->setWebsite($userJSON->website);


        //tenta di effettuare il salvataggio
        $pUser = new UserParse();
        $user = $pUser->saveUser($newUser);

        if (is_a($user, "Error")) {
            //result è un errore e contiene il motivo dell'errore
            $error = array('status' => "Service Unavailable", "msg" => "Cannot create a new user");
            $this->response($error, 503);
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
        $this->response(array("OK"), 200);
    }

    /**
     * verifica la correttezza del recaptcha inserito, salva in sessione
     * il risultato e risponde  alla chiamata con un codice di conferma 
     * 
     */
    public function recaptcha() {

        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }

        //verifico che ci sia il codice recaptcha nei parametri
        if (!isset($this->request['recaptcha'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No new user specified");
            $this->response($error, 400);
        }

        //da implementare

        $this->response(array("OK"), 200);
    }

    /**
     * 
     * Permette l'upload dell'immagine dell'utente utilizzando un plugin (plupload?)
     * 
     */
    public function uploaProfileImage() {
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }

        //verifico che ci sia il codice recaptcha nei parametri
//        if (!isset($this->request['recaptcha'])) {
//            // If invalid inputs "Bad Request" status message and reason
//            $error = array('status' => "Bad Request", "msg" => "No new user specified");
//            $this->response($error), 400);
//        }
        //da implementare

        $this->response(array("OK"), 200);
    }

    /**
     * Risponde alla chiamata API "checkUsernameExists"
     * In post riceve:
     *              username => lo username di cui si verifica l'esistenza
     */
    public function checkUsernameExists() {
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }

        //verifico che ci sia il nuovo utente nei paraemtri
        if (!isset($this->request['username'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No username specified");
            $this->response($error, 400);
        }

        $username = $this->request['username'];
        //query per la verifica dello username
        $up = new UserParse();
        $up->whereEqualTo("username", $username);
        $res = $up->getCount();

        if (is_a($res, "Error")) {
            //result è un errore e contiene il motivo dell'errore
            $error = array('status' => "Service Unavailable", "msg" => "Cannot create a new user");
            $this->response($error, 503);
        }

        //restituisco $res che assume valori 0 o 1
        $this->response(array($res), 200);
    }

    /**
     * Risponde alla chiamata API "checkEmailExists"
     * In post riceve:
     *              email => l'email di cui si verifica l'esistenza
     */
    public function checkEmailExists() {
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }

        if (!isset($this->request['email'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No username specified");
            $this->response($error, 400);
        }
        $email = $this->request['email'];
        //query per la verifica dell'email
        $up = new UserParse();
        $up->whereEqualTo("email", $email);
        $res = $up->getCount();

        if (is_a($res, "Error")) {
            //result è un errore e contiene il motivo dell'errore
            $error = array('status' => "Service Unavailable", "msg" => "Cannot create a new user");
            $this->response($error, 503);
        }
        //restituisco $res che assume valori 0 o 1
        $this->response(array($res), 200);
    }

}

?>