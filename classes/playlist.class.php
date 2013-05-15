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
	public function getTSongs(){
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
	
	public function getToUser(User $toUser){
		$this->toUser;
	}
	public function getActive($active){
		$this->active;
	}
	public function getTSongs(array $songs){
		$this->songs;
	}
	public function getUnlimited($unlimited){
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
		$string.="unlimited -> ".$this->unlimited."<br>";

		$i=0;
		foreach($this->songs as $song){
			$string.="songs[".$i."] -> ".$song->getTitle()." - ".$song->getTitle()."<br>";			
			$i++;
		}
		
		$string.="active-> ".$this->active."<br>";		
		if($this->getUpdatedAt())$string.="updatedAt -> ".$this->getUpdatedAt()->format('d/m/Y H:i:s')."<br>";
		if($this->getCreatedAt())$string.="createdAt -> ".$this->getCreatedAt()->format('d/m/Y H:i:s')."<br>";
		//$string.="-> ".$this->ACL;
		
		return $string;
	}
	
}

?>