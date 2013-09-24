<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di inserimento di una review 
 * \details		inserisce una review ad un evento o ad un record
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

/**
 * \brief	ReviewController class 
 * \details	controller di inserimento di una review 
 */
class ReviewController extends REST {

    public $config;

	/**
	 * \fn		construct()
	 * \brief   load config file for the controller
	 */
    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONTROLLERS_DIR . "config/review.config.json"), false);
    }
	
	/**
	 * \fn		init()
	 * \brief   start the session
	 */
    public function init() {
		session_start();
    }
	
	/**
	 * \fn		review()
	 * \brief   save a review an the related activity
	 * \todo    usare la sessione
	 */
    public function review() {
	
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
			
			$objectId = $_REQUEST['objectId'];
			$classType = $_REQUEST['classType'];
			
			$activity = new Activity();
            $activity->setAccepted(true);
            $activity->setActive(true);
			$activity->setCounter(0);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setRead(true);
            $activity->setStatus("A");
			
			$review = new CommentParse();
			$review->setActive(true);
			$review->setAlbum(null);
			$review->setComment(null);
			$review->setCommentCounter(0);
			$review->setCommentators(null);
			$review->setComments(null);
			$review->setCounter(0);
			//TODO
			//$review->setFromUser($currentUser);
			$review->setFromUser($fromUser->getObjectId());
			 
			$review->setImage(null);
			$review->setLocation(null);
			$review->setLoveCounter(0);
			$review->setLovers(null);
			$review->setOpinions(null);
			$review->setShareCounter(0);
			$review->setSong(null);
			$review->setStatus(null);
			$review->setTags(null);
			$review->setTitle(null);
			$review->setText($text);
			
			#TODO
			//$userParse = new UserParse();
			//$toUser = $userParse->getUser($this->request['fromUser']);
			$review->setToUser($toUser->getObjectId());
			
			$review->setType('P');
			$review->setVideo(null);
			$review->setVote(null);
			
			switch ($classType) {
				case 'Event'://posso fare la recensione di un mio evento??
					$reviewEvent->setEvent($objectId);
					$review->setType('RE');
					$activity->setEvent($objectId);
					$activity->setType("NEWEVENTREVIEW");
					//$event = $eventParse->getEvent($objectId);
					//$activity->setToUser($event->getFromUser());
					break;
				case 'Record'://posso fare la recensione di un mio record??
					$reviewEvent->setRecord($objectId);
					$review->setType('RR');
					$activity->setRecord(($objectId);
					$activity->setType("NEWRECORDREVIEW");
					//$event = $eventParse->getEvent($objectId);
					//$activity->setToUser($event->getFromUser());
					break;
			}
			
			//salvo review
			$commentParse = new CommentParse();
			$res = $commentParse->saveComment($review);
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
			$this->response(array('Your review has been saved'), 200);
	
	}catch (Exception $e) {
            $this->response($e, 503);
        }
	}

}
?>