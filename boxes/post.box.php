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

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	PostInfo class 
 * \details	contains info for post to be displayed 
 */
class PostInfo {

    public $counters;
    public $createdAt;
    public $fromUserInfo;
    public $text;

    /**
     * \fn	__construct($counters, $createdAt, $fromUserInfo, $text)
     * \brief	construct for the PostInfo class
     * \param	$counters, $createdAt, $fromUserInfo, $text
     */
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

    /**
     * \fn	initForPersonalPage($objectId)
     * \brief	Init PostBox instance for Personal Page
     * \param	$objectId for user that owns the page
     * \return	postBox
     */
    public function initForPersonalPage($objectId) {
	$postBox = new PostBox();
	$info = array();
	$counter = 0;
	$value = array(array('fromUser' => $objectId), array('toUser' => $objectId));

	$post = new CommentParse();
	$post->whereOr($value);
	$post->where('type', 'P');
	$post->where('active', true);
	$post->setLimit(1000);
	$post->whereInclude('fromUser');
	$post->orderByDescending('createdAt');
	$posts = $post->getComments();
	if (get_class($posts) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $posts->getErrorMessage() . '<br/>';
	} else {
	    for ($i = 0; i < count($posts); ++$i) {
		$counter = ++$counter;
		$post = $posts[$i];
		if ($post->fromUser) {
		    $fromUser = $post->fromUser;
			$objectId = $fromUser->getObjectId();
		    $thumbnail = $fromUser->getProfileThumbnail();
		    $type = $fromUser->getType();
			$encodedUsername = $fromUser->getUsername();
		    $username = parse_decode_string($encodedUsername);
		}
		$fromUserInfo = new UserInfo($thumbnail, $type, $username);

		$commentCounter = $post->getCommentCounter();
		$createdAt = $post->getCreatedAt()->format('d-m-Y H:i:s');
		$loveCounter = $post->getLoveCounter();
		$reviewCounter = NDB;
		$shareCounter = $post->getShareCounter();
		$encodedtext = $post->getText();
		$text = parse_decode_string($encodedtext);
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$postInfo = new PostInfo($counters, $createdAt, $fromUserInfo, $text);
		array_push($info, $postInfo);
	    }
	    $postBox->postInfoArray = $info;
	    $postBox->postCounter = $counter;
	}

	return $postBox;
    }

}

?>