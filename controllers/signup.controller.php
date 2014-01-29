<?php

/* ! \par		Info Generali:
 * \author		Stafano Muscas
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		signup.controller
 * \details		Iscrizione dell'utente a Jamyourself
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		utilizzo del recaptcha, usare chiavi del sito definitive, query su Location
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'validateNewUser.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'recaptcha.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

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
     * \fn	signup()
     * \brief	mette in sessione le informazioni per corretta visualizzazione
     * \return
     * \todo
     */
    public function init() {
        session_start();
        $_SESSION['captchaPublicKey'] = CAPTCHA_PUBLIC_KEY;
        $_SESSION['captchaValidation'] = false;
        $_SESSION['config'] = $this->config;
    }

    /**
     * \fn	signup()
     * \brief	registrazione utente al sito
     * \return
     * \todo
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
            $this->debug("signup", "start");
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            }
            $this->debug("signup", "request => " . var_export($this->request, true));

//verifico che l'utente abbia effettivamente completato il captcha
//        if ($_SESSION['captchaValidation'] == false) {
//            // If invalid inputs "Bad Request" status message and reason
//            $error = array('status' => "Bad Request", "msg" => "Captcha test failed");
//            $this->response($error, 400);
//        }
            $userJSON = $this->request;
            $this->userValidator->checkNewUser($userJSON);
            if (!$this->userValidator->getIsValid()) {
                $this->debug("signup", "validator errors => " . var_export($this->userValidator->getErrors(), true));
                $error = array('status' => "Bad Request", "msg" => "Invalid new user", "errorList" => $this->userValidator->getErrors());
                $this->response(array('status' => $controllers['INVALIDNEWUSER'], 'errors' => $error), 403);
            }
            $this->debug("signup", "validation => OK");
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
            $this->debug("signup", "newUser => " . var_export($newUser, true));
            $this->debug("signup", "saving user on DB");
            $pUser = new UserParse();
            $user = $pUser->saveUser($newUser);
            if ($user instanceof Error) {
                $this->debug("signup", "ERROR SAVING USER => " . var_export($user, true));
                $this->response(array('status' => $controllers['NEWUSERCREATIONFAILED']), 503);
            }
            $this->debug("signup", "user saved => " . var_export($user, true));
            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setFromUser($user->getObjectId());
            $activity->setRead(true);
            $activity->setStatus("A");
            $activity->setType("SIGNEDUP");
            $this->debug("signup", "saving activity on DB");
            $pActivity = new ActivityParse();
            $pActivity->saveActivity($activity);
            $this->debug("signup", "activity saved => " . var_export($activity, true));
            $_SESSION['currentUser'] = $user;
            $this->debug("signup", "create FileSystem Structure...");
            $this->createFileSystemStructure($user->getObjectId(), $user->getType());
            $this->createImageDefaultAlbum($user->getObjectId());
            if ($user->getType() == "JAMMER") {
                $this->createRecordDefaultAlbum($user->getObjectId());
            }

            if (!is_null($user->getProfileThumbnail()) && strlen($user->getProfileThumbnail()) > 0 && strlen($user->getProfilePicture()) && !is_null($user->getProfilePicture())) {
                $res_1 = false;
                $res_2 = false;
                $src_img = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $user->getProfilePicture();
                $dest_img = USERS_DIR . $user->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicture" . DIRECTORY_SEPARATOR . $user->getProfilePicture();
                $src_thumb = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $user->getProfileThumbnail();
                $dest_thumb = USERS_DIR . $user->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicturethumb" . DIRECTORY_SEPARATOR . $user->getProfileThumbnail();
                $this->debug("signup", "Source image : " . $src_img);
                $this->debug("signup", "Destination image : " . $dest_img);
                $this->debug("signup", "Source thumbnail : " . $src_thumb);
                $this->debug("signup", "Destination thumbnail : " . $dest_thumb);
                //profile image
                if (file_exists($src_img)) {
                    $res_1 = rename($src_img, $dest_img);
                    if ($res_1) {
                        $this->debug("signup", "Destination image : SAVED");
                    } else {
                        $this->debug("signup", "Destination image : NOT SAVED - ERROR!!!");
                    }
                } else {
                    $this->debug("signup", "Destination image : " . $src_img . " - FILE NOT FOUND - ERROR!!!");
                }
                //thumbnail
                if (file_exists($src_thumb)) {
                    $res_2 = rename($src_thumb, $dest_thumb);
                    if ($res_2) {
                        $this->debug("signup", "Destination thumbnail : SAVED");
                    } else {
                        $this->debug("signup", "Destination thumbnail : NOT SAVED - ERROR!!!");
                    }
                } else {
                    $this->debug("signup", "Destination thumbnail : " . $src_thumb . " - FILE NOT FOUND - ERROR!!!");
                }
            } else {
                $this->debug("signup", "no image or thumbnail specified for this user");
            }
            $this->debug("signup", "signup END => USER CREATED");
            $this->response(array("status" => $controllers['USERCREATED']), 200);
        } catch (Exception $e) {
            $this->debug("signup", "Exception => " . var_export($e, true));
            $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    /**
     * \fn	recaptcha()
     * \brief	funzione di recaptcha
     * \todo    ancora da implementare
     */
    public function recaptcha() {
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 406);
            } elseif (!isset($this->request['challengeField']) || !isset($this->request['responseField'])) {
                $this->response(array('status' => $controllers["NOCAPTCHA"]), 403);
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
     * \fn	checkEmailExists()
     * \brief	verifica esistenza della mail
     * \todo
     */
    public function checkEmailExists() {
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers["NOPOSTREQUEST"]), 406);
            } elseif (!isset($this->request['email'])) {
                $this->response(array('status' => $controllers['NOMAILSPECIFIED']), 403);
            }
            $email = $this->request['email'];
            $up = new UserParse();
            $up->where("email", $email);
            $res = $up->getCount();
            if ($res < 1) {
                $this->response(array("status" => $controllers["VALIDMAIL"]), 200);
            } else {
                $this->response(array("status" => $controllers["MAILALREADYEXISTS"]), 403);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

    /**
     * \fn	checkUsernameExists()
     * \brief	verifica esistenza dello userName
     * \todo
     */
    public function checkUsernameExists() {
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers["NOPOSTREQUEST"]), 406);
            } elseif (!isset($this->request['username'])) {
                $this->response(array('status' => $controllers["NOUSERNAMESPECIFIED"]), 400);
            }
            $username = $this->request['username'];
            $up = new UserParse();
            $up->where("username", $username);
            $res = $up->getCount();
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
     * \fn	createFileSystemStructure($userId, $type)
     * \brief	crea le cartelle per tipologia di utente
     * \todo
     */
    private function createFileSystemStructure($userId, $type) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                mkdir(USERS_DIR . $userId, 0777, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images", 0777, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicturethumb", 0777, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "profilepicture", 0777, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcover", 0777, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "albumcoverthumb", 0777, true);
                mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "photos", 0777, true);

                if ($type == "JAMMER") {
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover", 0777, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb", 0777, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb", 0777, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcover", 0777, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs", 0777, true);
                } elseif ($type == "VENUE") {
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb", 0777, true);
                    mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcover", 0777, true);
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * \fn	createImageDefaultAlbum($userId)
     * \brief	crea album di default
     * \todo
     */
    private function createImageDefaultAlbum($userId) {
        require_once CLASSES_DIR . 'album.class.php';
        require_once CLASSES_DIR . 'albumParse.class.php';
        $album = new Album();
        $album->setActive(true);
        $album->setCounter(0);
        $album->setFromUser($userId);
        $album->setLoveCounter(0);
        $album->setShareCounter(0);
        $album->setTitle('Default Album');
        $pAlbum = new AlbumParse();
        return $pAlbum->saveAlbum($album);
    }

    /**
     * \fn	createRecordDefaultAlbum($userId)
     * \brief	crea record di default
     * \todo
     */
    private function createRecordDefaultAlbum($userId) {
        require_once CLASSES_DIR . 'record.class.php';
        require_once CLASSES_DIR . 'recordParse.class.php';
        $record = new Record();
        $record->setActive(true);
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

    /**
     * \fn	createSpotter($userJSON)
     * \brief	crea un utente di tipo SPOTTER
     * \todo
     */
    private function createSpotter($userJSON) {
        $this->debug("createSpotter", "START");
        $this->debug("createSpotter", "userJSON => " . var_export($userJSON, true));
        if (!is_null($userJSON)) {
            $user = new User("SPOTTER");
            $this->setCommonValues($user, $userJSON);
            $user->setCollaborationCounter(-1);
            $user->setFollowersCounter(-1);
            $user->setFollowingCounter(0);
            $user->setFriendshipCounter(0);
            $user->setJammerCounter(0);
            $user->setVenueCounter(0);
            $user->setFirstname($userJSON->firstname);
            $user->setLastname($userJSON->lastname);

            $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
            $parseGeoPoint = new parseGeoPoint($infoLocation["latitude"], $infoLocation["longitude"]);
            $user->setCity($infoLocation['city']);
            $user->setCountry($infoLocation['country']);
            $user->setGeoCoding($parseGeoPoint);

            $user->setMusic($this->getMusicArray($userJSON->genre));
            $user->setSex($userJSON->sex);
            $birthday = json_decode(json_encode($userJSON->birthday), false);
            if (strlen($birthday->year) > 0 && strlen($birthday->month) > 0 && strlen($birthday->day) > 0) {
                $user->setBirthDay($birthday->day . "-" . $birthday->month . "-" . $birthday->year);
            }
            $this->debug("createSpotter", "returning user => " . var_export($user, true));
            return $user;
        }
        return null;
    }

    /**
     * \fn	createVenue$userJSON)
     * \brief	crea un utente di tipo VENUE
     * \todo
     */
    private function createVenue($userJSON) {
        $this->debug("createVenue", "START");
        $this->debug("createVenue", "userJSON => " . var_export($userJSON, true));
        if (!is_null($userJSON)) {
            $user = new User("VENUE");
            $this->setCommonValues($user, $userJSON);
            $user->setCollaborationCounter(0);
            $user->setFollowersCounter(0);
            $user->setFollowingCounter(-1);
            $user->setFriendshipCounter(-1);
            $user->setJammerCounter(0);
            $user->setVenueCounter(0);

            $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
            $parseGeoPoint = new parseGeoPoint($infoLocation["latitude"], $infoLocation["longitude"]);
            $user->setCity($infoLocation['city']);
            $user->setCountry($infoLocation['country']);
            $user->setAddress($infoLocation['formattedAddress']);
            $user->setGeoCoding($parseGeoPoint);

            $user->setLocalType($this->getLocalTypeArray($userJSON->genre));
            $this->debug("createVenue", "returning  user => " . var_export($user, true));
            return $user;
        }
        return null;
    }

    /**
     * \fn	createJammer($userJSON)
     * \brief	crea un utente di tipo JAMMER
     * \todo
     */
    private function createJammer($userJSON) {
        $this->debug("createJammer", "START");
        $this->debug("createJammer", "userJSON => " . var_export($userJSON, true));
        if (!is_null($userJSON)) {
            $user = new User("JAMMER");
            $this->setCommonValues($user, $userJSON);
            $user->setCollaborationCounter(0);
            $user->setFollowersCounter(0);
            $user->setFollowingCounter(-1);
            $user->setFriendshipCounter(-1);
            $user->setJammerCounter(0);
            $user->setVenueCounter(0);
            $user->setJammerType($userJSON->jammerType);

            $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
            $parseGeoPoint = new parseGeoPoint($infoLocation["latitude"], $infoLocation["longitude"]);
            $user->setCity($infoLocation['city']);
            $user->setCountry($infoLocation['country']);
            $user->setGeoCoding($parseGeoPoint);

            if ($userJSON->jammerType == "band") {
                $user->setMembers($this->getMembersArray($userJSON->members));
            }
            $user->setMusic($this->getMusicArray($userJSON->genre));
            $this->debug("createJammer", "returning user => " . var_export($user, true));
            return $user;
        }
        return null;
    }

    /**
     * \fn	defineSettings($user_type, $language, $localTime, $imgProfile)
     * \brief	Inizializza la variabile in funzione dell'utente
     * \todo
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
     * \fn	getLocalTypeArray($genre)
     * \brief	
     * \todo
     */
    private function getLocalTypeArray($genre) {
        if (count($genre) > 0) {
            $return = array();
            foreach ($genre as $val) {
                $return[] = $val;
            }
            return $return;
        }
        else
            return null;
    }

    /**
     * \fn	getMembersArray($members)
     * \brief	
     * \todo
     */
    private function getMembersArray($members) {
        if (count($members) > 0) {
            $return = array();
            foreach ($members as $member) {
                array_push($return, $member->name);
                array_push($return, $member->instrument);
            }
            return $return;
        }
        else
            return null;
    }

    /**
     * \fn	getMusicArray($genre)
     * \brief	
     * \todo
     */
    private function getMusicArray($genre) {
        if (count($genre) > 0) {
            $return = array();
            foreach ($genre as $val) {
                $return[] = $val;
            }
            return $return;
        }
        else
            return null;
    }

    /**
     * \fn	init_common_settings($language, $localTime, $imgProfile)
     * \brief	Inizializza con le impostazioni di default alcuni valori comuni a tutti gli utenti
     * \todo
     */
    private function init_common_settings($language, $localTime, $imgProfile) {
        $settings = array();
        $settings[0] = $language;
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
     * \fn	init_spotter_settings()
     * \brief	Inizializza con le impostazioni di default per SPOTTER
     * \todo
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
     * \fn	init_venue_settings($settings)
     * \brief	Inizializza con le impostazioni di default per VENUE
     * \todo
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

    /**
     * \fn	init_jammer_settings()
     * \brief	Inizializza con le impostazioni di default per JAMMER
     * \todo
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
     * \fn	setCommonValues($user, $decoded)
     * \brief	setta i valori comuni ai 3 tipi di utenti
     * \todo
     */
    private function setCommonValues($user, $decoded) {
        $user->setUsername($decoded->username);
        $user->setEmail($decoded->email);
        $user->setPassword($decoded->password);
        $user->setDescription($decoded->description);
        require_once CONTROLLERS_DIR . "utilsController.php";
        $imgInfo = getCroppedImages($decoded);
        $user->setSettings($this->defineSettings($user->getType(), $decoded->language, $decoded->localTime, $imgInfo['picture']));
        $user->setProfilePicture($imgInfo['picture']);
        $user->setProfileThumbnail($imgInfo['thumbnail']);
        if (strlen($decoded->facebook))
            $user->setFbPage($decoded->facebook);
        if (strlen($decoded->twitter))
            $user->setTwitterPage($decoded->twitter);
        if (strlen($decoded->google))
            $user->setGooglePlusPage($decoded->google);
        if (strlen($decoded->youtube))
            $user->setYoutubeChannel($decoded->youtube);
        if (strlen($decoded->web))
            $user->setWebsite($decoded->web);
        $user->setBadge(array());
        $parseACL = new parseACL();
        $parseACL->setPublicReadAccess(true);
        $user->setACL($parseACL);
        $user->setActive(true);
        $user->setBackground(DEFBGD);
        $user->setLevel(0);
        $user->setLevelValue(1);
        $user->setPremium(false);
    }

    private function debug($function, $msg) {
        $path = "signup.controller/";
        $file = date("Ymd"); //today
        debug($path, $file, $function . " | " . $msg);
    }

}

?>