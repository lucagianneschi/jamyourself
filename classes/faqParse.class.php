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
 
	public function getFaq($objectId) {
		try {
			//creo un nuovo oggetto FAQ
			$faq = new faq();
			//carico la FAQ richiesta
			$parseObject = new parseObject('FAQ');
			$res = $parseObject->get($objectId);
 
			//inizializzo l'oggetto
			$faq->setObjectId($res->objectId);
			$faq->setAnswer($res->answer);
			$faq->setArea($res->area);
			$faq->setPosition($res->position);
			$faq->setQuestion($res->question);
			$faq->setTag($res->tag);
			$dateTimeC = new DateTime($res->createdAt);
			$faq->setCreatedAt($dateTimeC);
			$dateTimeU = new DateTime($res->updatedAt);
			$faq->setUpdatedAt($dateTimeU);
			$faq->setACL($res->ACL);
 
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
 
	public function saveFaq($faq) {
		//creo la "connessione" con Parse
		$parseObject = new parseObject('FAQ');
 		$parseObject->answer = 		$faq->getAnswer();
		$parseObject->area = 		$faq->getArea();
		$parseObject->position = 	$faq->getPosition();
		$parseObject->question = 	$faq->getQuestion();
		$parseObject->tag = 		$faq->getTag();
 
		$parseObject->save();
	}
 
	public function getFaqs() {
		//creo un contenitore di FAQs
		$faqs = array();
		//carico le FAQs
		$res = $this->parseQuery->find();
 
		foreach ($res->results as $obj) {
 
			$faq = new faq();
 
			$faq->setObjectId($obj->objectId);
			$faq->setAnswer($obj->answer);
			$faq->setArea($obj->area);
			$faq->setPosition($obj->position);
			$faq->setQuestion($obj->question);
			$faq->setTag($obj->tag);
			$dateTimeC = new DateTime($res->createdAt);
			$faq->setCreatedAt($dateTimeC);
			$dateTimeU = new DateTime($res->updatedAt);
			$faq->setUpdatedAt($dateTimeU);
			$faq->setACL($res->ACL);
 
			$faqs[$obj->objectId] = $faq;
		}
 
		return $faqs;
	}
 
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}
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