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
require_once CLASSES_DIR . 'video.class.php';

class VideoParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Video");
    }

    public function deleteVideo($objectId) {
        try {
            $parseVideo = new parseObject('Video');
            $parseVideo->active = false;
            $parseVideo->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getVideo($objectId) {
        try {
            $parseVideo = new parseObject('Video');
            $res = $parseVideo->get($objectId);
            $video = $this->parseToVideo($res);
            return $video;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getVideos() {
        $videos = null;
        try {
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $videos = array();
                foreach ($res->results as $obj) {
                    if ($obj) {
                        $video = $this->parseToVideo($obj);
                        $videos[$video->getObjectId] = $video;
                    }
                }
            }
            return $videos;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

	/**
	 * \fn		void orderBy($field)
	 * \brief	Specifies which field need to be ordered of requested Error
	 * \param	$field	the field on which to sort
	 */
	public function orderBy($field) {
		$this->parseQuery->orderBy($field);
	}	
	
	/**
	 * \fn		void orderByAscending($field)
	 * \brief	Specifies which field need to be ordered ascending of requested Error
	 * \param	$field	the field on which to sort ascending
	 */
	public function orderByAscending($field) {
		$this->parseQuery->orderByAscending($field);
	}
	
	/**
	 * \fn		void orderByDescending($field)
	 * \brief	Specifies which field need to be ordered descending of requested Error
	 * \param	$field	the field on which to sort descending
	 */
	public function orderByDescending($field) {
		$this->parseQuery->orderByDescending($field);
	}

    function parseToVideo($res) {
        if (is_null($res))
		return throwError(new Exception('parseToVideo parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $video = new Video();
            $video->setObjectId($res->objectId);
            $video->setActive($res->active);
            $video->setAuthor($res->author);
            $commentators = fromParseRelation('Video', 'commentators', $res->objectId, '_User');
            $video->setCommentators($commentators);
            $comments = fromParseRelation('Video', 'comments', $res->objectId, 'Comment');
            $video->setComments($comments);
            $video->setCounter($res->counter);
            $video->setDescription($res->description);
            $video->setDuration($res->duration);
            $featuring = fromParseRelation('Video', 'featuring', $res->objectId, '_User');
            $video->setFeaturing($featuring);
            $fromUser = fromParsePointer($res->fromUser);
            $video->setFromUser($fromUser);
            $video->setLoveCounter($res->loveCounter);
            $lovers = fromParseRelation('Video', 'lovers', $res->objectId, '_User');
            $video->setLovers($lovers);
            $video->setTags($res->tags);
            $video->setTitle($res->title);
            $video->setThumbnail($res->thumbnail);
            $video->setURL($res->URL);
            $video->setCreatedAt(new DateTime($res->createdAt));
            $video->setUpdatedAt(new DateTime($res->updatedAt));
            $video->setACL(fromParseACL($res->ACL));
            return $video;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function saveVideo($video) {
        try {
            $parseVideo = new parseObject('Video');
            is_null($video->getActive()) ? $parseVideo->active = true : $parseVideo->active = $video->getActive();
            is_null($video->getAuthor()) ? $parseVideo->author = null : $parseVideo->author = $video->getAuthor();
            is_null($video->getCommentators()) ? $parseVideo->commentators = null : $parseVideo->commentators = toParseRelation('_User', $video->getCommentators());
            is_null($video->getComments()) ? $parseVideo->comments = null : $parseVideo->comments = toParseRelation('Comment', $video->getComments());
            is_null($video->getCounter()) ? $parseVideo->counter = -1			: $parseVideo->counter = $video->getCounter();
            is_null($video->getDescription()) ? $parseVideo->description = null : $parseVideo->description = $video->getDescription();
            is_null($video->getDuration()) ? $parseVideo->duration = 0 : $parseVideo->duration = $video->getDuration();
            is_null($video->getFeaturing()) ? $parseVideo->featuring = null : $parseVideo->featuring = toParseRelation('_User', $video->getFeaturing());
            is_null($video->getFromUser()) ? $parseVideo->fromUser = null : $parseVideo->fromUser = toParsePointer('_User', $video->getFromUser());
            is_null($video->getLoveCounter()) ? $parseVideo->loveCounter = -1 : $parseVideo->loveCounter = $video->getLoveCounter();
            is_null($video->getLovers()) ? $parseVideo->lovers = null : $parseVideo->lovers = toParseRelation('_User', $video->getLovers());
            is_null($video->getTags()) ? $parseVideo->tags = null : $parseVideo->tags = $video->getTags();
            is_null($video->getThumbnail()) ? $parseVideo->thumbnail = null : $parseVideo->thumbnail = $video->getThumbnail();
            is_null($video->getTitle()) ? $parseVideo->title = null : $parseVideo->title = $video->getTitle();
            is_null($video->getURL()) ? $parseVideo->URL = null : $parseVideo->URL = $video->getURL();
			$acl = new ParseACL();
			$acl = setPuclicWriteAccess(true);
			$acl = setPuclicReadAccess(true);
            is_null($video->getACL()) ? $parseVideo->ACL = $acl : $parseVideo->ACL = toParseACL($video->getACL());
            if ($video->getObjectId() == '') {
                $res = $parseVideo->save();
                $video->setObjectId($res->objectId);
                return $video;
            } else {
                $parseVideo->update($video->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

   /**
	 * \fn		void setLimit($limit)
	 * \brief	Sets the maximum number of Error to return
	 * \param	$limit	the maximum number
	 */
	public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}
	
	/**
	 * \fn		void setSkip($skip)
	 * \brief	Sets the number of how many Error(s) must be discarded initially
	 * \param	$skip	the number of Error(s) to skip
	 */
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
	}
	
	/**
	 * \fn		void where($field, $value)
	 * \brief	Sets a condition for which the field $field must value $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function where($field, $value) {
		$this->parseQuery->where($field, $value);
	}
	
	/**
	 * \fn		void whereContainedIn($field, $value)
	 * \brief	Sets a condition for which the field $field must value one or more $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the array which represent the values
	 */
	public function whereContainedIn($field, $values) {
		$this->parseQuery->whereContainedIn($field, $values);
	}
	
	/**
	 * \fn		void whereEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must value $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereEqualTo($field, $value) {
		$this->parseQuery->whereEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereExists($field)
	 * \brief	Sets a condition for which the field $field must be enhanced
	 * \param	$field	the string which represent the field
	 */
	public function whereExists($field) {
		$this->parseQuery->whereExists($field);
	}	
	
	/**
	 * \fn		void whereGreaterThan($field, $value)
	 * \brief	Sets a condition for which the field $field must value more than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereGreaterThan($field, $value) {
		$this->parseQuery->whereGreaterThan($field, $value);
	}
	
	/**
	 * \fn		void whereGreaterThanOrEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must value equal or more than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereGreaterThanOrEqualTo($field, $value) {
		$this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereLessThan($field, $value)
	 * \brief	Sets a condition for which the field $field must value less than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereLessThan($field, $value) {
		$this->parseQuery->whereLessThan($field, $value);
	}
	
	/**
	 * \fn		void whereLessThanOrEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must value equal or less than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereLessThanOrEqualTo($field, $value) {
		$this->parseQuery->whereLessThanOrEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereNotContainedIn($field, $value)
	 * \brief	Sets a condition for which the field $field must not value one or more $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the array which represent the values
	 */
	public function whereNotContainedIn($field, $array) {
		$this->parseQuery->whereNotContainedIn($field, $array);
	}
	
	/**
	 * \fn		void whereNotEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must not value $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereNotEqualTo($field, $value) {
		$this->parseQuery->whereNotEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereNotExists($field)
	 * \brief	Sets a condition for which the field $field must not be enhanced
	 * \param	$field	the string which represent the field
	 */
	public function whereNotExists($field) {
		$this->parseQuery->whereDoesNotExist($field);
	}

	/**
	 * \fn		void wherePointer($field, $className, $objectId)
	 * \brief	Sets a condition for which the field $field must contain a Pointer to the class $className with pointer value $objectId
	 * \param	$field		the string which represent the field
	 * \param	$className	the string which represent the className of the Pointer
	 * \param	$objectId	the string which represent the objectId of the Pointer
	 */
	public function wherePointer($field, $className, $objectId) {
		$this->parseQuery->wherePointer($field, $className, $objectId);
	}
		
	public function whereRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
	}
		
}
?> 