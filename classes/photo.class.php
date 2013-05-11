<?php

class Photo{ 
	private $fromUser;	
	private $description;	
	private $album;	
	private $filePath;	
	private $location;	
	private $featuring;	
	private $title;	
	private $genre;	
	private $label;
	private $duration;

	//costruttore
	public function __construct(){
		
	}
	
	//setters
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
	
	public function setTitle($title){
		$this->title = title;
	}
	
	public function setGenre($genre){
		$this->genre = $genre;
	}
	
	public function setLabel($label){
		$this->label = $label;
	}
	
	public function setDuration(DateInterval $duration){
		$this->duration = $duration;
	}
	
	//getters
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
	
	public function getTitle(){
		return $this->title ;
	}
	
	public function getGenre(){
		return $this->genre ;
	}
	
	public function getLabel(){
		return $this->label ;
	}
	
	public function getDuration(){
		return $this->duration ;
	}    
}
?>