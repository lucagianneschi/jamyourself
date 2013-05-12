<?php

class Song{

	private $objectId;
	private $createdAt;
	private $updatedAt;
	private $active;
	private $authorId;				//l'autore del media -> l'utente che ha caricato il file
	private $title;					//titolo del file
	private $duration;				//Durata del brano (da vedere come calcolarla)
	private $genre;					//genere musicale -> obbligatorio
	private $filePath;				//path relativo del file
	private $description;			//Opzionale = descrizione del file
	private $albumId;				//Album in cui è inserito il brano
	private $label;					//Opzionale : etichetta discografica
	private $location;				//Opzionale = geopoint di Parse.Geopoint
	private $featuring;				//array di Parse.User

	//SETTERS

	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

	public function setCreatedAt($createdAt){
		$this->createdAt = $createdAt;
	}

	public function setUpdatedAt($updatedAt){
		$this->updatedAt = $updatedAt;
	}

	public function setAuthorId($authorId){
		$this->authorId = $authorId;
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

	public function setAlbumId($albumId){
		$this->albumId = $albumId;
	}

	public function setLabel($label){
		$this->label = $label;
	}

	public function setLocation($location){
		$this->location = $location;
	}

	public function setFeaturing($featuring){
		$this->featuring = $featuring;
	}

	//GETTERS

	public function getObjectId(){
		return $this->objectId ;
	}

	public function getCreatedAt(){
		return $this->createdAt ;
	}

	public function getActive(){
		return $this->active;
	}
	public function getUpdatedAt(){
		return $this->updatedAt ;
	}

	public function getAuthorId(){
		return $this->authorId ;
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

	public function getAlbumId(){
		return $this->albumId ;
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
}