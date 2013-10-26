<?php

/* ! \par Info	Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *
 *  \par	Info Classe:
 *  \brief	Utils class
 *  \details	Classe di utilità sfruttata delle classi modello per snellire il codice
 *
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

/**
 * \fn		number executionTime($start, $end)
 * \brief	The function returns the difference between $end and $start parameter in microseconds
 * \param	$start		represent the microsecond time of the begin of the operation
 * \param	$end		represent the microsecond time of the end of the operation
 * \return	number		the number representing the difference in microsecond
 * \return	Error		if the parameters are null
 */
function executionTime($start, $end) {
    if (is_null($start) || is_null($end))
	return throwError(new Exception('executionTime parameters are incorrect'), 'Utils', __FUNCTION__, func_get_args());
    $arrStart = explode(' ', $start);
    $arrEnd = explode(' ', $end);
    $secStart = $arrStart[1];
    $secEnd = $arrEnd[1];
    $msecStart = substr($arrStart[0], 2, 6);
    $msecEnd = substr($arrEnd[0], 2, 6);
    if (($secStart - $secEnd) == 0) {
	$time = '0.' . str_pad($msecEnd - $msecStart, 6, 0, STR_PAD_LEFT);
    } else {
	$timeStart = $secStart . '.' . $msecStart;
	$timeEnd = $secEnd . '.' . $msecEnd;
	$time = round(($timeEnd - $timeStart), 6);
    }
    return $time;
}

/**
 * \fn		parseACL fromParseACL($parseACL)
 * \brief	The function returns a parseACL object from the representation of ACL in Parse
 * \param	$parseACL 	represent the ACL object returned from Parse
 * \return	parseACL	the parseACL object
 * \return	null		if the parameter is null
 */
function fromParseACL($parseACL) {
    if (is_null($parseACL)) {
	return null;
    } else {
	$pACL = new parseACL();
	foreach ($parseACL as $key => $value) {
	    if ($key == "*") {
		if (isset($value->read)) {
		    $pACL->setPublicReadAccess($parseACL->{$key}->read);
		}
		if (isset($value->write)) {
		    $pACL->setPublicWriteAccess($parseACL->{$key}->write);
		}
	    } else {
		if (isset($value->read)) {
		    $pACL->setReadAccessForId($key, $parseACL->{$key}->read);
		}
		if (isset($value->write)) {
		    $pACL->setWriteAccessForId($key, $parseACL->{$key}->write);
		}
	    }
	}
	return $pACL;
    }
}

/**
 * \fn		DateTime fromParseDate($date)
 * \brief	The function returns a DateTime object from the representation of Date in Parse
 * \param	$date 		represent the Date object returned from Parse
 * \return	DateTime	the DateTime object
 * \return	Error		if the $date parameter is not set
 */
function fromParseDate($date) {
    if (is_null($date))
	return throwError(new Exception('fromParseDate parameters are incorrect'), 'Utils', __FUNCTION__, func_get_args());
    if (is_object($date) && isset($date->__type) && $date->__type == 'Date' && isset($date->iso)) {
	return new DateTime($date->iso);
    } else {
	return new DateTime($date);
    }
}

/**
 * \fn		parseFile fromParseFile($filePointer, $mime_type)
 * \brief	Crea un nuovo oggetto parseFile reperendolo da Parse
 * \param	$filePointer	represent the filePointer object returned from Parse
 * \param	$mime_type		represent the extension of the file ("pdf/application", "mp3/audio", "img/jpg", ...)
 * \return	parseFile		the parseFile object
 * \return	null			if the $filePointer parameter is not set
 * \warning Function never tested and never verified
 */
function fromParseFile($filePointer, $mime_type) {
    if ($filePointer != null && isset($filePointer->url)) {
	try {
	    $data = file_get_contents($filePointer->url);
	    $parseFile = new parseFile($mime_type, $data);
	    $parseFile->_fileName = $filePointer->name;
	    return $parseFile;
	} catch (Exception $exception) {
	    return throwError($exception, 'utils', __FUNCTION__, func_get_args());
	}
    }
    else
	return null;
}

/**
 * \fn		parseGeoPoint fromParseGeoPoint($geoPoint)
 * \brief	The function returns a parseGeoPoint object from the representation of GeoPoint in Parse
 * \param	$geoPoint 		represent the GeoPoint object returned from Parse
 * \return	parseGeoPoint	the parseGeoPoint object
 * \return	null			if the $geoPoint parameter is not set
 */
function fromParseGeoPoint($geoPoint) {
    if (is_null($geoPoint)) {
	return null;
    } else {
	$parseGeoPointer = new parseGeoPoint($geoPoint->latitude, $geoPoint->longitude);
	return $parseGeoPointer;
    }
}

/**
 * \fn		string fromParseGeoPoint($pointer)
 * \brief	The function returns an objectId string like representation of the Pointed object
 * \param	$pointer	represent the Pointer object returned from Parse
 * \return	string		the object objectId
 * \return	null		if the $pointer parameter is not set
 */
function fromParsePointer($pointer) {
    if (is_null($pointer)) {
	return null;
    } elseif ($pointer->__type == 'Pointer') {
	return $pointer->objectId;
    } elseif ($pointer->__type == 'Object') {
	switch ($pointer->className) {
	    case '_User':
		require_once CLASSES_DIR . 'user.class.php';
		require_once CLASSES_DIR . 'userParse.class.php';
		$userParse = new UserParse();
		$object = $userParse->parseToUser($pointer);
		break;
	}
	return $object;
    }
}

/**
 * \fn		array fromParseRelation($fromClassName, $fromField, $fromObjectId, $toClassName)
 * \brief	The function returns an array of objectId like representation of all the objects in relation with the class (i.e. all the Users
 * 			relationed with an Event are: fromParseRelation('Event', 'partecipateToEvent', '<eventObjectId>', '_User')
 * \param	$fromClassName	represent the name of the class of the relation
 * \param	$fromField		represent the field name of the class of the relation
 * \param	$fromObjectId	represent the objectId of the class of the relation
 * \param	$toClassName	represent the name of the class with whom I have the relation
 * \return	array			the array of all objectId relationed
 * \return	null			if no relation is present
 * \return	Error			the Error raised by the function
 */
function fromParseRelation($fromClassName, $fromField, $fromObjectId, $toClassName) {
    if (is_null($fromClassName) || is_null($fromField) || is_null($fromObjectId) || is_null($toClassName)) {
	return throwError(new Exception('fromParseRelation parameters are incorrect'), 'utils', __FUNCTION__, func_get_args());
    } else {
	try {
	    //inizializzo la variabile di ritorno a null
	    $objectIds = null;
	    //query sulla classe con cui devo fare la relazione
	    $parseQuery = new parseQuery($toClassName);
	    $parseQuery->whereRelatedTo($fromField, $fromClassName, $fromObjectId);
	    $res = $parseQuery->find();
	    if (is_array($res->results) && count($res->results) > 0) {
		$objectIds = array();
		foreach ($res->results as $obj) {
		    //controllo che abbiano un objectId
		    if (isset($obj->objectId)) {
			$objectIds[] = $obj->objectId;
		    }
		}
		return $objectIds;
	    } else {
		return null;
	    }
	} catch (Exception $e) {
	    return throwError($e, 'utils', __FUNCTION__, func_get_args());
	}
    }
}

/**
 * \fn		array toParseACL($parseACL)
 * \brief	The function returns an array like representation of parseACL object
 * \param	$parseACL 	represent the parseACL object
 * \return	array		the array representation of a parseACL object
 * \return	null		if the $parseACL parameter is not set
 */
function toParseACL($parseACL) {
    if (is_null($parseACL)) {
	return null;
    } else {
	return $parseACL->acl;
    }
}

/**
 * \fn		array toParseDate($date)
 * \brief	The function returns an array like representation of Date object
 * \param	$date 	represent the DateTime object
 * \return	array	the array representation of a Date object
 * \return	null	if the $parseACL parameter is not set
 */
function toParseDate($date) {
    if (is_null($date)) {
	return null;
    } else {
	$parseRestClient = new parseRestClient();
	return $parseRestClient->dataType("date", $date->format("r"));
    }
}

/**
 * \fn		array toParseACL($parseACL)
 * \brief	The function returns an array like representation of parseACL object
 * \param	$parseACL 	represent the parseACL object
 * \return	array		the array representation of a parseACL object
 * \return	null		if the $parseACL parameter is not set
 */
function toParseDefaultACL() {
    try {
	$parseACL = new ParseACL();
	$parseACL->setPublicWriteAccess(true);
	$parseACL->setPublicReadAccess(true);
	return toParseACL($parseACL);
    } catch (Exception $e) {
	return throwError($e, 'utils', __FUNCTION__, func_get_args());
    }
}

/**
 * \fn		array toParseFile($parseFile)
 * \brief	The function returns an array like representation of File object, uploading existing File
 * \param	$parseFile 	represent the File object
 * \return	array		the array representation of a parseFile object
 * \return	null		if the $parseFile parameter is not set
 * \warning Function never tested and never verified
 */
function toParseFile($parseFile) {
    if ($parseFile != null && isset($parseFile->_fileName)) {
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
 * \fn		array toParseGeoPoint($geoPoint)
 * \brief	The function returns an array like representation of GeoPoint object
 * \param	$geoPoint 	represent the parseGeoPoint object
 * \return	array		the array representation of a GeoPoint object
 * \return	null		if the $geoPoint parameter is not set
 */
function toParseGeoPoint($geoPoint) {
    if (is_null($geoPoint)) {
	return null;
    } else {
	return $geoPoint->location;
    }
}

/**
 * \fn		array toParsePointer($className, $objectId)
 * \brief	The function returns an array like representation of Pointer object
 * \param	$className 	represent the object class
 * \param	$objectId 	represent the object objectId
 * \return	array		the array representation of a Pointer object
 * \return	null		if the $className or $objectId parameter are not set
 */
function toParsePointer($className, $objectId) {
    if (is_null($className) || is_null($objectId)) {
	return null;
    } else {
	$parseRestClient = new parseRestClient();
	return $parseRestClient->dataType("pointer", array($className, $objectId));
    }
}

/**
 * Crea un array di punatori che rappresenta una relation in Parse a partire da un array
 * di stringhe di objectId
 * @param array $array
 * @return null
 */

/**
 * \fn		array toParseAddRelation($className, $objectIds)
 * \brief	The function returns an array like representation of all Relation objects
 * \param	$className 	represent the object class
 * \param	$objectIds 	is the array of objectId
 * \return	array		the array representation of all Relation objects
 * \return	null		if no relation is present
 * \return	Error		the Error raised by the function
 */
function toParseAddRelation($className, $objectIds) {
    if (is_null($className) || is_null($objectIds)) {
	return throwError(new Exception('toParseAddRelation parameters are incorrect'), 'utils', __FUNCTION__, func_get_args());
    } else {
	if (count($objectIds) > 0) {
	    $arrayPointer = array();
	    foreach ($objectIds as $objectId) {
		$pointer = toParsePointer($className, $objectId);
		$arrayPointer[] = $pointer;
	    }
	    $parseRestClient = new parseRestClient();
	    return $parseRestClient->dataType("addRelation", $arrayPointer);
	} else {
	    return null;
	}
    }
}

/**
 * \fn		array toParseRemoveRelation($className, $objectIds)
 * \brief	The function returns an array like representation of all Relation objects
 * \param	$className 	represent the object class
 * \param	$objectIds 	is the array of objectId
 * \return	array		the array representation of all Relation objects
 * \return	null		if no relation is present
 * \return	Error		the Error raised by the function
 */
function toParseRemoveRelation($className, $objectIds) {
    if (is_null($className) || is_null($objectIds)) {
	return throwError(new Exception('toParseRemoveRelation parameters are incorrect'), 'utils', __FUNCTION__, func_get_args());
    } else {
	if (count($objectIds) > 0) {
	    $arrayPointer = array();
	    foreach ($objectIds as $objectId) {
		$pointer = toParsePointer($className, $objectId);
		$arrayPointer[] = $pointer;
	    }
	    $parseRestClient = new parseRestClient();
	    return $parseRestClient->dataType("removeRelation", $arrayPointer);
	} else {
	    return null;
	}
    }
}

/**
 * \fn		Error throwError($exception, $class, $function, $args)
 * \brief	The function save and return an Error
 * \param	$exception 	the Exception
 * \param	$class 		the class name who raise the Exception
 * \param	$function 	the function name who raise the Exception
 * \param	$args 		the arguments passed to the function who raise an Exception
 * \return	Error		the Error saved on Parse
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
 * \fn		parseFile uploadFile($pathFile, $mime_type = '')
 * \brief	The function upload a File in Parse and return the parseFile object associated
 * \param	$pathFile 	the path of the File to upload
 * \param	$mime_type 	the mime type of the File to upload
 * \return	parseFile	the parseFile representation of File
 * \return	null		if the $parseFile parameter is not set
 * \return	Error		the Error raised by the function
 * \warning Function never tested and never verified
 */
function uploadFile($pathFile, $mime_type = '') {
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
	    if ($result != null && isset($result->name)) {
		//ora recupero il nome del file e creo un puntatore al file col dataType
		$pFile->_fileName = $result->name;
		//restituisco...
		return $pFile;
	    }
	    else
		return null;
	} catch (Exception $exception) {
	    return throwError($exception, 'utils', __FUNCTION__, func_get_args());
	}
    }
    else
	return null;
}

?>