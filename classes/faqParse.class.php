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
        $faqs = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $faqs = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $faq = $this->parseToFaq($obj);
                        $faqs[$faq->getObjectId] = $faq;
                    }
                }
            }
            return $faqs;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
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
        if ($parseObj == null || !isset($parseObj->objectId))
		return throwError(new Exception('parseToFaq parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $faq = new Faq();
            $faq->setObjectId($parseObj->objectId);
            $faq->setAnswer($parseObj->answer);
            $faq->setArea($parseObj->area);
            $faq->setPosition($parseObj->position);
            $faq->setQuestion($parseObj->question);
            $faq->setTags($parseObj->tags);
            $faq->setCreatedAt(new DateTime($parseObj->createdAt));
            $faq->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $faq->setACL(toParseACL($parseObj->ACL));
            return $faq;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function saveFaq(Faq $faq) {
        try {
            $parseObject = new parseObject('FAQ');
            is_null($faq->getAnswer()) ? $parseObject->answer = null : $parseObject->answer = $faq->getAnswer();
            is_null($faq->getArea()) ? $parseObject->area = null : $parseObject->area = $faq->getArea();
            is_null($faq->getPosition()) ? $parseObject->position = null : $parseObject->position = $faq->getPosition();
            is_null($faq->getQuestion()) ? $parseObject->question = null : $parseObject->question = $faq->getQuestion();
            is_null($faq->getTags()) ? $parseObject->tags = null : $parseObject->tags = $faq->getTags();
            is_null($faq->getACL()) ? $parseObject->ACL = null : $parseObject->ACL = toParseACL($faq->getACL());
            $res = $parseObject->save();
            $faq->setObjectId($res->objectId);
            return $faq;
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