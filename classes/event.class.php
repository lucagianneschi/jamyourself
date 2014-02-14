<?php

/* ! \par	    Info Generali:
 *  \author	    Maria Laura Fresu
 *  \version	    0.3
 *  \date	    2013
 *  \copyright	    Jamyourself.com 2013
 *  \par Info	    Classe:
 *  \brief	    Event
 *  \details	    Classe dedicata agli eventi, solo JAMMER e VENUE possono istanziare questa classe
 *  \par	    Commenti:
 *  \warning
 *  \bug
 *  \todo		
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Event">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Event">API</a>
 */

class Event {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $address;
    private $attendeecounter;
    private $city;
    private $cover;
    private $cancelledcounter;
    private $commentcounter;
    private $counter;
    private $description;
    private $eventdate;
    private $fromuser;
    private $genre;
    private $invitedcounter;
    private $latitude;
    private $longitude;
    private $locationname;
    private $lovecounter;
    private $reviewcounter;
    private $refusedcounter;
    private $sharecounter;
    private $tag;
    private $thumbnail;
    private $title;

    /**
     * \fn	getId()
     * \brief	Return the id value
     * \return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn	DateTime getCreatedat()
     * \brief	Return the Event creation date
     * \return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Event modification date
     * \return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
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
     * \fn	getAddress()
     * \brief	Return the address value
     * \return	string
     */
    public function getAddress() {
	return $this->address;
    }

    /**
     * \fn	getAttendeeCounter()
     * \brief	Return the number of attendees value
     * \return	string
     */
    public function getAttendeecounter() {
	return $this->attendeecounter;
    }

    /**
     * \fn	getCancelledCounter()
     * \brief	Return the number of attendees value
     * \return	string
     */
    public function getCancelledcounter() {
	return $this->cancelledcounter;
    }

    /**
     * \fn	getCity()
     * \brief	Return the city value
     * \return	string
     */
    public function getCity() {
	return $this->city;
    }

    /**
     * \fn	int getCommentCounter()
     * \brief	Return the comment counter value (number of comments)
     * \return	int
     */
    public function getCommentcounter() {
	return $this->commentcounter;
    }

    /**
     * \fn	int getCounter()
     * \brief	Return the counter value
     * \return	int
     */
    public function getCounter() {
	return $this->counter;
    }

    /**
     * \fn	getCover()
     * \brief	Return the city value
     * \return	string
     */
    public function getCover() {
	return $this->cover;
    }

    /**
     * \fn	string getDescription()
     * \brief	Return the description value
     * \return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * \fn	DateTime getEventdate()
     * \brief	Return the Event Date 
     * \return	DateTime
     */
    public function getEventdate() {
	return $this->eventdate;
    }

    /**
     * \fn	string getFromuser()
     * \brief	Return the id value for the fromUser
     * \return	string
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * \fn	array getGenre()
     * \brief	Return the genre (array) value for the genre
     * \return	array
     */
    public function getGenre() {
	return $this->genre;
    }

    /**
     * \fn	getInvitedCounter()
     * \brief	Return the number of invited value
     * \return	string
     */
    public function getInvitedcounter() {
	return $this->invitedcounter;
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
     * \fn	getLongitude()
     * \brief	Return the longitude value
     * \return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * \fn	string getLocationname()
     * \brief	Return the name of the location
     * \return	string
     */
    public function getLocationname() {
	return $this->locationname;
    }

    /**
     * \fn	int getLovecounter()
     * \brief	Return the int value of loveCounter, counting the love action on the event
     * \return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * \fn	getRefusedCounter()
     * \brief	Return the number of attendees value
     * \return	string
     */
    public function getRefusedCounter() {
	return $this->refusedCounter;
    }

    /**
     * \fn	int getReviewcounter()
     * \brief	Return the review counter value (number of review)
     * \return	int
     */
    public function getReviewcounter() {
	return $this->reviewcounter;
    }

    /**
     * \fn	int getSharecounter()
     * \brief	Return the counter for sharing action
     * \return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * \fn	array getTag()
     * \brief	Return the tags value, array of string to categorize the event
     * \return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail value
     * \return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * \fn	string getTitle()
     * \brief	Return the title value
     * \return	string
     */
    public function getTitle() {
	return $this->title;
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
     * \fn	void setCreatedat($createdat)
     * \brief	Sets the Event creation date
     * \param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn	void setUpdatedat($updatedat)
     * \brief	Sets the Event modification date
     * \param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
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
     * \fn		void setAddress($address)
     * \brief	Sets the address value
     * \param	string
     */
    public function setAddress($address) {
	$this->address = $address;
    }

    /**
     * \fn	void setAttendeecounter($attendeecounter)
     * \brief	Sets the attendeeCounter value
     * \param	int
     */
    public function setAttendeecounter($attendeecounter) {
	$this->attendeecounter = $attendeecounter;
    }

    /**
     * \fn	void setCancelledcounter($cancelledCounter)
     * \brief	Sets the cancelledcounter value
     * \param	int
     */
    public function setCancelledcounter($cancelledcounter) {
	$this->cancelledcounter = $cancelledcounter;
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
     * \fn	void setCommentcounter($commentcounter)
     * \brief	Sets the commnetCounter value
     * \param	int
     */
    public function setCommentcounter($commentcounter) {
	$this->commentcounter = $commentcounter;
    }

    /**
     * \fn		void setCounter($counter)
     * \brief	Sets the counter value
     * \param	int
     */
    public function setCounter($counter) {
	$this->counter = $counter;
    }

    /**
     * \fn	void setCover($cover)
     * \brief	Sets the cover value
     * \param	string
     */
    public function setCover($cover) {
	$this->cover = $cover;
    }

    /**
     * \fn	void setDescription($description)
     * \brief	Sets the description value
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn	setEventDate($eventDate)
     * \brief	Sets the Event Date date
     * \param	DateTime
     */
    public function setEventdate($eventdate) {
	$this->eventdate = $eventdate;
    }

    /**
     * \fn	void setFromuser($fromuser))
     * \brief	Sets the fromUser value,pointer to ParseUser
     * \param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * \fn	void setGenre($genre)
     * \brief	Sets the genre value, array for genres
     * \param	int
     */
    public function setGenre($genre) {
	$this->genre = $genre;
    }

    /**
     * \fn	setInvitedCounter($invitedCounter)
     * \brief	Sets the invitedCounter value
     * \param	int
     */
    public function setInvitedCounter($invitedCounter) {
	$this->invitedCounter = $invitedCounter;
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
     * \fn	void setLongitude($longitude)
     * \brief	Sets the longitude value
     * \param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * \fn	void setLocationName($locationName)
     * \brief	Sets the locationName value
     * \param	string
     */
    public function setLocationname($locationname) {
	$this->locationname = $locationname;
    }

    /**
     * \fn	void setLovecounter($lovecounter)
     * \brief	Sets the loveCounter value
     * \param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * \fn	void  setRefusedCounter($refusedcounter)
     * \brief	Sets the refusedCounter value
     * \param	int
     */
    public function setRefusedcounter($refusedcounter) {
	$this->refusedcounter = $refusedcounter;
    }

    /**
     * \fn	void setReviewcounter($reviewcounter)
     * \brief	Sets the reviewcounter value
     * \param	int
     */
    public function setReviewcounter($reviewcounter) {
	$this->reviewcounter = $reviewcounter;
    }

    /**
     * \fn	void setCounter($sharecounter)
     * \brief	Sets the sharecounter value
     * \param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * \fn	void setTag($tag)
     * \brief	Sets the tags value
     * \param	int
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value
     * \param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn	void setTitle($title)
     * \brief	Sets the title value
     * \param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Event object
     * \return	string
     */
    function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$string .= '[createdat] => ' . $this->getCreatedat()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedat] => ' . $this->getUpdatedat()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[address] => ' . $this->getAddress() . '<br />';
	$string .= '[attendeecounter] => ' . $this->getAttendeecounter() . '<br />';
	$string .= '[cancelledcounter] => ' . $this->getCancelledcounter() . '<br />';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[eventdate] => ' . $this->getEventdate()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[tags] => ' . $this->getGenre() . '<br />';
	$string .= '[invitedcounter] => ' . $this->getInvitedcounter() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[locationname] => ' . $this->getLocationname() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[reviewcounter] => ' . $this->getReviewcounter() . '<br />';
	$string .= '[refusedcounter] => ' . $this->getRefusedCounter() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	$string .= '[tags] => ' . $this->getTag() . '<br />';
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	return $string;
    }

}

?>