<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'imageParse.class.php';

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
			case 'Image':
				$parseObject = new parseObject($classType);
				$parseObject->increment('loveCounter', array(1));
				$res = $parseObject->update($objectId);
				break;
			case 'Song':
				//ecc...
				break;
		}
		
        $this->response(array($res->loveCounter), 200);
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