<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info utente
 * \details		Recupera le informazioni dell'utente, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class infoBox {

    public function sendInfo($objectId) {
	$userParse = new UserParse();
	$user = $userParse->getUser($objectId);
	if (get_class($user) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $user->getErrorMessage() . '<br/>';
	} else {
	    $userName = $user->getUsername();
	    $backGround = $user->getBackGround();
	    $profilePicture = $user->getProfilePicture();
	    $description = $user->getDescription();
	    $city = $user->getCity();
	    $country = $user->getCountry();
	    $fbPage = $user->getFbPage();
	    $twitterPage = $user->getTwitterPage();
	    $webSite = $user->getWebsite();
	    $youtubeChannel = $user->getYoutubeChannel();
	    $googlePlusPage = $user->getGooglePlusPage();
	    $level = $user->getLevel();
	    $levelValue = $user->getLevelValue();

	    $type = $user->getType();
	    switch ($type) {
		case 'SPOTTER':
		    $followingCounter = $user->getFollowingCounter();
		    $frindshipCounter = $user->getFriendshipCounter();
		    $venueCounter = $user->getVenueCounter();
		    $jammerCounter = $user->getJammerCounter();
		    $music = $user->getMusic();
		    $resultArray = array('userName' => $userName,
			'backGround' => $backGround,
			'profilePicture' => $profilePicture,
			'description' => $description,
			'city' => $city,
			'country' => $country,
			'fbPage' => $fbPage,
			'twitterPage' => $twitterPage,
			'webSite' => $webSite,
			'youtubeChannel' => $youtubeChannel,
			'googlePlusPage' => $googlePlusPage,
			'level' => $level,
			'levelValue' => $levelValue,
			'music' => $music,
			'followingCounter' => $followingCounter,
			'frindshipCounter' => $frindshipCounter,
			'venueCounter' => $venueCounter,
			'jammerCounter' => $jammerCounter);
		    break;
		case 'JAMMER':
		    $followersCounter = $user->getFollowersCounter();
		    $collaborationCounter = $user->getCollaborationCounter();
		    $venueCounter = $user->getVenueCounter();
		    $jammerCounter = $user->getJammerCounter();
		    $music = $user->getMusic();
		    $members = $user->getMembers();
		    $resultArray = array('userName' => $userName,
			'backGround' => $backGround,
			'profilePicture' => $profilePicture,
			'description' => $description,
			'city' => $city,
			'country' => $country,
			'fbPage' => $fbPage,
			'twitterPage' => $twitterPage,
			'webSite' => $webSite,
			'youtubeChannel' => $youtubeChannel,
			'googlePlusPage' => $googlePlusPage,
			'level' => $level,
			'levelValue' => $levelValue,
			'music' => $music,
			'jammerType' => $jammerType,
			'followersCounter' => $followersCounter,
			'collaborationCounter' => $collaborationCounter,
			'venueCounter' => $venueCounter,
			'jammerCounter' => $jammerCounter,
			'members' => $members);
		    break;
		case 'VENUE':
		    $localType = $user->getlocalType();
		    $followersCounter = $user->getFollowersCounter();
		    $collaborationCounter = $user->getCollaborationCounter();
		    $venueCounter = $user->getVenueCounter();
		    $jammerCounter = $user->getJammerCounter();
		    $resultArray = array('userName' => $userName,
			'backGround' => $backGround,
			'profilePicture' => $profilePicture,
			'description' => $description,
			'city' => $city,
			'country' => $country,
			'fbPage' => $fbPage,
			'twitterPage' => $twitterPage,
			'webSite' => $webSite,
			'youtubeChannel' => $youtubeChannel,
			'googlePlusPage' => $googlePlusPage,
			'level' => $level,
			'levelValue' => $levelValue,
			'localType' => $localType,
			'followersCounter' => $followersCounter,
			'collaborationCounter' => $collaborationCounter,
			'venueCounter' => $venueCounter,
			'jammerCounter' => $jammerCounter);
		    break;
		default:
		    break;
	    }
	}
	return $resultArray;
    }

}

?>
