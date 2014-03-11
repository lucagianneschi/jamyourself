<?php

/* ! \par		Info Generali:
 * @author		Daniele Caldelli
 * @version		0.3
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di post
 * \details		effettua il post in bacheca di un utente, istanza della classe Comment con type P
 * \par			Commenti:
 * @warning
 * @bug
 * @todo		fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
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
     * \fn	post()
     * \brief   save a post an the related activity
     * @todo    salvare il post sul db relazionale
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
	    $fromuser = $_SESSION['id'];
	    $toUserId = $this->request['toUser'];
	    $post = $_REQUEST['post'];
	    if (strlen($post) < $this->config->minPostSize) {
		$this->response(array('status' => $controllers['SHORTPOST'] . strlen($post)), 406);
	    } elseif (strlen($post) > $this->config->maxPostSize) {
		$this->response(array('status' => $controllers['LONGPOST'] . strlen($post)), 406);
	    }
	    $cmt = new Comment();
	    $cmt->setActive(1);
	    $cmt->setAlbum(null);
	    $cmt->setComment(null);
	    $cmt->setCommentcounter(0);
	    $cmt->setCounter(0);
	    $cmt->setEvent(null);
	    $cmt->setFromuser($fromuser->getId());
	    $cmt->setImage(null);
	    $cmt->setLatitude(null);
	    $cmt->setLongitude(null);
	    $cmt->setLovecounter(0);
	    $cmt->setRecord(null);
	    $cmt->setSharecounter(0);
	    $cmt->setSong(null);
	    $cmt->setTitle(null);
	    $cmt->setText($post);
	    $cmt->setTouser($toUserId);
	    $cmt->setType('P');
	    $cmt->setVideo(null);
	    $cmt->setVote(null);
	    $id = insertComment($cmt);
	    $node = createNode('post', $cmt->getId());
	    if ($id instanceof Error) {
		$this->response(array('status' => $id->getMessage()), 503);
	    }
	    if(!$node){
		$this->response(array('status' => $controllers['NODEERROR']), 503);
	    }
	    $this->response(array('status' => $controllers['POSTSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>