<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di cancellazione 
 * \details		controller di cancellazione istanza di una classe
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
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
 * \brief	DeleteController class 
 * \details	controller di cancellazione 
 */
class DeleteController extends REST {

    /**
     * \fn		delete()
     * \brief   logical delete of instance of a class
     * \todo    sistemare invio mail in caso di cancellazione utente
     */
    public function deleteObj() {
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['classType'])) {
		$this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
	    } elseif (!isset($this->request['id'])) {
		$this->response(array('status' => $controllers['NOOBJECTID']), 403);
	    }
	    $id = $this->request['id'];
	    $classType = $this->request['classType'];
	    $currentUser = $this->request['currentUser'];
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setCounter(0);
	    $activity->setFromuser($currentUser->getId());
	    $activity->setRead(true);
	    $activity->setStatus("A");
	    switch ($classType) {
		case 'Activity':
		    $activityParse = new ActivityParse();
		    $act = $activityParse->getActivity($id);
		    if ($act instanceof Error) {
			$this->response(array('status' => $controllers['NOACTIVITFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $act->getFromuser()) {
			$res = $activityParse->deleteActivity($id);
			$activity->setType("DELETEDACTIVITY");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Album':
		    require_once CLASSES_DIR . 'albumParse.class.php';
		    $albumParse = new AlbumParse();
		    $album = $albumParse->getAlbum($id);
		    if ($album instanceof Error) {
			$this->response(array('status' => $controllers['NOALBUMFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $album->getFromuser()) {
			$res = $albumParse->deleteAlbum($id);
			$activity->setAlbum($id);
			$activity->setType("DELETEDALBUM");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Comment':
		    require_once CLASSES_DIR . 'commentParse.class.php';
		    $commentParse = new CommentParse();
		    $comment = $commentParse->getComment($id);
		    if ($comment instanceof Error) {
			$this->response(array('status' => $controllers['NOCOMMENTFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $comment->getFromuser()) {
			$res = $commentParse->deleteComment($id);
			$activity->setComment($id);
			$activity->setType("DELETEDCOMMENT");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Event':
		    require_once CLASSES_DIR . 'eventParse.class.php';
		    $eventParse = new EventParse();
		    $event = $eventParse->getEvent($id);
		    if ($event instanceof Error) {
			$this->response(array('status' => $controllers['NOEVENTFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $event->getFromuser()) {
			$res = $eventParse->deleteEvent($id);
			$activity->setEvent($id);
			$activity->setType("DELETEDEVENT");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Image':
		    require_once CLASSES_DIR . 'imageParse.class.php';
		    $imageParse = new ImageParse();
		    $image = $imageParse->getImage($id);
		    if ($image instanceof Error) {
			$this->response(array('status' => $controllers['NOIMAGEFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $image->getFromuser()) {
			$res = $imageParse->deleteImage($id);
			$activity->setImage($id);
			$activity->setType("DELETEDIMAGE");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Playlist':
		    require_once CLASSES_DIR . 'playlistParse.class.php';
		    $playlistParse = new PlaylistParse();
		    $playlist = $playlistParse->getPlaylist($id);
		    if ($playlist instanceof Error) {
			$this->response(array($controllers['NOPLAYLISTFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $playlist->getFromuser()) {
			$res = $playlistParse->deletePlaylist($id);
			$activity->setPlaylist($id);
			$activity->setType("DELETEDPLAYLIST");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Record':
		    require_once CLASSES_DIR . 'recordParse.class.php';
		    $recordParse = new RecordParse();
		    $record = $recordParse->getRecord($id);
		    if ($record instanceof Error) {
			$this->response(array('status' => $controllers['NORECORDFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $record->getFromuser()) {
			$res = $recordParse->deleteRecord($id);
			$activity->setRecord($id);
			$activity->setType("DELETEDRECORD");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Song':
		    require_once CLASSES_DIR . 'songParse.class.php';
		    $songParse = new SongParse();
		    $song = $songParse->getSong($id);
		    if ($song instanceof Error) {
			$this->response(array('status' => $controllers['NOSONGFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $song->getFromuser()) {
			$res = $songParse->deleteSong($id);
			$activity->setSong($id);
			$activity->setType("DELETEDSONG");
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'User':
		    require_once CLASSES_DIR . 'userParse.class.php';
		    require_once CLASSES_DIR . 'utils.php';
		    require_once SERVICES_DIR . 'mail.service.php';
		    global $mail_files;
		    if ($currentUser->getId() === $id) {
			$userParse = new UserParse();
			$res = $userParse->deleteUser($id);
			$activity->setType("DELETEDUSER");
			$activity->setToUser($id);
			$mail = mailService();
			$mail->AddAddress($currentUser->getEmail());
			$mail->Subject = $controllers['SBJ'];
			$mail->Body = file_get_contents(STDHTML_DIR . $mail_files['USERDELETED']);
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			$resMail = $mail->Send();
			if ($resMail instanceof phpmailerException) {
			    $this->response(array('status' => $controllers['NOMAIL']), 403);
			}
			$mail->SmtpClose();
			unset($mail);
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
		case 'Video':
		    require_once CLASSES_DIR . 'videoParse.class.php';
		    $videoParse = new VideoParse();
		    $video = $videoParse->getVideo($id);
		    if ($video instanceof Error) {
			$this->response(array('status' => $controllers['NOVIDEOFORDELETE']), 503);
		    }
		    if ($currentUser->getId() == $video->getFromuser()) {
			$res = $videoParse->deleteVideo($id);
			$activity->setType("DELETEDVIDEO");
			$activity->setVideo($id);
		    } else {
			$this->response(array('status' => $controllers['CND']), 401);
		    }
		    break;
	    }
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['DELERR']), 503);
	    } else {
		$activityParse = new ActivityParse();
		$resActivity = $activityParse->saveActivity($activity);
		if ($resActivity instanceof Error) {
		    require_once CONTROLLERS_DIR . 'rollBackUtils.php';
		    $message = rollbackDeleteController($classType, $id);
		    $this->response(array('status' => $message), 503);
		}
	    }
	    $this->response(array($controllers['DELETEOK']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>