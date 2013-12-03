<?php
/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Stutus Class
 *  \details	Classe status dello User, raccoglie uno stato dell'utente, posso collegarci immagine o song
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:status">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:status">API</a>
 */

class Status {

	private $objectId;
	private $active;
	private $commentCounter;
	private $counter;
	private $event;
	private $fromUser;
	private $image;
	private $location;
	private $loveCounter;
	private $lovers;
	private $shareCounter;
	private $song;
	private $taggedUsers;
	private $text;
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
	 * \brief	Return the active vvalure
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
	 * \fn		string getEvent()
	 * \brief	Return the Event objectId value
	 * \return	string
	 */
	public function getEvent() {
		return $this->event;
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
	 * \fn		string getImage()
	 * \brief	Return the Image objectId value
	 * \return	string
	 */
	public function getImage() {
		return $this->image;
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
	 * \brief	Return the loveCounter  value
	 * \return	int
	 */
	public function getLoveCounter() {
		return $this->loveCounter;
	}

	/**
	 * \fn		array getLovers()
	 * \brief	Return the lovers value,array of objectId
	 * \return	array
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
	 * \fn		string getSong()
	 * \brief	Return the song value, objectId of song
	 * \return	string
	 */
	public function getSong() {
		return $this->song;
	}

	/**
	 * \fn		array getTaggedUsers()
	 * \brief	Return the taggedUsers value,array of objectId
	 * \return	array
	 */
	public function getTaggedUsers() {
		return $this->taggedUsers;
	}

	/**
	 * \fn		string getText()
	 * \brief	Return the text of the status
	 * \return	string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * \fn		DateTime getCreatedAt()
	 * \brief	Return the Status creation date
	 * \return	DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * \fn		DateTime getUpdatedAt()
	 * \brief	Return the Status modification date
	 * \return	DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * \fn		parseACL getACL()
	 * \brief	Return the parseACL object representing the Status ACL 
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

	//Parse Object Event: evento associato allo status
	public function setEvent($event) {
		$this->events = $event;
	}

	/**
	 * \fn		void setFromUser($fromUser)
	 * \brief	Sets the fromUser value,pointer to ParseUser
	 * \param	string
	 */
	public function setFromUser($fromUser) {
		$this->fromUser = $fromUser;
	}

	/**
	 * \fn		void setImage($image)
	 * \brief	Sets the image value,pointer to ParseImage (objectId)
	 * \param	string
	 */
	public function setImage($image) {
		$this->image = $image;
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
	 * \fn		void setSong($song)
	 * \brief	Sets the song value,pointer to ParseSong (objectId)
	 * \param	string
	 */
	public function setSong($song) {
		$this->song = $song;
	}

	/**
	 * \fn		void setTaggedUsers($taggedUsers)
	 * \brief	Sets the lovers taggedUsers,array of pointer to ParseUser
	 * \param	array
	 */
	public function setTaggedUsers($taggedUsers) {
		$this->taggedUsers = $taggedUsers;
	}

	/**
	 * \fn		void setText($text)
	 * \brief	Sets the test value
	 * \param	string
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * \fn		void setCreatedAt($createdAt)
	 * \brief	Sets the Status creation date
	 * \param	DateTime
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}

	/**
	 * \fn		void setUpdatedAt($updatedAt)
	 * \brief	Sets the Status modification date
	 * \param	DateTime
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}

	/**
	 * \fn		void setACL($ACL)
	 * \brief	Sets the parseACL object representing the Status ACL
	 * \param	parseACL
	 */
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}

	/**
	 * \fn		string __toString()
	 * \brief	Return a printable string representing the Status object
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
		if ($this->getEvent() != null) {
			$string .= '[event] => ' . $this->getEvent() . '<br />';
		} else {
			$string .= '[event] => NULL<br />';
		}
		$string.= '[fromUser] => ' . $this->getFromUser() . '<br />';
		$string .= '[image] => ' . $this->getImage() . '<br />';
		if ( ($geopoint = $this->getLocation()) != null) {
			$string .= '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
		} else {
			$string .= '[location] => NULL<br />';
		}
		$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
		if (count($this->getLovers()) != 0) {
			foreach ($this->getLovers() as $lovers) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[lovers] => ' . $lovers . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[lovers] => NULL<br />';
		}
		$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
		if ($this->getSong() != null) {
			$string .= '[song] => ' . $this->getSong() . '<br />';
		} else {
			$string .= '[song] => NULL<br />';
		}
		if (count($this->getTaggedUsers()) != 0) {
			foreach ($this->getTaggedUsers() as $taggedUser) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[taggedUser] => ' . $taggedUser . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[taggedUser] => NULL<br />';
		}
		$string.= '[text] => ' . $this->getText() . '<br />';
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