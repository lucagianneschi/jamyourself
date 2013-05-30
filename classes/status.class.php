<?php

class Status{
	//proprie di Parse
	private $objectId;  				//string: object ID Parse      
	private $active; 					//BOOL: indica se la classe è attiva o meno
    private $commentators;				//relation: array di puntatori a Parse Users
    private $comments;					//relation: array di puntatori a Comment
	private $counter; 					//number: contatore che serve per gradimento dello status
	private $event;   					//Parse Object Event: evento associato allo status
	private $fromUser; 					//Parse User: utente che pubblica lo status
	private $image;						//Parse Object Image: image associata allo status
	private $location; 					//GeoPoint: lat e long per localizzazione dello status (inutilizzato)
	private $loveCounter;  				//number: counter per tenere conto delle sole azioni di love
	private $lovers; 					//relation: array di puntatori a Parse Users
	private $song;						//Parse Object Song: song associata allo status
	private $taggedUsers;				//relation: array di puntatori a Parse Users
	private $text;						//string: testo inserito dall'utente per il proprio status
	private $createdAt;					//DataTime: data di creazione dello status						
	private $updatedAt;					//DataTime: data di update dello status						
	private $ACL;						//Access Control List										

	//public function __construct(){}
	
	//FUNZIONI SET	
	
	//string: object ID Parse 
	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

	//BOOL: indica se la classe è attiva o meno
	public function setActive($active){
		$this->active = $active;
	}

    //relation: array di puntatori a Parse Users
	public function setCommentators(Relation $commentators){
		$this->commentators = $commentators;
	}

     //relation: array di puntatori a Parse Comment
	public function setComments(Relation $comments){
		$this->comments = $comments;
	}

	//number: contatore che serve per gradimento dello status
	public function setCounter($counter){
		$this->counter = $counter;
	}

	//Parse Object Event: evento associato allo status
	public function setEvent($event){
		$this->events = $event;
	}
	
	//Parse User: utente che pubblica lo status
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}
	
	//Parse Object Image: image associata allo status
	public function setImage($image){ 
		$this->image = $image;
	}

	//GeoPoint: lat e long per localizzazione dello status (inutilizzato)
	public function setLocation(parseGeoPoint $location){
		$this->location = $location;
	}

	//number: counter per tenere conto delle sole azioni di love
	public function setLoveCounter($loveCounter){
		$this->loveCounter = $loveCounter;	
	}

    //relation: array di puntatori a Parse Users
	public function setLovers(Relation $lovers){
		$this->lovers = $lovers;
	}
	
	//Parse Object Song: song associata allo status
	public function setSong($song){
		$this->song = $song;
	}

	//relation: array di puntatori a Parse Users
	public function setTaggedUsers(Relation $taggedUsers){
		$this->taggedUsers = $taggedUsers;
	}

	//string: testo inserito dall'utente per il proprio status
	public function setText($text){
		$this->text = $text;
	}

	//DataTime: data di creazione dello status
	public function setCreatedAt(DataTime $createdAt){
		$this->createdAt = $createdAt;
	}
	
	//DataTime: data di update dello status	
	public function setUpdatedAt(DataTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}

	//Access Control List
	public function setACL($ACL){
		$this->ACL = $ACL;
	}

	//FUNZIONI GET
	
	//string: object ID Parse 
	public function getObjectId(){
		return $this->objectId;
	}

	//BOOL: indica se la classe è attiva o meno
	public function getActive(){
		return $this->active;
	}

	//relation: array di puntatori a Parse Users
	public function getCommentators(){
		return $this->commentators;
	}

	//relation: array di puntatori a Parse Users
	public function getComments(){
		return $this->comments;
	}

	//number: contatore che serve per gradimento dello status
	public function getCounter(){
		return $this->counter;
	}

	//Parse Object Event: evento associato allo status
	public function getEvent(){
		return $this->event;
	}
	
	//Parse User: utente che pubblica lo status
	public function getfromUser(){
		return $this->fromUser;
	}
	
	//Parse Object Image: image associata allo status
	public function getImage(){
		return $this->image;
	}

	//GeoPoint: lat e long per localizzazione dello status (inutilizzato)
	public function getLocation(){
		return $this->location;
	}
	
	//number: counter per tenere conto delle sole azioni di love
	public function getLoveCounter(){
		return $this->loveCounter;
	}

	//relation: array di puntatori a Parse Users
	public function getLovers(){
		return $this->lovers;
	}
	
	//Parse Object Song: song associata allo status
	public function getSong(){
		return $this->song;
	}

	//relation: array di puntatori a Parse Users
	public function getTaggedUsers(){
		return $this->taggedUsers;
	}

	//string: testo inserito dall'utente per il proprio status
	public function getText(){
		return $this->text;
	}

	//DataTime: data di creazione dello status
	public function getCreatedAt(){
		return $this->createdAt;
	}

	//DataTime: data di update dello status
	public function getUpdatedAt(){
		return $this->updatedAt;
	}
	//Access Control List
	public function getACL(){
		return $this->ACL;
	}
	
	
	public function __toString(){
		$string = "";
		
		$string.="objectId: " .$this->objectId."<br>";
		$string.="createdAt: ". $this->createdAt."<br>";
		$string.="updatedAt: " .$this->updatedAt."<br>";		
		$string.="fromUser: " .$this->fromUser['objectId']."<br>"; 	
		$string.="counter: ". $this->counter."<br>"; 
		$string.="loveCounter: ". $this->loveCounter."<br>"; 
		//$string.="location: " .$this->location."<br>"; 	
		$string.="active: " .$this->active."<br>"; 	
		//$string.="ACL: " .$this->ACL."<br>"; 		
		$string.="text: ". $this->text."<br>";
		//$string.="img: " .$this->img."<br>";
		//$string.="song: " .$this->song."<br>";
		$i=0;
		foreach($this->taggedUsers as $user){
			
			$string.="users[$i]: " .$user."<br>";
			
			$i++;
		}
		$string.="event: " .$this->event."<br>";
		
		return $string;	
	}
}

?>
