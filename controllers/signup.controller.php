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
require_once CONTROLLERS_DIR . 'utilsController.php';
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
                $this->response(array(), 406);
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
            $this->createFileSystemStructure($user->getObjectId());

//crea l'album immagini di default        
            $this->createImageDefaultAlbum($user->getObjectId());

//crea l'album record di default
            $this->createRecordDefaultAlbum($user->getObjectId());

//SPOSTO LE IMMAGINI NELLE RISPETTIVE CARTELLE   
            if (!is_null($user->getProfileThumbnail()) && strlen($user->getProfileThumbnail()) > 0 && strlen($user->getProfilePicture()) && !is_null($user->getProfilePicture())) {
                rename(MEDIA_DIR . "cache/" . $user->getProfileThumbnail(), USERS_DIR . $user->getObjectId() . "/" . "images" . "/" . "profilepicturethumb" . "/" . $user->getProfileThumbnail());
                rename(MEDIA_DIR . "cache/" . $user->getProfilePicture(), USERS_DIR . $user->getObjectId() . "/" . "images" . "/" . "profilepicture" . "/" . $user->getProfilePicture());
            }
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
        try {
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
     * Risponde alla chiamata API "checkUsernameExists"
     * In post riceve:
     *              username => lo username di cui si verifica l'esistenza
     */
    public function checkUsernameExists() {
        try {
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
            $this->response(array("Result" => $res), 200);
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
        try {
            if ($this->get_request_method() != "POST" || !isset($_SESSION['currentUser'])) {
                $this->response('', 406);
            }

            if (!isset($this->request['email'])) {
// If invalid inputs "Bad Request" status message and reason
                $error = array('status' => "Bad Request", "msg" => "No email specified");
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
            $this->response(array("Result" => $res), 200);
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
            for ($i = 0; $i < count($genre); $i++) {
                $return[] = $this->config->music[$genre[$i]];
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
            for ($i = 0; $i < count($genre); $i++) {
                $return[] = $this->config->localType[$genre[$i]];
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
        $user->setSettings(defineSettings($user->getType(), $decoded->language, $decoded->localTime, $imgInfo['ProfilePicture']));
//la parte social      
        $user->setProfilePicture($imgInfo['ProfilePicture']);
        $user->setProfileThumbnail($imgInfo['ProfileThumbnail']);
        $user->setFbPage($decoded->facebook);
        $user->setTwitterPage($decoded->twitter);
        $user->setGooglePlusPage($decoded->google);
        $user->setYoutubeChannel($decoded->youtube);
        $user->setWebsite($decoded->web);

//imposto i parametri di Jam       
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
        $thumbUrl = $cacheDir . $thumbId;

//CANCELLAZIONE DELLA VECCHIA IMMAGINE
        unlink($cacheImg);
//RETURN        
        return array('ProfilePicture' => $coverId, 'ProfileThumbnail' => $thumbId);
    }

    private function createFileSystemStructure($userId) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                mkdir(USERS_DIR . $userId,0,true);
                mkdir(USERS_DIR . $userId . "/" . "images",0,true);
                mkdir(USERS_DIR . $userId . "/" . "images" . "/" . "default",0,true);
                mkdir(USERS_DIR . $userId . "/" . "images" . "/" . "profilepicturethumb",0,true);
                mkdir(USERS_DIR . $userId . "/" . "images" . "/" . "profilepicture",0,true);
                mkdir(USERS_DIR . $userId . "/" . "images" . "/" . "albumcover",0,true);
                mkdir(USERS_DIR . $userId . "/" . "images" . "/" . "albumcoverthumb",0,true);
                mkdir(USERS_DIR . $userId . "/" . "images" . "/" . "recordcover",0,true);
                mkdir(USERS_DIR . $userId . "/" . "images" . "/" . "recordcoverthumb",0,true);
                mkdir(USERS_DIR . $userId . "/" . "songs");
                mkdir(USERS_DIR . $userId . "/" . "songs" . "/" . "default");
            }
        } catch (Exception $e) {
            return false;
        }
    }

    private function createRecordDefaultAlbum($userId) {
        $record = new Record();
        $record->setActive(true);
        $record->setCommentCounter(0);
//$record->setCoverFile();
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
//        $album->setCoverFile("");
        $album->setFromUser($userId);
        $album->setCommentCounter(0);
        $album->setLoveCounter(0);
        $album->setShareCounter(0);
        $album->setTitle('Default Album');

        $pAlbum = new AlbumParse();

//result è un errore e contiene il motivo dell'errore
        return $pAlbum->saveAlbum($album);
    }

}

/**
 * Inizializza la variabile in funzione dell'utente: chiamare questa per inizializzare tutto l'array settings
 */
 
function defineSettings($user_type,$language,$localTime,$imgProfile){

	$settings = array();

	if($user_type && $language && $localTime){

		$common = init_common_settings($language,$localTime,$imgProfile);

		$settings = array_merge($settings, $common);

		switch($user_type){

			case "SPOTTER" :

				$spot=init_spotter_settings($settings);

				$settings = array_merge($settings, $spot);

				break;

			case "JAMMER" :

				$jam=init_jammer_settings($settings);

				$settings = array_merge($settings, $jam);

				break;

			case "VENUE" :

				$ven=init_venue_settings($settings);

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
function init_common_settings($language,$localTime,$imgProfile){

	$settings = array();

	$settings[0] = $language;//questi vanno recuperati via javascript
	$settings[1] = $localTime;//
	$settings[2] = $imgProfile;
	for($i=3; $i<=10; $i++){

		$settings[$i] = "PUBLIC";

	}
	$settings[11] = "YES";

	$settings[13] = "PUBLIC";


	for($i=15; $i<=26; $i++){

		$settings[$i] = true;

	}
	for($i=30; $i<=33; $i++){

		$settings[$i] = false;

	}
	return $settings;
}

/**
 * Inizializza con le impostazioni di default alcuni valori dell'account SPOTTER
 * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
 *
 */
function init_spotter_settings(){

	$settings = array();

	$settings[12] = "FOLLOWERS" ;

	$settings[14] = "YES";

	for($i=27; $i<=29; $i++){

		$settings[$i] = false;

	}

	$settings[34] = true ;

	$settings[35] = false ;

	$settings[36] = true ;

	$settings[37] = true ;

	$settings[38] = false ;

	return $settings;

}

/**
 * Inizializza con le impostazioni di default alcuni valori dell'account JAMMER
 * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
 *
 */
function init_jammer_settings(){

	$settings = array();

	$settings[12] = "FandC" ;

	$settings[14] = true;

	for($i=27; $i<=29; $i++){

		$settings[$i] = true;

	}
	$settings[34] = false ;

	$settings[35] = false ;

	$settings[36] = false ;

	$settings[37] = true  ;

	$settings[38] = false ;

	$settings[39] = true  ;

	$settings[40] = false ;

	$settings[41] = false ;

	$settings[42] = true  ;

	$settings[43] = true  ;

	$settings[44] = true  ;

	return $settings;
}


/**
 * Inizializza con le impostazioni di default alcuni valori dell'account VENUE
 * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
 *
 */
function init_venue_settings($settings){

	$settings = array();

	$settings[12] = "FandC" ;

	$settings[14] = true;

	$settings[27] = true  ;

	$settings[28] = false ;

	$settings[29] = false ;

	$settings[34] = false ;

	$settings[35] = true  ;

	$settings[36] = false ;

	$settings[37] = false ;

	$settings[38] = true  ;

	$settings[39] = true  ;

	$settings[40] = true  ;

	return $settings;

}

/**
 * Serve per compilare il form per verificare
 * i settaggi attuali dell'utente e
 * impostarli nel form della modifica
 *
 * @param unknown $set array dei settings dell'utente
 * @param unknown $index indice di cui si vuole controllare se � "checked"
 * @param unknown $value valore da confrontare
 */
function checked($set, $index, $value){
	if($set[$index] == $value) echo "checked";
	else echo "";
}

/**
 * Serve per compilare il form per verificare
 * i settaggi attuali dell'utente e
 * impostarli nel form della modifica
 *
 * @param unknown $set array dei settings dell'utente
 * @param unknown $index indice di cui si vuole controllare se � "selected"
 * @param unknown $value valore da confrontare
 */
function selected($set, $index, $value){
	if($set[$index] == $value) echo "selected";
	else echo "";
}

//*********************** Array descrittivi specifici ***********************************************//

//******************* JAMMER ************************************************//
$jammer_set = array();
$jammer_set[0] =  $settings_strings['JAMMER_SETTING_0'];
$jammer_set[1] =  $settings_strings['JAMMER_SETTING_1'];
$jammer_set[2] =  $settings_strings['JAMMER_SETTING_2'];
$jammer_set[3] =  $settings_strings['JAMMER_SETTING_3'];
$jammer_set[4] =  $settings_strings['JAMMER_SETTING_4'];
$jammer_set[5] =  $settings_strings['JAMMER_SETTING_5'];
$jammer_set[6] =  $settings_strings['JAMMER_SETTING_6'];
$jammer_set[7] =  $settings_strings['JAMMER_SETTING_7'];
$jammer_set[8] =  $settings_strings['JAMMER_SETTING_8'];
$jammer_set[9] =  $settings_strings['JAMMER_SETTING_9'];
$jammer_set[10] = $settings_strings['JAMMER_SETTING_10'];
$jammer_set[11] = $settings_strings['JAMMER_SETTING_11'];
$jammer_set[12] = $settings_strings['JAMMER_SETTING_12'];
$jammer_set[13] = $settings_strings['JAMMER_SETTING_13'];
$jammer_set[14] = $settings_strings['JAMMER_SETTING_14'];
$jammer_set[15] = $settings_strings['JAMMER_SETTING_15'];
$jammer_set[16] = $settings_strings['JAMMER_SETTING_16'];
$jammer_set[17] = $settings_strings['JAMMER_SETTING_17'];
$jammer_set[18] = $settings_strings['JAMMER_SETTING_18'];
$jammer_set[19] = $settings_strings['JAMMER_SETTING_19'];
$jammer_set[20] = $settings_strings['JAMMER_SETTING_20'];
$jammer_set[21] = $settings_strings['JAMMER_SETTING_21'];
$jammer_set[22] = $settings_strings['JAMMER_SETTING_22'];
$jammer_set[23] = $settings_strings['JAMMER_SETTING_23'];
$jammer_set[24] = $settings_strings['JAMMER_SETTING_24'];
$jammer_set[25] = $settings_strings['JAMMER_SETTING_25'];
$jammer_set[26] = $settings_strings['JAMMER_SETTING_26'];
$jammer_set[27] = $settings_strings['JAMMER_SETTING_27'];
$jammer_set[28] = $settings_strings['JAMMER_SETTING_28'];
$jammer_set[29] = $settings_strings['JAMMER_SETTING_29'];
$jammer_set[30] = $settings_strings['JAMMER_SETTING_30'];
$jammer_set[31] = $settings_strings['JAMMER_SETTING_31'];
$jammer_set[32] = $settings_strings['JAMMER_SETTING_32'];
$jammer_set[33] = $settings_strings['JAMMER_SETTING_33'];
$jammer_set[34] = $settings_strings['JAMMER_SETTING_34'];
$jammer_set[35] = $settings_strings['JAMMER_SETTING_35'];
$jammer_set[36] = $settings_strings['JAMMER_SETTING_36'];
$jammer_set[37] = $settings_strings['JAMMER_SETTING_37'];
$jammer_set[38] = $settings_strings['JAMMER_SETTING_38'];
$jammer_set[39] = $settings_strings['JAMMER_SETTING_39'];
$jammer_set[40] = $settings_strings['JAMMER_SETTING_40'];
$jammer_set[41] = $settings_strings['JAMMER_SETTING_41'];
$jammer_set[42] = $settings_strings['JAMMER_SETTING_42'];
$jammer_set[43] = $settings_strings['JAMMER_SETTING_43'];
$jammer_set[44] = $settings_strings['JAMMER_SETTING_44'];

//************************************* SPOTTER ********************//
$spotter_set = array();
$spotter_set[0] = $settings_strings['SPOTTER_SETTING_0'] ;
$spotter_set[1] = $settings_strings['SPOTTER_SETTING_1'] ;
$spotter_set[2] = $settings_strings['SPOTTER_SETTING_2'] ;
$spotter_set[3] = $settings_strings['SPOTTER_SETTING_3'] ;
$spotter_set[4] = $settings_strings['SPOTTER_SETTING_4'] ;
$spotter_set[5] = $settings_strings['SPOTTER_SETTING_5'] ;
$spotter_set[6] = $settings_strings['SPOTTER_SETTING_6'] ;
$spotter_set[7] = $settings_strings['SPOTTER_SETTING_7'] ;
$spotter_set[8] = $settings_strings['SPOTTER_SETTING_8'] ;
$spotter_set[9] = $settings_strings['SPOTTER_SETTING_9'] ;
$spotter_set[10] = $settings_strings['SPOTTER_SETTING_10'];
$spotter_set[11] = $settings_strings['SPOTTER_SETTING_11'];
$spotter_set[12] = $settings_strings['SPOTTER_SETTING_12'];
$spotter_set[13] = $settings_strings['SPOTTER_SETTING_13'];
$spotter_set[14] = $settings_strings['SPOTTER_SETTING_14'];
$spotter_set[15] = $settings_strings['SPOTTER_SETTING_15'];
$spotter_set[16] = $settings_strings['SPOTTER_SETTING_16'];
$spotter_set[17] = $settings_strings['SPOTTER_SETTING_17'];
$spotter_set[18] = $settings_strings['SPOTTER_SETTING_18'];
$spotter_set[19] = $settings_strings['SPOTTER_SETTING_19'];
$spotter_set[20] = $settings_strings['SPOTTER_SETTING_20'];
$spotter_set[21] = $settings_strings['SPOTTER_SETTING_21'];
$spotter_set[22] = $settings_strings['SPOTTER_SETTING_22'];
$spotter_set[23] = $settings_strings['SPOTTER_SETTING_23'];
$spotter_set[24] = $settings_strings['SPOTTER_SETTING_24'];
$spotter_set[25] = $settings_strings['SPOTTER_SETTING_25'];
$spotter_set[26] = $settings_strings['SPOTTER_SETTING_26'];
$spotter_set[27] = $settings_strings['SPOTTER_SETTING_27'];
$spotter_set[28] = $settings_strings['SPOTTER_SETTING_28'];
$spotter_set[29] = $settings_strings['SPOTTER_SETTING_29'];
$spotter_set[30] = $settings_strings['SPOTTER_SETTING_30'];
$spotter_set[31] = $settings_strings['SPOTTER_SETTING_31'];
$spotter_set[32] = $settings_strings['SPOTTER_SETTING_32'];
$spotter_set[33] = $settings_strings['SPOTTER_SETTING_33'];
$spotter_set[34] = $settings_strings['SPOTTER_SETTING_34'];
$spotter_set[35] = $settings_strings['SPOTTER_SETTING_35'];
$spotter_set[36] = $settings_strings['SPOTTER_SETTING_36'];
$spotter_set[37] = $settings_strings['SPOTTER_SETTING_37'];
$spotter_set[38] = $settings_strings['SPOTTER_SETTING_38'];

//*********************************** VENUE *********************************************//
$venue_set = array();
$venue_set[0] =   $settings_strings['VENUE_SETTING_0'];
$venue_set[1] =   $settings_strings['VENUE_SETTING_1'];
$venue_set[2] =   $settings_strings['VENUE_SETTING_2'];
$venue_set[3] =   $settings_strings['VENUE_SETTING_3'];
$venue_set[4] =   $settings_strings['VENUE_SETTING_4'];
$venue_set[5] =   $settings_strings['VENUE_SETTING_5'];
$venue_set[6] =   $settings_strings['VENUE_SETTING_6'];
$venue_set[7] =   $settings_strings['VENUE_SETTING_7'];
$venue_set[8] =   $settings_strings['VENUE_SETTING_8'];
$venue_set[9] =   $settings_strings['VENUE_SETTING_9'];
$venue_set[10] =  $settings_strings['VENUE_SETTING_10'];
$venue_set[11] =  $settings_strings['VENUE_SETTING_11'];
$venue_set[12] =  $settings_strings['VENUE_SETTING_12'];
$venue_set[13] =  $settings_strings['VENUE_SETTING_13'];
$venue_set[14] =  $settings_strings['VENUE_SETTING_14'];
$venue_set[15] =  $settings_strings['VENUE_SETTING_15'];
$venue_set[16] =  $settings_strings['VENUE_SETTING_16'];
$venue_set[17] =  $settings_strings['VENUE_SETTING_17'];
$venue_set[18] =  $settings_strings['VENUE_SETTING_18'];
$venue_set[19] =  $settings_strings['VENUE_SETTING_19'];
$venue_set[20] =  $settings_strings['VENUE_SETTING_20'];
$venue_set[21] =  $settings_strings['VENUE_SETTING_21'];
$venue_set[22] =  $settings_strings['VENUE_SETTING_22'];
$venue_set[23] =  $settings_strings['VENUE_SETTING_23'];
$venue_set[24] =  $settings_strings['VENUE_SETTING_24'];
$venue_set[25] =  $settings_strings['VENUE_SETTING_25'];
$venue_set[26] =  $settings_strings['VENUE_SETTING_26'];
$venue_set[27] =  $settings_strings['VENUE_SETTING_27'];
$venue_set[28] =  $settings_strings['VENUE_SETTING_28'];
$venue_set[29] =  $settings_strings['VENUE_SETTING_29'];
$venue_set[30] =  $settings_strings['VENUE_SETTING_30'];
$venue_set[31] =  $settings_strings['VENUE_SETTING_31'];
$venue_set[32] =  $settings_strings['VENUE_SETTING_32'];
$venue_set[33] =  $settings_strings['VENUE_SETTING_33'];
$venue_set[34] =  $settings_strings['VENUE_SETTING_34'];
$venue_set[35] =  $settings_strings['VENUE_SETTING_35'];
$venue_set[36] =  $settings_strings['VENUE_SETTING_36'];
$venue_set[37] =  $settings_strings['VENUE_SETTING_37'];
$venue_set[38] =  $settings_strings['VENUE_SETTING_38'];
$venue_set[39] =  $settings_strings['VENUE_SETTING_39'];
$venue_set[40] =  $settings_strings['VENUE_SETTING_40'];

//*********************** Fine Array descrittivi specifici ***********************************************//

//*********************** Array delle possibili scelte ***************************************************//
//******************* JAMMER ************************************************//

/**
 * Restituisce un array di possibili valori per un determinato indice
 * @param unknown $type il tipo dell'utente: JAMMER, VENUE, SETTINGS
 * @param unknown $index indice del valore di array_val
 */
function getValues($type, $index){
	$jammer_val = array();
	$jammer_val[3] = "PUBLIC";
	$jammer_val[4] = "PUBLIC";
	$jammer_val[5] = "PUBLIC";
	$jammer_val[6] = "PUBLIC";
	$jammer_val[7] = "PUBLIC";
	$jammer_val[8] = "PUBLIC";
	$jammer_val[9] = "PUBLIC";
	$jammer_val[10] = "PUBLIC";
	$jammer_val[11] = "YES;CofC;NO";
	$jammer_val[12] = "PUBLIC;FOLLOWERS;FandC;COLLABORATORS ;NONE";
	$jammer_val[13] = "PUBLIC;FOLLOWERS;FandC;COLLABORATORS;NONE";
	$jammer_val[14] = "true;false";
	$jammer_val[15] = "true;false";
	$jammer_val[16] = "true;false";
	$jammer_val[17] = "true;false";
	$jammer_val[18] = "true;false";
	$jammer_val[19] = "true;false";
	$jammer_val[20] = "true;false";
	$jammer_val[21] = "true;false";
	$jammer_val[22] = "true;false";
	$jammer_val[23] = "true;false";
	$jammer_val[24] = "true;false";
	$jammer_val[25] = "true;false";
	$jammer_val[26] = "true;false";
	$jammer_val[27] = "true;false";
	$jammer_val[28] = "true;false";
	$jammer_val[29] = "true;false";
	$jammer_val[30] = "true;false";
	$jammer_val[31] = "true;false";
	$jammer_val[32] = "true;false";
	$jammer_val[33] = "true;false";
	$jammer_val[34] = "true;false";
	$jammer_val[35] = "true;false";
	$jammer_val[36] = "true;false";
	$jammer_val[37] = "true;false";
	$jammer_val[38] = "true;false";
	$jammer_val[39] = "true;false";
	$jammer_val[40] = "true;false";
	$jammer_val[41] = "true;false";
	$jammer_val[42] = "true;false";
	$jammer_val[43] = "true;false";
	$jammer_val[44] = "true;false";


	//************************************* SPOTTER ********************//
	$spotter_val = array();
	$spotter_val[3] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[4] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[5] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[6] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[7] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[8] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[9] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[10] = "ALL;CofC;NONE" ;
	$spotter_val[11] = "YES;CofC;NONE" ;
	$spotter_val[12] = "PUBLIC;FRIENDS;SELECTED;NONE" ;
	$spotter_val[13] = "PUBLIC;FRIENDS;SELECTED;NONE" ;
	$spotter_val[14] = "YES;PRIVATE_USERS;NO" ;
	$spotter_val[15] = "true;false" ;
	$spotter_val[16] = "true;false" ;
	$spotter_val[17] = "true;false" ;
	$spotter_val[18] = "true;false" ;
	$spotter_val[19] = "true;false" ;
	$spotter_val[20] = "true;false" ;
	$spotter_val[21] = "true;false" ;
	$spotter_val[22] = "true;false" ;
	$spotter_val[23] = "true;false" ;
	$spotter_val[24] = "true;false" ;
	$spotter_val[25] = "true;false" ;
	$spotter_val[26] = "true;false" ;
	$spotter_val[27] = "true;false" ;
	$spotter_val[28] = "true;false" ;
	$spotter_val[29] = "true;false" ;
	$spotter_val[30] = "true;false" ;
	$spotter_val[31] = "true;false" ;
	$spotter_val[32] = "true;false" ;
	$spotter_val[33] = "true;false" ;
	$spotter_val[34] = "true;false" ;
	$spotter_val[35] = "true;false" ;
	$spotter_val[36] = "true;false" ;
	$spotter_val[37] = "true;false" ;
	$spotter_val[38] = "true;false" ;

	//*********************************** VENUE *********************************************//
	$venue_val = array();
	$venue_val[3] = "PUBLIC" ;
	$venue_val[4] = "PUBLIC" ;
	$venue_val[5] = "PUBLIC" ;
	$venue_val[6] = "PUBLIC" ;
	$venue_val[7] = "PUBLIC" ;
	$venue_val[8] = "PUBLIC" ;
	$venue_val[9] = "PUBLIC" ;
	$venue_val[10] = "PUBLIC" ;
	$venue_val[11] = "YES;COLLABORATORS;NO" ;
	$venue_val[12] = "PUBLIC;FOLLORERS;FandC;COLLABORATORS;NONE" ;
	$venue_val[13] = "PUBLIC;FOLLOWERS;FandC;COLLABORATORS;NONE" ;
	$venue_val[14] = "true;false" ;
	$venue_val[15] = "true;false" ;
	$venue_val[16] = "true;false" ;
	$venue_val[17] = "true;false" ;
	$venue_val[18] = "true;false" ;
	$venue_val[19] = "true;false" ;
	$venue_val[20] = "true;false" ;
	$venue_val[21] = "true;false" ;
	$venue_val[22] = "true;false" ;
	$venue_val[23] = "true;false" ;
	$venue_val[24] = "true;false" ;
	$venue_val[25] = "true;false" ;
	$venue_val[26] = "true;false" ;
	$venue_val[27] = "true;false" ;
	$venue_val[28] = "true;false" ;
	$venue_val[29] = "true;false" ;
	$venue_val[30] = "true;false" ;
	$venue_val[31] = "true;false" ;
	$venue_val[32] = "true;false" ;
	$venue_val[33] = "true;false" ;
	$venue_val[34] = "true;false" ;
	$venue_val[35] = "true;false" ;
	$venue_val[36] = "true;false" ;
	$venue_val[37] = "true;false" ;
	$venue_val[38] = "true;false" ;
	$venue_val[39] = "true;false" ;
	$venue_val[40] = "true;false" ;

	$ret;
	switch ($type){
		case "JAMMER":
			$ret = explode(";", $jammer_val[$index]);
			break;

		case "SPOTTER":
			$ret = explode(";", $spotter_val[$index]);
			break;

		case "VENUE":
			$ret = explode(";", $venue_val[$index]);
			break;

	}
	return $ret;
}
?>
