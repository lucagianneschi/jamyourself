<?php

class Image{ 
	private $objectId;
	private $fromUser;	
	private $description;	
	private $album;	
	private $filePath;	
	private $location;	
	private $featuring;	
	private $tag;
	private $counter;

	private $createdAt;
	private $updatedAt;
	private $ACL;
	private $active;
	
	//costruttore
	public function __construct(){
		
	}
	
	//setters
	public function setOjectId($objectId){
		$this->objectId = $objectId;	
	}
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;	
	}
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;	
	}
	public function setCounter($counter){
		$this->counter = $counter;
	}
	public function setACL($ACL){
		$this->ACL = $ACL ;	
	}
	public function setActive($active){
		$this->active = $active;	
	}
	
	public function setFromUser(User $fromUser){		
		$this->fromUser = $fromUser;		
	}
	
	public function setDescription($description){		
		$this->description = $description;		
	}
	
	public function setAlbum(imageAlbum $album){
		$this->album = $album;		
	}
	
	public function setFilePath($filePath){
		$this->filePath = $filePath;
	}
	
	public function setLocation(parseGeoPoint $location){
		$this->location = $location;
	}
	
	public function setFeaturing(array $featuring){
		$this->featuring = $featuring;
	}
	
	
	public function setTag(array $tag){
		$this->tag = $tag;
	}
	
	//getters
	public function getOjectId(){
		return $this->objectId;	
	}
	public function getCreatedAt(){
		return $this->createdAt;	
	}
	public function getCounter(){
		return $this->counter;
	}
	public function getUpdatedAt(){
		return $this->updatedAt;	
	}
	public function getACL(){
		return $this->ACL;	
	}
	public function getActive(){
		return $this->active;	
	}
	
	public function getFromUser(){
		return $this->fromUser ;
	}
	
	public function getDescription(){
		return $this->description ;
	}
	
	public function getAlbum(){
		return $this->album ;
	}
	public function getFilePath(){
		return $this->filePath ;
	}
	
	public function getLocation(){
		return $this->location ;
	}
	
	public function getFeaturing(){
		return $this->featuring ;
	}
	
	public function getTag(){
		return $this->tag ;
	}
	  
}
?>