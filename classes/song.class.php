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
	public function setCounter($counter){
		$this->counter = $counter;
	}

	//string: Descrizione della Song data dall'utente     			#4
	public function setDescription($description){
		$this->description = $description;
	}

	//number: Durata della Song										#5
	public function setDuration($duration){
		$this->duration = $duration;
	}

	//array: presenza di altri Utenti								#6
	public function setFeaturing(array $featuring){
		$this->featuring = $featuring;
	}
	
	//string: Indirizzo del file									#7
	public function setFilePath($filePath){
		$this->filePath = $filePath;
	}

	//User: Utente che effettua la creazione della Song				#8
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	//string: Genere della Song										#9
	public function setGenre($genre){
		$this->genre = $genre;
	}

	//string: Etichetta di produzione								#10
	public function setLabel($label){
		$this->label = $label;
	}

	//geoPoint: coordinate di localizzazione della canzone			#11
	public function setLocation(parseGeoPoint $location){
		$this->location = $location;
	}

	//number: per tenere conto del numero di azioni love			#17
	public function setLoveCounter(array $loveCounter){
		$this->loveCounter = $loveCounter;
	}

	//Record (Parse Object): disco di appartenenza della song       #12
	public function setRecord(Record $record){
		$this->album = $record;
	}

	//string: titolo della song  									#13
	public function setTitle($title){
		$this->title = $title;
	}

	//DateTime: data e tempo di upload								#14
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;
	}

	//DateTime: data e tempo di ultima modifica					    #15
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}

	//Access Control list										    #16
	public function setACL(array $ACL){
		$this->ACL = $ACL;
	}


	//GETTERS

	//string: objectId su Parse									    #1
	public function getObjectId(){
		return $this->objectId;
	}

	//BOOL: attiva/disattiva l'istanza della classe  				#2
	public function getActive(){
		return $this->active;
	}

	//number: Contatore di gradimento 								#3
	public function getCounter(){
		return $this->counter;
	}

	//string: Descrizione della Song data dall'utente     			#4
	public function getDescription(){
		return $this->description;
	}

	//number: Durata della Song										#5
	public function getDuration(){
		return $this->duration;
	}

	//array: presenza di altri Utenti								#6
	public function getFeaturing(){
		return $this->featuring;
	}

	//string: Indirizzo del file									#7
	public function getFilePath(){
		return $this->filePath;
	}

	//User: Utente che effettua la creazione della Song				#8
	public function getFromUser(){
		return $this->fromUser;
	}

	//string: Genere della Song										#9
	public function getGenre(){
		return $this->genre;
	}

	//string: Etichetta di produzione								#10
	public function getLabel(){
		return $this->label;
	}

	//geoPoint: coordinate di localizzazione della canzone			#11
	public function getLocation(){
		return $this->location;
	}
	
	//number: per tenere conto del numero di azioni love			#17
	public function getLoveCounter(){
		return $this->loveCounter;
	}	

	//Record (Parse Object): disco di appartenenza della song       #12
	public function getRecord(){
		return $this->record;
	}

	//string: titolo della song  									#13
	public function getTitle(){
		return $this->title;
	}

	//DateTime: data e tempo di upload								#14
	public function getCreatedAt(){
		return $this->createdAt;
	}

	//DateTime: data e tempo di ultima modifica					    #15
	public function getUpdatedAt(){
		return $this->updatedAt;
	}

	//Access Control list										    #16
	public function getACL(){
		return $this->ACL;
	}
}
?>
