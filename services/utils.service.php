<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		0.3
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
 * \return	number	the number representing the difference in microsecond
 * \return	Error	if the parameters are null
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
 * \return	string		the decoded string
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
 * \return	string		the string encoded for DB
 */
function encode_string($string) {
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
    return $string;
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
 * \return	string $currentUserId;
 */
function sessionChecker() {
    if (session_id() == '')
	session_start();
    $sessionExist = session_id() === '' ? FALSE : TRUE;
    $currentUserId = null;
    if ($sessionExist == TRUE && isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	$currentUserId = $currentUser->getId();
    }
    return $currentUserId;
}
?>