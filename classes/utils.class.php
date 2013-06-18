<?php

/**
 * 
 * @param parseACL $ACL
 * @return null
 */
function toParseACL(parseACL $ACL) {
    if (!$ACL || !isset($ACL->acl) || ($ACL->acl == null) )
        return null;
    return $ACL->acl;
}

/**
 * Restituisce un array che rappresenta un puntatore in Parse
 * @param type $className nome della classe a cui si punta
 * @param type $objectId id dell'oggetto puntato
 * @return null
 */
function toParsePointer($className, $objectId) {
    //se sono stringhe valide
    if (count($className) > 0 && count($objectId) > 0) {
        $parseRestClient = new parseRestClient();
        return $parseRestClient->dataType("pointer", array($className, $objectId));
    }
    else
        return null;
}

/**
 * Fornisce una stringa che rappresenta l'objectId dell'oggetto rappresentato
 * come puntatore in Parse
 * @param type $pointer l'oggetto puntatore di Parse
 * @return null
 */
function fromParsePointer($pointer) {
    if (is_object($pointer) && isset($pointer->__type) && $pointer->__type == "Pointer" &&
            isset($pointer->__className) && isset($pointer->objectId)) {
        return $pointer->objectId;
    }
    else
        return null;
}

/**
 * Crea un array di punatori che rappresenta una relation in Parse a partire da un array
 * di stringhe di objectId
 * @param array $array
 * @return null
 */
function toParseRelation($className, array $objects) {

    if (count($className) > 0 && count($objects) > 0) {
        $arrayPointer = array();

        foreach ($objects as $objectId) {
            $pointer = toParsePointer($className, $objectId);
            if ($pointer)
                $arrayPointer[] = $pointer;
        }
        if (count($arrayPointer) > 0) {
            $parseRestClient = new parseRestClient();
            return $parseRestClient->dataType("relation", $arrayPointer);
        }
        else
            return null;
    }
    else
        return null;
}

/**
 * Restituisce un array di objectId che rapprsentano gli id degli oggetti con cui si
 * è in relazione
 * Esempio:
 * Dato un album, voglio reperire gli utenti che hanno messo un like (i lovers)
 * 
 * $users = fromParseRelation("Album", "lovers", $album->objectId, "_Users");
 * 
 * E' necessario gestire anche l'errore perché si deve fare una query verso Parse
 * 
 * @param type $fromClassName nome della classe di partenza
 * @param type $fromField colonna della tabella che rappresenta la relazione
 * @param type $fromObjectId id dell'oggetto di partenza
 * @param type $toClassName nome della classe con cui l'oggetto è in relazione
 * @return \error|null
 */
function fromParseRelation($fromClassName, $fromField, $fromObjectId, $toClassName) {
    
    if ($fromClassName != null && $fromField != null && $fromObjectId != null && $toClassName != null &&
            count($fromClassName) > 0 && count($fromField) > 0 && count($fromObjectId) > 0 && count($toClassName) > 0) {

        //inizializzo la variabile di ritorno a null
        $objectids = null;

        //query sulla classe con cui devo fare la relazione
        $parseQuery = new parseQuery($toClassName);
        $parseQuery->whereRelatedTo($fromField, $fromClassName, $fromObjectId);
        try {
            //try catch perché devo fare una query su Parse
            $result = $parseQuery->find();

            if (is_array($result->results) && count($result->results) > 0) {
                $objectids = array();
                //ciclo sui risultati che sono degli oggetti di cui non mi interessa sapere il tipo
                foreach (($result->results) as $object) {
                    //controllo che abbiano un objectId
                    if ($object != null && isset($object->objectId))
                        //aggiungo all'array da restituire
                        $objectids[] = $object->objectId;
                }
                return $objectids;
            }
            else
                return null;
        } catch (Exception $e) {
            //salvo l'errore
           return throwError($e,__CLASS__ , __FUNCTION__, func_get_args);
        }
    }
    else
        return null;
}

/**
 * Trasforma un DateTime (oggetto PHP) in un array che rappresenta un tipo
 * Date in Parse
 * 
 * @param DateTime $dateTime
 * @return null
 */
function toParseDateTime(DateTime $dateTime) {
    if ($dateTime == null)
        return null;
    else{
        $parseRestClient = new parseRestClient();
        return $parseRestClient->dataType('date', $dateTime->format('r'));
    }
}

/**
 * Restituisce un array che rappresenta un tipo GeoPoint in Parse
 * @param parseGeoPoint $geoPoint
 * @return null
 */
function toParseGeoPoint(parseGeoPoint $geoPoint) {
    if ($geoPoint==null)
        return null;
    return $geoPoint->location;
}

/**
 * Funzione per la gestione degli errori
 * 
 * @param type $exception Eccezione lanciata
 * @param type $class =  impostato al parametro __CLASS__
 * @param type $function = impostato al parametro __FUNCTION__
 * @param type $args = impostato al parametro func_get_args()
 * @return \error 
 */
function throwError($exception ,$class,$function,$args){
    $error = new error();
    $error->setErrorClass($class);
    $error->setErrorCode($exception->getCode());
    $error->setErrorMessage($exception->getMessage());
    $error->setErrorFunction($function);
    $error->setErrorFunctionParameter($args);
    $errorParse = new errorParse();
    $errorParse->saveError($error);
    return $error;
}
    
function toParseFile($args){
    
}
     //@todo   
return null;

function fromParseFile($args){
     //@todo   
return null;
}
?>
