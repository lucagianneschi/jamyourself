<?php
/*! \par Info Generali:
 *  \author    
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Puntatore
 *  \details   
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:user">API</a>
 */

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