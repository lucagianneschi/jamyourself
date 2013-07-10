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

$id = '7wi6AvviK4';
echo '<br />----------------------BOX------------POST---------------------------<br />';
$parsePost = new CommentParse();
$parsePost->wherePointer('fromUser', '_User', $id);
$parsePost->where('type', 'P');
$parsePost->setLimit(3);
$parsePost->orderByDescending('createdAt');
$last3post =$parsePost->getComments();
foreach ($last3post as $post) {
    $user = new UserParse();
    $userStamp = $user->getUser($post->getFromUser());
    echo '<br />[username] => ' . $userStamp->getUsername() . '<br />';
    echo '<br />[type] => ' . $userStamp->getType() . '<br />';
    echo '<br />[thumb] => ' . $userStamp->getProfileThumbnail() . '<br />';
    echo '<br />[testo] => ' . $post->getText() . '<br />';
    echo '<br />[data creazione] => ' . $post->getCreatedAt() . '<br />';
    echo '<br />[loveCounter] => ' . $post->getLoveCounter() . '<br />';
    echo '<br />[shareCounter] => ' . $post->getShareCounter() . '<br />';
    echo '<br />[commentCounter] => ' . $post->getCommentCounter() . '<br />';
    
}
echo '<br />----------------------BOX------------POST---------------------------<br />';
?>
