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
 * \todo		Fare API su Wiki
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

/**
 * \fn	getFeaturingArray() 
 * \brief   funzione per il recupero dei featuring per l'event
 */
function getFeaturingArray() {
    if (isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	$currentUserId = $currentUser->getId();
	$userArray = null;
	switch ($currentUser->getType()) {
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

/**
 * \fn	getImages($decoded)
 * \brief   funzione per recupero immagini
 * \param   $decoded
 * \todo check possibilità utilizzo di questa funzione come pubblica e condivisa tra più controller
 */
function getCroppedImages($decoded) {
//in caso di anomalie ---> default
    if (is_array($decoded)) {
	$decoded = json_decode(json_encode($decoded), false);
    }

    if (!isset($decoded->crop) || is_null($decoded->crop) ||
	    !isset($decoded->image) || is_null($decoded->image)) {
	return array("picture" => null, "thumbnail" => null);
    }

//recupero i dati per effettuare l'editing
    $cropInfo = json_decode(json_encode($decoded->crop), false);

    if (!isset($cropInfo->x) || is_null($cropInfo->x) || !is_numeric($cropInfo->x) ||
	    !isset($cropInfo->y) || is_null($cropInfo->y) || !is_numeric($cropInfo->y) ||
	    !isset($cropInfo->w) || is_null($cropInfo->w) || !is_numeric($cropInfo->w) ||
	    !isset($cropInfo->h) || is_null($cropInfo->h) || !is_numeric($cropInfo->h)) {
	return array("picture" => null, "thumbnail" => null);
    }
    $cacheDir = CACHE_DIR;
    $cacheImg = $cacheDir . $decoded->image;
    require_once SERVICES_DIR . 'cropImage.service.php';
//Preparo l'oggetto per l'editign della foto
    $cis = new CropImageService();

//gestione dell'immagine di profilo
    $coverId = $cis->cropImage($cacheImg, $cropInfo->x, $cropInfo->y, $cropInfo->w, $cropInfo->h, PROFILE_IMG_SIZE);
    $coverUrl = $cacheDir . $coverId;

//gestione del thumbnail
    $thumbId = $cis->cropImage($coverUrl, 0, 0, PROFILE_IMG_SIZE, PROFILE_IMG_SIZE, THUMBNAIL_IMG_SIZE);
//CANCELLAZIONE DELLA VECCHIA IMMAGINE
    unlink($cacheImg);
//RETURN        
    return array('picture' => $coverId, 'thumbnail' => $thumbId);
}

function filterFeaturingByValue($array, $value) {
    $newarray = array();
    if (is_array($array) && count($array) > 0) {
	foreach ($array as $key) {
	    if (stripos($key['text'], $value) !== false) {
		$newarray[] = $key;
	    }
	}
    }
    return $newarray;
}

?>