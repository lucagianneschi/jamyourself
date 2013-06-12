<?php

class ObjectParse {

    private $className;     //nome della classe su cui si vogliono fare le query
    private $parseQuery;    //parseQuery per le find su Parse

    function __construct($className) {

        if ($className == "User" || $className == "Role")
            $className = "_" . $className;
        $this->className = $className;
        $this->parseQuery = new ParseQuery($className);
    }

//*************************************************************************/    
//     
//     Metodi tipici delle classi parse
//     
//*************************************************************************/

    function saveObject($obj) {

        $parseObject = new parseObject($this->className);

        $classMethod = get_class_methods($this->className);
        
        foreach ($classMethod as $method_name) {
            
            //ignorno _toString, _construct e setters
            if ( $method_name == "__construct" 
                    ||$method_name == "__toString" 
                    || substr($method_name, 0,3) == "set" 
                    || $method_name == "getObjectId"
                    || $method_name == "getUpdatedAt"
                    || $method_name == "getCreatedAt"){
                continue;             
            }


            //taglio la stringa levando "get" e metto la prima lettera minuscola
            $varName = lcfirst(substr($method_name, 3));
            
            //inizializzo il valore finale a null per sicurezza
            $value = null;
            
            //chiamo la get
            $property = $obj->{$method_name}();
            
//            echo "Valore : $property <br>";
            
            //verifico il tipo del valore ricavato
            if(is_object($property)){
                //caso oggetto: distinguere in base alla classe degli oggetti
                switch (get_class($property)){
                    case "DateTime" :
                        $value = $this->toParseDateTime($property);
                        break;
                    case "parseACL" :
                        $value = $this->toParseACL($property);
                        break; 
                    case "parseGeoPoint" :
                        $value = $this->toParseGeoPoint($property);
                        break;
                    default : 
                       $value = $this->toParsePointer($property);                        
                }
                
                
            }else if(is_array($property) && count($property)>0 && is_object ($property[0])){
                //caso array di oggetti => relazione  
                $value = $this->toParseRelation($property);

            }else{
                //caso tipo base: array, stringhe, numeri, booleani, null
                $value = $property;
            }

            //alla fine setto il valore
            $parseObject->{$varName} = $value;
        }

        //test:
        return $parseObject;

        //salvataggio su Parse
        if ($obj->getObjectId() != null) {

            try {
                //aggiornamento
                $ret = $$parseObject->update($obj->getObjectId());

                $obj->setUpdatedAt($ret->updatedAt, new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $e) {

                return false;
            }
        } else {
            //salvataggio
            try {

                $ret = $$parseObject->save();
                $obj->setObjectId($ret->objectId);
                $obj->setCreatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
                $obj->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $e) {

                return false;
            }

            return $obj;
        }
    }

    function deleteObject($object) {
        if ($object) {
            $object->setActive(false);

            if ($this->save($object))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    function getObject() {
        $object = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {

                $object = $this->parseToObject($ret);
            }
        }
        return $object;
    }

    function getObjects() {
        $objects = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {

            $objects = array();

            foreach ($result->results as $object) {
                $object = $this->parseToObject($object);
                $objects[] = $object;
            }
        }
        return $objects;
    }

    public function parseToObject(stdClass $obj) {

        if ($obj == null || !is_object($obj) || !isset($obj->objectId))
            return null;

        $reflection = null;
        switch ($this->className) {
            case "_User" :
                ;
                switch ($obj->type) {
                    case "JAMMER" :
                        $reflection = new ReflectionClass("Jammer");
                        break;
                    case "SPOTTER" :
                        $reflection = new ReflectionClass("Spotter");
                        break;
                    case "VENUE" :
                        $reflection = new ReflectionClass("Venue");
                        break;
                    default :
                        //caso errore
                        return null;
                }

                break;

            default :
                $reflection = new ReflectionClass($this->className);
        }

        $instance = $reflection->newInstanceArgs(array());

        $varList = get_object_vars($obj);

        foreach ($varList as $name => $property) {

            $istancePorperty = null;

            switch ($name) {
                case "objectId" :
                    $istancePorperty = $property;
                    break;
                case "createdAt" :
                    $istancePorperty = new DateTime($property, new DateTimeZone("America/Los_Angeles"));
                    break;
                case "updatedAt" :
                    $istancePorperty = new DateTime($property, new DateTimeZone("America/Los_Angeles"));
                    break;
                case "ACL" :
//              ["ACL"]=> object(stdClass)#10 (1) { ["*"]=> object(stdClass)#11 (2) { ["write"]=> bool(true) ["read"]=> bool(true) }
                    $istancePorperty = new parseACL();
                    $istancePorperty->setPublicReadAccess(true);
                    $istancePorperty->setPublicWriteAccess(true);
                    break;
                default :

                    if ($this->isParsePointer($property)) {
                        $istancePorperty = $this->getPointer($property, $name, $obj->objectId);
                    } else if ($this->isParseRelation($property)) {
                        $istancePorperty = $this->getRelation($property, $name, $obj->objectId);
                    }else if($this->isParseGeoPoint($property)){
                        $istancePorperty = new parseGeoPoint($property->latitude, $property->longitude);
                    }
                    else {
                        $istancePorperty = $property;
                    }
            }

            //chiamo la funzione setNomeProperty
            $method_name = "set" . ucfirst($name);

            if (method_exists($instance, $method_name) && $istancePorperty != null) {
                $instance->{$method_name}($istancePorperty);
            }
        }
        return $instance;
    }
//**************************************************************************    
//     
//     Metodi ausiliari dalla classe da usare nella save
//     per la conversione dei tipi base di parse
//     
//*************************************************************************/    

    private function toParseACL(parseACL $ACL) {
        if (! $ACL )
            return null;
        return $ACL->acl;
    }

    private function toParsePointer($object) {
        if ( ! $object || ! is_object($object) )
            return null;

        $className = "";

        switch (get_class($object)) {
            case "Venue" :
                $className = "_User";
                break;
            case "Jammer" :
                $className = "_User";
                break;
            case "Spotter" :
                $className = "_User";
                break;
            case "Role" :
                $className = "_Role";
                break;
            default :
                $className = get_class($object);
        }


        $parseObj = new parseObject("TempClass");

        echo var_dump($object);
        return $parseObj->dataType("pointer", array($className, $object->{"getObjectId"}()));
    }

    private function toParseRelation(array $array) {
        if (! $array || ! count($array) > 0 || ! is_object($array[0]))
            return null;

        $parseObj = new parseObject("TempClass");
        $arrayPointer = array();

        foreach ($array as $istance) {
            $pointer = $this->toParsePointer($istance);
            $arrayPointer[] = $pointer;
        }
        return $parseObj->dataType("relation", $arrayPointer);
    }

    private function toParseDateTime(DateTime $dateTime) {
        if( ! $dateTime ) return null;
        $parseObj = new parseObject("TempClass");
        return $parseObj->dataType('date', $dateTime->format('r'));
    }
    
    private function toParseGeoPoint(parseGeoPoint $geoPoint) {
        if( ! $geoPoint ) return null;

        return $geoPoint->location;

    }
    
//**************************************************************************    
//     
//     Metodi ereditati dalla classe Query
//     
//*************************************************************************/ 

    public function getCount() {
        $this->parseQuery->getCount();
    }

    public function setLimit($int) {
        $this->parseQuery->setLimit($int);
    }

    public function setSkip($int) {
        $this->parseQuery->setSkip($int);
    }

    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    public function orderByAscending($value) {
        $this->parseQuery->orderByAscending($value);
    }

    public function orderByDescending($value) {
        $this->parseQuery->orderByDescending($value);
    }

    public function whereInclude($value) {
        $this->parseQuery->whereInclude($value);
    }

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

    public function whereContainedIn($key, $value) {
        $this->parseQuery->whereContainedIn($key, $value);
    }

    public function whereNotContainedIn($key, $value) {
        $this->parseQuery->whereNotContainedIn($key, $value);
    }

    public function whereExists($key) {
        $this->parseQuery->whereExists($key);
    }

    public function whereDoesNotExist($key) {
        $this->parseQuery->whereDoesNotExist($key);
    }

    public function whereRegex($key, $value, $options = '') {
        $this->parseQuery->whereRegex($key, $value, $options = '');
    }

    public function wherePointer($key, $className, $objectId) {
        $this->parseQuery->wherePointer($key, $className, $objectId);
    }

    public function whereInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereInQuery($key, $className, $inQuery);
    }

    public function whereNotInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereNotInQuery($key, $className, $inQuery);
    }

    public function whereRelatedTo($key, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($key, $className, $objectId);
    }

//**************************************************************************    
//     
//     Metodi ausiliari dalla classe da usare nel parseToObject
//     per il recupero degli oggetti nelle relazioni e nei puntatori
//     
//*************************************************************************/

    private function isParsePointer($property) {

        if ($property == null || is_object($property) == false)
            return false;
        if (isset($property->__type) && $property->__type == "Pointer")
            return true;
        else
            return false;
    }
    
    private function isParseGeoPoint($property){
        if ($property == null || is_object($property) == false)
            return false; 
        if (isset($property->__type) && $property->__type == "GeoPoint")
            return true;
        else
            return false;
    }

    private function isParseRelation($property) {

        if ($property == null || is_object($property) == false)
            return false;
        if (isset($property->__type) && $property->__type == "Relation")
            return true;
        else
            return false;
    }

    private function getRelation($property, $key, $objectId) {

        if ($property == null || !is_object($property) || !isset($property->className))
            return null;

        $parseQuery = new ObjectParse($property->className);

        $parseQuery->whereRelatedTo($key, $this->className, $objectId);

        $istance = $parseQuery->getObjects();

        return $istance;
    }

    private function getPointer($property, $key, $objectId) {

        if ($property == null || !is_object($property) || !isset($property->className))
            return null;

        $parseQuery = new ObjectParse($property->className);

        $parseQuery->wherePointer($key, $this->className, $objectId);

        $istance = $parseQuery->getObject();

        return $istance;
    }
}

?>
