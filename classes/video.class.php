<?php

//descrizione della classe:http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:video
//api: DA FARE!!

class Video{

	private $objectId;  		//string: objectId su Parse  								#1
	private $active;    		//BOOL: segnala se l'istanza della classe è attiva o no 	#17
	private $author;			//string: Utente che ha girato il video 					#4
    private $counter;			//number: Contatore per il gradimento 						#11
	private $description;		//string: Descrizione del video data dall'utente  			#7
	private $duration;			//number: Durata del video									#10
	private $fromUser;   		//User: Punta allo user che effettua l'embed del video  	#3
	private $featuring;			//array: per segnalare la presenza di altri utenti 			#12 
	private $loveCounter;		//number: Contatore per il numero di azioni love 			#16
	private $tags;				//array: stringhe per la categorizzazione del video 		#9
	private $thumbnail;  		//string: Percorso immagine del thumbnail del video 		#8
	private $title;				//string:Titolo del video  									#5
	private $URL;    			//string: URL del video  									#2
	private $createdAt;			//DataTime: data di creazione del video						#13
	private $updatedAt;			//DataTime: data di update del video						#14
	private $ACL;				//Access Control List										#15


	public function __construct(){
	}

	/** FUNZIONI GET */
	//string: objectId su Parse  								#1
	public function getObjectId(){
		return $this->objectId;
	}

	//BOOL: segnala se l'istanza della classe è attiva o no 	#17
	public function getActive(){
		return $this->active;
	}
	
	//string: Utente che ha girato il video 					#4
	public function getAuthor(){
		return $this->author;
	}

	//number: Contatore per il gradimento 						#11
	public function getCounter(){
		return $this->counter;
	}

	//string: Descrizione del video data dall'utente  			#7
	public function getDescription(){
		return $this->description;
	}

	//number: Durata del video									#10
	public function getDuration(){
		return $this->duration;
	}

	
	//array: per segnalare la presenza di altri utenti 			#12
	public function getFeaturing(){
		return $this->featuring;
	}

	//User: Punta allo user che effettua l'embed del video  	#3
	public function getFromUser(){
		return $this->fromUser;
	}

	//number: Contatore per il numero di azioni love 			#16
	public function getLoveCounter(){
		return $this->loveCounter;
	}

	//array: stringhe per la categorizzazione del video 		#9
	public function getTags(){
		return $this->tags;
	}

	//string:Titolo del video  									#5
	public function getTitle(){
		return $this->title;
	}

	//string: Percorso immagine del thumbnail del video 		#8
	public function getThumbnail(){
		return $this->thumbnail;
	}

	//string: URL del video  									#2
	public function getURL(){
		return $this->URL;
	}

	//DataTime: data di creazione del video						#13
	public function getCreatedAt(){
		return $this->createdAt;
	}

	//DataTime: data di update del video						#14
	public function getUpdatedAt(){
		return $this->updatedAt;
	}

	//Access Control List										#15
	public function getACL(){
		return $this->ACL;
	}

	/** FUNZIONI SET */
	
	//string: objectId su Parse  								#1
	public function setObjectId($objecId){
		$this->objectId = $objecId;
	}

	//BOOL: segnala se l'istanza della classe è attiva o no 	#17
	public function setActive($active){
		$this->active = $active;
	}

	//string: Utente che ha girato il video 					#4
	public function setAuthor($author){
		$this->author = $author;
	}

	//number: Contatore per il gradimento 						#11
	public function setCounter($counter){
		$this->counter = $counter;
	}

	//string: Descrizione del video data dall'utente  			#7
	public function setDescription($description){
		$this->description = $description;
	}

	//number: Durata del video									#10
	public function setDuration($duration){
		$this->duration = $duration;
	}

	//array: per segnalare la presenza di altri utenti 			#12
	public function setFeaturing(array $featuring){
		$this->featuring = $featuring;
	}

	//User: Punta allo user che effettua l'embed del video  	#3
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	//number: Contatore per il numero di azioni love 			#16
	public function setLoveCounter($loveCounter){
		$this->loveCounter = $loveCounter;
	}

	//array: stringhe per la categorizzazione del video 		#9
	public function setTags($tags){
		$this->tags = $tags;
	}

	//string:Titolo del video  									#5
	public function setTitle($title){
		$this->title = $title;
	}

	//string: Percorso immagine del thumbnail del video 		#8
	public function setThumbnail($thubmnail){
		$this->thumbnail = $thubmnail;
	}

	//string: URL del video  									#2
	public function setURL($URL){
		$this->URL = $URL;
	}

	//DataTime: data di creazione del video						#13
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;
	}

	//DataTime: data di update del video						#14
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}

	//Access Control List										#15
	public function setACL($ACL){
		$this->ACL = ACL;
	}
}

?>
