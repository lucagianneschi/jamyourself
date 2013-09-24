<?php
/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di post
 * \details		effettua il post in bacheca di un utente, istanza della classe Comment con type P
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
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
        $this->config = json_decode(file_get_contents(CONTROLLERS_DIR . "post/post.config.json"), false);
    }
	
	/**
	 * \fn		init()
	 * \brief   start the session
	 */
    public function init() {
        session_start();
    }

	/**
	 * \fn		post()
	 * \brief   save a post an the related activity
	 * \todo    usare la sessione
	 */
    public function post() {
		
		#TODO
		//in questa fase di debug, il fromUser e il toUser sono uguali e passati staticamente
		//questa sezione prima del try-catch dovrà sparire
		$userParse = new UserParse();
		$fromUser = $userParse->getUser($this->request['fromUser']);
		$toUser = $fromUser;
		
		try {
            //controllo la richiesta
			//if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
			if ($this->get_request_method() != "POST") {
				$this->response('', 406);
			}

			//controllo i parametri
			if (!isset($this->request['text'])) {
				$this->response(array('status' => "Bad Request", "msg" => "No comment specified"), 400);
			} elseif (!isset($this->request['toUser'])) {
				$this->response(array('status' => "Bad Request", "msg" => "No toUser specified"), 400);
			} elseif (!isset($this->request['fromUser'])) {
				$this->response(array('status' => "Bad Request", "msg" => "No fromUser specified"), 400);
			}
			
			//recupero l'utente che effettua il commento
			//$currentUser = $_SESSION['currentUser'];
		
			//recupero e controllo il post
			$text = $_REQUEST['text'];
			if (strlen($text) < $this->config->minPostSize) {
				$this->response(array("Dimensione post troppo corta | lungh: ".strlen($text)), 200);
			} elseif (strlen($text) > $this->config->maxPostSize) {
				$this->response(array("Dimensione post troppo lunga | lungh: ".strlen($text)), 200);
			} 
			
			//imposto i valori per il salvataggio del post

			$cmt = new Comment();
			$cmt->setActive(true);
			$cmt->setAlbum(null);
			$cmt->setComment(null);
			$cmt->setCommentCounter(0);
			$cmt->setCommentators(null);
			$cmt->setComments(null);
			$cmt->setCounter(0);
			$cmt->setEvent(null);
			
			#TODO
			//$cmt->setFromUser($currentUser);
			$cmt->setFromUser($fromUser->getObjectId());
			
			$cmt->setImage(null);
			$cmt->setLocation(null);
			$cmt->setLoveCounter(0);
			$cmt->setLovers(null);
			$cmt->setOpinions(null);
			$cmt->setRecord(null);
			$cmt->setShareCounter(0);
			$cmt->setSong(null);
			$cmt->setStatus(null);
			$cmt->setTags(null);
			$cmt->setTitle(null);
			$cmt->setText($text);
			
			#TODO
			//$userParse = new UserParse();
			//$toUser = $userParse->getUser($this->request['fromUser']);
			$cmt->setToUser($toUser->getObjectId());
			
			$cmt->setType('P');
			$cmt->setVideo(null);
			$cmt->setVote(null);
			
			//imposto i valori per il salvataggio dell'activity collegata al post
			$activity = new Activity();
			$activity->setActive(true);
			$activity->setAccepted(true);
			$activity->setAlbum(null);
			$activity->setComment(null);
			$activity->setCounter(0);
			$activity->setEvent(null);
			
			#TODO
			//$activity->setFromUser($currentUser);
			$activity->setFromUser($fromUser->getObjectId());

			$activity->setImage(null);
			$activity->setPlaylist(null);
			$activity->setQuestion(null);
			$activity->setRead(false);
			$activity->setRecord(null);
			$activity->setSong(null);
			$activity->setStatus('A');
			$activity->setToUser(null);
			$activity->setType('POSTED');
			$activity->setUserStatus(null); 
			$activity->setVideo(null);
			
			//salvo post
			$commentParse = new CommentParse();
			$res = $commentParse->saveComment($cmt);
			if (get_class($res) == 'Error') {
				$this->response(array($res), 503);
			}
			
			//salvo activity
			$activityParse = new ActivityParse();
			$res = $activityParse->saveActivity($activity);
			if (get_class($res) == 'Error') {
				$this->response(array($res), 503);
			}
			
			//risposta
			$this->response(array('Your post has been saved'), 200);
		} catch (Exception $e) {
            $this->response($e, 503);
        }
    }
}

?>