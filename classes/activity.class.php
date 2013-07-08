<?php
/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Playslist
 *  \details	Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:activity">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:activity">API</a>
 */

class Activity {

	private $objectId;
	private $accepted;
	private $active;
	private $album;
	private $comment;
	private $event;
	private $fromUser;
	private $image;
	private $playlist;
	private $question;
	private $read;
	private $record;
	private $song;
	private $status;
	private $toUser;
	private $type;
	private $userStatus;
	private $video;
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
	 * \fn		BOOL getAccepted()
	 * \brief	Return the accepted value
	 * \return	BOOL
	 */
	public function getAccepted() {
		return $this->accepted;
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
	 * \brief	Return the string value objectId to parseAlbum
	 * \return	BOOL
	 */
	public function getAlbum() {
		return $this->album;
	}

	/**
	 * \fn		string getComment()
	 * \brief	Return the related comment objectId
	 * \return	string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * \fn		string getEvent()
	 * \brief	Return the related event objectId
	 * \return	string
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * \fn		string getFromUser()
	 * \brief	Return the related fromUser objectId
	 * \return	string
	 */
	public function getFromUser() {
		return $this->fromUser;
	}

	/**
	 * \fn		string getImage()
	 * \brief	Return the related image objectId
	 * \return	string
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * \fn		string getPlaylist()
	 * \brief	Return the related playlist objectId
	 * \return	string
	 */
	public function getPlaylist() {
		return $this->playlist;
	}

	/**
	 * \fn		string getQuestion()
	 * \brief	Return the related question objectId
	 * \return	string
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * \fn		BOOL getRead()
	 * \brief	Return the read value, used for notification
	 * \return	BOOL
	 */
	public function getRead() {
		return $this->read;
	}

	/**
	 * \fn		string getRecord()
	 * \brief	Return the record value objectId
	 * \return	string
	 */
	public function getRecord() {
		return $this->record;
	}

	/**
	 * \fn		string getSong()
	 * \brief	Return the song value objectId
	 * \return	string
	 */
	public function getSong() {
		return $this->song;
	}

		/**
	 * \fn		string getStatus()
	 * \brief	Return the status value, P for pending, A for accepted and R for refused
	 * \return	string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * \fn		string getToUser()
	 * \brief	Return the toUser value, objectId
	 * \return	string
	 */
	public function getToUser() {
		return $this->toUser;
	}

	/**
	 * \fn		string getType()
	 * \brief	Return the type value
	 * \return	string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * \fn		string getUserStatus()
	 * \brief	Return the userStatus value,objectId
	 * \return	string
	 */
	public function getUserStatus() {
		return $this->userStatus;
	}

	/**
	 * \fn		string getVideo()
	 * \brief	Return the video value objectId
	 * \return	string
	 */
	public function getVideo() {
		return $this->video;
	}

	/**
	 * \fn		DateTime getCreatedAt()
	 * \brief	Return the Activity creation date
	 * \return	DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * \fn		DateTime getUpdatedAt()
	 * \brief	Return the Activity modification date
	 * \return	DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * \fn		parseACL getACL()
	 * \brief	Return the parseACL object representing the Activity ACL 
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
	 * \fn		void setAccepted($accepted)
	 * \brief	Sets the accepted value
	 * \param	BOOL
	 */
	public function setAccepted($accepted) {
		$this->accepted = $accepted;
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
	 * \brief	Sets the album objectId value
	 * \param	string
	 */
	public function setAlbum($album) {
		$this->album = $album;
	}

	/**
	 * \fn		void setComment($comment)
	 * \brief	Sets the comment value, objectId
	 * \param	string
	 */
	public function setComment($comment) {
		$this->comment = $comment;
	}

	/**
	 * \fn		void setEvent($event)
	 * \brief	Sets the event objectId value
	 * \param	string
	 */
	public function setEvent($event) {
		$this->event = $event;
	}

	/**
	 * \fn		void setFromUser($fromUser)
	 * \brief	Sets the fromUser objectId value
	 * \param	string
	 */
	public function setFromUser($fromUser) {
		$this->fromUser = $fromUser;
	}

	/**
	 * \fn		void setImage($image)
	 * \brief	Sets the image objectId value
	 * \param	string
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * \fn		void setPlaylist($playlist)
	 * \brief	Sets the playlist objectId value
	 * \param	string
	 */
	public function setPlaylist($playlist) {
		$this->playlist = $playlist;
	}

	/**
	 * \fn		void setQuestion($question)
	 * \brief	Sets the question objectId value
	 * \param	string
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}

	/**
	 * \fn		void setRead($read)
	 * \brief	Sets the read value
	 * \param	BOOL
	 */
	public function setRead($read) {
		$this->read = $read;
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
	 * \fn		void setSong($song)
	 * \brief	Sets the song objectId value
	 * \param	string
	 */
	public function setSong($song) {
		$this->song = $song;
	}

	/**
	 * \fn		void setStatus($status)
	 * \brief	Sets the status value, P for pending, A for accepted and R for refused
	 * \param	string
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * \fn		void setToUser($toUser)
	 * \brief	Sets the toUser objectId value
	 * \param	string
	 */
	public function setToUser($toUser) {
		$this->toUser = $toUser;
	}

	/**
	 * \fn		void setType($type)
	 * \brief	Sets the type objectId value
	 * \param	string
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * \fn		void setUserStatus($userStatus)
	 * \brief	Sets the userStatus objectId value
	 * \param	string
	 */
	public function setUserStatus($userStatus) {
		$this->userStatus = $userStatus;
	}

	/**
	 * \fn		void setVideo($video)
	 * \brief	Sets the video objectId value
	 * \param	string
	 */
	public function setVideo($video) {
		$this->video = $video;
	}

	/**
	 * \fn		void setCreatedAt($createdAt)
	 * \brief	Sets the Activity creation date
	 * \param	DateTime
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}

	/**
	 * \fn		void setUpdatedAt($updatedAt)
	 * \brief	Sets the Activity modification date
	 * \param	DateTime
	 */
	public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
	}

	/**
	 * \fn		void setACL($ACL)
	 * \brief	Sets the parseACL object representing the Activity ACL
	 * \param	parseACL
	 */
	public function setACL($ACL) {
	$this->ACL = $ACL;
	}

	/**
	 * \fn		string __toString()
	 * \brief	Return a printable string representing the Activity object
	 * \return	string
	 */
	public function __toString() {
		$string = '';
		$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
		if (is_null($this->getAccepted())) {
			$string .= '[accepted] => NULL<br />';
		} else {
			$this->getAccepted() ? $string .= '[accepted] => 1<br />' : $string .= '[accepted] => 0<br />';
		}
		if (is_null($this->getActive())) {
			$string .= '[active] => NULL<br />';
		} else {
			$this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
		}
		if ($this->getAlbum() != null) {
			$string .= '[album] => ' . $this->getAlbum() . '<br />';
		} else {
			$string .= '[album] => NULL<br />';
		}
		if ($this->getComment() != null) {
			$string .= '[comment] => ' . $this->getComment() . '<br />';
		} else {
			$string .= '[comment] => NULL<br />';
		}
		if ($this->getEvent() != null) {
			$string .= '[event] => ' . $this->getEvent() . '<br />';
		} else {
			$string .= '[event] => NULL<br />';
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
		if ($this->getPlaylist() != null) {
			$string .= '[playlist] => ' . $this->getPlaylist() . '<br />';
		} else {
			$string .= '[playlist] => NULL<br />';
		}
		if ($this->getQuestion() != null) {
			$string .= '[question] => ' . $this->getQuestion() . '<br />';
		} else {
			$string .= '[question] => NULL<br />';
		}
		if (is_null($this->getRead())) {
			$string .= '[read] => NULL<br />';
		} else {
			$this->getRead() ? $string .= '[read] => 1<br />' : $string .= '[read] => 0<br />';
		}
		if ($this->getRecord() != null) {
			$string .= '[record] => ' . $this->getRecord() . '<br />';
		} else {
			$string .= '[record] => NULL<br />';
		}
		if ($this->getSong() != null) {
			$string .= '[song] => ' . $this->getSong() . '<br />';
		} else {
			$string .= '[song] => NULL<br />';
		}
		$string .= '[status] => ' . $this->getStatus() . '<br />';
		if ($this->getToUser() != null) {
			$string .= '[toUser] => ' . $this->getToUser() . '<br />';
		} else {
			$string .= '[toUser] => NULL<br />';
		}
		$string .= '[type] => ' . $this->getType() . '<br />';
		if ($this->getUserStatus() != null) {
			$string .= '[userStatus] => ' . $this->getUserStatus() . '<br />';
		} else {
			$string .= '[userStatus] => NULL<br />';
		}
		if ($this->getVideo() != null) {
			$string .= '[video] => ' . $this->getVideo() . '<br />';
		} else {
			$string .= '[video] => NULL<br />';
		}
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
