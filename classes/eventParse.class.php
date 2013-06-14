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
        
        $event->setObjectId($parseObj->objectId);
        $event->setActive($parseObj->active);
        $parseQueryAttendee = new parseQuery('_User');
        $parseQueryAttendee->whereRelatedTo('attendee', 'Event', $parseObj->objectId);
        $testAttendee = $parseQueryAttendee->find();
        $attendee = array();
        foreach ($testAttendee->results as $user) {
            $attendee[] = $user->objectId;
        }
        $event->setAttendee($attendee);
        $parseQueryCommentators = new parseQuery('_User');
        $parseQueryCommentators->whereRelatedTo('commentators', 'Event', $parseObj->objectId);
        $testCommentators = $parseQueryCommentators->find();
        $commentators = array();
        foreach ($testCommentators->results as $user) {
            $commentators[] = $user->objectId;
        }
        $event->setCommentators($commentators);
        $parseQueryComment = new parseQuery('Comment');
        $parseQueryComment->whereRelatedTo('comments', 'Event', $parseObj->objectId);
        $testComment = $parseQueryComment->find();
        $comments = array();
        foreach ($testComment->results as $c) {
            $comments[] = $c->objectId;
        }
        $event->setComments($comments);
        $event->setCounter($parseObj->counter);
        $parseQueryFeaturing = new parseQuery('_User');
        $parseQueryFeaturing->whereRelatedTo('featuring', 'Event', $parseObj->objectId);
        $testFeaturing = $parseQueryFeaturing->find();
        $featuring = array();
        foreach ($testFeaturing->results as $user) {
            $featuring[] = $user->objectId;
        }
        $event->setFeaturing($featuring);
        $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
        $event->setLocation($parseGeoPoint->location);
        $event->setLocationName($parseObj->locationName);
        $event->setLoveCounter($parseObj->loveCounter);
        $parseQueryLovers = new parseQuery('_User');
        $parseQueryLovers->whereRelatedTo('lovers', 'Event', $parseObj->objectId);
        $testLovers = $parseQueryLovers->find();
        $lovers = array();
        foreach ($testLovers->results as $user) {
            $lovers[] = $user->objectId;
        }
        $event->setLovers($lovers);
        $parseQueryRefused = new parseQuery('_User');
        $parseQueryRefused->whereRelatedTo('refused', 'Event', $parseObj->objectId);
        $testRefused = $parseQueryRefused->find();
        $refused = array();
        foreach ($testRefused->results as $user) {
            $refused[] = $user->objectId;
        }
        $event->setRefused($refused);
        $event->setTags($parseObj->tags);
        $event->setThumbnail($parseObj->thumbnail);
        $event->setTitle($parseObj->title);
        //creo la data di tipo DateTime per createdAt e updatedAt
        if (isset($parseObj->createdAt))
            $event->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $event->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
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