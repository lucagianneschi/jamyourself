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

class VideoParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Video");
    }

    public function getVideo() {
        $video = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {
                //recupero l'utente
                $video = $this->parseToVideo($ret);
            }
        }
        return $video;
    }

    public function getVideos() {
        $videos = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $videos = array();
            foreach (($result->results) as $video) {
                $videos [] = $this->parseToVideo($video);
            }
        }
        return $videos;
    }

    /**
     * Salva un oggetto Video
     * 
     * @param Video $video
     * @return boolean|Video
     */
    public function saveVideo(Video $video) {

        $parse = new parseObject("Video");
        $parse->active = $video->getActive();
        $parse->author = $video->getAuthor();
        if ($video->getCommentators() != null && count($video->getCommentators()) > 0) {
            $arrayPointer = array();
            foreach ($video->getCommentators() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->commentators = $user->dataType("relation", $arrayPointer);
        } else {
            $parse->commentators = null;
        }
        if ($video->getComments() != null && count($video->getComments()) > 0) {
            $arrayPointer = array();
            foreach ($video->getComments() as $comment) {
                $pointer = $parse->dataType("pointer", array("Comment"), $comment->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->comments = $comment->dataType("relation", $arrayPointer);
        } else {
            $parse->comments = null;
        }
        $parse->counter = $video->getCounter();
        $parse->description = $video->getDescription();
        $parse->duration = $video->getDuration();
        if ($video->getFeaturing() != null && count($video->getFeaturing()) > 0) {
            $arrayPointer = array();
            foreach ($video->getFeaturing() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->featuring = $user->dataType("relation", $arrayPointer);
        } else {
            $parse->featuring = null;
        }
        if (($fromUser = $parse->getFromUser()) != null) {
            $pointerParse = $parse->dataType("pointer", array("_User"), $fromUser->getObjectId());
            $parse->fromUser = $pointerParse;
        } else {
            $parse->fromUser = null;
        }
        $parse->loveCounter = $video->getLoveCounter();
        if ($video->getLovers() != null && count($video->getLovers()) > 0) {
            $arrayPointer = array();
            foreach ($video->getLovers() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
            $parse->lovers = $user->dataType("relation", $arrayPointer);
        } else {
            $parse->lovers = null;
        }
        if ($video->getTags() != null && count($video->getTags()) > 0) {
            $parse->tags = $video->getTags();
        } else {
            $parse->tags = null;
        }
        $parse->title = $video->getTitle();
        $parse->thumbnail = $video->getThumbnail();
        $parse->URL = $video->getURL();
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $video->setACL($acl);

        //se esiste l'objectId vuol dire che devo aggiornare
        //se non esiste vuol dire che devo salvare
        if (( $video->getObjectId()) != null) {
            //update
            try {
                //update
                $result = $parse->update($video->getObjectId());

                //aggiorno l'update
                $video->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
            } catch (Exception $e) {
                $error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
            }
        } else {
            try {
                //salvo
                $result = $parse->save();

                //aggiorno i dati per la creazione
                $video->setObjectId($result->objectId);
                $video->setCreatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
                $video->setUpdatedAt(new DateTime($result->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (Exception $e) {
                $error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
                return false;
            }
        }

        //restituisco video aggiornato
        return $video;
    }

    /**
     * La cancellazione prevede che il video venga impostato inattivo
     * @param Video $video il video da cancellare
     */
    public function deleteVideo(Video $video) {
        $video->setActive(false);
        if ($this->save($video))
            return true;
        else {
            return false;
        }
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
        //array di puntatori ad User 
        if (isset($parseObj->commentators)) {
            $parseQueryCommentators = new UserParse();
            $parseQueryCommentators->whereRelatedTo("commentators", "_User", $parseObj->objectId);
            $video->setCommentators($parseQueryCommentators->getUsers());
        }
        //array di puntatori ad commets
        if (isset($parseObj->comments)) {
            $parseQueryComments = new CommentParse();
            $parseQueryComments->whereRelatedTo("comments", "Comment", $parseObj->objectId);
            $video->setComments($parseQueryComments->getComments());
        }
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
        if (isset($parseObj->featuring)) {
            $parseQueryFeaturing = new UserParse();
            $parseQueryFeaturing->whereRelatedTo("featuring", "_User", $parseObj->objectId);
            $video->setFeaturing($parseQueryFeaturing->getUsers());
        }
        if (isset($parseObj->fromUser)) {
            $parseQueryUser = new UserParse();
            $parseQueryUser->whereEqualTo("objectId", $parseObj->fromUser);
            $video->setFromUser($parseQueryUser);
        }
        //integer counter
        if (isset($parseObj->loveCounter))
            $video->setLoveCounter($parseObj->loveCounter);
        //array di puntatori ad User 
        if (isset($parseObj->lovers)) {
            $parseQueryLovers = new UserParse();
            $parseQueryLovers->whereRelatedTo("lovers", "_User", $parseObj->objectId);
            $video->setLovers($parseQueryLovers->getUsers());
        }
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