<?php

/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di post
 * \details		effettua il post in bacheca di un utente, istanza della classe Comment con type P
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CONTROLLERS_DIR . 'restController.php';
 

/**
 * \brief	PostController class 
 * \details	controller per l'azione di post
 */
class PostController extends REST {

    public $config;

    /**
     * \fn		construct()
     * \brief   load config file for the controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "postController.config.json"), false);
    }

    /**
     * \fn		post()
     * \brief   save a post an the related activity
     * \todo    usare la sessione
     */
    public function post() {
	global $controllers;

	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    if (!isset($this->request['post'])) {
		$this->response(array('status' => $controllers['NOPOST']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $fromuser = $_SESSION['currentUser'];
	    $toUserObjectId = $this->request['toUser'];
	    $post = $_REQUEST['post'];
	    if (strlen($post) < $this->config->minPostSize) {
		$this->response(array('status' => $controllers['SHORTPOST'] . strlen($post)), 406);
	    } elseif (strlen($post) > $this->config->maxPostSize) {
		$this->response(array('status' => $controllers['LONGPOST'] . strlen($post)), 406);
	    }
	    $cmt = new Comment();
	    $cmt->setActive(true);
	    $cmt->setAlbum(null);
	    $cmt->setComment(null);
	    $cmt->setCommentcounter(0);
	    $cmt->setCounter(0);
	    $cmt->setEvent(null);
	    $cmt->setFromuser($fromuser->getId());
	    $cmt->setImage(null);
	    $cmt->setLocation(null);
	    $cmt->setLovecounter(0);
	    $cmt->setLovers(array());
	    $cmt->setRecord(null);
	    $cmt->setSharecounter(0);
	    $cmt->setSong(null);
	    $cmt->setTag(array());
	    $cmt->setTitle(null);
	    $cmt->setText($post);
	    $cmt->setToUser($toUserObjectId);
	    $cmt->setType('P');
	    $cmt->setVideo(null);
	    $cmt->setVote(null);
	    $commentParse = new CommentParse();
	    $resCmt = $commentParse->saveComment($cmt);
	    if ($resCmt instanceof Error) {
		$this->response(array('status' => $resCmt->getMessageError()), 503);
	    } else {
		require_once CLASSES_DIR . 'activity.class.php';
		require_once CLASSES_DIR . 'activityParse.class.php';
		$activity = new Activity();
		$activity->setActive(true);
		$activity->setAlbum(null);
		$activity->setComment($resCmt->getId());
		$activity->setCounter(0);
		$activity->setEvent(null);
		$activity->setFromuser($fromuser->getId());
		$activity->setImage(null);
		$activity->setPlaylist(null);
		$activity->setQuestion(null);
		$activity->setRead(false);
		$activity->setRecord(null);
		$activity->setSong(null);
		$activity->setStatus('A');
		$activity->setToUser($toUserObjectId);
		$activity->setType('POSTED');
		$activity->setVideo(null);
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error) {
		    require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		    $message = rollbackPostController($resCmt->getId());
		    $this->response(array('status' => $message), 503);
		}
	    }
	    $this->response(array('status' => $controllers['POSTSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>