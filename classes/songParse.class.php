<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Song Class
 *  \details   Classe dedicata al singolo brano, pu� essere istanziata solo da Jammer
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:song">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:song">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';
require_once CLASSES_DIR . 'song.class.php';


class SongParse {

    private $parseQuery;

    function __construct() {
        $this->parseQuery = new parseQuery("Song");
    }

    function saveSong(Song $song) {

        //recupero le info dell'oggetto
        $parseObj = new parseObject("Song");

        $parseObj->active = $song->getActive();
        $parseObj->commentators = toParseRelation($song->getCommentators());
        $parseObj->comments = toParseRelation($song->getComments());
        $parseObj->counter = $song->getCounter();
        $parseObj->duration = $song->getDuration();
        $parseObj->featuring = toParseRelation($song->getFeaturing());
        $parseObj->filePath = $song->getFilePath();
        $parseObj->fromUser = toParsePointer($song->getFromUser());
        $parseObj->genre = $song->getGenre();
        $parseObj->location = toParseGeoPoint($song->getLocation());
        $parseObj->loveCounter = $song->getLoveCounter();
        $parseObj->lovers = toParseRelation($song->getLovers());
        $parseObj->record = toParsePointer($song->getRecord());
        $parseObj->title = $song->getTitle();
        $parseObj->ACL = toParseACL($song->getACL());

        if (( $song->getObjectId()) != null) {
            //update
            try {
                //update
                $result = $parseObj->update($song->getObjectId());

                //aggiorno l'update
                $song->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            try {
                //salvo
                $result = $parseObj->save();

                //aggiorno i dati per la creazione
                $song->setObjectId($result->objectId);
                $song->setCreatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
                $song->setUpdatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        }
        //restituisco song aggiornato
        return $song;
    }

    public function deleteSong($objectId) {
        try {
            $parseObject = new parseObject('Song');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    function getSong($objectId) {
        try {
            $query = new parseObject("Song");
            $result = $query->get($objectId);
            return $this->parseToSong($result);
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getSongs() {
        $songs = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $songs = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $song = $this->parseToRecord($obj);
                        $songs[$song->getObjectId()] = $song;
                    }
                }
            }
            return $songs;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    function parseToSong(stdClass $parseObj) {

        if ($parseObj == null || !isset($parseObj->objectId))
            return null;

        $song = new Song();
        //recupero objectId
        try {
            $song->setObjectId($parseObj->objectId);
            $song->setActive($parseObj->active);
            $song->setCommentators(fromParseRelation("Song", "commentators", $fromObjectId, "_User"));
            $song->setComments(fromParseRelation("Song", "comments", $parseObj->objectId, "Comment"));
            $song->setCounter($parseObj->counter);
            $song->setDuration($parseObj->duration);
            $song->setFeaturing(fromParseRelation("Song", "featuring", $parseObj->objectId, "_User"));
            $song->setFilePath($parseObj->filePath);
            $song->setFromUser(fromParsePointer($parseObj->fromUser));
            $song->setGenre($parseObj->genre);
            $song->setLocation(fromParseGeoPoint($parseObj->location));
            $song->setLoveCounter($parseObj->loveCounter);
            $song->setLovers(fromParseRelation("Song", "lovers", $parseObj->objectId, "_User"));
            $song->setRecord(fromParsePointer($parseObj->record));
            $song->setTitle($parseObj->title);
            $song->setCreatedAt(fromParseDate($parseObj->createdAt));
            $song->setUpdatedAt(fromParseDate($parseObj->updatedAt));
            $song->setACL(fromParseACL($parseObj->ACL));
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
        return $song;
    }

    public function getCount() {
        $this->parseQuery->getCount();
    }

    public function setLimit($int) {
        $this->parseQuery->setLimit($int);
    }

    public function setSkip($int) {
        $this->parseQuery->setSkip($int);
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