<?php

define('PARSE_DIR', '../parse/');
include_once PARSE_DIR.'parse.php';

class GeoPointParse {
	
	private $parseGeoPoint;
	
	public function __construct($lat, $lon){
		$this->parseGeoPoint = new parseGeoPoint($lat, $lon);
	}
	
	public function getGeoPoint() {
		return $this->parseGeoPoint->location;
	}
	
	public function printGeoPoint() {
		echo '[lat] => ' . $this->parseGeoPoint->lat . '<br />';
		echo '[lon] => ' . $this->parseGeoPoint->long . '<br />';
	}
	
}

?>