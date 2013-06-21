<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Video Class
 *  \details   Classe che contiene i video presi da Vimeo e Youtube e segnalati dagli utenti 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:video">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php??id=documentazione:api:video">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

class VideoParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Video");
    }

    public function deleteVideo($objectId) {
        try {
            $parseObject = new parseObject('Video');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getVideo($objectId) {
        try {
            $parseObject = new parseObject('Video');
            $res = $parseObject->get($objectId);
            $video = $this->parseToVideo($res);
            return $video;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getVideos() {
        try {
            $videos = array();
            $res = $this->parseQuery->find();
            foreach ($res->results as $obj) {
                $video = $this->parseToVideo($obj);
                $videos[$video->getObjectId()] = $video;
            }
            return $videos;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
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

    function parseToVideo(stdClass $parseObj) {
        try {
            $video = new Video();
            $video->setObjectId($parseObj->objectId);
            $video->setActive($parseObj->active);
            $video->setAuthor($parseObj->author);
            $commentators = fromParseRelation('Video', 'commentators', $parseObj->objectId, '_User');
            $video->setCommentators($commentators);
            $comments = fromParseRelation('Video', 'comments', $parseObj->objectId, 'Comment');
            $video->setComments($comments);
            $video->setCounter($parseObj->counter);
            $video->setDescription($parseObj->description);
            $video->setDuration($parseObj->duration);
            $featuring = fromParseRelation('Video', 'featuring', $parseObj->objectId, '_User');
            $video->setFeaturing($featuring);
            $fromUser = fromParsePointer($parseObj->fromUser);
            $video->setFromUser($fromUser);
            $video->setLoveCounter($parseObj->loveCounter);
            $lovers = fromParseRelation('Video', 'lovers', $parseObj->objectId, '_User');
            $video->setLovers($lovers);
            $video->setTags($parseObj->tags);
            $video->setTitle($parseObj->title);
            $video->setThumbnail($parseObj->thumbnail);
            $video->setURL($parseObj->URL);
            $video->setCreatedAt(new DateTime($parseObj->createdAt));
            $video->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $video->setACL(fromParseACL($parseObj->ACL));
            return $video;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function saveVideo(Video $video) {
        try {
            $parseObj = new parseObject('Video');
            is_null($video->getActive()) ? $parseObj->active = null : $parseObj->active = $video->getActive();
            is_null($video->getAuthor()) ? $parseObj->author = null : $parseObj->author = $video->getAuthor();
            is_null($video->getCommentators()) ? $parseObj->commentators = null : $parseObj->commentators = toParseRelation('_User', $video->getCommentators());
            is_null($video->getComments()) ? $parseObj->comments = null : $parseObj->comments = toParseRelation('Comment', $video->getComments());
            is_null($video->getCounter())  ? $parseObj->counter = null : $parseObj->counter = $video->getCounter();
            is_null($video->getDescription()) ? $parseObj->description = null : $parseObj->description = $video->getDescription();
            is_null($video->getDuration())  ? $parseObj->duration = null : $parseObj->duration = $video->getDuration();
            is_null($video->getFeaturing()) ? $parseObj->featuring = null : $parseObj->featuring = toParseRelation('_User', $video->getFeaturing());
            is_null($video->getFromUser()) ? $parseObj->fromUser = null : $parseObj->fromUser = toParsePointer('_User', $video->getFromUser());
            is_null($video->getLoveCounter()) ? $parseObj->loveCounter = null : $parseObj->loveCounter = $video->getLoveCounter();
            is_null($video->getLovers()) ? $parseObj->lovers = null : $parseObj->lovers = toParseRelation('_User', $video->getLovers());
            is_null($video->getTags()) ? $parseObj->tags = null : $parseObj->tags = $video->getTags();
            is_null($video->getThumbnail()) ? $parseObj->thumbnail = null : $parseObj->thumbnail = $video->getThumbnail();
            is_null($video->getTitle()) ? $parseObj->title = null : $parseObj->title = $video->getTitle();
            is_null($video->getURL()) ? $parseObj->URL = null : $parseObj->URL = $video->getURL();
            $acl = new ParseACL;
            $acl->setPublicRead(true);
            $acl->setPublicWrite(true);
            $video->setACL($acl);
            if ($video->getObjectId() == '') {
                $res = $parseObj->save();
                $video->setObjectId($res->objectId);
                return $video;
            } else {
                $parseObj->update($video->getObjectId());
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