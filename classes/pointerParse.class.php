<?php

class PointerParse {
	
	private $parsePointer;
	
	public function __construct($object, $objectId){
		$this->parsePointer = array("__type" => "Pointer", "className" => $object, "objectId" => $objectId);
	}
	
	public function getPointer() {
		return $this->parsePointer;
	}
	
	public function isNullPointer() {
		$className = $this->parsePointer['className'];
		$objectId =  $this->parsePointer['objectId'];
		return ($className == '' || $objectId == '') ? true : false;
	}
	
	public function printPointer() {
		foreach ($this->parsePointer as $key => $value) {
			echo '[' . $key . '] => ' . $value . '<br/>';
		}
	}
	
}

?>