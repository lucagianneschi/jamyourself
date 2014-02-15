<?php

/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di love/unlove 
 * \details		incrementa/decrementa il loveCounter di una classe e istanza corrispondente activity
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		fare API su Wiki
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

/**
 * \brief	LoveController class 
 * \details	controller di love/unlove
 */
class LoveController extends REST {

    /**
     * \fn		incrementLove()
     * \brief   increments loveCounter property of an istance of a class
     * \todo    usare la sessione, prendere il toUser per la incrementLove, poichè il propietario del media deve avere notifica
     */
    public function incrementLove() {
	global $controllers;

	try {

	    //controllo la richiesta
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }

	    //controllo i parametri
	    $classTypeAdmitted = array('Album', 'Comment', 'Event', 'Image', 'Record', 'Song', 'Video');
	    if (!isset($this->request['classType'])) {
		$this->response(array('status' => 'NOCLASSTYPE'), 400);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => 'NOOBJECTID'), 400);
	    } elseif (!in_array($this->request['classType'], $classTypeAdmitted)) {
		$this->response(array('status' => 'CLASSTYPEKO'), 400);
	    } elseif (!isset($this->request['objectIdUser'])) {
		$this->response(array('status' => 'NOUSERID'), 400);
	    }

	    //recupero l'utente fromUser
	    $fromUser = $_SESSION['currentUser'];

	    //recupero i parametri
	    $classType = $this->request['classType'];
	    $objectId = $this->request['objectId'];
	    $toUserObjectId = $this->request['objectIdUser'];

	    //controllo se non ho già lovvato
	    if ($this->isLoved($fromUser->getObjectId(), $objectId, $classType)) {
		$this->response(array('status' => 'ALREADYLOVED'), 500);
	    }

	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setCounter(0);
	    $activity->setFromUser($fromUser->getObjectId());
	    $activity->setQuestion(null);
	    $activity->setRead(false);
	    $activity->setStatus("A");
	    $activity->setToUser($toUserObjectId);
	    switch ($classType) {
		case 'Album':
		    require_once CLASSES_DIR . 'albumParse.class.php';
		    $albumParse = new AlbumParse();
		    $res = $albumParse->incrementAlbum($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setAlbum($objectId);
		    $activity->setType("LOVEDALBUM");
		    break;
		case 'Comment':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $res = $commentParse->incrementComment($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setComment($objectId);
		    $activity->setType("LOVEDCOMMENT");
		    break;
		case 'Event':
		    require_once CLASSES_DIR . 'eventParse.class.php';
		    $eventParse = new EventParse();
		    $res = $eventParse->incrementEvent($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setEvent($objectId);
		    $activity->setType("LOVEDEVENT");
		    break;
		case 'Image':
		    require_once CLASSES_DIR . 'imageParse.class.php';
		    $imageParse = new ImageParse();
		    $res = $imageParse->incrementImage($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setImage($objectId);
		    $activity->setType("LOVEDIMAGE");
		    break;
		case 'Record':
		    require_once CLASSES_DIR . 'recordParse.class.php';
		    $recordParse = new RecordParse();
		    $res = $recordParse->incrementRecord($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setRecord($objectId);
		    $activity->setType("LOVEDRECORD");
		    break;
		case 'Song':
		    require_once CLASSES_DIR . 'songParse.class.php';
		    $songParse = new SongParse();
		    $res = $songParse->incrementSong($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    require_once CLASSES_DIR . 'userParse.class.php';
		    $userParse = new UserParse();
		    $userParse->updateField($fromUser->getObjectId(), 'loveSongs', array($objectId), true, 'add', 'Song');
		    $activity->setSong($objectId);
		    $activity->setType("LOVEDSONG");
		    break;
		case 'Video':
		    require_once CLASSES_DIR . 'videoParse.class.php';
		    $videoParse = new VideoParse();
		    $res = $videoParse->incrementVideo($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setType("LOVEDVIDEO");
		    $activity->setVideo($objectId);
		    break;
	    }
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['LOVEPLUSERR']), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error) {
		    require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		    $message = rollbackLoveController($classType, $objectId, 'decrement', $fromUser);
		    $this->response(array('status' => $message), 503);
		}
	    }
	    $this->response(array('status' => $res), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * \fn		decrementLove()
     * \brief   decrements loveCounter property of an istance of a class
     * \todo    usare la sessione
     */
    public function decrementLove() {
	global $controllers;

	try {
	    //controllo la richiesta
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    }

	    //controllo i parametri
	    $classTypeAdmitted = array('Album', 'Comment', 'Event', 'Image', 'Record', 'Song', 'Video');
	    if (!isset($this->request['classType'])) {
		$this->response(array('status' => 'NOCLASSTYPE'), 400);
	    } elseif (!isset($this->request['objectId'])) {
		$this->response(array('status' => 'NOOBJECTID'), 400);
	    } elseif (!in_array($this->request['classType'], $classTypeAdmitted)) {
		$this->response(array('status' => 'CLASSTYPEKO'), 400);
	    } elseif (!isset($this->request['objectIdUser'])) {
		$this->response(array('status' => 'NOUSERID'), 400);
	    }

	    //recupero l'utente fromUser
	    $fromUser = $_SESSION['currentUser'];

	    //recupero i parametri
	    $classType = $this->request['classType'];
	    $objectId = $this->request['objectId'];
	    $toUserObjectId = $this->request['objectIdUser'];

	    #TODO
	    //devo farmi passare questo per poter avere la notifica
	    //$toUser = $this->request['toUser'];
	    //controllo se non ho già lovvato
	    if (!$this->isLoved($fromUser->getObjectId(), $objectId, $classType)) {
		$this->response(array('status' => 'NOLOVE'), 400);
	    }

	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setCounter(0);
	    $activity->setFromUser($fromUser->getObjectId());
	    $activity->setQuestion(null);
	    $activity->setRead(true);
	    $activity->setStatus("A");
	    $activity->setToUser($toUserObjectId);
	    switch ($classType) {
		case 'Album':
		    require_once CLASSES_DIR . 'albumParse.class.php';
		    $albumParse = new AlbumParse();
		    $res = $albumParse->decrementAlbum($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setAlbum($objectId);
		    $activity->setType("UNLOVEDALBUM");
		    break;
		case 'Comment':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $res = $commentParse->decrementComment($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setComment($objectId);
		    $activity->setType("UNLOVEDCOMMENT");
		    break;
		case 'Event':
		    require_once CLASSES_DIR . 'eventParse.class.php';
		    $eventParse = new EventParse();
		    $res = $eventParse->decrementEvent($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setEvent($objectId);
		    $activity->setType("UNLOVEDEVENT");
		    break;
		case 'Image':
		    require_once CLASSES_DIR . 'imageParse.class.php';
		    $imageParse = new ImageParse();
		    $res = $imageParse->decrementImage($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setImage($objectId);
		    $activity->setType("UNLOVEDIMAGE");
		    break;
		case 'Record':
		    require_once CLASSES_DIR . 'recordParse.class.php';
		    $recordParse = new RecordParse();
		    $res = $recordParse->decrementRecord($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setRecord($objectId);
		    $activity->setType("UNLOVEDRECORD");
		    break;
		case 'Song':
		    require_once CLASSES_DIR . 'songParse.class.php';
		    $songParse = new SongParse();
		    $res = $songParse->decrementSong($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    require_once CLASSES_DIR . 'userParse.class.php';
		    $userParse = new UserParse();
		    $userParse->updateField($fromUser->getObjectId(), 'loveSongs', array($objectId), true, 'remove', 'Song');
		    $activity->setSong($objectId);
		    $activity->setType("UNLOVEDSONG");
		    break;
		case 'Video':
		    require_once CLASSES_DIR . 'videoParse.class.php';
		    $videoParse = new VideoParse();
		    $res = $videoParse->decrementVideo($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
		    $activity->setType("UNLOVEDVIDEO");
		    $activity->setVideo($objectId);
		    break;
	    }
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['LOVEMINUSERR']), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error) {
		    require_once CONTROLLERS_DIR . 'rollBack.controller.php';
		    $message = rollbackLoveController($classType, $objectId, 'increment', $fromUser);
		    $this->response(array('status' => $message), 503);
		}
	    }
	    $this->response(array('status' => $res), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    private function isLoved($objectIdUser, $objectId, $classType) {
	switch ($classType) {
	    case 'Album':
		require_once CLASSES_DIR . 'albumParse.class.php';
		$albumParse = new AlbumParse();
		$res = $albumParse->getAlbum($objectId);
		break;
	    case 'Comment':
		require_once CLASSES_DIR . 'commentParse.class.php';
		$commentParse = new CommentParse();
		$res = $commentParse->getComment($objectId);
		break;
	    case 'Event':
		require_once CLASSES_DIR . 'eventParse.class.php';
		$eventParse = new EventParse();
		$res = $eventParse->getEvent($objectId);
		break;
	    case 'Image':
		require_once CLASSES_DIR . 'imageParse.class.php';
		$imageParse = new ImageParse();
		$res = $imageParse->getImage($objectId);
		break;
	    case 'Record':
		require_once CLASSES_DIR . 'recordParse.class.php';
		$recordParse = new RecordParse();
		$res = $recordParse->getRecord($objectId);
		break;
	    case 'Song':
		require_once CLASSES_DIR . 'songParse.class.php';
		$songParse = new SongParse();
		$res = $songParse->getSong($objectId);
		break;
	    case 'Video':
		require_once CLASSES_DIR . 'videoParse.class.php';
		$videoParse = new VideoParse();
		$res = $videoParse->getVideo($objectId);
		break;
	}
	$loved = in_array($objectIdUser, $res->getLovers()) ? true : false;
	return $loved;
    }

}

?>