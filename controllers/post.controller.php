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
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CONTROLLERS_DIR . 'utilsController.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once DEBUG_DIR . 'debug.php';

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
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/post.config.json"), false);
    }

    /**
     * \fn		post()
     * \brief   save a post an the related activity
     * \todo    usare la sessione
     */
    public function post() {
		global $controllers;
		
		try {
            //controllo la richiesta
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => 'La richiesta non è di tipo POST'), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => 'Non esiste nessun utente in SESSION'), 403);
            }
			
            //controllo i parametri
            if (!isset($this->request['post'])) {
                $this->response(array('status' => $controllers['NOPOST']), 400);
            } elseif (!isset($this->request['toUser'])) {
                $this->response(array('status' => $controllers['NOTOUSER']), 403);
            }

            //recupero gli utenti fromUser e toUser
            $fromUser = $_SESSION['currentUser'];
            $toUserObjectId = $this->request['toUser'];
			
			//recupero e controllo il post
            $post = $_REQUEST['post'];
            if (strlen($post) < $this->config->minPostSize) {
				$this->response(array('status' => $controllers['SHORTPOST'] . strlen($post)), 406);
            } elseif (strlen($post) > $this->config->maxPostSize) {
                $this->response(array('status' => $controllers['LONGPOST'] . strlen($post)), 406);
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
            $cmt->setFromUser($fromUser->getObjectId());
            $cmt->setImage(null);
            $cmt->setLocation(null);
            $cmt->setLoveCounter(0);
            $cmt->setLovers(null);
            $cmt->setRecord(null);
            $cmt->setShareCounter(0);
            $cmt->setSong(null);
            $cmt->setStatus(null);
            $cmt->setTags(null);
            $cmt->setTitle(null);
            $encodedText = parse_encode_string($post);
            $cmt->setText($encodedText);
            $cmt->setToUser($toUserObjectId);
            $cmt->setType('P');
            $cmt->setVideo(null);
            $cmt->setVote(null);

            //imposto i valori per il salvataggio dell'activity collegata al post
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
			$activity->setFromUser($fromUser->getObjectId());
			$activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRead(false);
            $activity->setRecord(null);
            $activity->setSong(null);
            $activity->setStatus('A');
            $activity->setToUser($toUserObjectId);
            $activity->setType('POSTED');
            $activity->setUserStatus(null);
            $activity->setVideo(null);

            //salvo post
            $commentParse = new CommentParse();
            $resCmt = $commentParse->saveComment($cmt);
            if (get_class($resCmt) == 'Error') {
                $this->response(array('status' => $resCmt->getMessageError()), 503);
            } else {
                //salvo activity
                $activityParse = new ActivityParse();
                $resActivity = $activityParse->saveActivity($activity);
                if (get_class($resActivity) == 'Error') {
                    $this->rollback($resCmt->getObjectId());
                }
            }
            $this->response(array('status' => $controllers['POSTSAVED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    private function rollback($objectId) {
        global $controllers;

        $commentParse = new CommentParse();
        $res = $commentParse->deleteComment($objectId);
        if (get_class($res) == 'Error') {
            $this->response(array('status' => $controllers['ROLLKO']), 503);
        } else {
            $this->response(array('status' => $controllers['ROLLOK']), 503);
        }
    }

}

?>