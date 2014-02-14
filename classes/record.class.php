<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Record 
 *  \details		Classe dedicata ad un album di brani musicali, puo' essere istanziata solo da Jammer
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Record">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Record">API</a>
 */

class Record {

    private $id;
    private $createdAt;
    private $updatedAt;
    private $active;
    private $buyLink;
    private $city;
    private $commentCounter;
    private $counter;
    private $cover;
    private $description;
    private $duration;
    private $fromUser;
    private $genre;
    private $label;
    private $latitude;
    private $longitude;
    private $loveCounter;
    private $reviewCounter;
    private $shareCounter;
    private $songCounter;
    private $thumbnail;
    private $title;
    private $tracklist;
    private $year;

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
     * \brief	Return the Record creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Record modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn	BOOL getId()
     * \brief	Return the active value
     * \return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	string getBuyLink()
     * \brief	Return the buyLink value
     * \return	string
     */
    public function getBuyLink() {
	return $this->buyLink;
    }

    /**
     * \fn	string getCity
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
     * \fn	string getCover()
     * \brief	Return the cover (path file) value
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
     * \fn	int getDuration()
     * \brief	Return the duration value in second
     * \return	int
     */
    public function getDuration() {
	return $this->duration;
    }

    /**
     * \fn	int getFromUser()
     * \brief	Return the id value for the fromUser
     * \return	int
     */
    public function getFromUser() {
	return $this->fromUser;
    }

    /**
     * \fn	getGenre()
     * \brief	Return the genre value 
     * \return	int
     */
    public function getGenre() {
	return $this->genre;
    }

    /**
     * \fn	string getLabel()
     * \brief	Return the label value
     * \return	string
     */
    public function getLabel() {
	return $this->label;
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
     * \fn	int getLoveCounter()
     * \brief	Return the loveCounter value, number of users who love the record
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
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
     * \fn	int getSongCounter()
     * \brief	Return the song counter value (number of songs)
     * \return	int
     */
    public function getSongCounter() {
	return $this->songCounter;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail (path file) value
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
     * \fn	getTracklist()
     * \brief	Return the tracklist value,array of Ids of song
     * \return	int
     */
    public function getTracklist() {
	return $this->tracklist;
    }

    /**
     * \fn	string getYear()
     * \brief	Return the year value
     * \return	string
     */
    public function getYear() {
	return $this->year;
    }

    /**
     * \fn	void setId($id)
     * \brief	Sets the id value
     * \param	int
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Song creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Song modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn	void setActive($active)
     * \brief	Sets the active  value
     * \param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn	void setBuyLink($buyLink)
     * \brief	Sets the buyLink value
     * \param	string
     */
    public function setBuyLink($buyLink) {
	$this->buyLink = $buyLink;
    }

    /**
     * \fn	setCity($city)
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
     * \fn	void setCounter($counter)
     * \brief	Sets the counter  value
     * \param	int
     */
    public function setCounter($counter) {
	$this->counter = $counter;
    }

    /**
     * \fn	void setCover($cover))
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
     * \fn	void setDuration($duration)
     * \brief	Sets the duration  value
     * \param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * \fn	void setFromUser($fromUser)
     * \brief	Sets the fromUser id  value
     * \param	int
     */
    public function setFromUser($fromUser) {
	$this->fromUser = $fromUser;
    }

    /**
     * \fn	void setGenre($genre) 
     * \brief	Sets the genre value
     * \param	int
     */
    public function setGenre($genre) {
	$this->genre = $genre;
    }

    /**
     * \fn	void setLabel($label) 
     * \brief	Sets the label value
     * \param	string
     */
    public function setLabel($label) {
	$this->label = $label;
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
     * \fn	void setLoveCounter($loveCounter)
     * \brief	Sets the LoveCounter  value
     * \param	int
     */
    public function setLoveCounter($loveCounter) {
	$this->loveCounter = $loveCounter;
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
     * \fn	void  setSongCounter($songCounter)
     * \brief	Sets the songCounter value
     * \param	int
     */
    public function setSongCounter($songCounter) {
	$this->songCounter = $songCounter;
    }

    /**
     * \fn	void setThumbnail($thumbnail) 
     * \brief	Sets the thumbnail (path file) value
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
     * \fn	void setTracklist($tracklist)
     * \brief	Sets the tracklist  value (list of id)
     * \param	array
     */
    public function setTracklist($tracklist) {
	$this->tracklist = $tracklist;
    }

    /**
     * \fn	void setYear($year) 
     * \brief	Sets the year value
     * \param	string
     */
    public function setYear($year) {
	$this->year = $year;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Record object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[buyLink] => ' . $this->getBuyLink() . '<br/>';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br/>';
	$string .= '[description] => ' . $this->getDescription() . '<br/>';
	$string .= '[duration] => ' . $this->getDuration() . '<br/>';
	$string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	$string .= '[genre] .= > ' . $this->getGenre() . '<br/>';
	$string .= '[label] .= > ' . $this->getLabel() . '<br/>';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[loveCounter] .= > ' . $this->getLoveCounter() . '<br/>';
	$string .= '[reviewCounter] => ' . $this->getReviewCounter() . '<br />';
	$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
	$string .= '[songCounter] => ' . $this->getSongCounter() . '<br />';
	$string .= '[thumbnailCover] .= > ' . $this->getThumbnail() . '<br/>';
	$string .= '[title] .= > ' . $this->getTitle() . '<br/>';
	$string .= '[tracklist] => ' . $this->getTracklist() . '<br />';
	$string .= '[year] .= > ' . $this->getYear() . '<br/>';
	return $string;
    }

}

?>