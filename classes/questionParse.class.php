<?php
/*! \par Info Generali:
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

define('PARSE_DIR', '../parse/');
define('CLASS_DIR', './');
include_once PARSE_DIR.'parse.php';
include_once CLASS_DIR.'Question.class.php';

class QuestionParse {
	
	private $parseQuery;
	
	public function __construct() {
		$this->parseQuery = new parseQuery('Question');
	}
	
	public function getQuestion() {
        $question = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {
                //recupero l'utente
                $quest = $this->parseToQuestion($ret);
            }
        }
        return $question;
    }
	
	public function getQuestions() {
        $questions = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $questions = array();
            foreach (($result->results) as $question) {
                $questions [] = $this->parseToQuestion($question);
            }
        }
        return $questions;
    }

	public function saveQuestion($quest) {
		//creo la "connessione" con Parse
		$parseObject = new parseObject('Question');
		
		$parseObject->answer = 		$quest->getAnswer();
		$parseObject->mailFrom = 	$quest->getMailFrom();
		$parseObject->mailTo = 		$quest->getMailTo();
		$parseObject->name = 		$quest->getName();
		$parseObject->replied = 	$quest->getReplied();
		$parseObject->subject = 	$quest->getSubject();
		$parseObject->text = 		$quest->getText();
		
		if( $quest->getObjectId()==null ){

			try{
				//caso save
				$ret = $parseObj->save();
				$quest->setObjectId($ret->objectId);
				$quest->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
				$quest->setCreatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
			}
			catch(Exception $e){
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
		else{
			//caso update
			try{
				$ret = $parseObj->update($playlist->getObjectId());	
				$quest->setUpdatedAt(new DateTime($ret->updatedAt, new DateTimeZone("America/Los_Angeles")));	
			}
			catch(Exception $e){
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
		return $quest;
	}
	
	function parseToQuestion(stdClass $parseObj){

		$question = new Question();

		if(isset($parseObj->objectId)) $question->setObjectId($parseObj->objectId) ;
		if(isset($parseObj->answer)) $question->setAnswer($parseObj->answer);
		if(isset($parseObj->mailFrom)) $question->setMailFrom($parseObj->mailFrom);
        if(isset($parseObj->mailTo)) $question->setMailTo($parseObj->mailTo);
		if(isset($parseObj->name)) $question->setName($parseObj->name);
		if(isset($parseObj->replied)) $question->setReplied($parseObj->replied);
		if(isset($parseObj->subject)) $question->setSubject($parseObj->subject);
		if(isset($parseObj->text)) $question->setText($parseObj->text);
		if (isset($parseObj->createdAt))
            $question->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $question->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
		$acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $question->setACL($acl);
		}
		return $question;
	}
	
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}
	public function setLimit($int) {
		$this->parseQuery->setLimit($int);
	}
	
	public function setSkip($int) {
		$this->parseQuery->setSkip($int);
	}
	
	public function orderBy($key) {
		$this->parseQuery->orderBy($key);
	}
	
	public function orderByAscending($key) {
		/* 
		 * NOTE:
		 * in caso di ordinamento di campi testuali, il metodo risente del Case-Sensitive
		 *
		 */
		$this->parseQuery->orderByAscending($key);
	}
	
	public function orderByDescending($key) {
		/*
		 * NOTE:
		 * in caso di ordinamento di campi testuali, il metodo risente del Case-Sensitive
		 *
		 */
		$this->parseQuery->orderByDescending($key);
	}
	
	/*
	 * NOTE:
	 * la seguente funzione è commentata perchè non se ne capisce la funzionalità
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
	 * la seguente funzione è commentata perchè non se ne capisce la funzionalità
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
	 * la seguente funzione è commentata perchè non se ne capisce la funzionalità
	 *
	 */
	/*
	public function whereInQuery($key, $className, $inQuery){
		$this->parseQuery->whereInQuery($key, $className, $inQuery);
	}
	*/

	/*
	 * NOTE:
	 * la seguente funzione è commentata perchè non se ne capisce la funzionalità
	 *
	 */
	/*
	public function whereNotInQuery($key, $className, $inQuery){
		$this->parseQuery->whereNotInQuery($key, $className, $inQuery);
	}
	*/
	
}
?>