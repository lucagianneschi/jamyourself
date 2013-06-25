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
require_once CLASSES_DIR . 'playlist.class.php';

class PlaylistParse {

    private $parseQuery;

    function __construct() {

        $this->parseQuery = new ParseQuery("Playlist");
    }

    public function deletePlaylist($objectId) {
        try {
            $parsePlaylist = new parseObject('Playlist');
            $parsePlaylist->active = false;
            $parsePlaylist->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getPlaylist($objectId) {
        try {
            $parsePlaylist = new parseObject('Playlist');
            $res = $parsePlaylist->get($objectId);
            $playlist = $this->parseToPlaylist($res);
            return $playlist;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

     public function getPlaylists() {
        $playlists = null;
        try {
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $playlists = array();
                foreach ($res->results as $obj) {
                    if ($obj) {
                        $playlist = $this->parseToPlaylist($obj);
                        $playlists[$playlist->getObjectId] = $playlist;
                    }
                }
            }
            return $playlists;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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

    function parseToPlaylist($res) {
        if (is_null($res))
		return throwError(new Exception('parseToVideo parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $playlist = new Playlist();
            $playlist->setObjectId($res->objectId);
            $playlist->setActive($res->active);
            $playlist->setFromUser(fromParsePointer($res->fromUser));
            $playlist->setName($res->name);
            $playlist->setSongs(fromParseRelation("Playlist", "songs", $res->objectId, "Song"));
            $playlist->setUnlimited($res->unlimited);
            $playlist->setCreatedAt(fromParseDate($res->createdAt));
            $playlist->setUpdatedAt(fromParseDate($res->updatedAt));
            $playlist->setACL(fromParseACL($res->ACL));
            return $playlist;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function savePlaylist($playlist) {
        try {

            $parsePlaylist = new parseObject('Playlist');
            is_null($playlist->getActive()) ? $parsePlaylist->active = true : $parsePlaylist->active = $playlist->getActive();
            is_null($playlist->getFromUser()) ? $parsePlaylist->fromUser = null : $parsePlaylist->fromUser = toParsePointer('_User', $playlist->getFromUser());
            is_null($playlist->getName()) ? $parsePlaylist->name = null : $parsePlaylist->name = $playlist->getName();
            is_null($playlist->getSongs()) ? $parsePlaylist->songs = null : $parsePlaylist->songs = toParseRelation('Song', $playlist->getSongs());
            is_null($playlist->getUnlimited()) ? $parsePlaylist->unlimited = false : $parsePlaylist->unlimited = $playlist->getUnlimited();
			$acl = new ParseACL();
			$acl = setPuclicWriteAccess(true);
			$acl = setPuclicReadAccess(true);
            is_null($playlist->getACL()) ? $parsePlaylist->ACL = $acl : $parsePlaylist->ACL = toParseACL($playlist->getACL());
            if ($playlist->getObjectId() == '') {
                $res = $parsePlaylist->save();
                $playlist->setObjectId($res->objectId);
                return $playlist;
            } else {
                $parsePlaylist->update($playlist->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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