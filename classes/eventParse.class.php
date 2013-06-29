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
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'event.class.php';

class EventParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Event class
     */
    public function __construct() {
        $this->parseQuery = new parseQuery('Event');
    }

    /**
     * \fn		void deleteEvent(string $objectId)
     * \brief	Set unactive a specified Event by objectId
     * \param   $objectId the string that represent the objectId of the Event
     * \return	error in case of exception
     */
    public function deleteEvent($objectId) {
        try {
            $parseEvent = new parseObject('Event');
            $parseEvent->active = false;
            $parseEvent->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests Event
     * \return	number
     */
    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		void getEvent(string $objectId)
     * \brief	The function returns the Event object specified
     * \param	$objectId the string that represent the objectId of the Event
     * \return	Event	the Event with the specified $objectId
     * \return	Error	the Error raised by the function
     */
    public function getEvent($objectId) {
        try {
            $parseEvent = new parseObject('Event');
            $res = $parseEvent->get($objectId);
            $event = $this->parseToEvent($res);
            return $event;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    /**
     * \fn		array getEvents()
     * \brief	The function returns the Events objects specified
     * \return	array 	an array of Event, if one or more Event are found
     * \return	null	if no Event are found
     * \return	Error	the Error raised by the function
     */
    public function getEvents() {
        $events = null;
        try {
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $events = array();
                foreach ($res->results as $obj) {
                    if ($obj) {
                        $event = $this->parseToEvent($obj);
                        $events[$event->getObjectId] = $event;
                    }
                }
            }
            return $events;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void orderBy($field)
     * \brief	Specifies which field need to be ordered of requested Error
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Error
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Error
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Event parseToEvent($res)
     * \brief	The function returns a representation of an Event object in Parse
     * \param	$res 	represent the Event object returned from Parse
     * \return	Event	the Event object
     * \return	Error	the Error raised by the function
     */
    function parseToEvent($res) {
        if (is_null($res))
            return throwError(new Exception('parseToEvent parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $event = new Event();
            $event->setObjectId($res->objectId);
            $event->setActive($res->active);
            $attendee = fromParseRelation('Event', 'attendee', $res->objectId, '_User');
            $event->setAttendee($attendee);
            $commentators = fromParseRelation('Event', 'commentators', $res->objectId, '_User');
            $event->setCommentators($commentators);
            $comments = fromParseRelation('Event', 'comments', $res->objectId, 'Comment');
            $event->setComments($comments);
            $event->setCounter($res->counter);
            $featuring = fromParseRelation('Event', 'featuring', $res->objectId, '_User');
            $event->setFeaturing($featuring);
            $fromUser = fromParsePointer($res->fromUser);
            $event->setFromUser($fromUser);
            $parseGeoPoint = new parseGeoPoint($res->location->latitude, $res->location->longitude);
            $event->setLocation($parseGeoPoint);
            $event->setLocationName($res->locationName);
            $event->setLoveCounter($res->loveCounter);
            $lovers = fromParseRelation('Event', 'lovers', $res->objectId, '_User');
            $event->setLovers($lovers);
            $refused = fromParseRelation('Event', 'refused', $res->objectId, '_User');
            $event->setLovers($refused);
            $event->setTags($res->tags);
            $event->setThumbnail($res->thumbnail);
            $event->setTitle($res->title);
            $event->setCreatedAt(new DateTime($res->createdAt));
            $event->setUpdatedAt(new DateTime($res->updatedAt));
            $event->setACL(fromParseACL($res->ACL));
            return $event;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    /**
     * \fn		Event saveEvent(Event $event)
     * \brief	This function save an Event object in Parse
     * \param	$event 	represent the Event object to save
     * \return	Event	the Event object with the new objectId parameter saved
     * \return	Error	the Error raised by the function
     */
    public function saveEvent($event) {
        if (is_null($event->getFromUser()))
            return throwError(new Exception('saveEvent parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $parseEvent = new parseObject('Event');
            is_null($event->getActive()) ? $parseEvent->active = true : $parseEvent->active = $event->getActive();
            is_null($event->getAttendee()) ? $parseEvent->attendee = null : $parseEvent->attendee = toParseRelation('_User', $event->getAttendee());
            is_null($event->getCommentators()) ? $parseEvent->commentators = null : $parseEvent->commentators = toParseRelation('_User', $event->getCommentators());
            is_null($event->getComments()) ? $parseEvent->comments = null : $parseEvent->comments = toParseRelation('Comment', $event->getComments());
            is_null($event->getCounter()) ? $parseEvent->counter = -1 : $parseEvent->counter = $event->getCounter();
            is_null($event->getDescription()) ? $parseEvent->description = null : $parseEvent->description = $event->getDescription();
            is_null($event->getEventDate()) ? $parseEvent->eventDate = null : $parseEvent->eventDate = toParseDateTime($event->getEventDate());
            is_null($event->getFeaturing()) ? $parseEvent->featuring = null : $parseEvent->featuring = toParseRelation('_User', $event->getFeaturing());
            is_null($event->getFromUser()) ? $parseEvent->fromUser = null : $parseEvent->fromUser = toParsePointer('_User', $event->getFromUser());
            is_null($event->getImage()) ? $parseEvent->image = 'images/defult/eventImage.jpg' : $parseEvent->image = toParsePointer('Image', $event->getImage());
            is_null($event->getInvited()) ? $parseEvent->invited = null : $parseEvent->invited = toParseRelation('_User', $event->getInvited());
            is_null($event->getLocation()) ? $parseEvent->location = null : $parseEvent->location = $event->getLocation();
            is_null($event->getLocationName()) ? $parseEvent->locationName = null : $parseEvent->locationName = $event->getLocationName();
            is_null($event->getLoveCounter()) ? $parseEvent->loveCounter = -1 : $parseEvent->loveCounter = $event->getLoveCounter();
            is_null($event->getLovers()) ? $parseEvent->lovers = null : $parseEvent->lovers = toParseRelation('_User', $event->getLovers());
            is_null($event->getRefused()) ? $parseEvent->refused = null : $parseEvent->refused = toParseRelation('_User', $event->getRefused());
            is_null($event->getTags()) ? $parseEvent->tags = null : $parseEvent->tags = $event->getTags();
            is_null($event->getThumbnail()) ? $parseEvent->thumbnail = 'images/defult/eventThumb.jpg' : $parseEvent->thumbnail = $event->getThumbnail();
            is_null($event->getText()) ? $parseEvent->text = null : $parseEvent->text = $event->getText();
            is_null($event->getTitle()) ? $parseEvent->title = null : $parseEvent->title = $event->getTitle();
            $acl = new ParseACL();
            $acl->setPublicReadAccess(true);
            $acl->setPublicWriteAccess(true);
            is_null($event->getACL()) ? $parseEvent->ACL = $acl : $parseEvent->ACL = toParseACL($event->getACL());
            if ($event->getObjectId() == '') {
                is_null($event->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseNewFile($event->getImage(), "img/jpg");
                $res = $parseEvent->save();
                $event->setObjectId($res->objectId);
                return $event;
            } else {
                is_null($event->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseFile($event->getImage());
                $parseEvent->update($event->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Error to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Error(s) must be discarded initially
     * \param	$skip	the number of Error(s) to skip
     */
    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void where($field, $value)
     * \brief	Sets a condition for which the field $field must value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function where($field, $value) {
        $this->parseQuery->where($field, $value);
    }

    /**
     * \fn		void whereContainedIn($field, $value)
     * \brief	Sets a condition for which the field $field must value one or more $value
     * \param	$field	the string which represent the field
     * \param	$value	the array which represent the values
     */
    public function whereContainedIn($field, $values) {
        $this->parseQuery->whereContainedIn($field, $values);
    }

    /**
     * \fn		void whereEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereEqualTo($field, $value) {
        $this->parseQuery->whereEqualTo($field, $value);
    }

    /**
     * \fn		void whereExists($field)
     * \brief	Sets a condition for which the field $field must be enhanced
     * \param	$field	the string which represent the field
     */
    public function whereExists($field) {
        $this->parseQuery->whereExists($field);
    }

    /**
     * \fn		void whereGreaterThan($field, $value)
     * \brief	Sets a condition for which the field $field must value more than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereGreaterThan($field, $value) {
        $this->parseQuery->whereGreaterThan($field, $value);
    }

    /**
     * \fn		void whereGreaterThanOrEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value equal or more than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereGreaterThanOrEqualTo($field, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
    }

    /**
     * \fn		void whereLessThan($field, $value)
     * \brief	Sets a condition for which the field $field must value less than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereLessThan($field, $value) {
        $this->parseQuery->whereLessThan($field, $value);
    }

    /**
     * \fn		void whereLessThanOrEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value equal or less than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereLessThanOrEqualTo($field, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($field, $value);
    }

    /**
     * \fn		void whereNotContainedIn($field, $value)
     * \brief	Sets a condition for which the field $field must not value one or more $value
     * \param	$field	the string which represent the field
     * \param	$value	the array which represent the values
     */
    public function whereNotContainedIn($field, $array) {
        $this->parseQuery->whereNotContainedIn($field, $array);
    }

    /**
     * \fn		void whereNotEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must not value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereNotEqualTo($field, $value) {
        $this->parseQuery->whereNotEqualTo($field, $value);
    }

    /**
     * \fn		void whereNotExists($field)
     * \brief	Sets a condition for which the field $field must not be enhanced
     * \param	$field	the string which represent the field
     */
    public function whereNotExists($field) {
        $this->parseQuery->whereDoesNotExist($field);
    }

    public function whereRelatedTo($field, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($field, $className, $objectId);
    }

    /**
     * \fn		void wherePointer($field, $className, $objectId)
     * \brief	Sets a condition for which the field $field must contain a Pointer to the class $className with pointer value $objectId
     * \param	$field		the string which represent the field
     * \param	$className	the string which represent the className of the Pointer
     * \param	$objectId	the string which represent the objectId of the Pointer
     */
    public function wherePointer($field, $className, $objectId) {
        $this->parseQuery->wherePointer($field, $className, $objectId);
    }

}

?>