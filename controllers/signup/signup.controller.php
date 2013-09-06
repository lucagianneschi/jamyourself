<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

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

            //passo la chiave pubblica del captcha qua
            $_SESSION['captchaPublicKey'] = CAPTCHA_PUBLIC_KEY;
            $_SESSION['captchaValidation'] = false;
            
            //recupero il JSON di configurazione
            $configFile = file_get_contents(CONTROLLERS_DIR."signup/signup.config.json");
            $config=json_decode($configFile,true);
            $_SESSION['config'] = $config;
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

        //creo l'oggetto per la validazione dell'utente
        $userValidator = new ValidateNewUserService();

        //verifico la validit� dell'utente
        if ($userValidator->checkNewUser($userJSON) == false) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "Invalid new user");
            $this->response($error, 400);
        }

        //recupero i campi dell'utente
        $newUser = null;
        switch ($userJSON->type) {
            case "SPOTTER" :
                $newUser = $this->createSpotter($userJSON);
                break;
            case "JAMMER" :
                $newUser = $this->createJammer($userJSON);
                break;
            case "VENUE" :
                $newUser = $this->createVenue($userJSON);
                break;
        }
        
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

    public function signupTest() {
        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
            $this->response('', 406);
        }

        if (!isset($this->request['formData'])) {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Bad Request", "msg" => "No form data specified");
            $this->response($error, 400);
        }


        $data = $this->request['formData'];
//        $decoded = json_decode($this->request['formData']);
        $params = array();
        parse_str($data, $params);

        $this->response(array('ok'), 200);
    }

    private function createSpotter($userJSON) {
        //birthday.day: "2"
        //birthday.month: "April"
        //birthday.year: "1925"
        //city: "pis"
        //country: "ita"
        //description: "lorem ipsum at doloret"
        //firstname: "stefa"
        //genre: "["4","24"]"
        //lastname: "musca"
        //sex: "M"        
        
        if (!is_null($userJSON)) {
            $decoded = json_decode($userJSON);
            $user = new User("SPOTTER");

            
            $this->setCommonValues($user, $decoded);

            //step 2
            $user->setFirstname($decoded->firstname);
            $user->setLastname($decoded->lastname);
            $user->setCountry($decoded->country);
            $user->setCity($decoded->city);
            $user->setMusic($this->getMusicArray($decoded->genre));

            //step 3
            $user->setSex($decoded->sex);

            //birthday            
            $birthday = json_decode($decoded->birthday);
            if($birthday->year.length > 0 && $birthday->month.length > 0 && $birthday->day.length > 0){
                $user->setBirthDay($birthday->year . "-" . $birthday->month . "-" . $birthday->day);
            }
            
            return $user;
        }
        return null;
    }

    private function createJammer($userJSON) {
        
        if (!is_null($userJSON)) {
            $decoded = json_decode($userJSON);
            $user = new User("JAMMER");
            //step1
            $this->setCommonValues($user, $decoded);
            
            //step2
            $user->setJammerType($decoded->jammerType);
            $user->setCountry($decoded->country);
            $user->setCity($decoded->city);
            if ($decoded->jammerType == "band") {                
                $user->setMembers($this->getMembersArray($decoded->members ));               
            }
            //step 3
            $user->setMusic($this->getMusicArray($decoded->genre));
            return $user;
        }
        return null;
    }

    private function createVenue($userJSON) {

        if (!is_null($userJSON)) {
            $decoded = json_decode($userJSON);
            $user = new User("VENUE");

            //step1
            $this->setCommonValues($user, $decoded);
            
            $user->setCountry($decoded->country);
            $user->setCity($decoded->city);
            $location = $decoded->country . " , ";
            $location .= $decoded->city . " , ";
            $location .= $decoded->province . " , ";
            $location .= $decoded->address . " , ";
            $location .= $decoded->number;
            $geocoding = GeocoderService::getLocation($decoded->country.",".$decoded->city.",".$decoded->province.",".$decoded->address.",".$decoded->number);
            $user->setGeoCoding($geocoding);

            //genre



            
            return $user;
        }
        return null;
    }

    private function getMusicArray($genre) {

    }
    
    private function getMembersArray($members){
        $decoded = json_decode($members);
    }
    
    private function getGenreArray($members){
        
    }
    
   
    
    private function setCommonValues($user, $decoded){
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