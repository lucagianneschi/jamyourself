<?php

class Playlist{
	
	private $objectId;
	
	private $fromUser;
	private $unlimited;
	private $songs;
	private $active;
	private $name;
	
	private $createdAt;
	private $updatedAt;
	private $ACL;
	
	
	
	public function __construct(){
		
	}
	
	
	//getters
	public function getObjectId(){
		return $this->objectId;  
	}
	
	public function getFromUser(){
		return $this->fromUser;
	}
	public function getActive(){
		return $this->active;
	}
	public function getName(){
		return $this->name;
	}
	public function getSongs(){
		return $this->songs;
	}
	public function getUnlimited(){
		return $this->unlimited;
	}
		
	public function getCreatedAt(){
		return $this->createdAt; 
	}
	
	public function getUpdatedAt(){
		return $this->updatedAt; 
	}
	
	public function getACL(){
		return $this->ACL;  
	}
	
	//setters
	public function setObjectId($objectId){
		$this->objectId = $objectId;  
	}
	
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}
	public function setActive($active){
		$this->active = $active;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function setSongs(array $songs){
		$this->songs = $songs;
	}
	public function setUnlimited($unlimited){
		$this->unlimited = $unlimited;
	}
	
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;  
	}
	
	public function setUpdatedAt(DateTime $updatedAt)
	{$this->updatedAt = $updatedAt;  
	}
	
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
				$string.="songs[".$i."] -> ".$song->getTitle()." - ".$song->getTitle()."<br>";			
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