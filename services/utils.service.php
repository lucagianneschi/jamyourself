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
 * \fn		string parse_decode_string($string)
 * \brief	The function returns a string read from Parse that can be interpreted by the user
 * \param	$string 	represent the string from Parse to decode
 * \return	string		the decoded string
 */
function parse_decode_string($string) {
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    $decodedString = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    return $decodedString;
}

/**
 * \fn		string parse_encode_string($string)
 * \brief	The function returns a string that can be saved to Parse
 * \param	$string 	represent the string to be saved
 * \return	string		the string encoded for Parse
 */
function parse_encode_string($string) {
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
    return $string;
}

?>