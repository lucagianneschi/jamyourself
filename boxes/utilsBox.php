<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file utilities box 
 * \details		file utilities box
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

/**
 * \brief	UserInfo class 
 * \details	user info to be displayed in thumbnail view over all the website 
 */
class UserInfo {

    public $objectId;
    public $thumbnail;
    public $type;
    public $username;

    /**
     * \fn	__construct($objectId, $thumbnail, $type, $username)
     * \brief	construct for the UserInfo class
     * \param	$objectId, $thumbnail, $type, $username
     */
    function __construct($objectId, $thumbnail, $type, $username) {
	require_once SERVICES_DIR . 'lang.service.php';
	require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
	global $boxes;
	is_null($objectId) ? $this->objectId = null : $this->objectId = $objectId;
	switch ($type) {
	    case 'SPOTTER':
		$imageDefault = DEFTHUMBSPOTTER;
		break;
	    case 'JAMMER':
		$imageDefault = DEFTHUMBJAMMER;
		break;
	    case 'VENUE':
		$imageDefault = DEFTHUMBVENUE;
		break;
	}
	is_null($thumbnail) ? $this->thumbnail = $imageDefault : $this->thumbnail = $thumbnail;
	is_null($type) ? $this->type = null : $this->type = $type;
	is_null($username) ? $this->username = null : $this->username = $username;
    }

}

/**
 * \fn	        getAllUsersInRelation($objectId, $field, $className, $collaboratorType = null)
 * \brief	Convenience method to get all kind of related User to another user, any kind
 * \param	$objectId for the istance of the class the user is supposed to be related to, $field to be related to, 
 * \return	userArray array of userInfo object
 * \todo        prevere la possibilità di avere più di 1000 utenti in lista
 */
function getAllUsersInRelation($objectId, $field, $userType = null) {
    require_once CLASSES_DIR . 'user.class.php';
    require_once CLASSES_DIR . 'userParse.class.php';
    $usersArray = array();
    $parseUser = new UserParse();
    $user = $parseUser->getUser($objectId);
    if ($user instanceof Error) {
	return $usersArray;
    } else {
	switch ($field) {
	    case 'collaboration':
		if (!is_null($userType) && $userType == 'VENUE') {
		    $cicles = ceil($user->getVenueCounter() / MAX);
		} elseif (!is_null($userType) && $userType == 'JAMMER') {
		    $cicles = ceil($user->getJammerCounter() / MAX);
		} else {
		    $cicles = ceil($user->getCollaborationCounter() / MAX);
		}
		break;
	    case 'followers':
		$cicles = ceil($user->getFollowersCounter() / MAX);
		break;
	    case 'following':
		if (!is_null($userType) && $userType == 'VENUE') {
		    $cicles = ceil($user->getVenueCounter() / MAX);
		} elseif (!is_null($userType) && $userType == 'JAMMER') {
		    $cicles = ceil($user->getJammerCounter() / MAX);
		} else {
		    $cicles = ceil($user->getFollowingCounter() / MAX);
		}
		break;
	    case 'friendship':
		$cicles = ceil($user->getFriendshipCounter() / MAX);
		break;
	}
	if ($cicles == 0) {
	    return $usersArray;
	} else {
	    for ($i = 0; $i < $cicles; ++$i) {
		$userP = new UserParse();
		$userP->whereRelatedTo($field, '_User', $objectId);
		if ($userType == 'VENUE') {
		    $userP->where('type', 'VENUE');
		} elseif ($userType == 'JAMMER') {
		    $userP->where('type', 'JAMMER');
		}
		$userP->where('active', true);
		$userP->setLimit(MAX);
		$userP->setSkip(MAX * $i);
		$users = $userP->getUsers();
		if ($users instanceof Error) {
		    return $usersArray;
		} else {
		    foreach ($users as $user) {
			array_push($usersArray, $user);
		    }
		}
	    }
	}
    }
    return $usersArray;
}

/**
 * \fn	getRelatedUsers($objectId, $field, $className, $all, $limit, $skip)
 * \brief	Convenience method to get all kind of related User to a class for each page
 * \param	$objectId for the istance of the class the user is supposed to be related to, $field to be related to, $all BOOL: Yes to retrieve all related users or using the limit from config file, $page the page which calls the method
 * \return	userArray array of userInfo object
 * \todo        prevere la possibilità di avere più di 1000 utenti in lista
 */
function getRelatedUsers($objectId, $field, $className, $all = false, $limit = MAX, $skip = 0) {
    require_once CLASSES_DIR . 'user.class.php';
    require_once CLASSES_DIR . 'userParse.class.php';
    $parseUser = new UserParse();
    $parseUser->whereRelatedTo($field, $className, $objectId);
    $parseUser->where('active', true);
    ($all == true) ? $parseUser->setLimit(MAX) : $parseUser->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : MAX);
    $parseUser->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0 ) ? $skip : 0);
    $users = $parseUser->getUsers();
    if ($users instanceof Error) {
	return $users;
    } elseif (is_null($users)) {
	return array();
    } else {
	return $users;
    }
}

/**
 * \fn	tracklistGenerator($objectId)
 * \brief	retrives info for generating a tracklist
 * \param	$objectId of the 
 * \return  $tracklist, array of Songinfo objects    
 */
function tracklistGenerator($objectId, $limit = DEFAULTQUERY) {
    require_once CLASSES_DIR . 'song.class.php';
    require_once CLASSES_DIR . 'songParse.class.php';
    $song = new SongParse();
    $song->wherePointer('record', 'Record', $objectId);
    $song->where('active', true);
    $song->setLimit((!is_null(!$limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : DEFAULTQUERY);
    $song->orderByAscending('position');
    $songs = $song->getSongs();
    return $songs;
}

/**
 * \fn		sessionChecker()
 * \brief	The function returns a string wiht the objectId of the user in session, if there's no user return a invalid ID used (valid for the code)
 * \return	string $currentUserId;
 */
function sessionChecker() {
    require_once CLASSES_DIR . 'userParse.class.php';
    if (session_id() == '')
	session_start();
    $sessionExist = session_id() === '' ? FALSE : TRUE;
    $currentUserId = null;
    if ($sessionExist == TRUE && isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	$currentUserId = $currentUser->getObjectId();
    }
    return $currentUserId;
}

?>