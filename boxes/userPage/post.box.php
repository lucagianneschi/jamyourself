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
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class PostInfo {

    public $commentCounter;
    public $createdAt;
    public $loveCounter;
    public $shareCounter;
    public $text;
    public $thumbnail;
    public $type;
    public $username;

    function __construct($commentCounter, $createdAt, $loveCounter, $shareCounter, $text, $thumbnail, $type, $username) {
	is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
	is_null($createdAt) ? $this->createdAt = NODATA : $this->createdAt = $createdAt;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($text) ? $this->text = NODATA : $this->text = $text;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($type) ? $this->type = NODATA : $this->type = $type;
	is_null($username) ? $this->username = NODATA : $this->username = $username;
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
		    } else{
			$fromUser = null;
			$thumbnail = null;
			$type = null;
			$username = null;
		    }
		    $commentCounter = $post->getCommentCounter();
		    $createdAt = $post->getCreatedAt()->format('d-m-Y H:i:s');
		    $loveCounter = $post->getLoveCounter();
		    $shareCounter = $post->getShareCounter();
		    $text = $post->getText();

		    $postInfo = new PostInfo($commentCounter, $createdAt, $loveCounter, $shareCounter, $text, $thumbnail, $type, $username);
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