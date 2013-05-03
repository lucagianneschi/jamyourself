<?php
define('PARSE_DIR', '../parse/');
define('CLASS_DIR', './');
include_once PARSE_DIR.'parse.php';

class ErrorParse {
	
	private $parseQuery;
	
	public function __construct() {
		$this->parseQuery = new parseQuery('Error');
	}
	
	public function saveError($error) {
		//creo la "connessione" con Parse
		$parseObject = new parseObject('Error');
		
		$parseObject->errorClass =				$error->getErrorClass();
		$parseObject->errorCode =               $error->getErrorCode();
		$parseObject->errorMessage =            $error->getErrorMessage();
		$parseObject->errorFunction =           $error->getErrorFunction();
		$parseObject->errorFunctionParameter =  $error->getErrorFunctionParameter();
		
		$parseObject->save();
	}
}
?>