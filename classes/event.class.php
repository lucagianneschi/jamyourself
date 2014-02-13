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

    private $objectId;
    private $active;
    private $address;
    private $attendeeCounter;
    private $city;
    private $cancelledCounter;
    private $commentCounter;
    private $counter;
    private $description;
    private $eventDate;
    private $fromUser;
    private $genre;
    private $image;
    private $invitedCounter;
    private $latitude;
    private $longitude;
    private $locationName;
    private $loveCounter;
    private $reviewCounter;
    private $refusedCounter;
    private $shareCounter;
    private $tags;
    private $thumbnail;
    private $title;
    private $createdAt;
    private $updatedAt;

    /**
     * \fn	getObjectId()
     * \brief	Return the objectId value
     * \return	int
     */
    public function getObjectId() {
	return $this->objectId;
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
    public function getAttendeeCounter() {
	return $this->attendeeCounter;
    }

    /**
     * \fn	getCancelledCounter()
     * \brief	Return the number of attendees value
     * \return	string
     */
    public function getCancelledCounter() {
	return $this->cancelledCounter;
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
    public function getCommentCounter() {
	return $this->commentCounter;
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
     * \fn	string getDescription()
     * \brief	Return the description value
     * \return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * \fn	DateTime getEventDate()
     * \brief	Return the Event Date 
     * \return	DateTime
     */
    public function getEventDate() {
	return $this->eventDate;
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
     * \fn	array getGenre()
     * \brief	Return the genre (array) value for the genre
     * \return	array
     */
    public function getGenre() {
	return $this->genre;
    }

    /**
     * \fn		string getImage()
     * \brief	Return the path file string for the cover of the event
     * \return	string
     */
    public function getImage() {
	return $this->image;
    }

    /**
     * \fn	getInvitedCounter()
     * \brief	Return the number of invited value
     * \return	string
     */
    public function getInvitedCounter() {
	return $this->invitedCounter;
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
     * \fn	string getLocationName()
     * \brief	Return the name of the location
     * \return	string
     */
    public function getLocationName() {
	return $this->locationName;
    }

    /**
     * \fn	int getLoveCounter()
     * \brief	Return the int value of loveCounter, counting the love action on the event
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
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
     * \fn	int getReviewCounter()
     * \brief	Return the review counter value (number of review)
     * \return	int
     */
    public function getReviewCounter() {
	return $this->reviewCounter;
    }

    /**
     * \fn	int getShareCounter()
     * \brief	Return the counter for sharing action
     * \return	int
     */
    public function getShareCounter() {
	return $this->shareCounter;
    }

    /**
     * \fn	array getTags()
     * \brief	Return the tags value, array of string to categorize the event
     * \return	int
     */
    public function getTags() {
	return $this->tags;
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
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Event creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Event modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
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
     * \fn		void setAddress($address)
     * \brief	Sets the address value
     * \param	string
     */
    public function setAddress($address) {
	$this->address = $address;
    }

    /**
     * \fn	void setAttendeeCounter($attendeeCounter)
     * \brief	Sets the attendeeCounter value
     * \param	int
     */
    public function setAttendeeCounter($attendeeCounter) {
	$this->attendeeCounter = $attendeeCounter;
    }

    /**
     * \fn	void setCancelledCounter($cancelledCounter)
     * \brief	Sets the cancelledCounter value
     * \param	int
     */
    public function setCancelledCounter($cancelledCounter) {
	$this->cancelledCounter = $cancelledCounter;
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
     * \fn	void setCommentCounter($commentCounter)
     * \brief	Sets the commnetCounter value
     * \param	int
     */
    public function setCommentCounter($commentCounter) {
	$this->commentCounter = $commentCounter;
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
     * \fn	void setDescription($description)
     * \brief	Sets the description value
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn		setEventDate($eventDate)
     * \brief	Sets the Event Date date
     * \param	DateTime
     */
    public function setEventDate($eventDate) {
	$this->eventDate = $eventDate;
    }

    /**
     * \fn	void setFromUser($fromUser))
     * \brief	Sets the fromUser value,pointer to ParseUser
     * \param	int
     */
    public function setFromUser($fromUser) {
	$this->fromUser = $fromUser;
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
     * \fn	void setImage($image)
     * \brief	Sets the image value, path file to cover
     * \param	int
     */
    public function setImage($image) {
	$this->image = $image;
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
    public function setLocationName($locationName) {
	$this->locationName = $locationName;
    }

    /**
     * \fn	void setLoveCounter($loveCounter)
     * \brief	Sets the loveCounter value
     * \param	int
     */
    public function setLoveCounter($loveCounter) {
	$this->loveCounter = $loveCounter;
    }

    /**
     * \fn	void  setRefusedCounter($refusedCounter)
     * \brief	Sets the refusedCounter value
     * \param	int
     */
    public function setRefusedCounter($refusedCounter) {
	$this->refusedCounter = $refusedCounter;
    }

    /**
     * \fn	void setReviewCounter($reviewCounter)
     * \brief	Sets the reviewCounter value
     * \param	int
     */
    public function setReviewCounter($reviewCounter) {
	$this->reviewCounter = $reviewCounter;
    }

    /**
     * \fn	void setCounter($shareCounter)
     * \brief	Sets the shareCounter value
     * \param	int
     */
    public function setShareCounter($shareCounter) {
	$this->shareCounter = $shareCounter;
    }

    /**
     * \fn	void setTags($tags)
     * \brief	Sets the tags value
     * \param	int
     */
    public function setTags($tags) {
	$this->tags = $tags;
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
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Event creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Event modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Event object
     * \return	string
     */
    function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	if (is_null($this->getActive())) {
	    $string .= '[active] => NULL<br />';
	} else {
	    $this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
	}
	$string .= '[address] => ' . $this->getAddress() . '<br />';
	$string .= '[attendeeCounter] => ' . $this->getAttendeeCounter() . '<br />';
	$string .= '[cancelledCounter] => ' . $this->getCancelledCounter() . '<br />';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	if ($this->getEventDate() != null) {
	    $string .= '[eventDate] => ' . $this->getEventDate()->format('d-m-Y H:i:s') . '<br />';
	} else {
	    $string .= '[eventDate] => NULL<br />';
	}
	$string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	$string .= '[tags] => ' . $this->getGenre() . '<br />';
	$string .= '[image] => ' . $this->getImage() . '<br />';
	$string .= '[attendeeCounter] => ' . $this->getInvitedCounter() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[locationName] => ' . $this->getLocationName() . '<br />';
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
	$string .= '[reviewCounter] => ' . $this->getReviewCounter() . '<br />';
	$string .= '[refusedCounter] => ' . $this->getRefusedCounter() . '<br />';
	$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
	$string .= '[tags] => ' . $this->getTags() . '<br />';
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
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