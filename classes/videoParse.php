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
        $parseQuery = new parseQuery('_User');
		$parseQuery->whereRelatedTo('commentators', 'Video', $res->objectId);
		$test = $parseQuery->find();
		$userRelatedTo = array();
		foreach ($test->results as $user) {
			$userRelatedTo[] = $user->objectId;
		}
		$video->setCommentators($userRelatedTo);
		
		$videoRelatedTo = $this->getRelatedTo('comments', 'Video', $res->objectId);
		$parseQuery = new parseQuery('Comment');
		$parseQuery->whereRelatedTo('comments', 'Video', $res->objectId);
		$test = $parseQuery->find();
		$videoRelatedTo = array();
		foreach ($test->results as $comment) {
			$videoRelatedTo[] = $comment->objectId;
		}
		$video->setComments($videoRelatedTo);
        //integer counter
        if (isset($parseObj->counter))
            $video->setCounter($parseObj->counter);
        //string description
        if (isset($parseObj->description))
            $video->setDescription($parseObj->description);
        //integer duration
        if (isset($parseObj->duration))
            $video->setDuration($parseObj->duration);
        //array di puntatori ad User 
		$parseQuery = new parseQuery('_User');
		$parseQuery->whereRelatedTo('featuring', 'Video', $res->objectId);
		$test = $parseQuery->find();
		$userRelatedTo = array();
		foreach ($test->results as $user) {
			$userRelatedTo[] = $user->objectId;
		}
		$video->setFeaturing($userRelatedTo);
		if ($res->fromUser != null) $video->setFromUser($res->fromUser);
        //integer counter
        if (isset($parseObj->loveCounter))
            $video->setLoveCounter($parseObj->loveCounter);
        //array di puntatori ad User 
        $parseQuery = new parseQuery('_User');
		$parseQuery->whereRelatedTo('lovers', 'Video', $res->objectId);
		$test = $parseQuery->find();
		$loversRelatedTo = array();
		foreach ($test->results as $user) {
			$loversRelatedTo[] = $user->objectId;
		}
		$video->setLovers($loversRelatedTo);
        //array di stringhe tags
        if (isset($parseObj->tags))
            $video->setTags($parseObj->tags);
        //string title
        if (isset($parseObj->title))
            $video->setTitle($parseObj->title);
        //string thumbnail
        if (isset($parseObj->thumbnail))
            $video->setThumbnail($parseObj->thumbnail);
        //string URL
        if (isset($parseObj->URL))
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
			$parseObject = new parseObject('Video');
			if ($video->getObjectId() == '') {
				$video->getActive() == null ? $parseObject->active = null : $parseObject->active = $video->getActive();
				$video->getAuthor() == null ? $parseObject->author = null : $parseObject->author = $video->getAuthor();
				$video->getCommentators() == null ? $parseObject->commentators = null : $parseObject->commentators = $video->getCommentators();
				$video->getComments() == null ? $parseObject->comments = null : $parseObject->comments = $video->getComments();
				$video->getCounter() == null ? $parseObject->counter = null : $parseObject->counter = $video->getCounter();
				$video->getDescription() == null ? $parseObject->description = null : $parseObject->description = $video->getDescription();
				$video->getDuration() == null ? $parseObject->duration = null : $parseObject->duration = $video->getDuration();
				$video->getFeaturing() == null ? $parseObject->featuring = null : $parseObject->featuring = $video->getFeaturing();
				$video->getFromUser() == null ? $parseObject->fromUser = null : $parseObject->fromUser = $video->getFromUser();
				$video->getLoveCounter() == null ? $parseObject->loveCounter = null : $parseObject->loveCounter = $video->getLoveCounter();
				$video->getLovers() == null ? $parseObject->lovers = null : $parseObject->lovers = $video->getLovers();
				$video->getTags() == null ? $parseObject->tags = null : $parseObject->tags = $video->getTags();
				$video->getThumbnail() == null ? $parseObject->thumbnail = null : $parseObject->thumbnail = $video->getThumbnail();
				$video->getTitle() == null ? $parseObject->title = null : $parseObject->title = $video->getTitle();
				$video->getURL() == null ? $parseObject->URL = null : $parseObject->URK = $video->getURL();
				$video->getACL() == null ? $parseObject->ACL = null : $parseObject->ACL = $video->getACL()->acl;
				$res = $parseObject->save();
				return $res->objectId;
			} else {
				if ($video->getActive() != null) $parseObject->active = $video->getActive();
				if ($video->getAuthor() != null) $parseObject->author = $video->getAuthor();
				if ($video->getCommentators() != null) $parseObject->commentators = $video->getCommentators();
				if ($video->getComments() != null) $parseObject->comments = $video->getComments();
				if ($video->getCounter() != null) $parseObject->counter = $video->getCounter();
				if ($video->getDescription() != null) $parseObject->description = $video->getDescription();
				if ($video->getDuration() != null) $parseObject->duration = $video->getDuration();
				if ($video->getFeaturing() != null) $parseObject->featuring = $video->getFeaturing();
				if ($video->getFromUser() != null) $parseObject->fromUser = $video->getFromUser();
				if ($video->getLoveCounter() != null) $parseObject->loveCounter = $video->getLoveCounter();
				if ($video->getLovers() != null) $parseObject->lovers = $video->getLovers();
				if ($video->getTags() != null) $parseObject->tags = $video->getTags();
				if ($video->getThumbnail() != null) $parseObject->thumbnail = $video->getThumbnail();
				if ($video->getTitle() != null) $parseObject->title = $video->getTitle();
				if ($video->getACL() != null) $parseObject->ACL = $video->getACL()->acl;
				$parseObject->update($video->getObjectId());
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