<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box commenti
 * \details		Recupera le informazioni del commento e le mette in oggetto commentBox
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
 * \brief	CommentInfo class 
 * \details	contains info for comment to be displayed 
 */
class CommentInfo {

    public $fromUserInfo;
    public $createdAt;
    public $text;

    /**
     * \fn	__construct($fromUserInfo, $createdAt, $text)
     * \brief	construct for the CommentInfo class
     * \param	$fromUserInfo, $createdAt, $text
     */
    function __construct($fromUserInfo, $createdAt, $text) {
	global $boxes;
	is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
	is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = $text;
    }

}

/**
 * \brief	CommentBox class 
 * \details	box class to pass info to the view 
 * \todo	usare whereInclude per il fromUSer per evitare di fare una ulteriore get 
 */
class CommentBox {

	public $config;
    public $commentInfoArray;

	function __construct() {
		$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/comment.config.json"), false);
    }
    /**
     * \fn	init($className,$objectId)
     * \brief	Init CommentBox instance all over the website
     * \param	$className for the instance of the class that has been commented, $objectId for object that has been commented
     * \return	commentBox
     */
    public function init($className, $objectId) {
	global $boxes;
	$commentBox = new CommentBox();
	$info = array();
	$commentP = new CommentParse();
	switch ($className) {
	    case 'Album':
		$field = 'album';
		$commentP->setLimit($this->config->limitForAlbum);
		break;
	    case 'Comment':
		$field = 'comment';
		$commentP->setLimit($this->config->limitForComment);
		break;
	    case 'Event':
		$field = 'event';
		$commentP->setLimit($this->config->limitForEvent);
		break;
	    case 'Image':
		$field = 'image';
		$commentP->setLimit($this->config->limitForImage);
		break;
	    case 'Record':
		$field = 'record';
		$commentP->setLimit($this->config->limitForRecord);
		break;
	    case 'Song':
		$field = 'song';
		$commentP->setLimit($this->config->limitForSong);
		break;
	    case 'Video':
		$field = 'video';
		$commentP->setLimit($this->config->limitForVideo);
		break;
	}
	$commentP->wherePointer($field, $className, $objectId);
	$commentP->where('type', 'C');
	$commentP->where('active', true);
	$commentP->whereInclude('fromUser');
	$commentP->orderByAscending('createdAt');
	$comments = $commentP->getComments();
	if (get_class($comments) == 'Error') {
	    return $comments;
	}elseif(count($comments) == 0){
		$commentBox->commentInfoArray = $boxes['NODATA'];
	} else {
	    foreach ($comments as $comment) {
		$createdAt = $comment->getCreatedAt()->format('d-m-Y H:i:s');
		$encodedText = $comment->getText();
		$text = parse_decode_string($encodedText);
		$objectId = $comment->getFromUser()->getObjectId();
		$thumbnail = $comment->getFromUser()->getProfileThumbnail();
		$type = $comment->getFromUser()->getType();
		$encodedUsername = $comment->getFromUser()->getUsername();
		$username = parse_decode_string($encodedUsername);
		$fromUserInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		$commentInfo = new CommentInfo($fromUserInfo, $createdAt, $text);
		array_push($info, $commentInfo);
	    }
		$commentBox->commentInfoArray = $info;
	}
	return $commentBox;
    }

}

?>