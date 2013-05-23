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

		//puntatore all'evento
		if( $activity->getEvent() != null ){

			$event = $activity->getEvent();

			$parseObj->event = array("__type" => "Pointer", "className" => "Event", "objectId" => $event->getObjectId());
		}


		//puntatore al fromUser

		if( $activity->getFromUser() != null ){

			$user = $activity->getFromUser();

			$parseObj->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
		}

		//puntatore allo status

		if( $activity->getStatus() != null ){

			$status = $activity->getStatus();

			$parseObj->status = array("__type" => "Pointer", "className" => "Status", "objectId" => $status->getObjectId());

		}

		//puntatore al toUser

		if( $activity->getToUser() != null ){

			$user = $activity->getToUser();

			$parseObj->toUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $user->getObjectId());
		}
		
		if( $activity->getSong() != null ){
			
			$song = $activity->getSong();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Song", "objectId" => $song->getObjectId());
				

		}
		
		if( $activity->getPhoto() != null ){
			
			$photo = $activity->getPhoto();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Photo", "objectId" => $photo->getObjectId());
				
		
		}
		
		if( $activity->getPhotoAlbum() != null ){
			
			$photoAlbum = $activity->getPhotoAlbum();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "PhotoAlbum", "objectId" => $photoAlbum->getObjectId());
				
		
		}
		
		if( $activity->getAlbum() != null ){
			
			$album = $activity->getAlbum();
			
			$parseObj->toUser = array("__type" => "Pointer", "className" => "Album", "objectId" => $album->getObjectId());
				
		
		}

		//Stringa type
		$parseObj->type = $activity->getType();
		//$parseObj->ACL = $activity->getACL();
		$parseObj->read = $activity->getRead();

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

		if(isset($parseObj->objectId)) $activity->setObjectId($parseObj->objectId) ;

		if(isset($parseObj->read)) $activity->setRead($parseObj->read);
		
		if(isset($parseObj->event)){
				
			$parseEvent = new EventParse();
			$parsEvent = $parseObj->event;
			$event = $parseEvent->getEvent($parsEvent->objectId);
				
			$activity->setEvent($event);
		}

		if(isset($parseObj->fromUser)){
				
			$parseUser = new userParse();
			$parseUser = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($parseUser->objectId);				
			$activity->setFromUser($fromUser);
				
		}

		if(isset($parseObj->status)){
			$parseStatus = new StatusParse();
				
			$parseStatus = $parseObj->status;
			$status  = $parseStatus->parseToStatus($parseStatus->objectId);				
			$activity->setStatus($status)  ;
		}

		if(isset($parseObj->toUser)){
			$parseUser = new userParse();
			$toUserParse = $parseObj->toUser;
			$toUser = $parseUser->parseToUser($toUserParse->objectId);
			$activity->setToUser($toUser)  ;
		}

		if(isset($parseObj->type)) $activity->setType($parseObj->type)  ;

		if(isset($parseObj->createdAt)){
				
			$createdAt = new DateTime($parseObj->createdAt);
				
			$activity->setCreatedAt($createdAt)  ;
		}

		if(isset($parseObj->updatedAt)){
			$updatedAt = new DateTime( $parseObj->updatedAt );
				
			$activity->setUpdatedAt($updatedAt)  ;
		}
		if(isset($parseObj->ACL)){
				
			$ACL = null;
				
			$activity->setACL($ACL)  ;
		}

		return $activity;
	}

}