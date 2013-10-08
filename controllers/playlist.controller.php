<?php
/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione della playlist
 * \details		gestisce l'inserimento e la cancellazione di una song dalla traclist di una playlist
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
require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';
require_once DEBUG_DIR . 'debug.php';

/**
 * \brief	LoveController class 
 * \details	controller di love/unlove
 */
class PlaylistController extends REST {

	/**
	 * \fn		init()
	 * \brief   start the session
	 */
    public function init() {
		session_start();
    }

	/**
	 * \fn		addSong()
	 * \brief   add song to playlist
	 * \todo    usare la sessione
	 */
    public function addSong() {
		
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
			$playlistId = $_REQUEST['playlistId'];
			$songId = $_REQUEST['songId'];
			
			$playlistP = new PlaylistParse();
			$playlist = $playlistP->getPlaylist($playlistId);
			if (get_class($playlist) == 'Error') {
				$this->response(array('Error: ' . $playlist->getMessage()), 503);
			} else {
				$playlistP->updateField($playlistId, 'songs', $songId, true, 'add', 'Song');
		
				$activity = new Activity();
				$activity->setActive(true);
				$activity->setAccepted(true);
				$activity->setAlbum(null);
				$activity->setComment(null);
				$activity->setCounter(0);
				$activity->setEvent(null);
				#TODO
				$activity->setFromUser($currentUser);
				//$activity->setFromUser($fromUser->getObjectId());
				$activity->setImage(null);
				$activity->setPlaylist(null);
				$activity->setQuestion(null);
				$activity->setRead(false);
				$activity->setRecord(null);
				$activity->setSong(null);
				$activity->setStatus('A');
				$activity->setToUser($toUserObjectId);
				$activity->setType("SONGADDEDTOPLAYLIST");
				$activity->setUserStatus(null);
				$activity->setVideo(null);
			}
			$activityParse = new ActivityParse();
			$resActivity = $activityParse->saveActivity($activity);
			if (get_class($resActivity) == 'Error') {
				$this->rollback($objectId, 'add');
			}
			$this->response(array($res), 200);
		} catch (Exception $e) {
	    $this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}
    }

	/**
	 * \fn		removeSong()
	 * \brief   remove song to playlist
	 * \todo    usare la sessione
	 */
	public function removeSong() {
		
    }
	

	
	private function rollback($objectId, $operation) {


				if ($operation == 'add') {
					//rimuovi 
				} elseif ($operation == 'remove') {
					//aggiungi
				}

		
		if (get_class($res) == 'Error') {
			$this->response(array($controllers['ROLLKO']), 503);
		} else {
			$this->response(array($controllers['ROLLOK']), 503);
		}
	}
}
?>