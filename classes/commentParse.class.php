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
 
require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
require_once PARSE_DIR.'parse.php';
require_once CLASSES_DIR.'error.class.php';
require_once CLASSES_DIR.'errorParse.class.php';

 
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
	
	public function getComment($objectId) {
		try {
			$parseObject = new parseObject('Comment');
			$res = $parseObject->get($objectId);
			$cmt = $this->parseToComment($res);
			return $cmt;
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
	
	public function getComments() {
		$cmts = array();
		$res = $this->parseQuery->find();
		foreach ($res->results as $obj) {
			$cmt = $this->parseToComment($obj);
			$cmts[$cmt->getObjectId()] = $cmt;
		}
		return $cmts;
	}
 
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}
 
	public function getRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
		$rel = $this->parseQuery->find();
		$relComment = array();
		foreach ($rel->results as $cmt) {
			$relComment[] = $cmt->objectId;
		}
		return $relComment;
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
 
	public function parseToComment($res) {
		$cmt = new Comment();
		
		$cmt->setObjectId($res->objectId);
		$cmt->setActive($res->active);
		if ($res->album != null) $cmt->setAlbum($res->album);
		if ($res->comment != null) $cmt->setComment($res->comment);
		
		# TODO
		//TEST ---> nella classe userParse.class.php si deve prevedere un metodo getRelatedTo($field, $className, $objectId)
		//          che ha il compito di restituire un array di User (solo glo objectId) relazionati all'objectId della classe
		//          $className del campo $field:
		//			$userParse = new UserParse();
		//			$userRelatedTo = $userParse->getRelatedTo('commentators', 'Comment', $res->objectId);
		$parseQuery = new parseQuery('_User');
		$parseQuery->whereRelatedTo('commentators', 'Comment', $res->objectId);
		$test = $parseQuery->find();
		$userRelatedTo = array();
		foreach ($test->results as $user) {
			$userRelatedTo[] = $user->objectId;
		}
		$cmt->setCommentators($userRelatedTo);
		
		$cmtRelatedTo = $this->getRelatedTo('comments', 'Comment', $res->objectId);
		$parseQuery = new parseQuery('Comment');
		$parseQuery->whereRelatedTo('comments', 'Comment', $res->objectId);
		$test = $parseQuery->find();
		$cmtRelatedTo = array();
		foreach ($test->results as $c) {
			$cmtRelatedTo[] = $c->objectId;
		}
		$cmt->setComments($cmtRelatedTo);
		
		$cmt->setCounter($res->counter);
		if ($res->event != null) $cmt->setEvent($res->event);
		if ($res->fromUser != null) $cmt->setFromUser($res->fromUser);
		if ($res->image != null) $cmt->setImage($res->image);
		$parseGeoPoint = new parseGeoPoint($res->location->latitude, $res->location->longitude);
		$cmt->setLocation($parseGeoPoint->location);
		$cmt->setLoveCounter();
		
		# TODO
		//TEST ---> $userParse = new UserParse();
		//			$loversRelatedTo = $userParse->getRelatedTo('lovers', 'Comment', $res->objectId):
		$parseQuery = new parseQuery('_User');
		$parseQuery->whereRelatedTo('lovers', 'Comment', $res->objectId);
		$test = $parseQuery->find();
		$loversRelatedTo = array();
		foreach ($test->results as $user) {
			$loversRelatedTo[] = $user->objectId;
		}
		$cmt->setLovers($loversRelatedTo);
		
		$cmt->setOpinions($res->opinions);
		if ($res->record != null) $cmt->setRecord($res->record);
		if ($res->song != null) $cmt->setSong($res->song);
		if ($res->status != null) $cmt->setStatus($res->status);
		$cmt->setTags($res->tags);
		$cmt->setText($res->text);
		if ($res->toUser != null) $cmt->setToUser($res->toUser);
		$cmt->setType($res->type);
		if ($res->video != null) $cmt->setVideo($res->video);
		$cmt->setVote($res->vote);
		$dateTime = new DateTime($res->createdAt);
		$cmt->setCreatedAt($dateTime);
		$dateTime = new DateTime($res->updatedAt);
		$cmt->setUpdatedAt($dateTime);
		$cmt->setACL($res->ACL);
 
		return $cmt;
	}
	
	public function saveComment($cmt) {
		try {
			$parseObject = new parseObject('Comment');
			if ($cmt->getObjectId() == '') {
				$cmt->getActive() == null ? $parseObject->active = null : $parseObject->active = $cmt->getActive();
				$cmt->getAlbum() == null ? $parseObject->album = null : $parseObject->album = $cmt->getAlbum();
				$cmt->getComment() == null ? $parseObject->comment = null : $parseObject->comment = $cmt->getComment();
				$cmt->getCommentators() == null ? $parseObject->commentators = null : $parseObject->commentators = $cmt->getCommentators();
				$cmt->getComments() == null ? $parseObject->comments = null : $parseObject->comments = $cmt->getComments();
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
				$res = $parseObject->save();
				return $res->objectId;
			} else {
				if ($cmt->getActive() != null) $parseObject->active = $cmt->getActive();
				if ($cmt->getAlbum() != null) $parseObject->album = $cmt->getAlbum();
				if ($cmt->getComment() != null) $parseObject->comment = $cmt->getComment();
				if ($cmt->getCommentators() != null) $parseObject->commentators = $cmt->getCommentators();
				if ($cmt->getComments() != null) $parseObject->comments = $cmt->getComments();
				if ($cmt->getCounter() != null) $parseObject->counter = $cmt->getCounter();
				if ($cmt->getEvent() != null) $parseObject->event = $cmt->getEvent();
				if ($cmt->getFromUser() != null) $parseObject->fromUser = $cmt->getFromUser();
				if ($cmt->getImage() != null) $parseObject->image = $cmt->getImage();
				if ($cmt->getLocation() != null) $parseObject->location = $cmt->getLocation();
				if ($cmt->getLoveCounter() != null) $parseObject->loveCounter = $cmt->getLoveCounter();
				if ($cmt->getLovers() != null) $parseObject->lovers = $cmt->getLovers();
				if ($cmt->getOpinions() != null) $parseObject->opinions = $cmt->getOpinions();
				if ($cmt->getRecord() != null) $parseObject->record = $cmt->getRecord();
				if ($cmt->getSong() != null) $parseObject->song = $cmt->getSong();
				if ($cmt->getStatus() != null) $parseObject->status = $cmt->getStatus();
				if ($cmt->getTags() != null) $parseObject->tags = $cmt->getTags();
				if ($cmt->getText() != null) $parseObject->text = $cmt->getText();
				if ($cmt->getToUser() != null) $parseObject->toUser = $cmt->getToUser();
				if ($cmt->getType() != null) $parseObject->type = $cmt->getType();
				if ($cmt->getVideo() != null) $parseObject->video = $cmt->getVideo();
				if ($cmt->getVote() != null) $parseObject->vote = $cmt->getVote();
				if ($cmt->getACL() != null) $parseObject->ACL = $cmt->getACL()->acl;
				$parseObject->update($cmt->getObjectId());
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
 
	public function updateComment($cmt){
		$cmt->printComment();
		$parseObject = new parseObject('Comment');	
 
		$parseObject->objectId = $cmt->getObjectId();
		$parseObject->active = $cmt->getActive();
		$parseObject->counter = $cmt->getCounter();
		$parseObject->event = $cmt->getEvent();
		$parseObject->fromUser = $cmt->getFromUser();
		$parseObject->image = $cmt->getImage();
		$parseObject->location = $cmt->getLocation();
		$parseObject->opinions = $cmt->getOpinions();
		$parseObject->photoAlbum = $cmt->getPhotoAlbum();
		$parseObject->record = $cmt->getRecord();
		$parseObject->song = $cmt->getSong();
		$parseObject->tag = $cmt->getTag();
		$parseObject->text = $cmt->getText();
		$parseObject->toUser = $cmt->getToUser();
		$parseObject->type = $cmt->getType();
		$parseObject->user = $cmt->getUser();
		$parseObject->video = $cmt->getVideo();
		$parseObject->vote = $cmt->getVote();
		$parseObject->createdAt = $cmt->getCreatedAt();
		$parseObject->updatedAt = $cmt->getUpdatedAt();
 
		$parseObject->update($cmt->getObjectId());
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

