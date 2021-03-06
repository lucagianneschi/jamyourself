<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		RecordParse
 *  \details		Classe dedicata ad un album di brani musicali, puo' essere istanziata solo da Jammer
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-RecordParse">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'songParse.class.php';

class RecordParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Record class
     */
    function __construct() {
	$this->parseQuery = new ParseQuery('Record');
    }

    /**
     * \fn		void decrementRecord(string $objectId, string $field, int $value)
     * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Record
     * \param	$field		the string that represent the field to decrement
     * \param 	$value		the number that represent the quantity to decrease the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function decrementRecord($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
	try {
	    $parseObject = new parseObject('Record');
	    //we use the increment function with a negative value because decrement function still not work
	    $parseObject->increment($field, array(0 - $value));
	    if ($withArray) {
		if (is_null($fieldArray) || empty($valueArray))
		    return throwError(new Exception('decrementRecord parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
		$parseObject->removeArray($fieldArray, $valueArray);
	    }
	    $res = $parseObject->update($objectId);
	    return $res->$field;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void deleteRecord(string $objectId)
     * \brief	Set unactive a specified Record by objectId
     * \param	$objectId the string that represent the objectId of the Record
     * \return	error in case of exception
     */
    public function deleteRecord($objectId) {
	try {
	    require_once BOXES_DIR . 'utilsBox.php';
	    $parseObject = new parseObject('Record');
	    $res = $parseObject->get($objectId);
	    $record = $this->parseToRecord($res);
	    $songs = tracklistGenerator($objectId, MAX);
	    foreach ($songs as $song) {
		$songP = new SongParse();
		$songP->deleteSong($song->getObjectId());
	    }
	    $record->setActive(false);
	    $this->saveRecord($record);
	    $parseObject->update($objectId);
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests Record
     * \return	number
     */
    public function getCount() {
	return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		void getRecord(string $objectId)
     * \brief	The function returns the Record object specified
     * \param	$objectId the string that represent the objectId of the Record
     * \return	Record	the Record with the specified $objectId
     * \return	Error	the Error raised by the function
     */
    function getRecord($objectId) {
	try {
	    $parseObject = new parseObject('Record');
	    $res = $parseObject->get($objectId);
	    return $this->parseToRecord($res);
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		array getRecords()
     * \brief	The function returns the Records objects specified
     * \return	array	an array of Record, if one or more Record are found
     * \return	null	if no Record are found
     * \return	Error	the Error raised by the function
     */
    public function getRecords() {
	try {
	    $records = null;
	    $res = $this->parseQuery->find();
	    if (is_array($res->results) && count($res->results) > 0) {
		$records = array();
		foreach ($res->results as $obj) {
		    $record = $this->parseToRecord($obj);
		    $records[$record->getObjectId()] = $record;
		}
	    }
	    return $records;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void incrementRecord(string $objectId, string $field, int $value)
     * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Record
     * \param	$field		the string that represent the field to increment
     * \param 	$value		the number that represent the quantity to increase the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function incrementRecord($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
	try {
	    $parseObject = new parseObject('Record');
	    $parseObject->increment($field, array($value));
	    if ($withArray) {
		if (is_null($fieldArray) || empty($valueArray))
		    return throwError(new Exception('incrementRecord parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
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
     * \brief	Specifies which field need to be ordered of requested Record
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
	$this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Record
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
	$this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Record
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
	$this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Record parseToRecord($res)
     * \brief	The function returns a representation of an Record object in Parse
     * \param	$res	represent the Record object returned from Parse
     * \return	Record	the Record object
     * \return	Error	the Error raised by the function
     */
    function parseToRecord($res) {
	if (is_null($res))
	    return throwError(new Exception('parseToRecord parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
	try {
	    $record = new Record();
	    $record->setObjectId($res->objectId);
	    $record->setActive($res->active);
	    $record->setBuyLink($res->buyLink);
	    $record->setCity(parse_decode_string($res->city));
	    $record->setCommentCounter($res->commentCounter);
	    $record->setCounter($res->counter);
	    $record->setCity($res->city);
	    $record->setCover($res->cover);
	    $record->setDescription(parse_decode_string($res->description));
	    $record->setDuration($res->duration);
	    $record->setFromUser(fromParsePointer($res->fromUser));
	    $record->setGenre($res->genre);
	    $record->setLabel(parse_decode_string($res->label));
	    $record->setLocation(fromParseGeoPoint($res->location));
	    $record->setLoveCounter($res->loveCounter);
	    $record->setLovers($res->lovers);
	    $record->setReviewCounter($res->reviewCounter);
	    $record->setShareCounter($res->shareCounter);
	    $record->setSongCounter($res->songCounter);
	    $record->setThumbnailCover($res->thumbnailCover);
	    $record->setTitle(parse_decode_string($res->title));
	    $record->setYear($res->year);
	    $record->setCreatedAt(fromParseDate($res->createdAt));
	    $record->setUpdatedAt(fromParseDate($res->updatedAt));
	    $record->setACL(fromParseACL($res->ACL));
	    return $record;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		Record saveRecord(Record $record)
     * \brief	This function save an Record object in Parse
     * \param	$record		represent the Record object to save
     * \return	Record		the Record object with the new objectId parameter saved
     * \return	Error		the Error raised by the function
     */
    function saveRecord($record) {
	if (is_null($record->getFromUser()))
	    return throwError(new Exception('saveRecord parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
	try {
	    $nullArray = array();
	    $parseObject = new parseObject('Record');
	    $parseObject->active = is_null($record->getActive()) ? true : $record->getActive();
	    $parseObject->buyLink = is_null($record->getBuyLink()) ? null : $record->getBuyLink();
	    $parseObject->city = is_null($record->getCity()) ? null : parse_decode_string($record->getCity());
	    $parseObject->commentCounter = is_null($record->getCommentCounter()) ? 0 : $record->getCommentCounter();
	    $parseObject->counter = is_null($record->getCounter()) ? 0 : $record->getCounter();
	    $parseObject->cover = is_null($record->getCover()) ? null : $record->getCover();
	    $parseObject->description = is_null($record->getDescription()) ? null : parse_decode_string($record->getDescription());
	    $parseObject->duration = is_null($record->getDuration()) ? 0 : $record->getDuration();
	    $parseObject->featuring = is_null($record->getFeaturing()) ? null : toParseAddRelation('_User', $record->getFeaturing());
	    $parseObject->fromUser = toParsePointer('_User', $record->getFromUser());
	    $parseObject->genre = is_null($record->getGenre()) ? null : $record->getGenre();
	    $parseObject->label = is_null($record->getLabel()) ? null : parse_decode_string($record->getLabel());
	    $parseObject->location = is_null($record->getLocation()) ? null : toParseGeoPoint($record->getLocation());
	    $parseObject->loveCounter = is_null($record->getLoveCounter()) ? 0 : $record->getLoveCounter();
	    $parseObject->lovers = is_null($record->getLovers()) ? $nullArray : $record->getLovers();
	    $parseObject->reviewCounter = is_null($record->getReviewCounter()) ? 0 : $record->getReviewCounter();
	    $parseObject->shareCounter = is_null($record->getShareCounter()) ? 0 : $record->getShareCounter();
	    $parseObject->songCounter = is_null($record->getSongCounter()) ? 0 : $record->getSongCounter();
	    $parseObject->thumbnailCover = is_null($record->getThumbnailCover()) ? null : $record->getThumbnailCover();
	    $parseObject->title = is_null($record->getTitle()) ? null : parse_decode_string($record->getTitle());
	    $parseObject->tracklist = is_null($record->getTracklist()) ? null : toParseAddRelation('Song', $record->getTracklist());
	    $parseObject->year = is_null($record->getYear()) ? null : $record->getYear();
	    $parseObject->ACL = is_null($record->getACL()) ? toParseDefaultACL() : toParseACL($record->getACL());
	    if ($record->getObjectId() == '') {
		$res = $parseObject->save();
		$record->setObjectId($res->objectId);
		return $record;
	    } else {
		$parseObject->update($record->getObjectId());
	    }
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Record to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
	$this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Record(s) must be discarded initially
     * \param	$skip	the number of Record(s) to skip
     */
    public function setSkip($skip) {
	$this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the Record to update
     * \param	$field			the field of the Record to update
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
		$parseObject = new parseObject('Record');
		$parseObject->$field = toParseAddRelation($className, $value);
		$parseObject->update($objectId);
	    } elseif ($typeRelation == 'remove') {
		$parseObject = new parseObject('Record');
		$parseObject->$field = toParseRemoveRelation($className, $value);
		$parseObject->update($objectId);
	    } else {
		return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
	    }
	} else {
	    $parseObject = new parseObject('Record');
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
     * \fn	whereNearSphere($latitude, $longitude, $distance, $distanceType)
     * \brief	find element in a spherre near the given latitude e longitude
     * \param	$latitude, $longitude
     */
    public function whereNearSphere($latitude, $longitude, $distance = null, $distanceType = null) {
	$this->parseQuery->whereNearSphere('location', $latitude, $longitude, $distance, $distanceType);
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