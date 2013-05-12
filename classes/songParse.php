<?php

class SongParse{
	
	private $parseQuery;

	function __construct(){
		$this->parseQuery = new parseQuery("Song");
	}
	
	function save(Song $song){
		
		//recupero le info dell'oggetto
		$parse = new parseObject("Song");
		
		$parse->active = $song->getActive();
		$parse->counter = $song->getCounter();
		
		if( ( $fromUser = $song->getFromUser() ) != null ) {
			$parse->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $author->getObjectId() );			
		}
		
		$parse->title = $song->getTitle();
		$parse->duration = $song->getDuration();
		$parse->genre = $song->getGenre();
		$parse->filePath = $song->getFilePath();
		$parse->description = $song->getDescription();
		$parse->album = $song->getAlbum();
		$parse->label = $song->getLabel();
		
		//array di utenti
		$parse->featuring = array();
		foreach ($song->getFeaturing() as $user){
			array_push($parse->featuring, $user->getObjectId());
		}
				
		if( ($geoPoint = $song->getLocation() ) != null ){
			$parse->location = $geoPoint->location;			
		}
		
		//$parse->ACL = $song->getACL();
		
		//se esiste l'objectId vuol dire che devo aggiornare
		//se non esiste vuol dire che devo salvare
		if(( $song->getObjectId())!=null ){
			//update
			try{
				//update
				$result = $parse->update($song->getObjectId());
		
				//aggiorno l'update
				$song->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
					
			}
			catch(ParseLibraryException $e){
		
				return false;
		
			}
		
		
		
		}else{
		
			try{
				//salvo
				$result = $parse->save();
		
				//aggiorno i dati per la creazione
				$song->setObjectId($result->objectId);
				$song->setCreatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
				$song->setUpdatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
			}
			catch(ParseLibraryException $e){
		
				return false;
		
			}
		
		}
		
		//restituisco song aggiornato
		return $song;
	}
	
	function delete(Song $song){
		$song->setActive(false);
		
		if($this->save($song)) return true;
		else return false;		
	}
	
	function getSong($songId){
		
		$song = new Song();
			
		$parseSong = new parseObject("Song");
		
		$res = $parseSong->get($songId);
		
		$song = $this->parseToSong($res);
		
		return $song;		
	}
	
	function parseToSong(stdClass $parseObj){
		
		$song = new Song();
		//recupero objectId
		if(isset( $parseObj->objectId ) )$song->setObjectId($parseObj->objectId);
			
		//creo la data di tipo DateTime per createdAt e updatedAt
		if( isset($parseObj->createdAt) ) $song->setCreatedAt(new DateTime($parseObj->createdAt,new DateTimeZone("America/Los_Angeles")));
		if( isset($parseObj->updatedAt) ) $song->setUpdatedAt(new DateTime($parseObj->updatedAt,new DateTimeZone("America/Los_Angeles")));
		
		//boolean
		if(isset($parseObj->counter))  $song->setCounter($parseObj->counter);
		if(isset($parseObj->fromUser)){
			$parseUser = new UserParse();
			$pointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($pointer->objectId);
			$song->setActive($fromUser);
		}
		if(isset($parseObj->title))  $song->setTitle($parseObj->title);
		if(isset($parseObj->duration))  $song->setDuration($parseObj->duration);
		if(isset($parseObj->genre))  $song->setGenre($parseObj->genre);
		if(isset($parseObj->filePath))  $song->setFilePath($parseObj->filePath);
		if(isset($parseObj->description))  $song->setDescription($parseObj->description);
		if(isset($parseObj->album)){
			$parseAlbum = new RecordParse();
			$pointer = $parseObj->album;
			$song->setActive($parseAlbum->getAlbum($pointer->objectId));
		}
		if(isset($parseObj->label))  $song->setLabel($parseObj->label);
		if(isset($parseObj->location)){
			$geoParse = $parseObj->location;			
			$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
			$song->setLocation($geoPoint);

		}

		if(isset($parseObj->featuring)){
			$parseUser = new UserParse();
			$featuring = $parseUser->getUserArrayById($parseObj->featuring);
			$song->setFeaturing($featuring);
		}

		//ACL
		if(isset( $parseObj->ACL ) ){
				
			$ACL = null;
			$song->setACL($ACL);
		
		}
		
	}
}