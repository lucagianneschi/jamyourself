<?php

/* ! \par		Info Generali:
 *  @author		Stefano Muscas
 *  @version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Utils class
 *  \details		Classe di utilità sfruttata delle classi modello per snellire il codice
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo		Fare API su Wiki
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

/**
 * \fn		number executionTime($start, $end)
 * \brief	The function returns the difference between $end and $start parameter in microseconds
 * \param	$start	represent the microsecond time of the begin of the operation
 * \param	$end	represent the microsecond time of the end of the operation
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
 * \fn		string decode_string($string)
 * \brief	The function returns a string read from DB that can be interpreted by the user
 * \param	$string 	represent the string from DB to decode
 * @return	string		the decoded string
 */
function decode_string($string) {
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    $decodedString = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    return $decodedString;
}

/**
 * \fn		string encode_string($string)
 * \brief	The function returns a string that can be saved to DB
 * \param	$string 	represent the string to be saved
 * @return	string		the string encoded for DB
 */
function encode_string($string) {
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
    return $string;
}

/**
 * \fn	    filterFeaturingByValue($array, $value)
 * \brief   filtra featuind per tipo
 * \param   $array, $value
 * @return  $newarray
 * \todo    
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
 * \fn	    getCroppedImages($decoded)
 * \brief   funzione per recupero immagini dopo crop
 * \param   $decoded
 * \todo   check possibilità utilizzo di questa funzione come pubblica e condivisa tra più controller
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
 * \fn	    sendMailForNotification($address, $subject, $html)
 * \brief   invia mail ad utente
 * \param   $address, $subject, $html
 * \todo    testare
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
 * \fn		sessionChecker()
 * \brief	The function returns a string wiht the id of the user in session, if there's no user return a invalid ID used (valid for the code)
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