<?php

/* ! \par Info Generali:
 * \author Luca Gianneschi
 * \version 1.0
 * \date 2013
 * \copyright Jamyourself.com 2013
 *
 * \par Info Classe:
 * \brief Classe di test
 * \details Classe di test per la classe Location
 *
 * \par Commenti:
 * \warning
 * \bug
 * \todo modificare require_once
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'location.class.php';
require_once CLASSES_DIR . 'locationParse.class.php';

echo '<br />INIZIO IL RECUPERO DI UNA Location<br /><br />';

$locationParse = new LocationParse();
$resGet = $locationParse->getLocation('hAcjcsoLn9');
if (get_class($resGet) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
    echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNA LOCATION<br />';

echo '<br />-------------------------------------------------------------------------------<br />';


echo '<br />INIZIO IL RECUPERO DI PIU\' LOCATION<br />';

$locationParse = new LocationParse();
$locationParse->whereExists('objectId');
$locationParse->orderByDescending('createdAt');
$locationParse->setLimit(5);
$resGets = $locationParse->getLocations();
if (get_class($resGets) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
    foreach ($resGets as $location) {
	echo '<br />' . $location->getObjectId() . '<br />';
    }
}

echo '<br />FINITO IL RECUPERO DI PIU\' Location<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>