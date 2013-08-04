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
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class CommentInfo {

    public $createdAt;
    public $text;
    public $thumbnail;
    public $type;
    public $username;

    function __construct($createdAt, $text, $thumbnail, $type, $username) {
	is_null($createdAt) ? $this->createdAt = NODATA : $this->createdAt = $createdAt;
	is_null($text) ? $this->text = NODATA : $this->text = $text;
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($type) ? $this->type = NODATA : $this->type = $type;
	is_null($username) ? $this->username = NODATA : $this->username = $username;
    }

}

class CommentBox {

    public $commentInfoArray;

    public function init($className, $objectId) {

	$commentBox = new CommentBox();
	$info = array();
	switch ($className) {
	    case 'Album':
		$field = 'image';
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
	    default:
		break;
	}

	$commentP = new CommentParse();
	$commentP->whereRelatedTo($field, $className, $objectId);
	$commentP->where('active', true);
	$commentP->setLimit(1000);
	$commentP->orderByDescending('createdAt');
	$commentP->whereInclude('fromUser');
	$comments = $commentP->getComments();
	if (count($comments) != 0) {
	    if (get_class($comments) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $comments->getErrorMessage() . '<br/>';
	    } else {
		for ($i = 0; i < count($comments); ++$i) {
		    $comment = $comments[$i];

		    $createdAt = $comment->getCreatedAt()->format('d-m-Y H:i:s');
		    $text = $comment->getText();

		    $userP = new UserParse();
		    $fromUser = $userP->getUser($comment->fromUser);
		    $thumbnail = $fromUser->getProfileThumbnail();
		    $type = $fromUser->getType();
		    $username = $fromUser->getUsername();

		    $commentInfo = new CommentInfo($createdAt, $text, $thumbnail, $type, $username);
		    array_push($info, $commentInfo);
		}
		$commentBox->commentInfoArray = $info;
	    }
	}
	return $commentBox;
    }

}

?>