<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');
	
require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

/**
 * 
 * @param parseACL $ACL
 * @return null
 */
function toParseACL($ACL) {
    if ($ACL == null || !isset($ACL->acl) || ($ACL->acl == null))
        return null;
    return $ACL->acl;
}

function fromParseACL($parseACL) {
    if ($parseACL != null && isset($parseACL->ACL)) {
//  Parse mi manda uno stdObj fatto così:
//        ["ACL"]=> object(stdClass)#10 (1) { 
//        #["*"]=> object(stdClass)#11 (2) { 
//        #["write"]=> bool(true) 
//        #["read"]=> bool(true) } } }
        $ACL = new parseACL();
        $ACL->acl = $parseACL->ACL;
    }
    else
        return null;
}

/**
 * Crea un array riconosciuto da parse come tipo date a partire da un DateTime
 * @param DateTime $date
 */
function toParseDate($date) {
    if ($date != null && is_a($date, "DateTime")) {
        $parseRestClient = new parseRestClient();
        return $parseRestClient->dataType("date", $date->format("r"));
    }
    else
        return null;
}

/**
 * Crea un date time a partire dalla stringa fornita da parse
 * @param type $date
 * @return \DateTime|null
 */
function fromParseDate($date) {
    if ($date != null && count($date) > 0)
        return new DateTime($date);
    else
        return null;
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
function toParseRelation($className, $objects) {

    if ($className != null && $objects != null && count($className) > 0 && count($objects) > 0) {
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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }
    else
        return null;
}

/**
 * Restituisce un array che rappresenta un tipo GeoPoint in Parse
 * @param parseGeoPoint $geoPoint
 * @return null
 */
function toParseGeoPoint(parseGeoPoint $geoPoint) {
    if ($geoPoint == null)
        return null;
    return $geoPoint->location;
}

function fromParseGeoPoint($geopoint) {
    if ($geopoint != null && is_object($geopoint) && isset($geopoint->latitude) && isset($geopoint->longitude)) {
        return new parseGeoPoint($geopoint->latitude, $geopoint->longitude);
    }
    else
        return null;
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

/**
 * Crea un array visibile da Parse come un tipo puntatore a "File"
 * preoccupandosi di uploadarlo (per file GIA' esistenti in Parse)
 * @param parseFile $parseFile
 * @return null
 */
function toParseFile($parseFile) {

    if ($parseFile != null && isset($parseFile->name)) {
        //carico i contenuti del file    
        //ora recupero il nome del file e creo un puntatore al file col dataType
        $parseRestClient = new parseRestClient();
        $parseFile = $parseRestClient->dataType("file", array($parseFile->_fileName));
        //restituisco...
        return $parseFile;
    }
    else
        return null;
}

/**
 * Crea un array visibile da Parse come un tipo puntatore a "File"
 * preoccupandosi di uploadarlo (per file NON ancora esistenti in Parse)
 * @param type $pathFile il path del file
 * @param type $mime_type il tipo MIME del file, es: "txt" 
 * oppure "pdf/application" oppure "mp3/audio" oppure "img/jpg", ecc...
 * @return null
 */
function toParseNewFile($pathFile, $mime_type = '') {

    if ($pathFile != null && file_exists($pathFile) && $mime_type != null) {
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
            if ($result && isset($result->name)) {
                //ora recupero il nome del file e creo un puntatore al file col dataType
                $parseRestClient = new parseRestClient();
                $parseFile = $parseRestClient->dataType("file", array($result->name));
                //restituisco...
                return $parseFile;
            }
            else
                return null;
        } catch (Exception $exception) {
            return throwError($exception, "Utils", __FUNCTION__, func_get_args());
        }
    }
    else
        return null;
}

/**
 * Crea un nuovo oggetto parseFile reperendolo da Parse
 * 
 * @param type $filePointer
 * @param type $mime_type l'estensione MIME del file es: "txt" 
 * oppure "pdf/application" oppure "mp3/audio" oppure "img/jpg", ecc...
 * 
 * @return \parseFile|null
 */
function fromParseFile($filePointer, $mime_type = '') {
    if ($filePointer != null && isset($filePointer->url)) {
        try {
            $data = file_get_contents($filePointer->url);
            $parseFile = new parseFile($mime_type, $data);
            return $parseFile;
        } catch (Exception $exception) {
            return throwError($exception, "Utils", __FUNCTION__, func_get_args());
        }
    }
    else
        return null;
}

?>
