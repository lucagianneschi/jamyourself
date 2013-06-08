<?php
/*! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     geoPointParse
 *  \details   Classe che serve per accogliere latitudine e longitudine di un 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:geopointparse">API</a>
 */

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