<?php
class RecordParse{

	private $parseQuery;

	function __construct(){
			
		$this->parseQuery = new ParseQuery("Record");
			
	}

	function save(Record $record){
			
		//creo un'istanza dell'oggetto della libreria ParseLib
		$parseObj = new parseObject("Record");
			
		//inizializzo le properties

		if($record->getFromUser() != null){
			$fromUser = $record->getFromUser();
			$parseObj->fromUser = $parseObj->event = array("__type" => "Pointer", "className" => "_User", "objectId" => $fromUser->getObjectId());;			
		}

		$parseObj->active = $record->getActive() ;
		$parseObj->title = $record->getTitle();
		$parseObj->description = $record->getDescription();
		
		if($record->getLocation()!=null){
			$geoPoint =  $record->getLocation();
			$parseObj->location = $geoPoint->location;			
		}

		$parseObj->counter = $record->getCounter();
		$parseObj->loveCounter = $record->getLoveCounter(); //aggiunta per tenere conto del numero di love
		$parseObj->cover = $record->getCover();
		$parseObj->thumbnailCover = $record->getThumbnailCover();
		$parseObj->featuring = $record->getFeaturing();
		
		//array di utenti
		$parse->featuring = array();		
		foreach ($record->getFeaturing() as $user){
			array_push($parse->featuring, $user->getObjectId());
		}
		
		$parseObj->keywords = $record->getKeywords();
			
			
		if( isset($record->getObjectId()) && $record->getObjectId()!=null ){
				
			try{
				$ret = $parseObj->update($record->getObjectId());
					
				$event->setObjectId($record->objectId);
					
				$event->setUpdatedAt($record->createdAt);
					
				$event->setCreatedAt($record->createdAt);
			}
			catch(ParseLibraryException $e){
					
				return false;
					
			}
				
		}
		else{
			//caso save
			try{
				$ret = $parseObj->save();
					
				$record->setUpdatedAt($ret->updatedAt);
					
			}
			catch(ParseLibraryException $e){
					
				return false;
					
			}
				
		}
			
		return $record;
	}

	/**
	 * 
	 * @param record $record
	 * @return boolean
	 */
	function delete(Record $record){			
			if($record){
				$record->setActive(false);
					
				if( $this->save($record) ) return true;
				else return false;
			}
			else return false;
	}

	function getrecord($recordId){
		
		$record = null;
		
		$this->parseQuery->where('objectId', $recordId);
		
		$result = $this->parseQuery->find();
		
		if (is_array($result->results) && count($result->results)>0){
		
			$ret = $result->results[0];
		
			if($ret){
		
				//recupero l'utente
				$record = $this->parseTorecord($ret);
		
			}
		
		}
		
		return $record;
	}

	function parseTorecord(stdClass $parseObj){
		
		$record = new Record();

		//specifiche
		
		if(isset($parseObj->fromUser ) ){
			$parseUser = new UserParse();
			$pointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($pointer->getObjectId());
			$record->setFromUser($fromUser);
		}	
		if(isset($parseObj->active ) )$record->setActive($parseObj->active);
		if(isset($parseObj->title ) )$record->setTitle($parseObj->title);
		if(isset($parseObj->description ) )$record->setDescription($parseObj->description);

		if( isset($parseObj->location) ){
			//recupero il GeoPoint
			$geoParse = $parseObj->location;
		
			$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);

			$record->setLocation($geoPoint);
		
		}
			
		if(isset($parseObj->cover ) )$record->setCover($parseObj->cover);
		if(isset($parseObj->counter ) )$record->setCounter($parseObj->counter);
		if(isset($parseObj->loveCounter ) )$record->setLoveCounter($parseObj->loveCounter);
		if(isset($parseObj->thumbnailCover ) )$record->setThumbnailCover($parseObj->thumbnailCover);
		
		if(isset($parseObj->featuring ) ){
			
			$parseUser = new UserParse();
			
			$featuring = $parseUser->getUserArrayById($parseObj->featuring);
			
			$record->setFeaturing($featuring);
			
		}
		
		
		if(isset($parseObj->keywords ) )$record->setkeywords($parseObj->keywords);
		
		//generali
		
		if(isset($parseObj->objectId)) $record->setObjectId($parseObj->objectId) ;
		if(isset($parseObj->type)) $record->setType($parseObj->type)  ;
		
		if(isset($parseObj->createdAt)){
		
			$createdAt = new DateTime($parseObj->createdAt);
		
			$record->setCreatedAt($createdAt)  ;
		}
		
		if(isset($parseObj->updatedAt)){
			$updatedAt = new DateTime( $parseObj->updatedAt );
		
			$record->setUpdatedAt($updatedAt)  ;
		}
		if(isset($parseObj->ACL)){
		
			$ACL = null;
		
			$record->setACL($ACL)  ;
		}
		
		return $record;
	}

}
