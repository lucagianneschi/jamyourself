<?php

define('CLASS_DIR', '../classes/');
include_once CLASS_DIR.'geoPointParse.class.php';

class event {
	
	private $objectId;
	private $attendee;				//Array di utenti che partecipano all'evento
	private $author;				//id user che ha effettuato l'evento: obbligatorio			
	private $counter;				//contatore per il gradimento dell'utente
	private $description;			//descrizione dell'evento: inserito da utente - obbligatorio
	private $eventDate;				//data di quando sara' l'evento: inserito da utente - obbligatorio
	private $featuring; 			//elenco di utente presenti all'evento: inserito da utente - obbligatorio
	private $invited;				//array di utenti invitati all'evento
	private $location;				//luogo in cui si svolge l'evento: inserito da utente - obbligatorio 
	private $locationName;			//nome del locale dove si svolge l'evento: inserito da utente - obbligatorio 
	private $photo;					//locandina evento: inserito da utente - opzionale 
	private $refused;				//array di utenti che non partecipano all'evento
	private $tag; 					//categorizzazione dell'evento: inserito da utente - opzionale
	private $thumbnail; 			//thumbnail della locandina: opzionale
	private $title;					//titolo dell'evento: inserito da utente - obbligatorio
	private $createdAt;
	private $updatedAt;
	private $ACL;		
	
	public function getObjectId() {
		return $this->objectId;
	}

	public function getAttendee() {
		return $this->attendee;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getCounter() {
		return $this->counter;
	}
	
	public function getDescription() {
		return $this->description;
	}

	public function getEventDate() {
		return $this->eventDate;
	}
	
	public function getFeaturing() {
		return $this->featuring;
	}

	public function getInvited() {
		return $this->invited;
	}
	
	public function getLocation() {
		return $this->location;
	//	$geoPointParse = new geoPointParse($this->location['latitude'], $this->location['longitude']);
	//	return $geoPointParse->getGeoPoint();
	}
	
	public function getLocationName() {
		return $this->locationName;
	}
	
	public function getPhoto() {
		return $this->photo;
	}
	
	public function getRefused() {
		return $this->refused;
	}

	public function getTag() {
		return $this->tag;
	}
	
	public function getThumbnail() {
		return $this->thumbnail;
	}
	
	public function getTitle() {
		return $this->title;
	}

	public function getCreatedAt() {
		return $this->createdAt;
	}	

	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	public function getACL(){
		return $this->ACL;
	}
	
	public function printEvent() {
		echo '[objectId] => ' . $this->getObjectId() . '<br />';
		foreach ($this->getAttendee() as $at) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[attendee] => ' . $at . '<br />';
		}
		$au = $this->getAuthor();
		echo '[author] => ' . $au['className'] . ' -> ' . $au['objectId'] . '<br/>';
		echo '[counter] => ' . $this->getCounter() . '<br />';
		echo '[description] => ' . $this->getDescription() . '<br />';
	    echo '[eventDate] => ' . $this->getEventDate()->format('d-M-Y H:i:s') . '<br />';
		foreach ($this->getFeaturing() as $fe) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[featuring] => ' . $fe . '<br />';
		}
	    foreach ($this->getInvited() as $in) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[invited] => ' . $in . '<br />';
		}
		$geoCoding = $this->getLocation();
		echo '[location] => ' . $geoCoding['latitude'] . ', ' . 
								$geoCoding['longitude'] . '<br />';
	    echo '[locationName] => ' . $this->getLocationName() . '<br />';
	    echo '[photo] => ' . $this->getPhoto() . '<br />';			
	    foreach ($this->getRefused() as $re) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[refused] => ' . $re . '<br />';
		}
		foreach ($this->getTag() as $ta) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[tag] => ' . $ta . '<br />';
		}
	    echo '[thumbnail] => ' . $this->getThumbnail() . '<br />'; 	
	    echo '[title] => ' . $this->getTitle() . '<br />';			
	    echo '[createdAt] => ' . $this->getCreatedAt() . '<br />';
	    echo '[updatedAt] => ' . $this->getUpdatedAt() . '<br />';
	    echo '[ACL] => ' . $this->getACL() . '<br />';
	}

    public function setObjectId($value) {
		$this->objectId = $value;
	}
	
	public function setAttendee($value) {
		$this->attendee = $value;
	}

	public function setAuthor($value) {
		$this->author = $value;
		
		
	}
	
	public function setCounter($value) {
		$this->counter = $value;
	}

	public function setDescription($value) {
		$this->description = $value;
	}

	public function setEventDate($value) {
		$this->eventDate = $value;
	}

	public function setFeaturing($value) {
		$this->featuring = $value;
	}

	public function setInvited($value) {
		$this->invited = $value;
	}

	public function setLocation($value) {
		//$geoPointParse = new geoPointParse($value['latitude'], $value['longitude']);
		//$this->location = $geoPointParse->getGeoPoint();
		$this->location = $value;
	}
	
	public function setLocationName($value) {
		$this->locationName = $value;
	}
	
	public function setPhoto($value) {
		$this->photo = $value;
	}
	
	public function setRefused($value) {
		$this->refused = $value;
	}
	
	public function setTag($value) {
		$this->tag = $value;
	}

	public function setThumbnail($value) {
		$this->thumbnail = $value;
	}
	
	public function setTitle($value) {
		$this->title = $value;
	}
	
	public function setCreatedAt($value) {
		$this->createdAt = $value;
	}	

	public function setUpdatedAt($value) {
		$this->updatedAt = $value;
	}
	
	public function setACL($value){
		$this->ACL = $value;
	}

}
?>