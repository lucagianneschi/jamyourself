<?php
/*! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Record Class
 *  \details   Classe dedicata ad un album di brani musicali, pu˜ essere istanziata solo da Jammer
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:record">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:record">API</a>
 */
define('CLASS_DIR', './classes/');
include_once CLASS_DIR.'userParse.class.php';

class RecordParse{

	private $parseQuery;

	function __construct() {
		$this->parseQuery = new ParseQuery("Record");
	}

	/**
	 * @param Record $record
	 * @return boolean
	 */
	function delete(Record $record) {
		if($record) {
			$record->setActive(false);
			if($this->save($record)) {
				return true;
			} else {
				return false;
			}
		}
		else return false;
	}
	
	function getRecord($objectId) {
		$record = null;
		$this->parseQuery->where('objectId', $objectId);
		$result = $this->parseQuery->find();
		if ( is_array($result->results) && count($result->results) > 0 ) {
			$ret = $result->results[0];
			if($ret) {
				//recupero l'utente
				$record = $this->parseToRecord($ret);
			}
		}
		return $record;
	}

	function parseToRecord(stdClass $parseObj) {
		$record = new Record();

		//specifiche
		if(isset($parseObj->active)) $record->setActive($parseObj->active);
		if(isset($parseObj->counter)) $record->setCounter($parseObj->counter);
		if(isset($parseObj->cover)) $record->setCover($parseObj->cover);
		if(isset($parseObj->description)) $record->setDescription($parseObj->description);
		if(isset($parseObj->featuring)) {
			$parseUser = new UserParse();
			$featuring = $parseUser->getUserArrayById($parseObj->featuring);
			$record->setFeaturing($featuring);
		}
		if(isset($parseObj->fromUser ) ) {
			$parseUser = new UserParse();
			$pointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($pointer->getObjectId());
			$record->setFromUser($fromUser);
		}
		if( isset($parseObj->location) ) {
			//recupero il GeoPoint
			$geoParse = $parseObj->location;
			$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
			$record->setLocation($geoPoint);
		}
		if(isset($parseObj->loveCounter)) $record->setLoveCounter($parseObj->loveCounter);
		if(isset($parseObj->thumbnailCover)) $record->setThumbnailCover($parseObj->thumbnailCover);
		if(isset($parseObj->title)) $record->setTitle($parseObj->title);
		
		//generali
		if(isset($parseObj->objectId)) $record->setObjectId($parseObj->objectId);
		if(isset($parseObj->createdAt)) {
			$createdAt = new DateTime($parseObj->createdAt);
			$record->setCreatedAt($createdAt)  ;
		}
		if(isset($parseObj->updatedAt)) {
			$updatedAt = new DateTime( $parseObj->updatedAt );
			$record->setUpdatedAt($updatedAt);
		}
		if(isset($parseObj->ACL)){
			$ACL = null;
			$record->setACL($ACL)  ;
		}

		return $record;
	}
        
	function save(Record $record) {
		$parseObj = new parseObject("Record");

		//inizializzo le properties
		$parseObj->active = $record->getActive();
                
                if($record->getCommentators() != null || count($record->getCommentators())>0){
                    foreach($record->getCommentators() as $user){
                            $parse->commentators->__op = "AddRelation";
                            $parse->commentators->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
                    }
                } else {
                    $parse->commentators = null;  
                }
                
                if($record->getComments() != null || count($record->getComments())>0){
                    foreach($record->getComments() as $comment){
                            $parse->comments->__op = "AddRelation";
                            $parse->comments->objects = array(array("__type" => "Pointer", "className" => "Comment", "objectId" => ($comment ->getObjectId())));
                    }
                } else {
                    $parse->comments = null;
                }
                
		$parse->counter = $record->getCounter();
		$parseObj->cover = $record->getCover();
		$parseObj->description = $record->getDescription();
                
                  //array di puntori ad utenti
                if($record->getFeaturing() != null || count($record->getFeaturing())>0){
                    foreach($record->getFeaturing() as $user){
                            $parse->featuring->__op = "AddRelation";
                            $parse->featuring->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
                    }
                } else {
                    $parse->featuring = null;
                }
           
		if($record->getFromUser() != null){
			$fromUser = $record->getFromUser();
			$parseObj->fromUser = $parseObj->event = array("__type" => "Pointer", "className" => "_User", "objectId" => $fromUser->getObjectId());;
		}
		if($record->getLocation()!=null){
			$geoPoint =  $record->getLocation();
			$parseObj->location = $geoPoint->location;
		}
		$parseObj->loveCounter = $record->getLoveCounter(); //aggiunta per tenere conto del numero di love
		$parseObj->thumbnailCover = $record->getThumbnailCover();
		$parseObj->title = $record->getTitle();
		
		if( isset($record->getObjectId()) && $record->getObjectId() != null ) {
			try{
				$result = $parseObj->update($record->getObjectId());
                                $record->setObjectId($result->objectId);
				$record->setCreatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
				$record->setUpdatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
			}
			catch(ParseLibraryException $e) {
				return false;
			}
		} else {
			//caso save
			try{
				$result = $parseObj->save();
				$record->setUpdatedAt($result->updatedAt);
			} catch(ParseLibraryException $e) {
				return false;
			}
		}
		return $record;
	}
}