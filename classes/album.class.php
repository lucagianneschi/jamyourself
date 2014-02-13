<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Album
 *  \details		Classe raccoglitore per immagini
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Album">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Album">API</a>
 */

class Album {

    private $objectId;
    private $active;
    private $commentCounter;
    private $counter;
    private $cover;
    private $description;
    private $imageCounter;
    private $latitude;
    private $longitude;
    private $loveCounter;
    private $shareCounter;
    private $tags;
    private $thumbnail;
    private $title;
    private $createdAt;
    private $updatedAt;

    /**
     * \fn	getObjectId()
     * \brief	Return the objectId value
     * \return	string
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
     * \fn	getCommentCounter()
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
     * \fn      getCover()
     * \brief	Return the cover (path file) value
     * \return	string
     */
    public function getCover() {
	return $this->cover;
    }

    /**
     * \fn	getDescription()
     * \brief	Return the description value
     * \return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * \fn		int getImageCounter()
     * \brief	Return the image counter value (number of images)
     * \return	int
     */
    public function getImageCounter() {
	return $this->imageCounter;
    }

    /**
     * \fn	getLatitude()
     * \brief	Return the latitude value
     * \return	long
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
     * \fn	getLoveCounter()
     * \brief	Return the int value of loveCounter, counting the love action on the album
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
    }

    /**
     * \fn	getShareCounter()
     * \brief	Return the counter for sharing action
     * \return	int
     */
    public function getShareCounter() {
	return $this->shareCounter;
    }

    /**
     * \fn	getTags()
     * \brief	Return the tags value, array of string to categorize the album
     * \return	int
     */
    public function getTags() {
	return $this->tags;
    }

    /**
     * \fn	getThumbnail()
     * \brief	Return the thumbnail value 
     * \return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * \fn	getTitle()
     * \brief	Return the title value
     * \return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Album creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Album modification date
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
     * \fn	void setCommentCounter($commentCounter)
     * \brief	Sets the commnetCounter value
     * \param	int
     */
    public function setCommentCounter($commentCounter) {
	$this->commentCounter = $commentCounter;
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
     * \fn	void setImageCounter($imageCounter)
     * \brief	Sets the imagetCounter value
     * \param	int
     */
    public function setImageCounter($imageCounter) {
	$this->imageCounter = $imageCounter;
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
     * \fn	void setLocation($location)
     * \brief	Sets the longitude value
     * \param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
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
     * \fn	void setCounter($shareCounter)
     * \brief	Sets the shareCounter value
     * \param	int
     */
    public function setShareCounter($shareCounter) {
	$this->shareCounter = $shareCounter;
    }

    /**
     * \fn	void setTags($tags)
     * \brief	Sets the tags value,array of strings
     * \param	array
     */
    public function setTags($tags) {
	$this->tags = $tags;
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
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value
     * \param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Album creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn		void setUpdatedAt($updatedAt)
     * \brief	Sets the Album modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn		string __toString()
     * \brief	Return a printable string representing the Album object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	if (is_null($this->getActive())) {
	    $string .= '[active] => NULL<br />';
	} else {
	    $this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
	}
	$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[imageCounter] => ' . $this->getImageCounter() . '<br />';
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
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