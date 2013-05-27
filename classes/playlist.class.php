<?php

class Playlist{
	
	private $objectId;			//string: objectId Parse
	private $active;  			//BOOL: classe attiva/non attiva
	private $fromUser;			//Pointer to Parse User, utente a cui appartiene la playlist
	private $name;				//string: nome della playlist
	private $unlimited; 		//BOOL: indica se il numero di canzoni da mettere nella playlist è illimitato o meno
	private $songs;     		//relation: lista delle canzoni inserite dall'utente nella playslit
	private $createdAt; 		//DateTime: data e ora di creazione dell'istanza della playlist
	private $updatedAt; 		//DateTime: data e ora di update dell'istanza della playlist
	private $ACL;				//Access Control List

	public function __construct(){
		
	}
	
	//getters
	//string: objectId Parse
	public function getObjectId(){
		return $this->objectId;  
	}

	//BOOL: classe attiva/non attiva
	public function getActive(){
		return $this->active;
	}

	//Pointer to Parse User, utente a cui appartiene la playlist
	public function getFromUser(){
		return $this->fromUser;
	}

	//string: nome della playlist
	public function getName(){
		return $this->name;
	}

	//BOOL: indica se il numero di canzoni da mettere nella playlist è illimitato o meno
	public function getUnlimited(){
		return $this->unlimited;
	}
		
	//relation: lista delle canzoni inserite dall'utente nella playslit
	public function getSongs(){
		return $this->songs;
	}

	//DateTime: data e ora di creazione dell'istanza della playlist
	public function getCreatedAt(){
		return $this->createdAt; 
	}
	
	//DateTime: data e ora di update dell'istanza della playlist
	public function getUpdatedAt(){
		return $this->updatedAt; 
	}
	
	//Access Control List
	public function getACL(){
		return $this->ACL;  
	}
	
	//setters
	//string: objectId Parse
	public function setObjectId($objectId){
		$this->objectId = $objectId;  
	}

	//BOOL: classe attiva/non attiva
	public function setActive($active){
		$this->active = $active;
	}
	
	//Pointer to Parse User, utente a cui appartiene la playlist
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	//string: nome della playlist
	public function setName($name){
		$this->name = $name;
	}

	//relation: lista delle canzoni inserite dall'utente nella playslit
	public function setSongs(Relation $songs){
		$this->songs = $songs;
	}

	//BOOL: indica se il numero di canzoni da mettere nella playlist è illimitato o meno
	public function setUnlimited($unlimited){
		$this->unlimited = $unlimited;
	}
	
	//DateTime: data e ora di creazione dell'istanza della playlist
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;  
	}
	
	//DateTime: data e ora di update dell'istanza della playlist
	public function setUpdatedAt(DateTime $updatedAt)
	{$this->updatedAt = $updatedAt;  
	}
	
	//Access Control List
	public function setACL($ACL){
		$this->ACL = $ACL; 
	}
	
	public function __toString(){
		$string ="";
		$string.="objectId -> ".$this->objectId."<br>";
		

		$string.="fromUser -> ".$this->fromUser->getUsername()."<br>";

		$string.="name -> ".$this->getName()."<br>";
		
		$converted_res = ($this->unlimited) ? 'true' : 'false';
		
		$string.="unlimited -> ".$converted_res."<br>";

		$i=0;
		if($this->songs){
			foreach($this->songs as $song){
				$string.="songs[".$i."] -> ".$song->getTitle()." - ".$song->getTitle()."<br>";	//controllare il funzionamento di questa funzione dopo modifica del tipo!! da array a relation!!		
				$i++;
			}
		}
		
		$converted_res = ($this->active) ? 'true' : 'false';
		$string.="active-> ".$converted_res."<br>";	
			
		if($this->getUpdatedAt())$string.="updatedAt -> ".$this->getUpdatedAt()->format('d/m/Y H:i:s')."<br>";
		if($this->getCreatedAt())$string.="createdAt -> ".$this->getCreatedAt()->format('d/m/Y H:i:s')."<br>";
		//$string.="-> ".$this->ACL;
		
		return $string;
	}
	
}

?>