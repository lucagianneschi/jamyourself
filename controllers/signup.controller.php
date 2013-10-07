<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'validateNewUser.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'recaptcha.lib.php';
////////////////////////////////////////////////////////////////////////////////
//
// DEFINIZIONE DELLE FUNZIONI DEL CONTROLLER PER LA REGISTRAZIONE
//  
//////////////////////////////////////////////////////////////////////////////// 
//Domain Name:	socialmusicdiscovering.com
define("CAPTCHA_PUBLIC_KEY", "6LfMnNcSAAAAABls9QS4oPvL86A0RzstkhSFWKud");
define("CAPTCHA_PRIVATE_KEY", "6LfMnNcSAAAAAKYZCjSxFXMpTTYeclVzAsuke0Vu");

class SignupController extends REST {

    private $config;
    private $userValidator;

    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONTROLLERS_DIR . "config/signup.config.json"), false);
        $this->userValidator = new ValidateNewUserService($this->config);
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

//        if (!isset($_SESSION['currentUser'])) { @Per il test
        //dovrei inizializzarlo vuoto... ma il costruttore non  me lo permette.. :(
        $sessionUser = new User("SPOTTER");
        $sessionUser->setType(null);
        $_SESSION['currentUser'] = $sessionUser;

        //passo la chiave pubblica del captcha qua
        $_SESSION['captchaPublicKey'] = CAPTCHA_PUBLIC_KEY;
        $_SESSION['captchaValidation'] = false;
        $_SESSION['config'] = $this->config;

        //return qualcosa se c'è qualcosa da ritornare...
        //}
    }

    /**
     * Effettua l'iscrizione di un utente al sito
     * 
     * ACTION :  POST
     * DATA: tra i parametri mi aspetto un "newUser"
     * 
     */
    public function signup() {
        try {
//con captcha:
//        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser']) ||
//                !isset($_SESSION['recaptcha']) || !$_SESSION['recaptcha']) {
//            $this->response('', 406);
//        }
//senza captcha:
            if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
                $this->response('', 406);
            }

            //verifico che l'utente abbia effettivamente completato il captcha
//        if ($_SESSION['captchaValidation'] == false) {
//            // If invalid inputs "Bad Request" status message and reason
//            $error = array('status' => "Bad Request", "msg" => "Captcha test failed");
//            $this->response($error, 400);
//        }
            //recupero l'utente passato come parametro nella request
            $userJSON = $this->request;

            //effetuo la validazione dell'utente
            $this->userValidator->checkNewUser($userJSON);
            if (!$this->userValidator->getIsValid()) {
                // If invalid inputs "Bad Request" status message and reason
                $error = array('status' => "Bad Request", "msg" => "Invalid new user");
                $this->response($error, 400);
            }


            //recupero i campi dell'utente
            $newUser = json_decode(json_encode($userJSON), false);
            switch ($newUser->type) {
                case "SPOTTER" :
                    $newUser = $this->createSpotter($newUser);
                    break;
                case "JAMMER" :
                    $newUser = $this->createJammer($newUser);
                    break;
                case "VENUE" :
                    $newUser = $this->createVenue($newUser);
                    break;
            }

            //tenta di effettuare il salvataggio
            $pUser = new UserParse();
            $user = $pUser->saveUser($newUser);

            if (is_a($user, "Error")) {
                //result è un errore e contiene il motivo dell'errore
                $error = array('status' => "Service Unavailable", "msg" => $user->getErrorMessage());
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
            
        } catch (Exception $e) {
            $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
            $this->response($error, 503);
        }
    }

    /**
     * verifica la correttezza del recaptcha inserito, salva in sessione
     * il risultato e risponde  alla chiamata con un codice di conferma 
     * 
     */
    public function recaptcha() {
        try{
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }

        //verifico che ci sia il codice recaptcha nei parametri
        if (!isset($this->request['challengeField']) || !isset($this->request['responseField'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No new user specified");
            $this->response($error, 400);
        }
        $challengeField = $this->request['challengeField'];
        $responseField = $this->request['responseField'];

        //da implementare

        $resp = recaptcha_check_answer(CAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $challengeField, $responseField);

        if ($resp->is_valid) {
            $_SESSION['captchaValidation'] = true;
            $this->response(array("success"), 200);
        } else {
            $this->response(array("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
                "(reCAPTCHA said: " . $resp->error . ")"), 200);
        }
                } catch (Exception $e) {
            $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
            $this->response($error, 503);
        }
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
        try{
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
                } catch (Exception $e) {
            $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
            $this->response($error, 503);
        }
    }

    /**
     * Risponde alla chiamata API "checkEmailExists"
     * In post riceve:
     *              email => l'email di cui si verifica l'esistenza
     */
    public function checkEmailExists() {
        try{
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
                } catch (Exception $e) {
            $error = array('status' => "Service Unavailable", "msg" => $e->getMessage());
            $this->response($error, 503);
        }
    }

    private function createSpotter($userJSON) {

        if (!is_null($userJSON)) {
            $user = new User("SPOTTER");

            $this->setCommonValues($user, $userJSON);
            
            //step 2
            $user->setFirstname($userJSON->firstname);
            $user->setLastname($userJSON->lastname);
            $user->setCountry($userJSON->country);
            $user->setCity($userJSON->city);
            $user->setMusic($this->getMusicArray($userJSON->genre));

            //step 3
            $user->setSex($userJSON->sex);

            //birthday            
            $birthday = json_decode(json_encode($userJSON->birthday),false);
            if (strlen($birthday->year) > 0 && strlen($birthday->month) > 0 && strlen($birthday->day) > 0) {
                $user->setBirthDay($birthday->day . "-" . $birthday->month . "-" . $birthday->year);
            }

            return $user;
        }
        return null;
    }
////////////////////////////////////////////////////////////////////////////////
//
//       Funzioni per la creazione del nuovo utente (non invocabili via REST API
//        
//////////////////////////////////////////////////////////////////////////////// 

    private function createJammer($userJSON) {

        if (!is_null($userJSON)) {
            $user = new User("JAMMER");
            //step1
            $this->setCommonValues($user, $userJSON);

            //step2
            $user->setJammerType($userJSON->jammerType);
            $user->setCountry($userJSON->country);
            $user->setCity($userJSON->city);
            if ($userJSON->jammerType == "band") {
                $user->setMembers($this->getMembersArray($userJSON->members));
            }
            //step 3
            $user->setMusic($this->getMusicArray($userJSON->genre));
            return $user;
        }
        return null;
    }

    private function createVenue($userJSON) {

        if (!is_null($userJSON)) {
            $user = new User("VENUE");

            //step1
            $this->setCommonValues($user, $userJSON);

            $user->setCountry($userJSON->country);
            $user->setCity($userJSON->city);
            $location = $userJSON->country . " , ";
            $location .= $userJSON->city . " , ";
            $location .= $userJSON->province . " , ";
            $location .= $userJSON->address . " , ";
            $location .= $userJSON->number;
            $geocoding = GeocoderService::getLocation($userJSON->country . "," . $userJSON->city . "," . $userJSON->province . "," . $userJSON->address . "," . $userJSON->number);
            $user->setGeoCoding($geocoding);
            $user->setLocalType($this->getLocalTypeArray($userJSON->genre));
            
            return $user;
        }
        return null;
    }

    private function getMusicArray($genre) {
          if(count($genre) > 0){
              $return = array();
              for($i=0; $i<count($genre); $i++){
                  $return[] = $this->config->music[$genre[$i]];
              }
              
              return $return;
          }else return null;        
          
    }

    private function getMembersArray($members) {
        
        if(count($members)> 0){
            $return = array();
            foreach($members as  $member){
                $return[] = array("instrument" => $member->instrument, "name" => $member->name);
            }
            return $return;
        }else return null;                
    }

    private function getLocalTypeArray($genre) {
          if(count($genre) > 0){
              $return = array();
              for($i=0; $i<count($genre); $i++){
                  $return[] = $this->config->localType[$genre[$i]];
              }
              
              return $return;
          }else return null;         
    }

    private function setCommonValues($user, $decoded) {
            
        //la parte dello step 1
        $user->setUsername($decoded->username);
        $user->setEmail($decoded->email);
        $user->setPassword($decoded->password);
        $user->setDescription($decoded->description);
        $imgProfile = ""; //@todo
        $user->setSettings(defineSettings($user->getType(), $decoded->language, $decoded->localTime, $imgProfile));
        //la parte social        
        $user->setFbPage($decoded->facebook);
        $user->setTwitterPage($decoded->twitter);
        $user->setGooglePlusPage($decoded->google);
        $user->setYoutubeChannel($decoded->youtube);
        $user->setWebsite($decoded->web);

        //imposto i parametri di Jam
//        $user->setAuthData($authData);
        $parseACL = new parseACL();
        $parseACL->setPublicReadAccess(true);
        $user->setACL($parseACL);
        $user->setActive(true);
//        $user->setBackground();
        $user->setCollaborationCounter(0);
        $user->setFollowersCounter(0);
        $user->setFollowingCounter(0);
        $user->setFriendshipCounter(0);
        $user->setJammerCounter(0);
        $user->setLevel(0);
        $user->setLevelValue(1);
        $user->setPremium(false);
        $user->setVenueCounter(0);
    }

}

?>