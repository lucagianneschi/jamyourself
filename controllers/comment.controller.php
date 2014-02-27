<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di inserimento commenti
 * \details		controller di inserimento commenti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		fare API su Wiki; avviare invio mail
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';

/**
 * \brief	CommentController class 
 * \details	controller di inserimento commenti
 */
class CommentController extends REST {

    public $config;

    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "commentController.config.json"), false);
    }

    /**
     * \fn		comment()
     * \brief   salva un commento
     * \todo    testare con sessione
     */
    public function comment() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['comment'])) {
		$this->response(array('status' => $controllers['NOCOMMENT']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    } elseif (!isset($this->request['classType'])) {
		$this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
	    }
	    $fromuser = $_SESSION['currentUser'];
	    $toUserId = $this->request['toUser'];
	    $comment = $this->request['comment'];
	    $classType = $this->request['classType'];
	    $id = $this->request['id'];
	    if (strlen($comment) < $this->config->minCommentSize) {
		$this->response(array('status' => $controllers['SHORTCOMMENT'] . strlen($comment)), 406);
	    } elseif (strlen($comment) > $this->config->maxCommentSize) {
		$this->response(array('status' => $controllers['LONGCOMMENT'] . strlen($comment)), 406);
	    }
	    require_once CLASSES_DIR . 'comment.class.php';
	    $cmt = new Comment();
	    $cmt->setActive(1);
	    $cmt->setCommentcounter(0);
	    $cmt->setFromuser($fromuser->getId());
	    $cmt->setLatitude(null);
	    $cmt->setLongitude(null);
	    $cmt->setLovecounter(0);
	    $cmt->setLovers(array());
	    $cmt->setSharecounter(0);
	    $cmt->setTag(array());
	    $cmt->setTitle(null);
	    $cmt->setText($comment);
	    $cmt->setTouser($toUserId);
	    $cmt->setType('C');
	    $cmt->setVote(null);
	    switch ($classType) {
		case 'Album':
		    require_once CLASSES_DIR . 'album.class.php';
		    $album = new Album();
		    $album->setId($id);
		    $cmt->setAlbum($id);
		    //INCREMENTARE COMMENT COUNTER ALBUM e FARE RELAZIONE USER - ALBUM
		    break;
		case 'Comment':
		    $comment = selectComments($id);
		    if ($comment instanceOf Error) {
			$this->response(array('status' => $comment->getErrorMessage()), 503);
		    }
		    //INCREMENTARE COMMENT COUNTER COMMENT e FARE RELAZIONE USER - COMMENT
		    $cmt->setComment($id);
		    break;
		case 'Event':
		    require_once CLASSES_DIR . 'event.class.php';
		    $event = new Event();
		    $cmt->setEvent($event);
		    //INCREMENTARE COMMENT COUNTER EVENT e FARE RELAZIONE USER - EVENT
		    break;
		case 'Image':
		    require_once CLASSES_DIR . 'image.class.php';
		    $image = new Image();
		    $cmt->setImage($image);
		     //INCREMENTARE COMMENT COUNTER IMAGE e FARE RELAZIONE USER - IMAGE
		    break;
		case 'Record':
		    require_once CLASSES_DIR . 'record.class.php';
		    $record = new Record();
		    $cmt->setRecord($record);
		     //INCREMENTARE COMMENT COUNTER RECORD e FARE RELAZIONE USER - RECORD
		    break;
		case 'Video':
		    require_once CLASSES_DIR . 'video.class.php';
		    $video = new Video();
		    $cmt->setVideo($video);
		     //INCREMENTARE COMMENT COUNTER VIDEO e FARE RELAZIONE USER - VIDEO
		    break;
	    }
	    $resCmt = insertComment($cmt);
	    if ($resCmt instanceof Error) {
		$this->response(array('status' => $resCmt->getErrorMessage()), 503);
	    }
	    global $mail_files;
	    require_once CLASSES_DIR . 'user.class.php';
	    $user = selectUsers($toUserId);
	    $address = $user->getEmail();
	    $subject = $controllers['SBJCOMMENT'];
	    $html = $mail_files['COMMENTEMAIL'];
	    sendMailForNotification($address, $subject, $html);
	    $this->response(array('status' => $controllers['COMMENTSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

}

?>