<?php

/**
 * Event class
 * Classe dedicata agli eventi, solo JAMMER e VENUE possono istanziare questa classe
 *
 * @author		Maria Laura Fresu
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Event
 */
class Event {

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
     * @property string di indirizzo della venue
     */
    private $address;

    /**
     * @property int numero di partecipanti all'event
     */
    private $attendeecounter;

    /**
     * @property int numero di partecipanti cancellati dall'event
     */
    private $cancelledcounter;

    /**
     * @property string city for the record
     */
    private $city;

    /**
     * @property int numero di commenti
     */
    private $commentcounter;

    /**
     * @property int indice di gradimento
     */
    private $counter;

    /**
     * @property string per l'immagine di copertina
     */
    private $cover;

    /**
     * @property string descrizione del video
     */
    private $description;

    /**
     * @property Datetime data dell'evento
     */
    private $eventdate;

    /**
     * @property int id del formuser
     */
    private $fromuser;

    /**
     * @property array di id del genere
     */
    private $genre;

    /**
     * @property int numero di invitati all'evento
     */
    private $invitedcounter;

    /**
     * @property float latitudine
     */
    private $latitude;

    /**
     * @property string per il nome della location
     */
    private $locationname;

    /**
     * @property float longitudine
     */
    private $longitude;

    /**
     * @property int contatore di azioni love
     */
    private $lovecounter;

    /**
     * @property int contatore di azioni review
     */
    private $reviewcounter;

    /**
     * @property int contatore di utenti che hanno rifiutato invito
     */
    private $refusedcounter;

    /**
     * @property int contatore di azioni share
     */
    private $sharecounter;

    /**
     * @property array di id di tag
     */
    private $tag;

    /**
     * @property string path al thumbnail della cover
     */
    private $thumbnail;

    /**
     * @property string titolo album
     */
    private $title;

    /**
     * Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Event creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Event modification date
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
     * Return the address value
     * @return	string
     */
    public function getAddress() {
	return $this->address;
    }

    /**
     * Return the number of attendees value
     * @return	string
     */
    public function getAttendeecounter() {
	return $this->attendeecounter;
    }

    /**
     * Return the number of attendees value
     * @return	string
     */
    public function getCancelledcounter() {
	return $this->cancelledcounter;
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
     * Return the city value
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
     * Return the Event Date 
     * @return	DateTime
     */
    public function getEventdate() {
	return $this->eventdate;
    }

    /**
     * Return the id value for the fromUser
     * @return	string
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * Return the genre (array) value for the genre
     * @return	array
     */
    public function getGenre() {
	return $this->genre;
    }

    /**
     * Return the number of invited value
     * @return	string
     */
    public function getInvitedcounter() {
	return $this->invitedcounter;
    }

    /**
     * Return the latitude value
     * @return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * Return the name of the location
     * @return	string
     */
    public function getLocationname() {
	return $this->locationname;
    }

    /**
     * Return the longitude value
     * @return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * Return the int value of loveCounter, counting the love action on the event
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * Return the number of attendees value
     * @return	string
     */
    public function getRefusedCounter() {
	return $this->refusedCounter;
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
     * Return the tags value, array of string to categorize the event
     * @return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * Return the thumbnail value
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
     * Sets the id value
     * @param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn	void setCreatedat($createdat)
     * \brief	Sets the Event creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * Sets the Event modification date
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
     * Sets the address value
     * @param	string
     */
    public function setAddress($address) {
	$this->address = $address;
    }

    /**
     * Sets the attendeeCounter value
     * @param	int
     */
    public function setAttendeecounter($attendeecounter) {
	$this->attendeecounter = $attendeecounter;
    }

    /**
     * Sets the cancelledcounter value
     * @param	int
     */
    public function setCancelledcounter($cancelledcounter) {
	$this->cancelledcounter = $cancelledcounter;
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
     * Sets the counter value
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
     * Sets the Event Date date
     * @param	DateTime
     */
    public function setEventdate($eventdate) {
	$this->eventdate = $eventdate;
    }

    /**
     * Sets the fromUser value
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the genre value, array for genres
     * @param	int
     */
    public function setGenre($genre) {
	$this->genre = $genre;
    }

    /**
     * Sets the invitedCounter value
     * @param	int
     */
    public function setInvitedCounter($invitedCounter) {
	$this->invitedCounter = $invitedCounter;
    }

    /**
     * Sets the latitude value
     * @param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * Sets the locationName value
     * @param	string
     */
    public function setLocationname($locationname) {
	$this->locationname = $locationname;
    }

    /**
     * Sets the longitude value
     * @param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * Sets the loveCounter value
     * @param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * Sets the refusedCounter value
     * @param	int
     */
    public function setRefusedcounter($refusedcounter) {
	$this->refusedcounter = $refusedcounter;
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
     * Sets the tags value
     * @param	int
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * Sets the thumbnail value
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
     * Return a printable string representing the Event object
     * @return	string
     */
    function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$createdAt = new DateTime($this->getCreatedat());
	$string .= '[createdat] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
	$updatedAt = new DateTime($this->getUpdatedat());
	$string .= '[updatedat] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[address] => ' . $this->getAddress() . '<br />';
	$string .= '[attendeecounter] => ' . $this->getAttendeecounter() . '<br />';
	$string .= '[cancelledcounter] => ' . $this->getCancelledcounter() . '<br />';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$eventDate = new DateTime($this->getEventdate());
	$string .= '[eventdate] => ' . $eventDate->format('d-m-Y H:i:s') . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	foreach ($this->getGenre() as $genre) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[genre] => ' . $genre . '<br />';
	}
	$string .= '[invitedcounter] => ' . $this->getInvitedcounter() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[locationname] => ' . $this->getLocationname() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[reviewcounter] => ' . $this->getReviewcounter() . '<br />';
	$string .= '[refusedcounter] => ' . $this->getRefusedCounter() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	foreach ($this->getTag() as $tag) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[tag] => ' . $tag . '<br />';
	}
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	return $string;
    }

}

?>