<?php

class Song{

	private $objectId;
	private $createdAt;
	private $updatedAt;
	private $ACL;
	
	private $active;
	private $counter; //aggiunta per tenere conto del numero di azioni di love
	private $fromUser;				
	private $title;					
	private $duration;				
	private $genre;					
	private $filePath;				
	private $description;			
	private $album;				
	private $label;					
	private $location;				
	private $featuring;				

	//SETTERS

	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;
	}

	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}

	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	public function setActive($active){
		$this->active = $active;
	}
		
	public function setTitle($title){
		$this->title = $title;
	}

	public function setDuration($duration){
		$this->duration = $duration;
	}

	public function setGenre($genre){
		$this->genre = $genre;
	}

	public function setFilePath($filePath){
		$this->filePath = $filePath;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function setAlbum(Record $album){
		$this->album = $album;
	}

	public function setLabel($label){
		$this->label = $label;
	}

	public function setLocation(parseGeoPoint $location){
		$this->location = $location;
	}

	public function setFeaturing(array $featuring){
		$this->featuring = $featuring;
	}

	public function setCounter(array $counter){
		$this->counter = $counter;
	}
	
	public function setLoveCounter(array $loveCounter){
		$this->loveCounter = $loveCounter;
	}
	
	public function setACL(array $ACL){
		$this->ACL = $ACL;
	}
	//GETTERS

	public function getObjectId(){
		return $this->objectId ;
	}

	public function getCreatedAt(){
		return $this->createdAt ;
	}

	public function getUpdatedAt(){
		return $this->updatedAt ;
	}

	public function getFromUser(){
		return $this->fromUser ;
	}
	
	public function getActive(){
		return $this->active;
	}

	public function getTitle(){
		return $this->title ;
	}

	public function getDuration(){
		return $this->duration ;
	}

	public function getGenre(){
		return $this->genre ;
	}

	public function getFilePath(){
		return $this->filePath ;
	}

	public function getDescription(){
		return $this->description ;
	}

	public function getAlbum(){
		return $this->album ;
	}

	public function getLabel(){
		return $this->label ;
	}

	public function getLocation(){
		return $this->location ;
	}

	public function getFeaturing(){
		return $this->featuring ;
	}
	
	public function getCounter(){
		return $this->counter ;
	}
	
	public function getLoveCounter(){
		return $this->loveCounter ;
	}
	
	public function getACL(){
		return $this->ACL ;
	}
}
