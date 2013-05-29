<?php
/**
 * definizione classe: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:album
 * api: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:album
 * @author Stefano
 *
 * Questa classe si occupa di gestire un ALBUM FOTOGRAFICO - corrisponde ad una riga
 * della tabella Album in Parse
 * 
 */
class Album{

	private $objectId;
	private $active;
	private $commentators;
	private $comments
	private $counter;
	private $cover;	
	private $description;
	private $featuring;
	private $fromUser;	
    private $images;
	private $location;
	private $loveCounter;
	private $lovers;		
	private $tags;	
	private $thumbnailCover;
	private $title;				
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
	
	public function getActive(){
		return $this->active;
	}
	
	public function getCommentators(){
		return $this->commentators;
	}

	public function getComments(){
		return $this->comments;
	}
	
	public function getCover(){		
		return $this->cover;
	}
	
	public function getCounter(){ 
		return $this->counter;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function getFeaturing(){
		return $this->featuring;
	}
	
	public function getFromUser(){
		return $this->fromUser;
	}

	public function getImages(){
		return $this->images;
	}
	
	public function getLocation(){
		return $this->location;
	}
	
	public function getLoveCounter(){
		return $this->loveCounter; 
	}
	
	public function getLovers(){
		return $this->lovers;
	}

	public function getTags(){
		return $this->tags;
	}
	
	public function getThumbnailCover(){
		return $this->thumbnailCover;
	}

	public function getTitle(){
		return $this->title;
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

	public function setObjectId(string $objectId){
		$this->objectId=$objectId ;
	}
	
	public function setActive($active){
		$this->active = $active;
	}
	
	public function setCommentators(Relation $commentators){
		$this->commentators  = $commentators;
	}

	public function setComments(Relation $comments){
		$this->comments  = $comments;
	}
	
	public function setCounter($counter){ 
		$this->counter  = $counter;
	}
	
	public function setCover(string $cover){
		$this->cover  = $cover;
	}
	
	public function setDescription(string $description){
		$this->description  = $description;
	}
	
	public function setFeaturing(Relation $featuring){
		$this->featuring  = $featuring ;
	}
	
	public function setFromUser(User $fromUser){
		$this->fromUser  = $fromUser;
	}

	public function setImages(Relation $images){
		$this->images  = $images; 
	}

	public function setLocation(parseGeoPoint $location){
		$this->location  = $location;
	}
	
	public function setLoveCounter($loveCounter){
		$this->loveCounter  = $loveCounter; 
	}
	
	public function setLovers(Relation $lovers){
		$this->lovers  = $lovers; 
	}
	
	public function setTitle(string $title){
		$this->title  = $title;
	}

	public function setThumbnailCover(string $thumbnailCover){
		$this->thumbnailCover  = $thumbnailCover ;
	}

	public function setTags(array $tags){
		$this->tag  = $tags;
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