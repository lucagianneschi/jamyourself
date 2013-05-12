<?php
class AlbumParse{

	private $parseQuery;

	function __construct(){
			
		$this->parseQuery = new ParseQuery("Album");
			
	}

	function save(Album $album){
			
		//creo un'istanza dell'oggetto della libreria ParseLib
		$parseObj = new parseObject("Album");
			
		//inizializzo le properties

		if($album->getFromUser() != null){
			$fromUser = $album->getFromUser();
			$parseObj->fromUser = $parseObj->event = array("__type" => "Pointer", "className" => "_User", "objectId" => $fromUser->getObjectId());;			
		}

		$parseObj->active = $album->getActive() ;
		$parseObj->title = $album->getTitle();
		$parseObj->description = $album->getDescription();
		
		if($album->getLocation()!=null){
			$geoPoint =  $album->getLocation();
			$parseObj->location = $geoPoint->location;			
		}

		
		$parseObj->cover = $album->getCover();
		$parseObj->thumbnailCover = $album->getThumbnailCover();
		$parseObj->featuring = $album->getFeaturing();
		$parseObj->tag = $album->getTag();
			
			
		if( isset($album->getObjectId()) && $album->getObjectId()!=null ){
				
			try{
				$ret = $parseObj->update($album->getObjectId());
					
				$event->setObjectId($album->objectId);
					
				$event->setUpdatedAt($album->createdAt);
					
				$event->setCreatedAt($album->createdAt);
			}
			catch(ParseLibraryException $e){
					
				return false;
					
			}
				
		}
		else{
			//caso save
			try{
				$ret = $parseObj->save();
					
				$album->setUpdatedAt($ret->updatedAt);
					
			}
			catch(ParseLibraryException $e){
					
				return false;
					
			}
				
		}
			
		return $album;
	}

	/**
	 * 
	 * @param Album $album
	 * @return boolean
	 */
	function delete(Album $album){			
			if($album){
				$album->setActive(false);
					
				if( $this->save($album) ) return true;
				else return false;
			}
			else return false;
	}

	function getAlbum($albumId){
		
		$album = null;
		
		$this->parseQuery->where('objectId', $albumId);
		
		$result = $this->parseQuery->find();
		
		if (is_array($result->results) && count($result->results)>0){
		
			$ret = $result->results[0];
		
			if($ret){
		
				//recupero l'utente
				$album = $this->parseToAlbum($ret);
		
			}
		
		}
		
		return $album;
	}

	function parseToAlbum(stdClass $parseObj){
		
		$album = new Album();

		//specifiche
		
		if(isset($parseObj->fromUser ) ){
			$parseUser = new UserParse();
			$pointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($pointer->getObjectId());
			$album->setFromUser($fromUser);
		}	
		if(isset($parseObj->active ) )$album->setActive($parseObj->active);
		if(isset($parseObj->title ) )$album->setTitle($parseObj->title);
		if(isset($parseObj->description ) )$album->setDescription($parseObj->description);

		if( isset($parseObj->location) ){
			//recupero il GeoPoint
			$geoParse = $parseObj->location;
		
			$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);

			$album->setLocation($geoPoint);
		
		}
			
		if(isset($parseObj->cover ) )$album->setCover($parseObj->cover);
		if(isset($parseObj->thumbnailCover ) )$album->setThumbnailCover($parseObj->thumbnailCover);
		if(isset($parseObj->featuring ) )$album->setFeaturing($parseObj->featuring);
		if(isset($parseObj->tag ) )$album->setTag($parseObj->tag);
		
		//generali
		
		if(isset($parseObj->objectId)) $album->setObjectId($parseObj->objectId) ;
		if(isset($parseObj->type)) $album->setType($parseObj->type)  ;
		
		if(isset($parseObj->createdAt)){
		
			$createdAt = new DateTime($parseObj->createdAt);
		
			$album->setCreatedAt($createdAt)  ;
		}
		
		if(isset($parseObj->updatedAt)){
			$updatedAt = new DateTime( $parseObj->updatedAt );
		
			$album->setUpdatedAt($updatedAt)  ;
		}
		if(isset($parseObj->ACL)){
		
			$ACL = null;
		
			$album->setACL($ACL)  ;
		}
		
		return $album;
	}

}