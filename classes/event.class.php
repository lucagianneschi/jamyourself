<?php

//definizione della classe: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:event
//api:http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:event

define('CLASS_DIR', '../classes/');
include_once CLASS_DIR.'geoPointParse.class.php';

class Event {
	
	private $objectId;              //string: objectId su Parse											#1
	private $fromUser;				//User: User che crea l’evento										#2
    private $title;                 //string: Nome dell’evento											#3
	private $description;			//string: Descrizione breve dell’evento 							#4
    private $eventDate;             //DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento) #5
    private $location;				//GeoPoint: Luogo in cui si svolge l’evento                         #6
    private $locationName;			//string: Nome del locale in cui si svolge l’evento					#7
    private $image;					//string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento #8
    private $thumbnail;				//string: Stringa per il percorso di immagazzinamento della thumbnail #9
    private $featuring;             //array: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano…)  #10
    private $tag;                   //string: Categorizzazione dell’evento 								#11
	private $counter;				//number: counter per votazione dell'evento       					#12
	private $invited;				//array: Array che contiene puntatori ad utenti invitati all'evento  #13
    private $attendee;				//array: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento	#14
    private $refused;				//array: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento #15
	private $active;				//BOOL: attiva/disattiva l'evento									#16
	private $createdAt;				//DataTime: data di registrazione dell'evento						#17
	private $updatedAt;				//DataTime: data di ultimo update dell'evento						#18
	private $ACL;					//Access control list, definisce le politiche di accesso all'evento #19
	//private $featuring;			sostituirà #10: Dovrà essere impostata come RELATION dopo aggiornamento della libreria #20
    //private $invited;				sostituirà #13: Dovrà essere impostata come RELATION dopo aggiornamento della libreria #21	
	//private $attendee;			sostituirà #14: Dovrà essere impostata come RELATION dopo aggiornamento della libreria #22
	//private $refused;				sostituirà #15: Dovrà essere impostata come RELATION dopo aggiornamento della libreria #23
    private $loveCounter; 			//number:counter per gestire le azioni love sull'evento             #24
	
	//DEFINIZIONE DELLE FUNZIONI GET

	//string: objectId su Parse											#1
	public function getObjectId() {
		return $this->objectId;
	}

	//User: User che crea l’evento										#2
	public function getFromUser() {
		return $this->fromuser;
	}

	//string: Nome dell’evento											#3
	public function getTitle() {
		return $this->title;
	}

    //string: Descrizione breve dell’evento 							#4
	public function getDescription() {
		return $this->description;
	}

 	//DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento) #5
	public function getEventDate() {
		return $this->eventDate;
	}

	//GeoPoint: Luogo in cui si svolge l’evento                         #6
	public function getLocation() {
		return $this->location;
	//	$geoPointParse = new geoPointParse($this->location['latitude'], $this->location['longitude']);
	//	return $geoPointParse->getGeoPoint();
	}

	//string: Nome del locale in cui si svolge l’evento					#7
	public function getLocationName() {
		return $this->locationName;
	}

	//string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento #8
	public function getImage() {
		return $this->image;
	}

    //string: Stringa per il percorso di immagazzinamento della thumbnail #9
	public function getThumbnail() {
		return $this->thumbnail;
	}

	//array: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano…)  #10
	public function getFeaturing() {
		return $this->featuring;
	}

    //string: Categorizzazione dell’evento 								#11
	public function getTag() {
		return $this->tag;
	}

	//number: counter per votazione dell'evento       					#12
	public function getCounter() {
		return $this->counter;
	}

	//array: Array che contiene puntatori ad utenti invitati all'evento  #13
		public function getInvited() {
		return $this->invited;
	}

   //array: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento	#14
	public function getAttendee() {
		return $this->attendee;
	}

   //array: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento #15
	public function getRefused() {
		return $this->refused;
	}
	
	//BOOL: attiva/disattiva l'evento									#16
	public function getActive(){
		return $this->active;
	}

	//DataTime: data di registrazione dell'evento						#17
	public function getCreatedAt() {
		return $this->createdAt;
	}	

	//DataTime: data di ultimo update dell'evento						#18
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

    //Access control list, definisce le politiche di accesso all'evento #19
	public function getACL(){
		return $this->ACL;
	}

	//number:counter per gestire le azioni love sull'evento             #24
	public function getLoveCounter() {
		return $this->loveCounter;
	}

	//DEFINIZIONE DELLE FUNZIONI SET
	//string: objectId su Parse											#1
    public function setObjectId($value) {
		$this->objectId = $value;
	}
	
   //User: User che crea l’evento										#2
	public function setFromUser($value) {
		$this->fromUser = $value;	
	}

	//string: Nome dell’evento											#3
	public function setTitle($value) {
		$this->title = $value;
	}

   //string: Descrizione breve dell’evento 							#4
	public function setDescription($value) {
		$this->description = $value;
	}

	//DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento) #5
	public function setEventDate($value) {
		$this->eventDate = $value;
	}

	//GeoPoint: Luogo in cui si svolge l’evento                         #6
	public function setLocation($value) {
		//$geoPointParse = new geoPointParse($value['latitude'], $value['longitude']);
		//$this->location = $geoPointParse->getGeoPoint();
		$this->location = $value;
	}

    //string: Nome del locale in cui si svolge l’evento					#7
	public function setLocationName($value) {
		$this->locationName = $value;
	}

   //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento #8
	public function setImage($value) {
		$this->image = $value;
	}

   //string: Stringa per il percorso di immagazzinamento della thumbnail #9
	public function setThumbnail($value) {
		$this->thumbnail = $value;
	}

   //array: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano…)  #10
	public function setFeaturing($value) {
		$this->featuring = $value;
	}

	//string: Categorizzazione dell’evento 								#11
	public function setTag($value) {
		$this->tag = $value;
	}

   //number: counter per votazione dell'evento       					#12
	public function setCounter($value) {
		$this->counter = $value;
	}

	//array: Array che contiene puntatori ad utenti invitati all'evento  #13
	public function setInvited($value) {
		$this->invited = $value;
	}

	//array: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento	#14
	public function setAttendee($value) {
		$this->attendee = $value;
	}
 
	//array: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento #15
	public function setRefused($value) {
		$this->refused = $value;
	}

	//BOOL: attiva/disattiva l'evento									#16
	public function setActive($active){
		$this->active = $active;
	}
	
   //DataTime: data di registrazione dell'evento						#17  serve??
	public function setCreatedAt($value) {
		$this->createdAt = $value;
	}

	//DataTime: data di ultimo update dell'evento						#18  serve??
	public function setUpdatedAt($value) {
		$this->updatedAt = $value;
	}
	
    //Access control list, definisce le politiche di accesso all'evento #19
	public function setACL($value){
		$this->ACL = $value;
	}

	//number:counter per gestire le azioni love sull'evento             #24
	public function setLoveCounter($value) {
		$this->loveCounter = $value;
	}
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

?>
