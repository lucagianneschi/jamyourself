<?php

define('PARSE_DIR', '../parse/');
define('CLASS_DIR', './');
include_once PARSE_DIR.'parse.php';
include_once CLASS_DIR.'comment.class.php';
include_once CLASS_DIR.'geoPointParse.class.php';
include_once CLASS_DIR.'pointerParse.class.php';

class commentParse {
	
	private $parseQuery;
	
	public function __construct() {
		$this->parseQuery = new parseQuery('Comment');
	}
	
	public function getComment($objectId) {
		//creo un nuovo oggetto Comment
		$cmt = new comment();
		//carico il Comment richiesta
		$parseObject = new parseObject('Comment');
		$res = $parseObject->get($objectId);

		//inizializzo l'oggetto
		$cmt->setObjectId($res->objectId);
		$cmt->setActive($res->active);
		$pointerParse = new pointerParse($res->albumBrano->className, $res->albumBrano->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setAlbumBrano($pointer);
		$pointerParse = new pointerParse($res->albumImmagine->className, $res->albumImmagine->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setAlbumImmagine($pointer);
		$pointerParse = new pointerParse($res->brano->className, $res->brano->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setBrano($pointer);
		$cmt->setCounter($res->counter);
		$pointerParse = new pointerParse($res->event->className, $res->event->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setEvent($pointer);
		$pointerParse = new pointerParse($res->fromUser->className, $res->fromUser->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setFromUser($pointer);
		$pointerParse = new pointerParse($res->immagine->className, $res->immagine->objectId);
		$pointer = $pointerParse->getPointer();
		$cmt->setImmagine($pointer);
		$geoPointParse = new GeoPoint_Parse($res->location->latitude, $res->location->longitude);
		$geoPoint = $geoPointParse->getGeoPoint();
		$cmt->setLocation($geoPoint);
		$cmt->setOpinions($res->opinions);
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
		$parseObject->albumBrano = 		$cmt->getAlbumBrano();
		$parseObject->albumImmagine = 	$cmt->getAlbumImmagine();
		$parseObject->brano = 			$cmt->getBrano();
		$parseObject->counter = 		$cmt->getCounter();
		$parseObject->event = 			$cmt->getEvent();
		$parseObject->fromUser = 		$cmt->getFromUser();
		$parseObject->immagine = 		$cmt->getImmagine();
		$parseObject->location = 		$cmt->getLocation();
		$parseObject->opinions = 		$cmt->getOpinions();
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