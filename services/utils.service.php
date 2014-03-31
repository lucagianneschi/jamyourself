<?php

/**
 * funzioni utilità per controller
 * 
 * @author		Maria Laura Fresu
 * @author		Stefano Muscas
 * @author		Daniele Caldelli
 * @author		Luca Gianneschi
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
require_once SERVICES_DIR . 'select.service.php';

/**
 * verifica che l'indirizzo inserito sia un indirizzo valido
 * 
 * @param $email string email inserita
 * @return true in case of success, false otherwise
 */
function checkEmail($email) {
    if (strlen($email) > 50)
	return false;
    if (stripos($email, " ") !== false)
	return false;
    if (!(stripos($email, "@") !== false))
	return false;
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL)))
	return false;
    return true;
}

/**
 * The function returns the difference between $end and $start parameter in microseconds
 * 
 * @param	$start	represent the microsecond time of the begin of the operation
 * @param	$end	represent the microsecond time of the end of the operation
 * @return	number	the number representing the difference in microsecond
 * @return	Error	if the parameters are null
 */
function executionTime($start, $end) {
    if (is_null($start) || is_null($end))
	return throwError(new Exception('executionTime parameters are incorrect'), 'Utils', __FUNCTION__, func_get_args());
    $arrStart = explode(' ', $start);
    $arrEnd = explode(' ', $end);
    $secStart = $arrStart[1];
    $secEnd = $arrEnd[1];
    $msecStart = substr($arrStart[0], 2, 6);
    $msecEnd = substr($arrEnd[0], 2, 6);
    if (($secStart - $secEnd) == 0) {
	$time = '0.' . str_pad($msecEnd - $msecStart, 6, 0, STR_PAD_LEFT);
    } else {
	$timeStart = $secStart . '.' . $msecStart;
	$timeEnd = $secEnd . '.' . $msecEnd;
	$time = round(($timeEnd - $timeStart), 6);
    }
    return $time;
}

/**
 * The function returns a string read from DB that can be interpreted by the user
 * 
 * @param	$string 	represent the string from DB to decode
 * @return	string		the decoded string
 */
function decode_string($string) {
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    $decodedString = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    return $decodedString;
}

/**
 * The function returns a string that can be saved to DB
 * 
 * @param	$string 	represent the string to be saved
 * @return	string		the string encoded for DB
 */
function encode_string($string) {
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
    return $string;
}

/**
 * filtra featuind per tipo
 * 
 * @param   $array, $value
 * @return  $newarray
 *    
 */
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

/**
 * funzione per recupero immagini dopo crop
 * 
 * @param   $decoded
 * @todo   check possibilità utilizzo di questa funzione come pubblica e condivisa tra più controller
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

/**
 * funzione per il recupero dei featuring, da usare nei form che prevedono l'inserimento di featuring
 */
function getFeaturingArray() {
    if (session_id() == '')
	session_start();
    if (isset($_SESSION['id'])) {
	$currentUserId = $_SESSION['id'];
	$currentUserType = $_SESSION['type'];
	$userArray = null;
	$connectionService = new ConnectionService();
	switch ($currentUserType) {
	    case "SPOTTER":
		$userArrayFriend = getRelatedNodes($connectionService, 'user', $currentUserId, 'user', 'FRIENDSHIP');
		if ((!$userArrayFriend) || is_null($userArrayFriend)) {
		    $userArrayFriend = array();
		}
		$userArrayFollowing = getRelatedNodes($connectionService, 'user', $currentUserId, 'user', 'FOLLOWING');
		if ((!$userArrayFollowing) || is_null($userArrayFollowing)) {
		    $userArrayFollowing = array();
		}
		$userArray = array_merge($userArrayFriend, $userArrayFollowing);
		break;
	    default:
		$userArray = getRelatedNodes($connectionService, 'user', $currentUserId, 'user', 'COLLABORATION');
		break;
	}
	if ((!$userArray) || is_null($userArray)) {
	    return array();
	} else {
	    $userArrayInfo = array();
	    $connection = $connectionService->connect();
	    $users = selectUsers($connection, null, array('id' => $userArray));
	    foreach ($users as $user) {
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
 * cripta la password prima di scriverla sul DB,SHA1 hash of the password using 2 salts that the user specifies.
 * 
 * @param string $password Password
 * @todo test
 */
function passwordEncryption($password) {
    return sha1(md5(SALT2 . $password . SALT1));
}

/**
 * invia mail ad utente
 * 
 * @param   $address, $subject, $html
 * @todo    testare
 */
function sendMailForNotification($address, $subject, $html) {
    global $controllers;
    require_once SERVICES_DIR . 'mail.service.php';
    $mail = mailService();
    $mail->AddAddress($address);
    $mail->Subject = $subject;
    $mail->MsgHTML($html);
    $resMail = $mail->Send();
    if ($resMail instanceof phpmailerException) {
	$this->response(array('status' => $controllers['NOMAIL']), 403);
    }
    $mail->SmtpClose();
    unset($mail);
    return true;
}

/**
 * The function returns a string wiht the id of the user in session, if there's no user return a invalid ID used (valid for the code)
 * 
 * @return	string $currentUserId;
 */
function sessionChecker() {
    if (session_id() == '')
	session_start();
    $sessionExist = session_id() === '' ? FALSE : TRUE;
    $currentUserId = null;
    if ($sessionExist == TRUE && isset($_SESSION['id'])) {
	$currentUserId = $_SESSION['id'];
    }
    return $currentUserId;
}

?>