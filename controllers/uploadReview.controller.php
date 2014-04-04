<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'insert.service.php';

/**
 * UploadReviewController class
 * si collega al form di upload di una review, effettua controlli, scrive su DB
 * 
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class UploadReviewController extends REST {

    /**
     * inizializzazione della pagina
     */
    public function init() {
	if (!isset($_SESSION['id'])) {
	    header('Location: login.php?from=uploadReview.php');
	    exit;
	}
    }

    /**
     * funzione per pubblicazione review
     */
    public function publish() {
	global $controllers;
	global $mail_files;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
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
	    $currentUserId = $_SESSION['id'];
	    $commentedObjectId = $this->request['reviewedId'];
	    $commentedType = $this->request['type'];
	    $rating = intval($this->request['rating']);
	    $text = $this->request['review'];
		
	    if (!in_array($commentedType, array('Event', 'Record'))) {
		$this->response(array("status" => $controllers['CLASSTYPEKO']), 406);
	    }
	    $commentedObject = $this->getReviewdById($commentedObjectId, $commentedType);
	    if ((count($commentedObject) != 1) || ($commentedObject == false)) {
		$this->response(array('status' => $controllers['ERRORREVIEW']), 403);
	    }
	    $touser = $commentedObject->getFromuser();
	    if ($touser->getId() == $currentUserId) {
		$this->response(array("status" => $controllers['NOSELFREVIEW']), 403);
	    }
	    require_once CLASSES_DIR . 'comment.class.php';
	    $review = new Comment();
	    $review->setActive(1);
	    $review->setAlbum(null);
	    $review->setCommentcounter(0);
	    $review->setCounter(0);
	    $review->setFromuser($currentUserId);
	    $review->setImage(null);
	    $review->setLatitude(null);
	    $review->setLongitude(null);
	    $review->setLovecounter(0);
	    $review->setSharecounter(0);
	    $review->setSong(null);
	    $review->setTag(array());
	    $review->setTitle(null);
	    $review->setText($text);
	    $review->setTouser($touser->getId());
	    $review->setVideo(null);
	    $review->setVote($rating);
	    switch ($commentedType) {
		case 'Event' :
		    $review->setEvent($commentedObjectId);
		    $review->setRecord(null);
		    $review->setType('RE');
		    $type = "NEWEVENTREVIEW";
		    $subject = $controllers['SBJE'];
		    $html = $mail_files['EVENTREVIEWEMAIL'];
		    break;
		case 'Record':
		    $review->setEvent(null);
		    $review->setRecord($commentedObjectId);
		    $review->setType('RR');
		    $type = "NEWRECORDREVIEW";
		    $subject = $controllers['SBJR'];
		    $html = $mail_files['RECORDREVIEWEMAIL'];
		    break;
	    }
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
		
	    $result = insertComment($connection, $review);
		
	    $node = createNode($connectionService, 'comment', $commentedObjectId);
	    $relation = createRelation($connectionService, 'user', $currentUserId, 'comment', $commentedObjectId, 'ADD');
	    if ($result === false || $relation === false || $node === false) {
		$this->response(array('status' => $controllers['REVIEWERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    require_once SERVICES_DIR . 'utils.service.php';
	    sendMailForNotification($touser->getEmail(), $subject, $html); 
	    $this->response(array("status" => $controllers['REWSAVED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * funzione privata per il recupero di un commento dal DB
     * 
     * @param   $id of the reviewed object
     * @param   $type of the reviewed object
     * @return false, in case of error; id of the object in case of ok select
     */
    private function getReviewdById($id, $type) {
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
	    $connectionService->disconnect($connection);
	    return $rows[$id];
	}
    }

}

?>