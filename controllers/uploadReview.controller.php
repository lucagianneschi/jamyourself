<?php

/* ! \par		Info Generali:
 * \author		Stefano Muscas
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di upload review 
 * \details		si collega al form di upload di una review, effettua controlli, scrive su DB
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		Fare API su Wiki
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	UploadReviewController class 
 * \details	controller di upload review
 */
class UploadReviewController extends REST {

    public $reviewedId;
    public $reviewed;
    public $reviewedFeaturing;
    public $reviewedClassType;
    public $reviewedFromUser;

    /**
     * \fn	init()
     * \brief   inizializzazione della pagina
     */
    public function init() {
        if (!isset($_SESSION['currentUser'])) {
            /* This will give an error. Note the output
             * above, which is before the header() call */
            header('Location: login.php?from=uploadReview.php');
            exit;
        }
        if (isset($_GET["rewiewId"]) && strlen($_GET["rewiewId"]) > 0 && (isset($_GET["type"]) && strlen($_GET["type"]) > 0) && ( ($_GET["type"] == "Event" ) || ($_GET["type"] == "Record" ))) {
            $this->reviewedId = $_GET["rewiewId"];
            $this->reviewedClassType = $_GET["type"];            
            $this->reviewed = $this->getReviewdById($this->reviewedId, $this->reviewedClassType);
            if (is_null($this->reviewed) || $this->reviewed == false) {
                die("Errore");
            } else {
                //@todo 1
//                $this->reviewedFeaturing = getRelatedUsers($this->reviewedId, "featuring", $this->reviewedClassType);
                $this->reviewedFromUser = $this->reviewed->getFromuser();
                if ($this->reviewedFeaturing instanceof Error) {
                    die("Errore");
                }
            }
        } else {
            die("Errore");
        }
    }

    /**
     * \fn	publish()
     * \brief   funzione per pubblicazione review
     */
    public function publish() {
        global $controllers;
        global $mail_files;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif ((!isset($this->request['reviewedId']) || is_null($this->request['reviewedId']) || !(strlen($this->request['reviewedId']) > 0))) {
                $this->response(array('status' => $controllers['NOOBJECTID']), 403);
            } elseif ((!isset($this->request['review']) || is_null($this->request['review']) || !(strlen($this->request['review']) > 0 ))) {
                $this->response(array('status' => $controllers['NOREW']), 403);
            } elseif ((!isset($this->request['rating']) || is_null($this->request['rating']) || !(strlen($this->request['rating']) > 0 ))) {
                $this->response(array('status' => $controllers['NORATING']), 403);
            } elseif ((!isset($this->request['type']) || is_null($this->request['type']) || !(strlen($this->request['type']) > 0 ))) {
                $this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
            }
            $currentUser = $_SESSION['currentUser'];
            $reviewRequest = json_decode(json_encode($this->request), false);
            $this->reviewedId = $reviewRequest->reviewedId;
            $this->reviewedClassType = $reviewRequest->type;
            $rating = intval($this->request['rating']);
            if (!in_array($this->reviewedClassType, array('Event', 'Record'))) {
                $this->response(array("status" => $controllers['CLASSTYPEKO']), 406);
            }

            $this->reviewed = $this->getReviewdById($this->reviewedId, $this->reviewedClassType);

            if (is_null($this->reviewed) || ($this->reviewed == false)) {
                $this->response(array('status' => $controllers['ERRORREVIEW']), 403);
            }

            $touser = $this->reviewed->getFromuser();
            if ($touser->getId() == $currentUser->getId()) {
                $this->response(array("status" => $controllers['NOSELFREVIEW']), 403);
            }
            require_once CLASSES_DIR . 'comment.class.php';
            $review = new Comment();
            $review->setActive(true);
            $review->setAlbum(null);
            $review->setCounter(0);
            $review->setFromuser($currentUser->getId());
            $review->setImage(null);
            $review->setLocation(null);
            $review->setLovecounter(0);
            $review->setSharecounter(0);
            $review->setSong(null);
            $review->setTag(array());
            $review->setTitle(null);
            $review->setText($reviewRequest->review);
            $review->setTouser($touser->getId());
            $review->setVideo(null);
            $review->setVote($rating);
            switch ($this->reviewedClassType) {
                case 'Event' :
                    $review->setEvent($this->reviewedId);
                    $review->setRecord(null);
                    $review->setType('RE');
                    $type = "NEWEVENTREVIEW";
                    $subject = $controllers['SBJE'];
                    $html = $mail_files['EVENTREVIEWEMAIL'];
                    break;
                case 'Record';
                    $review->setEvent(null);
                    $review->setRecord($this->reviewedId);
                    $review->setType('RR');
                    $type = "NEWRECORDREVIEW";
                    $subject = $controllers['SBJR'];
                    $html = $mail_files['RECORDREVIEWEMAIL'];
                    break;
            }
            require_once SERVICES_DIR . 'utils.service.php';
            sendMailForNotification($touser->getEmail(), $subject, $html);
            $resRev = $this->saveComment($review);
            if ($resRev == false) {
                $this->response(array("status" => $controllers['NOSAVEDREVIEW']), 503);
            }
            $this->response(array("status" => $controllers['REWSAVED'], "id" => $this->reviewedId), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }

    /**
     * \fn	saveComment()
     * \brief   funzione privata per il salvataggio nel DB di un commento
     * \param   $comment
     */
    private function saveComment($comment) {
        require_once SERVICES_DIR . 'connection.service.php';
        $connectionService = new ConnectionService();
        $connection = $connectionService->connect();

        if ($connection != false) {
            require_once SERVICES_DIR . 'insert.service.php';
            $result = insertComment($connection, $comment);
            $connectionService->disconnect();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * \fn	getReviewdById()
     * \brief   funzione privata per il recupero di un commento dal DB
     * \param   $id, $type
     */
    private function getReviewdById($id, $type) {
        require_once SERVICES_DIR . 'connection.service.php';
        $connectionService = new ConnectionService();
        $connection = $connectionService->connect();
        $rows = null;
        if ($connection != false) {
            require_once SERVICES_DIR . 'select.service.php';

            switch ($type) {
                case "Event":
                    $rows = selectEvents($connection, $id);
                    break;
                case "Record":
                    $rows = selectRecords($connection, $id);
                    break;
            }
            $connectionService->disconnect();

            if (count($rows) > 0) {
                return $rows[0];
            }
            else
                return null;
        } else {
            return false;
        }
    }

}

?>