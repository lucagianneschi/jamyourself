<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box commenti record
 * \details		Recupera i commenti legati al record
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();

$id = 'b8r9q9b5se';
$comment_start = microtime();
$commentP = new CommentParse();
$commentP->wherePointer('record', 'Record', $id);
$commentP->where('type', 'C');
$commentP->where('active', true);
$commentP->whereInclude('fromUser');
$commentP->setLimit(3);
$commentP->orderByDescending('createdAt');
$last3comments = $commentP->getComments();
if ($last3comments != 0) {
    if (get_class($last3comments) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last3comments->getErrorMessage() . '<br/>';
    } else {
	foreach ($last3comments->fromUser as $fromUser) {
	    echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
	    echo '<br />[type] => ' . $fromUser->getType() . '<br />';
	    echo '<br />[thumb] => ' . $fromUser->getProfileThumbnail() . '<br />';
	}
	foreach ($last3comments as $comment) {
	    echo '<br />[text] => ' . $comment->getText() . '<br />';
	}
    }
}
$comment_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero info record ' . executionTime($comment_start, $comment_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>
