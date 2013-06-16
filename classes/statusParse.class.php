<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Stutus Class
 *  \details   Classe status dello User, raccoglie uno stato dell'utente, posso collegarci immagine o song
 *
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:status">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:status">API</a>
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';

require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';

require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';


class StatusParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Status");
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getRelatedTo($field, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($field, $className, $objectId);
        $rel = $this->parseQuery->find();
        $relStatus = array();
        foreach ($rel->results as $status) {
            $relStatus[] = $status->objectId;
        }
        return $relStatus;
    }

    public function deleteStatus($objectId) {
        try {
            $parseObject = new parseObject('Status');
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

    public function getStatus($objectId) {
        try {
            $parseObject = new parseObject('Status');
            $res = $parseObject->get($objectId);
            $status = $this->parseToStatus($res);
            return $status;
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

    public function getStatuses() {
        $statuses = array();
        $res = $this->parseQuery->find();
        foreach ($res->results as $obj) {
            $status = $this->parseToComment($obj);
            $statuses[$status->getObjectId()] = $status;
        }
        return $statuses;
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

    public function parseToStatus(stdClass $parseObj) {

        if ($parseObj == null)
            return null;  //se non ho ricevuto niente...

        $status = new Status();
        
        if(isset($parseObj->objectId))
            $status->setObjectId($parseObj->objectId);
        if(isset($parseObj->active))
            $status->setActive($parseObj->active);
        if(isset($parseObj->commentators)){
            $userParse = new UserParse();
            $commentators = $this->$userParse->getRelatedTo('commentators', 'Status', $parseObj->objectId);
            $status->setCommentators($commentators);
        }
        if(isset($parseObj->comments)){
            $commentParse = new CommentParse();
            $comments = $this->$commentParse->getRelatedTo('comments', 'Status', $parseObj->objectId);
            $status->setComments($comments);
        }
        if(isset($parseObj->counter))
            $status->setCounter($parseObj->counter);
        if (isset($parseObj->event))
            $status->setEvent($parseObj->event);
        if (isset($parseObj->fromUser))
            $status->setFromUser($parseObj->fromUser);
        if (isset($parseObj->image))
            $status->setImage($parseObj->image);
        if(isset($parseObj->location)){
            $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
            $status->setLocation($parseGeoPoint->location);
        }
        if(isset($parseObj->loveCounter))
            $status->setLoveCounter($parseObj->loveCounter);
        if(isset($parseObj->lovers)){
            $userParse = new UserParse();
            $lovers = $this->$userParse->getRelatedTo('lovers', 'Status', $parseObj->objectId);
            $status->setLovers($lovers);
        }
        if (isset($parseObj->song))
            $status->setSong($parseObj->song);
        if(isset($parseObj->text))
            $status->setText($parseObj->text);
        if(isset($parseObj->taggedUsers)){
            $userParse = new UserParse();
            $taggedUsers = $this->$userParse->getRelatedTo('taggedUsers', 'Status', $parseObj->objectId);
            $status->setLovers($taggedUsers);
        }
        if (isset($parseObj->createdAt))
            $status->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $status->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $status->setACL($acl);
        return $status;
    }

    public function saveStatus(Status $status) {
        try {
            $parseObject = new parseObject('Status');
            if ($status->getObjectId() == '') {
                 //codice che implementa la utils.class
                /*
                $parseObj->commentators = toParseRelation($status->getCommentators());
                $parseObj->comments = toParseRelation($status->getComments());
                $parseObj->featuring = toParseRelation($status->getFeaturing());
                $parseObj->fromUser = toParsePointer($status->getFromUser()); 
                $parseObj->image = toParsePointer($status->getImage());
                $parseObj->location = toParsePointer($status->getLocation());
                $parseObj->lovers = toParseRelation($status->getLovers())
                $parseObj->taggedUsers = toParseRelation($status->getTaggedUsers());
                $parseObj->ACL = toParseACL($status->getACL());
                */
                
                
                $status->getActive() === null ? $parseObject->active = null : $parseObject->active = $status->getActive();
                $status->getCommentators() == null ? $parseObject->commentators = null : $parseObject->commentators = $status->getCommentators();
                $status->getComments() == null ? $parseObject->comments = null : $parseObject->comments = $status->getComments();
                $status->getCounter() == null ? $parseObject->counter = null : $parseObject->counter = $status->getCounter();
                $status->getEvent() == null ? $parseObject->event = null : $parseObject->event = $status->getEvent();
                $status->getFromUser() == null ? $parseObject->fromUser = null : $parseObject->fromUser = $status->getFromUser();
                $status->getImage() == null ? $parseObject->image = null : $parseObject->image = $status->getImage();
                $status->getImageFile() == null ? $parseObject->imageFile = null : $parseObject->imageFile = $status->getImageFile();
                $status->getLocation() == null ? $parseObject->location = null : $parseObject->location = $status->getLocation();
                $status->getLoveCounter() == null ? $parseObject->loveCounter = null : $parseObject->loveCounter = $status->getLoveCounter();
                $status->getLovers() == null ? $parseObject->lovers = null : $parseObject->lovers = $status->getLovers();
                $status->getSong() == null ? $parseObject->song = null : $parseObject->song = $status->getSong();
                $status->getTaggedUsers() == null ? $parseObject->taggedUsers = null : $parseObject->taggedUsers = $status->getTaggedUsers();
                $status->getText() == null ? $parseObject->text = null : $parseObject->text = $status->getText();
                $status->getACL() == null ? $parseObject->ACL = null : $parseObject->ACL = $status->getACL()->acl;
                $parseObj = $parseObject->save();
                return $parseObj->objectId;
            } else {
                if ($status->getActive() != null)
                    $parseObject->active = $status->getActive();
                if ($status->getCommentators() != null)
                    $parseObject->commentators = $status->getCommentators();
                if ($status->getComments() != null)
                    $parseObject->comments = $status->getComments();
                if ($status->getCounter() != null)
                    $parseObject->counter = $status->getCounter();
                if ($status->getEvent() != null)
                    $parseObject->event = $status->getEvent();
                if ($status->getFromUser() != null)
                    $parseObject->fromUser = $status->getFromUser();
                if ($status->getImage() != null)
                    $parseObject->image = $status->getImage();
                if ($status->getImageFile() != null)
                    $parseObject->imageFile = $status->getImageFile();
                if ($status->getLocation() != null)
                    $parseObject->location = $status->getLocation();
                if ($status->getLoveCounter() != null)
                    $parseObject->loveCounter = $status->getLoveCounter();
                if ($status->getLovers() != null)
                    $parseObject->lovers = $status->getLovers();
                if ($status->getSong() != null)
                    $parseObject->song = $status->getSong();
                if ($status->getTaggedUsers() != null)
                    $parseObject->taggedUsers = $status->getTaggedUsers();
                if ($status->getText() != null)
                    $parseObject->text = $status->getText();
                if ($status->getACL() != null)
                    $parseObject->ACL = $status->getACL()->acl;
                $parseObject->update($status->getObjectId());
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

    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    public function where($field, $value) {
        $this->parseQuery->where($field, $value);
    }

    public function whereContainedIn($field, $values) {
        $this->parseQuery->whereContainedIn($field, $values);
    }

    public function whereEqualTo($field, $value) {
        $this->parseQuery->whereEqualTo($field, $value);
    }

    public function whereExists($field) {
        $this->parseQuery->whereExists($field);
    }

    public function whereGreaterThan($field, $value) {
        $this->parseQuery->whereGreaterThan($field, $value);
    }

    public function whereGreaterThanOrEqualTo($field, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
    }

    public function whereLessThan($field, $value) {
        $this->parseQuery->whereLessThan($field, $value);
    }

    public function whereLessThanOrEqualTo($field, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($field, $value);
    }

    public function whereNotContainedIn($field, $array) {
        $this->parseQuery->whereNotContainedIn($field, $array);
    }

    public function whereNotEqualTo($field, $value) {
        $this->parseQuery->whereNotEqualTo($field, $value);
    }

    public function whereNotExists($field) {
        $this->parseQuery->whereDoesNotExist($field);
    }

    public function wherePointer($field, $className, $objectId) {
        $this->parseQuery->wherePointer($field, $className, $objectId);
    }

}

?>