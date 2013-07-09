<?php
/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Record Class
 *  \details	Classe dedicata ad un album di brani musicali, pu� essere istanziata solo da Jammer
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:record">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:record">API</a>
 */
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
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
	 * \fn		void deleteRecord(string $objectId)
	 * \brief	Set unactive a specified Record by objectId
	 * \param	$objectId the string that represent the objectId of the Record
	 * \return	error in case of exception
	 */
	public function deleteRecord($objectId, $songsId) {
		try {
			$parseObject = new parseObject('Record');
			$parseObject->active = false;
			$parseObject->update($objectId);
			if ($songsId && count($songsId) > 0) {
				$parseSong = new SongParse();
				foreach ($songsId as $songId) {
					$parseSong->deleteSong($songId);
				}
			}
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
		$records = null;
		try {
			$res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$records = array();
				foreach ($res->results as $obj) {
					if ($obj) {
						$record = $this->parseToRecord($obj);
						$records[$record->getObjectId()] = $record;
					}
				}
			}
			return $records;
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
			$record->setCommentCounter($res->commentCounter);
			#$record->setCommentators(fromParseRelation('Record', 'commentators', $res->objectId, '_User'));
			#$record->setComments(fromParseRelation('Record', 'comments', $res->objectId, 'Comment'));
			$record->setCounter($res->counter);
			$record->setCover($res->cover);
			$record->setCoverFile(fromParseFile($res->coverFile));
			$record->setDescription($res->description);
			$record->setDuration($res->duration);
			#$record->setFeaturing(fromParseRelation('Record', 'featuring', $res->objectId, '_User'));
			$record->setFromUser(fromParsePointer($res->fromUser));
			$record->setGenre($res->genre);
			$record->setLabel($res->label);
			$record->setLocation(fromParseGeoPoint($res->location));
			$record->setLoveCounter($res->loveCounter);
			#$record->setLovers(fromParseRelation('Record', 'lovers', $res->objectId, '_User'));
			$record->setShareCounter($res->shareCounter);
			$record->setSongCounter($res->songCounter);
			$record->setThumbnailCover($res->thumbnailCover);
			$record->setTitle($res->title);
			#$record->setTracklist(fromParseRelation('Record', 'tracklist', $res->objectId, 'Song'));
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
			$parseObject = new parseObject('Record');
			is_null($record->getActive()) ? $parseObject->active = true : $parseObject->active = $record->getActive();
			is_null($record->getBuyLink()) ? $parseObject->buyLink = null : $parseObject->buyLink = $record->getBuyLink();
			is_null($record->getCommentCounter()) ? $parseObject->commentCounter = -1 : $parseObject->commentCounter = $record->getCommentCounter();
			is_null($record->getCommentators()) ? $parseObject->commentators = null : $parseObject->commentators = toParseAddRelation('_User', $record->getCommentators());
			is_null($record->getComments()) ? $parseObject->comments = null : $parseObject->comments = toParseAddRelation('Comment', $record->getComments());
			is_null($record->getCounter()) ? $parseObject->counter = -1 : $parseObject->counter = $record->getCounter();
			is_null($record->getCover()) ? $parseObject->cover = 'images/defult/recordImage.jpg' : $parseObject->cover = $record->getCover();
			is_null($record->getCoverFile()) ? $parseObject->coverFile = null : $parseObject->coverFile = toParseFile($record->getCoverFile());
			is_null($record->getDescription()) ? $parseObject->description = null : $parseObject->description = $record->getDescription();
			is_null($record->getDuration()) ? $parseObject->duration = 0 : $parseObject->duration = $record->getDuration();
			is_null($record->getFeaturing()) ? $parseObject->featuring = null : $parseObject->featuring = toParseAddRelation('_User', $record->getFeaturing());
			$parseObject->fromUser = toParsePointer('_User', $record->getFromUser());
			is_null($record->getGenre()) ? $parseObject->genre = null : $parseObject->genre = $record->getGenre();
			is_null($record->getLabel()) ? $parseObject->label = null : $parseObject->label = $record->getLabel();
			is_null($record->getLocation()) ? $parseObject->location = null : $parseObject->location = toParseGeoPoint($record->getLocation());
			is_null($record->getLoveCounter()) ? $parseObject->loveCounter = -1 : $parseObject->loveCounter = $record->getLoveCounter();
			is_null($record->getLovers()) ? $parseObject->lovers = null : $parseObject->lovers = toParseAddRelation('_User', $record->getLovers());
			is_null($record->getShareCounter()) ? $parseObject->shareCounter = -1 : $parseObject->shareCounter = $record->getShareCounter();
			is_null($record->getSongCounter()) ? $parseObject->songCounter = -1 : $parseObject->songCounter = $record->getSongCounter();
			is_null($record->getThumbnailCover()) ? $parseObject->thumbnailCover = 'images/defult/recordThumb.jpg' : $parseObject->thumbnailCover = $record->getThumbnailCover();
			is_null($record->getTitle()) ? $parseObject->title = null : $parseObject->title = $record->getTitle();
			is_null($record->getTracklist()) ? $parseObject->tracklist = null : $parseObject->tracklist = toParseAddRelation('Song', $record->getTracklist());
			is_null($record->getYear()) ? $parseObject->year = null : $parseObject->year = $record->getYear();
			is_null($record->getACL()) ? $parseObject->ACL = toParseDefaultACL() : $parseObject->ACL = toParseACL($record->getACL());
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
		if (is_null($objectId) || is_null($field) || is_null($value))
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