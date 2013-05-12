<?php

class Video{

	private $objectId;
	private $createdAt;
	private $updatedAt;
	private $active;
	private $URL;	
	private $uploader;
	private $author;
	private $title;
	private $description;
	private $thumbnail;
	private $tags;
	private $duration;
	private $counter;
	private $featuring;
	private $ACL;


	public function __construct(){
	}

	/** FUNZIONI GET */

	public function getCounter(){

		return $this->counter;

	}

	public function getObjectId(){

		return $this->objectId;

	}

	
	public function getActive(){
		return $this->active;
	}
	
	public function getURL(){

		return $this->URL;

	}

	public function getUploader(){

		return $this->uploader;

	}
	
	public function getAuthor(){

		return $this->author;

	}

	public function getTitle(){

		return $this->title;

	}

	public function getDescription(){

		return $this->description;

	}

	public function getThumbnail(){

		return $this->thumbnail;


	}

	public function getTags(){

		return $this->tags;

	}

	public function getDuration(){

		return $this->duration;

	}

	public function getFeaturing(){

		return $this->featuring;

	}

	public function getCreatedAt(){

		return $this->createdAt;

	}

	public function getUpdatedAt(){

		return $this->updatedAt;

	}

	/** FUNZIONI SET */
	
	public function setURL($URL){
	
		$this->URL = $URL;
	
	}
	
	public function setACL($ACL){
		$this->ACL = ACL;
	}

	public function setUploader(User $uploader){

		$this->uploader = $uploader;

	}

	public function setAuthor($author){

		$this->author = $author;

	}

	public function setTitle($title){

		$this->title = $title;
	}

	public function setDescription($description){

		$this->description = $description;

	}

	public function setThumbnail($thubmnail){

		$this->thumbnail = $thubmnail;
	}

	public function setActive($active){
		$this->active = $active;
	}
	
	public function setTags($tags){

		$this->tags = $tags;

	}

	public function setDuration($duration){

		$this->duration = $duration;

	}

	public function setFeaturing(array $featuring){

		$this->featuring = $featuring;
	}

	public function setObjectId($objecId){

		$this->objectId = $objecId;

	}

	public function setCreatedAt(DateTime $createdAt){

		$this->createdAt = $createdAt;

	}

	public function setCounter($counter){
		
		$this->counter = $counter;
		
	}
	
	public function setUpdatedAt(DateTime $updatedAt){

		$this->updatedAt = $updatedAt;

	}
}

?>