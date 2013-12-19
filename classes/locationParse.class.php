<?php

/* ! \par		Info Generali:
 *  \author		Luca Gianneschi
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *
 *  \par		Info Classe:
 *  \brief		Location
 *  \details	Classe che accoglie i dati di laqtitudine e longitudine delle citta da impostre per JAMMER  e SPOTTER, non si creano nuove istanze e non si cancellano vecchie istanze. Si fanno solo le get.
 *  
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:location">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:location">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'location.class.php';

class LocationParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the Location class
     */
    function __construct() {
        $this->parseQuery = new ParseQuery('Location');
    }

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests Location
     * \return	number
     */
    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		void getLocation(string $objectId)
     * \brief	The function returns the Location object specified
     * \param	$objectId the string that represent the objectId of the Location
     * \return	Location	the Location with the specified $objectId
     * \return	Error	the Error raised by the function
     */
    public function getLocation($objectId) {
        try {
            $parseLocation = new parseObject('Location');
            $res = $parseLocation->get($objectId);
            $cmt = $this->parseToLocation($res);
            return $cmt;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    /**
     * \fn		array getLocations()
     * \brief	The function returns the Locations objects specified
     * \return	array 	an array of Location, if one or more Location are found
     * \return	null	if no Location are found
     * \return	Error	the Error raised by the function
     */
    public function getLocations() {
        try {
            $locations = null;
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $locations = array();
                foreach ($res->results as $obj) {
                    $location = $this->parseToLocation($obj);
                    $locations[$location->getObjectId()] = $location;
                }
            }
            return $locations;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void orderBy($field)
     * \brief	Specifies which field need to be ordered of requested Location
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested Location
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested Location
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		Location parseToLocation($res)
     * \brief	The function returns a representation of an Location object in Parse
     * \param	$res 	represent the Location object returned from Parse
     * \return	Location	the Location object
     * \return	Error	the Error raised by the function
     */
    function parseToLocation($res) {
        if (is_null($res))
            return throwError(new Exception('parseToLocation parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $location = new Location();
            $location->setObjectId($res->objectId);
            $location->setCity(parse_decode_string($res->city));
            $location->setCountry($res->country);
            $location->setGeoPoint(fromParseGeoPoint($res->geoPoint));
            $location->setLocId($res->locId);
            $location->setCreatedAt(fromParseDate($res->createdAt));
            $location->setUpdatedAt(fromParseDate($res->updatedAt));
            $location->setACL(fromParseACL($res->ACL));
            return $location;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of Location to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many Location(s) must be discarded initially
     * \param	$skip	the number of Location(s) to skip
     */
    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    /**
     * \fn		void where($field, $value)
     * \brief	Sets a condition for which the field $field must value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function where($field, $value) {
        $this->parseQuery->where($field, $value);
    }

    /**
     * \fn		void whereEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereEqualTo($field, $value) {
        $this->parseQuery->whereEqualTo($field, $value);
    }

    /**
     * \fn		void whereExists($field)
     * \brief	Sets a condition for which the field $field must be enhanced
     * \param	$field	the string which represent the field
     */
    public function whereExists($field) {
        $this->parseQuery->whereExists($field);
    }

    /**
     * \fn		void whereGreaterThan($field, $value)
     * \brief	Sets a condition for which the field $field must value more than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereGreaterThan($field, $value) {
        $this->parseQuery->whereGreaterThan($field, $value);
    }

    /**
     * \fn		void whereGreaterThanOrEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value equal or more than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereGreaterThanOrEqualTo($field, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
    }

    /**
     * \fn		void whereLessThan($field, $value)
     * \brief	Sets a condition for which the field $field must value less than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereLessThan($field, $value) {
        $this->parseQuery->whereLessThan($field, $value);
    }

    /**
     * \fn		void whereLessThanOrEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must value equal or less than $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereLessThanOrEqualTo($field, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($field, $value);
    }

    /**
     * \fn		void whereNotEqualTo($field, $value)
     * \brief	Sets a condition for which the field $field must not value $value
     * \param	$field	the string which represent the field
     * \param	$value	the string which represent the value
     */
    public function whereNotEqualTo($field, $value) {
        $this->parseQuery->whereNotEqualTo($field, $value);
    }

    /**
     * \fn		void whereNotExists($field)
     * \brief	Sets a condition for which the field $field must not be enhanced
     * \param	$field	the string which represent the field
     */
    public function whereNotExists($field) {
        $this->parseQuery->whereDoesNotExist($field);
    }

}

?>