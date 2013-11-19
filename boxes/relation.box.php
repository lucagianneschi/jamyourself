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
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

class RelationsBox {

    public $config;
    public $relationArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/relation.config.json"), false);
    }

    public function initForPersonalPage($objectId, $type) {
        global $boxes;
        $info = array();
        $followingArray = array();
        $friendshipArray = array();
        $venuesArray = array();
        $jammersArray = array();
        $followersArray = array();
        $relationsBox = new RelationsBox();
        if ($type == 'SPOTTER') {
            $activityFollowing = new ActivityParse();
            $activityFollowing->wherePointer('fromUser', '_User', $objectId);
            $activityFollowing->whereEqualTo('type', 'FOLLOWING');
            $activityFollowing->where('active', true);
            $activityFollowing->whereInclude('toUser');
            $activityFollowing->setLimit($this->config->following);
            $activityFollowing->orderByDescending('createdAt');
            $followings = $activityFollowing->getActivities();
            if ($followings instanceof Error) {
                return $followings;
            } elseif (is_null($followings)) {
                $followingArray = $boxes['NOFOLLOWING'];
            } else {
                foreach ($followings as $following) {
                    $followingId = $following->getToUser()->getObjectId();
                    $thumbnail = $following->getToUser()->getProfileThumbnail();
                    $type = $following->getToUser()->getType();
                    $username = parse_decode_string($following->getToUser()->getUserName());
                    $userInfo = new UserInfo($followingId, $thumbnail, $type, $username);
                    array_push($followingArray, $userInfo);
                }
            }
            $activityFriendship = new ActivityParse();
            $activityFriendship->setLimit($this->config->friends);
            $activityFriendship->wherePointer('fromUser', '_User', $objectId);
            $activityFriendship->whereEqualTo('type', 'FRIENDSHIPREQUEST');
            $activityFriendship->whereEqualTo('status', 'A');
            $activityFriendship->where('active', true);
            $activityFriendship->whereInclude('toUser');
            $activityFriendship->orderByDescending('createdAt');
            $friendships = $activityFriendship->getActivities();
            if ($friendships instanceof Error) {
                return $friendships;
            } elseif (is_null($friendships)) {
                $friendshipArray = $boxes['NOFRIENDS'];
            } else {
                foreach ($friendships as $friendship) {
                    $friendshipId = $friendship->getToUser()->getObjectId();
                    $thumbnail = $friendship->getToUser()->getProfileThumbnail();
                    $type = $friendship->getToUser()->getType();
                    $username = parse_decode_string($friendship->getToUser()->getUserName());
                    $userInfo = new UserInfo($friendshipId, $thumbnail, $type, $username);
                    array_push($friendshipArray, $userInfo);
                }
            }
            $info = array('followers' => $boxes['ND'], 'following' => $followingArray, 'friendship' => $friendshipArray, 'venuesCollaborators' => $boxes['ND'], 'jammersCollaborators' => $boxes['ND']);
        } else {
            $collaborators = getRelatedUsers($objectId, 'collaboration', '_User', false, $this->config->collaborations, 0);
            if ($collaborators instanceof Error) {
                return $collaborators;
            } elseif (is_null($collaborators)) {
                $venuesArray = $boxes['NOVENUE'];
                $jammersArray = $boxes['NOJAMMER'];
            } else {
                foreach ($collaborators as $collaborator) {
                    ($collaborator->type == 'VENUE') ? array_push($venuesArray, $collaborator) : array_push($jammersArray, $collaborator);
                }
            }
            $following = new ActivityParse();
            $following->wherePointer('toUser', '_User', $objectId);
            $following->whereEqualTo('type', 'FOLLOWING');
            $following->where('active', true);
            $following->whereInclude('fromUser');
            $following->setLimit($this->config->followingProfessional);
            $following->orderByDescending('createdAt');
            $followers = $following->getActivities();
            if ($followers instanceof Error) {
                return $followers;
            } elseif (is_null($followers)) {
                $followersArray = $boxes['NOFOLLOWERS'];
            } else {
                foreach ($followers as $follower) {
                    $followerId = $follower->getFromUser()->getObjectId();
                    $thumbnail = $follower->getFromUser()->getProfileThumbnail();
                    $type = $follower->getFromUser()->getType();
                    $username = parse_decode_string($follower->getFromUser()->getUserName());
                    $userInfo = new UserInfo($followerId, $thumbnail, $type, $username);
                    array_push($followersArray, $userInfo);
                }
            }
            $info = array('followers' => $followersArray, 'following' => $boxes['ND'], 'friendship' => $boxes['ND'], 'venuesCollaborators' => $venuesArray, 'jammersCollaborators' => $jammersArray);
        }
        $relationsBox->relationArray = $info;
        return $relationsBox;
    }

}

?>