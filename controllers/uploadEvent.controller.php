<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'event.class.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'connection.service.php';

/**
 * UploadEventController class
 * si collega al form di upload di un evet, effettua controlli, scrive su DB
 * 
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class UploadEventController extends REST {

    /**
     * inizializzazione della pagina
     */
    public function init() {
	if (!isset($_SESSION['id'])) {
	    header('Location: login.php?from=uploadEvent.php');
	    exit;
	}
    }

    /**
     * funzione per pubblicazione dell'event
     */
    public function createEvent() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 400);
	    } elseif (!isset($this->request['title']) || is_null($this->request['title']) || !(strlen($this->request['title']) > 0)) {
		$this->response(array('status' => $controllers['NOEVENTTITLE']), 400);
	    } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
		$this->response(array('status' => $controllers['NOEVENTDESCRIPTION']), 400);
	    } elseif (!isset($this->request['date']) || is_null($this->request['date'])) {
		$this->response(array('status' => $controllers['NOEVENTDATE']), 400);
	    } elseif (!isset($this->request['hours']) || is_null($this->request['hours'])) {
		$this->response(array('status' => $controllers['NOEVENTHOURS']), 400);
	    } elseif (!isset($this->request['music']) || is_null($this->request['music']) || !is_array($this->request['music']) || !(count($this->request['music']) > 0)) {
		$this->response(array('status' => $controllers['NOEVENTMUSIC']), 400);
	    } elseif (!isset($this->request['tags']) || is_null($this->request['tags']) || !is_array($this->request['tags']) || !(count($this->request['tags']) > 0)) {
		$this->response(array('status' => $controllers['NOEVENTTAGS']), 400);
	    } elseif (!isset($this->request['venue']) || is_null($this->request['venue']) || !(strlen($this->request['venue']) > 0)) {
		$this->response(array('status' => $controllers['NOEVENTVENUE']), 400);
	    } elseif (!isset($this->request['image']) || is_null($this->request['image'])) {
		$this->response(array('status' => $controllers['NOEVENTIMAGE']), 400);
	    } elseif (!isset($this->request['crop']) || is_null($this->request['crop'])) {
		$this->response(array('status' => $controllers['NOEVENTTHUMB']), 400);
	    } elseif (!isset($this->request['city']) || is_null($this->request['city'])) {
		$this->response(array('status' => $controllers['NOEVENTADDRESS']), 400);
	    }
	    $userId = $_SESSION['id'];
	    require_once SERVICES_DIR . 'geocoder.service.php';
	    $infoLocation = GeocoderService::getCompleteLocationInfo($this->request['city']);
	    $imgInfo = getCroppedImages($this->request);
	    $event = new Event();
	    $event->setActive(1);
	    $event->setAttendeecounter(0);
	    $event->setAddress($infoLocation["address"] . ", " . $infoLocation['number']);
	    $event->setCancelledcounter(0);
	    $event->setCity($infoLocation["city"]);
	    $event->setCommentcounter(0);
	    $event->setCounter(0);
	    $event->setCover($imgInfo['picture']);
	    $event->setDescription($this->request['description']);
	    $eventDate = $this->getDate($this->request['date'], $this->request['hours']);
	    if (!$eventDate) {
		$this->response(array('status' => $controllers['NOEVENTDATE']), 400);
	    }
	    $event->setEventdate($eventDate);
	    $event->setFromuser($userId);	    
	    $event->setGenre($this->request['music']);
	    $event->setInvitedCounter(0);
	    $event->setLatitude($infoLocation['latitude']);
	    $event->setLocationName($this->request['venue']);
	    $event->setLongitude($infoLocation["longitude"]);
	    $event->setLovecounter(0);
	    $event->setRefusedcounter(0);
	    $event->setReviewcounter(0);
	    $event->setSharecounter(0);
	    $event->setTag($this->request['tags']);
	    $event->setThumbnail($imgInfo['thumbnail']);
	    $event->setTitle($this->request['title']);
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $result = insertEvent($connection, $event);
	    $node = createNode($connectionService, 'event', $result);
	    $relation = createRelation($connectionService, 'user', $userId, 'event', $result, 'CREATE');
		if (!isset($this->request['jammers']) || is_null($this->request['jammers']) || !is_array($this->request['jammers']) || !(count($this->request['jammers']) > 0)) {			
			foreach ($this->request['jammers'] as $userId) {
				$featuring = createRelation($connectionService, 'user', $userId, 'event', $result, 'FEATURE');
				if($featuring == false) $this->response(array('status' => $controllers['COMMENTERR']), 503);
			}			
	    }
	    $fileManager = new FileManagerService();
	    $res_thumb = $fileManager->saveEventPhoto($userId, $event->getThumbnail());
	    $res_image = $fileManager->saveEventPhoto($userId, $event->getCover());
	    if ($result === false || $relation === false || $node === false || $res_image === false || $res_thumb === false) {
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    $this->response(array('status' => $controllers['EVENTCREATED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * funzione per formattazione della data
     * @param int $day Day of the event
     * @param int $day Hour of the event
     * @return Datetime of the event
     * @todo    check su utilizzo funzioni della utilsClass
     */
    private function getDate($day, $hours) {
	try {
	    if (!isset($day) || is_null($day) || !(strlen($day) > 0)) {
		return null;
	    } elseif (!isset($hours) || is_null($hours) || !(strlen($hours) > 0)) {
		return DateTime::createFromFormat("d/m/Y", $day);
	    } else {
		return DateTime::createFromFormat("d/m/Y H:i", $day . " " . $hours);
	    }
	} catch (Exception $e) {
	    return false;
	}
    }

}

?>