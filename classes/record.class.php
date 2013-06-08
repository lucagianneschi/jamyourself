<?php
/*! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Record Class
 *  \details   Classe dedicata ad un album di brani musicali, pu� essere istanziata solo da Jammer
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:record">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:record">API</a>
 */

define('CLASS_DIR', './');
include_once CLASS_DIR.'geoPointParse.class.php';

class Record {
	
	private $objectId;
	private $active;
	private $buyLink;
	private $comments;      //relation: puntatori ad oggetti Comment
	private $counter;
	private $cover;
	private $description;
	private $duration;
	private $featuring;
	private $fromUser;
	private $genre;
	private $label;
	private $location;
	private $loveCounter;
	private $thumbnailCover;
	private $title;
	private $year;
	private $createdAt;
	private $updatedAt;
	private $ACL;

	public function getObjectId() {
		return $this->objectId;
	}

	public function getActive() {
		return $this->active;
	}
	
	public function getBuyLink() {
		return $this->buyLink;
	}

	//relation: puntatori ad oggetti Comment 								
	public function getComments(){
		return $this->comments;
	}

	public function getCounter() {
		return $this->counter;
	}
	
	public function getCover() {
		return $this->cover;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getDuration() {
		return $this->duration;
	}
	
	public function getFeaturing() {
		return $this->featuring;
	}
	
	public function getFromUser() {
		return $this->fromUser;
	}
	
	public function getGenre() {
		return $this->genre;
	}
	
	public function getLabel() {
		return $this->label;
	}
	
	public function getLocation() {
		$geoPointParse = new geoPointParse($this->location['latitude'], $this->location['longitude']);
		return $geoPointParse->getGeoPoint();
	}
	
	public function getLoveCounter() {
		return $this->loveCounter;
	}
	
	public function getThumbnailCover() {
		return $this->thumbnailCover;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getYear() {
		return $this->year;
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
	
	public function printRecord() {
		echo '[objectID] => ' . $this->getObjectID() . '<br />';
		echo '[active] => ' . $this->getActive() . '<br />';
		echo '[buylink] => ' . $this->getBuylink() . '<br />';
		echo '[counter] => ' . $this->getCounter() . '<br />';
		echo '[cover] => ' . $this->getCover() . '<br />';
		echo '[description] => ' . $this->getDescription() . '<br />';
		echo '[duration] => ' . $this->getDuration() . '<br />';
		foreach ($this->getFeaturing() as $fe) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[featuring] => ' . $fe . '<br />';
		}
		$fu = $this->getFromUser();
		echo '[fromUser] => ' . $fu['className'] . ' -> ' . $fu['objectId'] . '<br/>';
		echo '[genre] => ' . $this->getGenre() . '<br />';
		echo '[label] => ' . $this->getLabel() . '<br />';
		$geoCoding = $this->getLocation();
		echo '[location] => ' . $geoCoding['latitude'] . ', ' . 
								$geoCoding['longitude'] . '<br />';
		echo '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
		echo '[thumbnailCover] => ' . $this->getThumbnailCover() . '<br />';
		echo '[title] => ' . $this->getTitle() . '<br />';
		echo '[year] => ' . $this->getYear() . '<br />';
		$dateTime = $this->getCreatedAt();
		echo '[createdAt] => ' . $dateTime->format('Y-m-d H:i:s') . '<br />';
		$dateTime = $this->getUpdatedAt();
		echo '[updatedAt] => ' . $dateTime->format('Y-m-d H:i:s') . '<br />';
		echo '[ACL] => ' . $this->getACL() . '<br />';
	}
	
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}
	
	public function setActive($active) {
		$this->active = $active;
	}
	
	public function setBuyLink($buyLink) {
		$this->buyLink = $buyLink;
	}

	//relation: puntatori ad oggetti Comment
	public function setComments(array $comments){
		$this->comments = $comments;
	}
		
	public function setCounter($counter) {
		$this->counter = $counter;
	}
	
	public function setCover($cover) {
		$this->cover = $cover;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function setDuration($duration) {
		$this->duration = $duration;
	}
	
	public function setFeaturing(array $featuring) {
		$this->featuring = $featuring;
	}
	
	public function setFromUser(User $fromUser) {
		$this->fromUser = $fromUser;
	}
	
	public function setGenre($genre) {
		$this->genre = $genre;
	}
	
	public function setLabel($label) {
		$this->label = $label;
	}
	
	public function setLocation( $location) {
		$geoPointParse = new geoPointParse($location['latitude'], $location['longitude']);
		$this->location = $geoPointParse->getGeoPoint();
	}
	
	public function setLoveCounter($loveCounter) {
		$this->loveCounter = $loveCounter;
	}
	
	public function setThumbnailCover($thumbnailCover) {
		$this->thumbnailCover = $thumbnailCover;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setYear($year) {
		$this->year = $year;
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