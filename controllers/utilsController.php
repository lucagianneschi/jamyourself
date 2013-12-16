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
 * \todo		implementare funzioni comuni a più controllers
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

/**
 * \fn	    getCoordinates($city)
 * \brief   cerca le coordinate della città inserita nel form, prima sul DB, poi 
 * \param   $address, $subject, $html
 * \todo    testare
 */
function getCoordinates($city,$country) {
    $geoPointArray = array();
    if (!is_null($city)&& (!is_null($country))) {
        require_once CLASSES_DIR . 'location.class.php';
        require_once CLASSES_DIR . 'locationParse.class.php';
        $location = new LocationParse();
        $location->where('city', $city);
        $location->where('country', $country);
        $location->setLimit(1);
        $locations = $location->getLocations();
        if ($locations instanceof Error || is_null($locations)) {
            require_once SERVICES_DIR . 'geocoder.service.php';
            $geoCodingService = new GeocoderService();
            $geoPoint = $geoCodingService->getLocation($city.','.$country);
            $parseGeoPoint = (!$geoPoint) ? null : new parseGeoPoint($geoPoint['lat'], $geoPoint['lng']);
            return $parseGeoPoint;
        } else {
            foreach ($locations as $loc) {
                array_push($geoPointArray, $loc->getGeopoint());
            }
        }
    }
    $geoPoint = (count($geoPointArray) != 0) ? $geoPointArray[0] : null;
    return  $geoPoint;
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

?>