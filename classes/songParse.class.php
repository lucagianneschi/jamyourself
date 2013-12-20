<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Song Class
 *  \details		Classe dedicata al singolo brano, pu� essere istanziata solo da Jammer
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:song">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:song">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'song.class.php';

class SongParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Song class
     */
    public function __construct() {
	$this->parseQuery = new parseQuery('Song');
    }

    /**
     * \fn		void decrementSong(string $objectId, string $field, int $value)
     * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Song
     * \param	$field		the string that represent the field to decrement
     * \param 	$value		the number that represent the quantity to decrease the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function decrementSong($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
	try {
	    $parseObject = new parseObject('Song');
	    //we use the increment function with a negative value because decrement function still not work
	    $parseObject->increment($field, array(0 - $value));
	    if ($withArray) {
		if (is_null($fieldArray) || empty($valueArray))
		    return throwError(new Exception('decrementSong parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
		$parseObject->removeArray($fieldArray, $valueArray);
	    }
	    $res = $parseObject->update($objectId);
	    return $res->$field;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void deleteSong(string $objectId)
     * \brief	Set unactive a specified Song by objectId
     * \param	$objectId the string that represent the objectId of the Song
     * \return	error in case of exception
     */
    public function deleteSong($objectId) {
	try {
	    $parseObject = new parseObject('Song');
	    $parseObject->active = false;
	    $parseObject->update($objectId);
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests Song
     * \return	number
     */
    public function getCount() {
	$this->parseQuery->getCount();
    }

    /**
     * \fn		void getSong(string $objectId)
     * \brief	The function returns the Song object specified
     * \param	$objectId the string that represent the objectId of the Song
     * \return	Song	the Song with the specified $objectId
     * \return	Error	the Error raised by the function
     */
    public function getSong($objectId) {
	try {
	    $parseObject = new parseObject('Song');
	    $res = $parseObject->get($objectId);
	    return $this->parseToSong($res);
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		array getSong()
     * \brief	The function returns the Song objects specified
     * \return	array	an array of Song, if one or more Song are found
     * \return	null	if no Song are found
     * \return	Error	the Error raised by the function
     */
    public function getSongs() {
	try {
	    $songs = null;
	    $res = $this->parseQuery->find();
	    if (is_array($res->results) && count($res->results) > 0) {
		$songs = array();
		foreach ($res->results as $obj) {
		    $song = $this->parseToSong($obj);
		    $songs[$song->getObjectId()] = $song;
		}
	    }
	    return $songs;
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void incrementSong(string $objectId, string $field, int $value)
     * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the Song
     * \param	$field		the string that represent the field to increment
     * \param 	$value		the number that represent the quantity to increase the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function incrementSong($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
	try {
	    $parseObject = new parseObject('Song');
	    $parseObject->increment($field, array($value));
	    if ($withArray) {
		if (is_null($fieldArray) || empty($valueArray))
		    return throwError(new Exception('incrementSong parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
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
     * \brief	Specifies which field need to be ordered of requested Song
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
	$this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Song
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
	$this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Song
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
	$this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Song parseToSong($res)
     * \brief	The function returns a representation of an Song object in Parse
     * \param	$res	represent the Song object returned from Parse
     * \return	Song	the Song object
     * \return	Error	the Error raised by the function
     */
    public function parseToSong($res) {
	if (is_null($res))
	    return throwError(new Exception('parseToSong parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
	try {
	    $song = new Song();
	    $song->setObjectId($res->objectId);
	    $song->setActive($res->active);
	    $song->setCommentCounter($res->commentCounter);
	    $song->setCounter($res->counter);
	    $song->setDuration($res->duration);
	    $song->setFilePath($res->filePath);
	    $song->setFromUser(fromParsePointer($res->fromUser));
	    $song->setGenre($res->genre);
	    $song->setLocation(fromParseGeoPoint($res->location));
	    $song->setLoveCounter($res->loveCounter);
	    $song->setLovers($res->lovers);
	    $song->setPosition($res->position);
	    $song->setRecord(fromParsePointer($res->record));
	    $song->setShareCounter($res->shareCounter);
	    $song->setTitle(parse_decode_string($res->title));
	    $song->setCreatedAt(fromParseDate($res->createdAt));
	    $song->setUpdatedAt(fromParseDate($res->updatedAt));
	    $song->setACL(fromParseACL($res->ACL));
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
	return $song;
    }

    /**
     * \fn		Song saveSong(Song $song)
     * \brief	This function save an Song object in Parse
     * \param	$song	represent the Song object to save
     * \return	Song	the Song object with the new objectId parameter saved
     * \return	Error	the Error raised by the function
     */
    public function saveSong($song) {
	if (is_null($song->getFromUser()))
	    return throwError(new Exception('saveSong parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
	try {
	    $nullArray = array();
	    $parseObject = new parseObject('Song');
	    $parseObject->active = is_null($song->getActive()) ? true : $song->getActive();
	    $parseObject->commentCounter = is_null($song->getCommentCounter()) ? 0 : $song->getCommentCounter();
	    $parseObject->counter = is_null($song->getCounter()) ? 0 : $song->getCounter();
	    $parseObject->duration = is_null($song->getDuration()) ? 0 : $song->getDuration();
	    $parseObject->featuring = is_null($song->getFeaturing()) ? null : toParseAddRelation('_User', $song->getFeaturing());
	    $parseObject->filePath = is_null($song->getFilePath()) ? null : $song->getFilePath();
	    $parseObject->fromUser = toParsePointer('_User', $song->getFromUser());
	    $parseObject->genre = is_null($song->getGenre()) ? null : parse_encode_array($song->getGenre());
	    $parseObject->location = is_null($song->getLocation()) ? null : toParseGeoPoint($song->getLocation());
	    $parseObject->loveCounter = is_null($song->getLoveCounter()) ? 0 : $song->getLoveCounter();
	    $parseObject->lovers = is_null($song->getLovers()) ? $nullArray : $song->getLovers();
	    $parseObject->position = is_null($song->getPosition()) ? 0 : $song->getPosition();
	    $parseObject->record = is_null($song->getRecord()) ? null : toParsePointer('Record', $song->getRecord());
	    $parseObject->shareCounter = is_null($song->getShareCounter()) ? 0 : $song->getShareCounter();
	    $parseObject->title = is_null($song->getTitle()) ? null : parse_encode_string($song->getTitle());
	    $parseObject->ACL = is_null($song->getACL()) ? toParseDefaultACL() : toParseACL($song->getACL());
	    if ($song->getObjectId() == '') {
		$res = $parseObject->save();
		$song->setObjectId($res->objectId);
		return $song;
	    } else {
		$parseObject->update($song->getObjectId());
	    }
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Song to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
	$this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Song(s) must be discarded initially
     * \param	$skip	the number of Song(s) to skip
     */
    public function setSkip($skip) {
	$this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the Song to update
     * \param	$field			the field of the Song to update
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
		$parseObject = new parseObject('Song');
		$parseObject->$field = toParseAddRelation($className, $value);
		$parseObject->update($objectId);
	    } elseif ($typeRelation == 'remove') {
		$parseObject = new parseObject('Song');
		$parseObject->$field = toParseRemoveRelation($className, $value);
		$parseObject->update($objectId);
	    } else {
		return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
	    }
	} else {
	    $parseObject = new parseObject('Song');
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

?>