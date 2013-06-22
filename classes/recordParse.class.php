<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Record Class
 *  \details   Classe dedicata ad un album di brani musicali, pu� essere istanziata solo da Jammer
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:record">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:record">API</a>
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

require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'song.class.php';

class RecordParse {

    private $parseQuery;

    function __construct() {
        $this->parseQuery = new ParseQuery("Record");
    }

    function saveRecord(Record $record) {
        $parseObj = new parseObject("Record");

        $parseObj->active = $record->getActive();
        $parseObj->buyLink = $record->getBuyLink();
        $parseObj->commentators = toParseRelation("_User", $record->getCommentators());
        $parseObj->comments = toParseRelation("Comment", $record->getComments());
        $parseObj->counter = $record->getCounter();
        $parseObj->cover = $record->getCover();
        $parseObj->coverFile = toParseFile($record->getCoverFile());
        $parseObj->description = $record->getDescription();
        $parseObj->duration = $record->getDuration();
        $parseObj->featuring = toParseRelation("_User", $record->getFeaturing());
        $parseObj->fromUser = toParsePointer("_User", $record->getFromUser());
        $parseObj->genre = $record->getGenre();
        $parseObj->label = $record->getLabel();
        $parseObj->location = toParseGeoPoint($record->getLocation());
        $parseObj->loveCounter = $record->getLoveCounter();
        $parseObj->lovers = toParseRelation("_User", $record->getLovers());
        $parseObj->thumbnailCover = $record->getThumbnailCover();
        $parseObj->title = $record->getTitle();
        $parseObj->tracklist = toParseRelation("Song", $record->getTracklist());
        $parseObj->year = $record->getYear();
        $parseObj->ACL = toParseACL($record->getACL());

        if ($record->getObjectId() != null) {
            try {
                $result = $parseObj->update($record->getObjectId());
                $record->setObjectId($result->objectId);
                $record->setCreatedAt(fromParseDate($result->createdAt));
                $record->setUpdatedAt(fromParseDate($result->createdAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            //caso save
            try {
                $result = $parseObj->save();
                $record->setUpdatedAt(fromParseDate($result->updatedAt));
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        }
        return $record;
    }

    function deleteAlbum($album) {
        if ($album != null) {
            $album->setActive(false);
            try {
                //cancellazione delle immagini dell'album
                if ($album->getImages() != null && count($album->getImages()) > 0) {
                    $parseImage = new ImageParse();
                    $parseImage->whereRelatedTo("images", "Album", $album->getObjectId());
                    $images = $parseImage->getImages();
                    if ($images != null && count($images) > 0) {
                        foreach ($images as $image) {
                            $parseImage = new ImageParse(); //necessario per resettare la query
                            $parseImage->delete($image);
                        }
                    }
                }
                return $this->save($album);
            } catch (Exception $exception) {
                return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
            }
        }
        else
            return false;
    }

    function getRecord($objectId) {
        try {
            $query = new parseObject("Record");
            $result = $query->get($objectId);
            return $this->parseToRecord($result);
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getRecords() {
        $records = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $records = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $record = $this->parseToRecord($obj);
                        $records[$record->getObjectId()] = $record;
                    }
                }
            }
            return $records;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    function parseToRecord(stdClass $parseObj) {

        if (!$parseObj != null || !isset($parseObj->objectId))
            return null;

        $record = new Record();

        try {
            $record->setObjectId($parseObj->objectId);
            $record->setActive($parseObj->active);
            $record->setBuyLink($parseObj->buyLink);
            $record->setCommentators(fromParseRelation("Record", "commentators", $parseObj->objectId, "_User"));
            $record->setComments(fromParseRelation("Record", "comments", $parseObj->objectId, "Comment"));
            $record->setCounter($parseObj->counter);
            $record->setCover($parseObj->cover);
            $record->setCoverFile(fromParseFile($parseObj->coverFile));
            $record->setDescription($parseObj->description);
            $record->setDuration($parseObj->duration);
            $record->setFeaturing(fromParseRelation("Record", "featuring", $parseObj->objectId, "_User"));
            $record->setFromUser(fromParsePointer($parseObj->fromUser));
            $record->setGenre($parseObj->genre);
            $record->setLabel($parseObj->label);
            $record->setLocation(fromParseGeoPoint($parseObj->location));
            $record->setLoveCounter($parseObj->loveCounter);
            $record->setLovers(fromParseRelation("Record", "lovers", $parseObj->objectId, "_User"));
            $record->setThumbnailCover($parseObj->thumbnailCover);
            $record->setTitle($parseObj->title);
            $record->setTracklist(fromParseRelation("Record", "tracklist", $parseObj->objectId, "Song"));
            $record->setYear($parseObj->year);
            $record->setCreatedAt(fromParseDate($parseObj->createdAt));
            $record->setUpdatedAt(fromParseDate($parseObj->updatedAt));
            $record->setACL(fromParseACL($parseObj->ACL));
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }

        return $record;
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