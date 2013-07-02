<?php
/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info  Classe:
 *  \brief		Error
 *  \details	Classe Error per la gestione degli errori
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:error:faq">API</a>
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'error.class.php';

class ErrorParse {

	private $parseQuery;

	/**
	 * \fn		void __construct()
	 * \brief	The constructor instantiates a new object of type ParseQuery on the Error class
	 */
	public function __construct() {
		$this->parseQuery = new parseQuery('Error');
	}

	/**
	 * \fn		number getCount()
	 * \brief	Returns the number of requests Error
	 * \return	number
	 */
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}

	/**
	 * \fn		Error getError(string $objectId)
	 * \brief	The function returns the Error object specified
	 * \param	$objectId the string that represent the objectId of the Error
	 * \return	Error	the Error with the specified $objectId
	 * \return	Error	the Error raised by the function
	 */
	public function getError($objectId) {
		try {
			$parseObject = new parseObject('Error');
			$res = $parseObject->get($objectId);
			$error = $this->parseToError($res);
			return $error;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		array getErrors()
	 * \brief	The function returns an array Error objects specified
	 * \return	array	an array of Error, if one or more Error are found
	 * \return	null	if no Error are found
	 * \return	Error	the Error raised by the function
	 */
	public function getErrors() {
		try {
			$errors = null;
			$res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$errors = array();
				foreach ($res->results as $obj) {
					$error = $this->parseToError($obj);
					$errors[$error->getObjectId()] = $error;
				}
			}
			return $errors;
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
	 * \fn		Error parseToError($res)
	 * \brief	The function returns a representation of an Error object in Parse
	 * \param	$res	represent the Error object returned from Parse
	 * \return	Error	the Error object
	 * \return	Error	the Error raised by the function
	 */
	public function parseToError($res) {
		if (is_null($res))
			return throwError(new Exception('parseToError parameter is incorrect'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			$error = new Error();
			$error->setObjectId($res->objectId);
			$error->setErrorClass($res->errorClass);
			$error->setErrorCode($res->errorCode);
			$error->setErrorMessage($res->errorMessage);
			$error->setErrorFunction($res->errorFunction);
			$error->setErrorFunctionParameter($res->errorFunctionParameter);
			$error->setCreatedAt(new DateTime($res->createdAt));
			$error->setUpdatedAt(new DateTime($res->updatedAt));
			$error->setACL(fromParseACL($res->ACL));
			return $error;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}

	/**
	 * \fn		Error saveError($error)
	 * \brief	This function save an Error object in Parse
	 * \param	$error		represent the Error object to save
	 * \return	Error		the Error object with the new objectId parameter saved
	 * \return	Exception	the Exception raised by the function
	 */
	public function saveError($error) {
		if (!is_null($error->getObjectId()))
			return new Exception('saveError update is not allow here');
		try {
			$parseObject = new parseObject('Error');
			is_null($error->getErrorClass()) ? $parseObject->errorClass = null : $parseObject->errorClass = $error->getErrorClass();
			is_null($error->getErrorCode()) ? $parseObject->errorCode = null : $parseObject->errorCode = $error->getErrorCode();
			is_null($error->getErrorMessage()) ? $parseObject->errorMessage = null : $parseObject->errorMessage = $error->getErrorMessage();
			is_null($error->getErrorFunction()) ? $parseObject->errorFunction = null : $parseObject->errorFunction = $error->getErrorFunction();
			is_null($error->getErrorFunctionParameter()) ? $parseObject->errorFunctionParameter = null : $parseObject->errorFunctionParameter = $error->getErrorFunctionParameter();
			is_null($error->getACL()) ? $parseObject->ACL = toParseDefaultACL() : $parseObject->ACL = toParseACL($error->getACL());
			$res = $parseObject->save();
			$error->setObjectId($res->objectId);
			return $error;
		} catch (Exception $e) {
			return new Exception($e->getMessage());
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
	 * \brief	Sets the number of how many Error must be discarded initially
	 * \param	$skip	the number of Error to skip
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
	 * \brief	Sets a condition for which to return all the Error objects present in the field $field of object $objectId of type $className
	 * \param	$field		the string which represent the field
	 * \param	$className	the string which represent the className
	 * \param	$objectId	the string which represent the objectId
	 */
	public function whereRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
	}

}

?>