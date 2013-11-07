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
$commentBox = $commentBoxP->init('Album', $album, 10, 0);
print "<pre>";
print_r($commentBox);
print "</pre>";
$album_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX COMMENT-------------------------------------------<br />';
$comment_start = microtime();
$commentBoxP1 = new CommentBox();
$commentBox1 = $commentBoxP1->init('Comment', $comment, 10, 0);
print "<pre>";
print_r($commentBox1);
print "</pre>";
$comment_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX EVENT-------------------------------------------<br />';
$event_start = microtime();
$commentBoxP2 = new CommentBox();
$commentBox2 = $commentBoxP2->init('Comment', $event, 10, 0);
print "<pre>";
print_r($commentBox2);
print "</pre>";
$event_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX IMAGE-------------------------------------------<br />';
$image_start = microtime();
$commentBoxP3 = new CommentBox();
$commentBox3 = $commentBoxP3->init('Image', $image, 10, 0);
print "<pre>";
print_r($commentBox3);
print "</pre>";
$image_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX RECORD-------------------------------------------<br />';
$record_start = microtime();
$commentBoxP4 = new CommentBox();
$commentBox4 = $commentBoxP4->init('Record', $record, 10, 0);
print "<pre>";
print_r($commentBox4);
print "</pre>";
$record_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX SONG-------------------------------------------<br />';
$song_start = microtime();
$commentBoxP5 = new CommentBox();
$commentBox5 = $commentBoxP5->init('Song', $song, 10, 0);
print "<pre>";
print_r($commentBox5);
print "</pre>";
$song_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX STATUS-------------------------------------------<br />';
$status_start = microtime();
$commentBoxP6 = new CommentBox();
$commentBox6 = $commentBoxP6->init('Status', $status, 10, 0);
print "<pre>";
print_r($commentBox6);
print "</pre>";
$status_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX VIDEO-------------------------------------------<br />';
$video_start = microtime();
$commentBoxP7 = new CommentBox();
$commentBox7 = $commentBoxP7->init('Video', $video, 10, 0);
print "<pre>";
print_r($commentBox7);
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
echo 'Tempo recupero commento STATUS' . executionTime($status_start, $status_stop) . '<br />';
echo 'Tempo recupero commento VIDEO' . executionTime($video_start, $video_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>