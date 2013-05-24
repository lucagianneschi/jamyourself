<?php

class VideoParse{
	
	
	private $parseQuery;
	
	public function __construct() {
	
		$this->parseQuery = new ParseQuery("Video");
	
	}
	
	/**
	 * Salva un oggetto Video
	 * 
	 * @param Video $video
	 * @return boolean|Video
	 */
	public function save(Video $video){
		
		$parse = new parseObject("Video");
		$parse->active = $video->getActive();
		$parse->author = $video->getAuthor();
		$parse->counter = $video->getCounter();
		$parse->description = $video->getDescription();
		$parse->duration = $video->getDuration();
		$parse->fromUser = $video->getFromUser();
		if( ( $fromUser = $video->getFromUser() ) != null ) {
			$parse->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $fromUser->getObjectId() );			
		}
		$parse->featuring = array();
		foreach($video->getFeaturing() as $user){
			array_push($parse->featuring, $user);
		}
		$parse->loveCounter = $video->getLoveCounter();
		$parse->tags = $video->getTags();
		$parse->title = $video->getTitle();
		$parse->thumbnail = $video->getThumbnail();
		$parse->URL = $video->getURL();
		
		//$parse->ACL = $video->getACL();  //perchè non lo setti??

		//se esiste l'objectId vuol dire che devo aggiornare
		//se non esiste vuol dire che devo salvare
		if(( $video->getObjectId())!=null ){
			//update
			try{
				//update
				$result = $parse->update($video->getObjectId());
				
				//aggiorno l'update
				$video->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
					
			}
			catch(ParseLibraryException $e){
				return false;
			}
		}else{
			try{
				//salvo
				$result = $parse->save();

				//aggiorno i dati per la creazione
				$video->setObjectId($result->objectId);
				$video->setCreatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
				$video->setUpdatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
			}
			catch(ParseLibraryException $e){

				return false;

			}

		}

		//restituisco video aggiornato
		return $video;
	}

	/**
	 * La cancellazione prevede che il video venga impostato inattivo
	 * @param Video $video il video da cancellare
	 */
	public function delete(Video $video){
		$video->setActive(false);
		$this->save($video);
	}

	/**
	 * Restituisce un oggetto Video a partire dall'id
	 * @param String $videoId
	 * @return Video
	 */
	public function getVideo($videoId){
	
		$video = new Video();
			
		$parseVideo = new parseObject("Video");
	
		$res = $parseVideo->get($videoId);
	
		$status = $this->parseToVideo($res);
	
		return $video;
	}
	
	
	/**
	 * Restituisce i video caricati dall'utente (con un limit = 100 video come di default ) 
	 * @param User $user
	 * @return Ambigous <multitype:, NULL>
	 */
	public function getVideoByUser(User $user){
	
		$list = null;
			
		$this->parseQuery->wherePointer('fromUser','_User', $user->getObjectId());
	
		$return = $this->parseQuery->find();
	
		if (is_array($return->results) && count($return->results)>0){
	
			$list = array();
	
			foreach ($return->results as $result) {
					
				array_push($list, $this->parseToStatus($result));
	
			}
		}
		return $list;
	}
	
/**
 * Converte una riga della tabella Video in un oggetto della classe Video
 * @param stdClass $parseObj
 * @return Video
 */	
	function parseToVideo(stdClass $parseObj){
		
		$video = new Video();
		//recupero objectId
		if(isset($parseObj->objectId))$video->setObjectId($parseObj->objectId);
		 
		//boolean active		
		if(isset($parseObj->active))  $video->setActive($parseObj->active);
		
		//string author
		if(isset($parseObj->author))  $video->setAuthor($parseObj->author);

		//integer counter
		if(isset($parseObj->counter))  $video->setCounter($parseObj->counter);

		//string description
		if(isset($parseObj->description))  $video->setDescription($parseObj->description);

		//integer duration
		if(isset($parseObj->duration))  $video->setDuration($parseObj->duration);

		//array di id
		if(isset($parseObj->featuring)){
			$parseUser = new UserParse();
			$featuring = $parseUser->getUserArrayById($parseObj->featuring);
			$video->setFeaturing($featuring) ;
		}

		//Pointer fromUser
		if(isset($parseObj->fromUser)){
			$parseUser = new UserParse();
			$userPointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($userPointer->objectId);
			$video->setfromUser($fromUser);
		}

		//integer counter
		if(isset($parseObj->loveCounter))  $video->setLoveCounter($parseObj->loveCounter) ;

		//array di stringhe tags
		if(isset($parseObj->tags))  $video->setTags($parseObj->parseObj->tags);
		
		//string title
		if(isset($parseObj->title))  $video->setTitle($parseObj->title);
		
		//string thumbnail
		if(isset($parseObj->thumbnail))  $video->setThumbnail($parseObj->thumbnail);
			
		//string URL
		if(isset($parseObj->URL)) $video->setURL($parseObj->URL);

		//creo la data di tipo DateTime per createdAt e updatedAt
		if(isset($parseObj->createdAt)) $video->setCreatedAt(new DateTime($parseObj->createdAt,new DateTimeZone("America/Los_Angeles")));
		if(isset($parseObj->updatedAt)) $video->setUpdatedAt(new DateTime($parseObj->updatedAt,new DateTimeZone("America/Los_Angeles")));

		//ACL
	 	if(isset( $parseObj->ACL) ){
 		
	 		$ACL = null;	 		
	 		$video->setACL($ACL);
	 		
 		}
 		return $video;
	}
}
