<?php

////////////////////////////////////////////////////////////////////////////////
//
//    Script per le funzioni ausiliari nella gestione dei tipi di Parse
//    
//    =====>> NB: ciò che esce dalla FROM deve poter entrare nella TO <<=====
//
////////////////////////////////////////////////////////////////////////////////
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'errorParse.class.php';

////////////////////////////////////////////////////////////////////////////////
//
//          Gestione ACL
//
////////////////////////////////////////////////////////////////////////////////
/**
 * Crea un Array multidimensionale che rappresenta un oggetto parseACL
 * @param type $ACL
 * @return \array|null
 */
function fromParseACL($parseACL) {

    if (!is_null($parseACL) && count((array) $parseACL) > 0) {

        $ACL = new parseACL();
        foreach ($parseACL as $key => $value) {
            if ($key == "*") {
                if (isset($value->read)) {
                    $ACL->setPublicReadAccess($parseACL->{$key}->read);
                }
                if (isset($value->write)) {
                    $ACL->setPublicWriteAccess($parseACL->{$key}->write);
                }
            } else {
                if (isset($value->read)) {
                    $ACL->setReadAccessForId($key, $parseACL->{$key}->read);
                }
                if (isset($value->write)) {
                    $ACL->setWriteAccessForId($key, $parseACL->{$key}->write);
                }
            }
        }
        return $ACL;
    }
    else
        return throwError(new Exception("fromParseACL: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

/**
 * @param parseACL $ACL

 */
function toParseACL($ACL) {
    if (is_null($ACL) || !isset($ACL->acl) || is_null($ACL->acl))
        return throwError(new Exception("toParseACL: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
    return $ACL->acl;
}

////////////////////////////////////////////////////////////////////////////////
//
//          Gestione Date
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Crea un date time a partire dalla stringa fornita da parse
 * @param type $date
 * @return \DateTime|null
 */
function fromParseDate($date) {
    if (is_object($date) && isset($date->__type) && $date->__type == "Date" && isset($date->iso)) {
        return new DateTime($date->iso);
    } else if ($date != null && count($date) > 0)
        return new DateTime($date);
    else
        return throwError(new Exception("toParseACL: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

/**
 * Crea un array riconosciuto da parse come tipo date a partire da un DateTime
 * @param DateTime $date
 */
function toParseDate($date) {
    if (!is_null($date) && is_a($date, "DateTime")) {
        $parseRestClient = new parseRestClient();
        return $parseRestClient->dataType("date", $date->format("r"));
    }
    else
        return throwError(new Exception("toParseDate: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

////////////////////////////////////////////////////////////////////////////////
//
//          Gestione GeoPoint
//
////////////////////////////////////////////////////////////////////////////////

/**
 * 
 * @param type $geoPoint

 */
function fromParseGeoPoint($geoPoint) {
    if (!is_null($geoPoint) && is_object($geoPoint) && isset($geoPoint->latitude) && isset($geoPoint->longitude)) {
        $parseGeoPointer = new parseGeoPoint($geoPoint->latitude, $geoPoint->longitude);
        return $parseGeoPointer;
    } else {
        return throwError(new Exception("fromParseGeoPoint: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
    }
}

/**
 * Restituisce un array che rappresenta un tipo GeoPoint in Parse
 * @param parseGeoPoint $geoPoint

 */
function toParseGeoPoint($geoPoint) {
    if (is_null($geoPoint) || !isset($geoPoint->location))
        return throwError(new Exception("toParseGeoPoint: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
    return $geoPoint->location;
}

////////////////////////////////////////////////////////////////////////////////
//
//          Gestione File
//
////////////////////////////////////////////////////////////////////////////////
/**
 * Crea un nuovo oggetto parseFile reperendolo da Parse
 * 
 * @param type $filePointer
 * @param type $mime_type l'estensione MIME del file es: "txt" 
 * oppure "pdf/application" oppure "mp3/audio" oppure "img/jpg", ecc...
 * 
 * @return \parseFile|null
 */
function fromParseFile($filePointer, $mime_type) {
    if (!is_null($filePointer) && isset($filePointer->url)) {
        try {
            $data = file_get_contents($filePointer->url);
            $parseFile = new parseFile($mime_type, $data);
            $parseFile->_fileName = $filePointer->name;
            return $parseFile;
        } catch (Exception $exception) {
            return throwError($exception, "Utils", __FUNCTION__, func_get_args());
        }
    }
    else
        return throwError(new Exception("fromParseFile: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

/**
 * Crea un array visibile da Parse come un tipo puntatore a "File"
 * preoccupandosi di uploadarlo (per file GIA' esistenti in Parse)
 * @param parseFile $parseFile

 */
function toParseFile($parseFile) {

    if (!is_null($parseFile) && isset($parseFile->_fileName)) {
        //carico i contenuti del file    
        //ora recupero il nome del file e creo un puntatore al file col dataType
        $parseRestClient = new parseRestClient();
        $parseFile = $parseRestClient->dataType("file", array($parseFile->_fileName));
        //restituisco...
        return $parseFile;
    }
    else
        return throwError(new Exception("toParseFile: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

/**
 * Crea un oggetto parseFile  che dovrà essere poi trasformato in un
 * array "file" par parse preoccupandosi di uploadarlo 
 * @param type $pathFile il path del file
 * @param type $mime_type il tipo MIME del file, es: "txt" 
 * oppure "pdf/application" oppure "mp3/audio" oppure "img/jpg", ecc...

 */
function uploadFile($pathFile, $mime_type = '') {

    if (!is_null($pathFile) && file_exists($pathFile) && !is_null($mime_type)) {
        try {
            //carico i contenuti del file    
            $data = file_get_contents($pathFile);
            //carico le info del file
            $path_parts = pathinfo($pathFile);
            //creo il parseFile
            $pFile = new parseFile($mime_type, $data);
            //tento l'upload su parse
            $result = $pFile->save($path_parts['filename']);
            //
            if (!is_null($result) && isset($result->name)) {
                //ora recupero il nome del file e creo un puntatore al file col dataType
                $pFile->_fileName = $result->name;
                //restituisco...
                return $pFile;
            }
            else
                return throwError(new Exception("uploadFile: upload failed"), "Utils", __FUNCTION__, func_get_args());
        } catch (Exception $exception) {
            return throwError($exception, "Utils", __FUNCTION__, func_get_args());
        }
    }
    else
        return throwError(new Exception("uploadFile: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

////////////////////////////////////////////////////////////////////////////////
//
//          Gestione Pointer
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Fornisce una stringa che rappresenta l'objectId dell'oggetto rappresentato
 * come puntatore in Parse
 * @param type $pointer l'oggetto puntatore di Parse

 */
function fromParsePointer($pointer) {
    if (is_object($pointer) &&
            isset($pointer->__type) &&
            $pointer->__type == "Pointer" &&
            isset($pointer->className) &&
            isset($pointer->objectId)) {

        return $pointer->objectId;
    } else {
        return throwError(new Exception("fromParsePointer: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
    }
}

/**
 * Restituisce un array che rappresenta un puntatore in Parse
 * @param type $className nome della classe a cui si punta
 * @param type $objectId id dell'oggetto puntato

 */
function toParsePointer($className, $objectId) {
    //se sono stringhe valide
    if (count($className) > 0 && count($objectId) > 0) {
        $parseRestClient = new parseRestClient();
        return $parseRestClient->dataType("pointer", array($className, $objectId));
    }
    else
        return throwError(new Exception("toParsePointer: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

////////////////////////////////////////////////////////////////////////////////
//
//          Gestione Relation
//
////////////////////////////////////////////////////////////////////////////////

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

    if (!is_null($toClassName) && $fromField != null && $fromObjectId != null && $toClassName != null &&
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
                return throwError(new Exception("fromParseRelation: empty relation"), "Utils", __FUNCTION__, func_get_args());
        } catch (Exception $e) {
            //salvo l'errore
            return throwError($e, "Utils", __FUNCTION__, func_get_args());
        }
    }
    else
        return throwError(new Exception("fromParseRelation: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

/**
 * Crea un array di punatori che rappresenta una relation in Parse a partire da un array
 * di stringhe di objectId
 * @param array $array
 */
function toParseRelation($className, $objects) {

    if ($className != null && $objects != null && count($className) > 0) {
        $arrayPointer = array();
        if (count($objects) > 0) {
            foreach ($objects as $objectId) {
                $pointer = toParsePointer($className, $objectId);
                if ($pointer)
                    $arrayPointer[] = $pointer;
            }

            $parseRestClient = new parseRestClient();
            return $parseRestClient->dataType("relation", $arrayPointer);
        }
        else
            return throwError(new Exception("toParseRelation: Array Id is empty"), "Utils", __FUNCTION__, func_get_args());
    }
    else
        return throwError(new Exception("toParseRelation: Invalid Parameter"), "Utils", __FUNCTION__, func_get_args());
}

////////////////////////////////////////////////////////////////////////////////
//
//          Gestione Errori
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Funzione per la gestione degli errori
 * 
 * @param type $exception Eccezione lanciata
 * @param type $class =  impostato al parametro "Utils"
 * @param type $function = impostato al parametro __FUNCTION__
 * @param type $args = impostato al parametro func_get_args()
 * @return \error 
 */
function throwError($exception, $class, $function, $args) {
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

?>