<?php

class Error {
	
	private $objectId;
	private $errorClass;
	private $errorCode;
	private $errorMessage;
	private $errorFunction;
	private $errorFunctionParameter;
	private $createdAt;
	private $updatedAt;
	//private $ACL;
	
	public function getObjectId() {
		return $this->objectId;
	}
	
	public function getErrorClass() {
		return $this->errorClass;
	}
	
	public function getErrorCode() {
		return $this->errorCode;
	}
	
	public function getErrorMessage() {
		return $this->errorMessage;
	}
	
	public function getErrorFunction() {
		return $this->errorFunction;
	}
	
	public function getErrorFunctionParameter() {
		return $this->errorFunctionParameter;
	}
	
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	public function printError() {
		echo '[objectId] => ' . $this->getObjectId() . '<br />';
		echo '[errorClass] => ' . $this->getErrorClass() . '<br />';
		echo '[errorCode] => ' . $this->getErrorCode() . '<br />';
		echo '[errorMessage] => ' . $this->getErrorMessage() . '<br />';
		echo '[errorFunction] => ' . $this->getErrorFunction() . '<br />';
		foreach ($this->getErrorFunctionParameter() as $parameter) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '[errorFunctionParameter] => ' . $parameter . '<br />';
		}
		echo '[createdAt] => ' . $this->getCreatedAt() . '<br />';
		echo '[updatedAt] => ' . $this->getUpdatedAt() . '<br />';
	}
	
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}
	
	public function setErrorClass($errorClass) {
		$this->errorClass = $errorClass;
	}
	
	public function setErrorCode($errorCode) {
		$this->errorCode = $errorCode;
	}
	
	public function setErrorMessage($errorMessage) {
		$this->errorMessage = $errorMessage;
	}
	
	public function setErrorFunction($errorFunction) {
		$this->errorFunction = $errorFunction;
	}
	
	public function setErrorFunctionParameter($errorFunctionParameter) {
		$this->errorFunctionParameter = $errorFunctionParameter;
	}
	
	public function setCreatedAt(DateTime $createdAt) {
		$this->createdAt = $createdAt;
	}
	
	public function setUpdatedAt(DateTime $updatedAt) {
		return $this->updatedAt = $updatedAt;
	}
	
}

?>