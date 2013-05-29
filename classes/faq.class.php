<?php

class Faq {
	
	private $objectId;
	private $answer;
	private $area;
	private $position;
	private $question;
	private $tag;
	private $createdAt;
	private $updatedAt;
	private $ACL;
	
	public function getObjectId() {
		return $this->objectId;
	}
	
	public function getAnswer() {
		return $this->answer;
	}

	public function getArea() {
		return $this->area;
	}

	public function getPosition() {
		return $this->position;
	}
	
	public function getQuestion() {
		return $this->question;
	}
	
	public function getTag() {
		return $this->tag;
	}
	
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	public function getACL() {
		return $this->ACL;
	}
	
	public function printFaq() {
		echo '[objectId] => ' . $this->getObjectId() . '<br />';
		echo '[area] => ' . $this->getArea() . '<br />';
		echo '[answer] => ' . $this->getAnswer() . '<br />';
		echo '[question] => ' . $this->getQuestion() . '<br />';
		echo '[position] => ' . $this->getPosition() . '<br />';
		foreach ($this->getTag() as $tag) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[tag] => ' . $tag . '<br />';
		}
		$dateTime = $this->getCreatedAt();
		echo '[createdAt] => ' . $dateTime->format('Y-m-d H:i:s') . '<br />';
		$dateTime = $this->getUpdatedAt();
		echo '[updatedAt] => ' . $dateTime->format('Y-m-d H:i:s') . '<br />';
		echo '[ACL] => ' . $this->getACL() . '<br />';
	}
	
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}
	
	public function setAnswer($answer) {
		$this->answer = $answer;
	}

	public function setArea($area) {
		$this->area = $area;
	}

	public function setPosition($position) {
		$this->position = $position;
	}
	
	public function setQuestion($question) {
		$this->question = $question;
	}
	
	public function setTag($tag) {
		$this->tag = $tag;
	}
	
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}
	
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}
	
	public function setACL($ACL) {
		return $this->ACL = $ACL;
	}
	
}
?>