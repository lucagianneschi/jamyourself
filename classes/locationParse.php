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
require_once CLASSES_DIR . 'location.class.php';

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
            $parseLocation = new parseObject('Location');
            $res = $parseLocation->get($objectId);
            $cmt = $this->parseToLocation($res);
            return $cmt;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getLocations() {
        $locations = null;
        try {
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $locations = array();
                foreach ($res->results as $obj) {
                    if ($obj) {
                        $location = $this->parseToLocation($obj);
                        $locations[$location->getObjectId] = $location;
                    }
                }
            }
            return $locations;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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

    function parseToLocation($res) {
        if (is_null($res))
		return throwError(new Exception('parseToVideo parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $location = new Location();
            $location->setObjectId($res->objectId);
            $location->setCity($res->city);
            $location->setCountry($res->country);
            $parseGeoPoint = new parseGeoPoint($res->location->latitude, $res->location->longitude);
            $location->setLocation($parseGeoPoint);
            $location->setLocId($res->locId);
            $location->setCreatedAt(new DateTime($res->createdAt));
            $location->setUpdatedAt(new DateTime($res->updatedAt));
            $location->setACL(toParseACL($res->ACL));
            return $location;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    public function where($field, $value) {
        $this->parseQuery->where($field, $value);
    }

    public function whereContainedIn($field, $values) {
        $this->parseQuery->whereContainedIn($field, $values);
    }

    public function whereEqualTo($field, $value) {
        $this->parseQuery->whereEqualTo($field, $value);
    }

    public function whereExists($field) {
        $this->parseQuery->whereExists($field);
    }

    public function whereGreaterThan($field, $value) {
        $this->parseQuery->whereGreaterThan($field, $value);
    }

    public function whereGreaterThanOrEqualTo($field, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
    }

    public function whereLessThan($field, $value) {
        $this->parseQuery->whereLessThan($field, $value);
    }

    public function whereLessThanOrEqualTo($field, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($field, $value);
    }

    public function whereNotContainedIn($field, $array) {
        $this->parseQuery->whereNotContainedIn($field, $array);
    }

    public function whereNotEqualTo($field, $value) {
        $this->parseQuery->whereNotEqualTo($field, $value);
    }

    public function whereNotExists($field) {
        $this->parseQuery->whereDoesNotExist($field);
    }

    public function wherePointer($field, $className, $objectId) {
        $this->parseQuery->wherePointer($field, $className, $objectId);
    }

    public function whereRelatedTo($field, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($field, $className, $objectId);
    }

}

?>