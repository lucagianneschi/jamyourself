<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'location.class.php';
require_once CLASSES_DIR . 'locationParse.class.php';

class locationNew {

    public function sendInfo() {
	$resultArray = array();
	$location = new LocationParse();
	$location->orderByDescending('country');
	$locations = $location->getLocations();
	var_dump($location);
	
    }
}

$loc = new locationNew();

$loc->sendInfo();

?>