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
define('CLASS_DIR', './classes/');
include_once CLASS_DIR . 'userParse.class.php';

class RecordParse {

    private $parseQuery;

    function __construct() {
        $this->parseQuery = new ParseQuery("Record");
    }

    function saveRecord(Record $record) {
        $parseObj = new parseObject("Record");

        $parseObj->active = $record->getActive();
        $parseObj->buyLink = $record->getBuyLink();
        $parseObj->commentators = toParseRelation($record->getCommentators());
        $parseObj->comments = toParseRelation($record->getComments());
        $parseObj->counter = $record->getCounter();
        $parseObj->cover = $record->getCover();
//        $parseObj->coverFile = $record->getCoverFile();
        $parseObj->description = $record->getDescription();
        $parseObj->duration = $record->getDuration();
        $parseObj->featuring = toParseRelation($record->getFeaturing());
        $parseObj->fromUser = toParsePointer($record->getFromUser());
        $parseObj->genre = $record->getGenre();
        $parseObj->label = $record->getLabel();
        $parseObj->location = toParseGeoPoint($record->getLocation());
        $parseObj->loveCounter = $record->getLoveCounter();
        $parseObj->lovers = toParseRelation($record->getLovers());
        $parseObj->thumbnailCover = $record->getThumbnailCover();
        $parseObj->title = $record->getTitle();
        $parseObj->tracklist = $record->getTracklist();
        $parseObj->year = $record->getYear();
        $parseObj->ACL = toParseACL($record->getACL());

        if (isset($record->getObjectId()) && $record->getObjectId() != null) {
            try {
                $result = $parseObj->update($record->getObjectId());
                $record->setObjectId($result->objectId);
                $record->setCreatedAt(new DateTime($result->createdAt));
                $record->setUpdatedAt(new DateTime($result->createdAt));
            } catch (ParseLibraryException $e) {
                return false;
            }
        } else {
            //caso save
            try {
                $result = $parseObj->save();
                $record->setUpdatedAt($result->updatedAt);
            } catch (ParseLibraryException $e) {
                return false;
            }
        }
        return $record;
    }
    
    function deleteRecord(Record $record) {
        if ($record) {
            $record->setActive(false);
            if ($this->save($record)) {
                return true;
            } else {
                return false;
            }
        }
        else
            return false;
    }

    function getRecord($objectId) {
        $record = null;
        $this->parseQuery->where('objectId', $objectId);
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {
                //recupero l'utente
                $record = $this->parseToRecord($ret);
            }
        }
        return $record;
    }

    function parseToRecord(stdClass $parseObj) {
        $record = new Record();

        //specifiche
        if (isset($parseObj->objectId))
            $record->setObjectId($parseObj->objectId);
        else return null;
        
        if (isset($parseObj->active))
            $record->setActive($parseObj->active);
        
        if (isset($parseObj->buyLink))
            $record->setBuyLink($parseObj->buyLink);
        
        if (isset($parseObj->commentators)){
            $parse = new UserParse();
            $parse->whereRelatedTo("commentators", "Record", $parseObj->objectId);
            $record->setCommentators($parse->getUsers());
        }
        
        if (isset($parseObj->comments)){
            $record->setComments($parseObj->comments);
        }
        
        if (isset($parseObj->counter))
            $record->setCounter($parseObj->counter);
        
        if (isset($parseObj->cover))
            $record->setCover($parseObj->cover);
        
        if (isset($parseObj->coverFile))
            $record->setCoverFile($parseObj->coverFile);
        if (isset($parseObj->description))
            $record->setDescription($parseObj->description);
        
        if (isset($parseObj->duration))
            $record->setDuration($parseObj->duration);
        
        if (isset($parseObj->featuring))
            $record->setFeaturing($parseObj->featuring);
        
        if (isset($parseObj->fromUser)){
            $parse = new UserParse();
            $parse->whereRelatedTo("fromUser", "Record", $parseObj->objectId);
            $record->setCommentators($parse->getUsers());
        }
        
        if (isset($parseObj->genre))
            $record->setGenre($parseObj->genre);
        
        if (isset($parseObj->label))
            $record->setLabel($parseObj->label);
        
        if (isset($parseObj->location))
            $record->setLocation(new parseGeoPoint ($parseObj->location->latitude, $parseObj->location->longitude));
        
        if (isset($parseObj->loveCounter))
            $record->setLoveCounter($parseObj->loveCounter);
        
        if (isset($parseObj->lovers)){
            $parse = new UserParse();
            $parse->whereRelatedTo("lovers", "Record", $parseObj->objectId);
            $record->setCommentators($parse->getUsers());
        }
        
        if (isset($parseObj->thumbnailCover))
            $record->setThumbnailCover($parseObj->thumbnailCover);
        
        if (isset($parseObj->title))
            $record->setTitle($parseObj->title);
        
        if (isset($parseObj->tracklist))
            $record->setTracklist($parseObj->tracklist);
        
        if (isset($parseObj->year))
            $record->setYear($parseObj->year);
        
        if (isset($parseObj->createdAt))
            $record->setCreatedAt(new DateTime($parseObj->createdAt));
        if (isset($parseObj->updatedAt))
            $record->setUpdatedAt(new DateTime($parseObj->updatedAt));
        if (isset($parseObj->ACL))
            $record->setACL($parseObj->ACL);

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