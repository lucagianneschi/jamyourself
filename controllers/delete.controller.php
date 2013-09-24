<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

	
define('CND', 'Cannot delete this element: you are not its owner!');	
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

class DeleteController extends REST {

    public function init() {
		session_start();
    }

    public function delete() {
		
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
            $activity->setAccepted(true);
            $activity->setActive(true);
			$activity->setCounter(0);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setRead(true);
            $activity->setStatus("A");
            
			switch ($classType) {
				case 'Activity':
					$activityParse = new ActivityParse();
					$act = $activityParse->getActivity($objectId);
					if($currentUser == $act->fromUser){
						$res = $activityParse->deleteActivity($objectId);
						$activity->setAlbum($objectId);
						$activity->setType("DELETEDACTIVITY");
						//$activity = $activityParse->getActivity($objectId);
						//$activity->setToUser($activity->getFromUser());
					} else {
						$this->response(array(CND), 200);
					}
					break;			
				case 'Album':
					require_once CLASSES_DIR . 'albumParse.class.php';
					$albumParse = new AlbumParse();
					$album = $albumParse->getAlbum($objectId);
					if($currentUser == $album->fromUser){
						$res = $albumParse->deleteAlbum($objectId);
						$activity->setAlbum($objectId);
						$activity->setType("DELETEDALBUM");
						//$album = $albumParse->getAlbum($objectId);
						//$activity->setToUser($album->getFromUser());
					}else {
						$this->response(array(CND), 200);
					}
					break;
				case 'Comment':
					require_once CLASSES_DIR . 'commentParse.class.php';
					$commentParse = new CommentParse();
					$comment = $commentParse->getComment($objectId);
					if($currentUser == $comment->fromUser()){
						$res = $commentParse->deleteComment($objectId);
						$activity->setComment($objectId);
						$activity->setType("DELETEDCOMMENT");
						//$comment = $commentParse->getComment($objectId);
						//$activity->setToUser($comment->getFromUser());
					} else {
						$this->response(array(CND), 200);
					}
					break;
				case 'Event':
					require_once CLASSES_DIR . 'eventParse.class.php';
					$eventParse = new EventParse();
					$event = $eventParse->getEvent($objectId);
					if($currentUser == $comment->fromUser()){
						$res = $eventParse->deleteEvent($objectId);
						$activity->setEvent($objectId);
						$activity->setType("DELETEDEVENT");
						//$event = $eventParse->getEvent($objectId);
						//$activity->setToUser($event->getFromUser());
					} else {
						$this->response(array(CND), 200);
					}
					break;
				case 'Image':
					require_once CLASSES_DIR . 'imageParse.class.php';
					$imageParse = new ImageParse();
					$image = $imageParse->getImage($objectId);
					if($currentUser == $image->fromUser()){
						$res = $imageParse->deleteImage($objectId);
						$activity->setImage($objectId);
						$activity->setType("DELETEDIMAGE");
						//$image = $imageParse->getEvent($objectId);
						//$activity->setToUser($image->getFromUser());					
					} else {
						$this->response(array(CND), 200);
					}
					break;
				case 'Playlist':
					require_once CLASSES_DIR . 'playlistParse.class.php';
					$playlistParse = new PlaylistParse();
					$playlist = $playlistParse->getPlaylist($objectId);
					if($currentUser == $playlist->fromUser()){
						$res = $playlistParse->deletePlaylist($objectId);
						$activity->setPlaylist($objectId);
						$activity->setType("DELETEDPLAYLIST");
						//$playlist = $playlistParse->getPlaylist($objectId);
						//$activity->setToUser($playlist->getFromUser());
					} else {
						$this->response(array(CND), 200);
					}
					break;
				case 'Record':
					require_once CLASSES_DIR . 'recordParse.class.php';
					$recordParse = new RecordParse();
					$record = $recordParse->getRecord($objectId);
					if($currentUser == $record->fromUser()){
						$res = $recordParse->deleteRecord($objectId);
						$activity->setRecord($objectId);
						$activity->setType("DELETEDRECORD");
						//$record = $recordParse->getRecord($objectId);
						//$activity->setToUser($record->getFromUser());					
					} else {
						$this->response(array(CND), 200);
					}				
					break;
				case 'Song':
					require_once CLASSES_DIR . 'songParse.class.php';
					$songParse = new SongParse();
					$song = $songParse->getSong($objectId);
					if($currentUser == $song->fromUser()){
						$res = $songParse->deleteSong($objectId);
						$activity->setSong($objectId);
						$activity->setType("DELETEDSONG");
						//$song = $songParse->getSong($objectId);
						//$activity->setToUser($song->getFromUser());
					} else {
						$this->response(array(CND), 200);
					}					
					break;
				case 'Status':
					require_once CLASSES_DIR . 'statusParse.class.php';
					$statusParse = new StatusParse();
					$status = $statusParse->getStatus($objectId);
					if($currentUser == $song->fromUser()){
						$res = $statusParse->deleteStatus($objectId);
						$activity->setUserStatus($objectId);
						$activity->setType("DELETEDSTATUS");
						//$status = $statusParse->getStatus($objectId);
						//$activity->setToUser($status->getFromUser());					
					} else {
						$this->response(array(CND), 200);
					}
					break;
				case 'User':
					require_once CLASSES_DIR . 'userParse.class.php';
					$userParse = new UserParse();
					$user = $userParse->getUser($objectId);
					if($currentUser == $song->fromUser()){
						$res = $userParse->deleteUser($objectId);
						$activity->setType("DELETEDUSER");
						$activity->setToUser($objectId);
						//$activity->setToUser($objectId);
					} else {
						$this->response(array(CND), 200);
					}
					break;
				case 'Video':
					require_once CLASSES_DIR . 'videoParse.class.php';
					$videoParse = new VideoParse();
					$video = $videoParse->getVideo($objectId);
					if($currentUser == $song->fromUser()){
						$res = $videoParse->deleteVideo($objectId);
						$activity->setType("DELETEDVIDEO");
						$activity->setVideo($objectId);
						//$video = $videoParse->getVideo($objectId);
						//$activity->setToUser($video->getFromUser());
					} else {
						$this->response(array(CND), 200);
					}				
					break;
			}
			
			if (get_class($res) == 'Error') {
				$this->response(array($res), 503);
			}
			
			$activityParse = new ActivityParse();
			$resActivity = $activityParse->saveActivity($activity);
			
			if (get_class($resActivity) == 'Error') {
				$this->response(array($resActivity), 503);
			}
							
			$this->response(array($res), 200);
						
		} catch (Exception $e) {
			$this->response(array($e), 503);
		}
    }
}
?>