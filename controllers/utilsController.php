<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file per funzioni di utilità per controller
 * \details		file per funzioni di utilità per controller
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		eliminare dopo realizzazione recupero featuring
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

/**
 * \fn	getFeaturingArray() 
 * \brief   funzione per il recupero dei featuring per l'event
 * \todo  getRelatedUsers non esiste più
 */
function getFeaturingArray() {
    if (isset($_SESSION['id'])) {
	$currentUserId = $_SESSION['id'];
	$currentUserType =  $_SESSION['type'];
	$userArray = null;
	switch ($currentUserType) {
	    case "SPOTTER":
		$userArrayFriend = getRelatedUsers($currentUserId, 'friendship', '_User');
		if (($userArrayFriend instanceof Error) || is_null($userArrayFriend)) {
		    $userArrayFriend = array();
		}
		$userArrayFollowing = getRelatedUsers($currentUserId, 'following', '_User');
		if (($userArrayFollowing instanceof Error) || is_null($userArrayFollowing)) {
		    $userArrayFollowing = array();
		}
		$userArray = array_merge($userArrayFriend, $userArrayFollowing);
		break;
	    case "JAMMER":
	    case "VENUE":
		$userArray = getRelatedUsers($currentUserId, 'collaboration', '_User');
		break;
	    default:
		break;
	}

	if (($userArray instanceof Error) || is_null($userArray)) {
	    return array();
	} else {
	    $userArrayInfo = array();
	    foreach ($userArray as $user) {
		require_once CLASSES_DIR . "user.class.php";
		$username = $user->getUsername();
		$userId = $user->getId();
		$userType = $user->getType();
		array_push($userArrayInfo, array("id" => $userId, "text" => $username, 'type' => $userType));
	    }
	    return $userArrayInfo;
	}
    }
    else
	return array();
}





?>