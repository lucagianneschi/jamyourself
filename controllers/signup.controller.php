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
 * \todo		query su Location, fare API su Wiki
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
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'utils.service.php';

define("CAPTCHA_PUBLIC_KEY", "6Lei6NYSAAAAAENpHWBBkHtd0ZbfAdRAtKMcvlaQ");
define("CAPTCHA_PRIVATE_KEY", "6Lei6NYSAAAAAOXsGrRhJxUqdFGt03jcqaABdJMn");

class SignupController extends REST {

    private $config;
    private $userValidator;

    /**
     * \fn	__construct()
     * \brief	imposta il file di cunfigurazione e chiama il servizio di validazione utente
     * \todo
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "signupController.config.json"), false);
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
	if (isset($_SESSION['SignupCaptchaValidation'])) {
	    unset($_SESSION['SignupCaptchaValidation']);
	}
	$_SESSION['config'] = $this->config;
    }

    /**
     * \fn	checkEmailExists()
     * \brief	verifica esistenza della mail
     * \todo    vedi ISSUE #79
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
     * \todo    vedi ISSUE #79
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
		$_SESSION['SignupCaptchaValidation'] = true;
		$this->response(array("status" => $controllers["CORRECTCAPTCHA"]), 200);
	    } else {
		$_SESSION['SignupCaptchaValidation'] = false;
		$this->response(array("status" => $controllers["WRONGRECAPTCHA"]), 403);
	    }
	} catch (Exception $e) {
	    unset($_SESSION['SignupCaptchaValidation']);
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
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
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    }
	    //verifico che l'utente abbia effettivamente completato il captcha
	    if (!isset($_SESSION['SignupCaptchaValidation']) || is_null($_SESSION['SignupCaptchaValidation']) || $_SESSION['SignupCaptchaValidation'] == false) {
		// If invalid inputs "Bad Request" status message and reason
		$this->response(array('status' => $controllers['NOCAPTCHAVALIDATION']), 401);
	    } else {
		unset($_SESSION['SignupCaptchaValidation']);
	    }
	    $userJSON = $this->request;
	    $this->userValidator->checkNewUser($userJSON);
	    if (!$this->userValidator->getIsValid()) {
		$error = array('status' => "Bad Request", "msg" => "Invalid new user", "errorList" => $this->userValidator->getErrors());
		$this->response(array('status' => $controllers['INVALIDNEWUSER'], 'errors' => $error), 403);
	    }
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
	    $pUser = new UserParse();
	    $user = $pUser->saveUser($newUser);
	    if ($user instanceof Error) {
		$this->response(array('status' => $controllers['NEWUSERCREATIONFAILED']), 503);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setFromuser($user->getId());
	    $activity->setRead(true);
	    $activity->setStatus("A");
	    $activity->setType("SIGNEDUP");
	    $pActivity = new ActivityParse();
	    $pActivity->saveActivity($activity);
	    $_SESSION['currentUser'] = $user;
	    $this->createFileSystemStructure($user->getId(), $user->getType());
	    $this->createDefaultAlbum($user->getId());
	    $this->createDefaultPlaylist($user->getId());
	    if ($user->getType() == "JAMMER") {
		$this->createDefaultRecord($user->getId());
	    }
	    if (!is_null($user->getThumbnail()) && strlen($user->getThumbnail()) > 0 && strlen($user->getAvatar()) && !is_null($user->getAvatar())) {
		$res_1 = false;
		$res_2 = false;
		$src_img = CACHE_DIR . $user->getAvatar();
		$src_thumb = CACHE_DIR . $user->getThumbnail();
		$fileManager = new FileManagerService();
		$dest_img = $fileManager->getPhotoPath($user->getId(), $user->getAvatar());
		$dest_thumb = $fileManager->getPhotoPath($user->getId(), $user->getThumbnail());
		if (file_exists($src_img)) {
		    $res_1 = rename($src_img, $dest_img);
		}
		if (file_exists($src_thumb)) {
		    $res_2 = rename($src_thumb, $dest_thumb);
		}
	    }
	    unset($_SESSION['captchaPublicKey']);
	    unset($_SESSION['config']);
	    $this->response(array("status" => $controllers['USERCREATED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

    /**
     * \fn	createDefaultAlbum($userId)
     * \brief	crea album di default
     * \todo
     */
    private function createDefaultAlbum($userId) {
	require_once CLASSES_DIR . 'album.class.php';
	require_once CLASSES_DIR . 'albumParse.class.php';
	$album = new Album();
	$album->setActive(true);
	$album->setCounter(0);
	$album->setFromuser($userId);
	$album->setLovecounter(0);
	$album->setSharecounter(0);
	$album->setTitle(DEF_ALBUM);
	$pAlbum = new AlbumParse();
	return $pAlbum->saveAlbum($album);
    }

    /**
     * \fn	createDefaultRecord($userId)
     * \brief	crea record di default
     * \return  $record
     * \todo
     */
    private function createDefaultRecord($userId) {
	require_once CLASSES_DIR . 'record.class.php';
	$record = new Record();
	$record->setActive(true);
	$record->setDuration(0);
	$record->setFromuser($userId);
	$record->setLovecounter(0);
	$record->setReviewcounter(0);
	$record->setSharecounter(0);
	$record->setTitle(DEF_REC);
	$record->setYear(date("Y"));
	return $record;
    }

    /**
     * \fn	createDefaultPlaylist($userId)
     * \brief	crea playslit di default
     * \todo
     */
    private function createDefaultPlaylist($userId) {
	require_once CLASSES_DIR . 'playlist.class.php';
	$playlist = new Playlist();
	$playlist->setActive(true);
	$playlist->setFromuser($userId);
	$playlist->setName(DEF_PLAY);
	$playlist->setUnlimited(false);
	return $playlist;
    }

    /**
     * \fn	createFileSystemStructure($userId, $type)
     * \brief	crea le cartelle per tipologia di utente
     * \todo
     */
    private function createFileSystemStructure($userId, $type) {
	try {
	    $fileManager = new FileManagerService();
	    if (!is_null($userId) && strlen($userId) > 0) {
		$fileManager->createPhotoDir($userId);
		if ($type == "JAMMER") {
		    $fileManager->createSongsDir($userId);
		    $fileManager->createRecordPhotoDir($userId);
		    $fileManager->createEventPhotoDir($userId);
		} elseif ($type == "VENUE") {
		    $fileManager->createEventPhotoDir($userId);
		}
	    }
	} catch (Exception $e) {
	    return false;
	}
    }

    /**
     * \fn	createSpotter($userJSON)
     * \brief	crea un utente di tipo SPOTTER
     * \todo
     */
    private function createSpotter($userJSON) {
	if (!is_null($userJSON)) {
	    $user = new User("SPOTTER");
	    $this->setCommonValues($user, $userJSON);
	    $user->setCollaborationCounter(-1);
	    $user->setFollowerscounter(-1);
	    $user->setFollowingcounter(0);
	    $user->setFriendshipCounter(0);
	    $user->setJammercounter(0);
	    $user->setVenuecounter(0);
	    $user->setFirstname($userJSON->firstname);
	    $user->setLastname($userJSON->lastname);
	    $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
	    $latitude = $infoLocation["latitude"];
	    $longitude = $infoLocation["longitude"];
	    $user->setLatitude($latitude);
	    $user->setLongitude($longitude);
	    $user->setCity($infoLocation['city']);
	    $user->setCountry($infoLocation['country']);
	    $user->setMusic($this->getMusicArray($userJSON->genre));
	    $user->setSex($userJSON->sex);
	    $birthday = json_decode(json_encode($userJSON->birthday), false);
	    if (strlen($birthday->year) > 0 && strlen($birthday->month) > 0 && strlen($birthday->day) > 0) {
		$user->setBirthday($birthday->day . "-" . $birthday->month . "-" . $birthday->year);
	    }
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
	if (!is_null($userJSON)) {
	    $user = new User("VENUE");
	    $this->setCommonValues($user, $userJSON);
	    $user->setCollaborationcounter(0);
	    $user->setFollowerscounter(0);
	    $user->setFollowingcounter(-1);
	    $user->setFriendshipcounter(-1);
	    $user->setJammercounter(0);
	    $user->setVenuecounter(0);
	    $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
	    $latitude = $infoLocation["latitude"];
	    $longitude = $infoLocation["longitude"];
	    $user->setLatitude($latitude);
	    $user->setLongitude($longitude);
	    $user->setCity($infoLocation['city']);
	    $user->setCountry($infoLocation['country']);
	    $user->setAddress($infoLocation['formattedAddress']);
	    $user->setLocalType($this->getLocalTypeArray($userJSON->genre));
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
	if (!is_null($userJSON)) {
	    $user = new User("JAMMER");
	    $user->setCity($infoLocation['city']);
	    $user->setCountry($infoLocation['country']);
	    $this->setCommonValues($user, $userJSON);
	    $user->setCollaborationcounter(0);
	    $user->setFollowerscounter(0);
	    $user->setFollowingcounter(-1);
	    $user->setFriendshipCounter(-1);
	    $user->setJammercounter(0);
	    $user->setVenuecounter(0);
	    $user->setJammerType($userJSON->jammerType);
	    $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
	    $latitude = $infoLocation["latitude"];
	    $longitude = $infoLocation["longitude"];
	    $user->setLatitude($latitude);
	    $user->setLongitude($longitude);
	    if ($userJSON->jammerType == "band") {
		$user->setMembers($this->getMembersArray($userJSON->members));
	    }
	    $user->setMusic($this->getMusicArray($userJSON->genre));
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
	$settings[1] = $localTime;
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
     * \fn	passwordEncryption()
     * \brief	cripta la password prima di scriverla sul DB
     * \todo    VEDI ISSUE #78
     */
    private function passwordEncryption() {
	
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

}

?>
