<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Comment
 *  \details   Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI
 *
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:comment">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:comment">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';

class CommentParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new parseQuery('Comment');
    }

    public function deleteComment($objectId) {
        try {
            $parseObject = new parseObject('Comment');
            $parseObject->active = false;
            $parseObject->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getComment($objectId) {
        try {
            $parseObject = new parseObject('Comment');
            $res = $parseObject->get($objectId);
            $cmt = $this->parseToComment($res);
            return $cmt;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    public function getComments() {
		try {
            $cmts = null;
            $res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$cmts = array();
				foreach ($res->results as $obj) {
					$cmt = $this->parseToComment($obj);
					$cmts[$cmt->getObjectId()] = $cmt;
				}
			}
            return $cmts;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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

    public function parseToComment($res) {
		if ($res == null || !isset($res->objectId))
			return throwError(new Exception('parseToComment parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $cmt = new Comment();

            $cmt->setObjectId($res->objectId);
            $cmt->setActive($res->active);
            $cmt->setAlbum(fromParsePointer($res->album));
            $cmt->setComment(fromParsePointer($res->comment));
			$cmt->setCommentators(fromParseRelation('Comment', 'commentators', $res->objectId, '_User'));
            $cmt->setComments(fromParseRelation('Comment', 'comments', $res->objectId, 'Comment'));
            $cmt->setCounter($res->counter);
            $cmt->setEvent(fromParsePointer($res->event));
            $cmt->setFromUser(fromParsePointer($res->fromUser));
            $cmt->setImage(fromParsePointer($res->image));
            $cmt->setLocation(fromParseGeoPoint($res->location));
            $cmt->setLoveCounter($res->loveCounter);
            $cmt->setLovers(fromParseRelation('Comment', 'lovers', $res->objectId, '_User'));
            $cmt->setOpinions($res->opinions);
            $cmt->setRecord(fromParsePointer($res->record));
            $cmt->setSong(fromParsePointer($res->song));
            $cmt->setStatus(fromParsePointer($res->status));
            $cmt->setTags($res->tags);
            $cmt->setText($res->text);
            $cmt->setToUser(fromParsePointer($res->toUser));
            $cmt->setType($res->type);
            $cmt->setVideo(fromParsePointer($res->video));
            $cmt->setVote($res->vote);
            $cmt->setCreatedAt(new DateTime($res->createdAt));
            $cmt->setUpdatedAt(new DateTime($res->updatedAt));
            $cmt->setACL(fromParseACL($res->ACL));

            return $cmt;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    //� giusto, in caso di SAVE, ritornare il commento con l'objectId in pi�?
    public function saveComment($cmt) {
        try {
            $parseObject = new parseObject('Comment');

            is_null($cmt->getActive()) ? $parseObject->active = null : $parseObject->active = $cmt->getActive();
            is_null($cmt->getAlbum()) ? $parseObject->album = null : $parseObject->album = toParsePointer('Album', $cmt->getAlbum());
            is_null($cmt->getComment()) ? $parseObject->comment = null : $parseObject->comment = toParsePointer('Comment', $cmt->getComment());
            is_null($cmt->getCommentators()) ? $parseObject->commentators = null : $parseObject->commentators = toParseRelation('_User', $cmt->getCommentators());
            is_null($cmt->getComments()) ? $parseObject->comments = null : $parseObject->comments = toParseRelation('Comment', $cmt->getComments());
            is_null($cmt->getCounter()) ? $parseObject->counter = null : $parseObject->counter = $cmt->getCounter();
            is_null($cmt->getEvent()) ? $parseObject->event = null : $parseObject->event = toParsePointer('Event', $cmt->getEvent());
            is_null($cmt->getFromUser()) ? $parseObject->fromUser = null : $parseObject->fromUser = toParsePointer('_User', $cmt->getFromUser());
            is_null($cmt->getImage()) ? $parseObject->image = null : $parseObject->image = toParsePointer('Image', $cmt->getImage());
            is_null($cmt->getLocation()) ? $parseObject->location = null : $parseObject->location = toParseGeoPoint($cmt->getLocation());
            is_null($cmt->getLoveCounter()) ? $parseObject->loveCounter = null : $parseObject->loveCounter = $cmt->getLoveCounter();
            is_null($cmt->getLovers()) ? $parseObject->lovers = null : $parseObject->lovers = toParseRelation('_User', $cmt->getLovers());
            is_null($cmt->getOpinions()) ? $parseObject->opinions = null : $parseObject->opinions = $cmt->getOpinions();
            is_null($cmt->getRecord()) ? $parseObject->record = null : $parseObject->record = toParsePointer('Record', $cmt->getRecord());
            is_null($cmt->getSong()) ? $parseObject->song = null : $parseObject->song = toParsePointer('Song', $cmt->getSong());
            is_null($cmt->getStatus()) ? $parseObject->status = null : $parseObject->status = toParsePointer('Status', $cmt->getStatus());
            is_null($cmt->getTags()) ? $parseObject->tags = null : $parseObject->tags = $cmt->getTags();
            is_null($cmt->getText()) ? $parseObject->text = null : $parseObject->text = $cmt->getText();
            is_null($cmt->getToUser()) ? $parseObject->toUser = null : $parseObject->toUser = toParsePointer('_User', $cmt->getToUser());
            is_null($cmt->getType()) ? $parseObject->type = null : $parseObject->type = $cmt->getType();
            is_null($cmt->getVideo()) ? $parseObject->video = null : $parseObject->video = toParsePointer('Video', $cmt->getVideo());
            is_null($cmt->getVote()) ? $parseObject->vote = null : $parseObject->vote = $cmt->getVote();
			is_null($cmt->getACL()) ? $parseObject->ACL = null : $parseObject->ACL = toParseACL($cmt->getACL());

            if ($cmt->getObjectId() == '') {
                $res = $parseObject->save();
                $cmt->setObjectId($res->objectId);
                return $cmt;
            } else {
                $parseObject->update($cmt->getObjectId());
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

