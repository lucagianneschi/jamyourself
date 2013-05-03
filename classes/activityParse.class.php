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

			$parseObj->fromUser = array("__type" => "Pointer", "className" => "Event", "objectId" => $user->getObjectId());
		}

		//puntatore allo status

		if( $activity->getStatus() != null ){

			$status = $activity->getStatus();

			$parseObj->status = array("__type" => "Pointer", "className" => "Event", "objectId" => $status->getObjectId());

		}

		//puntatore al toUser

		if( $activity->getToUser() != null ){

			$user = $activity->getToUser();

			$parseObj->toUser = array("__type" => "Pointer", "className" => "Event", "objectId" => $user->getObjectId());
		}

		//Stringa type
		$parseObj->type = $activity->getType();
		//$parseObj->ACL = $activity->getACL();

		//caso update
		if( isset($activity->getObjectId()) && $activity->getObjectId()!=null ){

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
	 * @param stdClass $parseObj
	 * @return boolean|Activity
	 */
	public function parseToActivity(stdClass $parseObj){

		if($parseObj == null) return false;

		$activity = new activity(); //

		if(isset($parseObj->objectId)) $activity->setObjectId($parseObj->objectId) ;

		if(isset($parseObj->event)){
				
			$parseEvent = new eventParse();
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
			$parseStatus = new statusParse();
				
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