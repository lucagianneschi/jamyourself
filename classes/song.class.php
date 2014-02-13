<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Song Class
 *  \details		Classe dedicata al singolo brano, puo' essere istanziata solo da Jammer
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Song">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Song">API</a>
 */

class Song {

    private $objectId;
    private $active;
    private $commentCounter;
    private $counter;
    private $duration;
    private $filePath;
    private $fromUser;
    private $genre;
    private $latitude;
    private $longitude;
    private $loveCounter;
    private $position;
    private $record;
    private $shareCounter;
    private $title;
    private $createdAt;
    private $updatedAt;

    /**
     * \fn	int getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
	return $this->objectId;
    }

    /**
     * \fn	BOOL getObjectId()
     * \brief	Return the active value
     * \return	BOOL
     */
    public function getActive() {
	return $this->active;
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
     * \fn	int getDuration()
     * \brief	Return the duration value in second
     * \return	int
     */
    public function getDuration() {
	return $this->duration;
    }

    /**
     * \fn	string getFilePath()
     * \brief	Return the filePath value,path of the mp3 file
     * \return	string
     */
    public function getFilePath() {
	return $this->filePath;
    }

    /**
     * \fn	int getFromUser()
     * \brief	Return the objectId value for the fromUser
     * \return	int
     */
    public function getFromUser() {
	return $this->fromUser;
    }

    /**
     * \fn	string getGenre()
     * \brief	Return the genre value 
     * \return	string
     */
    public function getGenre() {
	return $this->genre;
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
     * \brief	Return the loveCounter value, number of users who love the song
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
    }

    /**
     * \fn	string getPosition()
     * \brief	Return the position value,number of the song in the tracklist of its record
     * \return	string
     */
    public function getPosition() {
	return $this->position;
    }

    /**
     * \fn	int getRecord()
     * \brief	Return the record value,string of the objectId of the related record
     * \return	int
     */
    public function getRecord() {
	return $this->record;
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
     * \fn	string getTitle()
     * \brief	Return the title value
     * \return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Song creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Song modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn	void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	int
     */
    public function setObjectId($objectId) {
	$this->objectId = $objectId;
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
     * \fn	void setDuration($duration)
     * \brief	Sets the duration value
     * \param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * \fn	void setFilePath($filePath)
     * \brief	Sets the filePath  value
     * \param	string
     */
    public function setFilePath($filePath) {
	$this->filePath = $filePath;
    }

    /**
     * \fn	void setFromUser($fromUser)
     * \brief	Sets the fromUser objectId  value
     * \param	string
     */
    public function setFromUser($fromUser) {
	$this->fromUser = $fromUser;
    }

    /**
     * \fn	void setGenre($genre) 
     * \brief	Sets the genre value
     * \param	string
     */
    public function setGenre($genre) {
	$this->genre = $genre;
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
     * \fn	setPosition($position)
     * \brief	Sets the position value
     * \param	string
     */
    public function setPosition($position) {
	$this->position = $position;
    }

    /**
     * \fn	void setRecord($record) 
     * \brief	Sets the record objectId value
     * \param	int
     */
    public function setRecord($record) {
	$this->record = $record;
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
     * \fn	void setTitle($title) 
     * \brief	Sets the title value
     * \param	string
     */
    public function setTitle($title) {
	$this->title = $title;
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
     * \fn	string __toString()
     * \brief	Return a printable string representing the Song object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[duration] => ' . $this->getDuration() . '<br />';
	$string .= '[filePath] => ' . $this->getFilePath() . '<br />';
	$string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	$string .= '[genre] => ' . $this->getGenre() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
	$string .= '[position] => ' . $this->getPosition() . '<br />';
	$string .= '[record] => ' . $this->getRecord() . '<br />';
	$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
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