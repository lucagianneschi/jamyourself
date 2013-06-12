<?php
/* ! \par Info Generali:
 *  \author    Luca Gianneschi
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Location
 *  \details   Classe che accoglie i dati di laqtitudine e longitudine delle citta da impostre per JAMMER  e SPOTTER, non si creano nuove istanze e non si cancellano vecchie istanze. Si fanno solo le get.
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:location">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:location">API</a>
 */
 
include_once ROOT.CLASS_DIR.'error.class.php';
include_once ROOT.CLASS_DIR.'errorParse.class.php';
class LocationParse{

	private $parseQuery;

	function __construct(){
			
		$this->parseQuery = new ParseQuery("Location");
	}

	public function getLocation() {
        $location = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {
                $location = $this->parseToLocation($ret);
            }
        }
        return $location;
    }
	public function getLocations() {
        $locations = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $locations = array();
            foreach (($result->results) as $location) {
                $locations [] = $this->parseToLocation($location);
            }
        }
        return $locations;
    }
	
	function parseToLocation(stdClass $parseObj) {
        $location = new Location();
		if (isset($parseObj->objectId))
            $location->setObjectId($parseObj->objectId);
		if (isset($parseObj->city))
            $location->setCity($parseObj->city);
		if (isset($parseObj->country))
            $location->setCountry($parseObj->country);
		if (isset($parseObj->geoPoint)) {
            $geoParse = $parseObj->geoPoint;
            $geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
            $location->setGeopoint($geoPoint);
        }
		if (isset($parseObj->locId))
            $location->setLocId($parseObj->locId);
		if (isset($parseObj->createdAt))
            $playlist->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $location->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $playlist->setACL($acl);
        return $location;
		}

	public function getCount(){
		$this->_count = 1;
		$this->_limit = 0;
		return $this->find();
	}

	public function setLimit($int){
		if ($int >= 1 && $int <= 1000){
			$this->_limit = $int;
		}
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
				
		}
	}

	public function setSkip($int){
		$this->_skip = $int;
	}

	public function orderBy($field){
		if(!empty($field)){
			$this->_order[] = $field;
		}
	}

	public function orderByAscending($value){
		if(is_string($value)){
			$this->_order[] = $value;
		}
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
			
		}
	}

	public function orderByDescending($value){
		if(is_string($value)){
			$this->_order[] = '-'.$value;
		}
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
			
		}
	}
	
	public function whereInclude($value){
		if(is_string($value)){
			$this->_include[] = $value;
		}
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
			
		}
	}

	public function where($key,$value){
		$this->whereEqualTo($key,$value);
	}

	public function whereEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = $value;
		}
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	}

	public function whereNotEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$ne' => $value
			);
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	}

	public function whereGreaterThan($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$gt' => $value
			);
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	
	}

	public function whereLessThan($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$lt' => $value
			);
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	
	}

	public function whereGreaterThanOrEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$gte' => $value
			);
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	
	}

	public function whereLessThanOrEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$lte' => $value
			);
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
				
		}
	
	}

	public function whereContainedIn($key,$value){
		if(isset($key) && isset($value)){
			if(is_array($value)){
				$this->_query[$key] = array(
					'$in' => $value
				);		
			}
			else{
				$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
				
			}
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	
	}

	public function whereNotContainedIn($key,$value){
		if(isset($key) && isset($value)){
			if(is_array($value)){
				$this->_query[$key] = array(
					'$nin' => $value
				);		
			}
			else{
				$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
			}
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	
	}

	public function whereExists($key){
		if(isset($key)){
			$this->_query[$key] = array(
				'$exists' => true
			);
		}
	}

	public function whereDoesNotExist($key){
		if(isset($key)){
			$this->_query[$key] = array(
				'$exists' => false
			);
		}
	}
	
	public function whereRegex($key,$value,$options=''){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$regex' => $value
			);

			if(!empty($options)){
				$this->_query[$key]['options'] = $options;
			}
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
		
	}

	public function wherePointer($key,$className,$objectId){
		if(isset($key) && isset($className)){
			$this->_query[$key] = $this->dataType('pointer', array($className,$objectId));
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
		
	}

	public function whereInQuery($key,$className,$inQuery){
		if(isset($key) && isset($className)){
			$this->_query[$key] = array(
				'$inQuery' => $inQuery,
				'className' => $className
			);
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
		
	}

	public function whereNotInQuery($key,$className,$inQuery){
		if(isset($key) && isset($className)){
			$this->_query[$key] = array(
				'$notInQuery' => $inQuery,
				'className' => $className
			);
		}	
		else{
			$error = new error();
            $error->setErrorClass(__CLASS__);
			$error->setErrorCode($e->getCode());
			$error->setErrorMessage($e->getMessage());
			$error->setErrorFunction(__FUNCTION__);
			$error->setErrorFunctionParameter(func_get_args());
			$errorParse = new errorParse();
			$errorParse->saveError($error);
					
		}
	}
}
?>