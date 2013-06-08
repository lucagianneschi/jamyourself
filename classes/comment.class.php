<?php
/*! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Comment 
 *  \details   Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:comment">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:comment">API</a>
 */

define('CLASS_DIR', './');
include_once CLASS_DIR.'geoPointParse.class.php';
include_once CLASS_DIR.'pointerParse.class.php';

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
		$pointerParse = new PointerParse($this->event['className'], $this->event['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->event;
	}
	
	public function getFromUser() {	
		return $this->fromUser;
	}
	
	public function getImage() {
		$pointerParse = new PointerParse($this->image['className'], $this->image['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->image;
	}
	
	public function getLocation() {
		$geoPointParse = new geoPointParse($this->location['latitude'], $this->location['longitude']);
		return $geoPointParse->getGeoPoint();
	}
	
	public function getOpinions() {	
		return $this->opinions;
	}
	
	public function getPhotoAlbum() {	
		$pointerParse = new PointerParse($this->photoAlbum['className'], $this->photoAlbum['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->photoAlbum;
	}
	
	public function getRecord() {	
		$pointerParse = new PointerParse($this->record['className'], $this->record['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->record;
	}
	
	public function getSong() {	
		$pointerParse = new PointerParse($this->song['className'], $this->song['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->song;
	}
	
	public function getTag() {	
		return $this->tag;
	}
	
	public function getText() {	
		return $this->text;
	}
	
	public function getToUser() {	
		$pointerParse = new PointerParse($this->toUser['className'], $this->toUser['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->toUser;
	}
	
	public function getType() {	
		return $this->type;
	}
	
	public function getUser() {	
		$pointerParse = new PointerParse($this->user['className'], $this->user['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->user;
	}
	
	public function getVideo() {	
		$pointerParse = new PointerParse($this->video['className'], $this->video['objectId']);
		return $pointerParse->isNullPointer() ? NULL : $this->video;
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
	
	public function setFromUser(User $fromUser) {	
		$this->fromUser = $fromUser;
	}
	
	public function setImage(Image $image) {	
		$this->image = $image;
	}
	
	public function setLocation($location) {
		$geoPointParse = new geoPointParse($location['latitude'], $location['longitude']);
		$this->location = $geoPointParse->getGeoPoint();
	}
	
	public function setOpinions($opinions) {	
		$this->opinions = $opinions;
	}
	
	public function setPhotoAlbum(Album $photoAlbum) {	
		$this->photoAlbum = $photoAlbum;
	}
	
	public function setRecord(Record $record) {	
		$this->record = $record;
	}
	
	public function setSong(Song $song) {	
		$this->song = $song;
	}
	
	public function setTag($tag) {	
		$this->tag = $tag;
	}
	
	public function setText($text) {	
		$this->text = $text;
	}
	
	public function setToUser(User $toUser) {	
		$this->toUser = $toUser;
	}
	
	public function setType($type) {	
		$this->type = $type;
	}
	
	public function setUser(User $user) {	
		$this->user = $user;
	}
	
	public function setVideo(Video $video) {	
		$this->video = $video;
	}
	
	public function setVote($vote) {	
		$this->vote = $vote;
	}
	
	public function setCreatedAt(DateTime $createdAt) {
		$this->createdAt = $createdAt;
	}
	
	public function setUpdatedAt(DateTime $updatedAt) {
		$this->updatedAt = $updatedAt;
	}
	
	public function setACL(parseACL $ACL) {
		$this->ACL = $ACL;
	}
	
}

?>