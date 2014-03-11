<?php

/* ! \par		Info Generali:
 * @author		Stefano Muscas
 * @version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di upload event 
 * \details		si collega al form di upload di un evet, effettua controlli, scrive su DB
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		Fare API su Wiki
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'utils.service.php';

/**
 * \brief	UploadEventController class 
 * \details	controller di upload event
 */
class UploadEventController extends REST {

    /**
     * \fn	init()
     * \brief   inizializzazione della pagina
     */
    public function init() {
//utente non loggato

	if (!isset($_SESSION['currentUser'])) {
	    /* This will give an error. Note the output
	     * above, which is before the header() call */
	    header('Location: login.php?from=uploadEvent.php');
	    exit;
	}
    }

    /**
     * \fn	createEvent()
     * \brief   funzione per pubblicazione dell'event
     */
    public function createEvent() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['currentUser'])) {
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
//            } elseif (!isset($this->request['jammers']) || is_null($this->request['jammers']) || !is_array($this->request['jammers']) || !(count($this->request['jammers']) > 0)) {
//                $this->response(array('status' => $controllers['NOEVENTURL']), 400);
	    } elseif (!isset($this->request['venue']) || is_null($this->request['venue']) || !(strlen($this->request['venue']) > 0)) {
		$this->response(array('status' => $controllers['NOEVENTVENUE']), 400);
	    } elseif (!isset($this->request['image']) || is_null($this->request['image'])) {
		$this->response(array('status' => $controllers['NOEVENTIMAGE']), 400);
	    } elseif (!isset($this->request['crop']) || is_null($this->request['crop'])) {
		$this->response(array('status' => $controllers['NOEVENTTHUMB']), 400);
	    } elseif (!isset($this->request['city']) || is_null($this->request['city'])) {
		$this->response(array('status' => $controllers['NOEVENTADDRESS']), 400);
	    }
	    $currentUser = $_SESSION['currentUser'];
	    $userId = $currentUser->getId();
	    require_once CLASSES_DIR . 'event.class.php';
	    $event = new Event();
	    $event->setActive(true);
	    $event->setAttendee(null);
	    $event->setCounter(0);
	    $event->setDescription($this->request['description']);
	    $eventDate = $this->getDate($this->request['date'], $this->request['hours']);
	    if (is_null($eventDate)) {
		$this->response(array('status' => $controllers['NOEVENTDATE']), 400);
	    }
	    $event->setEventDate($eventDate);
	    if (!isset($this->request['jammers']) || is_null($this->request['jammers']) || !is_array($this->request['jammers']) || !(count($this->request['jammers']) > 0)) {
		$event->setFeaturing($this->request['jammers']);
	    }
	    $event->setFromuser($userId);
	    $imgInfo = getCroppedImages($this->request);
	    $event->setImage($imgInfo['picture']);
	    $event->setThumbnail($imgInfo['thumbnail']);
	    $event->setInvited(null);
	    $event->setLocationName($this->request['venue']);
	    require_once SERVICES_DIR . 'geocoder.service.php';
	    $infoLocation = GeocoderService::getCompleteLocationInfo($this->request['city']);
	    $event->setLatitude($infoLocation["latitude"]);
	    $event->setLongitude($infoLocation["longitude"]);
	    $event->setAddress($infoLocation["address"] . ", " . $infoLocation['number']);
	    $event->setCity($infoLocation["city"]);
	    $event->setLovecounter(0);
	    $event->setRefused(null);
	    $event->setReviewcounter(0);
	    $event->setSharecounter(0);
	    $event->setTag($this->request['tags']);
	    $event->setGenre($this->request['music']);
	    $event->setTitle($this->request['title']);
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $pEvent = new EventParse();
	    $eventSave = $pEvent->saveEvent($event);
	    if ($eventSave instanceof Error) {
		$this->response(array("status" => $controllers['EVENTCREATEERROR']), 503);
	    }
	    $fileManager = new FileManagerService();
	    $thumbSrc = $fileManager->getEventPhotoPath($userId, $eventSave->getThumbnail());
	    $imageSrc = $fileManager->getEventPhotoPath($userId, $eventSave->getImage());
	    if (!is_null($thumbSrc) && (strlen($thumbSrc) > 0) && !is_null($imageSrc) && (strlen($imageSrc) > 0)) {
		rename(CACHE_DIR . DIRECTORY_SEPARATOR . $eventSave->getThumbnail(), $thumbSrc);
		rename(CACHE_DIR . DIRECTORY_SEPARATOR . $eventSave->getImage(), $imageSrc);
	    }
	    unset($_SESSION['currentUserFeaturingArray']);
	    $activity = $this->createActivity($userId, $eventSave->getId());
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityP = new ActivityParse();
	    $activitySave = $activityP->saveActivity($activity);
	    if ($activitySave instanceof Error) {
		require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		$message = rollbackUploadEventController($eventSave->getId());
		$this->response(array('status' => $message), 503);
	    }
	    $this->response(array('status' => $controllers['EVENTCREATED'], "id" => $eventSave->getId()), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }


    /**
     * \fn	getDate($day, $hours)
     * \brief   funzione per formattazione della data
     * \todo    check su utilizzo funzioni della utilsClass
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
	    return null;
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
		echo json_encode(filterFeaturingByValue($currentUserFeaturingArray, $filter));
	    } else {
		echo json_encode($currentUserFeaturingArray);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>