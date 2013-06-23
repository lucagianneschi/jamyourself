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
require_once CLASSES_DIR . 'utils.class.php';

require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

     public function getPlaylists() {
        $playlists = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $playlists = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $playlist = $this->parseToActivity($obj);
                        $playlists[$playlist->getObjectId] = $playlist;
                    }
                }
            }
            return $playlists;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
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
        try {
            $playlist = new Playlist();
            $playlist->setObjectId($parseObj->objectId);
            $playlist->setActive($parseObj->active);
            $playlist->setFromUser(fromParsePointer($parseObj->fromUser));
            $playlist->setName($parseObj->name);
            $playlist->setSongs(fromParseRelation("Playlist", "songs", $parseObj->objectId, "Song"));
            $playlist->setUnlimited($parseObj->unlimited);
            $playlist->setCreatedAt(fromParseDate($parseObj->createdAt));
            $playlist->setUpdatedAt(fromParseDate($parseObj->updatedAt));
            $playlist->setACL(fromParseACL($parseObj->ACL));
            return $playlist;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function savePlaylist(Playlist $playlist) {
        try {

            $parseObject = new parseObject('Playlist');
            is_null($playlist->getActive()) ? $parseObject->active = null : $parseObject->active = $playlist->getActive();
            is_null($playlist->getFromUser()) ? $parseObject->fromUser = null : $parseObject->fromUser = toParsePointer('_User', $playlist->getFromUser());
            is_null($playlist->getName()) ? $parseObject->name = null : $parseObject->name = $playlist->getName();
            is_null($playlist->getSongs()) ? $parseObject->songs = null : $parseObject->songs = toParseRelation('Song', $playlist->getSongs());
            is_null($playlist->getUnlimited()) ? $parseObject->unlimited = false : $parseObject->unlimited = $playlist->getUnlimited();
            $acl = new ParseACL;
            $acl->setPublicReadAccess(true);
            $acl->setPublicWriteAccess(true);
            $playlist->setACL($acl);
            if ($playlist->getObjectId() == '') {
                $res = $parseObject->save();
                $playlist->setObjectId($res->objectId);
                return $playlist;
            } else {
                $parseObject->update($playlist->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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