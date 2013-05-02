<?php

class status{
	//proprie di Parse
	private $objectId;
	
	private $fromUser; 	// settarlo come il currentUser;
	private $counter; 	// inizializzare a 0;
	private $location; 	// lasciamolo empty, useremo questo campo solo per le applicazioni (non sarebbe comodo mettere il form don le coordinate etc, il commento è una cosa veloce);
	private $active; 	//impostarlo a YES;
	private $text;
	private $img;
	private $song;
	private $users;
	private $event;
	
	private $createdAt;
	private $updatedAt;
	private $ACL;

	public function __construct(){		
	}
	
	//FUNZIONI SET	
	
	public function setObjectId($objectId){
	
		$this->objectId = $objectId;
	
	}
	
	public function setFromUser(User $fromUser){
		
		$this->fromUser = $fromUser;
		
	}
	
	public function setACL($ACL){
		
		$this->ACL = $ACL;
		
	}
	
	public function setCounter($counter){
		
		$this->counter = $counter;
		
	}
	
	public function setLocation(parseGeoPoint $location){
		
		$this->location = $location;
		
	}
	
	public function setActive($active){
		
		$this->active = $active;
		
	}
	
	public function setCreatedAt(DataTime $createdAt){
		
		$this->createdAt = $createdAt;
		
	}
	
	public function setUpdatedAt(DataTime $updatedAt){
		
		$this->updatedAt = $updatedAt;
		
	}

	
	public function setText($text){
	
		$this->text = $text;
	
	}
	public function setImg($img){
	
		$this->img = $img;
	
	}
	public function setSong($song){
	
		$this->song = $song;
	
	}
	public function setUser(array $users){
		
		$userIdArray;
		
		$i = 0;
	
		foreach($users as $user){
			
			$userIdArray[$i] = $user->getObjectId();
			
			$i++;
		}
		$this->users = $userIdArray;
	
	}
	public function setEvent(Event $event){
	
		//event è un oggetto di tipo Event, recupoer l'objectId e creo il puntatore
		
		$this->events = $event;
	
	}
	
	
	
	//FUNZIONI GET
	
	public function getText(){
		
		return $this->text;
		
	}
	
	public function getACL(){
		
		return $this->ACL;
		
	}
	
	public function getfromUser(){
		
		return $this->fromUser;
		
	}
	
	public function getCounter(){
		
		return $this->counter;
		
	}
	
	public function getLocation(){
		
		return $this->location;
		
	}
	
	public function getActive(){
		
		return $this->active;
		
	}
	
	public function getCreatedAt(){
		
		return $this->createdAt;
		
	}
	
	public function getUpdatedAt(){
		
		return $this->updatedAt;
		
	}
	
	public function getObjectId(){
		
		return $this->objectId;
		
	}
	

	public function getImg(){
	
		return $this->img;
	
	}
	public function getSong(){
	
		return $this->song;
	
	}
	public function getUsers(){
	
		return $this->users;
	
	}
	public function getEvent(){
	
		return $this->event;
	
	}

	
	
	public function __toString(){
		$string = "";
		
		$string.="objectId: " .$this->objectId."<br>";
		$string.="createdAt: ". $this->createdAt."<br>";
		$string.="updatedAt: " .$this->updatedAt."<br>";		
		$string.="fromUser: " .$this->fromUser['objectId']."<br>"; 	
		$string.="counter: ". $this->counter."<br>"; 
		//$string.="location: " .$this->location."<br>"; 	
		$string.="active: " .$this->active."<br>"; 	
		//$string.="ACL: " .$this->ACL."<br>"; 		
		$string.="text: ". $this->text."<br>";
		//$string.="img: " .$this->img."<br>";
		//$string.="song: " .$this->song."<br>";
		$i=0;
		foreach($this->users as $user){
			
			$string.="users[$i]: " .$user."<br>";
			
			$i++;
		}
		$string.="event: " .$this->event."<br>";
		
		return $string;
		
	}


}

?>