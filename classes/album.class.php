<?php
/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Album
 *  \details	Classe raccoglitore per immagini
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:album">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:album">API</a>
 */

class Album {

	private $objectId;
	private $active;
	private $commentators;
	private $comments;
	private $counter;
	private $cover;
	private $coverFile;
	private $description;
	private $featuring;
	private $fromUser;
	private $images;
	private $location;
	private $loveCounter;
	private $lovers;
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
	 * \fn		array getCommentators()
	 * \brief	Return an array of objectId of istances of _User class who commented on the album
	 * \return	array
	 */
	public function getCommentators() {
		return $this->commentators;
	}

	/**
	 * \fn		array getComments()
	 * \brief	Return an array of objectId of istances of the Comment class; comments on album istance
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
	 * \fn		string getCover()
	 * \brief	Return the cover (path file) value
	 * \return	string
	 */
	public function getCover() {
		return $this->cover;
	}

	/**
	 * \fn		parseFile getCoverFile()
	 * \brief	Return the coverFile value
	 * \return	parseFile
	 */
	public function getCoverFile() {
		return $this->coverFile;
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
	 * \fn		void setCover($cover)
	 * \brief	Sets the cover value
	 * \param	string
	 */
	public function setCover($cover) {
		$this->cover = $cover;
	}

	/**
	 * \fn		void setCoverFile($coverFile)
	 * \brief	Sets the coverFile value
	 * \param	parseFile
	 */
	public function setCoverFile($coverFile) {
		$this->coverFile = $coverFile;
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
		if (count($this->getCommentators()) != 0) {
			foreach ($this->getCommentators() as $commentators) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[commentators] => ' . $commentators . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[commentators] => NULL<br />';
		}
		if (count($this->getComments()) != 0) {
			foreach ($this->getComments() as $comments) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[comments] => ' . $comments . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[comments] => NULL<br />';
		}
		$string .= '[counter] => ' . $this->getCounter() . '<br />';
		$string .= '[cover] => ' . $this->getCover() . '<br />';
		# TODO
		# $string .= '[coverFile] => ' . $this->getCoverFile() . '<br />';
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
		if ($this->getImages() != 0) {
			foreach ($this->getImages() as $images) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[images] => ' . $images . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[images] => NULL<br />';
		}
		if ( ($geopoint = $this->getLocation()) != null) {
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