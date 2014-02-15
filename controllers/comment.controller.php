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
require_once CONTROLLERS_DIR . 'utilsController.php';

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
	    $toUserObjectId = $this->request['toUser'];
	    $comment = $this->request['comment'];
	    $classType = $this->request['classType'];
	    $id = $this->request['id'];
	    if (strlen($comment) < $this->config->minCommentSize) {
		$this->response(array('status' => $controllers['SHORTCOMMENT'] . strlen($comment)), 406);
	    } elseif (strlen($comment) > $this->config->maxCommentSize) {
		$this->response(array('status' => $controllers['LONGCOMMENT'] . strlen($comment)), 406);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    require_once CLASSES_DIR . 'comment.class.php';
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    $cmt = new Comment();
	    $cmt->setActive(true);
	    $cmt->setCommentcounter(0);
	    $cmt->setFromuser($fromuser->getId());
	    $cmt->setLocation(null);
	    $cmt->setLovecounter(0);
	    $cmt->setLovers(array());
	    $cmt->setSharecounter(0);
	    $cmt->setTag(array());
	    $cmt->setTitle(null);
	    $cmt->setText($comment);
	    $cmt->setTouser($toUserObjectId);
	    $cmt->setType('C');
	    $cmt->setVote(null);
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setCounter(0);
	    $activity->setFromuser($fromuser->getId());
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRead(false);
	    $activity->setStatus('A');
	    $activity->setTouser($toUserObjectId);
	    switch ($classType) {
		case 'Album':
		    require_once CLASSES_DIR . 'albumParse.class.php';
		    $albumParse = new AlbumParse();
		    $res = $albumParse->incrementAlbum($id, 'commentCounter', 1);
		    $cmt->setAlbum($id);
		    $activity->setAlbum($id);
		    $activity->setType('COMMENTEDONALBUM');
		    break;
		case 'Comment':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $comment = $commentParse->getComment($id);
		    if ($comment instanceOf Error) {
			$this->response(array('status' => $comment->getErrorMessage()), 503);
		    }
		    $res = $commentParse->incrementComment($id, 'commentCounter', 1);
		    $cmt->setComment($id);
		    $activity->setComment($id);
		    switch ($comment->getType()) {
			case 'P':
			    $activity->setType('COMMENTEDONPOST');
			    break;
			case 'RE':
			    $activity->setType('COMMENTEDONEVENTREVIEW');
			    break;
			case 'RR':
			    $activity->setType('COMMENTEDONRECORDREVIEW');
			    break;
		    }
		    break;
		case 'Event':
		    require_once CLASSES_DIR . 'eventParse.class.php';
		    $eventParse = new EventParse();
		    $res = $eventParse->incrementEvent($id, 'commentCounter', 1);
		    $cmt->setEvent($id);
		    $activity->setEvent($id);
		    $activity->setType('COMMENTEDONEVENT');
		    break;
		case 'Image':
		    require_once CLASSES_DIR . 'imageParse.class.php';
		    $imageParse = new ImageParse();
		    $res = $imageParse->incrementImage($id, 'commentCounter', 1);
		    $cmt->setImage($id);
		    $activity->setImage($id);
		    $activity->setType('COMMENTEDONIMAGE');
		    break;
		case 'Record':
		    require_once CLASSES_DIR . 'recordParse.class.php';
		    $recordParse = new RecordParse();
		    $res = $recordParse->incrementRecord($id, 'commentCounter', 1);
		    $cmt->setRecord($id);
		    $activity->setRecord($id);
		    $activity->setType('COMMENTEDONRECORD');
		    break;
		case 'Video':
		    require_once CLASSES_DIR . 'videoParse.class.php';
		    $videoParse = new VideoParse();
		    $res = $videoParse->incrementVideo($id, 'commentCounter', 1);
		    $cmt->setVideo($id);
		    $activity->setVideo($id);
		    $activity->setType('COMMENTEDONVIDEO');
		    break;
	    }
	    $commentParse = new CommentParse();
	    $resCmt = $commentParse->saveComment($cmt);
	    if ($resCmt instanceof Error) {
		$this->response(array('status' => $resCmt->getErrorMessage()), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error || $res instanceof Error) {
		    require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		    $message = rollbackCommentController($id, $classType);
		    $this->response(array('status' => $message), 503);
		}
	    }
	    global $mail_files;
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    $user = $userParse->getUser($toUserObjectId);
	    $address = $user->getEmail();
	    $subject = $controllers['SBJCOMMENT'];
	    $html = $mail_files['COMMENTEMAIL'];
	    sendMailForNotification($address, $subject, $html);
	    $this->response(array('status' => $res), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getErrorMessage()), 503);
	}
    }

}

?>