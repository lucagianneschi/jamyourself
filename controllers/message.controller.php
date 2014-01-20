<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller per l'azione di mesaggio
 * \details		invia il messaggio e corrispondente activity;legge il messaggio
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		testare
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'relationChecker.service.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	MessageController class 
 * \details	controller per l'invio di messaggi
 */
class MessageController extends REST {

    public $config;

    /**
     * \fn		construct()
     * \brief   load config file for the controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/message.config.json"), false);
    }

    /**
     * \fn	read()
     * \brief   update activity for the current read message
     * \todo    testare
     */
    public function read() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif ($this->request['objectId']) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $objectId = $this->request['objectId'];
	    $activityP = new ActivityParse();
	    $activity = $activityP->getActivity($objectId);
	    if ($activity instanceof Error) {
		$this->response(array('status' => $controllers['NOACTFORREADMESS']), 503);
	    } elseif ($activity->getRead() != false) {
		$this->response(array('status' => $controllers['ALREADYREAD']), 503);
	    } else {
		$res = $activityP->updateField($objectId, 'read', true);
		$res1 = $activityP->updateField($objectId, 'status', 'A');
	    }
	    if ($res instanceof Error || $res1 instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackMessageController($objectId, 'readMessage');
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array($controllers['MESSAGEREAD']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	message()
     * \brief   save a message an the related activity
     * \todo    testare, possibilità di invio a utenti multipli, controllo della relazione
     */
    public function message() {
		global $controllers;
		try {
		    if ($this->get_request_method() != "POST") {
				$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
			} elseif (!isset($_SESSION['currentUser'])) {
				$this->response(array('status' => $controllers['USERNOSES']), 403);	   
		    } elseif (!isset($this->request['toUser'])) {
				$this->response(array('status' => $controllers['NOTOUSER']), 403);
			} elseif (!isset($this->request['toUserType'])) {
				$this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
		    } elseif (!isset($this->request['message'])) {
				$this->response(array('status' => $controllers['NOMESSAGE']), 403);
			}
		    $currentUser = $_SESSION['currentUser'];
		    $toUserId = $this->request['toUser'];
		    $toUserType = $this->request['toUserType'];
		    if (relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserId, $toUserType)) {
				$this->response(array('status' => $controllers['NOSPAM']), 401);
		    }
		    $text = $this->request['message'];
		    if (strlen($text) < $this->config->minMessageSize) {
				$this->response(array('status' => $controllers['SHORTMESSAGE'] . strlen($text)), 406);
		    }
		    require_once CLASSES_DIR . 'comment.class.php';
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $message = new Comment();
		    $message->setActive(true);
		    $message->setCommentCounter(0);
		    $message->setFromUser($currentUser->getObjectId());
		    $message->setLocation(null);
		    $message->setLoveCounter(0);
		    $message->setLovers(array());
		    $message->setShareCounter(0);
		    $message->setTags(array());
		    $message->setText($text);
		    $message->setTitle(null);
		    $message->setToUser($toUserId);
		    $message->setType('M');
		    $message->setVideo(null);
		    $message->setVote(null);
		    $commentParse = new CommentParse();
		    $resCmt = $commentParse->saveComment($message);
		    if ($resCmt instanceof Error) {
				$this->response(array('status' => 'NOSAVEMESS'), 503);
		    }
		    require_once CLASSES_DIR . 'activityParse.class.php';
		    $activity = $this->createActivity($currentUser->getObjectId(), $toUserId);
		    $activityParse = new ActivityParse();
		    $resActivity = $activityParse->saveActivity($activity);
		    if ($resActivity instanceof Error) {
			require_once CONTROLLERS_DIR . 'rollBackUtils.php';
			$message = rollbackMessageController($resCmt->getObjectId(), 'sendMessage');
			$this->response(array('status' => $message), 503);
		    }
		    global $mail_files;
		    require_once CLASSES_DIR . 'userParse.class.php';
		    require_once CONTROLLERS_DIR . 'utilsController.php';
		    $userParse = new UserParse();
		    $user = $userParse->getUser($toUserObjectId);
		    #TODO
		    //$address = $user->getEmail();
		    $address = 'alesandro.ghilarducci@gmail.com';
		    $subject = $controllers['SBJMESSAGE'];
		    $html = $mail_files['MESSAGEEMAIL'];
		    sendMailForNotification($address, $subject, $html);
		    $this->response(array($controllers['MESSAGESAVED']), 200);
		} catch (Exception $e) {
		    $this->response(array('status' => $e->getMessage()), 503);
		}
    }

    /**
     * \fn	createActivity($fromUser,$toUser)
     * \brief   private function to create activity class instance
     * \param   $fromUser,$toUser
     */
    private function createActivity($fromUser,$toUser) {
		require_once CLASSES_DIR . 'activity.class.php';
		$activity = new Activity();
		$activity->setActive(true);
		$activity->setAlbum(null);
		$activity->setComment(null);
		$activity->setCounter(0);
		$activity->setEvent(null);
		$activity->setFromUser($fromUser);
		$activity->setImage(null);
		$activity->setPlaylist(null);
		$activity->setQuestion(null);
		$activity->setRead(false);
		$activity->setRecord(null);
		$activity->setSong(null);
		$activity->setStatus('P');
		$activity->setToUser($toUser);
		$activity->setType('MESSAGESENT');
		$activity->setVideo(null);
		return $activity;
    }
	
	/**
     * \fn	createActivity($fromUser,$toUser)
     * \brief   private function to delete activity class instance
     * \param   $objectId
     */
	public function deleteConversation(){
		global $controllers;
		try{
			
			if ($this->get_request_method() != "POST") {
				$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
		    } elseif (!isset($_SESSION['currentUser'])) {
				$this->response(array('status' => $controllers['USERNOSES']), 403);
		    } elseif (!isset($this->request['objectId'])) {
				$this->response(array('status' => $controllers['NOOBJECTID']), 403);
		    }
			$currentUser = $_SESSION['currentUser'];
	    	$objectId = $this->request['objectId'];
			
			//#TODO DA FARE
			
			
			
			$this->response(array($controllers['MESSAGEDELETE']), 200);
		}catch (Exception $e) {
	    	$this->response(array('status' => $e->getMessage()), 503);
		}
		
		
	}
	
	/**
     * \fn	getFeaturingJSON() 
     * \brief   funzione per il recupero dei featuring per l'event
     * \todo check possibilità utilizzo di questa funzione come pubblica e condivisa tra più controller
     */
    public function getFeaturingJSON() {
        try {
            global $controllers;
            error_reporting(E_ALL ^ E_NOTICE);
            $force = false;
            $filter = null;

            if (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 400);
            }
            if (isset($this->request['force']) && !is_null($this->request['force']) && $this->request['force'] == "true") {
                $force = true;
            }
            if (isset($this->request['term']) && !is_null($this->request['term']) && (strlen($this->request['term']) > 0)) {
                $filter = $this->request['term'];
            }
            $currentUserFeaturingArray = null;
            if ($force == false && isset($_SESSION['currentUserFeaturingArray']) && !is_null($_SESSION['currentUserFeaturingArray'])) {//caching dell'array
                $currentUserFeaturingArray = $_SESSION['currentUserFeaturingArray'];
            } else {
                require_once CONTROLLERS_DIR . 'utilsController.php';
                $currentUserFeaturingArray = getFeaturingArray();
                $_SESSION['currentUserFeaturingArray'] = $currentUserFeaturingArray;
            }

            if (!is_null($filter)) {
                require_once CONTROLLERS_DIR . 'utilsController.php';
				$featuring = array();
				if (is_array($currentUserFeaturingArray) && count($currentUserFeaturingArray) > 0) {
					$currentUser = $_SESSION['currentUser'];
					$typeCurrent = $currentUser->getType();
			        foreach ($currentUserFeaturingArray as $value) {			        	
			            if ($typeCurrent == 'SPOTTER' || ($typeCurrent != 'SPOTTER' && $value->type != 'SPOTTER')) {
			                $featuring[] = $value;
			            }
			        }
			    }
                echo json_encode($featuring);
            } else {
                echo json_encode($currentUserFeaturingArray);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }
	
	

}

?>