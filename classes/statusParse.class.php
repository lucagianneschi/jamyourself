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
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

class StatusParse {

    private $parseQuery;

    public function __construct() {

        $this->parseQuery = new ParseQuery("Status");
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

//recupero objectId

        $status->setObjectId($parseObj->objectId);
        $status->setActive($parseObj->active);
        $parseQueryCommentators = new parseQuery('_User');
        $parseQueryCommentators->whereRelatedTo('commentators', 'Status', $parseObj->objectId);
        $testCommentators = $parseQueryCommentators->find();
        $userRelatedTo = array();
        foreach ($testCommentators->results as $user) {
            $userRelatedTo[] = $user->objectId;
        }
        $status->setCommentators($userRelatedTo);
        $commentsRelatedTo = $this->getRelatedTo('comments', 'Status', $parseObj->objectId);
        $parseQueryComment = new parseQuery('Comment');
        $parseQueryComment->whereRelatedTo('comments', 'Status', $parseObj->objectId);
        $testComments = $parseQueryComment->find();
        $commentsRelatedTo = array();
        foreach ($testComments->results as $c) {
            $commentsRelatedTo[] = $c->objectId;
        }
        $status->setComments($commentsRelatedTo);
        $status->setCounter($parseObj->counter);
        if ($parseObj->event != null)
            $status->setEvent($parseObj->event);
        if ($parseObj->fromUser != null)
            $status->setFromUser($parseObj->fromUser);
        if ($parseObj->image != null)
            $status->setImage($parseObj->image);
        $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
        $status->setLocation($parseGeoPoint->location);
        $status->setLoveCounter($parseObj->loveCounter);
        $parseQueryLovers = new parseQuery('_User');
        $parseQueryLovers->whereRelatedTo('lovers', 'Comment', $parseObj->objectId);
        $testLovers = $parseQueryLovers->find();
        $loversRelatedTo = array();
        foreach ($testLovers->results as $user) {
            $loversRelatedTo[] = $user->objectId;
        }
        $status->setLovers($loversRelatedTo);
        if ($parseObj->song != null)
            $status->setSong($parseObj->song);
        $status->setText($parseObj->text);
        $parseQuerytaggedUser = new parseQuery('_User');
        $parseQuerytaggedUser->whereRelatedTo('taggedUsers', 'Status', $parseObj->objectId);
        $testTaggedUser = $parseQuerytaggedUser->find();
        $taggedUserRelatedTo = array();
        foreach ($testTaggedUser->results as $user) {
            $taggedUserRelatedTo[] = $user->objectId;
        }
        $status->setTaggedUser($taggedUserRelatedTo);
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
            $parseObject = new parseObject('Comment');
            if ($status->getObjectId() == '') {
                $status->getActive() == null ? $parseObject->active = null : $parseObject->active = $status->getActive();
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

    public function updateComment($status) {
        $status->printComment();
        $parseObject = new parseObject('Comment');

        $parseObject->objectId = $status->getObjectId();
        $parseObject->active = $status->getActive();
        $parseObject->counter = $status->getCounter();
        $parseObject->event = $status->getEvent();
        $parseObject->fromUser = $status->getFromUser();
        $parseObject->image = $status->getImage();
        $parseObject->location = $status->getLocation();
        $parseObject->opinions = $status->getOpinions();
        $parseObject->photoAlbum = $status->getPhotoAlbum();
        $parseObject->record = $status->getRecord();
        $parseObject->song = $status->getSong();
        $parseObject->tag = $status->getTag();
        $parseObject->text = $status->getText();
        $parseObject->toUser = $status->getToUser();
        $parseObject->type = $status->getType();
        $parseObject->user = $status->getUser();
        $parseObject->video = $status->getVideo();
        $parseObject->vote = $status->getVote();
        $parseObject->createdAt = $status->getCreatedAt();
        $parseObject->updatedAt = $status->getUpdatedAt();

        $parseObject->update($status->getObjectId());
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