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
require_once CLASSES_DIR . 'utils.class.php';

require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

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
            //qui creo una activity EVENTDELETED
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

     public function getEvents() {
        $events = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $events = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $event = $this->parseToEvent($obj);
                        $events[$event->getObjectId] = $event;
                    }
                }
            }
            return $events;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
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
        try {
            $event = new Event();
            $event->setObjectId($parseObj->objectId);
            $event->setActive($parseObj->active);
            $attendee = fromParseRelation('Event', 'attendee', $parseObj->objectId, '_User');
            $event->setAttendee($attendee);
            $commentators = fromParseRelation('Event', 'commentators', $parseObj->objectId, '_User');
            $event->setCommentators($commentators);
            $comments = fromParseRelation('Event', 'comments', $parseObj->objectId, 'Comment');
            $event->setComments($comments);
            $event->setCounter($parseObj->counter);
            $featuring = fromParseRelation('Event', 'featuring', $parseObj->objectId, '_User');
            $event->setFeaturing($featuring);
            $fromUser = fromParsePointer($parseObj->fromUser);
            $event->setFromUser($fromUser);
            $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
            $event->setLocation($parseGeoPoint);
            $event->setLocationName($parseObj->locationName);
            $event->setLoveCounter($parseObj->loveCounter);
            $lovers = fromParseRelation('Event', 'lovers', $parseObj->objectId, '_User');
            $event->setLovers($lovers);
            $refused = fromParseRelation('Event', 'refused', $parseObj->objectId, '_User');
            $event->setLovers($refused);
            $event->setTags($parseObj->tags);
            $event->setThumbnail($parseObj->thumbnail);
            $event->setTitle($parseObj->title);
            $event->setCreatedAt(new DateTime($parseObj->createdAt));
            $event->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $event->setACL(fromParseACL($parseObj->ACL));
            return $event;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function saveEvent(Event $event) {
        try {
            $parseObject = new parseObject('Event');
            is_null($event->getActive()) ? $parseObject->active = null : $parseObject->active = $event->getActive();
            is_null($event->getAttendee()) ? $parseObject->attendee = null : $parseObject->attendee = toParseRelation('_User', $event->getAttendee());
            is_null($event->getCommentators()) ? $parseObject->commentators = null : $parseObject->commentators = toParseRelation('_User', $event->getCommentators());
            is_null($event->getComments()) ? $parseObject->comments = null : $parseObject->comments = toParseRelation('Comment', $event->getComments());
            is_null($event->getCounter()) ? $parseObject->counter = null : $parseObject->counter = $event->getCounter();
            is_null($event->getDescription()) ? $parseObject->description = null : $parseObject->description = $event->getDescription();
            is_null($event->getEventDate()) ? $parseObject->eventDate = null : $parseObject->eventDate = toParseDateTime($event->getEventDate());
            is_null($event->getFeaturing()) ? $parseObject->featuring = null : $parseObject->featuring = toParseRelation('_User', $event->getFeaturing());
            is_null($event->getFromUser()) ? $parseObject->fromUser = null : $parseObject->fromUser = toParsePointer('_User', $event->getFromUser());
            is_null($event->getImage()) ? $parseObject->image = null : $parseObject->image = toParsePointer('Image', $event->getImage());
            is_null($event->getInvited()) ? $parseObject->invited = null : $parseObject->invited = toParseRelation('_User', $event->getInvited());
            is_null($event->getLocation()) ? $parseObject->location = null : $parseObject->location = $event->getLocation();
            is_null($event->getLocationName()) ? $parseObject->locationName = null : $parseObject->locationName = $event->getLocationName();
            is_null($event->getLoveCounter()) ? $parseObject->loveCounter = null : $parseObject->loveCounter = $event->getLoveCounter();
            is_null($event->getLovers()) ? $parseObject->lovers = null : $parseObject->lovers = toParseRelation('_User', $event->getLovers());
            is_null($event->getRefused()) ? $parseObject->refused = null : $parseObject->refused = toParseRelation('_User', $event->getRefused());
            is_null($event->getTags()) ? $parseObject->tags = null : $parseObject->tags = $event->getTags();
            is_null($event->getThumbnail()) ? $parseObject->thumbnail = null : $parseObject->thumbnail = $event->getThumbnail();
            is_null($event->getText()) ? $parseObject->text = null : $parseObject->text = $event->getText();
            is_null($event->getTitle()) ? $parseObject->title = null : $parseObject->title = $event->getTitle();
            $acl = new ParseACL;
            $acl->setPublicReadAccess(true);
            $acl->setPublicWriteAccess(true);
            $event->setACL($acl);
            if ($event->getObjectId() == '') {
                is_null($event->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseNewFile($event->getImage(), "img/jpg");
                $res = $parseObject->save();
                $event->setObjectId($res->objectId);
                 //qui creo una activity EVENTCREATED
                return $event;
            } else {
                is_null($event->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseFile($event->getImage());
                $parseObject->update($event->getObjectId());
                //qui creo una activity EVENTUPDATED
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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