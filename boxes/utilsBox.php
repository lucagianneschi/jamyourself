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
	$this->objectId = is_null($objectId) ? null : $objectId;
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
	$this->thumbnail = is_null($thumbnail) ? $imageDefault : $thumbnail;
	$this->type = is_null($type) ? null : $type;
	$this->username = is_null($username) ? null : $username;
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
	switch ($userType) {
	    case 'VENUE':
		$counter = $user->getVenueCounter();
		break;
	    case 'JAMMER':
		$counter = $user->getJammerCounter();
	    default:
		if ($field == 'collaboration') {
		    $counter = $user->getCollaborationCounter();
		} elseif ($field == 'followers') {
		    $counter = $user->getFollowersCounter();
		} else {
		    $counter = $user->getFriendshipCounter();
		}
		break;
	}
	$cicles = ceil($counter / MAX);
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
		if ($users instanceof Error || is_null($users)) {
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
 * \fn	        findLocationCoordinates($city = null, $coutry = null)
 * \brief	find location for city and/or country for geoQuery
 * \param	$city = null, $coutry = null
 * \return      $locations, array with 1 element, null, if $city && $country are null at the same time, $error in case of query error
 */
function findLocationCoordinates($city = null, $coutry = null) {
    if (is_null($city) && is_null($coutry)) {
	return null;
    } else {
	require_once CLASSES_DIR . 'location.class.php';
	require_once CLASSES_DIR . 'locationParse.class.php';
	$location = new LocationParse();
	if (!is_null($city)) {
	    $location->where('city', $city);
	}
	if (!is_null($coutry)) {
	    $location->where('country', $coutry);
	}
	$location->setLimit(MIN);
	return $location->getLocations();
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