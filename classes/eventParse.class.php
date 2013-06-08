<?php

/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Event
 *  \details   Classe dedicata agli eventi, solo JAMMER e VENUE possono istanziare questa classe
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:event">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:event">API</a>
 */

define('PARSE_DIR', '../parse/');
define('CLASS_DIR', './');
include_once PARSE_DIR . 'parse.php';
include_once CLASS_DIR . 'event.class.php';
include_once CLASS_DIR . 'geoPointParse.class.php';

//include_once 'pointerParse.class.php';

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
        $event->setActive($res->active);

        if ($res->getAttendee() != null || count($res->getAttendee()) > 0) {
            foreach ($res->getAttendee() as $user) {
                $event->data[attendee]->__op = "AddRelation";
                $event->data[attendee]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
            }
        } else {
            $event->data[attendee] = null;
        }

        if ($res->getCommentators() != null || count($res->getCommentators()) > 0) {
            foreach ($res->getCommentators() as $user) {
                $event->data[commentators]->__op = "AddRelation";
                $event->data[commentators]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
            }
        } else {
            $event->data[commentators] = null;
        }

        if ($res->getComments() != null || count($res->getComments()) > 0) {
            foreach ($res->getComments() as $comment) {
                $event->data[comments]->__op = "AddRelation";
                $event->data[comments]->objects = array(array("__type" => "Pointer", "className" => "Comment", "objectId" => ($comment->getObjectId())));
            }
        } else {
            $event->data[comments] = null;
        }

        $event->setCounter($res->counter);
        $event->setDescription($res->description);
        $event->setEventDate($res->eventDate);

        if ($res->getFeaturing() != null || count($res->getFeaturing()) > 0) {
            foreach ($res->getFeaturing() as $user) {
                $event->data[featuring]->__op = "AddRelation";
                $event->data[featuring]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
            }
        } else {
            $event->data[featuring] = null;
        }

        $event->setFromUser($res->fromUser);
        $event->setImage($res->image);

        if ($res->getInvited() != null || count($res->getInvited()) > 0) {
            foreach ($res->getInvited() as $user) {
                $event->data[invited]->__op = "AddRelation";
                $event->data[invited]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
            }
        } else {
            $event->data[invited] = null;
        }

        $event->setLocation($res->location);
        $event->setLocationName($res->locationName);
        $event->setLoveCounter($res->loveCounter);

        if ($res->getLovers() != null || count($res->getLovers()) > 0) {
            foreach ($res->getLovers() as $user) {
                $event->data[lovers]->__op = "AddRelation";
                $event->data[lovers]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
            }
        } else {
            $event->data[lovers] = null;
        }

        if ($res->getRefused() != null || count($res->getRefused()) > 0) {
            foreach ($res->getRefused() as $user) {
                $event->data[refused]->__op = "AddRelation";
                $event->data[refused]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user->getObjectId())));
            }
        } else {
            $event->data[refused] = null;
        }

        if ($res->getTags() != null || count($res->getTags()) > 0) {
            $event->setTags($res->tags);
        } else {
            $event->tags = null;
        }
        
        $event->setThumbnail($res->thumbnail);
        $event->setTitle($res->title);
        $event->setCreatedAt($res->createdAt);
        $event->setUpdatedAt($res->updatedAt);

        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $event->setACL($acl);

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
			$event->setActive($obj->active);

			foreach($obj->getAttendee() as $user){
				$event->data[attendee]->__op = "AddRelation";
				$event->data[attendee]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
			}

			foreach($obj->getCommentators() as $user){
				$event->data[commentators]->__op = "AddRelation";
				$event->data[commentators]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
			}

			foreach($obj->getComments() as $comment){
				$event->data[comments]->__op = "AddRelation";
				$event->data[comments]->objects = array(array("__type" => "Pointer", "className" => "Comment", "objectId" => ($comment ->getObjectId())));
			}

			$event->setCounter($obj->counter);
			$event->setDescription($obj->description);
			$event->setEventDate($obj->eventDate);

			foreach($obj->getFeaturing() as $user){
				$event->data[featuring]->__op = "AddRelation";
				$event->data[featuring]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
			}	

			$pointerParse = new pointerParse($obj->fromUser->className, $obj->fromUser->objectId);
			$pointer = $pointerParse->getPointer();
			$event->setFromUser($pointer);
			$event->setImage($obj->image);

			foreach($obj->getInvited() as $user){
				$event->data[invited]->__op = "AddRelation";
				$event->data[invited]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
			}	
			$event->setLocation($obj->location);
			$event->setLocationName($obj->locationName);
			$event->setLoveCounter($obj->loveCounter);

			foreach($obj->getLovers() as $user){
				$event->data[lovers]->__op = "AddRelation";
				$event->data[lovers]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
			}	
		
			foreach($obj->getRefused() as $user){
				$event->data[refused]->__op = "AddRelation";
				$event->data[refused]->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId())));
			}

			$event->setTags($obj->tags);
			$event->setThumbnail($obj->thumbnail);
			$event->setTitle($obj->title);
			$event->setCreatedAt($obj->createdAt);
			$event->setUpdatedAt($obj->updatedAt);
                        
                        
			$event->setACL($obj->ACL); 
			$events[$obj->objectId] = $event;
		}
		return $events;
	}

	public function saveEvent($event) {
		$parseObject = new parseObject('Event');
		
		$parseObject->active = $event->getActive();
		$parseObject->counter = $event->getCounter();
		$parseObject->description = $event->getDescription();
		
		//NUOVO
		$parseObject->eventDate = $parseObject->dataType('date', $event->getEventDate()->format('Y-m-d H:i:s'));
		
		//NUOVO
		$parseObject->fromUser = $parseObject->dataType('pointer', array('_User', 'aAbBcCdD'));
		
		$parseObject->image = $event->getImage();
		$parseObject->location = $event->getLocation()->location;
		$parseObject->locationName = $event->getLocationName();
		$parseObject->loveCounter = $event->getLoveCounter();
		$parseObject->tags = $event->getTags();		
		$parseObject->thumbnail = $event->getThumbnail();		
		$parseObject->title = $event->getTitle();
		$parseObject->ACL = $event->getACL()->acl;
		
		$res = $parseObject->save();
		$event->setObjectId($res->objectId);	
	}
	
	public function updateEvent($event){			
		$parseObject = new parseObject('Event');
		
		$parseObject->active = $event->getActive();
		$parseObject->attendee = $event->getAttendee();
		$parseObject->commentators = $event->getCommentators();
		$parseObject->comments = $event->getComments();
		$parseObject->counter = $event->getCounter();
		$parseObject->description = $event->getDescription();
		$parseObject->eventDate = $event->getEventDate();
		$parseObject->featuring = $event->getFeaturing();
		$parseObject->fromUser = $event->getFromUser();				
		$parseObject->image = $event->getImage();	
		$parseObject->invited = $event->getInvited();		
		$parseObject->location = $event->getLocation();
		$parseObject->locationName = $event->getLocationName();
		$parseObject->loveCounter = $event->getLoveCounter();
		$parseObject->lovers = $event->getLovers();
		$parseObject->refused = $event->getRefused();			
		$parseObject->tags = $event->getTags();		
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
		if(!strstr($event->getImage(), '../images/default/eventcover.jpg')){			
			unlink($event->getImage());
		}
		
		if(!strstr($event->getThumbnail(), '../images/default/eventcoverthumb.jpg')){			
			unlink($event->getThumbnail());
		}	
        $event->setActive(false);
        $parseObject->active = $event->getActive(); 
		$parseObject->update($event->getObjectId());
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