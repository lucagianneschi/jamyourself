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
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
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
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    private function isNullPointer($pointer) {
        $className = $pointer['className'];
        $objectId = $pointer['objectId'];
        $isNull = true;

        if ($className == '' || $objectId == '') {
            $isNull = true;
        } else {
            $isNull = false;
        }

        return $isNull;
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

        $error = new Error();
        $error->setObjectId($parseObj->objectId);
        if (isset($parseObj->errorClass)) {
            $error->setErrorClass($parseObj->errorClass);
        }
        if (isset($parseObj->errorCode)) {
            $error->setErrorCode($parseObj->errorCode);
        }
        if (isset($parseObj->errorMessage)) {
            $error->setErrorMessage($parseObj->errorMessage);
        }
        if (isset($parseObj->errorFunction)) {
            $error->setErrorFunction($parseObj->errorFunction);
        }
        if (isset($parseObj->errorFunctionParameter)) {
            $error->setErrorFunctionParameter($parseObj->errorFunctionParameter);
        }
        if (isset($parseObj->createdAt))
            $error->setCreatedAt(new DateTime($parseObj->createdAt));
        if (isset($parseObj->updatedAt))
            $error->setUpdatedAt(new DateTime($parseObj->updatedAt));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $error->setACL($acl);
        return $error;
    }

    public function saveError($error) {
        //creo la "connessione" con Parse
        $parseObject = new parseObject('Error');
        $parseObject->errorClass = $error->getErrorClass();
        $parseObject->errorCode = $error->getErrorCode();
        $parseObject->errorMessage = $error->getErrorMessage();
        $parseObject->errorFunction = $error->getErrorFunction();
        $parseObject->errorFunctionParameter = $error->getErrorFunctionParameter();
        $parseObject->save();
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