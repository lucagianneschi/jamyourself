<?php
/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Stutus Class
 *  \details	Classe status dello User, raccoglie uno stato dell'utente, posso collegarci immagine o song
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:status">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:status">API</a>
 */
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'status.class.php';

class StatusParse {

	private $parseQuery;

	/**
	 * \fn		void __construct()
	 * \brief	The constructor instantiates a new object of type ParseQuery on the Status class
	 */
	public function __construct() {
		$this->parseQuery = new ParseQuery('Status');
	}

	/**
	 * \fn		void decrementStatus(string $objectId, string $field, int $value)
	 * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
	 * \param	$objectId	the string that represent the objectId of the Status
	 * \param	$field		the string that represent the field to decrement
	 * \param 	$value		the number that represent the quantity to decrease the $field
	 * \return	int			the new value of the $field
	 * \return	error		in case of exception
	 */
	public function decrementStatus($objectId, $field, $value) {
		try {
			$parseObject = new parseObject('Status');
			//we use the increment function with a negative value because decrement function still not work
			$parseObject->increment($field, array(0 - $value));
			$res = $parseObject->update($objectId);
			return $res->$field;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	/**
	 * \fn		void deleteStatus(string $objectId)
	 * \brief	Set unactive a specified Status by objectId
	 * \param	$objectId the string that represent the objectId of the Status
	 * \return	error in case of exception
	 */
	public function deleteStatus($objectId) {
		try {
			$parseObject = new parseObject('Status');
			$parseObject->active = false;
			$parseObject->update($objectId);
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		number getCount()
	 * \brief	Returns the number of requests Status
	 * \return	number
	 */
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}

	/**
	 * \fn		void getStatus(string $objectId)
	 * \brief	The function returns the Status object specified
	 * \param	$objectId	the string that represent the objectId of the Status
	 * \return	Status		the Status with the specified $objectId
	 * \return	Error		the Error raised by the function
	 */
	public function getStatus($objectId) {
		try {
			$parseObject = new parseObject('Status');
			$res = $parseObject->get($objectId);
			$status = $this->parseToStatus($res);
			return $status;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		array getStatuses()
	 * \brief	The function returns the Statuss objects specified
	 * \return	array	an array of Status, if one or more Status are found
	 * \return	null	if no Status are found
	 * \return	Error	the Error raised by the function
	 */
	public function getStatuses() {
		try {
			$statuses = null;
			$res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$statuses = array();
				foreach ($res->results as $obj) {
					$status = $this->parseToStatus($obj);
					$statuses[$status->getObjectId()] = $status;
				}
			}
			return $statuses;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	/**
	 * \fn		void incrementStatus(string $objectId, string $field, int $value)
	 * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
	 * \param	$objectId	the string that represent the objectId of the Status
	 * \param	$field		the string that represent the field to increment
	 * \param 	$value		the number that represent the quantity to increase the $field
	 * \return	int			the new value of the $field
	 * \return	error		in case of exception
	 */
	public function incrementStatus($objectId, $field, $value) {
		try {
			$parseObject = new parseObject('Status');
			$parseObject->increment($field, array($value));
			$res = $parseObject->update($objectId);
			return $res->$field;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	/**
	 * \fn		void orderBy($field)
	 * \brief	Specifies which field need to be ordered of requested Status
	 * \param	$field	the field on which to sort
	 */
	public function orderBy($field) {
		$this->parseQuery->orderBy($field);
	}

	/**
	 * \fn		void orderByAscending($field)
	 * \brief	Specifies which field need to be ordered ascending of requested Status
	 * \param	$field	the field on which to sort ascending
	 */
	public function orderByAscending($field) {
		$this->parseQuery->orderByAscending($field);
	}

	/**
	 * \fn		void orderByDescending($field)
	 * \brief	Specifies which field need to be ordered descending of requested Status
	 * \param	$field	the field on which to sort descending
	 */
	public function orderByDescending($field) {
		$this->parseQuery->orderByDescending($field);
	}

	/**
	 * \fn		Status parseToStatus($res)
	 * \brief	The function returns a representation of an Status object in Parse
	 * \param	$res	represent the Status object returned from Parse
	 * \return	Status	the Status object
	 * \return	Error	the Error raised by the function
	 */
	public function parseToStatus($res) {
		if (is_null($res))
			return throwError(new Exception('parseToStatus parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$status = new Status();
			$status->setObjectId($res->objectId);
			$status->setActive($res->active);
			$status->setCommentCounter($res->commentCounter);
			#$status->setCommentators(fromParseRelation('Status', 'commentators', $res->objectId, '_User'));
			#$status->setComments(fromParseRelation('Status', 'comments', $res->objectId, 'Comment'));
			$status->setCounter($res->counter);
			$status->setEvent(fromParsePointer($res->event));
			$status->setFromUser(fromParsePointer($res->fromUser));
			$status->setImage(fromParsePointer($res->image));
			$status->setLocation(new parseGeoPoint($res->location->latitude, $res->location->longitude));
			$status->setLoveCounter($res->loveCounter);
			#$status->setLovers(fromParseRelation('Status', 'lovers', $res->objectId, '_User'));
			$status->setShareCounter($res->shareCounter);
			$status->setSong(fromParsePointer($res->song));
			$status->setText($res->text);
			#$status->setTaggedUsers(fromParseRelation('Status', 'taggedUsers', $res->objectId, '_User'));
			$status->setCreatedAt(fromParseDate($res->createdAt));
			$status->setUpdatedAt(fromParseDate($res->updatedAt));
			$status->setACL(fromParseACL($res->ACL));
			return $status;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		Status saveStatus(Status $status)
	 * \brief	This function save an Status object in Parse
	 * \param	$status		represent the Status object to save
	 * \return	Status		the Status object with the new objectId parameter saved
	 * \return	Error		the Error raised by the function
	 */
	public function saveStatus($status) {
		if (is_null($status->getFromUser()))
			return throwError(new Exception('saveStatus parameter fromUser must to be set'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$parseStatus = new parseObject('Status');
			is_null($status->getActive()) ? $parseStatus->active = true : $parseStatus->active = $status->getActive();
			is_null($status->getCommentCounter()) ? $parseStatus->commentCounter = -1 : $parseStatus->commentCounter = $status->getCommentCounter();
			is_null($status->getCommentators()) ? $parseStatus->commentators = null : $parseStatus->commentators = toParseAddRelation('_User', $status->getCommentators());
			is_null($status->getComments()) ? $parseStatus->comments = null : $parseStatus->comments = toParseAddRelation('Comment', $status->getComments());
			is_null($status->getCounter()) ? $parseStatus->counter = -1 : $parseStatus->counter = $status->getCounter();
			is_null($status->getEvent()) ? $parseStatus->event = null : $parseStatus->event = toParsePointer('Event', $status->getEvent());
			$parseStatus->fromUser = toParsePointer('_User', $status->getFromUser());
			is_null($status->getImage()) ? $parseStatus->image = null : $parseStatus->image = toParsePointer('Image', $status->getImage());
			is_null($status->getLocation()) ? $parseStatus->location = null : $parseStatus->location = toParseGeopoint($status->getLocation());
			is_null($status->getLoveCounter()) ? $parseStatus->loveCounter = null : $parseStatus->loveCounter = $status->getLoveCounter();
			is_null($status->getLovers()) ? $parseStatus->lovers = null : $parseStatus->lovers = toParseAddRelation('_User', $status->getLovers());
			is_null($status->getShareCounter()) ? $parseStatus->shareCounter = -1 : $parseStatus->shareCounter = $status->getShareCounter();
			is_null($status->getSong()) ? $parseStatus->song = null : $parseStatus->song = toParsePointer('Song', $status->getSong());
			is_null($status->getTaggedUsers()) ? $parseStatus->taggedUsers = null : $parseStatus->taggedUsers = toParseAddRelation('_User', $status->getTaggedUsers());
			is_null($status->getText()) ? $parseStatus->text = null : $parseStatus->text = $status->getText();
			is_null($status->getACL()) ? $parseStatus->ACL = toParseDefaultACL() : $parseStatus->ACL = toParseACL($status->getACL());
			if ($status->getObjectId() == '') {
				is_null($status->getImageFile()) ? $parseStatus->imageFile = null : $parseStatus->imageFile = toParseNewFile($status->getImage(), 'img/jpg');
				$res = $parseStatus->save();
				$status->setObjectId($res->objectId);
				return $status;
			} else {
				is_null($status->getImageFile()) ? $parseStatus->imageFile = null : $parseStatus->imageFile = toParseFile($status->getImage());
				$parseStatus->update($status->getObjectId());
			}
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		void setLimit($limit)
	 * \brief	Sets the maximum number of Status to return
	 * \param	$limit	the maximum number
	 */
	public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}

	/**
	 * \fn		void setSkip($skip)
	 * \brief	Sets the number of how many Status(s) must be discarded initially
	 * \param	$skip	the number of Status(s) to skip
	 */
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
	}

	/**
	 * \fn		void updateField($objectId, $field, $value, $isRelation = false, $typeRelation, $className)
	 * \brief	Update a field of the object
	 * \param	$objectId		the objectId of the Status to update
	 * \param	$field			the field of the Status to update
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
				$parseObject = new parseObject('Status');
				$parseObject->$field = toParseAddRelation($className, $value);
				$parseObject->update($objectId);
			} elseif ($typeRelation == 'remove') {
				$parseObject = new parseObject('Status');
				$parseObject->$field = toParseRemoveRelation($className, $value);
				$parseObject->update($objectId);
			} else {
				return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
			}
		} else {
			$parseObject = new parseObject('Status');
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