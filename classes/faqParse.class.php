<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     geoPointParse
 *  \details   Classe che serve per accogliere latitudine e longitudine di un 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 * <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:faq">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:faq">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

class FaqParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new parseQuery('FAQ');
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getFaq($objectId) {
        try {
            $parseObject = new parseObject('Faq');
            $res = $parseObject->get($objectId);
            $faq = $this->parseToFaq($res);
            return $faq;
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

    public function getFaqs() {
        try {
            $faqs = array();
            $res = $this->parseQuery->find();
            foreach ($res->results as $obj) {
                $faq = $this->parseToComment($obj);
                $faqs[$faq->getObjectId()] = $faq;
            }
            return $faqs;
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

    public function orderByAscending($field) {
        /*
         * NOTE:
         * in caso di ordinamento di campi testuali, il metodo risente del Case-Sensitive
         *
         */
        $this->parseQuery->orderByAscending($field);
    }

    public function orderByDescending($field) {
        /*
         * NOTE:
         * in caso di ordinamento di campi testuali, il metodo risente del Case-Sensitive
         *
         */
        $this->parseQuery->orderByDescending($field);
    }

    /*
     * NOTE:
     * la seguente funzione � commentata perch� non se ne capisce la funzionalit�
     *
     */
    /*
      public function whereInclude($value){
      $this->parseQuery->whereInclude($value);
      }
     */

    function parseToFaq(stdClass $parseObj) {

        $faq = new Faq();

        if (isset($parseObj->objectId))
            $faq->setObjectId($parseObj->objectId);
        if (isset($parseObj->answer))
            $faq->setAnswer($parseObj->answer);
        if (isset($parseObj->area))
            $faq->setArea($parseObj->area);
        if (isset($parseObj->position))
            $faq->setPosition($parseObj->position);
        if (isset($parseObj->question))
            $faq->setQuestion($parseObj->question);
        if (isset($parseObj->tags))
            $faq->setTags($parseObj->tags);
        if (isset($parseObj->createdAt))
            $faq->setCreatedAt(new DateTime($parseObj->createdAt));
        if (isset($parseObj->updatedAt))
            $faq->setUpdatedAt(new DateTime($parseObj->updatedAt));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $faq->setACL($acl);
        return $faq;
    }

    public function saveFaq($faq) {
        try {
            $parseObject = new parseObject('FAQ');
            if ($faq->getObjectId() == '') {
                $faq->getAnswer() == null ? $parseObject->answer = null : $parseObject->answer = $faq->getAnswer();
                $faq->getArea() == null ? $parseObject->area = null : $parseObject->area = $faq->getArea();
                $faq->getPosition() == null ? $parseObject->position = null : $parseObject->position = $faq->getPosition();
                $faq->getQuestion() == null ? $parseObject->question = null : $parseObject->question = $faq->getQuestion();
                $faq->getTags() == null ? $parseObject->tags = null : $parseObject->tags = $faq->getTags();
                $faq->getACL() == null ? $parseObject->ACL = null : $parseObject->ACL = $faq->getACL()->acl;
                $res = $parseObject->save();
                return $res->objectId;
            } else {
                if ($faq->getAnswer() != null)
                    $parseObject->answer = $faq->getAnswer();
                if ($faq->getArea() != null)
                    $parseObject->answer = $faq->getArea();
                if ($faq->getPosition() != null)
                    $parseObject->answer = $faq->getPosition();
                if ($faq->getQuestion() != null)
                    $parseObject->question = $faq->getQuestion();
                if ($faq->getTags() != null)
                    $parseObject->tags = $faq->getTags();
                if ($faq->getACL() != null)
                    $parseObject->ACL = $faq->getACL()->acl;
                $parseObject->update($faq->getObjectId());
            }
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

    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    public function where($field, $value) {
        $this->parseQuery->where($field, $value);
    }

    public function whereEqualTo($field, $value) {
        $this->parseQuery->whereEqualTo($field, $value);
    }

    public function whereNotEqualTo($field, $value) {
        $this->parseQuery->whereNotEqualTo($field, $value);
    }

    public function whereGreaterThan($field, $value) {
        $this->parseQuery->whereGreaterThan($field, $value);
    }

    public function whereLessThan($field, $value) {
        $this->parseQuery->whereLessThan($field, $value);
    }

    public function whereGreaterThanOrEqualTo($field, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
    }

    public function whereLessThanOrEqualTo($field, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($field, $value);
    }

    public function whereContainedIn($field, $array) {
        $this->parseQuery->whereContainedIn($field, $array);
    }

    public function whereNotContainedIn($field, $array) {
        $this->parseQuery->whereNotContainedIn($field, $array);
    }

    public function whereExists($field) {
        $this->parseQuery->whereExists($field);
    }

    public function whereNotExists($field) {
        $this->parseQuery->whereDoesNotExist($field);
    }

    /*
     * NOTE:
     * la seguente funzione � commentata perch� non se ne capisce la funzionalit�
     *
     */
    /*
      public function whereRegex($key, $value, $options='') {
      $this->parseQuery->whereDoesNotExist($key, $value, $options);
      }
     */

    public function wherePointer($field, $pointerClass, $objectId) {
        $this->parseQuery->wherePointer($field, $pointerClass, $objectId);
    }

    /*
     * NOTE:
     * la seguente funzione � commentata perch� non se ne capisce la funzionalit�
     *
     */
    /*
      public function whereInQuery($key, $className, $inQuery){
      $this->parseQuery->whereInQuery($key, $className, $inQuery);
      }
     */

    /*
     * NOTE:
     * la seguente funzione � commentata perch� non se ne capisce la funzionalit�
     *
     */
    /*
      public function whereNotInQuery($key, $className, $inQuery){
      $this->parseQuery->whereNotInQuery($key, $className, $inQuery);
      }
     */

    /*     * * FUNZIONI PERSONALIZZATE ** */

    public function getDistinctAreas() {
        $faqs = $this->getFaqs();
        $aree = array();
        foreach ($faqs as $faq) {
            $aree[] = $faq->getArea();
        }
        $aree = array_unique($aree);
        natcasesort($aree);

        return $aree;
    }

    public function getDistinctTags() {
        $faqs = $this->getFaqs();
        $tags = array();
        foreach ($faqs as $faq) {
            $tags = array_merge($tags, $faq->getTag());
        }
        $tags = array_unique($tags);
        natcasesort($tags);

        return $tags;
    }

}

?>