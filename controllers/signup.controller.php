<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'validateNewUser.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'cropImage.service.php';
require_once SERVICES_DIR . 'recaptcha.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

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
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/signup.config.json"), false);
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
        global $controllers;

        try {
//con captcha:
//        if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser']) ||
//                !isset($_SESSION['recaptcha']) || !$_SESSION['recaptcha']) {
//            $this->response('', 406);
//        }
//senza captcha:
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
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
                $error = array('status' => "Bad Request", "msg" => "Invalid new user", "errorList" => $this->userValidator->getErrors());
                //oltre al messaggio potrebbe tornare utile a Maria Laura una lista delle property che han dato errore?
                //se si la trova in 'errors'
                $this->response(array('status' => $controllers['INVALIDNEWUSER'], 'errors' => $error), 403);
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

            if ($user instanceof Error) {
//result è un errore e contiene il motivo dell'errore
                $this->response(array('status' => $controllers['NEWUSERCREATIONFAILED']), 503);
            }
//se va a buon fine salvo una nuova activity       
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setFromUser($user->getObjectId());
            $activity->setRead(true);
            $activity->setStatus("A");
            $activity->setType("SIGNEDUP");
//            $activity->setACL(toParseDefaultACL());

            $pActivity = new ActivityParse();
            $pActivity->saveActivity($activity);

//aggiorno l'oggetto User in sessione
            $_SESSION['currentUser'] = $user;
//creo la struttura base del file system
            $this->createFileSystemStructure($user->getObjectId(), $user->getType());

//crea l'album immagini di default        
            $this->createImageDefaultAlbum($user->getObjectId());

//crea l'album record di default
            if($user->getType() == "JAMMER"){
                $this->createRecordDefaultAlbum($user->getObjectId());
            }

//SPOSTO LE IMMAGINI NELLE RISPETTIVE CARTELLE   
            if (!is_null($user->getProfileThumbnail()) && strlen($user->getProfileThumbnail()) > 0 && strlen($user->getProfilePicture()) && !is_null($user->getProfilePicture())) {
                rename(MEDIA_DIR . "cache/" . $user->getProfileThumbnail(), USERS_DIR . $user->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicturethumb" . DIRECTORY_SEPARATOR . $user->getProfileThumbnail());
                rename(MEDIA_DIR . "cache/" . $user->getProfilePicture(), USERS_DIR . $user->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicture" . DIRECTORY_SEPARATOR . $user->getProfilePicture());
            }
//restituire true o lo user....            
            $this->response(array("status" => $controllers['USERCREATED']), 200);
        } catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    /**
     * verifica la correttezza del recaptcha inserito, salva in sessione
     * il risultato e risponde  alla chiamata con un codice di conferma 
     * 
     */
    public function recaptcha() {
        global $controllers;

        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 406);
            }

//verifico che ci sia il codice recaptcha nei parametri
            if (!isset($this->request['challengeField']) || !isset($this->request['responseField'])) {
// If invalid inputs "Bad Request" status message and reason
                $this->response(array('status' => $controllers["NOCAPTCHA"]), 400);
            }
            $challengeField = $this->request['challengeField'];
            $responseField = $this->request['responseField'];

//da implementare

            $resp = recaptcha_check_answer(CAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $challengeField, $responseField);

            if ($resp->is_valid) {
                $_SESSION['captchaValidation'] = true;
                $this->response(array("status" => $controllers["CORRECTCAPTCHA"]), 200);
            } else {
                $this->response(array("status" => $controllers["WRONGRECAPTCHA"]), 403);
            }
        } catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    /**
     * Risponde alla chiamata API "checkUsernameExists"
     * In post riceve:
     *              username => lo username di cui si verifica l'esistenza
     */
    public function checkUsernameExists() {
        global $controllers;

        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers["NOPOSTREQUEST"]), 406);
            }

//verifico che ci sia il nuovo utente nei paraemtri
            if (!isset($this->request['username'])) {
// If invalid inputs "Bad Request" status message and reason
                $this->response(array('status' => $controllers["NOUSERNAMESPECIFIED"]), 400);
            }

            $username = $this->request['username'];
//query per la verifica dello username
            $up = new UserParse();
            $up->whereEqualTo("username", $username);
            $res = $up->getCount();

//$res assume valori 0 o 1
            if ($res < 1) {
                $this->response(array("status" => $controllers["VALIDUSERNAME"]), 200);
            } else {
                $this->response(array("status" => $controllers["USERNAMEALREADYEXISTS"]), 200);
            }
        } catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    /**
     * Risponde alla chiamata API "checkEmailExists"
     * In post riceve:
     *              email => l'email di cui si verifica l'esistenza
     */
    public function checkEmailExists() {
        global $controllers;

        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers["NOPOSTREQUEST"]), 406);
            }

            if (!isset($this->request['email'])) {
// If invalid inputs "Bad Request" status message and reason
                $this->response(array('status' => $controllers['NOMAILSPECIFIED']), 403);
            }
            $email = $this->request['email'];
//query per la verifica dell'email
            $up = new UserParse();
            $up->whereEqualTo("email", $email);
            $res = $up->getCount();

//$res assume valori 0 o 1
            if ($res < 1) {
                $this->response(array("status" => $controllers["VALIDMAIL"]), 200);
            } else {
                $this->response(array("status" => $controllers["MAILALREADYEXISTS"]), 403);
            }
        } catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    private function createSpotter($userJSON) {

        if (!is_null($userJSON)) {
            $user = new User("SPOTTER");

            $this->setCommonValues($user, $userJSON);

            $user->setCollaborationCounter(-1); 
            $user->setFollowersCounter(-1);  
            $user->setFollowingCounter(0); 
            $user->setFriendshipCounter(0);
            $user->setJammerCounter(-1); 
            $user->setVenueCounter(-1); 
//step 21
            $user->setFirstname($userJSON->firstname);
            $user->setLastname($userJSON->lastname);
            $user->setCountry($userJSON->country);
            $user->setCity($userJSON->city);
            $user->setMusic($this->getMusicArray($userJSON->genre));

//step 3
            $user->setSex($userJSON->sex);

//birthday            
            $birthday = json_decode(json_encode($userJSON->birthday), false);
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

            $user->setCollaborationCounter(0);
            $user->setFollowersCounter(0);
            $user->setFollowingCounter(-1); 
            $user->setFriendshipCounter(-1);
            $user->setJammerCounter(0);
            $user->setVenueCounter(0);
            
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

            $user->setCollaborationCounter(0);
            $user->setFollowersCounter(0);
            $user->setFollowingCounter(-1);
            $user->setFriendshipCounter(-1);
            $user->setJammerCounter(0);
            $user->setVenueCounter(0);

            
            $user->setCountry($userJSON->country);
            $user->setCity($userJSON->city);
            $location = $userJSON->country . " , ";
            $location .= $userJSON->city . " , ";
            $location .= $userJSON->province . " , ";
            $location .= $userJSON->address . " , ";
            $location .= $userJSON->number;
            $geocoding = GeocoderService::getLocation($location);
            if ($geocoding != false) {
                $parseGeopoint = new parseGeoPoint($geocoding['lat'], $geocoding['lng']);
                $user->setGeoCoding($parseGeopoint);
                $user->setLocalType($this->getLocalTypeArray($userJSON->genre));
            }
            return $user;
        }
        return null;
    }

    private function getMusicArray($genre) {
        if (count($genre) > 0) {
            $return = array();
            foreach ($genre as $val) {
                $return[] = $this->config->music[$val];
            }

            return $return;
        }
        else
            return null;
    }

    private function getMembersArray($members) {

        if (count($members) > 0) {
            $return = array();
            foreach ($members as $member) {
                $return[] = array("instrument" => $member->instrument, "name" => $member->name);
            }
            return $return;
        }
        else
            return null;
    }

    private function getLocalTypeArray($genre) {
        if (count($genre) > 0) {
            $return = array();
            foreach ($genre as $val) {
                $return[] = $this->config->localType[$val];
            }

            return $return;
        }
        else
            return null;
    }

    private function setCommonValues($user, $decoded) {

//la parte dello step 1
        $user->setUsername($decoded->username);
        $user->setEmail($decoded->email);
        $user->setPassword($decoded->password);
        $user->setDescription($decoded->description);

        $imgInfo = $this->getImages($decoded);
        $user->setSettings($this->defineSettings($user->getType(), $decoded->language, $decoded->localTime, $imgInfo['ProfilePicture']));
//la parte social      
        $user->setProfilePicture($imgInfo['ProfilePicture']);
        $user->setProfileThumbnail($imgInfo['ProfileThumbnail']);
        $user->setFbPage($decoded->facebook);
        $user->setTwitterPage($decoded->twitter);
        $user->setGooglePlusPage($decoded->google);
        $user->setYoutubeChannel($decoded->youtube);
        $user->setWebsite($decoded->web);

//nuova property badge
        $user->setBadge(array());

//imposto i parametri di Jam       
        $parseACL = new parseACL();
        $parseACL->setPublicReadAccess(true);
        $user->setACL($parseACL);

        $user->setActive(true);
        $user->setBackground(DEFBGD);        
        
        $user->setLevel(0);
        $user->setLevelValue(1);
        $user->setPremium(false);
    }

    private function getImages($decoded) {
//in caso di anomalie ---> default
        if (!isset($decoded->crop) || is_null($decoded->crop) ||
                !isset($decoded->imageProfile) || is_null($decoded->imageProfile)) {
            return array("ProfilePicture" => null, "ProfileThumbnail" => null);
        }

        $PROFILE_IMG_SIZE = 300;
        $THUMBNAIL_IMG_SIZE = 150;

//recupero i dati per effettuare l'editing
        $cropInfo = json_decode(json_encode($decoded->crop), false);

        if (!isset($cropInfo->x) || is_null($cropInfo->x) || !is_numeric($cropInfo->x) ||
                !isset($cropInfo->y) || is_null($cropInfo->y) || !is_numeric($cropInfo->y) ||
                !isset($cropInfo->w) || is_null($cropInfo->w) || !is_numeric($cropInfo->w) ||
                !isset($cropInfo->h) || is_null($cropInfo->h) || !is_numeric($cropInfo->h)) {
            return array("ProfilePicture" => null, "ProfileThumbnail" => null);
        }
        $cacheDir = MEDIA_DIR . "cache/";
        $cacheImg = $cacheDir . $decoded->imageProfile;

//Preparo l'oggetto per l'editign della foto
        $cis = new CropImageService();

//gestione dell'immagine di profilo
        $coverId = $cis->cropImage($cacheImg, $cropInfo->x, $cropInfo->y, $cropInfo->w, $cropInfo->h, $PROFILE_IMG_SIZE);
        $coverUrl = $cacheDir . $coverId;

//gestione del thumbnail
        $thumbId = $cis->cropImage($coverUrl, 0, 0, $PROFILE_IMG_SIZE, $PROFILE_IMG_SIZE, $THUMBNAIL_IMG_SIZE);

//CANCELLAZIONE DELLA VECCHIA IMMAGINE
        unlink($cacheImg);
//RETURN        
        return array('ProfilePicture' => $coverId, 'ProfileThumbnail' => $thumbId);
    }

    private function createFileSystemStructure($userId, $type) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                mkdir(USERS_DIR . $userId, 0, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images", 0, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "default", 0, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicturethumb", 0, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicture", 0, true);
                if ($type == "JAMMER") {
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcover", 0, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcoverthumb", 0, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover", 0, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb", 0, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb", 0, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcover", 0, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs");
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . "default");
                }elseif($type == "VENUE"){
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb", 0, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcover", 0, true);
                }
                    
            }
        } catch (Exception $e) {
            return false;
        }
    }

    private function createRecordDefaultAlbum($userId) {
        $record = new Record();
        $record->setActive(true);
        $record->setCommentCounter(0);
        $record->setDuration(0);
        $record->setFromUser($userId);
        $record->setLoveCounter(0);
        $record->setReviewCounter(0);
        $record->setShareCounter(0);
        $record->setTitle('Default Record');
        $record->setYear(date("Y"));
        $pRecord = new RecordParse();
        return $pRecord->saveRecord($record);
    }

    private function createImageDefaultAlbum($userId) {
        $album = new Album();
        $album->setActive(true);
        $album->setCommentCounter(0);
        $album->setCounter(0);
        $album->setFromUser($userId);
        $album->setCommentCounter(0);
        $album->setLoveCounter(0);
        $album->setShareCounter(0);
        $album->setTitle('Default Album');
        $pAlbum = new AlbumParse();
        return $pAlbum->saveAlbum($album);
    }

    /*     * *************************************************************************** */

    /**
     * Inizializza la variabile in funzione dell'utente: chiamare questa per inizializzare tutto l'array settings
     */
    private function defineSettings($user_type, $language, $localTime, $imgProfile) {
        $settings = array();
        if (!is_null($user_type) && !is_null($language) && !is_null($localTime)) {
            $common = $this->init_common_settings($language, $localTime, $imgProfile);
            $settings = array_merge($settings, $common);

            switch ($user_type) {
                case "SPOTTER" :
                    $spot = $this->init_spotter_settings($settings);
                    $settings = array_merge($settings, $spot);
                    break;

                case "JAMMER" :
                    $jam = $this->init_jammer_settings($settings);
                    $settings = array_merge($settings, $jam);
                    break;

                case "VENUE" :
                    $ven = $this->init_venue_settings($settings);
                    $settings = array_merge($settings, $ven);
                    break;
            }
        }

        return $settings;
    }

    /**
     * Inizializza con le impostazioni di default alcuni valori comuni a tutti gli utenti
     * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
     *
     */
    private function init_common_settings($language, $localTime, $imgProfile) {

        $settings = array();

        $settings[0] = $language; //questi vanno recuperati via javascript
        $settings[1] = $localTime; //
        $settings[2] = $imgProfile;
        for ($i = 3; $i <= 10; $i++) {
            $settings[$i] = "PUBLIC";
        }
        $settings[11] = "YES";
        $settings[13] = "PUBLIC";

        for ($i = 15; $i <= 26; $i++) {
            $settings[$i] = true;
        }
        for ($i = 30; $i <= 33; $i++) {
            $settings[$i] = false;
        }
        return $settings;
    }

    /**
     * Inizializza con le impostazioni di default alcuni valori dell'account SPOTTER
     * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
     *
     */
    private function init_spotter_settings() {

        $settings = array();

        $settings[12] = "FOLLOWERS";
        $settings[14] = "YES";

        for ($i = 27; $i <= 29; $i++) {
            $settings[$i] = false;
        }

        $settings[34] = true;
        $settings[35] = false;
        $settings[36] = true;
        $settings[37] = true;
        $settings[38] = false;

        return $settings;
    }

    /**
     * Inizializza con le impostazioni di default alcuni valori dell'account JAMMER
     * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
     *
     */
    private function init_jammer_settings() {

        $settings = array();

        $settings[12] = "FandC";
        $settings[14] = true;

        for ($i = 27; $i <= 29; $i++) {
            $settings[$i] = true;
        }
        $settings[34] = false;
        $settings[35] = false;
        $settings[36] = false;
        $settings[37] = true;
        $settings[38] = false;
        $settings[39] = true;
        $settings[40] = false;
        $settings[41] = false;
        $settings[42] = true;
        $settings[43] = true;
        $settings[44] = true;

        return $settings;
    }

    /**
     * Inizializza con le impostazioni di default alcuni valori dell'account VENUE
     * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
     *
     */
    private function init_venue_settings($settings) {

        $settings = array();

        $settings[12] = "FandC";
        $settings[14] = true;
        $settings[27] = true;
        $settings[28] = false;
        $settings[29] = false;
        $settings[34] = false;
        $settings[35] = true;
        $settings[36] = false;
        $settings[37] = false;
        $settings[38] = true;
        $settings[39] = true;
        $settings[40] = true;

        return $settings;
    }

}

?>