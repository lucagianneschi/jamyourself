<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Album
 * \details		Recupera gli ultimi 4 album attivi (valido per ogni tipologia di utente)
 * \par			Commenti:
 * \warning
 * \bug
 * \todo        utilizzare le variabili di sessione e non fare la get dello user
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'comment.box.php';
$i_end = microtime();

$album = '6nl9mn8a4I';
$comment = '53ZW8ukLKB';
$event = '';
$image = '';
$record = 'vR80iF0aI7';
$song = '';
$video = '';
$currentUserId = '7fes1RyY77';
echo '<br />-------------------------TEST COMMENT BOX ALBUM-------------------------------------------<br />';
$album_start = microtime();
$commentBoxP = new CommentBox();
$commentBoxP->init($album, 'Album', 10, 0);
print "<pre>";
print_r($commentBoxP);
print "</pre>";
$album_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX COMMENT-------------------------------------------<br />';
$comment_start = microtime();
$commentBoxP1 = new CommentBox();
$commentBoxP1->init($comment, 'Comment', 10, 0);
print "<pre>";
print_r($commentBoxP1);
print "</pre>";
$comment_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX EVENT-------------------------------------------<br />';
$event_start = microtime();
$commentBoxP2 = new CommentBox();
$commentBoxP2->init($event, 'Comment', 10, 0);
print "<pre>";
print_r($commentBoxP2);
print "</pre>";
$event_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX IMAGE-------------------------------------------<br />';
$image_start = microtime();
$commentBoxP3 = new CommentBox();
$commentBoxP3->init($image, 'Image', 10, 0);
print "<pre>";
print_r($commentBoxP3);
print "</pre>";
$image_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX RECORD-------------------------------------------<br />';
$record_start = microtime();
$commentBoxP4 = new CommentBox();
$commentBoxP4->init($record, 'Record', 10, 0);
print "<pre>";
print_r($commentBoxP4);
print "</pre>";
$record_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX SONG-------------------------------------------<br />';
$song_start = microtime();
$commentBoxP5 = new CommentBox();
$commentBoxP5->init($song, 'Song', 10, 0);
print "<pre>";
print_r($commentBoxP5);
print "</pre>";
$song_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX VIDEO-------------------------------------------<br />';
$video_start = microtime();
$commentBoxP7 = new CommentBox();
$commentBoxP7->init($video,'Video',  10, 0);
print "<pre>";
print_r($commentBoxP7);
print "</pre>";
$video_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero commento ALBUM' . executionTime($album_start, $album_stop) . '<br />';
echo 'Tempo recupero commento COMMENT' . executionTime($comment_start, $comment_stop) . '<br />';
echo 'Tempo recupero commento EVENT' . executionTime($event_start, $event_stop) . '<br />';
echo 'Tempo recupero commento IMAGE' . executionTime($image_start, $image_stop) . '<br />';
echo 'Tempo recupero commento RECORD' . executionTime($record_start, $record_stop) . '<br />';
echo 'Tempo recupero commento SONG' . executionTime($song_start, $song_stop) . '<br />';
echo 'Tempo recupero commento VIDEO' . executionTime($video_start, $video_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>