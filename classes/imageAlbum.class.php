<?php

class ImageAlbum{

	private $objectId;
	private $fromUser;
	private $title;
	private $description;
	private $location;
	private $cover;
	private $thumbnailCover;
	private $featuring;
	private $tag;
	private $createdAt;
	private $updatedAt;
	private $ACL;

	//costruttore
	public function __construct(){

	}

	//getters
	public function getObjectId(){
		return $this->objectId;
	}
	public function getFromUser(){
		return $this->fromUser  ;
	}
	public function getTitle(){
		return $this->title  ;
	}
	public function getDescription(){
		return $this->description  ;
	}

	public function getLocation(){
		return $this->location  ;
	}

	public function getCover(){		
		return $this->cover  ;
	}

	public function getThumbnailCover(){
		return $this->thumbnailCover  ;
	}

	public function getFeaturing(){
		return $this->featuring  ;
	}

	public function getTag(){
		return $this->tag  ;
	}
	
	public function getCreatedAt(){
		return $this->createdAt  ;
	}
	
	public function getUpdatedAt(){
		return $this->updatedAt  ;
	}
	
	public function getACL(){
		return $this->ACL  ;
	}


	//setters

	public function setObjectId($objectId){
		$this->objectId=$objectId  ;
	}
	
	public function setFromUser(User $fromUser){
		$this->fromUser  = $fromUser ;
	}
	
	public function setTitle($title){
		$this->title  = $title ;
	}
	
	public function setDescription($description){
		$this->description  = $description ;
	}
	
	public function setLocation(parseGeoPoint $location){
		$this->location  = $location ;
	}
	
	public function setCover($cover){
		$this->cover  = $cover ;
	}
	
	public function setThumbnailCover($thumbnailCover){
		$this->thumbnailCover  = $thumbnailCover ;
	}
	
	public function setFeaturing(array $featuring){
		$this->featuring  = $featuring ;
	}
	
	public function setTag(array $tag){
		$this->tag  = $tag ;
	}
	
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt  = $createdAt ;
	}
	
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt  = $updatedAt ;
	}
	
	public function setACL($ACL){
		$this->ACL  = $ACL ;
	}

}
?>
