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
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

class LocationParse {

    private $parseQuery;

    function __construct() {

        $this->parseQuery = new ParseQuery("Location");
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getLocation($objectId) {
        try {
            $parseObject = new parseObject('Location');
            $res = $parseObject->get($objectId);
            $cmt = $this->parseToLocation($res);
            return $cmt;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getLocations() {
        try {
            $locations = array();
            $res = $this->parseQuery->find();
            foreach ($res->results as $obj) {
                $location = $this->parseToComment($obj);
                $locations[$location->getObjectId()] = $location;
            }
            return $locations;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    function parseToLocation(stdClass $parseObj) {
        try {
            $location = new Location();
            $location->setObjectId($parseObj->objectId);
            $location->setCity($parseObj->city);
            $location->setCountry($parseObj->country);
            $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
            $location->setLocation($parseGeoPoint);
            $location->setLocId($parseObj->locId);
            $location->setCreatedAt(new DateTime($parseObj->createdAt));
            $location->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $location->setACL(toParseACL($parseObj->ACL));
            return $location;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function setLimit($int) {
        $this->parseQuery->setLimit($int);
    }

    public function setSkip($int) {
        $this->parseQuery->setSkip($int);
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

}

?>