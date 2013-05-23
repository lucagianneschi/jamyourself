<?php
 
define('PARSE_DIR', '../parse/');
define('CLASS_DIR', './');
include_once PARSE_DIR.'parse.php';
include_once CLASS_DIR.'comment.class.php';
include_once CLASS_DIR.'geoPointParse.class.php';
include_once CLASS_DIR.'pointerParse.class.php';
 
class CommentParse {
 
	private $parseQuery;
 
	public function __construct() {
		$this->parseQuery = new parseQuery('Comment');
	}
 
	public function getComment($objectId) {
		$cmt = new Comment();
		
		$parseObject = new parseObject('Comment');
		$res = $parseObject->get($objectId);
 
		$cmt->setObjectId($res->objectId);
		$cmt->setActive($res->active);
		$cmt->setCounter($res->counter);
		$pointerParse = new pointerParse($res->event->className, $res->event->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setEvent($pointer);
		$pointerParse = new pointerParse($res->fromUser->className, $res->fromUser->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setFromUser($pointer);
		$pointerParse = new pointerParse($res->image->className, $res->image->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setImage($pointer);
		$geoPointParse = new GeoPointParse($res->location->latitude, $res->location->longitude);
		$geoPoint = $geoPointParse->getGeoPoint();
		$cmt->setLocation($geoPoint);
		$cmt->setOpinions($res->opinions);
		$pointerParse = new pointerParse($res->photoAlbum->className, $res->photoAlbum->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setPhotoAlbum($pointer);
		$pointerParse = new pointerParse($res->record->className, $res->record->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setRecord($pointer);
		$pointerParse = new pointerParse($res->song->className, $res->song->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setSong($pointer);
		$cmt->setTag($res->tag);
		$cmt->setText($res->text);
		$pointerParse = new pointerParse($res->toUser->className, $res->toUser->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setToUser($pointer);
		$cmt->setType($res->type);
		$pointerParse = new pointerParse($res->user->className, $res->user->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setUser($pointer);
		$pointerParse = new pointerParse($res->video->className, $res->video->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setVideo($pointer);
		$cmt->setVote($res->vote);
		$cmt->setCreatedAt($res->createdAt);
		$cmt->setUpdatedAt($res->updatedAt);
 
		return $cmt;
	}
 
	public function getComments() {
		$cmts = array();
		$res = $this->parseQuery->find();
		foreach ($res->results as $obj) {
			$cmt = new Comment();
			$cmt->setObjectId($obj->objectId);
			$cmt->setActive($obj->active);
			$cmt->setCounter($obj->counter);
			$cmt->setEvent($obj->event);
			$cmt->setFromUser($obj->fromUser);
			$cmt->setImage($obj->image);
			$geoPointParse = new GeoPointParse($obj->location->latitude, $obj->location->longitude);
			$geoPoint = $geoPointParse->getGeoPoint();
			$cmt->setLocation($geoPoint);
			$cmt->setOpinions($obj->opinions);
			$cmt->setPhotoAlbum($obj->photoAlbum);
			$cmt->setRecord($obj->record);
			$cmt->setSong($obj->song);
			$cmt->setTag($obj->tag);
			$cmt->setText($obj->text);
			$cmt->setToUser($obj->toUser);
			$cmt->setType($obj->type);
			$cmt->setUser($obj->user);
			$cmt->setVideo($obj->video);
			$cmt->setVote($obj->vote);
			$cmt->setCreatedAt($obj->createdAt);
			$cmt->setUpdatedAt($obj->updatedAt);
			//$cmt->setACL($obj->ACL);
			$cmts[$obj->objectId] = $cmt;
		}
		return $cmts;
	}
 
	public function getCount() {
		return $this->parseQuery->getCount()->count;
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
 
	public function saveComment($cmt) {
		$parseObject = new parseObject('Comment');
 
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
 
		$parseObject->save();
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

