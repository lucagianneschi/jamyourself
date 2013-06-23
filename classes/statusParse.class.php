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
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getStatus($objectId) {
        try {
            $parseObject = new parseObject('Status');
            $res = $parseObject->get($objectId);
            $status = $this->parseToStatus($res);
            return $status;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getStatuses() {
        $statuses = null;
        try {
            $result = $this->parseQuery->find();
            if (is_array($result->results) && count($result->results) > 0) {
                $statuses = array();
                foreach ($result->results as $obj) {
                    if ($obj) {
                        $status = $this->parseToStatus($obj);
                        $statuses[$status->getObjectId] = $status;
                    }
                }
            }
            return $statuses;
        } catch (Exception $exception) {
            return throwError($exception, __CLASS__, __FUNCTION__, func_get_args());
        }
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
        if ($parseObj == null || !isset($parseObj->objectId))
		return throwError(new Exception('parseToStatus parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $status = new Status();
            $status->setObjectId($parseObj->objectId);
            $status->setActive($parseObj->active);
            $commentators = fromParseRelation('Status','commentators', $parseObj->objectId, '_User');
            $status->setCommentators($commentators);
            $comments = fromParseRelation('Status','comments', $parseObj->objectId, 'Comment');
            $status->setComments($comments);
            $status->setCounter($parseObj->counter);
            $event = fromParsePointer($parseObj->event);
            $status->setEvent($event);
            $fromUser = fromParsePointer($parseObj->fromUser);
            $status->setFromUser($fromUser);
            $image = fromParsePointer($parseObj->image);
            $status->setImage($image);
            $parseGeoPoint = new parseGeoPoint($parseObj->location->latitude, $parseObj->location->longitude);
            $status->setLocation($parseGeoPoint);
            $status->setLoveCounter($parseObj->loveCounter);
            $lovers = fromParseRelation('Status','lovers', $parseObj->objectId, '_User');
            $status->setLovers($lovers);
            $song = fromParsePointer($parseObj->song);
            $status->setSong($song);
            $status->setText($parseObj->text);
            $taggedUsers = fromParseRelation('Status','taggedUsers', $parseObj->objectId, '_User');
            $status->setLovers($taggedUsers);
            $status->setCreatedAt(new DateTime($parseObj->createdAt));
            $status->setUpdatedAt(new DateTime($parseObj->updatedAt));
            $status->setACL(fromParseACL($parseObj->ACL));
            return $status;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function saveStatus(Status $status) {
        try {
            $parseObj = new parseObject('Status');

            is_null($status->getActive()) ? $parseObj->active = null : $parseObj->active = $status->getActive();
            is_null($status->getCommentators()) ? $parseObj->commentators = null : $parseObj->commentators = toParseRelation('_User', $status->getCommentators());
            is_null($status->getComments()) ? $parseObj->comments = null : $parseObj->comments = toParseRelation('Comment', $status->getCommentas());
            is_null($status->getCounter()) ? $parseObj->counter = null : $parseObj->counter = $status->getCounter();
            is_null($status->getEvent()) ? $parseObj->event = null : $parseObj->event = toParsePointer('Event', $status->getEvent());
            is_null($status->getFromUser()) ? $parseObj->fromUser = null : $parseObj->fromUser = toParsePointer('_User', $status->getFromUser());
            is_null($status->getImage()) ? $parseObj->image = null : $parseObj->image = toParsePointer('Image', $status->getImage());
            is_null($status->getLocation()) ? $parseObj->location = null : $parseObj->location = toParseGeopoint($status->getLocation());
            is_null($status->getLoveCounter()) ? $parseObj->loveCounter = null : $parseObj->loveCounter = $status->getLoveCounter();
            is_null($status->getLovers()) ? $parseObj->lovers = null : $parseObj->lovers = toParseRelation('_User', $status->getLovers());
            is_null($status->getSong()) ? $parseObj->song = null : $parseObj->song = toParsePointer('Song', $status->getSong());
            is_null($status->getTaggedUsers()) ? $parseObj->taggedUsers = null : $parseObj->taggedUsers = toParseRelation('_User', $status->getTaggedUsers());
            is_null($status->getText()) ? $parseObj->text = null : $parseObj->text = $status->getText();
            $acl = new ParseACL;
            $acl->setPublicReadAccess(true);
            $acl->setPublicWriteAccess(true);
            $parseObj->ACL = toParseACL($acl);
            if ($status->getObjectId() == '') {
                is_null($status->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseNewFile($status->getImage(), "img/jpg");
                $res = $parseObj->save();
                $status->setObjectId($res->objectId);
                return $status;
            } else {
                is_null($status->getImageFile()) ? $parseObj->imageFile = null : $parseObj->imageFile = toParseFile($status->getImage());
                $parseObj->update($status->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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