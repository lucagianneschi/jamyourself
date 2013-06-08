<?php
//definizione: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:song
//api: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:song

class Song{

    private $objectId;  //string: objectId su Parse									   
    private $active;  //BOOL: attiva/disattiva l'istanza della classe 
    private $comments;      //relation: puntatori ad oggetti Comment
    private $counter;  //number: Contatore di gradimento 								
    private $duration;  //number: Durata della Song										
    private $featuring;  //array: presenza di altri Utenti								
    private $filePath;  //string: Indirizzo del file									
    private $fromUser;  //User: Utente che effettua la creazione della Song				
    private $genre;   //string: Genere della Song										
    private $location;      //geoPoint: coordinate di localizzazione della canzone			
    private $loveCounter;   //number: per tenere conto del numero di azioni love			
    private $record;  //Record (Parse Object): disco di appartenenza della song       
    private $title;   //string: titolo della song  											
    private $createdAt;  //DateTime: data e tempo di upload								
    private $updatedAt;  //DateTime: data e tempo di ultima modifica						
    private $ACL;   //Access Control list										    

	//SETTERS

	//string: objectId su Parse									    
	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

	//BOOL: attiva/disattiva l'istanza della classe  				
	public function setActive($active){
		$this->active = $active;
	}

	//relation: puntatori ad oggetti Comment
	public function setComments(array $comments){
		$this->comments = $comments;
	}

	//number: Contatore di gradimento 								
	public function setCounter($counter){
		$this->counter = $counter;
	}

	//number: Durata della Song										
	public function setDuration($duration){
		$this->duration = $duration;
	}

	//array: presenza di altri Utenti								
	public function setFeaturing(array $featuring){
		$this->featuring = $featuring;
	}
	
	//string: Indirizzo del file									
	public function setFilePath($filePath){
		$this->filePath = $filePath;
	}

	//User: Utente che effettua la creazione della Song				
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	//string: Genere della Song									
	public function setGenre($genre){
		$this->genre = $genre;
	}

	//geoPoint: coordinate di localizzazione della canzone			
	public function setLocation(parseGeoPoint $location){
		$this->location = $location;
	}

	//number: per tenere conto del numero di azioni love			
	public function setLoveCounter($loveCounter){
		$this->loveCounter = $loveCounter;
	}

	//Record (Parse Object): disco di appartenenza della song       
	public function setRecord(Record $record){
		$this->album = $record;
	}

	//string: titolo della song  									
	public function setTitle($title){
		$this->title = $title;
	}

	//DateTime: data e tempo di upload								
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;
	}

	//DateTime: data e tempo di ultima modifica					    
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}

	//Access Control list										    
	public function setACL(parseACL $ACL){
		$this->ACL = $ACL;
	}


	//GETTERS

	//string: objectId su Parse									    
	public function getObjectId(){
		return $this->objectId;
	}

	//BOOL: attiva/disattiva l'istanza della classe  			
	public function getActive(){
		return $this->active;
	}

	//relation: puntatori ad oggetti Comment 								
	public function getComments(){
		return $this->comments;
	}

	//number: Contatore di gradimento 								
	public function getCounter(){
		return $this->counter;
	}

	//number: Durata della Song										
	public function getDuration(){
		return $this->duration;
	}

	//array: presenza di altri Utenti								
	public function getFeaturing(){
		return $this->featuring;
	}

	//string: Indirizzo del file									
	public function getFilePath(){
		return $this->filePath;
	}

	//User: Utente che effettua la creazione della Song				
	public function getFromUser(){
		return $this->fromUser;
	}

	//string: Genere della Song										
	public function getGenre(){
		return $this->genre;
	}

	//geoPoint: coordinate di localizzazione della canzone			
	public function getLocation(){
		return $this->location;
	}
	
	//number: per tenere conto del numero di azioni love			
	public function getLoveCounter(){
		return $this->loveCounter;
	}	

	//Record (Parse Object): disco di appartenenza della song       
	public function getRecord(){
		return $this->record;
	}

	//string: titolo della song  									
	public function getTitle(){
		return $this->title;
	}

	//DateTime: data e tempo di upload								
	public function getCreatedAt(){
		return $this->createdAt;
	}

	//DateTime: data e tempo di ultima modifica					    
	public function getUpdatedAt(){
		return $this->updatedAt;
	}

	//Access Control list										    
	public function getACL(){
		return $this->ACL;
	}
}
?>
