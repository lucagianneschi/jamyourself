<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
ini_set('max_execution_time', 0);

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';

$ACL = new parseACL();
$ACL->setPublicWriteAccess(true);

$album = new Album();
//
//$album->setActive(null);
//$album->setCommentators(null);
//$album->setComments(null);
//$album->setCounter(null);
//$album->setCover(null);
//$album->setCoverFile(null);
//$album->setDescription(null);
//$album->setFeaturing(null);
//$album->setFromUser(null);
//$album->setImages(null);
//$album->setLocation(null);
//$album->setLoveCounter(null);
//$album->setLovers(null);
//$album->setTags(null);
//$album->setThumbnailCover(null);
//$album->setTitle(null);
//$album->setACL($ACL);
//
//echo '<br />-------------------------------------------------------------------------------<br />';
//echo "<br/><br/> Stampo Album prima del salvataggio con valori NULL:  <br/><br/>";
//echo '<br />-------------------------------------------------------------------------------<br />';
//echo $album;
//echo '<br />-------------------------------------------------------------------------------<br />';
//echo "<br/><br/> Stampo Album restituita dal salvataggio con valori NULL:  <br/><br/>";
//echo '<br />-------------------------------------------------------------------------------<br />';
//$pAlbum = new AlbumParse();
//
//$album = $pAlbum->saveAlbum($album);
//
//echo $album;
//echo '<br />-------------------------------------------------------------------------------<br />';
//echo "<br/><br/>Recupero l'oggetto salvato su Parse: objectId: ". $album->getObjectId() ."  <br/><br/>";
//echo '<br />-------------------------------------------------------------------------------<br />';
//$pAlbum = new AlbumParse();
//$album = $pAlbum->getAlbum($album->getObjectId());

//echo $album;
echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />Inizializzo i valori <br />';
echo '<br />-------------------------------------------------------------------------------<br />';

$file = uploadFile("testParseFile.txt", "txt");
$active = true;
$commentators = array("1l9es3F5WO","sDqka2c1WB");
$comments = array("M8Abw83aVG");
$counter = 5;
$cover = "testCoverPath";
$coverFile = $file;
$description = "TEST_ALBUM_SAVE";
$featuring = array("1l9es3F5WO");
$fromUser = "sDqka2c1WB";
$images = array("3AI9EDVMHj","P8YxAJF4Vw");
$location = new parseGeoPoint("34", "65");
$loveCounter = 2;
$lovers = array("9Jtjk3OYvN","4ioHYWKsXx");
$tags = array ('test','album');
$thumbnailCover = "testThumbnailCoverPath";
$title = "TEST_ALBUM";

$album->setActive($active);
$album->setCommentators($commentators);
$album->setComments($comments);
$album->setCounter($counter);
$album->setCover($cover);
$album->setCoverFile($coverFile);
$album->setDescription($description);
$album->setFeaturing($featuring);
$album->setFromUser($fromUser);
$album->setImages($images);
$album->setLocation($location);
$album->setLoveCounter($loveCounter);
$album->setLovers($lovers);
$album->setTags($tags);
$album->setThumbnailCover($thumbnailCover);
$album->setTitle($title);
$album->setACL($ACL);

echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> Stampo Album prima del salvataggio:  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
echo $album;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> Stampo Album restituita dal salvataggio:  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pAlbum = new AlbumParse();
$album = $pAlbum->saveAlbum($album);
echo $album;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/>Recupero l'oggetto salvato su Parse: objectId: ". $album->getObjectId() ."  <br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pAlbum = new AlbumParse();
$album = $pAlbum->getAlbum($album->getObjectId());

echo $album;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> UPDATE dell'oggetto salvato su Parse: objectId: ". $album->getObjectId() ."<br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pAlbum = new AlbumParse();
$album = $pAlbum->getAlbum($album->getObjectId());
$album->setDescription("TEST_ALBUM_UPDATED");
$album = $pAlbum->saveAlbum($album);
$album = $pAlbum->getAlbum($album->getObjectId());

echo $album;
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> DELETE dell'oggetto salvato su Parse: objectId: ". $album->getObjectId() ."<br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$ret = $pAlbum->deleteAlbum($album->getObjectId());

echo "Fine delete";
echo '<br />-------------------------------------------------------------------------------<br />';
echo "<br/><br/> DELETE Provo a recuperare l'oggetto cancellato (deve avere active = FALSE): ". $album->getObjectId() ."<br/><br/>";
echo '<br />-------------------------------------------------------------------------------<br />';
$pAlbum = new AlbumParse();
$album = $pAlbum->getAlbum($album->getObjectId());
echo $album;
echo '<br />-------------------------------------------------------------------------------<br />';
?>
