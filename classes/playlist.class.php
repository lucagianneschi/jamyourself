<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Playslist
 *  \details   Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:playlist">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:playlist">API</a>
 */

class Playlist {

    private $objectId;
    private $active;
    private $fromUser;
    private $name;
    private $songs;
    private $unlimited;
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
     * \fn	BOOL getActive()
     * \brief	Return the active vvalure
     * \return	BOOL
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * \fn	string getFromUser()
     * \brief	Return the objectId value for the fromUser
     * \return	string
     */
    public function getFromUser() {
        return $this->fromUser;
    }

    /**
     * \fn	string getName()
     * \brief	Return the name value for playlist
     * \return	string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * \fn	array getSongs()
     * \brief	Return an array of objectId of istances of the Song class
     * \return	array
     */
    public function getSongs() {
        return $this->songs;
    }

    /**
     * \fn	BOOL getUnlimited()
     * \brief	Return the unlimited value (YES just for premium account)
     * \return	BOOL
     */
    public function getUnlimited() {
        return $this->unlimited;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Playlist creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Playlist modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * \fn	parseACL getACL()
     * \brief	Return the parseACL object representing the Playlist ACL 
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
     * \fn	void setActive($active)
     * \brief	Sets the active value
     * \param	BOOL
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * \fn	void setFromUser($fromUser))
     * \brief	Sets the fromUser value,pointer to ParseUser
     * \param	string
     */
    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    /**
     * \fn	void  setName($name)
     * \brief	Sets the name for the playlist
     * \param	string
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * \fn	void setSongs($songs)
     * \brief	Sets the songs value,array of pointer to Song
     * \param	array
     */
    public function setSongs($songs) {
        $this->songs = $songs;
    }

    /**
     * \fn	void setUnlimited($unlimited)
     * \brief	Sets the unlimited value
     * \param	BOOL
     */
    public function setUnlimited($unlimited) {
        $this->unlimited = $unlimited;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Playlist creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Playlist modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * \fn	void setACL($ACL)
     * \brief	Sets the parseACL object representing the Playlist ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

		/**
	* \fn		string __toString()
	* \brief	Return a printable string representing the Playlist object
	* \return	string
	*/
    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        if (is_null($this->getActive())) {
            $string .= '[active] => NULL<br />';
        } else {
            $this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
        }
        $string.="[fromUser] => " . $this->getFromUser() . "<br />";
        $string.="[name] => " . $this->getName() . "<br />";
        if (count($this->getSongs()) != 0) {
            foreach ($this->getSongs() as $song) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[songs] => ' . $song . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[songs] => NULL<br />';
        }
        if ($this->getUnlimited() === null) {
            $string .= '[unlimited] => NULL<br />';
        } else {
            $this->getUnlimited() ? $string .= '[unlimited] => 1<br />' : $string .= '[active] => 0<br />';
        }
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
                $string .= '[ACL] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[ACL] => NULL<br />';
        }
        return $string;
    }

}

?>