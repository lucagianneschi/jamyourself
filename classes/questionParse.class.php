<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     QuestionParse
 *  \details   Classe Parsededicata alle domande e alle risposte tra utenti e amministrazione
 *
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:question">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:question">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

class QuestionParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new parseQuery('Question');
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getQuestion($objectId) {
        try {
            $parseObject = new parseObject('Question');
            $res = $parseObject->get($objectId);
            $question = $this->parseToQuestion($res);
            return $question;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }
    
    public function getQuestions() {
        $questions = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $questions = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $question = $this->parseToQuestion($obj);
                        $questions[$question->getObjectId] = $question;
                    }
                }
            }
            return $questions;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function orderBy($key) {
        $this->parseQuery->orderBy($key);
    }

    public function orderByAscending($key) {
        $this->parseQuery->orderByAscending($key);
    }

    public function orderByDescending($key) {
        $this->parseQuery->orderByDescending($key);
    }

    function parseToQuestion(stdClass $parseObj) {
        if ($parseObj == null || !isset($parseObj->objectId))
		return throwError(new Exception('parseToQuestion parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $question = new Question();
            $question->setObjectId($parseObj->objectId);
            $question->setAnswer($parseObj->answer);
            $question->setMailFrom($parseObj->mailFrom);
            $question->setMailTo($parseObj->mailTo);
            $question->setReplied($parseObj->replied);
            $question->setSubject($parseObj->subject);
            $question->setText($parseObj->text);
            $question->setCreatedAt(new DateTime($parseObj->createdAt));
            $question->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $question->setACL(toParseACL($parseObj->ACL));
            return $question;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function saveQuestion(Question $question) {
        try {
            $parseObject = new parseObject('Question');
            is_null($question->getAnswer()) ? $parseObject->answer = null : $parseObject->answer = $question->getAnswer();
            is_null($question->getMailFrom()) ? $parseObject->mailFrom = null : $parseObject->mailFrom = $question->getMailFrom();
            is_null($question->getMailTo()) ? $parseObject->mailTo = null : $parseObject->mailTo = $question->getMailTo();
            is_null($question->getName()) ? $parseObject->name = null : $parseObject->name = $question->getName();
            is_null($question->getReplied()) ? $parseObject->replied = null : $parseObject->replied = $question->getReplied();
            is_null($question->getSubject()) ? $parseObject->subject = null : $parseObject->subject = $question->getSubject();
            is_null($question->getText()) ? $parseObject->text = null : $parseObject->text = $question->getText();
            is_null($question->getACL()) ? $parseObject->ACL = null : $parseObject->ACL = toParseACL($question->getACL());
            $res = $parseObject->save();
            $question->setObjectId($res->objectId);
            return $question;
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

    public function whereContainedIn($key, $array) {
        $this->parseQuery->whereContainedIn($key, $array);
    }

    public function whereNotContainedIn($key, $array) {
        $this->parseQuery->whereNotContainedIn($key, $array);
    }

    public function whereExists($key) {
        $this->parseQuery->whereExists($key);
    }

    public function whereNotExists($key) {
        $this->parseQuery->whereDoesNotExist($key);
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

    public function wherePointer($key, $className, $objectId) {
        $this->parseQuery->wherePointer($key, $className, $objectId);
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
}

?>
