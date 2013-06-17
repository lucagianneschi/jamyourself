<?php

//**************************************************************************    
//     
//     Metodi ausiliari dalla classe da usare nella save
//     per la conversione dei tipi base di parse
//     
//*************************************************************************/    

/**
 * 
 * @param parseACL $ACL
 * @return null
 */
function toParseACL(parseACL $ACL) {
    if (!$ACL)
        return null;
    return $ACL->acl;
}

/**
 * 
 * @param type $object
 * @return null
 */
function toParsePointer($object) {
//     ["__type"] => string(7) "Pointer" 
//    ["className"]=> string(5) "_User" 
//    ["objectId"]=> string(10) "zINFFnEZOi" 

    if (!$object || !is_object($object) || !isset($object->__type) || !$object->__type == "Pointer" || !isset($object->className) || !isset($object->objectId))
        return null;
    else
        return (new parseRestClient())->dataType("pointer", array($object->className, $object->getObjectId()));
}

/**
 * 
 * @param array $array
 * @return null
 */
function toParseRelation(array $objects) {
    
//    ["__type"]=> string(8) "Relation" ["className"]=> string(5) "_User"
    
    $arrayPointer = array();

    foreach ($objects as $istance) {
        $pointer = toParsePointer($istance);
        if ($pointer)
            $arrayPointer[] = $pointer;
    }
    return (new parseRestClient())->dataType("relation", $arrayPointer);
}

/**
 * 
 * @param DateTime $dateTime
 * @return null
 */
function toParseDateTime(DateTime $dateTime) {
    if (!$dateTime)
        return null;
    return (new parseRestClient())->dataType('date', $dateTime->format('r'));
}

/**
 * 
 * @param parseGeoPoint $geoPoint
 * @return null
 */
function toParseGeoPoint(parseGeoPoint $geoPoint) {
    if (!$geoPoint)
        return null;
    return $geoPoint->location;
}

function getRelationType(array $objects){
    if( count($objects)<= 0 || count($className) = 0 ) return null;
    else{
        $arrayPointer = array();
        foreach ($objects as $object){
            if(is_object($object)){
                $pointer = toParsePointer($object);
                if($pointer) $arrayPointer[] = $pointer;
            }
        }
        if(count($arrayPointer)>0)  return $arrayPointer;
        else return null;
    }
}

//**************************************************************************    
//     
//     Metodi ausiliari dalla classe da usare nel parseToObject
//     per il recupero degli oggetti nelle relazioni e nei puntatori
//     
//*************************************************************************/

/**
 * Verifica che una property passata come argomento sia un Pointer in Parse
 * @param type $property
 * @return boolean
 */
function isParsePointer($property) {

    if ($property == null || is_object($property) == false)
        return false;
    if (isset($property->__type) && $property->__type == "Pointer")
        return true;
    else
        return false;
}

/**
 * Verifica che una property passata come argomento sia un GeoPoint in Parse
 * @param type $property
 * @return boolean
 */
function isParseGeoPoint($property) {
    if ($property == null || is_object($property) == false)
        return false;
    if (isset($property->__type) && $property->__type == "GeoPoint")
        return true;
    else
        return false;
}

/**
 * Verifica che una property passata come argomento sia una Relation in Parse
 * @param type $property
 * @return boolean
 */
function isParseRelation($property) {

    if ($property == null || is_object($property) == false)
        return false;
    if (isset($property->__type) && $property->__type == "Relation")
        return true;
    else
        return false;
}

?>
