<?php

/**
 * Classe dedicata al singolo brano, puo' essere istanziata solo da Jammer
 *
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Song
 */
class Song {

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
     * @property int numero di commenti
     */
    private $commentcounter;

    /**
     * @property int indice di gradimento
     */
    private $counter;

    /**
     * @property int durata in secondi
     */
    private $duration;

    /**
     * @property int id dell'utente che fa upload dell'album
     */
    private $fromuser;

    /**
     * @property int id del genre della song
     */
    private $genre;

    /**
     * @property float latitudine
     */
    private $latitude;

    /**
     * @property float longitudine
     */
    private $longitude;

    /**
     * @property int contatore azioni love
     */
    private $lovecounter;

    /**
     * @property string del path dell'mp3
     */
    private $path;

    /**
     * @property int posizione nella tracklist
     */
    private $position;

    /**
     * @property int id del record
     */
    private $record;

    /**
     * @property int contatore di azioni share
     */
    private $sharecounter;

    /**
     * @property string titolo della song
     */
    private $title;

    /**
     * Return the id value
     * @return	string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Song creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Song modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * Return the active value
     * @return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * Return the comment counter value (number of comments)
     * @return	int
     */
    public function getCommentcounter() {
	return $this->commentcounter;
    }

    /**
     * Return the counter value
     * @return	int
     */
    public function getCounter() {
	return $this->counter;
    }

    /**
     * Return the duration value in second
     * @return	int
     */
    public function getDuration() {
	return $this->duration;
    }

    /**
     * Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * Return the genre value 
     * @return	string
     */
    public function getGenre() {
	return $this->genre;
    }

    /**
     * Return the latitude value
     * @return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * Return the longitude value
     * @return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * Return the loveCounter value, number of users who love the song
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * Return the path value
     * @return	string
     */
    public function getPath() {
	return $this->path;
    }

    /**
     * Return the position value,number of the song in the tracklist of its record
     * @return	string
     */
    public function getPosition() {
	return $this->position;
    }

    /**
     * Return the record value,string of the id of the related record
     * @return	int
     */
    public function getRecord() {
	return $this->record;
    }

    /**
     * Return the counter for sharing action
     * @return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * Return the title value
     * @return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * Sets the id value
     * @param	int
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * Sets the Song creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * Sets the Song modification date
     * @param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * Sets the active  value
     * @param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * Sets the commnetCounter value
     * @param	int
     */
    public function setCommentcounter($commentcounter) {
	$this->commentcounter = $commentcounter;
    }

    /**
     * Sets the counter  value
     * @param	int
     */
    public function setCounter($counter) {
	$this->counter = $counter;
    }

    /**
     * Sets the duration value
     * @param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * Sets the fromUser id  value
     * @param	string
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the genre value
     * @param	string
     */
    public function setGenre($genre) {
	$this->genre = $genre;
    }

    /**
     * Sets the latitude value
     * @param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * Sets the longitude value
     * @param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * Sets the LoveCounter  value
     * @param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * Sets the path value
     * @param	string
     */
    public function setPath($path) {
	$this->path = $path;
    }

    /**
     * Sets the position value
     * @param	string
     */
    public function setPosition($position) {
	$this->position = $position;
    }

    /**
     * Sets the record id value
     * @param	int
     */
    public function setRecord($record) {
	$this->record = $record;
    }

    /**
     * Sets the sharecounter value
     * @param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * Sets the title value
     * @param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * Return a printable string representing the Song object
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
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[duration] => ' . $this->getDuration() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[genre] => ' . $this->getGenre() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[path] => ' . $this->getPath() . '<br />';
	$string .= '[position] => ' . $this->getPosition() . '<br />';
	$string .= '[record] => ' . $this->getRecord() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	return $string;
    }

}

?>