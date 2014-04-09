<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * PostController class
 * controller per l'azione di post
 * 
 * @author		Daniele Caldelli
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class PostController extends REST {

    /**
     * @property array Array di config values
     */
    public $config;

    /**
     * Configura oggetto PostController
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "postController.config.json"), false);
    }

    /**
     * Salva un post sul DB mySQL, crea nodi sul grafo, crea relazione nodi utente - nodo post
     * 
     * @todo    testare e prevedere rollback
     */
    public function post() {
	global $controllers;
    try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }
	    if (!isset($this->request['post'])) {
		$this->response(array('status' => $controllers['NOPOST']), 400);
	    } elseif (!isset($this->request['toUser'])) {
		$this->response(array('status' => $controllers['NOTOUSER']), 403);
	    }
	    $fromuserId = $_SESSION['id'];
	    $toUserId = $this->request['toUser'];
	    $postTxt = $_REQUEST['post'];
	    if (strlen($postTxt) < $this->config->minPostSize) {
		$this->response(array('status' => $controllers['SHORTPOST'] . strlen($postTxt)), 406);
	    } elseif (strlen($postTxt) > $this->config->maxPostSize) {
		$this->response(array('status' => $controllers['LONGPOST'] . strlen($postTxt)), 406);
	    }
        $connectionService = new ConnectionService();
        $connection = $connectionService->connect();
        if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $post = new Comment();
	    $post->setActive(1);
	    $post->setAlbum(null);
	    $post->setComment(null);
	    $post->setCommentcounter(0);
	    $post->setCounter(0);
	    $post->setEvent(null);
	    $post->setFromuser($fromuserId);
	    $post->setImage(null);
	    $post->setLatitude(null);
	    $post->setLongitude(null);
	    $post->setLovecounter(0);
	    $post->setRecord(null);
	    $post->setSharecounter(0);
	    $post->setSong(null);
	    $post->setTitle(null);
	    $post->setText($postTxt);
	    $post->setTouser($toUserId);
	    $post->setType('P');
	    $post->setVideo(null);
	    $post->setVote(null);
	    $connection->autocommit(false);
        $connectionService->autocommit(false);
        $resPost = insertComment($connection, $post);
        $node = createNode($connectionService, 'comment', $resPost);
        $relation = createRelation($connectionService, 'user', $fromuserId, 'comment', $resPost, 'ADD');
        if ($resPost === false || $node === false || $relation === false) {
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
        $connectionService->commit();
        }
	    $connectionService->disconnect($connection);
	    $this->response(array('status' => $controllers['POSTSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>