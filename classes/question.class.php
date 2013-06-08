<?php
/*! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Question
 *  \details   Classe dedicata alle domande e alle risposte tra utenti e amministrazione
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:question">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:question">API</a>
 */

class Question {
	
	private $objectId;
	private $answer;
	private $mailFrom;
	private $mailTo;
	private $name;
	private $replied;
	private $subject;
	private $text;
	private $createdAt;
	private $updatedAt;
	private $ACL; //perchè non si setta??
	
	public function getObjectId() {
		return $this->objectId;
	}
	
	public function getAnswer() {
		return $this->answer;
	}
	
	public function getMailFrom() {
		return $this->mailFrom;
	}
	
	public function getMailTo() {
		return $this->mailTo;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getReplied() {
		return $this->replied;
	}
	
	public function getSubject() {
		return $this->subject;
	}
	
	public function getText() {
		return $this->text;
	}
	
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	public function printQuestion() {
		echo '[objectId] => ' . $this->getObjectId() . '<br />';
		echo '[answer] => ' . $this->getAnswer() . '<br />';
		echo '[mailFrom] => ' . $this->getMailFrom() . '<br />';
		echo '[mailTo] => ' . $this->getMailTo() . '<br />';
		echo '[name] => ' . $this->getName() . '<br />';
		echo '[replied] => ' . $this->getReplied() . '<br />';
		echo '[subject] => ' . $this->getSubject() . '<br />';
		echo '[text] => ' . $this->getText() . '<br />';
		echo '[createdAt] => ' . $this->getCreatedAt() . '<br />';
		echo '[updatedAt] => ' . $this->getUpdatedAt() . '<br />';
	}
	
	public function setObjectId($value) {
		$this->objectId = $value;
	}
	
	public function setAnswer($value) {
		$this->answer = $value;
	}
	
	public function setMailFrom($value) {
		$this->mailFrom = $value;
	}
	
	public function setMailTo($value) {
		$this->mailTo = $value;
	}
	
	public function setName($value) {
		$this->name = $value;
	}
	
	public function setReplied($value) {
		$this->replied = $value;
	}
	
	public function setSubject($value) {
		$this->subject = $value;
	}
	
	public function setText($value) {
		$this->text = $value;
	}
	 
	public function setCreatedAt(DateTime $value) {
		$this->createdAt = $value;
	}
	
	public function setUpdatedAt(DateTime $value) {
		return $this->updatedAt = $value;
	}
        
        public function setACL(parseACL $value) {
		return $this->ACL = $value;
	}
}

?>