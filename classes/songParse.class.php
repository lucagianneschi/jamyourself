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

require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'record.class.php';

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
            } catch (ParseLibraryException $e) {
                return false;
            }
        } else {
            try {
                //salvo
                $result = $parseObj->save();

                //aggiorno i dati per la creazione
                $song->setObjectId($result->objectId);
                $song->setCreatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
                $song->setUpdatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $e) {
                return false;
            }
        }
        //restituisco song aggiornato
        return $song;
    }

    function deleteSong(Song $song) {
        $song->setActive(false);

        if ($this->save($song))
            return true;
        else
            return false;
    }

    function getSong($songId) {

        $parseSong = new parseObject("Song");

        $res = $parseSong->get($songId);

        $song = $this->parseToSong($res);

        return $song;
    }

    function parseToSong(stdClass $parseObj) {

        $song = new Song();
        //recupero objectId
        if (isset($parseObj->objectId))
            $song->setObjectId($parseObj->objectId);
        else
            return null;

        if (isset($parseObj->active))
            $song->setActive($parseObj->active);
        
        if (isset($parseObj->commentators)) {
            $parse = new UserParse();
            $parse->whereRelatedTo("commentators", "Song", $parseObj->objectId);
            $song->setCommentators($parse->getUsers());
        }
        
        if (isset($parseObj->comments)) {
            $parse = new CommentParse();
            $parse->whereRelatedTo("comments", "Song", $parseObj->objectId);
            $song->setComments($parse->getUsers());
        }
        
        if (isset($parseObj->counter))
            $song->setCounter($parseObj->counter);
        
        if (isset($parseObj->duration))
            $song->setDuration($parseObj->duration);
        
        if (isset($parseObj->featuring)) {
            $parse = new UserParse();
            $parse->whereRelatedTo("featuring", "Song", $parseObj->objectId);
            $song->setFeaturing($parse->getUsers());
        }
        
        if (isset($parseObj->filePath))
            $song->setFilePath($parseObj->filePath);
        
        if (isset($parseObj->fromUser)) {
            $parse = new UserParse();
            $song->setFromUser($parse->getUser($parseObj->fromUser->objectId));
        }
        
        if (isset($parseObj->genre))
            $song->setGenre($parseObj->genre);
        
        if (isset($parseObj->location))
            $song->setLocation(new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude));
        
        if (isset($parseObj->loveCounter))
            $song->setLoveCounter($parseObj->loveCounter);
        
        if (isset($parseObj->lovers)) {
            $parse = new UserParse();
            $parse->whereRelatedTo("lovers", "Song", $parseObj->objectId);
            $song->setLovers($parse->getUsers());
        }
        
        if (isset($parseObj->record)) {
            $parse = new RecordParse();
            $parse->whereRelatedTo("record", "Song", $parseObj->objectId);
            $song->setRecord($parse->getUsers());
        }
        
        if (isset($parseObj->title))
            $song->setTitle($parseObj->title);
        
        if (isset($parseObj->createdAt))
            $song->setCreatedAt(new DateTime($parseObj->createdAt));
        
        if (isset($parseObj->updatedAt))
            $song->setUpdatedAt(new DateTime($parseObj->updatedAt));
        
        if (isset($parseObj->ACL))
            $song->setACL($parseObj->ACL);

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