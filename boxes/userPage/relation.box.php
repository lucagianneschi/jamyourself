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
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class RelationInfo {

    public $thumbnail;
    public $username;

    function __construct($thumbnail, $username) {
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($username) ? $this->username = NODATA : $this->username = $username;
    }

}

class RelationsBox {

    public $relationArray;

    public function init($objectId, $type) {
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
			$username = $toUser->getUserName();

			$relationInfo = new RelationInfo($thumbnail, $username);
			array_push($followingArray, $relationInfo);
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
			    $username = $toUser->getUserName();

			    $relationInfo = new RelationInfo($thumbnail, $username);
			    array_push($friendshipArray, $relationInfo);
			}
		    }
		}

		$info = array('followers' => NOTDEFINED, 'following' => $followingArray, 'friendship' => $friendshipArray, 'venuesCollaborators' => NOTDEFINED, 'jammersCollaborators' => NOTDEFINED);
		break;
	    default :
		$collaboratorVenue = new UserParse();
		$collaboratorVenue->whereRelatedTo('collaboration', '_User', $objectId);
		$collaboratorVenue->whereEqualTo('type', 'VENUE');
		$collaboratorVenue->where('active', true);
		$collaboratorVenue->setLimit(1000);
		$collaboratorVenue->orderByDescending('createdAt');
		$venues = $collaboratorVenue->getUsers();
		foreach ($venues as $venue) {
		    $thumbnail = $venue->getProfileThumbnail();
		    $username = $venue->getUserName();

		    $relationInfo = new RelationInfo($thumbnail, $username);
		    array_push($venuesArray, $relationInfo);
		}

		$collaboratorJammer = new UserParse();
		$collaboratorJammer->whereRelatedTo('collaboration', '_User', $objectId);
		$collaboratorJammer->whereEqualTo('type', 'JAMMER');
		$collaboratorJammer->setLimit(1000);
		$collaboratorJammer->orderByDescending('createdAt');
		$jammers = $collaboratorJammer->getUsers();
		foreach ($jammers as $jammer) {
		    $thumbnail = $jammer->getProfileThumbnail();
		    $username = $jammer->getUserName();

		    $relationInfo = new RelationInfo($thumbnail, $username);
		    array_push($jammersArray, $relationInfo);
		}

		$following = new ActivityParse();
		$following->wherePointer('toUser', '_User', $objectId);
		$following->whereEqualTo('type', 'FOLLOWING');
		$following->where('active', true);
		$following->setLimit(1000);
		$following->orderByDescending('createdAt');
		$followers = $following->getActivities();

		foreach ($followers as $follower) {
		    $followerId = $follower->getFromUser();
		    $userP = new UserParse();
		    $user = $userP->getUser($followerId);

		    $thumbnail = $user->getProfileThumbnail();
		    $username = $user->getUserName();

		    $relationInfo = new RelationInfo($thumbnail, $username);
		    array_push($followersArray, $relationInfo);
		}
		$info = array('followers' => $followersArray, 'following' => NOTDEFINED, 'friendship' => NOTDEFINED, 'venuesCollaborators' => $venuesArray, 'jammersCollaborators' => $jammersArray);
		break;
	}
	$relationsBox->relationArray = $info;
	return $relationsBox;
    }

}

?>