<?php

/**
 * Playslist class
 * Classe che accoglie le canzoni che andranno nel player della pagina utente
 *
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Playlists
 */
class Playlist {

    /**
     * @property int id istanza
     */
    private $id;

    /**
     * @property date data creazione istanza
     */
    private $createdat;

    /**
     * @property date data modifica istanza
     */
    private $updatedat;

    /**
     * @property int istanza attiva/non attiva
     */
    private $active;

    /**
     * @property int id del formuser
     */
    private $fromuser;

    /**
     * @property string name of the playlist
     */
    private $name;

    /**
     * @property int numero di canzoni nella playlist
     */
    private $songcounter;

    /**
     * @property array di id di song in playlist
     */
    private $songs;

    /**
     * @property int 1 = YES, 0 = NO
     */
    private $unlimited;

    /**
     * Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Playlist creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Playlist modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * Return the active value
     * @return	int
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * Return the name value for playlist
     * @return	string
     */
    public function getName() {
	return $this->name;
    }

    /**
     * Return the song counter value (number of songs)
     * @return	int
     */
    public function getSongcounter() {
	return $this->songcounter;
    }

    /**
     * Return the song counter value (number of songs)
     * @return	int
     */
    public function getSongs() {
	return $this->songs;
    }

    /**
     * Return the unlimited value (YES just for premium account)
     * @return	BOOL
     */
    public function getUnlimited() {
	return $this->unlimited;
    }

    /**
     * Sets the id value
     * @param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * Sets the Playlist creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * Sets the Playlist modification date
     * @param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * Sets the active value
     * @param	int
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * Sets the fromUser value
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the name for the playlist
     * @param	string
     */
    public function setName($name) {
	$this->name = $name;
    }

    /**
     * Sets the songs value
     * @param	int
     */
    public function setSongs($songs) {
	$this->songs = $songs;
    }

    /**
     * Sets the songcounter value
     * @param	int
     */
    public function setSongcounter($songcounter) {
	$this->songcounter = $songcounter;
    }

    /**
     * Sets the unlimited value
     * @param	BOOL
     */
    public function setUnlimited($unlimited) {
	$this->unlimited = $unlimited;
    }

    /**
     * Return a printable string representing the Playlist object
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