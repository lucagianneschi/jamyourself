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
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

class UserInfoBox {

    public $backGround;
    public $city;
    public $collaborationCounter;
    public $country;
    public $description;
    public $fbPage;
    public $followersCounter;
    public $followingCounter;
    public $frindshipCounter;
    public $geoCoding;
    public $googlePlusPage;
    public $level;
    public $levelValue;
    public $localType;
    public $jammerCounter;
    public $members;
    public $music;
    public $profilePicture;
    public $userName;
    public $type;
    public $twitterPage;
    public $webSite;
    public $youtubeChannel;
    public $venueCounter;

    /**
     * \fn	initForPersonalPage($objectId)
     * \brief	Init InfoBox instance for Personal Page
     * \param	$objectId for user that owns the page
     * \return	infoBox if the user has been found, otherwise return an error;
     */
    public function initForPersonalPage($objectId) {
	global $boxes;
	global $default_img;
	$userParse = new UserParse();
	$user = $userParse->getUser($objectId);
	if (is_a($user, 'Error')) {
	    return $user;
	} else {
	    $infoBox = new UserInfoBox();
	    is_null($user->getBackGround()) ? $infoBox->backGround = $default_img['DEFBGD'] : $infoBox->backGround = $user->getBackGround();
	    is_null($user->getCity()) ? $infoBox->city = $boxes['NODATA'] : $infoBox->city = parse_decode_string($user->getCity());
	    is_null($user->getCountry()) ? $infoBox->country = $boxes['NODATA'] : $infoBox->country = parse_decode_string($user->getCountry());
	    is_null($user->getDescription()) ? $infoBox->description = $boxes['NODATA'] : $infoBox->description = parse_decode_string($user->getDescription());
	    is_null($user->getFbPage()) ? $infoBox->fbPage = $boxes['NODATA'] : $infoBox->fbPage = parse_decode_string($user->getFbPage());
	    is_null($user->getGooglePlusPage()) ? $infoBox->googlePlusPage = $boxes['NODATA'] : $infoBox->googlePlusPage = parse_decode_string($user->getGooglePlusPage());
	    is_null($user->getLevel()) ? $infoBox->level = 0 : $infoBox->level = $user->getLevel();
	    is_null($user->getLevelValue()) ? $infoBox->levelValue = 1 : $infoBox->levelValue = $user->getLevelValue();
	    is_null($user->getProfilePicture()) ? $infoBox->profilePicture = $default_img['DEFAULTAVATAR'] : $infoBox->profilePicture = $user->getProfilePicture();
	    is_null($user->getTwitterPage()) ? $infoBox->twitterPage = $boxes['NODATA'] : $infoBox->twitterPage = parse_decode_string($user->getTwitterPage());
	    is_null($user->getUsername()) ? $infoBox->userName = $boxes['NODATA'] : $infoBox->userName = parse_decode_string($user->getUsername());
	    is_null($user->getWebsite()) ? $infoBox->webSite = $boxes['NODATA'] : $infoBox->webSite = parse_decode_string($user->getWebsite());
	    is_null($user->getYoutubeChannel()) ? $infoBox->youtubeChannel = $boxes['NODATA'] : $infoBox->youtubeChannel = parse_decode_string($user->getYoutubeChannel());
	    is_null($user->getJammerCounter()) ? $infoBox->jammerCounter = $boxes['NODATA'] : $infoBox->jammerCounter = $user->getJammerCounter();
	    is_null($user->getVenueCounter()) ? $infoBox->venueCounter = $boxes['NODATA'] : $infoBox->venueCounter = $user->getVenueCounter();
	    $infoBox->type = $user->getType();
	    switch ($infoBox->type) {
		case 'SPOTTER':
		    $infoBox->collaborationCounter = $boxes['ND'];
		    $infoBox->followersCounter = $boxes['ND'];
		    is_null($user->getFollowingCounter()) ? $infoBox->followingCounter = 0 : $infoBox->followingCounter = $user->getFollowingCounter();
		    is_null($user->getFriendshipCounter()) ? $infoBox->frindshipCounter = 0 : $infoBox->frindshipCounter = $user->getFriendshipCounter();
		    $infoBox->geoCoding = $boxes['ND'];
		    $infoBox->localType = $boxes['ND'];
		    $infoBox->members = $boxes['ND'];
		    is_null($user->getMusic()) ? $infoBox->music = $boxes['NODATA'] : $infoBox->music = $user->getMusic();
		    break;
		case 'JAMMER':
		    is_null($user->getCollaborationCounter()) ? $infoBox->collaborationCounter = 0 : $infoBox->collaborationCounter = $user->getCollaborationCounter();
		    is_null($user->getFollowersCounter()) ? $infoBox->followersCounter = 0 : $infoBox->followersCounter = $user->getFollowersCounter();
		    $infoBox->followingCounter = $boxes['ND'];
		    $infoBox->frindshipCounter = $boxes['ND'];
		    $infoBox->geoCoding = $boxes['ND'];
		    $infoBox->localType = $boxes['ND'];
		    is_null($user->getMembers()) ? $infoBox->members = $boxes['NODATA'] : $infoBox->members = $user->getMembers();
		    is_null($user->getMusic()) ? $infoBox->music = $boxes['NODATA'] : $infoBox->music = $user->getMusic();
		    break;
		case 'VENUE':
		    is_null($user->getCollaborationCounter()) ? $infoBox->collaborationCounter = 0 : $infoBox->collaborationCounter = $user->getCollaborationCounter();
		    is_null($user->getFollowersCounter()) ? $infoBox->followersCounter = 0 : $infoBox->followersCounter = $user->getFollowersCounter();
		    is_null($user->getGeoCoding()) ? $infoBox->geoCoding = $boxes['NODATA'] : $infoBox->geoCoding = $user->getGeoCoding();
		    $infoBox->followingCounter = $boxes['ND'];
		    $infoBox->frindshipCounter = $boxes['ND'];
		    is_null($user->getLocalType()) ? $infoBox->localType = $boxes['NODATA'] : $infoBox->localType = $user->getLocalType();
		    $infoBox->members = $boxes['ND'];
		    $infoBox->music = $boxes['ND'];
		    break;
	    }
	    return $infoBox;
	}
    }

}

?>