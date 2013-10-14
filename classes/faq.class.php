<?php
/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		geoPointParse
 *  \details	Classe che serve per accogliere latitudine e longitudine di un 
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 * <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:faq">Descrizione della classe</a>
 * <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:faq">API</a>
 */

class Faq {

	private $objectId;
	private $answer;
	private $area;
	private $lang;
	private $position;
	private $question;
	private $tags;
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
	 * \fn		string getAnswer()
	 * \brief	Return the answer value
	 * \return	string
	 */
	public function getAnswer() {
		return $this->answer;
	}

	/**
	 * \fn		string getArea()
	 * \brief	Return the area value
	 * \return	string
	 */
	public function getArea() {
		return $this->area;
	}
	
	/**
	 * \fn		string getLang()
	 * \brief	Return the language (lang) value
	 * \return	string
	 */
	public function getLang() {
		return $this->lang;
	}

	/**
	 * \fn		string getPosition()
	 * \brief	Return the position value (for ordering)
	 * \return	string
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * \fn		string getQuestion()
	 * \brief	Return the question value
	 * \return	string
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * \fn		array getTags()
	 * \brief	Return the tags value, array to categorize the Faq
	 * \return	array
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * \fn		DateTime getCreatedAt()
	 * \brief	Return the FAQ creation date
	 * \return	DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * \fn		DateTime getUpdatedAt()
	 * \brief	Return the FAQ modification date
	 * \return	DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * \fn		parseACL getACL()
	 * \brief	Return the parseACL object representing the FAQ ACL 
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
	 * \fn		void setAnswer($answer)
	 * \brief	Sets the answer value
	 * \param	string
	 */
	public function setAnswer($answer) {
		$this->answer = $answer;
	}

	/**
	 * \fn		void setArea($area)
	 * \brief	Sets the area value
	 * \param	string
	 */
	public function setArea($area) {
		$this->area = $area;
	}
	
	/**
	 * \fn		void setLang($lang)
	 * \brief	Sets the lang value
	 * \param	string
	 */
	public function setLang($lang) {
		$this->lang = $lang;
	}

	/**
	 * \fn		void setPosition($position)
	 * \brief	Sets the position value
	 * \param	int
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * \fn		void setQuestion($question)
	 * \brief	Sets the question value
	 * \param	string
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}

	/**
	 * \fn		void setTags($tags)
	 * \brief	Sets the tags value
	 * \param	array
	 */
	public function setTags($tags) {
		$this->tag = $tags;
	}

	/**
	 * \fn		void setCreatedAt($createdAt)
	 * \brief	Sets the FAQ creation date
	 * \param	DateTime
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}

	/**
	 * \fn		void setUpdatedAt($updatedAt)
	 * \brief	Sets the FAQ modification date
	 * \param	DateTime
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}

	/**
	 * \fn		void setACL($ACL)
	 * \brief	Sets the parseACL object representing the FAQ ACL
	 * \param	parseACL
	 */
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}

	/**
	 * \fn		string __toString()
	 * \brief	Return a printable string representing the FAQ object
	 * \return	string
	 */
	public function __toString() {
		$string = '';
		$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
		$string .= '[answer] => ' . $this->getAnswer() . '<br />';
		$string .= '[area] => ' . $this->getArea() . '<br />';
		$string .= '[lang] => ' . $this->getLang() . '<br />';
		$string .= '[position] => ' . $this->getPosition() . '<br />';
		$string .= '[question] => ' . $this->getQuestion() . '<br />';
		if (count($this->getTags()) != 0) {
			foreach ($this->getTags() as $tag) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[tag] => ' . $tag . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[tags] => NULL<br />';
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