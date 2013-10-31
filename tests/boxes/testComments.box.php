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

$id = 'gdZowTbFRk';
echo '<br />-------------------------TEST COMMENT BOX IMAGE-------------------------------------------<br />';
$comment_start = microtime();
$commentBoxP = new CommentBox();
$commentBox = $commentBoxP->init('Image',$id);
print "<pre>";
print_r($commentBox);
print "</pre>";
$comment_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX IMAGE-------------------------------------------<br />';

$idRec = 'sveemvaUN8';
echo '<br />-------------------------TEST COMMENT BOX RECORD-------------------------------------------<br />';
$comment1_start = microtime();
$commentBoxP = new CommentBox();
$commentBox = $commentBoxP->init('Record',$idRec);
print "<pre>";
print_r($commentBox);
print "</pre>";
$comment1_stop = microtime();
echo '<br />-------------------------FINE TEST COMMENT BOX RECORD-------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero commento ' . executionTime($comment_start, $comment_stop) . '<br />';
echo 'Tempo recupero commento ' . executionTime($comment1_start, $comment1_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>