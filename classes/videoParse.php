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
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

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
        $videos = array();
        $res = $this->parseQuery->find();
        foreach ($res->results as $obj) {
            $video = $this->parseToVideo($obj);
            $videos[$video->getObjectId()] = $video;
        }
        return $videos;
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getRelatedTo($field, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($field, $className, $objectId);
        $rel = $this->parseQuery->find();
        $relVideo = array();
        foreach ($rel->results as $video) {
            $relVideo[] = $video->objectId;
        }
        return $relVideo;
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

    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    function parseToVideo(stdClass $parseObj) {
        $video = new Video();
        //recupero objectId
        if (isset($parseObj->objectId))
            $video->setObjectId($parseObj->objectId);
        //boolean active		
        if (isset($parseObj->active))
            $video->setActive($parseObj->active);
        //string author
        if (isset($parseObj->author))
            $video->setAuthor($parseObj->author);
        $parseQueryCommentators = new parseQuery('_User');
        $parseQueryCommentators->whereRelatedTo('commentators', 'Video', $parseObj->objectId);
        $testCommentators = $parseQueryCommentators->find();
        $commentators = array();
        foreach ($testCommentators->results as $user) {
            $commentators[] = $user->objectId;
        }
        $video->setCommentators($commentators);

        $videoRelatedTo = $this->getRelatedTo('comments', 'Video', $parseObj->objectId);
        $parseQueryComments = new parseQuery('Comment');
        $parseQueryComments->whereRelatedTo('comments', 'Video', $parseObj->objectId);
        $testComments = $parseQueryComments->find();
        $comments = array();
        foreach ($testComments->results as $comment) {
            $comments[] = $comment->objectId;
        }
        $video->setComments($comments);

        $video->setCounter($parseObj->counter);
        $video->setDescription($parseObj->description);
        $video->setDuration($parseObj->duration);
        //array di puntatori ad User 
        $parseQueryFeaturing = new parseQuery('_User');
        $parseQueryFeaturing->whereRelatedTo('featuring', 'Video', $parseObj->objectId);
        $testFeaturing = $parseQueryFeaturing->find();
        $featuring = array();
        foreach ($testFeaturing->results as $user) {
            $featuring[] = $user->objectId;
        }
        $video->setFeaturing($featuring);
        if ($parseObj->fromUser != null)
            $video->setFromUser($parseObj->fromUser);
        $video->setLoveCounter($parseObj->loveCounter);
        //array di puntatori ad User 
        $parseQueryLovers = new parseQuery('_User');
        $parseQueryLovers->whereRelatedTo('lovers', 'Video', $parseObj->objectId);
        $testLovers = $parseQueryLovers->find();
        $lovers = array();
        foreach ($testLovers->results as $user) {
            $lovers[] = $user->objectId;
        }
        $video->setLovers($lovers);
        $video->setTags($parseObj->tags);
        $video->setTitle($parseObj->title);
        $video->setThumbnail($parseObj->thumbnail);
        $video->setURL($parseObj->URL);
        //creo la data di tipo DateTime per createdAt e updatedAt
        if (isset($parseObj->createdAt))
            $video->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $video->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $video->setACL($acl);
        return $video;
    }

    public function saveVideo(Video $video) {
        try {
            $parseObj = new parseObject('Video');
            if ($video->getObjectId() == '') {
                $video->getActive() === null ? $parseObj->active = null : $parseObj->active = $video->getActive();
                $video->getAuthor() == null ? $parseObj->author = null : $parseObj->author = $video->getAuthor();
                $video->getCommentators() == null ? $parseObj->commentators = null : $parseObj->commentators = $video->getCommentators();
                $video->getComments() == null ? $parseObj->comments = null : $parseObj->comments = $video->getComments();
                $video->getCounter() == null ? $parseObj->counter = null : $parseObj->counter = $video->getCounter();
                $video->getDescription() == null ? $parseObj->description = null : $parseObj->description = $video->getDescription();
                $video->getDuration() == null ? $parseObj->duration = null : $parseObj->duration = $video->getDuration();
                $video->getFeaturing() == null ? $parseObj->featuring = null : $parseObj->featuring = $video->getFeaturing();
                $video->getFromUser() == null ? $parseObj->fromUser = null : $parseObj->fromUser = $video->getFromUser();
                $video->getLoveCounter() == null ? $parseObj->loveCounter = null : $parseObj->loveCounter = $video->getLoveCounter();
                $video->getLovers() == null ? $parseObj->lovers = null : $parseObj->lovers = $video->getLovers();
                $video->getTags() == null ? $parseObj->tags = null : $parseObj->tags = $video->getTags();
                $video->getThumbnail() == null ? $parseObj->thumbnail = null : $parseObj->thumbnail = $video->getThumbnail();
                $video->getTitle() == null ? $parseObj->title = null : $parseObj->title = $video->getTitle();
                $video->getURL() == null ? $parseObj->URL = null : $parseObj->URL = $video->getURL();
                $video->getACL() == null ? $parseObj->ACL = null : $parseObj->ACL = $video->getACL()->acl;
                $parseObj = $parseObj->save();
                return $parseObj->objectId;
            } else {
                if ($video->getActive() != null)
                    $parseObj->active = $video->getActive();
                if ($video->getAuthor() != null)
                    $parseObj->author = $video->getAuthor();
                if ($video->getCommentators() != null)
                    $parseObj->commentators = $video->getCommentators();
                if ($video->getComments() != null)
                    $parseObj->comments = $video->getComments();
                if ($video->getCounter() != null)
                    $parseObj->counter = $video->getCounter();
                if ($video->getDescription() != null)
                    $parseObj->description = $video->getDescription();
                if ($video->getDuration() != null)
                    $parseObj->duration = $video->getDuration();
                if ($video->getFeaturing() != null)
                    $parseObj->featuring = $video->getFeaturing();
                if ($video->getFromUser() != null)
                    $parseObj->fromUser = $video->getFromUser();
                if ($video->getLoveCounter() != null)
                    $parseObj->loveCounter = $video->getLoveCounter();
                if ($video->getLovers() != null)
                    $parseObj->lovers = $video->getLovers();
                if ($video->getTags() != null)
                    $parseObj->tags = $video->getTags();
                if ($video->getThumbnail() != null)
                    $parseObj->thumbnail = $video->getThumbnail();
                if ($video->getTitle() != null)
                    $parseObj->title = $video->getTitle();
                if ($video->getACL() != null)
                    $parseObj->ACL = $video->getACL()->acl;
                $parseObj->update($video->getObjectId());
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