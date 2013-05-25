<?php

//definizione: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:song
//api: http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:song

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
		$parse->description = $song->getDescription();
		$parse->duration = $song->getDuration();
		//array di utenti
		$parse->featuring = array();
		foreach ($song->getFeaturing() as $user){
			array_push($parse->featuring, $user->getObjectId());
		}
		$parse->filePath = $song->getFilePath();
		if( ( $fromUser = $song->getFromUser() ) != null ) {
			$parse->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $fromUser->getObjectId() );			
		}
		$parse->genre = $song->getGenre();
		$parse->label = $song->getLabel();
		if( ($geoPoint = $song->getLocation() ) != null ){
			$parse->location = $geoPoint->location;			
		}
		$parse->loveCounter = $song->getLoveCounter(); //contatore per tenere conto dei love
		$parse->record = $song->getRecord();
		$parse->title = $song->getTitle();

		//$parse->ACL = $song->getACL();  PERCHé non viene settato??
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
		
		//boolean
        if(isset($parseObj->active))  $song->setActive($parseObj->active);
		if(isset($parseObj->counter))  $song->setCounter($parseObj->counter);
		if(isset($parseObj->description))  $song->setDescription($parseObj->description);
		if(isset($parseObj->duration))  $song->setDuration($parseObj->duration);
		if(isset($parseObj->featuring)){
			$parseUser = new UserParse();
			$featuring = $parseUser->getUserArrayById($parseObj->featuring);
			$song->setFeaturing($featuring);
		}

		if(isset($parseObj->filePath))  $song->setFilePath($parseObj->filePath);
		if(isset($parseObj->fromUser)){
			$parseUser = new UserParse();
			$pointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($pointer->objectId);
			$song->setFromUser($fromUser);
		}

		if(isset($parseObj->genre))  $song->setGenre($parseObj->genre);
		if(isset($parseObj->label))  $song->setLabel($parseObj->label);
		if(isset($parseObj->location)){
			$geoParse = $parseObj->location;			
			$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
			$song->setLocation($geoPoint);
		}

		if(isset($parseObj->loveCounter))  $song->setLoveCounter($parseObj->loveCounter); //aggiunto per tenere conto del numero di love
		if(isset($parseObj->record)){
			$parseRecord = new RecordParse();
			$pointer = $parseObj->record;
			$song->setRecord($parseRecord->getRecord($pointer->objectId));
		}

		if(isset($parseObj->title))  $song->setTitle($parseObj->title);

		//creo la data di tipo DateTime per createdAt e updatedAt
		if( isset($parseObj->createdAt) ) $song->setCreatedAt(new DateTime($parseObj->createdAt,new DateTimeZone("America/Los_Angeles")));
		if( isset($parseObj->updatedAt) ) $song->setUpdatedAt(new DateTime($parseObj->updatedAt,new DateTimeZone("America/Los_Angeles")));

		//ACL
		if(isset( $parseObj->ACL ) ){
			$ACL = null;
			$song->setACL($ACL);
		}
	}
}
?>
