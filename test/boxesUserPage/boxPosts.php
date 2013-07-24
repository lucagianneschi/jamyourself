<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Post
 * \details		Recupera gli ultimi 3 post attivi (valido per ogni tipologia di utente)
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
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();

$id = '7fes1RyY77';//LDF
$userParse = new UserParse();
$user = $userParse->getUser($id);

$post_start = microtime();
$parsePost = new CommentParse();
$parsePost->wherePointer('toUser', '_User', $id);
$parsePost->where('type', 'P');
$parsePost->where('active', true);
$parsePost->setLimit(3);
$parsePost->whereInclude('fromUser');
$parsePost->orderByDescending('createdAt');
$last3post = $parsePost->getComments();
if ($last3post != 0) {
    if (get_class($last3post) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last3post->getErrorMessage() . '<br/>';
    } else {

	foreach ($last3post->fromUser as $fromUser) {
	    echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
	    echo '<br />[type] => ' . $fromUser->getType() . '<br />';
	    echo '<br />[thumb] => ' . $fromUser->getProfileThumbnail() . '<br />';
	}
	foreach ($last3post as $post) {
	    echo '<br />[testo] => ' . $post->getText() . '<br />';
	    echo '<br />[data creazione] => ' . $post->getCreatedAt() . '<br />';
	    echo '<br />[loveCounter] => ' . $post->getLoveCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $post->getShareCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $post->getCommentCounter() . '<br />';
	}
    }
}
$post_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post_start, $post_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>