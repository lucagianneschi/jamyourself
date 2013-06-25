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
            $parseStatus = new parseObject('Status');
            $parseStatus->active = false;
            $parseStatus->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    public function getStatus($objectId) {
        try {
            $parseStatus = new parseObject('Status');
            $res = $parseStatus->get($objectId);
            $status = $this->parseToStatus($res);
            return $status;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function getStatuses() {
        $statuses = null;
        try {
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $statuses = array();
                foreach ($res->results as $obj) {
                    if ($obj) {
                        $status = $this->parseToStatus($obj);
                        $statuses[$status->getObjectId] = $status;
                    }
                }
            }
            return $statuses;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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

    public function parseToStatus($res) {
        if (is_null($res))
		return throwError(new Exception('parseToVideo parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $status = new Status();
            $status->setObjectId($res->objectId);
            $status->setActive($res->active);
            $commentators = fromParseRelation('Status','commentators', $res->objectId, '_User');
            $status->setCommentators($commentators);
            $comments = fromParseRelation('Status','comments', $res->objectId, 'Comment');
            $status->setComments($comments);
            $status->setCounter($res->counter);
            $event = fromParsePointer($res->event);
            $status->setEvent($event);
            $fromUser = fromParsePointer($res->fromUser);
            $status->setFromUser($fromUser);
            $image = fromParsePointer($res->image);
            $status->setImage($image);
            $parseGeoPoint = new parseGeoPoint($res->location->latitude, $res->location->longitude);
            $status->setLocation($parseGeoPoint);
            $status->setLoveCounter($res->loveCounter);
            $lovers = fromParseRelation('Status','lovers', $res->objectId, '_User');
            $status->setLovers($lovers);
            $song = fromParsePointer($res->song);
            $status->setSong($song);
            $status->setText($res->text);
            $taggedUsers = fromParseRelation('Status','taggedUsers', $res->objectId, '_User');
            $status->setLovers($taggedUsers);
            $status->setCreatedAt(new DateTime($res->createdAt));
            $status->setUpdatedAt(new DateTime($res->updatedAt));
            $status->setACL(fromParseACL($res->ACL));
            return $status;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

    public function saveStatus($status) {
        try {
            $parseStatus = new parseObject('Status');

            is_null($status->getActive()) ? $parseStatus->active = true : $parseStatus->active = $status->getActive();
            is_null($status->getCommentators()) ? $parseStatus->commentators = null : $parseStatus->commentators = toParseRelation('_User', $status->getCommentators());
            is_null($status->getComments()) ? $parseStatus->comments = null : $parseStatus->comments = toParseRelation('Comment', $status->getCommentas());
            is_null($status->getCounter()) ? $parseStatus->counter = -1 : $parseStatus->counter = $status->getCounter();
            is_null($status->getEvent()) ? $parseStatus->event = null : $parseStatus->event = toParsePointer('Event', $status->getEvent());
            is_null($status->getFromUser()) ? $parseStatus->fromUser = null : $parseStatus->fromUser = toParsePointer('_User', $status->getFromUser());
            is_null($status->getImage()) ? $parseStatus->image = null : $parseStatus->image = toParsePointer('Image', $status->getImage());
            is_null($status->getLocation()) ? $parseStatus->location = null : $parseStatus->location = toParseGeopoint($status->getLocation());
            is_null($status->getLoveCounter()) ? $parseStatus->loveCounter = null : $parseStatus->loveCounter = $status->getLoveCounter();
            is_null($status->getLovers()) ? $parseStatus->lovers = null : $parseStatus->lovers = toParseRelation('_User', $status->getLovers());
            is_null($status->getSong()) ? $parseStatus->song = null : $parseStatus->song = toParsePointer('Song', $status->getSong());
            is_null($status->getTaggedUsers()) ? $parseStatus->taggedUsers = null : $parseStatus->taggedUsers = toParseRelation('_User', $status->getTaggedUsers());
            is_null($status->getText()) ? $parseStatus->text = null : $parseStatus->text = $status->getText();
            $acl = new ParseACL;
            $acl->setPublicReadAccess(true);
            $acl->setPublicWriteAccess(true);
            is_null($status->getACL()) ? $parseStatus->ACL = $acl : $parseStatus->ACL = toParseACL($status->getACL());
            if ($status->getObjectId() == '') {
                is_null($status->getImageFile()) ? $parseStatus->imageFile = null : $parseStatus->imageFile = toParseNewFile($status->getImage(), "img/jpg");
                $res = $parseStatus->save();
                $status->setObjectId($res->objectId);
                return $status;
            } else {
                is_null($status->getImageFile()) ? $parseStatus->imageFile = null : $parseStatus->imageFile = toParseFile($status->getImage());
                $parseStatus->update($status->getObjectId());
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

    public function whereRelatedTo($field, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($field, $className, $objectId);
    }

}

?>