<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Error
 *  \details   Classe Error per la gestione degli errori
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 * 
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:error:faq">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

class ErrorParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new parseQuery('Error');
    }

    public function getCount() {
		return $this->parseQuery->getCount()->count;
	}

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

     public function getgetErrors() {
        $errors = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $errors = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $error = $this->parseToError($obj);
                        $errors[$error->getObjectId] = $error;
                    }
                }
            }
            return $errors;
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

    public function parseToError(stdClass $parseObj) {
        if (is_null($parseObj))
		return throwError(new Exception('parseToError parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $error = new Error();
            $error->setObjectId($parseObj->objectId);
            $error->setErrorClass($parseObj->errorClass);
            $error->setErrorCode($parseObj->errorCode);
            $error->setErrorMessage($parseObj->errorMessage);
            $error->setErrorFunction($parseObj->errorFunction);
            $error->setErrorFunctionParameter($parseObj->errorFunctionParameter);
            $error->setCreatedAt(new DateTime($parseObj->createdAt));
            $error->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $error->setACL($parseObj->ACL);
            return $error;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function saveError($error) {
        try {
            $parseObject = new parseObject('Error');
            $parseObject->errorClass = $error->getErrorClass();
            $parseObject->errorCode = $error->getErrorCode();
            $parseObject->errorMessage = $error->getErrorMessage();
            $parseObject->errorFunction = $error->getErrorFunction();
            $parseObject->errorFunctionParameter = $error->getErrorFunctionParameter();
            is_null($error->getACL()) ? $parseObject->ACL = null : $parseObject->ACL = toParseACL($error->getACL());
            $res = $parseObject->save();
            $error->setObjectId($res->objectId);
            return $error;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}
 
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
	}
 
	public function where($field, $value) {
		$this->parseQuery->where($field, $value);
	}
 
	public function whereContainedIn($field, $values) {
		$this->parseQuery->whereContainedIn($field, $values);
	}
 
	public function whereEqualTo($field, $value) {
		$this->parseQuery->whereEqualTo($field, $value);
	}
 
	public function whereExists($field) {
		$this->parseQuery->whereExists($field);
	}	
 
	public function whereGreaterThan($field, $value) {
		$this->parseQuery->whereGreaterThan($field, $value);
	}
 
	public function whereGreaterThanOrEqualTo($field, $value) {
		$this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
	}
 
	public function whereLessThan($field, $value) {
		$this->parseQuery->whereLessThan($field, $value);
	}
 
	public function whereLessThanOrEqualTo($field, $value) {
		$this->parseQuery->whereLessThanOrEqualTo($field, $value);
	}
 
	public function whereNotContainedIn($field, $array) {
		$this->parseQuery->whereNotContainedIn($field, $array);
	}
 
	public function whereNotEqualTo($field, $value) {
		$this->parseQuery->whereNotEqualTo($field, $value);
	}
 
	public function whereNotExists($field) {
		$this->parseQuery->whereDoesNotExist($field);
	}
 
	public function wherePointer($field, $className, $objectId) {
		$this->parseQuery->wherePointer($field, $className, $objectId);
	}
        
    public function whereRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
	}

}

?>