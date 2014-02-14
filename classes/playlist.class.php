<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Playslist
 *  \details		Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Playlists">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Playlist">API</a>
 */

class Playlist {

    private $id;
    private $createdAt;
    private $updatedAt;
    private $active;
    private $fromUser;
    private $name;
    private $songCounter;
    private $songs;
    private $unlimited;

    /**
     * \fn	int getId()
     * \brief	Return the id value
     * \return	int
     */
    public function getId() {
	return $this->id;
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
     * \fn	BOOL getActive()
     * \brief	Return the active value
     * \return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	getFromUser()
     * \brief	Return the id value for the fromUser
     * \return	int
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
     * \fn	int getSongCounter()
     * \brief	Return the song counter value (number of songs)
     * \return	int
     */
    public function getSongCounter() {
	return $this->songCounter;
    }

    /**
     * \fn	getSongs()
     * \brief	Return an array of object of istances of the Song class
     * \return	int
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
     * \fn	void setId($id)
     * \brief	Sets the id value
     * \param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn		void setCreatedAt($createdAt)
     * \brief	Sets the Playlist creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn		void setUpdatedAt($updatedAt)
     * \brief	Sets the Playlist modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
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
     * \brief	Sets the fromUser value
     * \param	int
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
     * \fn	void  setSongCounter($songCounter)
     * \brief	Sets the songCounter value
     * \param	int
     */
    public function setSongCounter($songCounter) {
	$this->songCounter = $songCounter;
    }

    /**
     * \fn	void setSongs($songs)
     * \brief	Sets the songs value,array of pointer to Song
     * \param	int
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
     * \fn	string __toString()
     * \brief	Return a printable string representing the Playlist object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	$string .= '[name] => ' . $this->getName() . '<br />';
	$string .= '[songCounter] => ' . $this->getSongCounter() . '<br />';
	$string .= '[songs] => ' . $this->getSongs() . '<br />';
	$string .= '[unlimited] => ' . $this->getUnlimited() . '<br />';
	return $string;
    }

}

?>