<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		test pagina LDdf
 * \details		carica i box di una pagina di un jammer, Ldf
 * \par			Commenti:
 * \warning
 * \bug
 * \todo                inserire box comment e box review ad un record
 *
 */

$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'album.box.php';
require_once BOXES_DIR . 'event.box.php';
require_once BOXES_DIR . 'comment.box.php';
require_once BOXES_DIR . 'event.box.php';
require_once BOXES_DIR . 'post.box.php';
require_once BOXES_DIR . 'relation.box.php';
require_once BOXES_DIR . 'review.box.php';
require_once BOXES_DIR . 'userInfo.box.php';
$i_end = microtime();

$objectId = '7fes1RyY77'; //Ldf
echo '<br />-------------------------INIZIO CARICAMENTO BOX-------------------------------------------<br />';
echo '<br />-------------------------BOX USERINFO-------------------------------------------<br />';
$userInfo_start = microtime();
$userInfoBoxP = new UserInfoBox();
$userInfoBox = $userInfoBoxP->initForPersonalPage($objectId);
print "<pre>";
print_r($userInfoBox);
print "</pre>";
$userInfo_stop = microtime();
echo '<br />-------------------------FINE USERINFO EVENT-------------------------------------------<br />';
echo '<br />-------------------------BOX ALBUM-------------------------------------------<br />';
$album_start = microtime();
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->initForPersonalPage($objectId);
print "<pre>";
print_r($albumBox);
print "</pre>";
$album_stop = microtime();
echo '<br />-------------------------FINE BOX ALBUM-------------------------------------------<br />';
echo '<br />-------------------------BOX EVENT-------------------------------------------<br />';
$event_start = microtime();
$eventBoxP = new EventBox();
$eventBox = $eventBoxP->initForPersonalPage($objectId);
print "<pre>";
print_r($eventBox);
print "</pre>";
$event_stop = microtime();
echo '<br />-------------------------FINE BOX EVENT-------------------------------------------<br />';
echo '<br />-------------------------BOX POST-------------------------------------------<br />';
$post_start = microtime();
$postBoxP = new PostBox();
$postBox = $postBoxP->initForPersonalPage($objectId);
print "<pre>";
print_r($postBox);
print "</pre>";
$post_stop = microtime();
echo '<br />-------------------------FINE POST EVENT-------------------------------------------<br />';
echo '<br />-------------------------BOX RELATION-------------------------------------------<br />';
$relation_start = microtime();
$relationBoxP = new RelationsBox();
$relationBox = $relationBoxP->initForPersonalPage($objectId, 'JAMMER');
print "<pre>";
print_r($relationBox);
print "</pre>";
$relation_stop = microtime();
echo '<br />-------------------------FINE RELATION EVENT-------------------------------------------<br />';
echo '<br />-------------------------BOX REVIEW EVENT-------------------------------------------<br />';
$review_start = microtime();
$reviewBoxP = new ReviewBox();
$reviewBox = $reviewBoxP->initForPersonalPage($objectId, 'Event');
print "<pre>";
print_r($reviewBox);
print "</pre>";
$review_stop = microtime();
echo '<br />-------------------------FINE REVIEW EVENT-------------------------------------------<br />';
//echo '<br />-------------------------BOX REVIEW RECORD-------------------------------------------<br />';
//$review1_start = microtime();
//$reviewBoxP1 = new ReviewBox();
//$reviewBox1 = $relationBoxP1->initForPersonalPage($objectId, 'Record');
//print "<pre>";
//print_r($reviewBox1);
//print "</pre>";
//$review1_stop = microtime();
//echo '<br />-------------------------FINE REVIEW RECORD-------------------------------------------<br />';
//echo '<br />-------------------------BOX COMMENT-------------------------------------------<br />';
//$comment_start = microtime();
//$commentBoxP = new CommentBox();
//$commentBox = $commentBoxP->initForPersonalPage($objectId);
//print "<pre>";
//print_r($commentBox);
//print "</pre>";
//$comment_stop = microtime();
//echo '<br />-------------------------FINE BOX COMMENT-------------------------------------------<br />';

$t_end = microtime();
echo '<br />-------------------------FINE CARICAMENTO BOX-------------------------------------------<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo caricamento BOX ALBUM ' . executionTime($album_start, $album_stop) . '<br />';
//echo 'Tempo caricamento BOX COMMENT ' . executionTime($comment_start, $comment_stop) . '<br />';
echo 'Tempo caricamento BOX EVENT ' . executionTime($event_start, $event_stop) . '<br />';
echo 'Tempo caricamento BOX POST ' . executionTime($post_start, $post_stop) . '<br />';
echo 'Tempo caricamento BOX RELATION ' . executionTime($relation_start, $relation_stop) . '<br />';
echo 'Tempo caricamento BOX REVIEW EVENT ' . executionTime($review_start, $review_stop) . '<br />';
//echo 'Tempo caricamento BOX REVIEW RECORD' . executionTime($review1_start, $review1_stop) . '<br />';
echo 'Tempo caricamento USERINFO REVIEW ' . executionTime($userInfo_start, $userInfo_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';