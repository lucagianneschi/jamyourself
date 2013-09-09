<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once PARSE_DIR . 'parse.php';
//spostarli dentro lo switch??
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'statusParse.class.php';
require_once CLASSES_DIR . 'videoParse.class.php';

class ProfileController extends REST {

    public function init() {
		session_start();
    }

    public function incrementLove() {
        //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
		if ($this->get_request_method() != 'POST') {
            $this->response('', 406);
        }
		$objectId = $_REQUEST['objectId'];
		$classType = $_REQUEST['classType'];
		switch ($classType) {
			case 'Activity':
				$activityParse = new ActivityParse();
				$res = $activityParse->incrementActivity($objectId, 'loveCounter', 1);
				break;
			case 'Album':
				$albumParse = new AlbumParse();
				$res = $albumParse->incrementAlbum($objectId, 'loveCounter', 1);
				break;
			case 'Comment':
				$commentParse = new CommentParse();
				$res = $commentParse->incrementComment($objectId, 'loveCounter', 1);
				break;
			case 'Event':
				$eventParse = new EventParse();
				$res = $eventParse->incrementEvent($objectId, 'loveCounter', 1);
				break;
			case 'Image':
				$imageParse = new ImageParse();
				$res = $imageParse->incrementImage($objectId, 'loveCounter', 1);
				break;
			case 'Record':
				$recordParse = new RecordParse();
				$res = $recordParse->incrementRecord($objectId, 'loveCounter', 1);
				break;
			case 'Song':
				$songParse = new SongParse();
				$res = $songParse->incrementSong($objectId, 'loveCounter', 1);
				break;
			case 'Status':
				$statusParse = new StatusParse();
				$res = $statusParse->incrementStatus($objectId, 'loveCounter', 1);
				break;
			case 'Video':
				$videoParse = new VideoParse();
				$res = $videoParse->incrementVideo($objectId, 'loveCounter', 1);
				break;
		}
		
		$this->response(array($res), 200);
    }
	
	public function decrementLove() {
        //if ($this->get_request_method() != 'POST' || !isset($_SESSION['currentUser'])) {
		if ($this->get_request_method() != 'POST') {
            $this->response('', 406);
        }
		
		$objectId = $_REQUEST['objectId'];
		$classType = $_REQUEST['classType'];
		switch ($classType) {
			case 'Image':
				$imageParse = new ImageParse();
				$res = $imageParse->decrementImage($objectId, 'loveCounter', 1);
				break;
			case 'Song':
				//ecc...
				break;
		}
        
		$this->response(array($res), 200);
    }

}
?>