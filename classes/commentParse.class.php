<?php
 /*! \par Info Generali:
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
require_once CLASSES_DIR . 'utils.class.php';
 
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
			throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	public function getComment($objectId) {
		try {
			$parseObject = new parseObject('Comment');
			$res = $parseObject->get($objectId);
			$cmt = $this->parseToComment($res);
			return $cmt;
		} catch (Exception $e) {
			throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	public function getComments() {
		try {
			$cmts = array();
			$res = $this->parseQuery->find();
			foreach ($res->results as $obj) {
				$cmt = $this->parseToComment($obj);
				$cmts[$cmt->getObjectId()] = $cmt;
			}
			return $cmts;
		} catch (Exception $e) {
			throwError($e, __CLASS__, __FUNCTION__, func_get_args());
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
			
			//TODO
			$parseGeoPoint = new parseGeoPoint($res->location->latitude, $res->location->longitude);
			$cmt->setLocation($parseGeoPoint->location);
			
			$cmt->setLoveCounter();
			if (fromParseRelation('Comment', 'lovers', $res->objectId, '_User') != null) $cmt->setLovers(fromParseRelation('Comment', 'lovers', $res->objectId, '_User'));
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
			$cmt->setACL($res->ACL);
	 
			return $cmt;
		} catch (Exception $e) {
			throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	//� giusto, in caso di SAVE, ritornare il commento con l'objectId in pi�?
	public function saveComment($cmt) {
		try {
			$parseObject = new parseObject('Comment');
			
			$cmt->getActive() == null ? $parseObject->active = null : $parseObject->active = $cmt->getActive();
			$cmt->getAlbum() == null ? $parseObject->album = null : $parseObject->album = $cmt->getAlbum();
			$cmt->getComment() == null ? $parseObject->comment = null : $parseObject->comment = $cmt->getComment();
			$cmt->getCommentators() == null ? $parseObject->commentators = null : $parseObject->commentators = toParseRelation('_User', $cmt->getCommentators());
			$cmt->getComments() == null ? $parseObject->comments = null : $parseObject->comments = toParseRelation('Comment', $cmt->getComments());
			$cmt->getCounter() == null ? $parseObject->counter = null : $parseObject->counter = $cmt->getCounter();
			$cmt->getEvent() == null ? $parseObject->event = null : $parseObject->event = $cmt->getEvent();
			$cmt->getFromUser() == null ? $parseObject->fromUser = null : $parseObject->fromUser = $cmt->getFromUser();
			$cmt->getImage() == null ? $parseObject->image = null : $parseObject->image = $cmt->getImage();
			$cmt->getLocation() == null ? $parseObject->location = null : $parseObject->location = $cmt->getLocation();
			$cmt->getLoveCounter() == null ? $parseObject->loveCounter = null : $parseObject->loveCounter = $cmt->getLoveCounter();
			$cmt->getLovers() == null ? $parseObject->lovers = null : $parseObject->lovers = $cmt->getLovers();
			$cmt->getOpinions() == null ? $parseObject->opinions = null : $parseObject->opinions = $cmt->getOpinions();
			$cmt->getRecord() == null ? $parseObject->record = null : $parseObject->record = $cmt->getRecord();
			$cmt->getSong() == null ? $parseObject->song = null : $parseObject->song = $cmt->getSong();
			$cmt->getStatus() == null ? $parseObject->status = null : $parseObject->status = $cmt->getStatus();
			$cmt->getTags() == null ? $parseObject->tags = null : $parseObject->tags = $cmt->getTags();
			$cmt->getText() == null ? $parseObject->text = null : $parseObject->text = $cmt->getText();
			$cmt->getToUser() == null ? $parseObject->toUser = null : $parseObject->toUser = $cmt->getToUser();
			$cmt->getType() == null ? $parseObject->type = null : $parseObject->type = $cmt->getType();
			$cmt->getVideo() == null ? $parseObject->video = null : $parseObject->video = $cmt->getVideo();
			$cmt->getVote() == null ? $parseObject->vote = null : $parseObject->vote = $cmt->getVote();
			$cmt->getACL() == null ? $parseObject->ACL = null : $parseObject->ACL = $cmt->getACL()->acl;
			
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

