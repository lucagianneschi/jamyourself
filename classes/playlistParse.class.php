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

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';

class PlaylistParse {

    private $parseQuery;

    function __construct() {

        $this->parseQuery = new ParseQuery("Playlist");
    }

    public function deletePlaylist($playlist) {
        if ($playlist) {
            $playlist->setActive(false);
            try {
                //cancellazione delle immagini dell'album
                if ($playlist->getSongs() != null && count($playlist->getSongs()) > 0) {
                    $parseSong = new SongParse();
                    $parseSong->whereRelatedTo("songs", "Playlist", $playlist->getObjectId());
                    $songs = $parseSong->getSongs();
                    if ($songs != null && count($songs) > 0) {
                        foreach ($songs as $song) {
                            $parseSong = new SongParse(); //necessario per resettare la query
                            $parseSong->delete($song);
                        }
                    }
                }


                return $this->save($playlist);
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        }
        else
            return false;
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
        try {
            $playslists = array();
            $res = $this->parseQuery->find();
            foreach ($res->results as $obj) {
                $playslist = $this->parseToPlaylist($obj);
                $playslists[$playslist->getObjectId()] = $playslist;
            }
            return $playslists;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
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
            $playlist->setCreatedAt(fromParseDate($parseObj->createdA));
            $playlist->setUpdatedAt(fromParseDate($parseObj->updatedAt));
            $playlist->setACL(fromParseACL($parseObj->ACL));

            return $playlist;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function savePlaylist(Playlist $playlist) {
        try {

            $parseObj = new parseObject("Playlist");

            $parseObj->active = $playlist->getActive();
            $parseObj->fromUser = toParsePointer("_User", $playlist->getFromUser());
            $parseObj->name = $playlist->getName();
            $parseObj->songs = toParseRelation("Song", $playlist->getSongs());
            $parseObj->unlimited = $playlist->getUnlimited();
            $parseObj->ACL = toParseACL($playlist->getACL());

            if ($playlist->getObjectId() == null) {

                $res = $parseObj->save();
                $playlist->setObjectId($res->objectId);
                $playlist->setCreatedAt(fromParseDate($ret->createdAt));
                $playlist->setUpdatedAt(fromParseDate($ret->createdAt));
            } else {

                $parseObj->update($playlist->getObjectId());
                $playlist->setUpdatedAt(fromParseDate($ret->updatedAt));
            }

            return $playlist;
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