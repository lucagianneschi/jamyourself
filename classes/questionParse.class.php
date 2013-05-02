<?php

define('PARSE_DIR', '../parse/');
define('CLASS_DIR', './');
include_once PARSE_DIR.'parse.php';
include_once CLASS_DIR.'Question.class.php';

class questionParse {
	
	private $parseQuery;
	
	public function __construct() {
		$this->parseQuery = new parseQuery('Question');
	}
	
	public function getQuestion($objectId) {
		//creo un nuovo oggetto Question
		$quest = new question();
		//carico la Question richiesta
		$parseObject = new parseObject('Question');
		$res = $parseObject->get($objectId);

		//inizializzo l'oggetto
		$quest->setObjectId($res->objectId);
		$quest->setAnswer($res->answer);
		$quest->setMailFrom($res->mailFrom);
		$quest->setMailTo($res->mailTo);
		$quest->setName($res->name);
		$quest->setReplied($res->replied);
		$quest->setSubject($res->subject);
		$quest->setText($res->text);
		$quest->setCreatedAt($res->createdAt);
		$quest->setUpdatedAt($res->updatedAt);
		
		return $quest;
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
		
		$parseObject->save();
	}
	
	public function updateQuestion($quest) {
		//creo la "connessione" con Parse
		$parseObject = new parseObject('Question');	
		
		$parseObject->answer = 		$quest->getAnswer();
		$parseObject->mailFrom = 	$quest->getMailFrom();
		$parseObject->mailTo = 		$quest->getMailTo();
		$parseObject->name = 		$quest->getName();
		$parseObject->replied = 	$quest->getReplied();
		$parseObject->subject = 	$quest->getSubject();
		$parseObject->text = 		$quest->getText();
		
		$parseObject->update($quest->getObjectId());
	}
	
	public function getQuestions() {
		//creo un contenitore di Questions
		$quests = array();
		//carico le FAQs
		$res = $this->parseQuery->find();
		
		foreach ($res->results as $obj) {
			
			$quest = new question();
			
			$quest->setObjectId($obj->objectId);
			$quest->setAnswer($obj->answer);
			$quest->setMailFrom($obj->mailFrom);
			$quest->setMailTo($obj->mailTo);
			$quest->setName($obj->name);
			$quest->setReplied($obj->replied);
			$quest->setSubject($obj->subject);
			$quest->setText($obj->text);
			$quest->setCreatedAt($obj->createdAt);
			$quest->setUpdatedAt($obj->updatedAt);
			
			$quests[$obj->objectId] = $quest;
		}
		
		return $quests;
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