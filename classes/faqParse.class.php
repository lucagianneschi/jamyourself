<?php
/*! \par Info Generali:
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

define('ROOT', '/var/www/vhosts/socialmusicdiscovering.com/httpdocs/');
define('PARSE_DIR', '../parse/');
define('CLASS_DIR', './');
include_once ROOT.PARSE_DIR.'parse.php';
include_once ROOT.CLASS_DIR.'faq.class.php';
include_once ROOT.CLASS_DIR.'error.class.php';
include_once ROOT.CLASS_DIR.'errorParse.class.php';
 
class FaqParse {
 
	private $parseQuery;
 
	public function __construct() {
		$this->parseQuery = new parseQuery('FAQ');
	}
 
 public function getFaq() {
        $faq = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {
                //recupero l'utente
                $faq = $this->parseToFaq($ret);
            }
        }
        return $faq;
    }
	
	public function getQuestions() {
        $faqs = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $faqs = array();
            foreach (($result->results) as $faq) {
                $faq [] = $this->parseToFaq($faq);
            }
        }
        return $faqs;
    }

	public function saveFaq($faq) {
		//creo la "connessione" con Parse
		$parseObject = new parseObject('FAQ');
 		$parseObject->answer = 		$faq->getAnswer();
		$parseObject->area = 		$faq->getArea();
		$parseObject->position = 	$faq->getPosition();
		$parseObject->question = 	$faq->getQuestion();
		$parseObject->tag = 		$faq->getTag();
		
		if($faq->getObjectId()==null ){

			try{
				//caso save
				$ret = $parseObj->save();
				$faq->setObjectId($ret->objectId);
				$faq->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
				$faq->setCreatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
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
				$faq->setUpdatedAt(new DateTime($ret->updatedAt, new DateTimeZone("America/Los_Angeles")));	
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
                return $error;;		
			}
		}
		return $quest;
	}
	
	function parseToFaq(stdClass $parseObj){

		$faq = new Faq();

		if(isset($parseObj->objectId))$faq->setObjectId($parseObj->objectId) ;
		if(isset($parseObj->answer))$faq->setAnswer($parseObj->answer);
		if(isset($parseObj->area)) $faq->setArea($parseObj->area);
        if(isset($parseObj->position))$faq->setPosition($parseObj->position);
		if(isset($parseObj->question))$faq->setQuestion($parseObj->question);
		if (isset($parseObj->tags))$faq->setTags($parseObj->tags);
		if (isset($parseObj->createdAt))
            $faq->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $faq->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
		$acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $faq->setACL($acl);
		}
		return $faq;
	}

 public function getCount() {
 ;		return $this->parseQuery->getCount()->count;
 	public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}
 
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
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
	 * la seguente funzione è commentata perchè non se ne capisce la funzionalità
	 *
	 */
	/*
	public function whereInclude($value){
		$this->parseQuery->whereInclude($value);
	}
	*/
 
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
	 * la seguente funzione è commentata perchè non se ne capisce la funzionalità
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
 
	/*** FUNZIONI PERSONALIZZATE ***/
 
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