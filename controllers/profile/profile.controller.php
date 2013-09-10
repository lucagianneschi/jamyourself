<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once PARSE_DIR . 'parse.php';

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
			case 'Album':
				require_once CLASSES_DIR . 'albumParse.class.php';
				$albumParse = new AlbumParse();
				$res = $albumParse->incrementAlbum($objectId, 'loveCounter', 1);
				break;
			case 'Comment':
				require_once CLASSES_DIR . 'commentParse.class.php';
				$commentParse = new CommentParse();
				$res = $commentParse->incrementComment($objectId, 'loveCounter', 1);
				break;
			case 'Event':
				require_once CLASSES_DIR . 'eventParse.class.php';
				$eventParse = new EventParse();
				$res = $eventParse->incrementEvent($objectId, 'loveCounter', 1);
				break;
			case 'Image':
				require_once CLASSES_DIR . 'imageParse.class.php';
				$imageParse = new ImageParse();
				$res = $imageParse->incrementImage($objectId, 'loveCounter', 1);
				break;
			case 'Record':
				require_once CLASSES_DIR . 'recordParse.class.php';
				$recordParse = new RecordParse();
				$res = $recordParse->incrementRecord($objectId, 'loveCounter', 1);
				break;
			case 'Song':
				require_once CLASSES_DIR . 'songParse.class.php';
				$songParse = new SongParse();
				$res = $songParse->incrementSong($objectId, 'loveCounter', 1);
				break;
			case 'Status':
				require_once CLASSES_DIR . 'statusParse.class.php';
				$statusParse = new StatusParse();
				$res = $statusParse->incrementStatus($objectId, 'loveCounter', 1);
				break;
			case 'Video':
				require_once CLASSES_DIR . 'videoParse.class.php';
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
			case 'Album':
				require_once CLASSES_DIR . 'albumParse.class.php';
				$albumParse = new AlbumParse();
				$res = $albumParse->decrementAlbum($objectId, 'loveCounter', 1);
				break;
			case 'Comment':
				require_once CLASSES_DIR . 'commentParse.class.php';
				$commentParse = new CommentParse();
				$res = $commentParse->decrementComment($objectId, 'loveCounter', 1);
				break;
			case 'Event':
				require_once CLASSES_DIR . 'eventParse.class.php';
				$eventParse = new EventParse();
				$res = $eventParse->decrementEvent($objectId, 'loveCounter', 1);
				break;
			case 'Image':
				require_once CLASSES_DIR . 'imageParse.class.php';
				$imageParse = new ImageParse();
				$res = $imageParse->decrementImage($objectId, 'loveCounter', 1);
				break;
			case 'Record':
				require_once CLASSES_DIR . 'recordParse.class.php';
				$recordParse = new RecordParse();
				$res = $recordParse->decrementRecord($objectId, 'loveCounter', 1);
				break;
			case 'Song':
				require_once CLASSES_DIR . 'songParse.class.php';
				$songParse = new SongParse();
				$res = $songParse->decrementSong($objectId, 'loveCounter', 1);
				break;
			case 'Status':
				require_once CLASSES_DIR . 'statusParse.class.php';
				$statusParse = new StatusParse();
				$res = $statusParse->decrementStatus($objectId, 'loveCounter', 1);
				break;
			case 'Video':
				require_once CLASSES_DIR . 'videoParse.class.php';
				$videoParse = new VideoParse();
				$res = $videoParse->decrementVideo($objectId, 'loveCounter', 1);
				break;
		}
        
		$this->response(array($res), 200);
    }

}
?>