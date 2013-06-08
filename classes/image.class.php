<?php
/*! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Image
 *  \details   Classe per la singola immagine caricata dall'utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:image">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:image">API</a>
 */

class Image{ 
    private $objectId;
    private $active;
    private $comments;
    private $fromUser;
    private $description;
    private $album;
    private $filePath;
    private $location;
    private $featuring;
    private $tags;
    private $counter;
    private $loveCounter;  //contatore per tenere conto delle sole attività di love
    private $createdAt;
    private $updatedAt;
    private $ACL;
	
	
	//costruttore
	public function __construct(){
		
	}
	
	//setters
	public function setOjectId($objectId){
		$this->objectId = $objectId;	
	}


	public function setComments(array $comments){
		$this->counter = $comments;
	}

	public function setCounter($counter){
		$this->counter = $counter;
	}
	public function setLoveCounter($loveCounter){
		$this->loveCounter = $loveCounter;
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
	
	public function setAlbum(Album $album){
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
	
	
	public function setTags(array $tags){
		$this->tags = $tags;
	}

	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;	
	}
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;	
	}
	public function setACL(parseACL $ACL){
		$this->ACL = $ACL ;	
	}
	
	//getters
	public function getObjectId(){
		return $this->objectId;	
	}

	public function getComments(){
		return $this->comments;
	}

	public function getCounter(){
		return $this->counter;
	}

	public function getLoveCounter(){
		return $this->loveCounter;
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
	
	public function getTags(){
		return $this->tags ;
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
}
?>
