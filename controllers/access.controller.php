<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di login e logout
 * \details		effettua operazioni di login e logut utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'connection.service.php';
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
				#TODO			
	//			$this -> response(array('status' => $controllers['ALREADYLOGGEDIND']), 405);
			}
			if ($this -> get_request_method() != "POST") {
				$this -> response(array('status' => $controllers['NOPOSTREQUEST']), 405);
			}
			if (!isset($this -> request['usernameOrEmail']) || !isset($this -> request['password'])) {
				$this -> response(array('status' => $controllers['NO CREDENTIALS']), 405);
			}
			$connectionService = new ConnectionService();
			$connectionService -> connect();
			if($connectionService -> getActive()){
				$name = mysqli_real_escape_string($connectionService -> getConnection(), stripslashes($this -> request['usernameOrEmail']));
				$password = mysqli_real_escape_string($connectionService -> getConnection(), stripslashes($this -> request['password']));
				$user = $this -> checkEmailOrUsername($connectionService, $password, $name);				
				
				if (!$user) {
					$this -> response(array('status' => 'INVALID CREDENTIALS'), 503);
				}
				#TODO currentUser da eliminare 
				$_SESSION['currentUser'] = $user;
				$this -> response(array('status' => $_SESSION['currentUser']-> getId() ), 200);
				$_SESSION['id'] = $user -> getId();
				$_SESSION['username'] = $user -> getUsername();
				$_SESSION['type'] = $user -> getType();
				$this -> response(array('status' => $controllers['OKLOGIN']), 200);
				$connectionService -> disconnect();
			}			
			else $this -> response(array('status' => 'ERROR CONNECT'), 503); #TODO
		} catch (Exception $e) {
			$this -> response(array('status' => $e -> getMessage()), 503);
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
			if ($this -> get_request_method() != "POST") {
				$this -> response(array('status' => $controllers['NOPOSTREQUEST']), 405);
			} elseif (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
				$this -> response(array('status' => $controllers['USERNOSES']), 403);
			}
			session_unset();
			session_destroy();
			$this -> response(array('status' => $controllers['OKLOGOUT']), 200);
		} catch (Exception $e) {
			$this -> response(array('status' => $e -> getMessage()), 503);
		}
	}

	/**
	 * \fn      private function checkEmailOrUsername($password, $name)
	 * \brief   check if user credentials are correct
	 * \param   $password, $name
	 * \todo
	 */
	private function checkEmailOrUsername($connectionService, $password, $name) {
		if (is_null($name) || is_null($password)) {
			return false;
		}		
		if (!$connectionService -> getActive()) {
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
		      WHERE password='$password' AND active = 1
		       AND (username='$name' OR email='$name')";
			$result = mysqli_query($connectionService -> getConnection(), $sql);
			if (!$result || (mysqli_num_rows($result) != 1)) {
				return false;
			}			
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$user = new User();
			$user -> setId($row['id']);
			$user -> setActive($row['active']);
			$user -> setAddress($row['address']);
			$user -> setAvatar($row['avatar']);
			$user -> setBackground($row['background']);
			$user -> setBirthday($row['birthday']);
			$user -> setCity($row['city']);
			$user -> setCollaborationcounter($row['collaborationcounter']);
			$user -> setCountry($row['country']);
			#TODO
	//		$user -> setCreatedat($row['createdat']);
			$user -> setDescription($row['description']);
			$user -> setEmail($row['email']);
			$user -> setFacebookId($row['facebookid']);
			$user -> setFacebookpage($row['facebookpage']);
			$user -> setFirstname($row['firstname']);
			$user -> setFollowerscounter($row['followerscounter']);
			$user -> setFollowingcounter($row['followingcounter']);
			$user -> setFriendshipcounter($row['friendshipcounter']);
			$user -> setGooglepluspage($row['googlepluspage']);
			$user -> setJammercounter($row['jammercounter']);
			$user -> setJammertype($row['jammertype']);
			$user -> setLastname($row['lastname']);
			$user -> setLevel($row['level']);
			$user -> setLevelvalue($row['levelvalue']);
			$user -> setLatitude($row['latitude']);
			$user -> setLongitude($row['longitude']);
			$user -> setMembers($row['members']);
			$user -> setPremium($row['premium']);
			$user -> setPremiumexpirationdate($row['premiumexpirationdate']);
			//TODO --> recuperare settings
			$user -> setSettings($row['settings']);
			$user -> setSex($row['sex']);
			$user -> setThumbnail($row['thumbnail']);
			$user->setType($row['type']);
			$user -> setTwitterpage($row['twitterpage']);
			#TODO
	//		$user -> setUpdatedat($row['updatedat']);
			$user -> setUsername($row['username']);
			$user -> setVenuecounter($row['venuecounter']);
			$user -> setWebsite($row['website']);
			$user -> setYoutubechannel($row['youtubechannel']);
			return $user;
		}
	}

}
?>