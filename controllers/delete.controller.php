<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di cancellazione 
 * \details		controller di cancellazione istanza di una classe
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
require_once DEBUG_DIR . 'debug.php';

/**
 * \brief	DeleteController class 
 * \details	controller di cancellazione 
 */
class DeleteController extends REST {

    /**
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
		session_start();
    }

    /**
     * \fn		delete()
     * \brief   logical delete of instance of a class
     */
    public function deleteObj() {
	
		global $controllers;
		
		#TODO
		//simulo che l'utente in sessione sia GuUAj83MGH
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
			$activity->setActive(true);
			$activity->setCounter(0);
			$activity->setFromUser($currentUser->getObjectId());
			$activity->setRead(true);
			$activity->setStatus("A");

			switch ($classType) {
				case 'Activity':
					$activityParse = new ActivityParse();
					$act = $activityParse->getActivity($objectId);
					if (get_class($act) == 'Error') {
						$this->response(array('Error: ' . $act->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $act->getFromUser()) {
						$res = $activityParse->deleteActivity($objectId);
						$activity->setAlbum($objectId);
						$activity->setType("DELETEDACTIVITY");
						//$activity = $activityParse->getActivity($objectId);
						//$activity->setToUser($activity->getFromUser());
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Album':
					require_once CLASSES_DIR . 'albumParse.class.php';
					$albumParse = new AlbumParse();
					$album = $albumParse->getAlbum($objectId);
					if (get_class($album) == 'Error') {
						$this->response(array('Error: ' . $album->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $album->getFromUser()) {
						$res = $albumParse->deleteAlbum($objectId);
						$activity->setAlbum($objectId);
						$activity->setType("DELETEDALBUM");
						//$album = $albumParse->getAlbum($objectId);
						//$activity->setToUser($album->getFromUser());
					} else {
						$this->response(array($controllers['CND']), 401);		
					}
					break;
				case 'Comment':
					require_once CLASSES_DIR . 'commentParse.class.php';
					$commentParse = new CommentParse();
					$comment = $commentParse->getComment($objectId);
					if (get_class($comment) == 'Error') {
						$this->response(array('Error: ' . $comment->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $comment->getFromUser()) {
						$res = $commentParse->deleteComment($objectId);
						$activity->setComment($objectId);
						$activity->setType("DELETEDCOMMENT");
						//$comment = $commentParse->getComment($objectId);
						//$activity->setToUser($comment->getFromUser());
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Event':
					require_once CLASSES_DIR . 'eventParse.class.php';
					$eventParse = new EventParse();
					$event = $eventParse->getEvent($objectId);
					if (get_class($event) == 'Error') {
						$this->response(array('Error: ' . $event->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $event->getFromUser()) {
						$res = $eventParse->deleteEvent($objectId);
						$activity->setEvent($objectId);
						$activity->setType("DELETEDEVENT");
						//$event = $eventParse->getEvent($objectId);
						//$activity->setToUser($event->getFromUser());
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Image':
					require_once CLASSES_DIR . 'imageParse.class.php';
					$imageParse = new ImageParse();
					$image = $imageParse->getImage($objectId);
					if (get_class($image) == 'Error') {
						$this->response(array('Error: ' . $image->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $image->getFromUser()) {
						$res = $imageParse->deleteImage($objectId);
						$activity->setImage($objectId);
						$activity->setType("DELETEDIMAGE");
						//$image = $imageParse->getEvent($objectId);
						//$activity->setToUser($image->getFromUser());					
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Playlist':
					require_once CLASSES_DIR . 'playlistParse.class.php';
					$playlistParse = new PlaylistParse();
					$playlist = $playlistParse->getPlaylist($objectId);
					if (get_class($playlist) == 'Error') {
						$this->response(array('Error: ' . $playlist->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $playlist->getFromUser()) {
						$res = $playlistParse->deletePlaylist($objectId);
						$activity->setPlaylist($objectId);
						$activity->setType("DELETEDPLAYLIST");
						//$playlist = $playlistParse->getPlaylist($objectId);
						//$activity->setToUser($playlist->getFromUser());
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Record':
					require_once CLASSES_DIR . 'recordParse.class.php';
					$recordParse = new RecordParse();
					$record = $recordParse->getRecord($objectId);
					if (get_class($record) == 'Error') {
						$this->response(array('Error: ' . $record->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $record->getFromUser()) {
						$res = $recordParse->deleteRecord($objectId);
						$activity->setRecord($objectId);
						$activity->setType("DELETEDRECORD");
						//$record = $recordParse->getRecord($objectId);
						//$activity->setToUser($record->getFromUser());					
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Song':
					require_once CLASSES_DIR . 'songParse.class.php';
					$songParse = new SongParse();
					$song = $songParse->getSong($objectId);
					if (get_class($song) == 'Error') {
						$this->response(array('Error: ' . $song->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $song->getFromUser()) {
						$res = $songParse->deleteSong($objectId);
						$activity->setSong($objectId);
						$activity->setType("DELETEDSONG");
						//$song = $songParse->getSong($objectId);
						//$activity->setToUser($song->getFromUser());
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Status':
					require_once CLASSES_DIR . 'statusParse.class.php';
					$statusParse = new StatusParse();
					$status = $statusParse->getStatus($objectId);
					if (get_class($status) == 'Error') {
						$this->response(array('Error: ' . $status->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $status->getFromUser()) {
						$res = $statusParse->deleteStatus($objectId);
						$activity->setUserStatus($objectId);
						$activity->setType("DELETEDSTATUS");
						//$status = $statusParse->getStatus($objectId);
						//$activity->setToUser($status->getFromUser());					
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'User':
					require_once CLASSES_DIR . 'userParse.class.php';
					require_once CLASSES_DIR . 'utils.php';
					require_once SERVICES_DIR . 'mail.service.php';
					global $mail_files;
					if ($currentUser->getObjectId() == $objectId) {
						$userParse = new UserParse();
						$res = $userParse->deleteUser($objectId);
						$activity->setType("DELETEDUSER");
						$activity->setToUser($objectId);
						//$activity->setToUser($objectId);
						
						try {
							$mail = mailService();
							#TODO
							//$mail->AddAddress($user->getEmail());
							$mail->AddAddress('daniele.caldelli@gmail.com');
							
							$mail->Subject = $controllers['SBJ'];
							$mail->Body    = file_get_contents(STDHTML_DIR . $mail_files['USERDELETED']);
							#TODO
							$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

							if(!$mail->send()) {
							   #TODO
							   //l'invio della mail � andato male
							}
							
							#TODO
							//l'invio della mail � andato a buon fine
							
							$mail->SmtpClose();
						} catch (phpmailerException $e) {
							echo 'Eccezione ' . $e->getMessage();
							//throwError($e, __CLASS__, __FUNCTION__, func_get_args());
						} catch (Exception $e) {
							echo 'Eccezione ' . $e->getMessage();
							//throwError($e, __CLASS__, __FUNCTION__, func_get_args());
						}
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
				case 'Video':
					require_once CLASSES_DIR . 'videoParse.class.php';
					$videoParse = new VideoParse();
					$video = $videoParse->getVideo($objectId);
					if (get_class($video) == 'Error') {
						$this->response(array('Error: ' . $video->getMessage()), 503);
					}
					if ($currentUser->getObjectId() == $video->getFromUser()) {
						$res = $videoParse->deleteVideo($objectId);
						$activity->setType("DELETEDVIDEO");
						$activity->setVideo($objectId);
						//$video = $videoParse->getVideo($objectId);
						//$activity->setToUser($video->getFromUser());
					} else {
						$this->response(array($controllers['CND']), 401);
					}
					break;
			}

			if (get_class($res) == 'Error') {
				$this->response(array($controllers['DELERR']), 503);
			} else {
				$activityParse = new ActivityParse();
				$resActivity = $activityParse->saveActivity($activity);
				if (get_class($resActivity) == 'Error') {
					$this->rollback($classType, $objectId);
				}
			}
			
			$this->response(array('OK'), 200);
		} catch (Exception $e) {
			$this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}
	}

	private function rollback($classType, $objectId) {
	
	global $controllers;
		switch ($classType) {
			case 'Activity':
				require_once CLASSES_DIR . 'activityParse.class.php';
				$activityParse = new ActivityParse();
				$res = $activityParse->updateField($objectId, 'active', true);
				break;
			case 'Album':
				require_once CLASSES_DIR . 'albumParse.class.php';
				$albumParse = new AlbumParse();
				$res = $albumParse->updateField($objectId, 'active', true);
				break;
			case 'Comment':
				require_once CLASSES_DIR . 'commentParse.class.php';
				$commentParse = new CommentParse();
				$res = $commentParse->updateField($objectId, 'active', true);
				break;
			case 'Event':
				require_once CLASSES_DIR . 'eventParse.class.php';
				$eventParse = new EventParse();
				$res = $eventParse->updateField($objectId, 'active', true);
				break;
			case 'Image':
				require_once CLASSES_DIR . 'imageParse.class.php';
				$imageParse = new ImageParse();
				$res = $imageParse->updateField($objectId, 'active', true);
				break;
			case 'Playlist':
				require_once CLASSES_DIR . 'playlistParse.class.php';
				$playlistParse = new PlaylistParse();
				$res = $playlistParse->updateField($objectId, 'active', true);
				break;
			case 'Record':
				require_once CLASSES_DIR . 'recordParse.class.php';
				$recordParse = new RecordParse();
				$res = $recordParse->updateField($objectId, 'active', true);
				break;
			case 'Song':
				require_once CLASSES_DIR . 'songParse.class.php';
				$songParse = new SongParse();
				$res = $songParse->updateField($objectId, 'active', true);
				break;
			case 'Status':
				require_once CLASSES_DIR . 'statusParse.class.php';
				$statusParse = new StatusParse();
				$res = $statusParse->updateField($objectId, 'active', true);
				break;
			case 'Video':
				require_once CLASSES_DIR . 'videoParse.class.php';
				$videoParse = new VideoParse();
				$res = $videoParse->updateField($objectId, 'active', true);
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