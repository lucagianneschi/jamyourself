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
require_once CLASSES_DIR . 'utils.class.php';


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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
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
        try {
            $faq = new Faq();
            $faq->setObjectId($parseObj->objectId);
            $faq->setAnswer($parseObj->answer);
            $faq->setArea($parseObj->area);
            $faq->setPosition($parseObj->position);
            $faq->setQuestion($parseObj->question);
            if ($parseObj->tags)
                $faq->setTags($parseObj->tags);
            if (($parseObj->createdAt))
                $faq->setCreatedAt(new DateTime($parseObj->createdAt));
            if (($parseObj->updatedAt))
                $faq->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $faq->setACL(toParseACL($parseObj->ACL));
            return $faq;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function saveFaq(Faq $faq) {

        $parseObject = new parseObject('FAQ');
        $faq->getAnswer() == null ? $parseObject->answer = null : $parseObject->answer = $faq->getAnswer();
        $faq->getArea() == null ? $parseObject->area = null : $parseObject->area = $faq->getArea();
        $faq->getPosition() == null ? $parseObject->position = null : $parseObject->position = $faq->getPosition();
        $faq->getQuestion() == null ? $parseObject->question = null : $parseObject->question = $faq->getQuestion();
        $faq->getTags() == null ? $parseObject->tags = null : $parseObject->tags = $faq->getTags();
        $acl = new ParseACL;
        $acl->setPublicRead(true);
        $acl->setPublicWrite(true);
        $faq->setACL($acl);
        if ($faq->getObjectId() != null) {
            try {
                $ret = $parseObject->update($faq->getObjectId());
                $dateTime = new DateTime($ret->updatedAt);
                $faq->setUpdatedAt($dateTime);
            } catch (Exception $e) {
                return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
            }
        } else {
            try {
                $ret = $parseObject->save();
                $faq->setObjectId($ret->objectId);
                $faq->setCreatedAt($ret->createdAt);
                $faq->setUpdatedAt($ret->updatedAt);
            } catch (Exception $e) {
                return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
            }
        }
        return $faq;
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