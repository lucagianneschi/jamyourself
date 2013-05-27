<?php

//definizione della classe: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:event
//api:http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:event

define('CLASS_DIR', '../classes/');
include_once CLASS_DIR.'geoPointParse.class.php';

class Event {
	
	private $objectId;              //string: objectId su Parse		
	private $active;				//BOOL: attiva/disattiva l'evento
	private $attendee;				//relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento
	private $commentators;			//relation: Array che contiene puntatori ad utenti che hanno compiuto azione commento
	private $counter;				//number: counter per votazione dell'evento 
	private $description;			//string: Descrizione breve dell’evento
	private $eventDate;             //DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento)
	private $featuring;             //relation: Presenza di altri utenti all’evento  
	private $fromUser;				//User: User che crea l’evento	
 	private $image;					//string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
	private $invited;				//relation: Array che contiene puntatori ad utenti invitati all'evento
    private $location;				//GeoPoint: Luogo in cui si svolge l’evento                         
    private $locationName;			//string: Nome del locale in cui si svolge l’evento	
 	private $loveCounter; 			//number:counter per gestire le azioni love sull'evento 
	private $lovers;				//relation: Array che contiene puntatori ad utenti che hanno compiuto azione love
	private $refused;				//relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento 									 
    private $tags;                  //array: Categorizzazione dell’evento 								
	private $thumbnail;				//string: Stringa per il percorso di immagazzinamento della thumbnail	
	private $title;                 //string: Nome dell’evento
	private $createdAt;				//DataTime: data di registrazione dell'evento					
	private $updatedAt;				//DataTime: data di ultimo update dell'evento						
	private $ACL;					//Access control list, definisce le politiche di accesso all'evento 


	
	//DEFINIZIONE DELLE FUNZIONI GET

	//string: objectId su Parse											
	public function getObjectId() {
		return $this->objectId;
	}

	//BOOL: attiva/disattiva l'evento									
	public function getActive(){
		return $this->active;
	}

    //relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento	
	public function getAttendee() {
		return $this->attendee;
	}

	//relation: Array che contiene puntatori ad utenti che hanno compiuto azione commento									
	public function getCommentators() {
		return $this->commentators;
	}

	//number: counter per votazione dell'evento       					
	public function getCounter() {
		return $this->counter;
	}

    //string: Descrizione breve dell’evento 						
	public function getDescription() {
		return $this->description;
	}

 	//DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento) 
	public function getEventDate() {
		return $this->eventDate;
	}

	//relation: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano…)  
	public function getFeaturing() {
		return $this->featuring;
	}

	//User: User che crea l’evento									
	public function getFromUser() {
		return $this->fromuser;
	}

	//string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
	public function getImage() {
		return $this->image;
	}

	//relation: Array che contiene puntatori ad utenti invitati all'evento  
		public function getInvited() {
		return $this->invited;
	}

	//GeoPoint: Luogo in cui si svolge l’evento                        
	public function getLocation() {
		return $this->location;
	}

	//number:counter per gestire le azioni love sull'evento             
	public function getLoveCounter() {
		return $this->loveCounter;
	}

	//number:counter per gestire le azioni love sull'evento            
	public function getLovers() {
		return $this->lovers;
	}

	//string: Nome del locale in cui si svolge l’evento					
	public function getLocationName() {
		return $this->locationName;
	}

    //relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento 
	public function getRefused() {
		return $this->refused;
	}
	
    //array: Categorizzazione dell’evento 								
	public function getTags() {
		return $this->tags;
	}

    //string: Stringa per il percorso di immagazzinamento della thumbnail
	public function getThumbnail() {
		return $this->thumbnail;
	}

	//string: Nome dell’evento										
	public function getTitle() {
		return $this->title;
	}

	//DataTime: data di registrazione dell'evento						
	public function getCreatedAt() {
		return $this->createdAt;
	}	

	//DataTime: data di ultimo update dell'evento						
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

    //Access control list, definisce le politiche di accesso all'evento 
	public function getACL(){
		return $this->ACL;
	}

	//DEFINIZIONE DELLE FUNZIONI SET
	//string: objectId su Parse											
    public function setObjectId($value) {
		$this->objectId = $value;
	}

	//BOOL: attiva/disattiva l'evento									
	public function setActive($active){
		$this->active = $active;
	}

	//relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento	
	public function setAttendee($value) {
		$this->attendee = $value;
	}

	//relation: Array che contiene puntatori ad utenti che hanno effettuato commento
	public function setCommentators($value) {
		$this->commentators = $value;
	}

   //number: counter per votazione dell'evento       					
	public function setCounter($value) {
		$this->counter = $value;
	}

  	//string: Descrizione breve dell’evento 							
	public function setDescription($value) {
		$this->description = $value;
	}

	//DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento) 
	public function setEventDate($value) {
		$this->eventDate = $value;
	}

  	//relation: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano…)  #10
	public function setFeaturing($value) {
		$this->featuring = $value;
	}

    //User: User che crea l’evento										#2
	public function setFromUser($value) {
		$this->fromUser = $value;	
	}

   //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
	public function setImage($value) {
		$this->image = $value;
	}

	//relation: Array che contiene puntatori ad utenti invitati all'evento  
	public function setInvited($value) {
		$this->invited = $value;
	}

	//GeoPoint: Luogo in cui si svolge l’evento                        
	public function setLocation($value) {
		$this->location = $value;
	}

    //string: Nome del locale in cui si svolge l’evento				
	public function setLocationName($value) {
		$this->locationName = $value;
	}

	//number:counter per gestire le azioni love sull'evento             
	public function setLoveCounter($value) {
		$this->loveCounter = $value;
	}

	//number:counter per gestire le azioni love sull'evento             
	public function setLovers($value) {
		$this->lovers = $value;
	}


	//relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento #15
	public function setRefused($value) {
		$this->refused = $value;
	}

	//array: Categorizzazione dell’evento 								
	public function setTags($value) {
		$this->tags = $value;
	}

    //string: Stringa per il percorso di immagazzinamento della thumbnail
	public function setThumbnail($value) {
		$this->thumbnail = $value;
	}

 	//string: Nome dell’evento										
	public function setTitle($value) {
		$this->title = $value;
	}

   //DataTime: data di registrazione dell'evento						
	public function setCreatedAt($value) {
		$this->createdAt = $value;
	}

	//DataTime: data di ultimo update dell'evento						
	public function setUpdatedAt($value) {
		$this->updatedAt = $value;
	}
	
    //Access control list, definisce le politiche di accesso all'evento 
	public function setACL($value){
		$this->ACL = $value;
	}
}
	
	function printEvent() {
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
