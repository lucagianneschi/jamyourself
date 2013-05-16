<?php

define('CLASS_DIR', './');
include_once CLASS_DIR.'geoPointParse.class.php';

class Comment {
	
	private $objectId;
	private $active;
	private $counter;
	private $event;
	private $fromUser;
	private $image;
	private $location;
	private $opinions;
	private $photoAlbum;
	private $record;
	private $song;
	private $tag;
	private $text;
	private $toUser;
	private $type;
	private $user;
	private $video;
	private $vote;
	private $createdAt;
	private $updatedAt;
	private $ACL;
	
	public function getObjectId() {
		return $this->objectId;
	}
	
	public function getActive() {
		return $this->active;
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
	
	public function getImage() {	
		return $this->immagine;
	}
	
	public function getLocation() {
		$geoPointParse = new geoPointParse($this->location['latitude'], $this->location['longitude']);
		return $geoPointParse->getGeoPoint();
	}
	
	public function getOpinions() {	
		return $this->opinions;
	}
	
	public function getPhotoAlbum() {	
		return $this->photoAlbum;
	}
	
	public function getRecord() {	
		return $this->record;
	}
	
	public function getSong() {	
		return $this->song;
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
	
	public function getACL() {
		return $this->ACL;
	}
	
	public function printComment() {
		echo '[objectId] => ' . $this->getObjectId() . '<br />';
		echo '[active] => ' . $this->getActive() . '<br />';
		echo '[counter] => ' . $this->getCounter() . '<br />';
		$ev = $this->getEvent();
		echo '[event] => ' . $ev['className'] . ' -> ' . $ev['objectId'] . '<br/>';
		$fu = $this->getFromUser();
		echo '[fromUser] => ' . $fu['className'] . ' -> ' . $fu['objectId'] . '<br/>';
		$im = $this->getImage();
		echo '[image] => ' . $im['className'] . ' -> ' . $im['objectId'] . '<br/>';
		$geoCoding = $this->getLocation();
		echo '[location] => ' . $geoCoding['latitude'] . ', ' . $geoCoding['longitude'] . '<br />';
		foreach ($this->getOpinions() as $op) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[opinions] => ' . $opinion . '<br />';
		}
		$pa = $this->getPhotoAlbum();
		echo '[photoAlbum] => ' . $pa['className'] . ' -> ' . $pa['objectId'] . '<br/>';
		$re = $this->getRecord();
		echo '[record] => ' . $re['className'] . ' -> ' . $re['objectId'] . '<br/>';
		$so = $this->getSong();
		echo '[song] => ' . $so['className'] . ' -> ' . $so['objectId'] . '<br/>';
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
		echo '[ACL] => ' . $this->getACL() . '<br />';
	}
	
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}
	
	public function setActive($active) {
		$this->active = $active;
	}
	
	public function setCounter($counter) {	
		$this->counter = $counter;
	}
	
	public function setEvent($event) {	
		$this->event = $event;
	}
	
	public function setFromUser($fromUser) {	
		$this->fromUser = $fromUser;
	}
	
	public function setImage($image) {	
		$this->image = $image;
	}
	
	public function setLocation($location) {
		$geoPointParse = new geoPointParse($location['latitude'], $location['longitude']);
		$this->location = $geoPointParse->getGeoPoint();
	}
	
	public function setOpinions($opinions) {	
		$this->opinions = $opinions;
	}
	
	public function setPhotoAlbum($photoAlbum) {	
		$this->photoAlbum = $photoAlbum;
	}
	
	public function setRecord($record) {	
		$this->record = $record;
	}
	
	public function setSong($song) {	
		$this->song = $song;
	}
	
	public function setTag($tag) {	
		$this->tag = $tag;
	}
	
	public function setText($text) {	
		$this->text = $text;
	}
	
	public function setToUser($toUser) {	
		$this->toUser = $toUser;
	}
	
	public function setType($type) {	
		$this->type = $type;
	}
	
	public function setUser($user) {	
		$this->user = $user;
	}
	
	public function setVideo($video) {	
		$this->video = $video;
	}
	
	public function setVote($vote) {	
		$this->vote = $vote;
	}
	
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}
	
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}
	
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}
	
}

?>