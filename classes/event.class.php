<?php

/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Event
 *  \details   Classe dedicata agli eventi, solo JAMMER e VENUE possono istanziare questa classe
 *  
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo		Gestire la propriet� File
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:event">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:event">API</a>
 */

class Event {

	private $objectId;
	private $active;
	private $attendee;
	private $address;
	private $city;
	private $commentCounter;
	private $commentators;
	private $comments;
	private $counter;
	private $description;
	private $eventDate;
	private $featuring;
	private $fromUser;
	private $image;
	private $imageFile;
	private $invited;
	private $location;
	private $locationName;
	private $loveCounter;
	private $lovers;
	private $refused;
	private $shareCounter;
	private $tags;
	private $thumbnail;
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
	 * \fn		string getAddress()
	 * \brief	Return the address value
	 * \return	string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * \fn		array getAttendee()
	 * \brief	Return an array of objectId of istances of _User class who area attendee to the event
	 * \return	array
	 */
	public function getAttendee() {
		return $this->attendee;
	}
	
	/**
	 * \fn		string getCity()
	 * \brief	Return the city value
	 * \return	string
	 */
	public function getCity() {
		return $this->city;
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
	 * \fn		array getCommentators()
	 * \brief	Return an array of objectId of istances of _User class who commented on the event
	 * \return	array
	 */
	public function getCommentators() {
		return $this->commentators;
	}

	/**
	 * \fn		array getComments()
	 * \brief	Return an array of objectId of istances of the Comment class; comments on the event
	 * \return	array
	 */
	public function getComments() {
		return $this->comments;
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
	 * \fn		DateTime getEventDate()
	 * \brief	Return the Event Date 
	 * \return	DateTime
	 */
	public function getEventDate() {
		return $this->eventDate;
	}

	/**
	 * *
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
	 * \fn		string getImage()
	 * \brief	Return the path file string for the cover of the event
	 * \return	string
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * \fn		string getImageFile()
	 * \brief	Return the  file string for the cover of the event
	 * \return	parseFile
	 */
	public function getImageFile() {
		return $this->imageFile;
	}

	/**
	 * \fn		array getInvited()
	 * \brief	Return the invited value, array of objectId to _User istances
	 * \return	array
	 */
	public function getInvited() {
		return $this->invited;
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
	 * \fn		string getLocationName()
	 * \brief	Return the name of the location
	 * \return	string
	 */
	public function getLocationName() {
		return $this->locationName;
	}

	/**
	 * \fn		int getLoveCounter()
	 * \brief	Return the int value of loveCounter, counting the love action on the event
	 * \return	int
	 */
	public function getLoveCounter() {
		return $this->loveCounter;
	}

	/**
	 * \fn		array  getLovers()
	 * \brief	Return the lovers value, array of objectId to istances of the _User, people ho love the event
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
	 * \fn		array  getRefused()
	 * \brief	Return the refuse value, array of objectId to istances of the _User, people will not attend the event
	 * \return	string
	 */
	public function getRefused() {
		return $this->refused;
	}

	/**
	 * \fn		array getTags()
	 * \brief	Return the tags value, array of string to categorize the event
	 * \return	array
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * \fn		string getThumbnail()
	 * \brief	Return the thumbnail value
	 * \return	string
	 */
	public function getThumbnail() {
		return $this->thumbnail;
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
	 * \brief	Return the Event creation date
	 * \return	DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * \fn		DateTime getUpdatedAt()
	 * \brief	Return the Event modification date
	 * \return	DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * \fn		parseACL getACL()
	 * \brief	Return the parseACL object representing the Event ACL 
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
	 * \fn		void setAddress($address)
	 * \brief	Sets the address value
	 * \param	string
	 */
	public function setAddress($address) {
		$this->address = $address;
	}
	
	/**
	 * \fn		void setAttendee($attendee)
	 * \brief	Sets the attendee value,array of pointer to ParseUser
	 * \param	array
	 */
	public function setAttendee($attendee) {
		$this->attendee = $attendee;
	}
	
	/**
	 * \fn		void setCity($city)
	 * \brief	Sets the city value
	 * \param	string
	 */
	public function setCity($city) {
		$this->city = $city;
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
	 * \fn		void setCommentators($commentators)
	 * \brief	Sets the commentators value,array of pointer to ParseUser
	 * \param	array
	 */
	public function setCommentators($commentators) {
		$this->commentators = $commentators;
	}

	/**
	 * \fn		void setComments($comments)
	 * \brief	Sets the comments value,array of pointer to ParseComment
	 * \param	array
	 */
	public function setComments($comments) {
		$this->comments = $comments;
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
	 * \fn		setEventDate($eventDate)
	 * \brief	Sets the Event Date date
	 * \param	DateTime
	 */
	public function setEventDate($eventDate) {
		$this->eventDate = $eventDate;
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
	 * \fn		void setImage($image)
	 * \brief	Sets the image value, path file to cover
	 * \param	string
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * \fn		void setImageFile($imageFile)
	 * \brief	Sets the imageFile value, path file to cover
	 * \param	parseFile
	 */
	public function setImageFile($imageFile) {
		$this->imageFile = $imageFile;
	}

	/**
	 * \fn		void setInvited($invited)
	 * \brief	Sets the invited value,array of pointer to ParseUser
	 * \param	array
	 */
	public function setInvited($invited) {
		$this->invited = $invited;
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
	 * \fn		void setLocationName($locationName)
	 * \brief	Sets the locationName value
	 * \param	string
	 */
	public function setLocationName($locationName) {
		$this->locationName = $locationName;
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
	 * \fn		void setRefused($refused)
	 * \brief	Sets the refused value,array of pointer to ParseUser
	 * \param	array
	 */
	public function setRefused($refused) {
		$this->refused = $refused;
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
	 * \fn		void setThumbnail($thumbnail)
	 * \brief	Sets the thumbnail value
	 * \param	string
	 */
	public function setThumbnail($thumbnail) {
		$this->thumbnail = $thumbnail;
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
	 * \fn		void setCreatedAt($createdAt)
	 * \brief	Sets the Event creation date
	 * \param	DateTime
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}

	/**
	 * \fn		void setUpdatedAt($updatedAt)
	 * \brief	Sets the Event modification date
	 * \param	DateTime
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}

	/**
	 * \fn		void setACL($ACL)
	 * \brief	Sets the parseACL object representing the Event ACL
	 * \param	parseACL
	 */
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}

	/**
	 * \fn		string __toString()
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
		if (count($this->getAttendee()) != 0) {
			foreach ($this->getAttendee() as $attendee) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[attendee] => ' . $attendee . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[attendee] => NULL<br />';
		}
		$string .= '[city] => ' . $this->getCity() . '<br />';
		$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
		if ($this->getCommentators() != 0) {
			foreach ($this->getCommentators() as $commentators) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[commentators] => ' . $commentators . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[commentators] => NULL<br />';
		}
		if ($this->getComments() != 0) {
			foreach ($this->getComments() as $comments) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[comments] => ' . $comments . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[comments] => NULL<br />';
		}
		$string .= '[counter] => ' . $this->getCounter() . '<br />';
		$string .= '[description] => ' . $this->getDescription() . '<br />';
		if ($this->getEventDate() != null) {
			$string .= '[eventDate] => ' . $this->getEventDate()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[eventDate] => NULL<br />';
		}
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
		if ($this->getImage() != null) {
			$string .= '[image] => ' . $this->getImage() . '<br />';
		} else {
			$string .= '[image] => NULL<br />';
		}
		# TODO
		# $string .= '[imageFile] => ' . $this->getImageFile() . '<br />';
		if ($this->getInvited() != 0) {
			foreach ($this->getInvited() as $invited) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[invited] => ' . $invited . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[invited] => NULL<br />';
		}
		if (($geopoint = $this->getLocation()) != null) {
			$string .= '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
		} else {
			$string .= '[location] => NULL<br />';
		}
		$string .= '[locationName] => ' . $this->getLocationName() . '<br />';
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
		if ($this->getRefused() != 0) {
			foreach ($this->getRefused() as $refused) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[refused] => ' . $refused . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[refused] => NULL<br />';
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
