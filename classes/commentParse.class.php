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
		//creo un nuovo oggetto Comment
		$cmt = new Comment();
		//carico il Comment richiesta
		$parseObject = new parseObject('Comment');
		$res = $parseObject->get($objectId);

		//inizializzo l'oggetto
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
		$geoPointParse = new GeoPoint_Parse($res->location->latitude, $res->location->longitude);
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
	
	public function saveComment($cmt) {
		//creo la "connessione" con Parse
		$parseObject = new parseObject('Comment');
		
		$parseObject->active = 			$cmt->getActive();
		$parseObject->counter = 		$cmt->getCounter();
		$parseObject->event = 			$cmt->getEvent();
		$parseObject->fromUser = 		$cmt->getFromUser();
		$parseObject->image = 			$cmt->getImage();
		$parseObject->location = 		$cmt->getLocation();
		$parseObject->opinions = 		$cmt->getOpinions();
		$parseObject->photoAlbum = 		$cmt->getPhotoAlbum();
		$parseObject->record = 			$cmt->getRecord();
		$parseObject->song = 			$cmt->getSong();
		$parseObject->tag = 			$cmt->getTag();
		$parseObject->text = 			$cmt->getText();
		$parseObject->toUser = 			$cmt->getToUser();
		$parseObject->type = 			$cmt->getType();
		$parseObject->user = 			$cmt->getUser();
		$parseObject->video = 			$cmt->getVideo();
		$parseObject->vote = 			$cmt->getVote();
		
		$parseObject->save();
	}
	
}
?>