<?php

define('CLASS_DIR', './');
include_once CLASS_DIR.'geoPointParse.class.php';

class Comment {
	
	private $objectId;
	private $active;
	private $albumBrano;
	private $albumImmagine;
	private $brano;
	private $counter;
	private $event;
	private $fromUser;
	private $immagine;
	private $location;
	private $opinions;
	private $tag;
	private $text;
	private $toUser;
	private $type;
	private $user;
	private $video;
	private $vote;
	private $createdAt;
	private $updatedAt;
	//private $ACL;
	
	public function getObjectId() {
		return $this->objectId;
	}
	
	public function getActive() {
		return $this->active;
	}
	
	public function getAlbumBrano() {
		return $this->albumBrano;
	}
	
	public function getAlbumImmagine() {	
		return $this->albumImmagine;
	}
	
	public function getBrano() {	
		return $this->brano;
	}
	
	public function getCounter() {	
		return $this->counter;
	}
	
	public function getEvent() {	
		return $this->event;
	}
	
	public function getFromUser() {	
		return $this->fromUser;
	}
	
	public function getImmagine() {	
		return $this->immagine;
	}
	
	public function getLocation() {
		$geoPointParse = new geoPointParse($this->location['latitude'], $this->location['longitude']);
		return $geoPointParse->getGeoPoint();
	}
	
	public function getOpinions() {	
		return $this->opinions;
	}
	
	public function getTag() {	
		return $this->tag;
	}
	
	public function getText() {	
		return $this->text;
	}
	
	public function getToUser() {	
		return $this->toUser;
	}
	
	public function getType() {	
		return $this->type;
	}
	
	public function getUser() {	
		return $this->user;
	}
	
	public function getVideo() {	
		return $this->video;
	}
	
	public function getVote() {	
		return $this->vote;
	}
	
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	public function printComment() {
		echo '[objectId] => ' . $this->getObjectId() . '<br />';
		echo '[active] => ' . $this->getActive() . '<br />';
		$ab = $this->getAlbumBrano();
		echo '[albumBrano] => ' . $ab['className'] . ' -> ' . $ab['objectId'] . '<br/>';
		$ai = $this->getAlbumImmagine();
		echo '[albumImmagine] => ' . $ai['className'] . ' -> ' . $ai['objectId'] . '<br/>';
		$br = $this->getBrano();
		echo '[brano] => ' . $br['className'] . ' -> ' . $br['objectId'] . '<br/>';
		echo '[counter] => ' . $this->getCounter() . '<br />';
		$ev = $this->getEvent();
		echo '[event] => ' . $ev['className'] . ' -> ' . $ev['objectId'] . '<br/>';
		$fu = $this->getFromUser();
		echo '[fromUser] => ' . $fu['className'] . ' -> ' . $fu['objectId'] . '<br/>';
		$im = $this->getImmagine();
		echo '[immagine] => ' . $im['className'] . ' -> ' . $im['objectId'] . '<br/>';
		
		$geoCoding = $this->getLocation();
		echo '[location] => ' . $geoCoding['latitude'] . ', ' . 
								$geoCoding['longitude'] . '<br />';
								 
		foreach ($this->getOpinions() as $op) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[opinions] => ' . $opinion . '<br />';
		}
		foreach ($this->getTag() as $tg) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[tag] => ' . $tg . '<br />';
		}
		echo '[text] => ' . $this->getText() . '<br />';
		$tu = $this->getToUser();
		echo '[toUser] => ' . $tu['className'] . ' -> ' . $tu['objectId'] . '<br/>';
		echo '[type] => ' . $this->getType() . '<br />';
		$us = $this->getUser();
		echo '[user] => ' . $us['className'] . ' -> ' . $us['objectId'] . '<br/>';
		$vi = $this->getVideo();
		echo '[video] => ' . $vi['className'] . ' -> ' . $vi['objectId'] . '<br/>';
		echo '[vote] => ' . $this->getVote() . '<br />';
		echo '[createdAt] => ' . $this->getCreatedAt() . '<br />';
		echo '[updatedAt] => ' . $this->getUpdatedAt() . '<br />';
	}
	
	public function setObjectId($value) {
		$this->objectId = $value;
	}
	
	public function setActive($value) {
		$this->active = $value;
	}
	
	public function setAlbumBrano($value) {
		$this->albumBrano = $value;
	}
	
	public function setAlbumImmagine($value) {
		$this->albumImmagine = $value;
	}
	
	public function setBrano($value) {	
		$this->brano = $value;
	}
	
	public function setCounter($value) {	
		$this->counter = $value;
	}
	
	public function setEvent($value) {	
		$this->event = $value;
	}
	
	public function setFromUser($value) {	
		$this->fromUser = $value;
	}
	
	public function setImmagine($value) {	
		$this->immagine = $value;
	}
	
	public function setLocation($value) {
		$geoPointParse = new geoPointParse($value['latitude'], $value['longitude']);
		$this->location = $geoPointParse->getGeoPoint();
	}
	
	public function setOpinions($value) {	
		$this->opinions = $value;
	}
	
	public function setTag($value) {	
		$this->tag = $value;
	}
	
	public function setText($value) {	
		$this->text = $value;
	}
	
	public function setToUser($value) {	
		$this->toUser = $value;
	}
	
	public function setType($value) {	
		$this->type = $value;
	}
	
	public function setUser($value) {	
		$this->user = $value;
	}
	
	public function setVideo($value) {	
		$this->video = $value;
	}
	
	public function setVote($value) {	
		$this->vote = $value;
	}
	
	public function setCreatedAt($value) {
		$this->createdAt = $value;
	}
	
	public function setUpdatedAt($value) {
		$this->updatedAt = $value;
	}
	
}

?>