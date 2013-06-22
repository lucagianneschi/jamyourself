<?php

/* ! \par Info Generali:
 *  \author    Luca Gianneschi
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Location
 *  \details   Classe che accoglie i dati di laqtitudine e longitudine delle citta da impostre per JAMMER  e SPOTTER
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:location">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:location">API</a>
 */

class Location {

    private $objectId;  															
    private $city;      																
    private $country;  									
    private $geoPoint;        			
    private $locId;   		           
    private $createdAt; 									
    private $updatedAt;  									
    private $ACL;   			

    //COSTRUTTORE

    public function __construct() {
        
    }
	//FUNZIONI GETTER
     
    public function getObjectId() {
        return $this->objectId;
    }

	public function getCity() {
        return $this->city;
    }
	
	public function getCountry() {
        return $this->coutry;
    }
	
	public function getGeopoint() {
        return $this->geoPoint;
    }
	
	public function getLocId() {
        return $this->locId;
    }
	
    public function getCreatedAt() {
        return $this->createdAt;
    }

  
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getACL() {
        return $this->ACL;
    }
	
	public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }
	
	public function setCity($city) {
        $this->city = $city;
    }
	
	public function setCountry($country) {
        $this->country = $country;
    }
	
	public function setGeoPoint($geoPoint) {
        $this->geoPoint= $geoPoint;
    }
	
	public function setLocId($locId) {
        $this->locId= $locId;
    }

	public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt( $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    public function __toString() {
        $string = "";
        if ($this->objectId != null)
            $string .= "[objectId ] => " . $this->objectId . "<br />";
		if ($this->city != null)
            $string .= "[city] => " . $this->city . "<br />";
		if ($this->country != null)
            $string .= "[country] => " . $this->country . "<br />";
		$parseGeoPoint = $this->getGeoPoint();
		if($parseGeoPoint != null){
		$string .= '[geoPoint] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';
		}		
		if ($this->locId != null)
            $string .= "[locId] => " . $this->locId . "<br />";
        if ($this->getCreatedAt() != null) {
			$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[createdAt] => NULL<br />';
		}
		if ($this->getUpdatedAt() != null) {
			$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[updatedAt] => NULL<br />';
		}
		$string .= '[ACL] => ' . print_r($this->getACL(), true) . '<br />';
        return $string;
    }
}

?>
