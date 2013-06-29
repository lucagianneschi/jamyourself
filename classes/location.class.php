<?php

/* ! \par Info Generali:
 *  \author    Luca Gianneschi
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Location
 *  \details   Classe che accoglie i dati di latitudine e longitudine delle citta da impostre per JAMMER  e SPOTTER
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

    /**
     * \fn	string getObjectId()
     * \brief	Return the objectId value
     * \return	string
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
     * \fn	string getGeopoint()
     * \brief	Return the geoPoint value
     * \return	parseGeopoint
     */
    public function getGeopoint() {
        return $this->geoPoint;
    }

    /**
     * \fn	string getLocId()
     * \brief	Return the locId value
     * \return	string
     */
    public function getLocId() {
        return $this->locId;
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
     * \fn	parseACL getACL()
     * \brief	Return the parseACL object representing the Location ACL 
     * \return	parseACL
     */
    public function getACL() {
        return $this->ACL;
    }

    /**
     * \fn	void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	string
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
     * \fn	void setGeoPoint($geoPoint)
     * \brief	Sets the geoPoint value
     * \param	parsegeopoint
     */
    public function setGeoPoint($geoPoint) {
        $this->geoPoint = $geoPoint;
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
     * \fn	void setACL($ACL)
     * \brief	Sets the parseACL object representing the Location ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

        /**
     * \fn	void setACL($ACL)
     * \brief	Sets the parseACL object representing the Location ACL
     * \param	parseACL
     */
    public function __toString() {
        $string = "";
        if ($this->objectId != null)
            $string .= "[objectId ] => " . $this->objectId . "<br />";
        if ($this->city != null)
            $string .= "[city] => " . $this->city . "<br />";
        if ($this->country != null)
            $string .= "[country] => " . $this->country . "<br />";
        $parseGeoPoint = $this->getGeoPoint();
        if ($parseGeoPoint != null) {
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
        if ($this->getACL() != null) {
            foreach ($this->getACL()->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[key] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        }
        return $string;
    }

}

?>
