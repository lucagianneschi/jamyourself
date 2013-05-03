<?php

define('PARSE_DIR', '../parse/');
define('CLASS_DIR', '../classes/');
include_once PARSE_DIR.'parse.php';
include_once CLASS_DIR.'event.class.php';
include_once CLASS_DIR.'geoPointParse.class.php';
include_once CLASS_DIR.'pointerParse.class.php';

class EventParse {
		
	private $parseQuery;

	public function __construct() {
		$this->parseQuery = new parseQuery('Event');
	}
	
	public function getEvent($objectId) {
		$event = new event();
		$parseObject = new parseObject('Event');
		$res = $parseObject->get($objectId);
		//inizializzo l'oggetto
		$event->setObjectId($res->objectId);
		$event->setAttendee($res->attendee);
	//	$pointerParse = new pointerParse($res->author->className, $res->author->objectId);
	//	$pointer = $pointerParse->getPointer();
	    
		$event->setAuthor($res->author);
		$event->setCounter($res->counter);
		$event->setDescription($res->description);
		//$date = new DateTime($res->eventDate->iso);
		$event->setEventDate($res->eventDate);
		$event->setFeaturing($res->featuring);
		$event->setInvited($res->invited);		
		$event->setLocation($res->location);
		$event->setLocationName($res->locationName);
		$event->setPhoto($res->photo);
		$event->setRefused($res->refused);
		$event->setTag($res->tag);
		$event->setThumbnail($res->thumbnail);
		$event->setTitle($res->title);
		$event->setCreatedAt($res->createdAt);
		$event->setUpdatedAt($res->updatedAt);
		return $event;
	}	

	public function getEvents() {
		//creo un contenitore di Events
		$events = array();
		//carico le Events
		$res = $this->parseQuery->find();
		
		foreach ($res->results as $obj) {
			$event = new event();
			$event->setObjectId($obj->objectId);
			$event->setAttendee($obj->attendee);
			$pointerParse = new pointerParse($obj->author->className, $obj->author->objectId);
			$pointer = $pointerParse->getPointer();
			$event->setAuthor($pointer);
			$event->setCounter($obj->counter);
			$event->setDescription($obj->description);
		//	$date = new DateTime($obj->eventDate->iso);
			$event->setEventDate($obj->eventDate);
			$event->setFeaturing($obj->featuring);
			$event->setInvited($obj->invited);
		//	$geoPointParse = new geoPointParse($obj->location->latitude, $obj->location->longitude);
		//	$geoPoint = $geoPointParse->getGeoPoint();
			$event->setLocation($obj->location);
			$event->setLocationName($obj->locationName);
			$event->setPhoto($obj->photo);
			$event->setRefused($obj->refused);
			$event->setTag($obj->tag);
			$event->setThumbnail($obj->thumbnail);
			$event->setTitle($obj->title);
			$event->setCreatedAt($obj->createdAt);
			$event->setUpdatedAt($obj->updatedAt);
			
			$events[$obj->objectId] = $event;
		}
		return $events;
	}

	public function saveEvent($event) {
		$parseObject = new parseObject('Event');
		
		$parseObject->attendee = $event->getAttendee();		
		$parseObject->author = $event->getAuthor();			
		$parseObject->counter = $event->getCounter();
		$parseObject->description = $event->getDescription();		
		$parseObject->eventDate = $event->getEventDate();		
		$parseObject->featuring = $event->getFeaturing();		
		$parseObject->invited = $event->getInvited();		
		$parseObject->location = $event->getLocation();		
		$parseObject->locationName = $event->getLocationName();
		$parseObject->photo = $event->getPhoto();		
		$parseObject->refused = $event->getRefused();			
		$parseObject->tag = $event->getTag();		
		$parseObject->thumbnail = $event->getThumbnail();		
		$parseObject->title = $event->getTitle();
		
		$res = $parseObject->save();
		$event->setObjectId($res->objectId);	
	}
	
	public function updateEvent($event){			
		$parseObject = new parseObject('Event');
		
		$parseObject->attendee = $event->getAttendee();
		$parseObject->author = $event->getAuthor();		
		$parseObject->counter = $event->getCounter();
		$parseObject->description = $event->getDescription();		
		$parseObject->eventDate = $event->getEventDate();		
		$parseObject->featuring = $event->getFeaturing();		
		$parseObject->invited = $event->getInvited();		
		$parseObject->location = $event->getLocation();		
		$parseObject->locationName = $event->getLocationName();
		$parseObject->photo = $event->getPhoto();		
		$parseObject->refused = $event->getRefused();			
		$parseObject->tag = $event->getTag();		
		$parseObject->thumbnail = $event->getThumbnail();		
		$parseObject->title = $event->getTitle();
		
		$parseObject->update($event->getObjectId());
	}
	
	/**
	 * Cancella un evento ($this) e tutti i relativi contenuti
	 */
	public function delete($event){		
		//prima cancellare tutti file relativi a quest album		
		$parseObject = new parseObject('Event');		
		if(!strstr($event->getPhoto(), '../images/default/eventcover.jpg')){			
			unlink($event->getPhoto());
		}
		
		if(!strstr($event->getThumbnail(), '../images/default/eventcoverthumb.jpg')){			
			unlink($event->getThumbnail());
		}	
		$parseObject->delete($event->getObjectId());		//cancello
	}
	
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}

	public function setLimit($int) {
		$this->parseQuery->setLimit($int);

	}
	public function setSkip($int) {
		$this->parseQuery->setSkip($int);

	}
	public function orderBy($key) {
		$this->parseQuery->orderBy($key);
	}	

	public function orderByAscending($key) {
		$this->parseQuery->orderByAscending($key);
	}

	public function orderByDescending($key) {
		$this->parseQuery->orderByDescending($key);
	}

	public function where($key, $value) {
		$this->parseQuery->where($key, $value);
	}

	public function whereEqualTo($key, $value) {
		$this->parseQuery->whereEqualTo($key, $value);
	}

	public function whereNotEqualTo($key, $value) {
		$this->parseQuery->whereNotEqualTo($key, $value);
	}

	public function whereGreaterThan($key, $value) {
		$this->parseQuery->whereGreaterThan($key, $value);
	}

	public function whereLessThan($key, $value) {
		$this->parseQuery->whereLessThan($key, $value);
	}

	public function whereGreaterThanOrEqualTo($key, $value) {
		$this->parseQuery->whereGreaterThanOrEqualTo($key, $value);
	}

	public function whereLessThanOrEqualTo($key, $value) {
		$this->parseQuery->whereLessThanOrEqualTo($key, $value);
	}

	public function whereContainedIn($key, $array) {
		$this->parseQuery->whereContainedIn($key, $array);
	}

	public function whereNotContainedIn($key, $array) {
		$this->parseQuery->whereNotContainedIn($key, $array);
	}

	public function whereExists($key) {
		$this->parseQuery->whereExists($key);
	}	

	public function whereNotExists($key) {
		$this->parseQuery->whereDoesNotExist($key);
	}

	public function wherePointer($key, $className, $objectId) {
		$this->parseQuery->wherePointer($key, $className, $objectId);
	}

}
?>