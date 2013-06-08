<?php
/*! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Playslist
 *  \details   Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:activity">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:activity">API</a>
 */


class Activity{

    private $objectId;  //String:objectId su Parse 															
    private $accepted;      //BOOL: da definire																	
    private $active;  //BOOL:Indica se l'istanza della classe è attiva 									
    private $album;         //Album (Parse Object): Istanza della classe Album associata all'activity 			
    private $comment;   //Comment (Parse Object): Istanza della classe Comment associata all'activity		
    private $event;   //Event (Parse Object): Istanza della classe Event associata all'activity           
    private $fromUser;  //User:Utente che effettua l'azione 												
    private $image;   //Image (Parse Object): Istanza della classe Image associata all'activity           	
    private $playlist;      //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     
    private $question;      //Question (Parse Object): Istanza della classe Question associata all'activity 
    private $read;   //BOOL:Indica se l'istanza della classe è stata letta o meno 						
    private $record;        //Record (Parse Object): Istanza della classe Record associata all'activity
    private $song;          //Song (Parse Object): Istanza della classe Song associata all'activity
    private $status;  //string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto
    private $toUser;  //User:Utente che riceve l'azione 												
    private $type;   //string:Indica la tipologia di attività 											
    private $userStatus;    //Status(Parse Object): Istanza della classe Status associata all'activity 			
    private $video;         //Video (Parse Object):Istanza della classe Video associata all'activity            
    private $createdAt;  //DateTime:Data di inserimento attività 											
    private $updatedAt;  //DateTime:Data di ultimo update attività 											
    private $ACL;   //ACL:access control list, determina le politiche di accesso alla classe 			

	//COSTRUTTORE

	public function __construct(){
	}

	//FUNZIONI SET
	/**
	 *
	 * @param string $objectId	
	 */
	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

     /**
	 *
	 * @param BOOL $accepted	
	 */
	public function setAccepted($accepted){
		$this->accepted = $accepted;
	}

	/**
	 *
	 * @param BOOL $active	
	 */
	public function setActive($active){
		$this->read = $active;
	}

	/**
	 *
	 * @param Album $album	
	 */
	public function setAlbum(Album $album){
		$this->album = $album;
	}

	/**
	 *
	 * @param Comment $comment	
	 */
	public function setComment(Comment $comment){
		$this->comment = $comment;
	}

	/**
	 *
	 * @param Event $event	
	 */
	public function setEvent(Event $event){
		$this->event = $event;
	}

	/**
	 *
	 * @param User $fromUser	
	 */
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	/**
	 *
	 * @param Image $image	
	 */
	public function setImage(Image $image){
		$this->image = $image;
	}

	/**
	 *
	 * @param Playlist $playlist	
	 */
	public function setPlaylist(Playlist $playlist){
		$this->playlist = $playlist;
    }

	/**
	 *
	 * @param Question question	
	 */
	public function setQuestion(Question $question){
		$this->question = $question;
    }

     /**
	 *
	 * @param BOOL $read	
	 */
	public function setRead($read){
		$this->read = $read;
	}

	/**
	 *
	 * @param Record $record	
	 */
	public function setRecord(Record $record){
		$this->record = $record;
	}


	/**
	 *
	 * @param string $status	
	 */
	public function setStatus($status){
		$this->status = $status;
	}

	/**
	 *
	 * @param Song $song	
	 */
	public function setSong(Song $song){
		$this->song = $song;
	}

	/**
	 *
	 * @param User $toUser	
	 */
	public function setToUser(User $toUser){
		$this->toUser = $toUser;
	}

	/**
	 *
	 * @param string $type	
	 */
	public function setType($type){
		$this->type = $type;
	}

	/**
	 *
	 * @param Status $status	
	 */
	public function setUserStatus(Status $userStatus){
		$this->userStatus = $userStatus;
	}

	/**
	 *
	 * @param Video $video	
	 */
	public function setVideo(Video $video){
		$this->video = $video;
	}

	/**
	 *
	 * @param DateTime $createdAt	
	 */
	public function setCreatedAt(DateTime $createdAt){

		$this->createdAt = $createdAt;
	}

	/**
	 *
	 * @param DateTime $updatedAt	
	 */
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;

	}

	/**
	 *
	 * @param ACL $ACL	
	 */
	public function setACL(parseACL $ACL){  
		$this->ACL = $ACL;
	}

	//FUNZIONI GET
	/**
	 *
	 * @param string $objectId	
	 */
	public function getObjectId(){
		return $this->objectId;
	}

	/**
	 *
	 * @param BOOL $active	
	 */
	public function getActive(){
		return $this->active;
	}

	/**
	 *
	 * @param BOOL $accepted	
	 */
	public function getAccepted(){
		return $this->accepted;
	}

	/**
	 *
	 * @param Album $album	
	 */

	public function getAlbum(){
		return $this->album;
	}

	/**
	 *
	 * @param Comment $comment	
	 */
	public function getComment(){
		return $this->comment;
	}

	/**
	 *
	 * @param Event $event	
	 */
	public function getEvent(){
		return $this->event;
	}

	/**
	 *
	 * @param User $fromUser	
	 */
	public function getFromUser(){
		return $this->fromUser;
	}

	/**
	 *
	 * @param Image $image	
	 */
	public function getImage(){
		return $this->image;
	}

	/**
	 *
	 * @param Playlist $playlist	
	 */
	public function getPlaylist(){
		return $this->playlist;
	}

	/**
	 *
	 * @param Question $question	
	 */

	public function getQuestion(){
		return $this->question;
	}

     /**
	 *
	 * @param BOOL $read	
	 */
	public function getRead(){
		return $this->read;
	}

	/**
	 *
	 * @param string $status	
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 *
	 * @param Record $record	
	 */
	public function getRecord(){
		return $this->record;
	}

	/**
	 *
	 * @param Song $song	
	 */
	public function getSong(){
		return $this->song;
	}

	/**
	 *
	 * @param User $toUser
	 */
	public function getToUser(){
		return $this->toUser;
	}

	/**
	 *
	 * @param string $type	
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 *
	 * @param Status $status	
	 */
	public function getUserStatus(){
		return $this->userStatus;
	}

	/**
	 *
	 * @param Video $video	
	 */
	public function getVideo(){
		return $this->video;
	}

	/**
	 *
	 * @param DateTime $createdAt	
	 */
	public function getCreatedAt(){
		return $this->createdAt;
	}

	/**
	 *
	 * @param DateTime $updatedAt	
	 */
	public function getUpdatedAt(){
		return $this->updatedAt;
	}
   
    /**
	 *
	 * @param ACL $ACL	
	 */
	public function getACL(){
		return $this->ACL;
	}
}
?>
