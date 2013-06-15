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
    if (!$object || !is_object($object))
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

    return parseObject::dataType("pointer", array($className, $object->{"getObjectId"}()));
}

/**
 * 
 * @param array $array
 * @return null
 */
function toParseRelation(array $array) {
    if (!$array || !count($array) > 0 || !is_object($array[0]))
        return null;
    
    $arrayPointer = array();

    foreach ($array as $istance) {
        $pointer = toParsePointer($istance);
        $arrayPointer[] = $pointer;
    }
    return parseObject::dataType("relation", $arrayPointer);
}

/**
 * 
 * @param DateTime $dateTime
 * @return null
 */
function toParseDateTime(DateTime $dateTime) {
    if (!$dateTime)
        return null;
    return parseObject::dataType('date', $dateTime->format('r'));
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
