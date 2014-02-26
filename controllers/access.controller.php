<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di login e logout
 * \details		effettua operazioni di login e logut utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		terminare la funzione logout e socialLogin; fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR 'user.class.php';

/**
 * \brief	ReviewController class 
 * \details	controller di inserimento di una review 
 */
class AccessController extends REST {

    /**
     * \fn      login()
     * \brief   user login
     * \todo    
     */
    public function login() {
	try {
	    global $controllers;
	    if ($_SESSION['id'] && $_SESSION['username']) {
		$this->response(array('status' => $controllers['ALREADYLOGGEDIND']), 405);
	    }
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    }
	    if (!isset($this->request['usernameOrEmail']) || !isset($this->request['password'])) {
		$this->response(array('status' => $controllers['NO CREDENTIALS']), 405);
	    }
	    $name = mysqli_real_escape_string(stripslashes($this->request['usernameOrEmail']));
	    $password = mysqli_real_escape_string(stripslashes($this->request['password']));
	    $user = $this->checkEmailOrUsername($password, $name);
	    if (!$user) {
		$this->response(array('status' => 'INVALID CREDENTIALS'), 503);
	    }
	    $_SESSION['id'] = $user->getId();
	    $_SESSION['username'] = $user->getUsername();
	    $this->response(array('status' => $controllers['OKLOGIN']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn      logout()
     * \brief   user logout
     * \todo    
     */
    public function logout() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id']) || !isset($_SESSION['username']) ) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    session_unset();
	    session_destroy();
	    $this->response(array('status' => $controllers['OKLOGOUT']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn      private function checkEmailOrUsername($password, $name)
     * \brief   check if user credentials are correct
     * \param   $password, $name
     * \todo    
     */
    private function checkEmailOrUsername($password, $name) {
	if (is_null($name) || is_null($password)) {
	    return false;
	}
	require_once SERVICES_DIR . 'connection.service.php';
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    return false;
	} else {
	    $sql = "SELECT id,
                           active,
                           address,
                           avatar,
                           background,
                           birthday,
                           city,
                           collaborationcounter,
                           country,
                           createdat,
                           description,
                           email,
                           facebookid,
                           facebookpage,
                           firstname,
                           followerscounter,
                           followingcounter,
                           friendshipcounter,
                           googlepluspage,
                           jammercounter,
                           jammertype,
                           lastname,
                           level,
                           levelvalue,
                           latitude,
                           longitude,
                           premium,
                           premiumexpirationdate,
                           sex,
                           thumbnail,
                           twitterpage,
                           type,
                           updatedat,
                           username,
                           venuecounter,
                           website,
                           youtubechannel 
		      FROM user
		     WHERE password='$password'
		       AND active = 1
		       AND username='$name' 
			OR email='$name'";
	    $result = mysqli_query($connectionService->connection, $sql);
	    if (!$result || (mysql_num_rows($result) != 1)) {
		return false;
	    }
	    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	    $user = new User($row[0]['type']);
	    $user->setId($row[0]['id']);
	    $user->setActive($row[0]['active']);
	    $user->setAddress($row[0]['address']);
	    $user->setAvatar($row[0]['avatar']);
	    $user->setBackground($row[0]['background']);
	    $user->setBirthday($row[0]['birthday']);
	    $user->setCity($row[0]['city']);
	    $user->setCollaborationcounter($row[0]['collaborationcounter']);
	    $user->setCountry($row[0]['country']);
	    $user->setCreatedat($row[0]['createdat']);
	    $user->setDescription($row[0]['description']);
	    $user->setEmail($row[0]['email']);
	    $user->setFacebookId($row[0]['facebookid']);
	    $user->setFbPage($row[0]['facebookpage']);
	    $user->setFirstname($row['firstname']);
	    $user->setFollowerscounter($row[0]['followerscounter']);
	    $user->setFollowingcounter($row[0]['followingcounter']);
	    $user->setFriendshipcounter($row[0]['friendshipcounter']);
	    $user->setGooglepluspage($row[0]['googlepluspage']);
	    $user->setJammercounter($row[0]['jammercounter']);
	    $user->setJammertype($row[0]['jammertype']);
	    $user->setLastname($row[0]['lastname']);
	    $user->setLevel($row[0]['level']);
	    $user->setLevelvalue($row['levelvalue']);
	    $user->setLatitude($row[0]['latitude']);
	    $user->setLongitude($row[0]['longitude']);
	    $user->setMembers($row[0]['members']);
	    $user->setPremium($row[0]['premium']);
	    $user->setPremiumexpirationdate($row[0]['premiumexpirationdate']);
	    //TODO --> recuperare settings
	    $user->setSettings($row[0]['settings']);
	    $user->setSex($row[0]['sex']);
	    $user->setThumbnail($row[0]['thumbnail']);
	    $user->setTwitterpage($row[0]['twitterpage']);
	    $user->setUpdatedat($row[0]['updatedat']);
	    $user->setUsername($row[0]['username']);
	    $user->setVenuecounter($row[0]['venuecounter']);
	    $user->setWebsite($row[0]['website']);
	    $user->setYoutubechannel($row[0]['youtubechannel']);
	    return $user;
	}
    }

}

?>