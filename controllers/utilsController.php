<?php

/* ! \par Info	Generali:
 *  \author		Luca Gianneschi
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *
 *  \par		Info Classe:
 *  \brief		Utils class
 *  \details            Classe di utilità sfruttata dai controller  per snellire il codice
 *
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo       
 *
 */

/**
 * \fn		parse_encode_array($array)
 * \brief	The function returns an array that can be saved to Parse
 * \param	$array 	represent the array to be saved
 * \return	array		the array encoded for Parse
 */
function parse_encode_array($array) {
    $encodedArray = array();
    if (!empty($array) && !is_null($array) && count($array) >0) {
	foreach ($array as $string) {
	    $encodedString = parse_encode_array($string);
	    array_push($encodedArray, $encodedString);
	}
    }
    return $encodedArray;
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