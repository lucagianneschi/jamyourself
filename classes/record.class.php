<?php

class Record{

	private	$objectId;
	private	$fromUser;
	private	$title;
	private	$description;
	private	$location;
	private	$cover;
	private	$thumbnailCover;
	private	$featuring;
	private	$keywords;
	private	$genre;
	private	$label;
	private	$createdAt;
	private	$updatedAt;


	//costruttore
	
	public function __construct(){

	}

	//SETTERS

	public function	setObjectId($objectId){
		$this->objectId = $objectId;
	}

	public function	setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;
	}

	public function	setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}

	public function	setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	public function	setTitle($title){
		$this->title = $title;
	}

	public function	setDescription($description){
		$this->description = $description;
	}

	public function	setLocation(parseGeoPoint $location){
		$this->location = $location;
	}

	public function	setCover($cover){
		$this->cover = $cover;
	}

	public function	setThumbnailCover($thumnbnailCover){
		$this->thumbnailCover = $thumbnailCover;
	}

	public function	setFeaturing(array $featuring){
		$this->featuring = $featuring;
	}

	public function	setKeywords(array $keywords){
		$this->keywords = $keywords;
	}

	public function	setGenre($genre){
		$this->genre = $genre;
	}

	public function	setLabel($label){
		$this->label = $label;
	}

	//GETTERS

	public function	getObjectId(){
		return $this->objectId;
	}

	public function	getCreatedAt(){
		return $this->createdAt;
	}

	public function	getUpdatedAt(){
		return $this->updatedAt;
	}

	public function	getFromUser(){
		return $this->fromUser;
	}

	public function	getTitle(){
		return $this->title;
	}

	public function	getDescription(){
		return $this->description;
	}

	public function	getLocation(){
		return $this->location;
	}

	public function	getCover(){
		return $this->cover;
	}

	public function	getThumbnailCover(){
		return $this->thumbnailCover;
	}

	public function	getFeaturing(){
		return $this->featuring;
	}

	public function	getKeywords(){
		return $this->keywords;
	}

	public function	getGenre(){
		return $this->genre;
	}

	public function	getLabel(){
		return $this->label;
	}
}
?>