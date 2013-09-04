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
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

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
	public geoCoding;
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
	$userParse = new UserParse();
	$user = $userParse->getUser($objectId);
	if (get_class($user) == 'Error') {
	    return $user;
	} else {
	    $infoBox = new UserInfoBox();
	    is_null($user->getBackGround()) ? $infoBox->backGround = DEFBGD : $infoBox->backGround = $user->getBackGround();
	    is_null($user->getCity()) ? $infoBox->city = NODATA : $infoBox->city = $user->getCity();
	    is_null($user->getCountry()) ? $infoBox->country = NODATA : $infoBox->country = $user->getCountry();
	    is_null($user->getDescription()) ? $infoBox->description = NODATA : $infoBox->description = $user->getDescription();
	    is_null($user->getFbPage()) ? $infoBox->fbPage = NODATA : $infoBox->fbPage = $user->getFbPage();
	    is_null($user->getGooglePlusPage()) ? $infoBox->googlePlusPage = NODATA : $infoBox->googlePlusPage = $user->getGooglePlusPage();
	    is_null($user->getLevel()) ? $infoBox->level = 0 : $infoBox->level = $user->getLevel();
	    is_null($user->getLevelValue()) ? $infoBox->levelValue = 1 : $infoBox->levelValue = $user->getLevelValue();
	    is_null($user->getProfilePicture()) ? $infoBox->profilePicture = DEFAULTAVATAR : $infoBox->profilePicture = $user->getProfilePicture();
	    is_null($user->getTwitterPage()) ? $infoBox->twitterPage = NODATA : $infoBox->twitterPage = $user->getTwitterPage();
	    is_null($user->getUsername()) ? $infoBox->userName = NODATA : $infoBox->userName = $user->getUsername();
	    is_null($user->getWebsite()) ? $infoBox->webSite = NODATA : $infoBox->webSite = $user->getWebsite();
	    is_null($user->getYoutubeChannel()) ? $infoBox->youtubeChannel = NODATA : $infoBox->youtubeChannel = $user->getYoutubeChannel();
	    is_null($user->getJammerCounter()) ? $infoBox->jammerCounter = NODATA : $infoBox->jammerCounter = $user->getJammerCounter();
	    is_null($user->getVenueCounter()) ? $infoBox->venueCounter = NODATA : $infoBox->venueCounter = $user->getVenueCounter();
	    $infoBox->type = $user->getType();
	    switch ($infoBox->type) {
		case 'SPOTTER':
		    $infoBox->collaborationCounter = ND;
		    $infoBox->followersCounter = ND;
		    is_null($user->getFollowingCounter()) ? $infoBox->followingCounter = 0 : $infoBox->followingCounter = $user->getFollowingCounter();
		    is_null($user->getFriendshipCounter()) ? $infoBox->frindshipCounter = 0 : $infoBox->frindshipCounter = $user->getFriendshipCounter();
			$infoBox->geoCoding = ND;
		    $infoBox->localType = ND;
		    $infoBox->members = ND;
		    is_null($user->getMusic()) ? $infoBox->music = NODATA : $infoBox->music = $user->getMusic();
		    break;
		case 'JAMMER':
		    is_null($user->getCollaborationCounter()) ? $infoBox->collaborationCounter = 0 : $infoBox->collaborationCounter = $user->getCollaborationCounter();
		    is_null($user->getFollowersCounter()) ? $infoBox->followersCounter = 0 : $infoBox->followersCounter = $user->getFollowersCounter();
		    $infoBox->followingCounter = ND;
		    $infoBox->frindshipCounter = ND;
			$infoBox->geoCoding = ND;
		    $infoBox->localType = ND;
		    is_null($user->getMembers()) ? $infoBox->members = NODATA : $infoBox->members = $user->getMembers();
		    is_null($user->getMusic()) ? $infoBox->music = NODATA : $infoBox->music = $user->getMusic();
		    break;
		case 'VENUE':
		    is_null($user->getCollaborationCounter()) ? $infoBox->collaborationCounter = 0 : $infoBox->collaborationCounter = $user->getCollaborationCounter();
		    is_null($user->getFollowersCounter()) ? $infoBox->followersCounter = 0 : $infoBox->followersCounter = $user->getFollowersCounter();
			is_null($user->getGeoCoding()) ? $infoBox->geoCoding = NODATA : $infoBox->geoCoding = $user->getGeoCoding();
		    $infoBox->followingCounter = ND;
		    $infoBox->frindshipCounter = ND;
		    is_null($user->getLocalType()) ? $infoBox->localType = NODATA : $infoBox->localType = $user->getLocalType();
		    $infoBox->members = ND;
		    $infoBox->music = ND;
		    break;
		default :
		    break;
	    }
	    return $infoBox;
	}
    }

}

?>