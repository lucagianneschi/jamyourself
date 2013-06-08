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
			$parseAlbumPointer = $parseObj->album;
			$album = $parseAlbum->getAlbum($parseAlbumPointer->objectId);
			$activity->setAlbum($album);
		}

    	//Comment (Parse Object): Istanza della classe Comment associata all'activity		
		if(isset($parseObj->comment)){
			$parseComment = new CommentParse();
			$parseCommentPointer = $parseObj->comment;
			$comment = $parseComment->getComment($parseCommentPointer->objectId);
			$activity->setComment($comment);
		}

		//User:Utente che effettua l'azione 											
		if(isset($parseObj->fromUser)){	
			$parseUser = new userParse();
			$parseUserPointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($parseUserPointer->objectId);				
			$activity->setFromUser($fromUser);	
		}

		//Event (Parse Object): Istanza della classe Event associata all'activity           
		if(isset($parseObj->event)){
			$parseEvent = new EventParse();
			$parseEventPointer = $parseObj->event;
			$event = $parseEvent->getEvent($parseEventPointer->objectId);
			$activity->setEvent($event);
		}

   		//Image (Parse Object): Istanza della classe Image associata all'activity           
		if(isset($parseObj->image)){
			$parseImage = new ImageParse();
			$parseImagePointer = $parseObj->image;
			$image = $parseImage->getImage($parseImagePointer->objectId);
			$activity->setImage($image);
		}

	    //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     
		if(isset($parseObj->playlist)){
			$parsePlaylist = new PlaylistParse();
			$parsePlaylistPointer = $parseObj->playlist;
			$playlist = $parsePlaylist->getQuestion($parsePlaylistPointer->objectId);
			$activity->setPlaylist($playlist);
		}

        //Question (Parse Object): Istanza della classe Question associata all'activity     
		if(isset($parseObj->question)){
			$parseQuestion = new QuestionParse();
			$parseQuestionPointer = $parseObj->question;
			$question = $parseQuestion->getQuestion($parseQuestionPointer->objectId);
			$activity->setQuestion($question);
		}

		//BOOL:Indica se l'istanza della classe è stata letta o meno 						
		if(isset($parseObj->read)) $activity->setRead($parseObj->read);

       //Record (Parse Object): Istanza della classe Record associata all'activity 		     
		if(isset($parseObj->record)){
			$parseRecord = new RecordParse();
			$parseRecordPointer = $parseObj->record;
			$record = $parseRecord->getRecord($parseRecordPointer->objectId);
			$activity->setRecord($record);
		}

 		//Song (Parse Object): Istanza della classe Song associata all'activity 			
		if(isset($parseObj->song)){
			$parseSong = new SongParse();
			$parseSongPointer = $parseObj->song;
			$song = $parseSong->getSong($parseSongPointer->objectId);
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
			$parseUserStatusPointer = $parseObj->userStatus;
			$userStatus  = $parseUserStatus->parseToStatus($parseUserStatusPointer->objectId);				
			$activity->setUserStatus($userStatus);
		}


        //Video (Parse Object):Istanza della classe Video associata all'activity            
		if(isset($parseObj->video)){
			$parseVideo = new VideoParse();
			$parseVideoPointer = $parseObj->video;
			$video = $parseVideo->getVideo($parseVideoPointer->objectId);
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
        
        /** 
         * Conta il numero di activity di tipo MESSAGESENT che 
         * hanno come toUser il currentUser e che hanno la property READ a NO
         * 
         * @param User $user
         * @return null|array
         */
        public function getUnreadMessagesActivities(User $user){
            
            $activities = array();
            
            //preparo le clausole WHERE
            $this->parseQuery->where("type", "MESSAGESENT");
            $this->parseQuery->wherePointer("toUser", "_User", $user->getObjectId());
            $this->parseQuery->where("read", false);
            
            //eseguo la query
            $result = $this->parseQuery->find();

            if (is_array($result->results) && count($result->results)>0){
               
                foreach($result->results as $activityObject){
                    
                  if( ($activity = $this->parseToActivity($activityObject)) != null ){
                      
                      array_push($activities, $activity);
                      
                  } 
                  
                }

            }
            
            return $activities;
            
        }
        
        /**
         * recupera l'activity di tipo MESSAGESENT che abbia come toUser il 
         * currentUser (utente loggato proprietario della pagina) e mostra a 
         * video la property username del fromUser della Activity nella forma 
         * "Username sent you a message " Es. "pippo sent you a message"
         * 
         * @param type $param
         */
        public function functionName($param) {
            
        }
        
//conta il numero di activity di tipo LOVED che abbiano come toUser il 
//currentUser (utente loggato proprietario della pagina) e che abbiamo la 
//property READ a No + Conta il numero di activity di tipo COMMENTED che abbiano 
//come toUser il currentUser (utente loggato proprietario 
//della pagina) e che abbiamo la property READ a No. Somma i due risultati 
//(che saranno mostrati come numero complessivo nella notifica)
    public function countUncheckedLOVED(User $user){

        $total = 0;

        //preparo le clausole WHERE
        $this->parseQuery->where("type", "DEFAULTRECORDCREATED");
//        $this->parseQuery->where("type", "LOVED");
        $this->parseQuery->wherePointer("fromUser", "_User", $user->getObjectId());
//        $this->parseQuery->where("read", false);
        $this->parseQuery->where("read", true);

        //eseguo la query
        $result = $this->parseQuery->getCount();
        
        return $result;
            
        }        
        
//recupera l'activity di tipo LOVED che abbia come toUser il currentUser (utente loggato proprietario della pagina) + Recupera l'activity di tipo 
//COMMENTED che abbia come toUser il currentUser (utente loggato proprietario della pagina). Metti i due Array in fila e ordinali in base alla 
//property createdAt che ha ogni oggetto contenuto all'interno della Array. Per ogni elemento della Array mostra a video: 1) se l'activity LOVED 
//o COMMENTED è riferita a un album (Property Activity "album" non null) mostra username del fromUser LOVED o COMMENTED ON property 
//"album: title" Es. "Pippo loved Album: default_album" Es. "Pippo commented on Album: default_album" 2) se l'activity LOVED o 
//COMMENTED è riferita a un comment (Property Activity "comment" non null) e fai un check sulla property type di quel comment: a) se è di 
//tipo M non scrivere niente b) se è di tipo P mostra username del fromUser della Activity LOVED o COMMENTED e mostra nella forma Es. 
//"Pippo loved your post" Es. "Pippo commented on your post" c) se è tipo R mostra username del fromUser della Activity LOVED o 
//COMMENTED e mostra nella forma Es. "Pippo loved your review" Es. "Pippo commented on your review" d) se è tipo C mostra username del 
//fromUser della Activity LOVED o COMMENTED e mostra nella forma Es. "Pippo commented on your comment" Es. "Pippo loved your 
//comment" 3) se l'activity LOVED o COMMENT è riferita a un Event (Property Activity "event" non null) mostra username del fromUser LOVED 
//o COMMENTED ON property "event: title" Es. "Pippo loved event: title_event" Es. "Pippo commented on event: title_event 4) se l'activity 
//LOVED o COMMENTED è riferita a una image (Property Activity "image" non null) mostra username del fromUser della Activity LOVED o 
//COMMENTED e mostra nella forma Es. "Pippo loved your image" Es. "Pippo commented on your image" 5) se l'activity LOVED o COMMENTED 
//è riferita a un record (Property Activity "record" non null) mostra username del fromUser LOVED o COMMENTED ON property "record:title" 
//Es. "Pippo loved record: title_record" Es. "Pippo commented on record: title_record" 6) se l'activity LOVED o COMMENTED è riferita a una 
//songmostra (Property Activity "song" non null) mostra username del fromUser LOVED o COMMENTED ON property "song:title" Es. "Pippo 
//loved song: title_song" Es. "Pippo commented on song: title_song" 7) se l'activity LOVED o COMMENTED è riferita a uno status (Property 
//Activity "status" non null) mostra username del fromUser della Activity LOVED o COMMENTED e mostra nella forma Es. "Pippo loved your 
//status" Es. "Pippo commented on your status"
  
        
//conta il numero di activity di tipo INVITED che abbiamo come 
//toUser il currentUser (utente loggato proprietario della pagina) e che abbiano 
//la property READ a No.
        
//recupera le activity di tipo INVITED che abbiamo come toUser il 
//currentUser (utente loggato proprietario della pagina). Per ciascuna delle 
//activity trovate mostra la forma Username invited on event:title_event 
//Es. "pippo invited you on event:title_event"
        
//check sulla property type del currentUser :1)CASO SPOTTER:Numero Richieste 
//amicizia ricevute e accettate (relazione SPOTTER-SPOTTER): 
//conta il numero di activity di tipo FRIENDREQUEST che abbiano come 
//toUser il currentUser e il cui status sia W e la property READ a No + 
//conta le activity di tipo FRIENDREQUEST in cui il currentUser è il 
//fromUser, property READ a No, e status ad A. Mostra a video la somma dei 
//due risultati. 2) CASO JAMMER &VENUE: Numero Richieste collaborazione ricevute 
//e accettate + Following Spotter: conta il numero di 
//activity di tipo COLLABORATIONREQUEST che abbiano come toUser il currentUser e 
//il cui status sia W e la property READ a No + conta le 
//activity di tipo COLLABORATIONREQUEST in cui il currentUser è il fromUser, 
//property READ a No, e status ad A + conta il numero di activity di 
//tipo FOLLOWING che hanno come toUser il currentUser e la cui property READ a 
//No. Mostra a video la somma dei due risultati.
        
}
?>
