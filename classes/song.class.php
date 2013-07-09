<?php
/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Song Class
 *  \details	Classe dedicata al singolo brano, pu� essere istanziata solo da Jammer
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:song">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:song">API</a>
 */

class Song {

	private $objectId;
	private $active;
	private $commentCounter;
	private $commentators;
	private $comments;
	private $counter;
	private $duration;
	private $featuring;
	private $filePath;
	private $fromUser;
	private $genre;
	private $location;
	private $loveCounter;
	private $lovers;
	private $record;
	private $shareCounter;
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
	 * \fn		BOOL getObjectId()
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
	 * \fn		array getCommentators()
	 * \brief	Return the commentators value,array of objectId of istance of the _User class who commented the song
	 * \return	array
	 */
	public function getCommentators() {
		return $this->commentators;
	}

	/**
	 * \fn		array getComments()
	 * \brief	Return the comments value,array of objectId of istance of the Comment class, comments on song
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
	 * \fn		int getDuration()
	 * \brief	Return the duration value in second
	 * \return	int
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * \fn		array getFeaturing()
	 * \brief	Return the featuring value,array of objectId of istance of the _User class who feat the song
	 * \return	array
	 */
	public function getFeaturing() {
		return $this->featuring;
	}

	/**
	 * \fn		string getFilePath()
	 * \brief	Return the filePath value,path of the mp3 file
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
	 * \fn		string getGenre()
	 * \brief	Return the genre value 
	 * \return	string
	 */
	public function getGenre() {
		return $this->genre;
	}

	/**
	 * \fn		parseGoPoint getLocation()
	 * \brief	Return the location value 
	 * \return	parseGoPoint
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * \fn		int getLoveCounter()
	 * \brief	Return the loveCounter value, number of users who love the song
	 * \return	int
	 */
	public function getLoveCounter() {
		return $this->loveCounter;
	}

	/**
	 * \fn		array getLovers()
	 * \brief	Return the lovers value,array of objectId of istance of the _User class who love the song
	 * \return	array
	 */
	public function getLovers() {
		return $this->lovers;
	}

	/**
	 * \fn		string getRecord()
	 * \brief	Return the record value,string of the objectId of the related record
	 * \return	string
	 */
	public function getRecord() {
		return $this->record;
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
	 * \fn		string getTitle()
	 * \brief	Return the title value
	 * \return	string
	 */
	public function getTitle() {
		return $this->title;
	}

		/**
	 * \fn		DateTime getCreatedAt()
	 * \brief	Return the Song creation date
	 * \return	DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * \fn		DateTime getUpdatedAt()
	 * \brief	Return the Song modification date
	 * \return	DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * \fn		parseACL getACL()
	 * \brief	Return the parseACL object representing the Song ACL 
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
	 * \brief	Sets the active  value
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
		$this->counter = $commentCounter;
	}
	
	/**
	 * \fn		void setCommentators($commentators)
	 * \brief	Sets the commentators  value
	 * \param	array
	 */
	public function setCommentators($commentators) {
		$this->commentators = $commentators;
	}

	/**
	 * \fn		void setComments($comments)
	 * \brief	Sets the comments  value
	 * \param	array
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}

	/**
	 * \fn		void setCounter($counter)
	 * \brief	Sets the counter  value
	 * \param	int
	 */
	public function setCounter($counter) {
		$this->counter = $counter;
	}

	/**
	 * \fn		void setDuration($duration)
	 * \brief	Sets the duration value
	 * \param	int
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
	}

	/**
	 * \fn		void setFeaturing($featuring)
	 * \brief	Sets the featuring  value
	 * \param	array
	 */
	public function setFeaturing($featuring) {
		$this->featuring = $featuring;
	}

	/**
	 * \fn		void setFilePath($filePath)
	 * \brief	Sets the filePath  value
	 * \param	string
	 */
	public function setFilePath($filePath) {
		$this->filePath = $filePath;
	}

	/**
	 * \fn		void setFromUser($fromUser)
	 * \brief	Sets the fromUser objectId  value
	 * \param	string
	 */
	public function setFromUser($fromUser) {
		$this->fromUser = $fromUser;
	}

	/**
	 * \fn		void setGenre($genre) 
	 * \brief	Sets the genre value
	 * \param	string
	 */
	public function setGenre($genre) {
		$this->genre = $genre;
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
	 * \fn		void setLovers($lovers)
	 * \brief	Sets the lovers  value
	 * \param	array
	 */
	public function setLovers($lovers) {
		$this->lovers = $lovers;
	}

	/**
	 * \fn		void setLoveCounter($loveCounter)
	 * \brief	Sets the LoveCounter  value
	 * \param	int
	 */
	public function setLoveCounter($loveCounter) {
		$this->loveCounter = $loveCounter;
	}

	/**
	 * \fn		void setRecord($record) 
	 * \brief	Sets the record objectId value
	 * \param	string
	 */
	public function setRecord($record) {
		$this->record = $record;
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
	 * \fn		void setTitle($title) 
	 * \brief	Sets the title value
	 * \param	string
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * \fn		void setCreatedAt($createdAt)
	 * \brief	Sets the Song creation date
	 * \param	DateTime
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}

	/**
	 * \fn		void setUpdatedAt($updatedAt)
	 * \brief	Sets the Song modification date
	 * \param	DateTime
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}

	/**
	 * \fn		void setACL($ACL)
	 * \brief	Sets the parseACL object representing the Song ACL
	 * \param	parseACL
	 */
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}

	/**
	 * \fn		string __toString()
	 * \brief	Return a printable string representing the Song object
	 * \return	string
	 */
	public function __toString() {
		$string = '';
		$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
		$string .= '[active] => ' . $this->getActive() . '<br />';
		$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
		if ($this->getCommentators() != null && count($this->getCommentators() > 0)) {
			foreach ($this->getCommentators() as $commentator) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[commentator] => ' . $commentator . '<br />';
			}
		}
		if ($this->getComments() != null && count($this->getComments() > 0)) {
			foreach ($this->getComments() as $comment) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[comment] => ' . $comment . '<br />';
			}
		}
		$string .= '[counter] => ' . $this->getCounter() . '<br />';
		$string .= '[duration] => ' . $this->getDuration() . '<br />';
		if ($this->getFeaturing() != null && count($this->getFeaturing() > 0)) {
			foreach ($this->getFeaturing() as $user) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[featuring] => ' . $user . '<br />';
			}
		}
		$string.= '[filePath] => ' . $this->getFilePath() . '<br />';
		$fromUser = $this->getFromUser();
		if ($fromUser != null) {
			$string.= '[fromUser] => ' . $fromUser . '<br />';
		}
		$string.= '[genre] => ' . $this->getGenre() . '<br />';
		$parseGeoPoint = $this->getLocation();
		if ($parseGeoPoint->lat != null && $parseGeoPoint->long) {
			$string .= '[location] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';
		}
		$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
		if ($this->getLovers() != null && count($this->getLovers() > 0)) {
			foreach ($this->getLovers() as $lover) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[lover] => ' . $lover . '<br />';
			}
		}
		$record = $this->getRecord();
		if ($record != null) {
			$string .= '[record] => ' . $record . '<br />';
		}
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