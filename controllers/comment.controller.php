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
			} elseif (!isset($this->request['objectId'])) {
				$this->response(array('status' => $controllers['NOOBJECTID']), 403);
			} elseif (!isset($this->request['classType'])) {
				$this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
			} 
			
			$fromUser = $_SESSION['currentUser'];
			$fromUserObjectId = $fromUser->getObjectId();
			$toUserObjectId = $this->request['toUser'];
			$comment = $this->request['comment'];
			$classType = $this->request['classType'];
			$objectId = $this->request['objectId'];
			
			
			if (strlen($comment) < $this->config->minCommentSize) {
				$this->response(array('status' => $controllers['SHORTCOMMENT'] . strlen($comment)), 406);
			} elseif (strlen($comment) > $this->config->maxCommentSize) {
				$this->response(array('status' => $controllers['LONGCOMMENT'] . strlen($comment)), 406);
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
			$cmt->setFromUser($fromUser->getObjectId());
			$cmt->setLocation(null);
			$cmt->setLoveCounter(0);
			$cmt->setLovers(null);
			$cmt->setShareCounter(0);
			$cmt->setTags(null);
			$cmt->setTitle(null);
			$encodedText = parse_encode_string($comment);
			$cmt->setText($encodedText);
			$cmt->setToUser($toUserObjectId);
			$cmt->setType('C');
			$cmt->setVote(null);
			
			$activity = new Activity();
			$activity->setActive(true);
			$activity->setCounter(0);
			$activity->setFromUser($fromUser->getObjectId());
			$activity->setPlaylist(null);
			$activity->setQuestion(null);
			$activity->setRead(false);
			$activity->setStatus('A');
			$activity->setToUser($toUserObjectId);
			
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
				$this->response(array('status' => $resCmt->getErrorMessage()), 503);
			} else {
				$activityParse = new ActivityParse();
				$resActivity = $activityParse->saveActivity($activity);
				if ($resActivity instanceof Error) {
					$this->rollback($resCmt->getObjectId());
				}
			}
			$this->response(array('status' => $controllers['COMMENTSAVED']), 200);
		} catch (Exception $e) {
			$this->response(array('status' => $e->getMessage()), 503);
		}
	}

	private function rollback($objectId) {
		global $controllers;
		$commentParse = new CommentParse();
		$res = $commentParse->deleteComment($objectId);
		if ($res instanceof Error) {
			$this->response(array('status' => $controllers['ROLLKO']), 503);
		} else {
			$this->response(array('status' => $controllers['ROLLOK']), 503);
		}
    }
}

?>