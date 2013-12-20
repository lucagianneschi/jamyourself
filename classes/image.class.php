<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version		1.0
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
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:image">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:image">API</a>
 */

class Image {

    private $objectId;
    private $active;
    private $album;
    private $commentCounter;
    private $counter;
    private $description;
    private $featuring;
    private $filePath;
    private $fromUser;
    private $location;
    private $loveCounter;
    private $lovers;
    private $shareCounter;
    private $tags;
    private $thumbnail;
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
     * \fn		string getAlbum()
     * \brief	Return the album value
     * \return	string
     */
    public function getAlbum() {
	return $this->album;
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
     * \fn		string getFilePath()
     * \brief	Return the filePath value, file path
     * \return	string
     */
    public function getFilePath() {
	return $this->filePath;
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
     * \fn		geopoint getLocation()
     * \brief	Return the location value
     * \return	geopoint
     */
    public function getLocation() {
	return $this->location;
    }

    /**
     * \fn		int getLoveCounter()
     * \brief	Return the int value of loveCounter, counting the love action on the image
     * \return	int
     */
    public function getLoveCounter() {
	return $this->loveCounter;
    }

    /**
     * \fn		array  getLovers()
     * \brief	Return the lovers value, array of objectId to istances of the _User, people ho love the image
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
     * \brief	Return the tags value, array of string to categorize the image
     * \return	array
     */
    public function getTags() {
	return $this->tags;
    }

    /**
     * \fn		string getThumbnail()
     * \brief	Return the thumbnail value, path for the thumnail
     * \return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * \fn		DateTime getCreatedAt()
     * \brief	Return the Image creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn		DateTime getUpdatedAt()
     * \brief	Return the Image modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn		parseACL getACL()
     * \brief	Return the parseACL object representing the Image ACL 
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
     * \fn		void setAlbum($album)
     * \brief	Sets the album value,pointer to ParseAlbum
     * \param	string
     */
    public function setAlbum($album) {
	$this->album = $album;
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
     * \fn		void setFilePath($filePath)
     * \brief	Sets the filePath value
     * \param	string
     */
    public function setFilePath($filePath) {
	$this->filePath = $filePath;
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
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value,string fot the thumbnail
     * \param	array
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn		void setCreatedAt($createdAt)
     * \brief	Sets the Image creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn		void setUpdatedAt($updatedAt)
     * \brief	Sets the Image modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn		void setACL($ACL)
     * \brief	Sets the parseACL object representing the Image ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
	$this->ACL = $ACL;
    }

    /**
     * \fn		void setACL($ACL)
     * \brief	Sets the parseACL object representing the Image ACL
     * \param	parseACL
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string.= '[album] => ' . $this->getAlbum() . '<br />';
	$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	if ($this->getFeaturing() != null && count($this->getFeaturing() > 0)) {
	    foreach ($this->getFeaturing() as $user) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[featuring] => ' . $user . '<br />';
	    }
	}
	$string .= '[filePath] => ' . $this->getFilePath() . '<br />';
	$fromUser = $this->getFromUser();
	if ($fromUser != null) {
	    $string.= '[fromUser] => ' . $fromUser . '<br />';
	}
	;
	if (($parseGeoPoint = $this->getLocation()) != null) {
	    $string .= '[location] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';
	}
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
	if ($this->getLovers() != null && count($this->getLovers() > 0)) {
	    foreach ($this->getLovers() as $lover) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[lover] => ' . $lover . '<br />';
	    }
	}
	$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
	if ($this->getTags() != null && count($this->getTags() > 0)) {
	    foreach ($this->getTags() as $tag) {
		$string.= '&nbsp&nbsp&nbsp&nbsp&nbsp';
		$string.= '[tag] => ' . $tag . '<br />';
	    }
	}
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