<?php

/* ! \par		Info Generali:
 *  \author		Luca Gianneschi
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Location
 *  \details		Classe che accoglie i dati di latitudine e longitudine delle citta da impostre per JAMMER  e SPOTTER
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo		fare API classe
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Location">Descrizione della classe</a>
 *  <a href=" ">API</a>
 */

class Location {

    private $objectId;
    private $city;
    private $country;
    private $latitude;
    private $locId;
    private $longitude;
    private $createdAt;
    private $updatedAt;

    /**
     * \fn	int getObjectId()
     * \brief	Return the objectId value
     * \return	int
     */
    public function getObjectId() {
	return $this->objectId;
    }

    /**
     * \fn	string getCity()
     * \brief	Return the city value
     * \return	string
     */
    public function getCity() {
	return $this->city;
    }

    /**
     * \fn	string getCountry()
     * \brief	Return the country value
     * \return	string
     */
    public function getCountry() {
	return $this->coutry;
    }

    /**
     * \fn	getLatitude()
     * \brief	Return the latitude value
     * \return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * \fn	getLocId()
     * \brief	Return the locId
     * \return	locId
     */
    public function getLocId() {
	return $this->locId;
    }

    /**
     * \fn	getLongitude()
     * \brief	Return the longitude value
     * \return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Location creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Location modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn	void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	int
     */
    public function setObjectId($objectId) {
	$this->objectId = $objectId;
    }

    /**
     * \fn	void setCity($city)
     * \brief	Sets the city value
     * \param	string
     */
    public function setCity($city) {
	$this->city = $city;
    }

    /**
     * \fn	void setCountry($country)
     * \brief	Sets the country value
     * \param	string
     */
    public function setCountry($country) {
	$this->country = $country;
    }

    /**
     * \fn	void setLatitude($latitude)
     * \brief	Sets the latitude value
     * \param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * \fn	void setLocId($locId)
     * \brief	Sets the locId value
     * \param	string
     */
    public function setLocId($locId) {
	$this->locId = $locId;
    }

    /**
     * \fn	void setLongitude($longitude)
     * \brief	Sets the longitude value
     * \param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Location creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Location modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Location object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->objectId . '<br />';
	$string .= '[city] => ' . $this->city . '<br />';
	$string .= '[country] => ' . $this->country . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[locId] => ' . $this->locId . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
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
	return $string;
    }

}

?>