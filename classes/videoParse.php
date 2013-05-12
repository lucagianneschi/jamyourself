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
		$parse->URL = $video->getURL();
		$parse->uploader = $video->getUploader();
		
		if( ( $author = $video->getAuthor() ) != null ) {
			$parse->author = array("__type" => "Pointer", "className" => "_User", "objectId" => $author->getObjectId() );			
		}

		
		
		$parse->title = $video->getTitle();
		$parse->description = $video->getDescription();
		$parse->thumbnail = $video->getThumbnail();
		$parse->tags = $video->getTags();
		$parse->duration = $video->getDuration();
		$parse->counter = $video->getCounter();
		
		$parse->featuring = array();
		foreach($video->getFeaturing() as $user){
			array_push($parse->featuring, $user);
		}
		
		//$parse->ACL = $video->getACL();

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
			
		$this->parseQuery->wherePointer('uploader','_User', $user->getObjectId());
	
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
		if(isset( $parseObj->objectId ) )$video->setObjectId($parseObj->objectId);
		 
		//creo la data di tipo DateTime per createdAt e updatedAt
		if( isset($parseObj->createdAt) ) $video->setCreatedAt(new DateTime($parseObj->createdAt,new DateTimeZone("America/Los_Angeles")));
		if( isset($parseObj->updatedAt) ) $video->setUpdatedAt(new DateTime($parseObj->updatedAt,new DateTimeZone("America/Los_Angeles")));

			//boolean		
		if(isset($parseObj->active))  $video->setActive($parseObj->active);
		
			//Pointer
		if(isset($parseObj->uploader) ){
			$parseUser = new UserParse();
			$userPointer = $parseObj->uploader;
			$uploader = $parseUser->getUserById($userPointer->objectId);
			$video->setUploader($uploader);
			
		}
		
			//string
		if(isset($parseObj->URL) ) $video->setURL($parseObj->URL) ;
		if(isset($parseObj->author) )  $video->setAuthor($parseObj->author);
		if(isset($parseObj->title) )  $video->setTitle($parseObj->title) ;
		if(isset($parseObj->description) )  $video->setDescription($parseObj->description) ;
		if(isset($parseObj->thumbnail) )  $video->setThumbnail($parseObj->thubmnail) ;
			
			//array di stringhe
		if(isset($parseObj->tags) )  $video->setTags($parseObj->parseObj->tags) ;
			//array di id
		if(isset($parseObj->featuring) ){
			$parseUser = new UserParse();
			$featuring = $parseUser->getUserArrayById($parseObj->featuring);
			$video->setFeaturing($featuring) ;
		}
				
			//integer
		if(isset($parseObj->duration) )  $video->setDuration($parseObj->duration) ;
		if(isset($parseObj->counter) )  $video->setCounter($parseObj->counter) ;

			//ACL
	 	if(isset( $parseObj->ACL ) ){
 		
	 		$ACL = null;	 		
	 		$video->setACL($ACL);
	 		
 		}
 		
 		return $video;
	}
}