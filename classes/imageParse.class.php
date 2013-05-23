<?php

class ImageParse{
	
	private $parseQuery;

	function __construct(){
		$this->parseQuery = new parseQuery("Image");
	}
	
	function save(Image $image){
		
		//recupero le info dell'oggetto
		$parse = new parseObject("Image");
		
		$parse->active = $image->getActive();
		$parse->counter = $image->getCounter();
		$parse->loveCounter = $image->getLoveCounter(); //aggiunta per il contatore di love
		
		if( ( $fromUser = $image->getFromUser() ) != null ) {
			$parse->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $author->getObjectId() );			
		}
		
		$parse->tag = $image->getTag();
		$parse->filePath = $image->getFilePath();
		$parse->description = $image->getDescription();
		$parse->album = $image->getAlbum();
		
		//array di utenti
		$parse->featuring = array();
		foreach ($image->getFeaturing() as $user){
			array_push($parse->featuring, $user->getObjectId());
		}
				
		if( ($geoPoint = $image->getLocation() ) != null ){
			$parse->location = $geoPoint->location;			
		}
		
		//$parse->ACL = $image->getACL();
		
		//se esiste l'objectId vuol dire che devo aggiornare
		//se non esiste vuol dire che devo salvare
		if(( $image->getObjectId())!=null ){
			//update
			try{
				//update
				$result = $parse->update($image->getObjectId());
		
				//aggiorno l'update
				$image->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
					
			}
			catch(ParseLibraryException $e){
		
				return false;
		
			}
		
		
		
		}else{
		
			try{
				//salvo
				$result = $parse->save();
		
				//aggiorno i dati per la creazione
				$image->setObjectId($result->objectId);
				$image->setCreatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
				$image->setUpdatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
			}
			catch(ParseLibraryException $e){
		
				return false;
		
			}
		
		}
		
		//restituisco image aggiornato
		return $image;
	}
	
	function delete(Image $image){
		$image->setActive(false);
		
		if($this->save($image)) return true;
		else return false;		
	}
	
	function getImage($imageId){
		
		$image = new Image();
			
		$parseImage = new parseObject("Image");
		
		$res = $parseImage->get($imageId);
		
		$image = $this->parseToImage($res);
		
		return $image;		
	}
	
	function parseToImage(stdClass $parseObj){
		
		$image = new Image();
		//recupero objectId
		if(isset( $parseObj->objectId ) )$image->setObjectId($parseObj->objectId);
			
		//creo la data di tipo DateTime per createdAt e updatedAt
		if( isset($parseObj->createdAt) ) $image->setCreatedAt(new DateTime($parseObj->createdAt,new DateTimeZone("America/Los_Angeles")));
		if( isset($parseObj->updatedAt) ) $image->setUpdatedAt(new DateTime($parseObj->updatedAt,new DateTimeZone("America/Los_Angeles")));
		
		//boolean
		if(isset($parseObj->counter))  $image->setCounter($parseObj->counter);
		if(isset($parseObj->loveCounter))  $image->setLoveCounter($parseObj->loveCounter); //aggiunta per il contatore di love
		if(isset($parseObj->fromUser)){
			$parseUser = new UserParse();
			$pointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($pointer->objectId);
			$image->setActive($fromUser);
		}
		if(isset($parseObj->tag))  $image->setTag($parseObj->tag);
		if(isset($parseObj->filePath))  $image->setFilePath($parseObj->filePath);
		if(isset($parseObj->description))  $image->setDescription($parseObj->description);
		if(isset($parseObj->album)){
			$parseAlbum = new AlbumParse();
			$pointer = $parseObj->album;
			$image->setActive($parseAlbum->getAlbum($pointer->objectId));
		}

		if(isset($parseObj->location)){
			$geoParse = $parseObj->location;			
			$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
			$image->setLocation($geoPoint);

		}

		if(isset($parseObj->featuring)){
			$parseUser = new UserParse();
			$featuring = $parseUser->getUserArrayById($parseObj->featuring);
			$image->setFeaturing($featuring);
		}

		//ACL
		if(isset( $parseObj->ACL ) ){
				
			$ACL = null;
			$image->setACL($ACL);
		
		}
		
	}
}
