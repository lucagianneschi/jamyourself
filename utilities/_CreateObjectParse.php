<?php

define('PARSE_DIR', '../parse/');
define('CLASS_DIR', '../class/');
include_once PARSE_DIR.'parse.php';
include_once CLASS_DIR.'GeoPoint_Parse.class.php';

//dichiaro il nuovo oggetto
$parseObject = new parseObject('Comment');

/*
 * Esempio di creazione di properties
 * ----------------------------------
 *
 * String
 * $parseObject->prop = '';
 *
 * Number
 * $parseObject->prop = 0;
 *
 * Array
 * $parseObject->prop = array();
 *
 * Pointer (ad una classe User)
 * $parseObject->prop = array("__type" => "Pointer", "className" => "_User", "objectId" => $objectId_User);
 *
 * Boolean
 * $parseObject->prop = true;
 *
 * GeoPoint
 * $geoPoint_Parse = new GeoPoint_Parse(0, 0);
 * $geoCoding = $geoPoint_Parse->getGeoPoint();
 * $parseObject->location = $geoCoding;
 *
 */

//creo le properties		
$parseObject->active = 			true;
$parseObject->albumBrano = 		array("__type" => "Pointer", "className" => "AlbumBrani", "objectId" => "lgSNpHdG1K");
$parseObject->albumImmagine = 	array("__type" => "Pointer", "className" => "AlbumImmagine", "objectId" => "1JqvkK1TBr");
$parseObject->brano = 			array("__type" => "Pointer", "className" => "Brani", "objectId" => "");
$parseObject->counter = 		0;
$parseObject->event = 			array("__type" => "Pointer", "className" => "Event", "objectId" => "fYvQmHJmqV");
$parseObject->fromUser = 		array("__type" => "Pointer", "className" => "_User", "objectId" => "rrC0rDTRkB");
$parseObject->immagine = 		array("__type" => "Pointer", "className" => "Immagini", "objectId" => "OeJ3fTgAS3");
$geoPoint_Parse = new GeoPoint_Parse(0, 0);
$geoCoding = $geoPoint_Parse->getGeoPoint();
$parseObject->location = 		$geoCoding;
$parseObject->opinions = 		array();
$parseObject->tag = 			array();
$parseObject->text = 			"";
$parseObject->toUser = 			array("__type" => "Pointer", "className" => "_User", "objectId" => "rrC0rDTRkB");
$parseObject->type = 			"";
$parseObject->user = 			array("__type" => "Pointer", "className" => "_User", "objectId" => "rrC0rDTRkB");
$parseObject->video = 			array("__type" => "Pointer", "className" => "Video", "objectId" => "ihcPvm6BIv");
$parseObject->vote = 			0;

//salvo l'oggetto
$res = $parseObject->save();

//stampo a video il risultato
print_r($res);

?>