<?php
/**
 * 
 * @author Stefano
 *
 * Questa classe si occupa di gestire un "record" cioè un ALBUM MUSICALE
 * Il Db corrispondente è Record
 * 
 */
class Record{

	private $objectId;
	
	private $fromUser;		//autore
	private $active;		//attiva?
	private $title;			//titolo
	private $date;			//data (de che??)
	private $description;	//descrizione
	private $location;		//location
	private $cover;			//cpver
	private $thumbnailCover;//thumbnailCover
	private $featuring;		//featuring
	private $keywords;		//parole chiave
	
	private $createdAt;
	private $updatedAt;
	private $ACL;



	public function __construct(){

	}


	//getters
	public function getObjectId(){return $this->objectId;  }

	public function getFromUser(){ return $this->fromUser  ; }		
	public function getActive(){ return $this->active  ; }		
	public function getTitle(){ return $this->title  ; }		
	public function getDate(){ return $this->date  ; }	
	public function getDescription(){ return $this->description  ; }	
	public function getLocation(){ return $this->location  ; }		
	public function getCover(){ return $this->cover  ; }			
	public function getThumbnailCover(){ return $this->thumbnailCover  ; }
	public function getFeaturing(){ return $this->featuring  ; }		
	public function getKeywords(){ return $this->keywords  ; }		

	public function getCreatedAt(){ return $this->createdAt; }
	public function getUpdatedAt(){ return $this->updatedAt; }
	public function getACL(){return $this->ACL;  }

	//setters
	public function setObjectId($objectId){$this->objectId = $objectId;  }

	public function setFromUser(User $fromUser){ $this->fromUser  = $fromUser  ; }		
	public function setActive($active){ $this->active  = $active ; }		
	public function setTitle($title){ $this->title = $title ; }			
	public function setDate(DateTime $date){ $this->date = $date ; }
	public function setDescription($description){ $this->description  = $description ; }	
	public function setLocation(parseGeoPoint $location){ $this->location  = $location ; }		
	public function setCover($cover){ $this->cover  = $cover ; }			
	public function setThumbnailCover($thumbnailCover){ $this->thumbnailCover  = $thumbnailCover ; }
	public function setFeaturing(array $featuring){ $this->featuring  = $featuring ; }		
	public function setKeywords(array $keywords){ $this->keywords  = $keywords ; }	
	
	public function setCreatedAt(DateTime $createdAt){$this->createdAt = $createdAt;  }
	public function setUpdatedAt(DateTime $updatedAt){$this->updatedAt = $updatedAt;  }
	public function setACL($ACL){ $this->ACL = ACL; }
}