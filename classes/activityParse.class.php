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

		//puntatore al fromUser
		//User:Utente che effettua l'azione 												#2
		if( $activity->getFromUser() != null ){

			$user = $activity->getFromUser();

			$parseObj->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
		}

		//puntatore al toUser
        //User:Utente che riceve l'azione 													#3
		if( $activity->getToUser() != null ){

			$user = $activity->getToUser();

			$parseObj->toUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
		}

        //string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto    #4
        $parseObj->status = $activity->getStatus();

		//Stringa type
        //string:Indica la tipologia di attività 											#5
		$parseObj->type = $activity->getType();

       //BOOL:Indica se l'istanza della classe è attiva 									#6
		$parseObj->active = $activity->getActive();

       //BOOL:Indica se l'istanza della classe è stata letta o meno 						#7
		$parseObj->read = $activity->getRead();

       //ACL:access control list, determina le politiche di accesso alla classe 			#10
	   //$parseObj->ACL = $activity->getACL();   //perchè non la prendi?????

		//puntatore allo status
        //Status(Parse Object): Istanza della classe Status associata all'activity 			#11
		if( $activity->getUserStatus() != null ){

			$status = $activity->getUserStatus();

			$parseObj->userStatus = array("__type" => "Pointer", "className" => "Status", "objectId" => $status->getObjectId());

		}

       //puntatore alla song
       //Song (Parse Object): Istanza della classe Song associata all'activity 			#12
		if( $activity->getSong() != null ){
			
			$song = $activity->getSong();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Song", "objectId" => $song->getObjectId());
				

		}
      //puntatore alla song
      //Record (Parse Object): Istanza della classe Record associata all'activity 		#13
		
		if( $activity->getRecord() != null ){
			
			$record = $activity->getRecord();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Record", "objectId" => $record->getObjectId());
				
		
		}
       //puntatore alla comment
      //Comment (Parse Object): Istanza della classe Comment associata all'activity		#14
		
		if( $activity->getComment() != null ){
			
			$comment = $activity->getComment()();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Comment", "objectId" => $comment->getObjectId());
				
		
		}
        //puntatore alla album
		//Album (Parse Object): Istanza della classe Album associata all'activity 			#15
		if( $activity->getAlbum() != null ){
			
			$album = $activity->getAlbum();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Album", "objectId" => $album->getObjectId());
				
		
		}
        //puntatore alla question
        //Question (Parse Object): Istanza della classe Question associata all'activity     #16
        if( $activity->getQuestion() != null ){

			$question = $activity->getQuestion();

			$parseObj->question = array("__type" => "Pointer", "className" => "Question", "objectId" => $question->getObjectId());
		}

       //puntatore alla question
       //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     #17
        if( $activity->getPlaylist() != null ){

			$playlist = $activity->getPlaylist();

			$parseObj->playlist = array("__type" => "Pointer", "className" => "Playlist", "objectId" => $playlist->getObjectId());
		}

		//puntatore all'image
        //Image (Parse Object): Istanza della classe Image associata all'activity           #18	
		if( $activity->getImage() != null ){

			$image = $activity->getImage();

			$parseObj->image = array("__type" => "Pointer", "className" => "Image", "objectId" => $image->getObjectId());
		}

		//puntatore all'evento
		//Event (Parse Object): Istanza della classe Event associata all'activity           #19
		if( $activity->getEvent() != null ){

			$event = $activity->getEvent();

			$parseObj->event = array("__type" => "Pointer", "className" => "Event", "objectId" => $event->getObjectId());
		}
        //Video (Parse Object):Istanza della classe Video associata all'activity            #20
		if( $activity->getVideo() != null ){

			$video = $activity->getVideo();

			$parseObj->video = array("__type" => "Pointer", "className" => "Video", "objectId" => $event->getObjectId());
		}

      //accepted BOOL: da definire																	#21
      $parseObj->accepted = $activity->getAccepted();

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

		//String:objectId su Parse 															#1
		if(isset($parseObj->objectId)) $activity->setObjectId($parseObj->objectId) ;

		//User:Utente che effettua l'azione 												#2
		if(isset($parseObj->fromUser)){
				
			$parseUser = new userParse();
			$parseUser = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($parseUser->objectId);				
			$activity->setFromUser($fromUser);
				
		}

		//User:Utente che riceve l'azione 													#3
		if(isset($parseObj->toUser)){
			$parseUser = new userParse();
			$toUserParse = $parseObj->toUser;
			$toUser = $parseUser->parseToUser($toUserParse->objectId);
			$activity->setToUser($toUser);
		}

 		//string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto    #4
		if(isset($parseObj->stutus)) $activity->setStatus($parseObj->status);

        //string:Indica la tipologia di attività 											#5
		if(isset($parseObj->type)) $activity->setType($parseObj->type);

        //BOOL:Indica se l'istanza della classe è attiva 									#6
		if(isset($parseObj->active)) $activity->setActive($parseObj->active);

		//BOOL:Indica se l'istanza della classe è stata letta o meno 						#7
		if(isset($parseObj->read)) $activity->setRead($parseObj->read);
		
		//DateTime:Data di inserimento attività 											#8
		if(isset($parseObj->createdAt)){
			$createdAt = new DateTime($parseObj->createdAt);
			$activity->setCreatedAt($createdAt);
		}
		
		//DateTime:Data di ultimo update attività 											#9
		if(isset($parseObj->updatedAt)){
			$updatedAt = new DateTime($parseObj->updatedAt);
			$activity->setUpdatedAt($updatedAt);
		}
 
       //ACL:access control list, determina le politiche di accesso alla classe 			#10
		if(isset($parseObj->ACL)){	
			$ACL = null;
			$activity->setACL($ACL);
		}

       //Status(Parse Object): Istanza della classe Status associata all'activity 			#11
		if(isset($parseObj->status)){
			$parseStatus = new StatusParse();
			$parseStatus = $parseObj->userStatus;
			$userStatus  = $parseStatus->parseToStatus($parseStatus->objectId);				
			$activity->setUserStatus($userStatus);
		}

		//Song (Parse Object): Istanza della classe Song associata all'activity 			#12
		if(isset($parseObj->song)){
			$parseSong = new SongParse();
			$parseSong = $parseObj->song;
			$song = $parseSong->getSong($parseSong->objectId);
			$activity->setSong($song);
		}
 
       //Record (Parse Object): Istanza della classe Record associata all'activity 		     #13
		if(isset($parseObj->record)){
			$parseRecord = new RecordParse();
			$parseRecord = $parseObj->record;
			$record = $parseRecord->getRecord($parseRecord->objectId);
			$activity->setRecord($record);
		}

     	//Comment (Parse Object): Istanza della classe Comment associata all'activity		#14
		if(isset($parseObj->comment)){
			$parseComment = new CommentParse();
			$parseComment = $parseObj->comment;
			$comment = $parseComment->getComment($parseComment->objectId);
			$activity->setComment($comment);
		}

	    //Album (Parse Object): Istanza della classe Album associata all'activity 			#15
		if(isset($parseObj->album)){
			$parseAlbum = new AlbumParse();
			$parseAlbum = $parseObj->album;
			$album = $parseAlbum->getAlbum($parseAlbum->objectId);
			$activity->setAlbum($album);
		}
         
        //Question (Parse Object): Istanza della classe Question associata all'activity     #16
		if(isset($parseObj->question)){
			$parseQuestion = new QuestionParse();
			$parseQuestion = $parseObj->question;
			$question = $parseAlbum->getQuestion($parseQuestion->objectId);
			$activity->setQuestion($question);
		}

	    //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     #17
		if(isset($parseObj->playlist)){
			$parsePlaylist = new PlaylistParse();
			$parsePlaylist = $parseObj->playlist;
			$playlist = $parsePlaylist->getQuestion($parsePlaylist->objectId);
			$activity->setPlaylist($playlist);
		}

   		//Image (Parse Object): Istanza della classe Image associata all'activity           #18
		if(isset($parseObj->image)){
			$parseImage = new ImageParse();
			$parseImage = $parseObj->image;
			$image = $parseImage->getImage($parseImage->objectId);
			$activity->setPlaylist($image);
		}

		//Event (Parse Object): Istanza della classe Event associata all'activity           #19
		if(isset($parseObj->event)){
			$parseEvent = new EventParse();
			$parseEvent = $parseObj->event;
			$event = $parseEvent->getEvent($parseEvent->objectId);
			$activity->setEvent($event);
		}

       //Video (Parse Object):Istanza della classe Video associata all'activity            #20
		if(isset($parseObj->video)){
			$parseVideo = new VideoParse();
			$parseVideo = $parseObj->video;
			$video = $parseEvent->getVideo($parseVideo->objectId);
			$activity->setVideo($video);
		} 

 		//accepted BOOL: da definire	
        if(isset($parseObj->accepted)) $activity->setAccepted($parseObj->accepted);

		return $activity;
	}
}