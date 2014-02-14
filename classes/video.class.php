<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Video 
 *  \details		Classe che contiene i video presi da Vimeo e Youtube e segnalati dagli utenti 
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Video">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Video">API</a>
 */

class Video {

    private $objectId;
    private $createdAt;
    private $updatedAt;
    private $active;
    private $author;
    private $counter;
    private $cover;
    private $description;
    private $duration;
    private $fromUser;
    private $loveCounter;
    private $tags;
    private $thumbnail;
    private $title;
    private $URL;

    /**
     * \fn	int getObjectId()
     * \brief	Return the objectId value
     * \return	int
     */
    public function getObjectId() {
	return $this->objectId;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Video creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Video modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn	boolean getActive()
     * \brief	Return the active value
     * \return	boolean
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	string getAuthor()
     * \brief	Return the author value; author is the uploader on YouTube or Vimeo
     * \return	string
     */
    public function getAuthor() {
	return $this->author;
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
     * \brief	Return the objectId value for the fromUser
     * \return	int
     */
    public function getFromUser() {
	return $this->fromUser;
    }

    /**
     * \fn	int getLoveCounter()
     * \brief	Return the int value of loveCounter, counting the love action on the video
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
    }

    /**
     * \fn	int getTags()
     * \brief	Return the tags value, array of string to categorize the video
     * \return	int
     */
    public function getTags() {
	return $this->tags;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail value, URL of the video cover image
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
     * \fn	string getURL()
     * \brief	Return the URL value
     * \return	string
     */
    public function getURL() {
	return $this->URL;
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
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Video creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Video modification date
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
     * \fn	void setAuthor($author)
     * \brief	Sets the author value
     * \param	string
     */
    public function setAuthor($author) {
	$this->author = $author;
    }

    /**
     * \fn	void setCounter($counter)
     * \brief	Sets the counter value
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
     * \brief	Sets the duration value
     * \param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
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
     * \fn	void setLoveCounter($loveCounter)
     * \brief	Sets the loveCounter value
     * \param	int
     */
    public function setLoveCounter($loveCounter) {
	$this->loveCounter = $loveCounter;
    }

    /**
     * \fn	void setTags($tags)
     * \brief	Sets the tags value,array of strings
     * \param	int
     */
    public function setTags($tags) {
	$this->tags = $tags;
    }

    /**
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value, url of the cover image of the video
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
     * \fn	void setURL($URL)
     * \brief	Sets the URL value, url of the video
     * \param	string
     */
    public function setURL($URL) {
	$this->URL = $URL;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Video object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[author] => ' . $this->getAuthor() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[duration] => ' . $this->getDuration() . '<br />';
	$string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
	$string .= '[tags] => ' . $this->getTags() . '<br />';
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	$string .= '[URL] => ' . $this->getURL() . '<br />';
	return $string;
    }

}

?>