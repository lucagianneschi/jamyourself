<?php
//docuwiki:
//definizione della classe:http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:activity
//api:http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:activity

class Activity{

	private $objectId;		//String:objectId su Parse 															#1
    private $fromUser;		//User:Utente che effettua l'azione 												#2
    private $toUser;		//User:Utente che riceve l'azione 													#3
    private $status;		//string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto    #4
    private $type;			//string:Indica la tipologia di attività 											#5
	private $active;		//BOOL:Indica se l'istanza della classe è attiva 									#6
    private $read;			//BOOL:Indica se l'istanza della classe è stata letta o meno 						#7
	private $createdAt;		//DateTime:Data di inserimento attività 											#8
	private $updatedAt;		//DateTime:Data di ultimo update attività 											#9
    private $ACL;			//ACL:access control list, determina le politiche di accesso alla classe 			#10
    private $userStatus;    //Status(Parse Object): Istanza della classe Status associata all'activity 			#11
    private $song;          //Song (Parse Object): Istanza della classe Song associata all'activity 			#12
    private $record;        //Record (Parse Object): Istanza della classe Record associata all'activity 		#13
    private $comment; 		//Comment (Parse Object): Istanza della classe Comment associata all'activity		#14
	private $album;         //Album (Parse Object): Istanza della classe Album associata all'activity 			#15
    private $question;      //Question (Parse Object): Istanza della classe Question associata all'activity     #16
	private $playlist;      //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     #17
    private $image;			//Image (Parse Object): Istanza della classe Image associata all'activity           #18	
	private $event;			//Event (Parse Object): Istanza della classe Event associata all'activity           #19
    private $video;         //Video (Parse Object):Istanza della classe Video associata all'activity            #20
	private $accepted;      //BOOL: da definire																	#21

	//COSTRUTTORE

	public function __construct(){
	}

	//FUNZIONI SET
	/**
	 *
	 * @param string $objectId	#1
	 */
	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

	/**
	 *
	 * @param User $fromUser	#2
	 */
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}

	/**
	 *
	 * @param User $toUser	#3
	 */
	public function setToUser(User $toUser){
		$this->toUser = $toUser;
	}

	/**
	 *
	 * @param string $status	#4
	 */
	public function setStatus($status){
		$this->objectId = $status;
	}

	/**
	 *
	 * @param string $type	#5
	 */
	public function setType($type){
		$this->type = $type;
	}

	/**
	 *
	 * @param BOOL $active	#6
	 */
	public function setActive($active){
		$this->read = $active;
	}

     /**
	 *
	 * @param BOOL $read	#7
	 */
	public function setRead($read){
		$this->read = $read;
	}

	/**
	 *
	 * @param DateTime $createdAt	#8
	 */
	public function setCreatedAt(DateTime $createdAt){

		$this->createdAt = $createdAt;
	}

	/**
	 *
	 * @param DateTime $updatedAt	#9
	 */
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;

	}

	/**
	 *
	 * @param ACL $ACL	#10
	 */
	public function setACL( $ACL){  //perchè manca il tipo??
		$this->ACL = $ACL;
	}

	/**
	 *
	 * @param Status $status	#11
	 */
	public function setUserStatus(Status $userStatus){
		$this->userStatus = $userStatus;
	}

	/**
	 *
	 * @param Song $song	#12
	 */
	public function setSong(Song $song){
		$this->song = $song;
	}

	/**
	 *
	 * @param Record $record	#13
	 */
	public function setRecord(Record $record){
		$this->record = $record;
	}

	/**
	 *
	 * @param Comment $comment	#14
	 */
	public function setComment(Comment $comment){
		$this->comment = $comment;
	}

	/**
	 *
	 * @param Album $album	#15
	 */
	public function setAlbum(Album $album){
		$this->album = $album;
	}

	/**
	 *
	 * @param Question question	#16
	 */
	public function setQuestion(Question $question){
		$this->question = $question;
    }

	/**
	 *
	 * @param Playlist $playlist	#17
	 */
	public function setPlaylist(Playlist $playlist){
		$this->playlist = $playlist;
    }

	/**
	 *
	 * @param Image $image	#18
	 */
	public function setImage(Image $image){
		$this->image = $image;
	}
	
	/**
	 *
	 * @param Event $event	#19
	 */
	public function setEvent(Event $event){
		$this->event = $event;
	}

	/**
	 *
	 * @param Video $video	#20
	 */
	public function setVideo(Video $video){
		$this->video = $video;
	}

     /**
	 *
	 * @param BOOL $accepted	#21
	 */
	public function setAccepted($accepted){
		$this->accepted = $accepted;
	}


	//FUNZIONI GET
	/**
	 *
	 * @param string $objectId	#1
	 */
	public function getObjectId(){
		return $this->objectId;
	}

	/**
	 *
	 * @param User $fromUser	#2
	 */
	public function getFromUser(){
		return $this->fromUser;
	}
	/**
	 *
	 * @param User $toUser	#3
	 */
	public function getToUser(){
		return $this->toUser;
	}

	/**
	 *
	 * @param string $status	#4
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 *
	 * @param string $type	#5
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 *
	 * @param BOOL $active	#6
	 */
	public function getActive(){
		return $this->active;
	}

     /**
	 *
	 * @param BOOL $read	#7
	 */
	public function getRead(){
		return $this->read;
	}

	/**
	 *
	 * @param DateTime $createdAt	#8
	 */
	public function getCreatedAt(){
		return $this->createdAt;
	}

	/**
	 *
	 * @param DateTime $updatedAt	#9
	 */
	public function getUpdatedAt(){
		return $this->updatedAt;
	}
   
    /**
	 *
	 * @param ACL $ACL	#10
	 */
	public function getACL(){
		return $this->ACL;
	}

	/**
	 *
	 * @param Status $status	#11
	 */
	public function getUserStatus(){
		return $this->userStatus;
	}

	/**
	 *
	 * @param Song $song	#12
	 */
	public function getSong(){
		return $this->song;
	}

	/**
	 *
	 * @param Record $record	#13
	 */
	public function getRecord(){
		return $this->record;
	}
	/**
	 *
	 * @param Comment $comment	#14
	 */
	public function getComment(){
		return $this->comment;
	}

	/**
	 *
	 * @param Album $album	#15
	 */

	public function getAlbum(){
		return $this->album;
	}

	/**
	 *
	 * @param Question $question	#16
	 */

	public function getQuestion(){
		return $this->question;
	}

	/**
	 *
	 * @param Playlist $playlist	#17
	 */
	public function getPlaylist(){
		return $this->playlist;
	}

	/**
	 *
	 * @param Image $image	#18
	 */
	public function getImage(){
		return $this->image;
	}

	/**
	 *
	 * @param Event $event	#19
	 */
	public function getEvent(){
		return $this->event;
	}

	/**
	 *
	 * @param Video $video	#20
	 */
	public function getVideo(){
		return $this->video;
	}

	/**
	 *
	 * @param BOOL $accepted	#21
	 */
	public function getAccepted(){
		return $this->accepted;
	}
}