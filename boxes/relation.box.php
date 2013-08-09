<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Relations
 * \details		Recupera le ultime relazioni per tipologia di utente
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
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';


class RelationsBox {

    public $relationArray;

    public function initForPersonalPage($objectId, $type) {
	$relationsBox = new RelationsBox();
	$info = array();
	$followingArray = array();
	$friendshipArray = array();
	$venuesArray = array();
	$jammersArray = array();
	$followersArray = array();

	switch ($type) {
	    case 'SPOTTER':
		$activityFollowing = new ActivityParse();
		$activityFollowing->setLimit(1000);
		$activityFollowing->wherePointer('fromUser', '_User', $objectId);
		$activityFollowing->whereEqualTo('type', 'FOLLOWING');
		$activityFollowing->where('active', true);
		$activityFollowing->whereInclude('toUser');
		$activityFollowing->orderByDescending('createdAt');
		$following = $activityFollowing->getActivities();
		if (count($following) == 0) {
		    $following = NODATA;
		} elseif (get_class($following) == 'Error') {
		    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $following->getErrorMessage() . '<br/>';
		} else {
		    foreach ($following->toUser as $toUser) {
			$thumbnail = $toUser->getProfileThumbnail();
			$type = $toUser->getType();
			$username = $toUser->getUserName();
			$userInfo = new UserInfo($thumbnail, $type, $username);
			array_push($followingArray, $userInfo);
		    }
		}

		$activityFriendship = new ActivityParse();
		$activityFriendship->setLimit(1000);
		$activityFriendship->wherePointer('fromUser', '_User', $objectId);
		$activityFriendship->whereEqualTo('type', 'FRIENDSHIPREQUEST');
		$activityFriendship->whereEqualTo('status', 'A');
		$activityFriendship->where('active', true);
		$activityFriendship->whereInclude('toUser');
		$activityFriendship->orderByDescending('createdAt');
		$friendship = $activityFriendship->getActivities();
		if ($friendship != 0) {
		    if (get_class($friendship) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $friendship->getErrorMessage() . '<br/>';
		    } else {
			foreach ($friendship->toUser as $toUser) {
			    $thumbnail = $toUser->getProfileThumbnail();
			    $type = $toUser->getType();
			    $username = $toUser->getUserName();
			    $userInfo = new UserInfo($thumbnail, $type, $username);
			    array_push($friendshipArray, $userInfo);
			}
		    }
		}

		$info = array('followers' => ND, 'following' => $followingArray, 'friendship' => $friendshipArray, 'venuesCollaborators' => ND, 'jammersCollaborators' => ND);
		break;
	    default :
		$collaboratorVenue = new UserParse();
		$collaboratorVenue->whereRelatedTo('collaboration', '_User', $objectId);
		$collaboratorVenue->whereEqualTo('type', 'VENUE');
		$collaboratorVenue->where('active', true);
		$collaboratorVenue->setLimit(1000);
		$collaboratorVenue->orderByDescending('createdAt');
		$venues = $collaboratorVenue->getUsers();
		foreach ($venues as $toUser) {
		    $thumbnail = $toUser->getProfileThumbnail();
		    $type = $toUser->getType();
		    $username = $toUser->getUserName();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
		    array_push($venuesArray, $userInfo);
		}

		$collaboratorJammer = new UserParse();
		$collaboratorJammer->whereRelatedTo('collaboration', '_User', $objectId);
		$collaboratorJammer->whereEqualTo('type', 'JAMMER');
		$collaboratorJammer->setLimit(1000);
		$collaboratorJammer->orderByDescending('createdAt');
		$jammers = $collaboratorJammer->getUsers();
		foreach ($jammers as $toUser) {
		    $thumbnail = $toUser->getProfileThumbnail();
		    $type = $toUser->getType();
		    $username = $toUser->getUserName();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
		    array_push($jammersArray, $userInfo);
		}

		$following = new ActivityParse();
		$following->wherePointer('toUser', '_User', $objectId);
		$following->whereEqualTo('type', 'FOLLOWING');
		$following->where('active', true);
		$following->setLimit(1000);
		$following->orderByDescending('createdAt');
		$followers = $following->getActivities();

		foreach ($followers as $toUser) {
		    $followerId = $toUser->getFromUser();
		    $userP = new UserParse();
		    $user = $userP->getUser($followerId);

		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
		    $username = $user->getUserName();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
		    array_push($followersArray, $userInfo);
		}
		$info = array('followers' => $followersArray, 'following' => ND, 'friendship' => ND, 'venuesCollaborators' => $venuesArray, 'jammersCollaborators' => $jammersArray);
		break;
	}
	$relationsBox->relationArray = $info;
	return $relationsBox;
    }

}

?>