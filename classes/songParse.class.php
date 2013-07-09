<?php
/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Song Class
 *  \details	Classe dedicata al singolo brano, pu� essere istanziata solo da Jammer
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
require_once CLASSES_DIR . 'utils.php';
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
	function getSong($objectId) {
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
	function parseToSong($res) {
		if (is_null($res))
			return throwError(new Exception('parseToSong parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$song = new Song();
			$song->setObjectId($res->objectId);
			$song->setActive($res->active);
			$song->setCommentCounter($res->commentCounter);
			#$song->setCommentators(fromParseRelation('Song', 'commentators', $res->objectId, '_User'));
			#$song->setComments(fromParseRelation('Song', 'comments', $res->objectId, 'Comment'));
			$song->setCounter($res->counter);
			$song->setDuration($res->duration);
			#$song->setFeaturing(fromParseRelation('Song', 'featuring', $res->objectId, '_User'));
			$song->setFilePath($res->filePath);
			$song->setFromUser(fromParsePointer($res->fromUser));
			$song->setGenre($res->genre);
			$song->setLocation(fromParseGeoPoint($res->location));
			$song->setLoveCounter($res->loveCounter);
			#$song->setLovers(fromParseRelation('Song', 'lovers', $res->objectId, '_User'));
			$song->setRecord(fromParsePointer($res->record));
			$song->setShareCounter($res->shareCounter);
			$song->setTitle($res->title);
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
	function saveSong($song) {
		if (is_null($song->getFromUser()))
			return throwError(new Exception('saveSong parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$parseSong = new parseObject('Song');
			is_null($song->getActive()) ? $parseSong->active = true : $parseSong->active = $song->getActive();
			is_null($song->getCommentCounter()) ? $parseSong->commentCounter = -1 : $parseSong->commentCounter = $song->getCommentCounter();
			is_null($song->getCommentators()) ? $parseSong->commentators = null : $parseSong->commentators = toParseAddRelation('_User', $song->getCommentators());
			is_null($song->getComments()) ? $parseSong->comments = null : $parseSong->comments = toParseAddRelation('Comment', $song->getComments());
			is_null($song->getCounter()) ? $parseSong->counter = -1 : $parseSong->counter = $song->getCounter();
			is_null($song->getDuration()) ? $parseSong->duration = 0 : $parseSong->duration = $song->getDuration();
			is_null($song->getFeaturing()) ? $parseSong->featuring = null : $parseSong->featuring = toParseAddRelation('_User', $song->getFeaturing());
			is_null($song->getFilePath()) ? $parseSong->filePath = null : $parseSong->filePath = $song->getFilePath();
			$parseSong->fromUser = toParsePointer('_User', $song->getFromUser());
			is_null($song->getGenre()) ? $parseSong->genre = null : $parseSong->genre = $song->getGenre();
			is_null($song->getLocation()) ? $parseSong->location = null : $parseSong->location = toParseGeoPoint($song->getLocation());
			is_null($song->getLoveCounter()) ? $parseSong->loveCounter = -1 : $parseSong->loveCounter = $song->getLoveCounter();
			is_null($song->getLovers()) ? $parseSong->lovers = null : $parseSong->lovers = toParseAddRelation('_User', $song->getLovers());
			is_null($song->getRecord()) ? $parseSong->record = null : $parseSong->record = toParsePointer('Record', $song->getRecord());
			is_null($song->getShareCounter()) ? $parseSong->shareCounter = -1 : $parseSong->shareCounter = $song->getShareCounter();
			is_null($song->getTitle()) ? $parseSong->title = null : $parseSong->title = $song->getTitle();
			is_null($song->getACL()) ? $parseSong->ACL = toParseDefaultACL() : $parseSong->ACL = toParseACL($song->getACL());
			if ($song->getObjectId() == '') {
				$res = $parseSong->save();
				$song->setObjectId($res->objectId);
				return $song;
			} else {
				$parseSong->update($song->getObjectId());
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
		if (is_null($objectId) || is_null($field) || is_null($value))
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

?>