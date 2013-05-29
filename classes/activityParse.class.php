<?php

class ActivityParse {

	private $parseQuery;

	public function __construct() {

		$this->parseQuery = new ParseQuery("Activity");

	}

	/**
	 * Salva un Activity nel DB di parse
	 * @param Activity $activity
	 */
	public function save(Activity $activity){

	   //creo un'istanza dell'oggetto della libreria ParseLib
	   $parseObj = new parseObject("Activity");

		//inizializzo le properties

       //accepted BOOL: da definire																	
       $parseObj->accepted = $activity->getAccepted();

       //BOOL:Indica se l'istanza della classe è attiva 									
		$parseObj->active = $activity->getActive();

        //puntatore alla album
		//Album (Parse Object): Istanza della classe Album associata all'activity 			
		if( $activity->getAlbum() != null ){
			$album = $activity->getAlbum();
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Album", "objectId" => $album->getObjectId());
		}

       //puntatore alla comment
       //Comment (Parse Object): Istanza della classe Comment associata all'activity		
		
		if( $activity->getComment() != null ){
			$comment = $activity->getComment();
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Comment", "objectId" => $comment->getObjectId());
		}

		//puntatore al fromUser
		//User:Utente che effettua l'azione 												
		if( $activity->getFromUser() != null ){
			$user = $activity->getFromUser();
			$parseObj->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
		}

		//puntatore all'evento
		//Event (Parse Object): Istanza della classe Event associata all'activity           
		if( $activity->getEvent() != null ){
			$event = $activity->getEvent();
			$parseObj->event = array("__type" => "Pointer", "className" => "Event", "objectId" => $event->getObjectId());
		}

		//puntatore all'image
        //Image (Parse Object): Istanza della classe Image associata all'activity           
		if( $activity->getImage() != null ){
			$image = $activity->getImage();
			$parseObj->image = array("__type" => "Pointer", "className" => "Image", "objectId" => $image->getObjectId());
		}

       //puntatore alla question
       //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     
        if( $activity->getPlaylist() != null ){
			$playlist = $activity->getPlaylist();
			$parseObj->playlist = array("__type" => "Pointer", "className" => "Playlist", "objectId" => $playlist->getObjectId());
		}

        //puntatore alla question
        //Question (Parse Object): Istanza della classe Question associata all'activity     
        if( $activity->getQuestion() != null ){
			$question = $activity->getQuestion();
			$parseObj->question = array("__type" => "Pointer", "className" => "Question", "objectId" => $question->getObjectId());
		}


        //BOOL:Indica se l'istanza della classe è stata letta o meno 						
		$parseObj->read = $activity->getRead();

        //puntatore alla song
        //Record (Parse Object): Istanza della classe Record associata all'activity 		
		if( $activity->getRecord() != null ){
			$record = $activity->getRecord();
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Record", "objectId" => $record->getObjectId());
		}

        //puntatore alla song
        //Song (Parse Object): Istanza della classe Song associata all'activity 			
		if( $activity->getSong() != null ){
			$song = $activity->getSong();
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Song", "objectId" => $song->getObjectId());
		}
        //string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto    
        $parseObj->status = $activity->getStatus();

		//puntatore al toUser
        //User:Utente che riceve l'azione 													
		if( $activity->getToUser() != null ){
			$user = $activity->getToUser();
			$parseObj->toUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
		}

		//Stringa type
        //string:Indica la tipologia di attività 											
		$parseObj->type = $activity->getType();

       //ACL:access control list, determina le politiche di accesso alla classe 			
	   //$parseObj->ACL = $activity->getACL();   //perchè non la prendi?????

		//puntatore allo stato
        //Status(Parse Object): Istanza della classe Status associata all'activity 			
		if( $activity->getUserStatus() != null ){
			$status = $activity->getUserStatus();
			$parseObj->userStatus = array("__type" => "Pointer", "className" => "Status", "objectId" => $status->getObjectId());
		}

        //Video (Parse Object):Istanza della classe Video associata all'activity            
		if( $activity->getVideo() != null ){
			$video = $activity->getVideo();
			$parseObj->video = array("__type" => "Pointer", "className" => "Video", "objectId" => $video->getObjectId());
		}

		//caso update
		if( $activity->getObjectId()!=null ){

			try{
				$ret = $parseObj->update($activity->getObjectId());

				$event->setObjectId($activity->objectId);

				$event->setUpdatedAt($activity->createdAt);

				$event->setCreatedAt($activity->createdAt);
			}
			catch(ParseLibraryException $e){

				return false;

			}

		}
		else{
			//caso save
			try{
				$ret = $parseObj->save();

				$activity->setUpdatedAt($ret->updatedAt);

			}
			catch(ParseLibraryException $e){

				return false;

			}

		}

		return $activity;

	}
	
	/**
	 * 
	 * @param string $activityId
	 * @return boolean|Activity
	 */
	public function getActivity($activityId){
		
		$activity = false;
		
		$this->parseQuery->where('objectId', $activityId);
		
		$result = $this->parseQuery->find();

		if (is_array($result->results) && count($result->results)>0){

			$ret = $result->results[0];

			if($ret){

				//recupero l'utente
				$activity = $this->parseToActivity($ret);

			}

		}
		
		return $activity;
	}

	/**
	 * 
	 * @param stdClass $parseObj
	 * @return boolean|Activity
	 */
	public function parseToActivity(stdClass $parseObj){

		if($parseObj == null) return false;

		$activity = new activity(); //

		//String:objectId su Parse 															
		if(isset($parseObj->objectId)) $activity->setObjectId($parseObj->objectId);

        //BOOL:Indica se l'istanza della classe è attiva 									
		if(isset($parseObj->active)) $activity->setActive($parseObj->active);

		//accepted BOOL: da definire	
        if(isset($parseObj->accepted)) $activity->setAccepted($parseObj->accepted);

	    //Album (Parse Object): Istanza della classe Album associata all'activity 			
		if(isset($parseObj->album)){
			$parseAlbum = new AlbumParse();
			$parseAlbum = $parseObj->album;
			$album = $parseAlbum->getAlbum($parseAlbum->objectId);
			$activity->setAlbum($album);
		}

    	//Comment (Parse Object): Istanza della classe Comment associata all'activity		
		if(isset($parseObj->comment)){
			$parseComment = new CommentParse();
			$parseComment = $parseObj->comment;
			$comment = $parseComment->getComment($parseComment->objectId);
			$activity->setComment($comment);
		}

		//User:Utente che effettua l'azione 											
		if(isset($parseObj->fromUser)){	
			$parseUser = new userParse();
			$parseUser = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($parseUser->objectId);				
			$activity->setFromUser($fromUser);	
		}

		//Event (Parse Object): Istanza della classe Event associata all'activity           
		if(isset($parseObj->event)){
			$parseEvent = new EventParse();
			$parseEvent = $parseObj->event;
			$event = $parseEvent->getEvent($parseEvent->objectId);
			$activity->setEvent($event);
		}

   		//Image (Parse Object): Istanza della classe Image associata all'activity           
		if(isset($parseObj->image)){
			$parseImage = new ImageParse();
			$parseImage = $parseObj->image;
			$image = $parseImage->getImage($parseImage->objectId);
			$activity->setImage($image);
		}

	    //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     
		if(isset($parseObj->playlist)){
			$parsePlaylist = new PlaylistParse();
			$parsePlaylist = $parseObj->playlist;
			$playlist = $parsePlaylist->getQuestion($parsePlaylist->objectId);
			$activity->setPlaylist($playlist);
		}

        //Question (Parse Object): Istanza della classe Question associata all'activity     
		if(isset($parseObj->question)){
			$parseQuestion = new QuestionParse();
			$parseQuestion = $parseObj->question;
			$question = $parseQuestion->getQuestion($parseQuestion->objectId);
			$activity->setQuestion($question);
		}

		//BOOL:Indica se l'istanza della classe è stata letta o meno 						
		if(isset($parseObj->read)) $activity->setRead($parseObj->read);

       //Record (Parse Object): Istanza della classe Record associata all'activity 		     
		if(isset($parseObj->record)){
			$parseRecord = new RecordParse();
			$parseRecord = $parseObj->record;
			$record = $parseRecord->getRecord($parseRecord->objectId);
			$activity->setRecord($record);
		}

 		//Song (Parse Object): Istanza della classe Song associata all'activity 			
		if(isset($parseObj->song)){
			$parseSong = new SongParse();
			$parseSong = $parseObj->song;
			$song = $parseSong->getSong($parseSong->objectId);
			$activity->setSong($song);
		}

 		//string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto   
		if(isset($parseObj->stutus)) $activity->setStatus($parseObj->status);

		//User:Utente che riceve l'azione 													
		if(isset($parseObj->toUser)){
			$parseUser = new userParse();
			$toUserParse = $parseObj->toUser;
			$toUser = $parseUser->parseToUser($toUserParse->objectId);
			$activity->setToUser($toUser);
		}

        //string:Indica la tipologia di attività 											
		if(isset($parseObj->type)) $activity->setType($parseObj->type);

       //Status(Parse Object): Istanza della classe Status associata all'activity 			
		if(isset($parseObj->userStatus)){
			$parseUserStatus = new StatusParse();
			$parseUserStatus = $parseObj->userStatus;
			$userStatus  = $parseUserStatus->parseToStatus($parseUserStatus->objectId);				
			$activity->setUserStatus($userStatus);
		}


        //Video (Parse Object):Istanza della classe Video associata all'activity            
		if(isset($parseObj->video)){
			$parseVideo = new VideoParse();
			$parseVideo = $parseObj->video;
			$video = $parseVideo->getVideo($parseVideo->objectId);
			$activity->setVideo($video);
		} 

		//DateTime:Data di inserimento attività 											
		if(isset($parseObj->createdAt)){
			$createdAt = new DateTime($parseObj->createdAt);
			$activity->setCreatedAt($createdAt);
		}
		
		//DateTime:Data di ultimo update attività 											
		if(isset($parseObj->updatedAt)){
			$updatedAt = new DateTime($parseObj->updatedAt);
			$activity->setUpdatedAt($updatedAt);
		}
 
       //ACL:access control list, determina le politiche di accesso alla classe 			
		if(isset($parseObj->ACL)){	
			$ACL = null;
			$activity->setACL($ACL);
		}
		return $activity;
	}
}
?>
