<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Image
 *  \details		Classe per la singola immagine caricata dall'utente
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Image">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Image">API</a>
 */

class Image {

    private $objectId;
    private $active;
    private $album;
    private $commentCounter;
    private $counter;
    private $description;
    private $filePath;
    private $fromUser;
    private $latitude;
    private $longitude;
    private $loveCounter;
    private $shareCounter;
    private $tags;
    private $thumbnail;
    private $createdAt;
    private $updatedAt;

    /**
     * \fn	int getObjectId()
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
     * \fn	int getAlbum()
     * \brief	Return the album value
     * \return	int
     */
    public function getAlbum() {
	return $this->album;
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
     * \fn	string getFilePath()
     * \brief	Return the filePath value, file path
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
     * \brief	Return the int value of loveCounter, counting the love action on the image
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
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
     * \fn	getTags()
     * \brief	Return the tags value
     * \return	int
     */
    public function getTags() {
	return $this->tags;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail value, path for the thumnail
     * \return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Image creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Image modification date
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
     * \brief	Sets the active value
     * \param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn	void setAlbum($album)
     * \brief	Sets the album value
     * \param	int
     */
    public function setAlbum($album) {
	$this->album = $album;
    }

    /**
     * \fn	void setCommentCounter($commentCounter)
     * \brief	Sets the commentCounter value
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
     * \fn	void setDescription($description)
     * \brief	Sets the description value
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn	void setFilePath($filePath)
     * \brief	Sets the filePath value
     * \param	string
     */
    public function setFilePath($filePath) {
	$this->filePath = $filePath;
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
     * \brief	Sets the tags value
     * \param	int
     */
    public function setTags($tags) {
	$this->tags = $tags;
    }

    /**
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value,string fot the thumbnail
     * \param	array
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Image creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Image modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Image object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[album] => ' . $this->getAlbum() . '<br />';
	$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[filePath] => ' . $this->getFilePath() . '<br />';
	$string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
	$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
	$string .= '[tags] => ' . $this->getTags() . '<br />';
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
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