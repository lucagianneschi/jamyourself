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
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CONTROLLERS_DIR . 'utilsController.php';
require_once SERVICES_DIR . 'mail.service.php';
require_once DEBUG_DIR . 'debug.php';

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
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/review.config.json"), false);
    }

    /**
     * \fn		review()
     * \brief   save a review an the related activity
     * \todo    usare la sessione, fare controllo sul fatto che l'utente non faccia una recensione di una cosa che gli appartiene
     */
    public function sendReview() {
        global $controllers;
        global $mail_files;

        #TODO
        //in questa fase di debug, il fromUser lo passo staticamente e non lo recupero dalla session
        //questa sezione prima del try-catch dovrà sparire
        require_once CLASSES_DIR . 'user.class.php';
        $fromUser = new User('SPOTTER');
        $fromUser->setObjectId('GuUAj83MGH');

        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            }

            //controllo i parametri
            if (!isset($this->request['text'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOREW']), 400);
            } elseif (!isset($this->request['objectId'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOOBJECTID']), 400);
            } elseif (!isset($this->request['classType'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOCLASSTYPE']), 400);
            }

            //recupero fromUser, objectId, classType e testo
            #TODO
            //$fromUser = $_SESSION['currentUser'];
            $fromUserObjectId = $fromUser->getObjectId();
            $text = $this->request['text'];
            $objectId = $this->request['objectId'];
            $classType = $this->request['classType'];

            if (strlen($text) < $this->config->minReviewSize) {
                $this->response(array($controllers['SHORTREW'] . strlen($text)), 200);
            } elseif (strlen($text) > $this->config->maxReviewSize) {
                $this->response(array($controllers['LONGREW'] . strlen($text)), 200);
            }

            $activity = new Activity();
            $activity->setActive(true);
            $activity->setCounter(0);
            #TODO
            //$activity->setFromUser($fromUser->getObjectId());
            $activity->setFromUser($fromUser->getObjectId());
            $activity->setRead(false);
            $activity->setStatus("A");

            $review = new Comment();
            $review->setActive(true);
            $review->setAlbum(null);
            $review->setComment(null);
            $review->setCommentCounter(0);
            $review->setCommentators(null);
            $review->setComments(null);
            $review->setCounter(0);
            #TODO
            //$review->setFromUser($fromUser->getObjectId());
            $review->setFromUser($fromUser->getObjectId());
            $review->setImage(null);
            $review->setLocation(null);
            $review->setLoveCounter(0);
            $review->setLovers(null);
            $review->setShareCounter(0);
            $review->setSong(null);
            $review->setStatus(null);
            $review->setTags(null);
            $review->setTitle(null);
            $encodedText = parse_encode_string($text);
            $review->setText($encodedText);
            $review->setVideo(null);
            $review->setVote(null);

            $mail = mailService();
            $mail->IsHTML(true);
            $mail->AddAddress('daniele.caldelli@gmail.com');
            //$mail->AddAddress($user->email);
            switch ($classType) {
                case 'Event'://posso fare la recensione di un mio evento?? NO! AGGIUNGERE CONTROLLO
                    $review->setEvent($objectId);
                    $review->setType('RE');
                    require_once CLASSES_DIR . 'eventParse.class.php';
                    $eventParse = new EventParse();
                    $event = $eventParse->getEvent($objectId);
                    //il toUser della review è il fromUser dell'Evento
                    $review->setToUser($event->getFromUser());
                    $activity->setEvent($objectId);
                    $activity->setType("NEWEVENTREVIEW");
                    $mail->Subject = $controllers['SBJE'];
                    $mail->MsgHTML(file_get_contents(STDHTML_DIR . $mail_files['EVENTREVIEWEMAIL']));
                    break;
                case 'Record'://posso fare la recensione di un mio record?? NO! AGGIUNGERE CONTROLLO
                    $review->setRecord($objectId);
                    $review->setType('RR');
                    require_once CLASSES_DIR . 'recordParse.class.php';
                    $recordParse = new RecordParse();
                    $record = $recordParse->getRecord($objectId);
                    //il toUser della review è il fromUser dell'Evento
                    $review->setToUser($record->getFromUser());
                    $activity->setRecord($objectId);
                    $activity->setType("NEWRECORDREVIEW");
                    $mail->Subject = $controllers['SBJR'];
                    $mail->MsgHTML(file_get_contents(STDHTML_DIR . $mail_files['RECORDREVIEWEMAIL']));
                    break;
            }
            $commentParse = new CommentParse();
            $resRev = $commentParse->saveComment($review);
            if ($resRev instanceof Error) {
                $this->response(array($resRev), 503);
            } else {
                $activityParse = new ActivityParse();
                $resActivity = $activityParse->saveActivity($activity);
                if ($resActivity instanceof Error) {
                    $this->rollback($resRev->getObjectId());
                }
            }
            $mail->Send();
            $mail->SmtpClose();
            $this->response(array($controllers['REWSAVED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    private function rollback($objectId) {
        global $controllers;
        $commentParse = new CommentParse();
        $res = $commentParse->deleteComment($objectId);
        if (get_class($res) == 'Error') {
            $this->response(array($controllers['ROLLKO']), 503);
        } else {
            $this->response(array($controllers['ROLLOK']), 503);
        }
    }

}

?>