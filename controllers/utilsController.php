<?php

/**
 * funzioni utilità per controller
 * 
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                da eliminare e portare le funzioni che servono dentro utils.service.php
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once SERVICES_DIR . 'connection.service.php';

/**
 * funzione per il recupero dei featuring per l'event
 * \todo  getRelatedUsers non esiste più
 */
function getFeaturingArray() {
    if (isset($_SESSION['id'])) {
	$currentUserId = $_SESSION['id'];
	$currentUserType =  $_SESSION['type'];
	$userArray = null;
	switch ($currentUserType) {
	    case "SPOTTER":
		$connectionService = new ConnectionService();
		$userArrayFriend = getRelatedNodes($connection, 'user', $currentUserId, 'user', 'friendship');
		if ((!$userArrayFriend) || is_null($userArrayFriend)) {
		    $userArrayFriend = array();
		}
		$userArrayFollowing = getRelatedNodes($connection, 'user', $currentUserId, 'user', 'following');
		if ((!$userArrayFollowing) || is_null($userArrayFollowing)) {
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