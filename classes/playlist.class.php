<?php

/* ! \par		Info Generali:
 *  @author		Stefano Muscas
 *  @version		0.3
 *  @since		2013
 *  @copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Playslist
 *  \details		Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  \par		Commenti:
 *  @warning
 *  @bug
 *  @todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Playlists">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Playlist">API</a>
 */

class Playlist {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $fromuser;
    private $name;
    private $songcounter;
    private $songs;
    private $unlimited;

    /**
     * \fn	int getId()
     * \brief	Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn	DateTime getCreatedat()
     * \brief	Return the Playlist creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Playlist modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * \fn	BOOL getActive()
     * \brief	Return the active value
     * @return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	getFromuser()
     * \brief	Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * \fn	string getName()
     * \brief	Return the name value for playlist
     * @return	string
     */
    public function getName() {
	return $this->name;
    }

    /**
     * \fn	int getsongcounter()
     * \brief	Return the song counter value (number of songs)
     * @return	int
     */
    public function getSongcounter() {
	return $this->songcounter;
    }

    /**
     * \fn	int getsongs()
     * \brief	Return the song counter value (number of songs)
     * @return	int
     */
    public function getSongs() {
	return $this->songs;
    }

    /**
     * \fn	BOOL getUnlimited()
     * \brief	Return the unlimited value (YES just for premium account)
     * @return	BOOL
     */
    public function getUnlimited() {
	return $this->unlimited;
    }

    /**
     * \fn	void setId($id)
     * \brief	Sets the id value
     * @param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn		void setCreatedat($createdat)
     * \brief	Sets the Playlist creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn		void setUpdatedat($updatedat)
     * \brief	Sets the Playlist modification date
     * @param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * \fn	void setActive($active)
     * \brief	Sets the active value
     * @param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn	void setFromuser($fromuser))
     * \brief	Sets the fromUser value
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * \fn	void  setName($name)
     * \brief	Sets the name for the playlist
     * @param	string
     */
    public function setName($name) {
	$this->name = $name;
    }

    /**
     * \fn	void  setSongs($songs)
     * \brief	Sets the songs value
     * @param	int
     */
    public function setSongs($songs) {
	$this->songs = $songs;
    }

    /**
     * \fn	void  setsongcounter($songcounter)
     * \brief	Sets the songcounter value
     * @param	int
     */
    public function setSongcounter($songcounter) {
	$this->songcounter = $songcounter;
    }

    /**
     * \fn	void setUnlimited($unlimited)
     * \brief	Sets the unlimited value
     * @param	BOOL
     */
    public function setUnlimited($unlimited) {
	$this->unlimited = $unlimited;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Playlist object
     * @return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$createdAt = new DateTime($this->getCreatedat());
	$string .= '[createdat] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
	$updatedAt = new DateTime($this->getUpdatedat());
	$string .= '[updatedat] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[name] => ' . $this->getName() . '<br />';
	$string .= '[songcounter] => ' . $this->getSongcounter() . '<br />';
	$string .= '[songs] => ' . $this->getSongs() . '<br />';
	$string .= '[unlimited] => ' . $this->getUnlimited() . '<br />';
	return $string;
    }

}

?>
