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
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once SERVICES_DIR . 'mail.service.php';

/**
 * \brief	CommentController class 
 * \details	controller di inserimento commenti
 */
class CommentController extends REST {

    public $config;

    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONTROLLERS_DIR . "config/comment.config.json"), false);
    }

    /**
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
	session_start();
    }

    /**
     * \fn		comment()
     * \brief   salva un commento
     * \todo    usare la sessione
     */
    public function comment() {
	#TODO
	//in questa fase di debug, il fromUser lo passo staticamente e non lo recupero dalla session
	//questa sezione prima del try-catch dovrà sparire
	require_once CLASSES_DIR . 'user.class.php';
	$currentUser = new User('SPOTTER');
	$currentUser->setObjectId('GuUAj83MGH');

	try {
	    //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
	    if ($this->get_request_method() != 'POST') {
		$this->response('', 406);
	    }

	    if (!isset($this->request['text'])) {
		$this->response(array('status' => "Bad Request", "msg" => "No comment specified"), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => "Bad Request", "msg" => "No toUser specified"), 400);
	    }

	    $text = $_REQUEST['text'];
	    if (strlen($text) < $this->config->minCommentSize) {
		$this->response(array("Dimensione commento troppo corta | lungh: " . strlen($text)), 200);
	    } elseif (strlen($text) > $this->config->maxCommentSize) {
		$this->response(array("Dimensione commento troppo lunga | lungh: " . strlen($text)), 200);
	    }

	    $objectId = $_REQUEST['objectId'];
	    $classType = $_REQUEST['classType'];

	    $cmt = new Comment();
	    $cmt->setActive(true);
	    $cmt->setCommentCounter(0);
	    $cmt->setCommentators(null);
	    $cmt->setComments(null);

	    #TODO
	    //$cmt->setFromUser($currentUser->getObjectId());
	    $cmt->setFromUser('GuUAj83MGH');
	    $cmt->setLocation(null);
	    $cmt->setLoveCounter(0);
	    $cmt->setLovers(null);
	    $cmt->setOpinions(null);
	    $cmt->setShareCounter(0);
	    $cmt->setTags(null);
	    $cmt->setTitle(null);
	    $cmt->setText($text);
	    $cmt->setToUser('GuUAj83MGH');
	    $cmt->setType('C');
	    $cmt->setVote(null);

	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAccepted(true);
	    $activity->setCounter(0);

	    #TODO
	    //$activity->setFromUser($currentUser);
	    $activity->setFromUser('GuUAj83MGH');
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRead(false); //OK?
	    $activity->setStatus('A');

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
		    $activity->setStatus($objectId);
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
	    if (get_class($resCmt) == 'Error') {
		$this->response(array($resCmt), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if (get_class($resActivity) == 'Error') {
		    $this->rollback($resCmt->getObjectId());
		}
	    }
	    $this->response(array('Your comment has been saved'), 200);
	} catch (Exception $e) {
	    $this->response(array('Error: ' . $e->getMessage()), 503);
	}
    }

    private function rollback($objectId) {
	$commentParse = new CommentParse();
	$res = $commentParse->deleteComment($objectId);
	if (get_class($res) == 'Error') {
	    $this->response(array("Rollback KO"), 503);
	} else {
	    $this->response(array("Rollback OK"), 503);
	}
    }

}

?>