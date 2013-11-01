<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di inserimento commenti
 * \details		controller di inserimento commenti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once DEBUG_DIR . 'debug.php';

/**
 * \brief	CommentController class 
 * \details	controller di inserimento commenti
 */
class CommentController extends REST {

    public $config;

    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/comment.config.json"), false);
    }

    /**
     * \fn		comment()
     * \brief   salva un commento
     * \todo    testare con sessione
     */
    public function sendComment() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['text'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOCOMMENT']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSER']), 403);
	    } elseif (!isset($this->request['classType'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOCLASSTYPE']), 403);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => "Bad Request", "msg" => $controllers['NOOBJECTID']), 403);
	    }
	    $fromUser = $this->request['currentUser'];
	    $fromUserId = $fromUser->getObjectId();
	    $toUserId = $this->request['toUser']; //mi passo solo l'ID
	    $text = $this->request['text'];
	    $classType = $this->request['classType'];
	    $objectId = $this->request['$objectId'];
	    if (strlen($text) < $this->config->minCommentSize) {
		$this->response(array($controllers['SHORTCOMMENT'] . strlen($text)), 406);
	    } elseif (strlen($text) > $this->config->maxCommentSize) {
		$this->response(array($controllers['LONGCOMMENT'] . strlen($text)), 406);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    require_once CLASSES_DIR . 'comment.class.php';
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    require_once CONTROLLERS_DIR . 'utilsController.php';
	    require_once SERVICES_DIR . 'mail.service.php';
	    $cmt = new Comment();
	    $cmt->setActive(true);
	    $cmt->setCommentCounter(0);
	    $cmt->setCommentators(null);
	    $cmt->setComments(null);
	    $cmt->setFromUser($fromUserId);
	    $cmt->setLocation(null);
	    $cmt->setLoveCounter(0);
	    $cmt->setLovers(null);
	    $cmt->setShareCounter(0);
	    $cmt->setTags(null);
	    $cmt->setTitle(null);
	    $encodedText = parse_encode_string($text);
	    $cmt->setText($encodedText);
	    $cmt->setToUser($toUserId);
	    $cmt->setType('C');
	    $cmt->setVote(null);
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setCounter(0);
	    $activity->setFromUser($fromUserId);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRead(false);
	    $activity->setStatus('A');
	    $activity->setToUser($toUserId);
	    switch ($classType) {
		case 'Album':
		    $cmt->setAlbum($objectId);
		    $activity->setAlbum($objectId);
		    $activity->setType('COMMENTEDONALBUM');
		    break;
		case 'Comment':
		    $cmt->setComment($objectId);
		    $activity->setComment($objectId);
		    $activity->setType('COMMENTEDONCOMMENT');
		    break;
		case 'Event':
		    $cmt->setEvent($objectId);
		    $activity->setEvent($objectId);
		    $activity->setType('COMMENTEDONEVENT');
		    break;
		case 'Image':
		    $cmt->setImage($objectId);
		    $activity->setImage($objectId);
		    $activity->setType('COMMENTEDONIMAGE');
		    break;
		case 'Status':
		    $cmt->setStatus($objectId);
		    $activity->setUserStatus($objectId);
		    $activity->setType('COMMENTEDONSTATUS');
		    break;
		case 'Record':
		    $cmt->setRecord($objectId);
		    $activity->setRecord($objectId);
		    $activity->setType('COMMENTEDONRECORD');
		    break;
		case 'Video':
		    $cmt->setVideo($objectId);
		    $activity->setVideo($objectId);
		    $activity->setType('COMMENTEDONVIDEO');
		    break;
	    }
	    $commentParse = new CommentParse();
	    $resCmt = $commentParse->saveComment($cmt);
	    if ($resCmt instanceof Error) {
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error) {
		    $this->rollback($resCmt->getObjectId());
		}
	    }
	    $this->response(array($controllers['COMMENTSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
	}
    }

    private function rollback($objectId) {
	global $controllers;
	$commentParse = new CommentParse();
	$res = $commentParse->deleteComment($objectId);
	if ($res instanceof Error) {
	    $this->response(array($controllers['ROLLKO']), 503);
	} else {
	    $this->response(array($controllers['ROLLOK']), 503);
	}
    }

}

?>