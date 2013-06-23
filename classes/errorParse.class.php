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
        $this->parseQuery->getCount();
    }

    public function getError($objectId) {
        try {
            $parseObject = new parseObject('Error');
            $res = $parseObject->get($objectId);
            $error = $this->parseToError($res);
            return $error;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getErrors() {
        try {
            $errors = array();
            $res = $this->parseQuery->find();
            foreach ($res->results as $obj) {
                $error = $this->parseToError($obj);
                $errors[$error->getObjectId()] = $error;
            }
            return $errors;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    public function orderByAscending($value) {
        $this->parseQuery->orderByAscending($value);
    }

    public function orderByDescending($value) {
        $this->parseQuery->orderByDescending($value);
    }

    public function parseToError(stdClass $parseObj) {
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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
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
            $acl = new ParseACL;
            $acl->setPublicReadAccess(true);
            $acl->setPublicWriteAccess(true);
            $parseObject->ACL = toParseACL($acl);
            if ($error->getObjectId() == '') {
                $res = $parseObject->save();
                $error->setObjectId($res->objectId);
                return $error;
            } else {
                $parseObject->update($error->getObjectId());
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

    public function whereInclude($value) {
        $this->parseQuery->whereInclude($value);
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

    public function whereContainedIn($key, $value) {
        $this->parseQuery->whereContainedIn($key, $value);
    }

    public function whereNotContainedIn($key, $value) {
        $this->parseQuery->whereNotContainedIn($key, $value);
    }

    public function whereExists($key) {
        $this->parseQuery->whereExists($key);
    }

    public function whereDoesNotExist($key) {
        $this->parseQuery->whereDoesNotExist($key);
    }

    public function whereRegex($key, $value, $options = '') {
        $this->parseQuery->whereRegex($key, $value, $options = '');
    }

    public function wherePointer($key, $className, $objectId) {
        $this->parseQuery->wherePointer($key, $className, $objectId);
    }

    public function whereInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereInQuery($key, $className, $inQuery);
    }

    public function whereNotInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereNotInQuery($key, $className, $inQuery);
    }

    public function whereRelatedTo($key, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($key, $className, $objectId);
    }

}

?>