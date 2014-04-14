<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'validateNewUser.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'recaptcha.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'connection.service.php';

define("CAPTCHA_PUBLIC_KEY", "6Lei6NYSAAAAAENpHWBBkHtd0ZbfAdRAtKMcvlaQ");
define("CAPTCHA_PRIVATE_KEY", "6Lei6NYSAAAAAOXsGrRhJxUqdFGt03jcqaABdJMn");

/**
 * SignupController class
 * Iscrizione dell'utente a Jamyourself
 * 
 * @author		Stafano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class SignupController extends REST {

    private $config;
    private $userValidator;

    /**
     * imposta il file di cunfigurazione e chiama il servizio di validazione utente
     * @todo
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "signupController.config.json"), false);
	$this->userValidator = new ValidateNewUserService($this->config);
    }

    /**
     * mette in sessione le informazioni per corretta visualizzazione
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
     * verifica esistenza della mail
     */
    public function checkEmailExists() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkEmailExists "No POST action"');
		$this->response(array('status' => $controllers["NOPOSTREQUEST"]), 406);
	    } elseif (!isset($this->request['email'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkEmailExists "No email set"');
		$this->response(array('status' => $controllers['NOMAILSPECIFIED']), 403);
	    }
	    $email = $this->request['email'];
	    $where = array("email" => $email);
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkEmailExists "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $res = selectUsers($connection, null, $where);
	    if ($res === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkEmailExists "Unable to excute selectUser"');
		$this->response(array("status" => $controllers["MAILCHECKERROR"]), 403);
	    }
	    $connectionService->disconnect($connection);
	    if (count($res) === 0) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] checkEmailExists executed');
		$this->response(array("status" => $controllers["VALIDMAIL"]), 200);
	    } else {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] checkEmailExists executed, mail error');
		$this->response(array("status" => $controllers["MAILERROREXISTS"]), 403);
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkEmailExists "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

    /**
     * verifica esistenza dello userName
     */
    public function checkUsernameExists() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkUsernameExists "No POST action"');
		$this->response(array('status' => $controllers["NOPOSTREQUEST"]), 406);
	    } elseif (!isset($this->request['username'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkEmailExists "No username set"');
		$this->response(array('status' => $controllers["NOUSERNAMESPECIFIED"]), 400);
	    }
	    $username = $this->request['username'];
	    $where = array("username" => $username);
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkUsernameExists "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $res = selectUsers($connection, null, $where);
	    if ($res === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkUsernameExists "Unable to excute selectUser"');
		$this->response(array("status" => $controllers["USERNAMECHECKERROR"]), 403);
	    }
	    $connectionService->disconnect($connection);
	    if (count($res) === 0) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] checkUsernameExists executed');
		$this->response(array("status" => $controllers["VALIDUSERNAME"]), 200);
	    } else {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] checkUsernameExists executed: error in username o email');
		$this->response(array("status" => $controllers["USERNAMEERROREXISTS"]), 403);
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during checkUsernameExists "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

    /**
     * funzione di recaptcha
     * 
     * @todo    ancora da implementare
     */
    public function recaptcha() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during recaptcha "No POST action"');
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 406);
	    } elseif (!isset($this->request['challengeField']) || !isset($this->request['responseField'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during recaptcha "challengefield/responde error"');
		$this->response(array('status' => $controllers["NOCAPTCHA"]), 403);
	    }
	    $challengeField = $this->request['challengeField'];
	    $responseField = $this->request['responseField'];
	    //da implementare
	    $resp = recaptcha_check_answer(CAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $challengeField, $responseField);
	    if ($resp->is_valid) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] recaptcha executed');
		$_SESSION['SignupCaptchaValidation'] = true;
		$this->response(array("status" => $controllers["CORRECTCAPTCHA"]), 200);
	    } else {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] recaptcha executed: error recaptcha');
		$_SESSION['SignupCaptchaValidation'] = false;
		$this->response(array("status" => $controllers["WRONGRECAPTCHA"]), 403);
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during recaptcha "Exception" => ' . $e->getMessage());
	    unset($_SESSION['SignupCaptchaValidation']);
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

    /**
     * registrazione utente al sito
     * verifico che l'utente abbia effettivamente completato il captcha,
     * 
     * @todo
     */
    public function signup() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during signup "No POST action"');
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    }
	    if (!isset($_SESSION['SignupCaptchaValidation']) || is_null($_SESSION['SignupCaptchaValidation']) || $_SESSION['SignupCaptchaValidation'] == false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during signup "recaptcha Error"');
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
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during signup "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $user = insertUser($connection, $newUser);
	    $node = createNode($connection, 'user', $user->getId());
	    if (!$user || !$node) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during signup "Unable to excute insertUser or createNode"');
		$this->response(array('status' => $controllers['NEWUSERCREATIONFAILED']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    $userId = $user->getId();
	    //$_SESSION['id'] == $userId;
	    $userType = $user->getType();
	    //$_SESSION['type'];
	    $this->createFileSystemStructure($userId, $userType);
	    $this->createDefaultAlbum($userId);
	    $this->createDefaultPlaylist($userId);
	    if ($user->getType() == "JAMMER") {
		$this->createDefaultRecord($userId);
	    }
	    if (!is_null($user->getThumbnail()) && strlen($user->getThumbnail()) > 0 && strlen($user->getAvatar()) && !is_null($user->getAvatar())) {
		$res_1 = false;
		$res_2 = false;
		$src_img = CACHE_DIR . $user->getAvatar();
		$src_thumb = CACHE_DIR . $user->getThumbnail();
		$fileManager = new FileManagerService();
		$dest_img = $fileManager->getPhotoPath($userId, $user->getAvatar());
		$dest_thumb = $fileManager->getPhotoPath($userId, $user->getThumbnail());
		if (file_exists($src_img)) {
		    $res_1 = rename($src_img, $dest_img);
		}
		if (file_exists($src_thumb)) {
		    $res_2 = rename($src_thumb, $dest_thumb);
		}
	    }
	    unset($_SESSION['captchaPublicKey']);
	    unset($_SESSION['config']);
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] signup executed');
	    $this->response(array("status" => $controllers['USERCREATED']), 200);
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during signup "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

    /**
     * crea album di default
     * 
     * @return $album
     * @todo
     */
    private function createDefaultAlbum($userId) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    return false;
	}
	require_once CLASSES_DIR . 'album.class.php';
	$album = new Album();
	$album->setActive(1);
	$album->setCommentcounter();
	$album->setCounter(0);
	$album->setCover(DEFALBUMCOVER);
	$album->setDescription(null);
	$album->setFromuser($userId);
	$album->setImagecounter(0);
	$album->setImages(array());
	$album->setLatitude(null);
	$album->setLongitude(null);
	$album->setLovecounter(0);
	$album->setSharecounter(0);
	$album->setTag(array());
	$album->setThumbnail(DEFALBUMTHUMB);
	$album->setTitle(DEF_ALBUM);
	$res = insertAlbum($connection, $album);
	$connectionService->disconnect($connection);
	return (!$res) ? false : $res;
    }

    /**
     * 
     * playlist di default
     * 
     * @return $playlist
     * @todo
     */
    private function createDefaultPlaylist($userId) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    return false;
	}
	require_once CLASSES_DIR . 'playlist.class.php';
	$playlist = new Playlist();
	$playlist->setActive(1);
	$playlist->setFromuser($userId);
	$playlist->setName(DEF_PLAY);
	$playlist->setUnlimited(false);
	$playlist->setSongs(array());
	$playlist->setSongcounter(0);
	$res = insertPlaylist($connection, $playlist);
	$connectionService->disconnect($connection);
	return (!$res) ? false : $res;
    }

    /**
     * crea record di default
     * 
     * @return  $record
     * @todo
     */
    private function createDefaultRecord($userId) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    return false;
	}
	require_once CLASSES_DIR . 'record.class.php';
	$record = new Record();
	$record->setActive(1);
	$record->getBuylink(null);
	$record->setCity(null);
	$record->setCommentcounter(0);
	$record->setCounter(0);
	$record->setCover(DEFRECORDCOVER);
	$record->setDescription(null);
	$record->setDuration(0);
	$record->setFromuser($userId);
	$record->getGenre(array());
	$record->getLabel(null);
	$record->setLatitude(null);
	$record->setLongitude(null);
	$record->setLovecounter(0);
	$record->setReviewcounter(0);
	$record->setSharecounter(0);
	$record->setThumbnail(DEFRECORDTHUMB);
	$record->setSongcounter(0);
	$record->setTitle(DEF_REC);
	$record->setYear(date("Y"));
	$res = insertRecord($connection, $record);
	$connectionService->disconnect($connection);
	return (!$res) ? false : $res;
    }

    /**
     * crea le cartelle per tipologia di utente
     * 
     * @todo
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
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createFileSystemStructure "Exception" => ' . $e->getMessage());
	    return false;
	}
    }

    /**
     * crea un utente di tipo SPOTTER
     * 
     * @return false in case of error, $user otherwise
     */
    private function createSpotter($userJSON) {
	if (!is_null($userJSON)) {
	    $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
	    $latitude = $infoLocation["latitude"];
	    $longitude = $infoLocation["longitude"];
	    $user = new User("SPOTTER");
	    $birthday = json_decode(json_encode($userJSON->birthday), false);
	    if (strlen($birthday->year) > 0 && strlen($birthday->month) > 0 && strlen($birthday->day) > 0) {
		$user->setBirthday($birthday->day . "-" . $birthday->month . "-" . $birthday->year);
	    }
	    $user->setCity($infoLocation['city']);
	    $user->setCountry($infoLocation['country']);
	    $this->setCommonValues($user, $userJSON);
	    $user->setCollaborationCounter(-1);
	    $user->setFirstname($userJSON->firstname);
	    $user->setFollowerscounter(-1);
	    $user->setFollowingcounter(0);
	    $user->setFriendshipCounter(0);
	    $user->setLastname($userJSON->lastname);
	    $user->setLatitude($latitude);
	    $user->setLongitude($longitude);
	    $user->setMusic($this->getMusicArray($userJSON->genre));
	    $user->setSex($userJSON->sex);
	    $user->setJammercounter(0);
	    $user->setVenuecounter(0);
	    return $user;
	}
	return null;
    }

    /**
     * crea un utente di tipo VENUE
     * 
     * @todo
     */
    private function createVenue($userJSON) {
	if (!is_null($userJSON)) {
	    $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
	    $latitude = $infoLocation["latitude"];
	    $longitude = $infoLocation["longitude"];
	    $user = new User("VENUE");
	    $user->setAddress($infoLocation['formattedAddress']);
	    $user->setCity($infoLocation['city']);
	    $user->setCountry($infoLocation['country']);
	    $this->setCommonValues($user, $userJSON);
	    $user->setCollaborationcounter(0);
	    $user->setFollowerscounter(0);
	    $user->setFollowingcounter(-1);
	    $user->setFriendshipcounter(-1);
	    $user->setLatitude($latitude);
	    $user->setLocalType($this->getLocalTypeArray($userJSON->genre));
	    $user->setLongitude($longitude);
	    $user->setJammercounter(0);
	    $user->setVenuecounter(0);
	    return $user;
	}
	return null;
    }

    /**
     * crea un utente di tipo JAMMER
     * 
     * @todo
     */
    private function createJammer($userJSON) {
	if (!is_null($userJSON)) {
	    $infoLocation = GeocoderService::getCompleteLocationInfo($userJSON->city);
	    $latitude = $infoLocation["latitude"];
	    $longitude = $infoLocation["longitude"];
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
     * Inizializza la variabile in funzione dell'utente
     * 
     * @todo
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
     * getLocalTypeArray($genre)
     * 
     * @param 	$genre
     * @todo
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
     * getMembersArray($members)
     * 
     * @param $members
     * @todo
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
     * getMusicArray($genre)	
     * 
     * @param $members
     * @todo
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
     * Inizializza con le impostazioni di default alcuni valori comuni a tutti gli utenti
     * 
     * @param $language
     * @param $localTime
     * @param $imgProfile
     * @return array $settings settings comuni a tutti i profili
     * @todo
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
     * Inizializza con le impostazioni di default per SPOTTER
     * 
     * @return array $settings settings per spotter
     * @todo
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
     * Inizializza con le impostazioni di default per VENUE
     * 
     * @return array $settings settings per venue
     * @todo
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
     * Inizializza con le impostazioni di default per JAMMER
     * 
     * @return array $settings settings per jammer
     * @todo
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
     * setta i valori comuni ai 3 tipi di utenti
     * 
     * @param $user
     * @param $decoded
     * @todo
     */
    private function setCommonValues($user, $decoded) {
	$imgInfo = getCroppedImages($decoded);
	$user->setActive(true);
	$user->setAvatar($imgInfo['picture']);
	$user->setBackground(DEFBGD);
	$user->setBadge(array());
	$user->setDescription($decoded->description);
	$user->setEmail($decoded->email);
	if (strlen($decoded->facebook))
	    $user->setFbPage($decoded->facebook);
	if (strlen($decoded->google))
	    $user->setGooglePlusPage($decoded->google);
	$user->setLevel(0);
	$user->setLevelValue(1);
	$user->setPassword(passwordEncryption($decoded->password));
	$user->setPremium(0);
	$user->setSettings($this->defineSettings($user->getType(), $decoded->language, $decoded->localTime, $imgInfo['picture']));
	$user->setThumbnail($imgInfo['thumbnail']);
	if (strlen($decoded->twitter))
	    $user->setTwitterPage($decoded->twitter);
	$user->setUsername($decoded->username);
	if (strlen($decoded->youtube))
	    $user->setYoutubeChannel($decoded->youtube);
	if (strlen($decoded->web))
	    $user->setWebsite($decoded->web);
    }

}

?>