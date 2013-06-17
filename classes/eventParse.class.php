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

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';
require_once CLASSES_DIR . 'utils.class.php';

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';


class EventParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new parseQuery('Event');
    }

    /**
     * Cancella un evento ($this) e tutti i relativi contenuti
     */
    public function deleteEvent($objectId) {
        try {
            $parseObject = new parseObject('Event');
            /*
              if(!strstr($parseObject->getImage(), '../images/default/eventcover.jpg')){
              unlink($parseObject->getImage());
              }
              if(!strstr($parseObject->getThumbnail(), '../images/default/eventcoverthumb.jpg')){
              unlink($parseObject->getThumbnail());
              }
             */
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getEvent($objectId) {
        try {
            $parseObject = new parseObject('Event');
            $res = $parseObject->get($objectId);
            $event = $this->parseToEvent($res);
            return $event;
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function getEvents() {
        try {
            $events = array();
            $res = $this->parseQuery->find();
            foreach ($res->results as $obj) {
                $event = $this->parseToEvent($obj);
                $events[$event->getObjectId()] = $event;
            }
            return $events;
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function getRelatedTo($field, $className, $objectId) {
        try {
            $this->parseQuery->whereRelatedTo($field, $className, $objectId);
            $rel = $this->parseQuery->find();
            $relEvent = array();
            foreach ($rel->results as $event) {
                $relEvent[] = $event->objectId;
            }
            return $relEvent;
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    // TODO - da capire se ancora utile o da eliminare
    private function isNullPointer($pointer) {
        $className = $pointer['className'];
        $objectId = $pointer['objectId'];
        $isNull = true;

        if ($className == '' || $objectId == '') {
            $isNull = true;
        } else {
            $isNull = false;
        }

        return $isNull;
    }

    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    function parseToEvent(stdClass $parseObj) {
        $event = new Event();
        
        if(isset($parseObj->objectId))
            $event->setObjectId($parseObj->objectId);
        if(isset($parseObj->active))
            $event->setActive($parseObj->active);
        if(isset($parseObj->attendee)){
            $userParse = new UserParse();
            $attendee = $this->$userParse->getRelatedTo('attendee', 'Event', $parseObj->objectId);
            $event->setAttendee($attendee);
        }
        if(isset($parseObj->commentators)){
            $userParse = new UserParse();
            $commentators = $this->$userParse->getRelatedTo('commentators', 'Event', $parseObj->objectId);
            $event->setCommentators($commentators);
        }
        if(isset($parseObj->comments)){
            $commentParse = new CommentParse();
            $comments = $this->$commentParse->getRelatedTo('comments', 'Event', $parseObj->objectId);
            $event->setComments($comments);
        }
        if(isset($parseObj->counter))
            $event->setCounter($parseObj->counter);
        if(isset($parseObj->featuring)){
            $userParse = new UserParse();
            $featuring = $this->$userParse->getRelatedTo('featuring', 'Event', $parseObj->objectId);
            $event->setFeaturing($featuring);
        }
        if (isset($parseObj->location)) {
            $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
            $event->setLocation($parseGeoPoint->location);
	}
        if(isset($parseObj->locationName))
            $event->setLocationName($parseObj->locationName);
        if(isset($parseObj->loveCounter))
            $event->setLoveCounter($parseObj->loveCounter);
        if(isset($parseObj->lovers)){
            $userParse = new UserParse();
            $lovers = $this->$userParse->getRelatedTo('lovers', 'Event', $parseObj->objectId);
            $event->setLovers($lovers);
        }
        if(isset($parseObj->refused)){
            $userParse = new UserParse();
            $refused = $this->$userParse->getRelatedTo('refused', 'Event', $parseObj->objectId);
            $event->setLovers($refused);
        }
        if(isset($parseObj->tags))
            $event->setTags($parseObj->tags);
        if(isset($parseObj->thumbnail))
            $event->setThumbnail($parseObj->thumbnail);
        if(isset($parseObj->title))
            $event->setTitle($parseObj->title);
        if (isset($parseObj->createdAt))
            $event->setCreatedAt(new DateTime($parseObj->createdAt));
        if (isset($parseObj->updatedAt))
            $event->setUpdatedAt(new DateTime($parseObj->updatedAt));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $event->setACL($acl);
        return $event;
    }

    public function saveEvent(Event $event) {
        try {
            $parseObject = new parseObject('Event');
            if ($event->getObjectId() == '') {
                //codice per implementazione utils
                /*
                 *$parseObj->attendee = toParseRelation($event->getAttendee());
                 *$parseObj->commentators = toParseRelation($event->getCommentators());
                 *$parseObj->comments = toParseRelation($event->getComments());
                 *$parseObj->eventDate = toParseDateTime($event->getEventDate());
                 *$parseObj->featuring = toParseRelation($event->getFeaturing());
                 *$parseObj->fromUser = toParsePointer($event->getFromUser()); 
                 *$parseObj->image = toParsePointer($event->getImage());
                 *$parseObj->invited = toParseRelation($event->getInvited());
                 *$parseObj->location = toParsePointer($event->getLocation());
                 *$parseObj->lovers = toParseRelation($event->getLovers());
                 *$parseObj->refused = toParseRelation($event->getRefused());
                 *$parseObj->taggedUsers = toParseRelation($event->getTaggedUsers());
                 *$parseObj->ACL = toParseACL($event->getACL()); 
                 */
                
                $event->getActive() == null ? $parseObject->active = null : $parseObject->active = $event->getActive();
                $event->getAttendee() == null ? $parseObject->attendee = null : $parseObject->attendee = $event->getAttendee();
                $event->getCommentators() == null ? $parseObject->commentators = null : $parseObject->commentators = $event->getCommentators();
                $event->getComments() == null ? $parseObject->comments = null : $parseObject->comments = $event->getComments();
                $event->getCounter() == null ? $parseObject->counter = null : $parseObject->counter = $event->getCounter();
                $event->getDescription() == null ? $parseObject->description = null : $parseObject->description = $event->getDescription();
                $event->getEventDate() == null ? $parseObject->eventDate = null : $parseObject->eventDate = $event->getEventDate();
                $event->getFeaturing() == null ? $parseObject->featuring = null : $parseObject->featuring = $event->getFeaturing();
                $event->getFromUser() == null ? $parseObject->fromUser = null : $parseObject->fromUser = $event->getFromUser();
                $event->getImage() == null ? $parseObject->image = null : $parseObject->image = $event->getImage();
                $event->getImageFile() == null ? $parseObject->imageFile = null : $parseObject->imageFile = $event->getImageFile();
                $event->getInvited() == null ? $parseObject->invited = null : $parseObject->invited = $event->getInvited();
                $event->getLocation() == null ? $parseObject->location = null : $parseObject->location = $event->getLocation();
                $event->getLocationName() == null ? $parseObject->locationName = null : $parseObject->locationName = $event->getLocationName();
                $event->getLoveCounter() == null ? $parseObject->loveCounter = null : $parseObject->loveCounter = $event->getLoveCounter();
                $event->getLovers() == null ? $parseObject->lovers = null : $parseObject->lovers = $event->getLovers();
                $event->getRefused() == null ? $parseObject->refused = null : $parseObject->refused = $event->getRefused();
                $event->getTags() == null ? $parseObject->tags = null : $parseObject->tags = $event->getTags();
                $event->getThumbnail() == null ? $parseObject->thumbnail = null : $parseObject->thumbnail = $event->getThumbnail();
                $event->getText() == null ? $parseObject->text = null : $parseObject->text = $event->getText();
                $event->getTitle() == null ? $parseObject->title = null : $parseObject->title = $event->getTitle();
                $event->getACL() == null ? $parseObject->ACL = null : $parseObject->ACL = $event->getACL()->acl;
                $res = $parseObject->save();
                return $res->objectId;
            } else {
                if ($event->getActive() != null)
                    $parseObject->active = $event->getActive();
                if ($event->getAttendee() != null)
                    $parseObject->attendee = $event->getAttendee();
                if ($event->getCommentators() != null)
                    $parseObject->commentators = $event->getCommentators();
                if ($event->getComments() != null)
                    $parseObject->comments = $event->getComments();
                if ($event->getCounter() != null)
                    $parseObject->counter = $event->getCounter();
                if ($event->getDescription() != null)
                    $parseObject->description = $event->getDescription();
                if ($event->getEventDate() != null)
                    $parseObject->eventDate = $event->getEventDate();
                if ($event->getFeaturing() != null)
                    $parseObject->featuring = $event->getFeaturing();
                if ($event->getFromUser() != null)
                    $parseObject->fromUser = $event->getFromUser();
                if ($event->getImage() != null)
                    $parseObject->image = $event->getImage();
                if ($event->getImageFile() != null)
                    $parseObject->imageFile = $event->getImageFile();
                if ($event->getLocation() != null)
                    $parseObject->location = $event->getLocation();
                if ($event->getLocationName() != null)
                    $parseObject->locationName = $event->getLocationName();
                if ($event->getLoveCounter() != null)
                    $parseObject->loveCounter = $event->getLoveCounter();
                if ($event->getLovers() != null)
                    $parseObject->lovers = $event->getLovers();
                if ($event->getTags() != null)
                    $parseObject->tags = $event->getTags();
                if ($event->getThumbnail() != null)
                    $parseObject->thumbnail = $event->getThumbnail();
                if ($event->getText() != null)
                    $parseObject->text = $event->getText();
                if ($event->getACL() != null)
                    $parseObject->ACL = $event->getACL()->acl;
                $parseObject->update($event->getObjectId());
            }
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function setLimit($int) {
        $this->parseQuery->setLimit($int);
    }

    public function setSkip($int) {
        $this->parseQuery->setSkip($int);
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