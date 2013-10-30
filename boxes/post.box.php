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
 * \todo		uso whereIncude        
 *
 */


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	PostInfo class 
 * \details	contains info for post to be displayed 
 */
class PostInfo {

    public $counters;
    public $createdAt;
    public $fromUserInfo;
    public $objectId;
    public $text;

    /**
     * \fn	__construct($counters, $createdAt, $fromUserInfo, $text)
     * \brief	construct for the PostInfo class
     * \param	$counters, $createdAt, $fromUserInfo, $text
     */
    function __construct($counters, $createdAt, $fromUserInfo, $objectId, $text) {
	global $boxes;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
	is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = $text;
    }

}

class PostBox {

    public $config;
    public $postInfoArray;
    //public $postCounter;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/post.config.json"), false);
    }

    /**
     * \fn	initForPersonalPage($objectId)
     * \brief	Init PostBox instance for Personal Page
     * \param	$objectId for user that owns the page
     * \return	postBox
     * \todo	usare whereInclude per il fromUser per avere una get in meno
     */
    public function initForPersonalPage($objectId) {
	global $boxes;
	$postBox = new PostBox();
	$info = array();
	//$counter = 0;
	$value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)),
	    array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)));
	$post = new CommentParse();
	$post->whereOr($value);
	$post->where('type', 'P');
	$post->where('active', true);
	$post->whereInclude('fromUser,toUser');
	$post->setLimit($this->config->limitForPersonalPage);
	$post->orderByDescending('createdAt');
	$posts = $post->getComments();
	if (get_class($posts) == 'Error') {
	    return $posts;
	} elseif (is_null($posts)) {
	    $postBox->postInfoArray = $boxes['NODATA'];
	    //$postBox->postCounter = $boxes['NODATA'];
	} else {
	    foreach ($posts as $post) {
		$counter = ++$counter;
		$objectId = $post->getFromUser()->getObjectId();
		$thumbnail = $post->getFromUser()->getProfileThumbnail();
		$type = $post->getFromUser()->getType();
		$encodedUsername = $post->getFromUser()->getUsername();
		$username = parse_decode_string($encodedUsername);
		$fromUserInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		$postId = $post->getObjectId();
		$commentCounter = $post->getCommentCounter();
		$createdAt = $post->getCreatedAt()->format('d-m-Y H:i:s');
		$loveCounter = $post->getLoveCounter();
		$reviewCounter = $boxes['NDB'];
		$shareCounter = $post->getShareCounter();
		$encodedtext = $post->getText();
		$text = parse_decode_string($encodedtext);
		$counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
		$postInfo = new PostInfo($counters, $createdAt, $fromUserInfo, $postId, $text);
		array_push($info, $postInfo);
	    }
	    $postBox->postInfoArray = $info;
	    //$postBox->postCounter = $counter;
	}
	return $postBox;
    }

}

?>