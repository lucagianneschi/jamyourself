<?php
/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di love/unlove 
 * \details		incrementa/decrementa il loveCounter di una classe e istanza corrispondente activity
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once DEBUG_DIR . 'debug.php';

/**
 * \brief	LoveController class 
 * \details	controller di love/unlove
 */
class LoveController extends REST {

	/**
	 * \fn		init()
	 * \brief   start the session
	 */
    public function init() {
		session_start();
    }

	/**
	 * \fn		incrementLove()
	 * \brief   increments loveCounter property of an istance of a class
	 * \todo    usare la sessione
	 */
    public function incrementLove() {
		
		global $controllers;
		#TODO
		//in questa fase di debug, il fromUser lo passo staticamente e non lo recupero dalla session
		//questa sezione prima del try-catch dovr� sparire
		require_once CLASSES_DIR . 'user.class.php';
		$currentUser = new User('SPOTTER');
		$currentUser->setObjectId('GuUAj83MGH');

		try {
			//if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
			if ($this->get_request_method() != 'POST') {
				$this->response('', 406);
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
            
			switch ($classType) {
				case 'Album':
					require_once CLASSES_DIR . 'albumParse.class.php';
					$albumParse = new AlbumParse();
					$res = $albumParse->incrementAlbum($objectId, 'loveCounter', 1);
					$activity->setAlbum($objectId);
					$activity->setType("LOVEDALBUM");
					//$album = $albumParse->getAlbum($objectId);
					//$activity->setToUser($album->getFromUser());
					break;
				case 'Comment':
					require_once CLASSES_DIR . 'commentParse.class.php';
					$commentParse = new CommentParse();
					$res = $commentParse->incrementComment($objectId, 'loveCounter', 1);
					$activity->setComment($objectId);
					$activity->setType("LOVEDCOMMENT");
					//$comment = $commentParse->getComment($objectId);
					//$activity->setToUser($comment->getFromUser());
					break;
				case 'Event':
					require_once CLASSES_DIR . 'eventParse.class.php';
					$eventParse = new EventParse();
					$res = $eventParse->incrementEvent($objectId, 'loveCounter', 1);
					$activity->setEvent($objectId);
					$activity->setType("LOVEDEVENT");
					//$event = $eventParse->getEvent($objectId);
					//$activity->setToUser($event->getFromUser());
					break;
				case 'Image':
					require_once CLASSES_DIR . 'imageParse.class.php';
					$imageParse = new ImageParse();
					$res = $imageParse->incrementImage($objectId, 'loveCounter', 1);
					$activity->setImage($objectId);
					$activity->setType("LOVEDIMAGE");
					//$image = $imageParse->getEvent($objectId);
					//$activity->setToUser($image->getFromUser());
					break;
				case 'Record':
					require_once CLASSES_DIR . 'recordParse.class.php';
					$recordParse = new RecordParse();
					$res = $recordParse->incrementRecord($objectId, 'loveCounter', 1);
					$activity->setRecord($objectId);
					$activity->setType("LOVEDRECORD");
					//$record = $recordParse->getRecord($objectId);
					//$activity->setToUser($record->getFromUser());
					break;
				case 'Song':
					require_once CLASSES_DIR . 'songParse.class.php';
					$songParse = new SongParse();
					$res = $songParse->incrementSong($objectId, 'loveCounter', 1);
					$activity->setSong($objectId);
					$activity->setType("LOVEDSONG");
					//$song = $songParse->getSong($objectId);
					//$activity->setToUser($song->getFromUser());
					break;
				case 'Status':
					require_once CLASSES_DIR . 'statusParse.class.php';
					$statusParse = new StatusParse();
					$res = $statusParse->incrementStatus($objectId, 'loveCounter', 1);
					$activity->setUserStatus($objectId);
					$activity->setType("LOVEDSTATUS");
					//$status = $statusParse->getStatus($objectId);
					//$activity->setToUser($status->getFromUser());
					break;
				case 'Video':
					require_once CLASSES_DIR . 'videoParse.class.php';
					$videoParse = new VideoParse();
					$res = $videoParse->incrementVideo($objectId, 'loveCounter', 1);
					$activity->setType("LOVEDVIDEO");
					$activity->setVideo($objectId);
					//$video = $videoParse->getVideo($objectId);
					//$activity->setToUser($video->getFromUser());
					break;
			}
			
			if (get_class($res) == 'Error') {
				$this->response(array($controllers['LOVEPLUSERR']), 503);
			} else {
				//salvo activity
				$activityParse = new ActivityParse();
				$resActivity = $activityParse->saveActivity($activity);
				if (get_class($resActivity) == 'Error') {
					$this->rollback($classType, $objectId, 'decrement');
				}
			}
			//risposta
			$this->response(array($res), 200);
		} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}
    }
	
	/**
	 * \fn		decrementLove()
	 * \brief   decrements loveCounter property of an istance of a class
	 * \todo    usare la sessione
	 */
	public function decrementLove() {
		
		global $controllers;
		#TODO
		//in questa fase di debug, il fromUser lo passo staticamente e non lo recupero dalla session
		//questa sezione prima del try-catch dovr� sparire
		require_once CLASSES_DIR . 'user.class.php';
		$currentUser = new User('SPOTTER');
		$currentUser->setObjectId('GuUAj83MGH');

		try {
			//if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
			if ($this->get_request_method() != 'POST') {
				$this->response('', 406);
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
            
			switch ($classType) {
				case 'Album':
					require_once CLASSES_DIR . 'albumParse.class.php';
					$albumParse = new AlbumParse();
					$res = $albumParse->decrementAlbum($objectId, 'loveCounter', 1);
					$activity->setAlbum($objectId);
					$activity->setType("UNLOVEDALBUM");
					//$album = $albumParse->getAlbum($objectId);
					//$activity->setToUser($album->getFromUser());
					break;
				case 'Comment':
					require_once CLASSES_DIR . 'commentParse.class.php';
					$commentParse = new CommentParse();
					$res = $commentParse->decrementComment($objectId, 'loveCounter', 1);
					$activity->setComment($objectId);
					$activity->setType("UNLOVEDCOMMENT");
					//$comment = $commentParse->getComment($objectId);
					//$activity->setToUser($comment->getFromUser());
					break;
				case 'Event':
					require_once CLASSES_DIR . 'eventParse.class.php';
					$eventParse = new EventParse();
					$res = $eventParse->decrementEvent($objectId, 'loveCounter', 1);
					$activity->setEvent($objectId);
					$activity->setType("UNLOVEDEVENT");
					//$event = $eventParse->getEvent($objectId);
					//$activity->setToUser($event->getFromUser());
					break;
				case 'Image':
					require_once CLASSES_DIR . 'imageParse.class.php';
					$imageParse = new ImageParse();
					$res = $imageParse->decrementImage($objectId, 'loveCounter', 1);
					$activity->setImage($objectId);
					$activity->setType("UNLOVEDIMAGE");
					//$image = $imageParse->getEvent($objectId);
					//$activity->setToUser($image->getFromUser());
					break;
				case 'Record':
					require_once CLASSES_DIR . 'recordParse.class.php';
					$recordParse = new RecordParse();
					$res = $recordParse->decrementRecord($objectId, 'loveCounter', 1);
					$activity->setRecord($objectId);
					$activity->setType("UNLOVEDRECORD");
					//$record = $recordParse->getRecord($objectId);
					//$activity->setToUser($record->getFromUser());
					break;
				case 'Song':
					require_once CLASSES_DIR . 'songParse.class.php';
					$songParse = new SongParse();
					$res = $songParse->decrementSong($objectId, 'loveCounter', 1);
					$activity->setSong($objectId);
					$activity->setType("UNLOVEDSONG");
					//$song = $songParse->getSong($objectId);
					//$activity->setToUser($song->getFromUser());
					break;
				case 'Status':
					require_once CLASSES_DIR . 'statusParse.class.php';
					$statusParse = new StatusParse();
					$res = $statusParse->decrementStatus($objectId, 'loveCounter', 1);
					$activity->setUserStatus($objectId);
					$activity->setType("UNLOVEDSTATUS");
					//$status = $statusParse->getStatus($objectId);
					//$activity->setToUser($status->getFromUser());
					break;
				case 'Video':
					require_once CLASSES_DIR . 'videoParse.class.php';
					$videoParse = new VideoParse();
					$res = $videoParse->decrementVideo($objectId, 'loveCounter', 1);
					$activity->setType("UNLOVEDVIDEO");
					$activity->setVideo($objectId);
					//$video = $videoParse->getVideo($objectId);
					//$activity->setToUser($video->getFromUser());
					break;
			}
			
        	if (get_class($res) == 'Error') {
				$this->response(array($controllers['LOVEMINUSERR']), 503);
			} else {
				//salvo activity
				$activityParse = new ActivityParse();
				$resActivity = $activityParse->saveActivity($activity);
				if (get_class($resActivity) == 'Error') {
					$this->rollback($classType, $objectId, 'increment');
				}
			}
			//risposta
			$this->response(array($res), 200);
		} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}

	}
	
	private function rollback($classType, $objectId, $operation) {
	
	global $controllers;
		switch ($classType) {
			case 'Album':
				require_once CLASSES_DIR . 'albumParse.class.php';
				$albumParse = new AlbumParse();
				if ($operation == 'increment') {
					$res = $albumParse->incrementAlbum($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $albumParse->decrementAlbum($objectId, 'loveCounter', 1);
				}
				break;
			case 'Comment':
				require_once CLASSES_DIR . 'commentParse.class.php';
				$commentParse = new CommentParse();
				if ($operation == 'increment') {
					$res = $commentParse->incrementComment($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $commentParse->decrementComment($objectId, 'loveCounter', 1);
				}
				break;
			case 'Event':
				require_once CLASSES_DIR . 'eventParse.class.php';
				$eventParse = new EventParse();
				if ($operation == 'increment') {
					$res = $eventParse->incrementEvent($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $eventParse->decrementEvent($objectId, 'loveCounter', 1);
				}
				break;
			case 'Image':
				require_once CLASSES_DIR . 'imageParse.class.php';
				$imageParse = new ImageParse();
				if ($operation == 'increment') {
					$res = $imageParse->incrementImage($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $imageParse->decrementImage($objectId, 'loveCounter', 1);
				}
				break;
			case 'Record':
				require_once CLASSES_DIR . 'recordParse.class.php';
				$recordParse = new RecordParse();
				if ($operation == 'increment') {
					$res = $recordParse->incrementRecord($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $recordParse->decrementRecord($objectId, 'loveCounter', 1);
				}
				break;
			case 'Song':
				require_once CLASSES_DIR . 'songParse.class.php';
				$songParse = new SongParse();
				if ($operation == 'increment') {
					$res = $songParse->incrementSong($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $songParse->decrementSong($objectId, 'loveCounter', 1);
				}
				break;
			case 'Status':
				require_once CLASSES_DIR . 'statusParse.class.php';
				$statusParse = new StatusParse();
				if ($operation == 'increment') {
					$res = $statusParse->incrementStatus($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $statusParse->decrementStatus($objectId, 'loveCounter', 1);
				}
				break;
			case 'Video':
				require_once CLASSES_DIR . 'videoParse.class.php';
				$videoParse = new VideoParse();
				if ($operation == 'increment') {
					$res = $videoParse->incrementVideo($objectId, 'loveCounter', 1);
				} elseif ($operation == 'decrement') {
					$res = $videoParse->decrementVideo($objectId, 'loveCounter', 1);
				}
				break;
		}
		
		if (get_class($res) == 'Error') {
			$this->response(array($controllers['ROLLKO']), 503);
		} else {
			$this->response(array($controllers['ROLLOK']), 503);
		}
	}
}
?>