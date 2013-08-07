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
 * \todo        
 *
 */


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utils.box.php';

class PostInfo {

    public $counters;
    public $createdAt;
    public $fromUserInfo;
    public $text;

    function __construct($counters, $createdAt, $fromUserInfo, $text) {
	is_null($counters) ? $this->counters = NODATA : $this->counters = $counters;
	is_null($createdAt) ? $this->createdAt = NODATA : $this->createdAt = $createdAt;
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($text) ? $this->text = NODATA : $this->text = $text;
    }

}

class PostBox {

    public $postInfoArray;
    public $postCounter;

    public function init($objectId) {

	$postBox = new PostBox();
	$info = array();
	$counter = 0;

	$post = new CommentParse();
	$post->wherePointer('toUser', '_User', $objectId);
	$post->where('type', 'P');
	$post->where('active', true);
	$post->setLimit(1000);
	$post->whereInclude('fromUser');
	$post->orderByDescending('createdAt');
	$lastposts = $post->getComments();
	if (count($lastposts) != 0) {
	    if (get_class($lastposts) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $lastposts->getErrorMessage() . '<br/>';
	    } else {
		for ($i = 0; i < count($lastposts); ++$i) {
		    $counter = ++$counter;

		    $post = $lastposts[$i];

		    if ($post->fromUser != null) {
			$fromUser = $post->fromUser;
			$thumbnail = $fromUser->getProfileThumbnail();
			$type = $fromUser->getType();
			$username = $fromUser->getUsername();
		    } else {
			$thumbnail = null;
			$type = null;
			$username = null;
		    }
		    $fromUserInfo = new UserInfo($thumbnail, $type, $username);
		    $commentCounter = $post->getCommentCounter();
		    $createdAt = $post->getCreatedAt()->format('d-m-Y H:i:s');
		    $loveCounter = $post->getLoveCounter();
		    $shareCounter = $post->getShareCounter();
		    $text = $post->getText();
		    $counters = new Counters($commentCounter, $loveCounter, $shareCounter);

		    $postInfo = new PostInfo($counters, $createdAt, $fromUserInfo, $text);
		    array_push($info, $postInfo);
		}
		$postBox->postInfoArray = $info;
		$postBox->postCounter = $counter;
	    }
	}
	return $postBox;
    }

}

?>