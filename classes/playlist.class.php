<?php

class Playlist{
	
	private $objectId;
	
	private $toUser;
	private $unlimited;
	private $songs;
	private $active;
	
	private $createdAt;
	private $updatedAt;
	private $ACL;
	
	
	
	public function __construct(){
		
	}
	
	
	//getters
	public function getObjectId(){
		return $this->objectId;  
	}
	
	public function getToUser(){
		return $this->toUser;
	}
	public function getActive(){
		return $this->active;
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
	
	public function setToUser(User $toUser){
		$this->toUser;
	}
	public function setActive($active){
		$this->active;
	}
	public function setSongs(array $songs){
		$this->songs;
	}
	public function setUnlimited($unlimited){
		$this->unlimited;
	}
	
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;  
	}
	
	public function setUpdatedAt(DateTime $updatedAt)
	{$this->updatedAt = $updatedAt;  
	}
	
	public function setACL($ACL){
		$this->ACL = ACL; 
	}
	
	public function __toString(){
		$string ="";
		$string.="objectId -> ".$this->objectId."<br>";
		

		$string.="toUser -> ".$this->toUser->getUsername()."<br>";
		
		$converted_res = ($this->unlimited) ? 'true' : 'false';
		
		$string.="unlimited -> ".$converted_res."<br>";

		$i=0;
		foreach($this->songs as $song){
			$string.="songs[".$i."] -> ".$song->getTitle()." - ".$song->getTitle()."<br>";			
			$i++;
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