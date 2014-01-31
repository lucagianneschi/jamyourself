<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version		1.0
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
    private $featuring;
    private $fromUser;
    private $imageCounter;
    private $images;
    private $location;
    private $loveCounter;
    private $lovers;
    private $shareCounter;
    private $tags;
    private $thumbnailCover;
    private $title;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    /**
     * \fn		string getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
	return $this->objectId;
    }

    /**
     * \fn		BOOL getActive()
     * \brief	Return the active value
     * \return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn		int getCommentCounter()
     * \brief	Return the comment counter value (number of comments)
     * \return	int
     */
    public function getCommentCounter() {
	return $this->commentCounter;
    }

    /**
     * \fn		int getCounter()
     * \brief	Return the counter value
     * \return	int
     */
    public function getCounter() {
	return $this->counter;
    }

    /**
     * \fn		string getCover()
     * \brief	Return the cover (path file) value
     * \return	string
     */
    public function getCover() {
	return $this->cover;
    }

    /**
     * \fn		string getDescription()
     * \brief	Return the description value
     * \return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * \fn		array getFeaturing()
     * \brief	Return the featuring value, array of objectId to _User istances
     * \return	array
     */
    public function getFeaturing() {
	return $this->featuring;
    }

    /**
     * \fn		string getFromUser()
     * \brief	Return the objectId value for the fromUser
     * \return	string
     */
    public function getFromUser() {
	return $this->fromUser;
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
     * \fn		array getImages()
     * \brief	Return the images value, array of objectId to Image istances
     * \return	array
     */
    public function getImages() {
	return $this->images;
    }

    /**
     * \fn		geopoint getLocation()
     * \brief	Return the location  value
     * \return	geopoint
     */
    public function getLocation() {
	return $this->location;
    }

    /**
     * \fn		int getLoveCounter()
     * \brief	Return the int value of loveCounter, counting the love action on the album
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
    }

    /**
     * \fn		array  getLovers()
     * \brief	Return the lovers value, array of objectId to istances of the _User, people ho love the album
     * \return	string
     */
    public function getLovers() {
	return $this->lovers;
    }

    /**
     * \fn		int getShareCounter()
     * \brief	Return the counter for sharing action
     * \return	int
     */
    public function getShareCounter() {
	return $this->shareCounter;
    }

    /**
     * \fn		array getTags()
     * \brief	Return the tags value, array of string to categorize the album
     * \return	array
     */
    public function getTags() {
	return $this->tags;
    }

    /**
     * \fn		string getThumbnailCover()
     * \brief	Return the thumbnailCover value 
     * \return	string
     */
    public function getThumbnailCover() {
	return $this->thumbnailCover;
    }

    /**
     * \fn		string getTitle()
     * \brief	Return the title value
     * \return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * \fn		DateTime getCreatedAt()
     * \brief	Return the Album creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn		DateTime getUpdatedAt()
     * \brief	Return the Album modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn		parseACL getACL()
     * \brief	Return the parseACL object representing the Album ACL 
     * \return	parseACL
     */
    public function getACL() {
	return $this->ACL;
    }

    /**
     * \fn		void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	string
     */
    public function setObjectId($objectId) {
	$this->objectId = $objectId;
    }

    /**
     * \fn		void setActive($active)
     * \brief	Sets the active value
     * \param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn		void setCommentCounter($commentCounter)
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
     * \fn		void setCover($cover)
     * \brief	Sets the cover value
     * \param	string
     */
    public function setCover($cover) {
	$this->cover = $cover;
    }

    /**
     * \fn		void setDescription($description)
     * \brief	Sets the description value
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn		void setFeaturing($featuring)
     * \brief	Sets the featuring value,array of pointer to ParseUser
     * \param	array
     */
    public function setFeaturing($featuring) {
	$this->featuring = $featuring;
    }

    /**
     * \fn		void setFromUser($fromUser))
     * \brief	Sets the fromUser value,pointer to ParseUser
     * \param	string
     */
    public function setFromUser($fromUser) {
	$this->fromUser = $fromUser;
    }

    /**
     * \fn		void setImageCounter($imageCounter)
     * \brief	Sets the imagetCounter value
     * \param	int
     */
    public function setImageCounter($imageCounter) {
	$this->imageCounter = $imageCounter;
    }

    /**
     * \fn		void setImages($images)
     * \brief	Sets the images value,array of pointer to Image
     * \param	array
     */
    public function setImages($images) {
	$this->images = $images;
    }

    /**
     * \fn		void setLocation($location)
     * \brief	Sets the location value
     * \param	parseGeopoint
     */
    public function setLocation($location) {
	$this->location = $location;
    }

    /**
     * \fn		void setLoveCounter($loveCounter)
     * \brief	Sets the loveCounter value
     * \param	int
     */
    public function setLoveCounter($loveCounter) {
	$this->loveCounter = $loveCounter;
    }

    /**
     * \fn		void setLovers($lovers)
     * \brief	Sets the lovers value,array of pointer to ParseUser
     * \param	array
     */
    public function setLovers($lovers) {
	$this->lovers = $lovers;
    }

    /**
     * \fn		void setCounter($shareCounter)
     * \brief	Sets the shareCounter value
     * \param	int
     */
    public function setShareCounter($shareCounter) {
	$this->shareCounter = $shareCounter;
    }

    /**
     * \fn		void setTags($tags)
     * \brief	Sets the tags value,array of strings
     * \param	array
     */
    public function setTags($tags) {
	$this->tags = $tags;
    }

    /**
     * \fn		void setTitle($title)
     * \brief	Sets the title value
     * \param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * \fn		void setThumbnailCover($thumbnailCover)
     * \brief	Sets the thumbnailCover value
     * \param	string
     */
    public function setThumbnailCover($thumbnailCover) {
	$this->thumbnailCover = $thumbnailCover;
    }

    /**
     * \fn		void setCreatedAt($createdAt)
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
     * \fn		void setACL($ACL)
     * \brief	Sets the parseACL object representing the Album ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
	$this->ACL = $ACL;
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
	if ($this->getFeaturing() != 0) {
	    foreach ($this->getFeaturing() as $featuring) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[featuring] => ' . $featuring . '<br />';
	    }
	} else {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[featuring] => NULL<br />';
	}
	if ($this->getFromUser() != null) {
	    $string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	} else {
	    $string .= '[fromUser] => NULL<br />';
	}
	$string .= '[imageCounter] => ' . $this->getImageCounter() . '<br />';
	if ($this->getImages() != 0) {
	    foreach ($this->getImages() as $images) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[images] => ' . $images . '<br />';
	    }
	} else {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[images] => NULL<br />';
	}
	if (($geopoint = $this->getLocation()) != null) {
	    $string .= '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
	} else {
	    $string .= '[location] => NULL<br />';
	}
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
	if ($this->getLovers() != 0) {
	    foreach ($this->getLovers() as $lovers) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[lovers] => ' . $lovers . '<br />';
	    }
	} else {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[lovers] => NULL<br />';
	}
	$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
	if ($this->getTags() != 0) {
	    foreach ($this->getTags() as $tags) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[tags] => ' . $tags . '<br />';
	    }
	} else {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[tags] => NULL<br />';
	}
	$string .= '[thumbnailCover] => ' . $this->getThumbnailCover() . '<br />';
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
	if ($this->getACL() != null) {
	    foreach ($this->getACL()->acl as $key => $acl) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[ACL] => ' . $key . '<br />';
		foreach ($acl as $access => $value) {
		    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
		}
	    }
	} else {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[ACL] => NULL<br />';
	}
	return $string;
    }

}

?>