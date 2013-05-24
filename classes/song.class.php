<?php
//definizione: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:song
//api: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:song

class Song{

	private $objectId;		//string: objectId su Parse									    #1
	private $active;		//BOOL: attiva/disattiva l'istanza della classe  				#2
	private $counter;		//number: Contatore di gradimento 								#3
	private $description;   //string: Descrizione della Song data dall'utente     			#4
	private $duration;		//number: Durata della Song										#5
	private $featuring;		//array: presenza di altri Utenti								#6
	private $filePath;		//string: Indirizzo del file									#7
	private $fromUser;		//User: Utente che effettua la creazione della Song				#8
	private $genre;			//string: Genere della Song										#9
	private $label;			//string: Etichetta di produzione								#10
	private $location;      //geoPoint: coordinate di localizzazione della canzone			#11  //DA RIMUOVERE(?)
	private $loveCounter;   //number: per tenere conto del numero di azioni love			#17
	private $record;		//Record (Parse Object): disco di appartenenza della song       #12
	private $title;			//string: titolo della song  									#13		
	private $createdAt;		//DateTime: data e tempo di upload								#14
	private $updatedAt;		//DateTime: data e tempo di ultima modifica						#15
	private $ACL;			//Access Control list										    #16

	//SETTERS

	//string: objectId su Parse									    #1
	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

	//BOOL: attiva/disattiva l'istanza della classe  				#2
	public function setActive($active){
		$this->active = $active;
	}

	//number: Contatore di gradimento 								#3
	public function setCounter(array $counter){
		$this->counter = $counter;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function setDuration($duration){
		$this->duration = $duration;
	}

	public function setFeaturing(array $featuring){
		$this->featuring = $featuring;
	}

	public function setFilePath($filePath){
		$this->filePath = $filePath;
	}
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	public function setGenre($genre){
		$this->genre = $genre;
	}

	public function setLabel($label){
		$this->label = $label;
	}

	public function setLocation(parseGeoPoint $location){
		$this->location = $location;
	}

	public function setLoveCounter(array $loveCounter){
		$this->loveCounter = $loveCounter;
	}

	public function setRecord(Record $record){
		$this->album = $record;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;
	}

	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}
	public function setACL(array $ACL){
		$this->ACL = $ACL;
	}


	//GETTERS

	public function getObjectId(){
		return $this->objectId ;
	}

	public function getActive(){
		return $this->active;
	}
	public function getCounter(){
		return $this->counter ;
	}

	public function getDescription(){
		return $this->description ;
	}

	public function getDuration(){
		return $this->duration ;
	}

	public function getFeaturing(){
		return $this->featuring ;
	}

	public function getFilePath(){
		return $this->filePath ;
	}

	public function getFromUser(){
		return $this->fromUser ;
	}

	public function getGenre(){
		return $this->genre ;
	}

	public function getLabel(){
		return $this->label ;
	}

	public function getLoveCounter(){
		return $this->loveCounter ;
	}	

	public function getLocation(){
		return $this->location ;
	}

	public function getRecord(){
		return $this->record ;
	}

	public function getTitle(){
		return $this->title ;
	}

	public function getCreatedAt(){
		return $this->createdAt ;
	}

	public function getUpdatedAt(){
		return $this->updatedAt ;
	}

	public function getACL(){
		return $this->ACL ;
	}
}
