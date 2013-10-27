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
 * \todo		uso whereIncude
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

class RelationsBox {

    public $relationArray;

    public function initForPersonalPage($objectId, $type) {
	global $boxes;
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
		$activityFollowing->setLimit(50);
		$activityFollowing->wherePointer('fromUser', '_User', $objectId);
		$activityFollowing->whereEqualTo('type', 'FOLLOWING');
		$activityFollowing->where('active', true);
		$activityFollowing->whereInclude('toUser');
		$activityFollowing->orderByDescending('createdAt');
		$followings = $activityFollowing->getActivities();
		if (get_class($followings) == 'Error') {
		    return $followings;
		} else {
		    foreach ($followings as $following) {
			$objectId = $following->getToUser()->getObjectId();
			$thumbnail = $following->getToUser()->getProfileThumbnail();
			$type = $following->getToUser()->getType();
			$encodedUsername = $following->getToUser()->getUserName();
			$username = parse_decode_string($encodedUsername);
			$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			array_push($followingArray, $userInfo);
		    }
		}
		$activityFriendship = new ActivityParse();
		$activityFriendship->setLimit(50);
		$activityFriendship->wherePointer('fromUser', '_User', $objectId);
		$activityFriendship->whereEqualTo('type', 'FRIENDSHIPREQUEST');
		$activityFriendship->whereEqualTo('status', 'A');
		$activityFriendship->where('active', true);
		$activityFriendship->whereInclude('toUser');
		$activityFriendship->orderByDescending('createdAt');
		$friendships = $activityFriendship->getActivities();
		if (get_class($friendships) == 'Error') {
		    return $friendships;
		} else {
		    foreach ($friendships as $friendship) {
			$objectId = $friendship->getToUser()->getObjectId();
			$thumbnail = $friendship->getToUser()->getProfileThumbnail();
			$type = $friendship->getToUser()->getType();
			$encodedUsername = $friendship->getToUser()->getUserName();
			$username = parse_decode_string($encodedUsername);
			$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			array_push($friendshipArray, $userInfo);
		    }
		}
		if (empty($followingArray)) {
		    $followingArray = $boxes['NOFOLLOWING'];
		}
		if (empty($friendshipArray)) {
		    $friendshipArray = $boxes['NOFRIENDS'];
		}
		$info = array('followers' => $boxes['ND'], 'following' => $followingArray, 'friendship' => $friendshipArray, 'venuesCollaborators' => $boxes['ND'], 'jammersCollaborators' => $boxes['ND']);
		break;
	    default :
		require_once CLASSES_DIR . 'user.class.php';
		require_once CLASSES_DIR . 'userParse.class.php';
		$collaboratorVenue = new UserParse();
		$collaboratorVenue->whereRelatedTo('collaboration', '_User', $objectId);
		$collaboratorVenue->where('active', true);
		$collaboratorVenue->setLimit(50);
		$collaboratorVenue->orderByDescending('createdAt');
		$collaborators = $collaboratorVenue->getUsers();
		if (get_class($collaborators) == 'Error') {
		    return $collaborators;
		} else {
		    foreach ($collaborators as $collaborator) {
			$objectId = $collaborator->getObjectId();
			$thumbnail = $collaborator->getProfileThumbnail();
			$type = $collaborator->getType();
			$encodedUsername = $collaborator->getUserName();
			$username = parse_decode_string($encodedUsername);
			$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			if ($type == 'VENUE') {
			    array_push($venuesArray, $userInfo);
			} else {
			    array_push($jammersArray, $userInfo);
			}
		    }
		}
		$following = new ActivityParse();
		$following->wherePointer('toUser', '_User', $objectId);
		$following->whereEqualTo('type', 'FOLLOWING');
		$following->where('active', true);
		$following->whereInclude('fromUser');
		$following->setLimit(50);
		$following->orderByDescending('createdAt');
		$followers = $following->getActivities();
		if (get_class($followers) == 'Error') {
		    return $followers;
		} else {
		    foreach ($followers as $follower) {
			$objectId = $follower->getFromUser()->getObjectId();
			$thumbnail = $follower->getFromUser()->getProfileThumbnail();
			$type = $follower->getFromUser()->getType();
			$encodedUsername = $follower->getFromUser()->getUserName();
			$username = parse_decode_string($encodedUsername);
			$userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
			array_push($followersArray, $userInfo);
		    }
		}
		if (empty($followersArray)) {
		    $followersArray = $boxes['NOFOLLOWERS'];
		}
		if (empty($venuesArray)) {
		    $venuesArray = $boxes['NOVENUE'];
		}
		if (empty($jammersArray)) {
		    $jammersArray = $boxes['NOJAMMER'];
		}
		$info = array('followers' => $followersArray, 'following' => $boxes['ND'], 'friendship' => $boxes['ND'], 'venuesCollaborators' => $venuesArray, 'jammersCollaborators' => $jammersArray);
		break;
	}
	if (empty($info)) {
	    $relationsBox->relationArray = $boxes['NODATA'];
	} else {
	    $relationsBox->relationArray = $info;
	}
	return $relationsBox;
    }

}

?>