<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     PlayslistParse
 *  \details   Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:playlist">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:playlist">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

class PlaylistParse {

    private $parseQuery;

    function __construct() {

        $this->parseQuery = new ParseQuery("Playlist");
    }

    public function deletePlaylist($objectId) {
        try {
            $parseObject = new parseObject('Playlist');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getPlaylist($objectId) {
        try {
            $parseObject = new parseObject('Playlist');
            $res = $parseObject->get($objectId);
            $playlist = $this->parseToPlaylist($res);
            return $playlist;
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function getPlaylists() {
        $playslists = array();
        $res = $this->parseQuery->find();
        foreach ($res->results as $obj) {
            $playslist = $this->parseToPlaylist($obj);
            $playslists[$playslist->getObjectId()] = $playslist;
        }
        return $playslists;
    }

    public function getRelatedTo($field, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($field, $className, $objectId);
        $rel = $this->parseQuery->find();
        $relPlaylist = array();
        foreach ($rel->results as $playlist) {
            $relPlaylist[] = $playlist->objectId;
        }
        return $$relPlaylist;
    }

    private function isNullPointer($pointer) {
        $className = $pointer['className'];
        $objectId = $pointer['objectId'];
        $isNull = true;

        if ($className == '' || $objectId == '') {
            $isNull = true;
        } else {
            $isNull = false;
        }

        return $isNull;
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

    function parseToPlaylist(stdClass $parseObj) {

        $playlist = new Playlist();

        $playlist->setObjectId($parseObj->objectId);
        $playlist->setActive($parseObj->active);
        if ($parseObj->fromUser != null)
            $playlist->setFromUser($parseObj->fromUser);
        $playlist->setName($parseObj->name);
        $parseQuery = new parseQuery('Song');
        $parseQuery->whereRelatedTo('songs', 'Playlist', $parseObj->objectId);
        $test = $parseQuery->find();
        $songRelatedTo = array();
        foreach ($test->results as $song) {
            $songRelatedTo[] = $song->objectId;
        }
        $playlist->setSongs($songRelatedTo);
        $playlist->setUnlimited($parseObj->unlimited);
        if (isset($parseObj->createdAt))
            $playlist->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $playlist->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $playlist->setACL($acl);
        return $playlist;
    }

    public function savePlaylist(Playlist $playlist) {
        try {
            $parseObject = new parseObject('Playlist');
            if ($playlist->getObjectId() == '') {

                $playlist->getActive() === null ? $parseObject->active = null : $parseObject->active = $playlist->getActive();
                $playlist->getFromUser() == null ? $parseObject->fromUser = null : $parseObject->fromUser = $playlist->getFromUser();
                $playlist->getName() == null ? $parseObject->name = null : $parseObject->name = $playlist->getName();
                $playlist->getSongs() == null ? $parseObject->songs = null : $parseObject->songs = $playlist->getSongs();
                $playlist->getUnlimited() === null ? $parseObject->unlimited = null : $parseObject->unlimited = $playlist->getUnlimited();
                $playlist->getACL() == null ? $parseObject->ACL = null : $parseObject->ACL = $playlist->getACL()->acl;
                $res = $parseObject->save();
                return $res->objectId;
            } else {
                if ($playlist->getActive() != null)
                    $parseObject->active = $playlist->getActive();
                if ($playlist->getFromUser() != null)
                    $parseObject->fromUser = $playlist->getFromUser();
                if ($playlist->getName() != null)
                    $parseObject->name = $playlist->getName();
                if ($playlist->getSongs() != null)
                    $parseObject->songs = $playlist->getSongs();
                if ($playlist->getUnlimited() != null)
                    $parseObject->unlimited = $playlist->getUnlimited();
                if ($playlist->getACL() != null)
                    $parseObject->ACL = $playlist->getACL()->acl;
                $parseObject->update($playlist->getObjectId());
            }
        } catch (Exception $e) {
            $error = new error();
            $error->setErrorClass(__CLASS__);
            $error->setErrorCode($e->getCode());
            $error->setErrorMessage($e->getMessage());
            $error->setErrorFunction(__FUNCTION__);
            $error->setErrorFunctionParameter(func_get_args());

            $errorParse = new errorParse();
            $errorParse->saveError($error);

            return $error;
        }
    }

    public function setLimit($int) {
        $this->parseQuery->setLimit($int);
    }

    public function setSkip($int) {
        $this->parseQuery->setSkip($int);
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

}

?>