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
	is_null($fromUserInfo) ? $this->fromUserInfo = NODATA : $this->fromUserInfo = $fromUserInfo;
	is_null($createdAt) ? $this->createdAt = NODATA : $this->createdAt = $createdAt;
	is_null($text) ? $this->text = NODATA : $this->text = $text;
    }

}

/**
 * \brief	CommentBox class 
 * \details	box class to pass info to the view 
 */
class CommentBox {

    public $commentInfoArray;

    /**
     * \fn	init($className,$objectId)
     * \brief	Init CommentBox instance all over the website
     * \param	$className fot the istance of the class that has been commented, $objectId for object that has been commented
     * \return	commentBox
     */
    public function init($className, $objectId) {

	$commentBox = new CommentBox();
	$info = array();
	switch ($className) {
	    case 'Album':
		$field = 'album';
		break;
	    case 'Comment':
		$field = 'comment';
		break;
	    case 'Event':
		$field = 'event';
		break;
	    case 'Image':
		$field = 'image';
		break;
	    case 'Record':
		$field = 'record';
		break;
	    case 'Song':
		$field = 'song';
		break;
	    case 'Video':
		$field = 'video';
		break;
	}

	$commentP = new CommentParse();
	$commentP->wherePointer($field, $className, $objectId);
	$commentP->where('type', 'C');
	$commentP->where('active', true);
	$commentP->setLimit(1000);
	$commentP->orderByDescending('createdAt');
	$comments = $commentP->getComments();
	if (get_class($comments) == 'Error') {
	    return $comments;
	} else {
	    foreach ($comments as $comment) {

		$createdAt = $comment->getCreatedAt()->format('d-m-Y H:i:s');
		$encodedText = $comment->getText();
		$text = parse_decode_string($encodedText);

		$fromUserId = $comment->getFromUser();

		$userP = new UserParse();
		$user = $userP->getUser($fromUserId);
		if (get_class($user) == 'Error') {
		    return $user;
		} else {
		    $objectId = $user->getObjectId();
		    $thumbnail = $user->getProfileThumbnail();
		    $type = $user->getType();
			$encodedUsername = $user->getUsername();
		    $username = parse_decode_string($encodedUsername);
		    $fromUserInfo = new UserInfo($objectId, $thumbnail, $type, $username);
		}

		$commentInfo = new CommentInfo($fromUserInfo, $createdAt, $text);
		array_push($info, $commentInfo);
	    }
		if(empty($info)){
			$commentBox->commentInfoArray = NODATA;
		} else {
			$commentBox->commentInfoArray = $info;
		}
	}
	return $commentBox;
    }

}

?>