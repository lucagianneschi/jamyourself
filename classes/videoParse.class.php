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

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

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

    public function getVideo($objectId) {
        try {
            $parseObject = new parseObject('Video');
            $res = $parseObject->get($objectId);
            $video = $this->parseToVideo($res);
            return $video;
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
            $commentators = fromParseRelation('commentators', 'Video', $parseObj->objectId, '_User');
            $video->setCommentators($commentators);
            $comments = fromParseRelation('comments', 'Video', $parseObj->objectId, 'Comment');
            $video->setComments($comments);
            $video->setCounter($parseObj->counter);
            $video->setDescription($parseObj->description);
            $video->setDuration($parseObj->duration);
            $featuring = fromParseRelation('featuring', 'Video', $parseObj->objectId, '_User');
            $video->setFeaturing($featuring);
            $fromUser = fromParsePointer('_User', $parseObj->fromUser);
            $video->setFromUser($fromUser);
            $video->setLoveCounter($parseObj->loveCounter);
            $lovers = fromParseRelation('lovers', 'Video', $parseObj->objectId, '_User');
            $video->setLovers($lovers);
            $video->setTags($parseObj->tags);
            $video->setTitle($parseObj->title);
            $video->setThumbnail($parseObj->thumbnail);
            $video->setURL($parseObj->URL);
            if ($parseObj->createdAt)
                $video->setCreatedAt(new DateTime($parseObj->createdAt));
            if ($parseObj->updatedAt)
                $video->setUpdatedAt(new DateTime($parseObj->updatedAt));
            if ($parseObj->ACL)
                $video->setACL($parseObj->ACL);
            return $video;
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

    public function saveVideo(Video $video) {

        $parseObj = new parseObject('Video');
        $video->getActive() === null ? $parseObj->active = null : $parseObj->active = $video->getActive();
        $video->getAuthor() == null ? $parseObj->author = null : $parseObj->author = $video->getAuthor();
        $parseObj->commentators = toParseRelation('_User', $video->getCommentators());
        $parseObj->comments = toParseRelation('Comment', $video->getComments());
        $video->getCounter() == null ? $parseObj->counter = null : $parseObj->counter = $video->getCounter();
        $video->getDescription() == null ? $parseObj->description = null : $parseObj->description = $video->getDescription();
        $video->getDuration() == null ? $parseObj->duration = null : $parseObj->duration = $video->getDuration();
        $parseObj->featuring = toParseRelation('_User', $video->getFeaturing());
        $parseObj->fromUser = toParsePointer('_User', $video->getFromUser());
        $video->getLoveCounter() == null ? $parseObj->loveCounter = null : $parseObj->loveCounter = $video->getLoveCounter();
        $parseObj->lovers = toParseRelation('_User', $video->getLovers());
        $video->getTags() == null ? $parseObj->tags = null : $parseObj->tags = $video->getTags();
        $video->getThumbnail() == null ? $parseObj->thumbnail = null : $parseObj->thumbnail = $video->getThumbnail();
        $video->getTitle() == null ? $parseObj->title = null : $parseObj->title = $video->getTitle();
        $video->getURL() == null ? $parseObj->URL = null : $parseObj->URL = $video->getURL();
        $parseObj->ACL = toParseACL($video->getACL());
        if ($video->getObjectId() != null) {
            try {
                $ret = $parseObj->update($video->getObjectId());
                $video->setUpdatedAt($ret->updatedAt, new DateTimeZone("America/Los_Angeles"));
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
        } else {
            try {
                $ret = $parseObj->save();
                $video->setObjectId($ret->objectId);
                $video->setCreatedAt($parseObj->createdAt);
                $video->setUpdatedAt($parseObj->updatedAt);
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
        return $video;
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