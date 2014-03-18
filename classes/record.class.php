<?php

/**
 * Record class
 * Classe dedicata ad un album di brani musicali, puo' essere istanziata solo da Jammer
 *
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Record
 */
class Record {

    /**
     * @var int id istanza
     */
    private $id;

    /**
     * @var date data creazione istanza
     */
    private $createdat;

    /**
     * @var date data modifica istanza
     */
    private $updatedat;

    /**
     * @var int istanza attiva/non attiva
     */
    private $active;

    /**
     * @var string url for buying the record
     */
    private $buylink;

    /**
     * @var string city for the record
     */
    private $city;

    /**
     * @var int numero di commenti
     */
    private $commentcounter;

    /**
     * @var int indice di gradimento
     */
    private $counter;

    /**
     * @var string per l'immagine di copertina
     */
    private $cover;

    /**
     * @var string descrizione del video
     */
    private $description;

    /**
     * @var int durata in secondi
     */
    private $duration;

    /**
     * @var int id del formuser
     */
    private $fromuser;

    /**
     * @var array di id del genere
     */
    private $genre;

    /**
     * @var string di definizione della label
     */
    private $label;

    /**
     * @var float latitudine
     */
    private $latitude;

    /**
     * @var float longitudine
     */
    private $longitude;

    /**
     * @var int contatore di azioni love
     */
    private $lovecounter;

    /**
     * @var int contatore di azioni review
     */
    private $reviewcounter;

    /**
     * @var int contatore di azioni share
     */
    private $sharecounter;

    /**
     * @var int contatore di canzoni
     */
    private $songcounter;

    /**
     * @var string path al thumbnail della cover
     */
    private $thumbnail;

    /**
     * @var string titolo album
     */
    private $title;

    /**
     * @var array id song
     */
    private $tracklist;

    /**
     * @var int anno realizzazione disco
     */
    private $year;

    /**
     * Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Record creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Record modification date
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
     * Return the buylink value
     * @return	string
     */
    public function getBuylink() {
	return $this->buylink;
    }

    /**
     * Return the city value
     * @return	string
     */
    public function getCity() {
	return $this->city;
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
     * Return the cover (path file) value
     * @return	string
     */
    public function getCover() {
	return $this->cover;
    }

    /**
     * Return the description value
     * @return	string
     */
    public function getDescription() {
	return $this->description;
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
     * @return	int
     */
    public function getGenre() {
	return $this->genre;
    }

    /**
     * Return the label value
     * @return	string
     */
    public function getLabel() {
	return $this->label;
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
     * Return the loveCounter value, number of users who love the record
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * Return the review counter value (number of review)
     * @return	int
     */
    public function getReviewcounter() {
	return $this->reviewcounter;
    }

    /**
     * Return the counter for sharing action
     * @return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * Return the song counter value (number of songs)
     * @return	int
     */
    public function getSongcounter() {
	return $this->songcounter;
    }

    /**
     * Return the thumbnail (path file) value
     * @return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * Return the title value
     * @return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * Return the tracklist value,array of Ids of song
     * @return	int
     */
    public function getTracklist() {
	return $this->tracklist;
    }

    /**
     * Return the year value
     * @return	string
     */
    public function getYear() {
	return $this->year;
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
     * Sets the buylink value
     * @param	string
     */
    public function setBuylink($buylink) {
	$this->buylink = $buylink;
    }

    /**
     * Sets the city value
     * @param	string
     */
    public function setCity($city) {
	$this->city = $city;
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
     * Sets the cover value
     * @param	string
     */
    public function setCover($cover) {
	$this->cover = $cover;
    }

    /**
     * Sets the description value
     * @param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * Sets the duration  value
     * @param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * Sets the fromUser id  value
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the genre value
     * @param	int
     */
    public function setGenre($genre) {
	$this->genre = $genre;
    }

    /**
     * Sets the label value
     * @param	string
     */
    public function setLabel($label) {
	$this->label = $label;
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
     * Sets the reviewcounter value
     * @param	int
     */
    public function setReviewcounter($reviewcounter) {
	$this->reviewcounter = $reviewcounter;
    }

    /**
     * Sets the sharecounter value
     * @param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * Sets the songcounter value
     * @param	int
     */
    public function setSongcounter($songcounter) {
	$this->songcounter = $songcounter;
    }

    /**
     * Sets the thumbnail (path file) value
     * @param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * Sets the title value
     * @param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * Sets the tracklist  value (list of id)
     * @param	array
     */
    public function setTracklist($tracklist) {
	$this->tracklist = $tracklist;
    }

    /**
     * Sets the year value
     * @param	string
     */
    public function setYear($year) {
	$this->year = $year;
    }

    /**
     * Return a printable string representing the Record object
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
	$string .= '[buylink] => ' . $this->getBuylink() . '<br/>';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br/>';
	$string .= '[description] => ' . $this->getDescription() . '<br/>';
	$string .= '[duration] => ' . $this->getDuration() . '<br/>';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	foreach ($this->getGenre() as $genre) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[genre] => ' . $genre . '<br />';
	}
	$string .= '[label] .= > ' . $this->getLabel() . '<br/>';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] .= > ' . $this->getLovecounter() . '<br/>';
	$string .= '[reviewcounter] => ' . $this->getReviewcounter() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	$string .= '[songcounter] => ' . $this->getSongcounter() . '<br />';
	$string .= '[thumbnailCover] .= > ' . $this->getThumbnail() . '<br/>';
	$string .= '[title] .= > ' . $this->getTitle() . '<br/>';
	$string .= '[tracklist] => ' . $this->getTracklist() . '<br />';
	$string .= '[year] .= > ' . $this->getYear() . '<br/>';
	return $string;
    }

}

?>