<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *
 *  \par		Info Classe:
 *  \brief		Event
 *  \details	Classe dedicata agli eventi, solo JAMMER e VENUE possono istanziare questa classe
 *  
 *  \par		Commenti:
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
require_once CLASSES_DIR . 'utilsClass.php';
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
     * \fn		void decrementEvent(string $objectId, string $field, int $value)
     * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Comment
     * \param	$field		the string that represent the field to decrement
     * \param 	$value		the number that represent the quantity to decrease the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function decrementEvent($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
	try {
	    $parseObject = new parseObject('Event');
	    //we use the increment function with a negative value because decrement function still not work
	    $parseObject->increment($field, array(0 - $value));
	    if ($withArray) {
		if (is_null($fieldArray) || empty($valueArray))
		    return throwError(new Exception('decrementEvent parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
		$parseObject->removeArray($fieldArray, $valueArray);
	    }
	    $res = $parseObject->update($objectId);
	    return $res->$field;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
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
	try {
	    $events = null;
	    $res = $this->parseQuery->find();
	    if (is_array($res->results) && count($res->results) > 0) {
		$events = array();
		foreach ($res->results as $obj) {
		    $event = $this->parseToEvent($obj);
		    $events[$event->getObjectId()] = $event;
		}
	    }
	    return $events;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void incrementEvent(string $objectId, string $field, int $value)
     * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Comment
     * \param	$field		the string that represent the field to increment
     * \param 	$value		the number that represent the quantity to increase the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function incrementEvent($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
	try {
	    $parseObject = new parseObject('Event');
	    $parseObject->increment($field, array($value));
	    if ($withArray) {
		if (is_null($fieldArray) || empty($valueArray))
		    return throwError(new Exception('incrementEvent parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
		$parseObject->addUniqueArray($fieldArray, $valueArray);
	    }
	    $res = $parseObject->update($objectId);
	    return $res->$field;
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
	    $event->setAddress(parse_decode_string($res->address));
	    $event->setCity(parse_decode_string($res->city));
	    $event->setCommentCounter($res->commentCounter);
	    $event->setCounter($res->counter);
	    $event->setDescription(parse_decode_string($res->description));
	    $event->setEventDate(fromParseDate($res->eventDate));
	    $event->setFromUser(fromParsePointer($res->fromUser));
	    $event->setImage($res->image);
	    $event->setImageFile(fromParseFile($res->image, "image/jpeg"));
	    $event->setLocation(fromParseGeoPoint($res->location));
	    $event->setLocationName(parse_decode_string($res->locationName));
	    $event->setLoveCounter($res->loveCounter);
	    $event->setLovers($res->lovers);
	    $event->setReviewCounter($res->reviewCounter);
	    $event->setShareCounter($res->shareCounter);
	    $event->setTags(parse_decode_array($res->tags));
	    $event->setThumbnail($res->thumbnail);
	    $event->setTitle(parse_decode_string($res->title));
	    $event->setCreatedAt(fromParseDate($res->createdAt));
	    $event->setUpdatedAt(fromParseDate($res->updatedAt));
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
	    $nullArray = array();
	    $parseEvent = new parseObject('Event');
	    is_null($event->getActive()) ? $parseEvent->active = true : $parseEvent->active = $event->getActive();
	    is_null($event->getAddress()) ? $parseEvent->address = null : $parseEvent->address = parse_encode_string($event->getAddress());
	    is_null($event->getAttendee()) ? $parseEvent->attendee = null : $parseEvent->attendee = toParseAddRelation('_User', $event->getAttendee());
	    is_null($event->getCity()) ? $parseEvent->city = null : $parseEvent->city = parse_encode_string($event->getCity());
	    is_null($event->getCommentCounter()) ? $parseEvent->commentCounter = -1 : $parseEvent->commentCounter = $event->getCommentCounter();
	    is_null($event->getCommentators()) ? $parseEvent->commentators = null : $parseEvent->commentators = toParseAddRelation('_User', $event->getCommentators());
	    is_null($event->getComments()) ? $parseEvent->comments = null : $parseEvent->comments = toParseAddRelation('Comment', $event->getComments());
	    is_null($event->getCounter()) ? $parseEvent->counter = -1 : $parseEvent->counter = $event->getCounter();
	    is_null($event->getDescription()) ? $parseEvent->description = null : $parseEvent->description = parse_encode_string($event->getDescription());
	    is_null($event->getEventDate()) ? $parseEvent->eventDate = null : $parseEvent->eventDate = toParseDate($event->getEventDate());
	    is_null($event->getFeaturing()) ? $parseEvent->featuring = null : $parseEvent->featuring = toParseAddRelation('_User', $event->getFeaturing());
	    $parseEvent->fromUser = toParsePointer('_User', $event->getFromUser());
	    is_null($event->getImage()) ? $parseEvent->image = DEFEVENTIMAGE : $parseEvent->image = $event->getImage();
	    is_null($event->getInvited()) ? $parseEvent->invited = null : $parseEvent->invited = toParseAddRelation('_User', $event->getInvited());
	    is_null($event->getLocation()) ? $parseEvent->location = null : $parseEvent->location = toParseGeoPoint($event->getLocation());
	    is_null($event->getLocationName()) ? $parseEvent->locationName = null : $parseEvent->locationName = parse_encode_string($event->getLocationName());
	    is_null($event->getLoveCounter()) ? $parseEvent->loveCounter = -1 : $parseEvent->loveCounter = $event->getLoveCounter();
	    is_null($event->getLovers()) ? $parseEvent->lovers = $nullArray : $parseEvent->lovers = $event->getLovers();
	    is_null($event->getReviewCounter()) ? $parseObject->reviewCounter = -1 : $parseObject->reviewCounter = $event->getReviewCounter();
	    is_null($event->getShareCounter()) ? $parseEvent->shareCounter = -1 : $parseEvent->shareCounter = $event->getShareCounter();
	    is_null($event->getRefused()) ? $parseEvent->refused = null : $parseEvent->refused = toParseAddRelation('_User', $event->getRefused());
	    is_null($event->getTags()) ? $parseEvent->tags = $nullArray : $parseEvent->tags = parse_encode_array($event->getTags());
	    is_null($event->getThumbnail()) ? $parseEvent->thumbnail = DEFEVENTTHUMB : $parseEvent->thumbnail = $event->getThumbnail();
	    is_null($event->getTitle()) ? $parseEvent->title = null : $parseEvent->title = parse_encode_string($event->getTitle());
	    is_null($event->getACL()) ? $parseEvent->ACL = toParseDefaultACL() : $parseEvent->ACL = toParseACL($event->getACL());
	    if ($event->getObjectId() == '') {
		# TODO
		# is_null($event->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseNewFile($event->getImage(), "img/jpg");
		$res = $parseEvent->save();
		$event->setObjectId($res->objectId);
		return $event;
	    } else {
		# TODO
		# is_null($event->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseFile($event->getImage());
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
     * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the Event to update
     * \param	$field			the field of the Event to update
     * \param	$value			the value to update te field
     * \param	$isRelation		[optional] default = false - define if the field is a relational type
     * \param	$typeRelation	[optional] default = '' - define if the relational update must add or remove the value from the field
     * \param	$className		[optional] default = '' - define the class of the type of object present into the relational field
     */
    public function updateField($objectId, $field, $value, $isRelation = false, $typeRelation = '', $className = '') {
	if (is_null($objectId) || is_null($field))
	    return throwError(new Exception('updateField parameters objectId, field and value must to be set'), __CLASS__, __FUNCTION__, func_get_args());
	if ($isRelation) {
	    if (is_null($typeRelation) || is_null($className))
		return throwError(new Exception('updateField parameters typeRelation and className must to be set for relation update'), __CLASS__, __FUNCTION__, func_get_args());
	    if ($typeRelation == 'add') {
		$parseObject = new parseObject('Event');
		$parseObject->$field = toParseAddRelation($className, $value);
		$parseObject->update($objectId);
	    } elseif ($typeRelation == 'remove') {
		$parseObject = new parseObject('Event');
		$parseObject->$field = toParseRemoveRelation($className, $value);
		$parseObject->update($objectId);
	    } else {
		return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
	    }
	} else {
	    $parseObject = new parseObject('Event');
	    $parseObject->$field = $value;
	    $parseObject->update($objectId);
	}
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
     * \fn		void whereInclude($field)
     * \brief	Sets a condition for which the field $field, that represent a Pointer, must return all the entire object
     * \param	$field	the string which represent the field
     */
    public function whereInclude($field) {
	$this->parseQuery->whereInclude($field);
    }

    /**
     * \fn	whereInQuery($field, $className, $array)
     * \brief	Sets a condition for which the field $field matches a value in the array $array
     * \param	$field, $className, $array
     */
    public function whereInQuery($field, $className, $array) {
	$this->parseQuery->whereInQuery($field, $className, $array);
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

    /**
     * \fn	whereNearSphere($latitude, $longitude)
     * \brief	find element in a spherre near the given latitude e longitude
     * \param	$latitude, $longitude
     */
    public function whereNearSphere($latitude, $longitude) {
	$this->parseQuery->whereNearSphere('location', $latitude, $longitude);
    }

    /**
     * \fn	whereNotInQuery($field, $className, $array)
     * \brief	Sets a condition for which the field $field does not match a value in the array $array
     * \param	$field, $className, $array
     */
    public function whereNotInQuery($field, $className, $array) {
	$this->parseQuery->whereNotInQuery($field, $className, $array);
    }

    /**
     * \fn		void whereOr($value)
     * \brief	Sets a condition for which the field in the array $value must value al least one value
     * 			An example of $value is:
     * 			$value = array(
     * 				array('type' => 'EVENTUPDATED'),
     * 				array('album' => array('__type' => 'Pointer', 'className' => 'Album', 'objectId' => 'lK0bNWIi7k'))
     * 			);
     * \param	$field	the array representing the field and the value to put in or
     */
    public function whereOr($value) {
	$this->parseQuery->where('$or', $value);
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

    /**
     * \fn		void whereRelatedTo($field, $className, $objectId)
     * \brief	Sets a condition for which to return all the Comment objects present in the field $field of object $objectId of type $className
     * \param	$field		the string which represent the field
     * \param	$className	the string which represent the className
     * \param	$objectId	the string which represent the objectId
     */
    public function whereRelatedTo($field, $className, $objectId) {
	$this->parseQuery->whereRelatedTo($field, $className, $objectId);
    }

}

?>