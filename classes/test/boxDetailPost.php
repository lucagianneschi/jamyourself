<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Box Album
 * \details		Box per mostrare gli ultimi album inseriti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

$idPost = '7wi6AvviK4';
$parseCommentOnPost = new CommentParse();
$parseCommentOnPost->whereRelatedTo('comments', 'Comment', $idPost);
$parseCommentOnPost->orderByDescending('createdAt');
$commentsOnPost = $parseCommentOnPost->getComments();
foreach ($commentsOnPost as $comment) {
    $user = new UserParse();
    $userStamp = $user->getUser($comment->getFromUser());
    echo '<br />[username] => ' . $userStamp->getUsername() . '<br />';
    echo '<br />[type] => ' . $userStamp->getType() . '<br />';
    echo '<br />[thumb] => ' . $userStamp->getProfileThumbnail() . '<br />';
    echo '<br />[testo] => ' . $comment->getText() . '<br />';
    echo '<br />[data creazione] => ' . $comment->getCreatedAt() . '<br />';
}
?>
