<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once 'restController.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';
require_once CLASSES_DIR . 'locationParse.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';
require_once CLASSES_DIR . 'questionParse.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'statusParse.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'videoParse.class.php';

class TestController extends REST {

    public function test() {
        if ($this->get_request_method() != "POST") {
            $this->response(array('status' => "NO POST REQUEST"), 405);
        } else if (isset($this->request['forceError']) && $this->request['forceError']) {
            $this->response(array('status' => "FORCE ERROR OK"), 405);
        } else {
            $this->response(array("objectReturned" => array("param1" => "A value", "param2" => "anotherValue")), 200);
        }
    }

    public function getObject() {
        if ($this->get_request_method() != "POST") {
            $this->response(array('status' => "NO POST REQUEST"), 405);
        }
        $objectId = $this->request['objectId'];
        $class = $this->request['class'];
        try {

            $parse = null;
            $obj = null;

            switch ($class) {
                case 'activity' :
                    $parse = new ActivityParse();
                    $obj = $parse->getActivity($objectId);
                    break;
                case 'album' :
                    $parse = new AlbumParse();
                    $obj = $parse->getAlbum($objectId);
                    break;
                case 'comment' :
                    $parse = new CommentParse();
                    $obj = $parse->getComment($objectId);
                    break;
                case 'error' :
                    $parse = new ErrorParse();
                    $obj = $parse->getError($objectId);
                    break;
                case 'event' :
                    $parse = new EventParse();
                    $obj = $parse->getEvent($objectId);
                    break;
                case 'image' :
                    $parse = new ImageParse();
                    $obj = $parse->getImage($objectId);
                    break;
                case 'location' :
                    $parse = new LocationParse();
                    $obj = $parse->getLocation($objectId);
                    break;
                case 'playlist' :
                    $parse = new PlaylistParse();
                    $obj = $parse->getPlaylist($objectId);
                    break;
                case 'question' :
                    $parse = new QuestionParse();
                    $obj = $parse->getQuestion($objectId);
                    break;
                case 'record' :
                    $parse = new RecordParse();
                    $obj = $parse->getRecord($objectId);
                    break;
                case 'song' :
                    $parse = new SongParse();
                    $obj = $parse->getSong($objectId);
                    break;
                case 'status' :
                    $parse = new StatusParse();
                    $obj = $parse->getStatus($objectId);
                    break;
                case 'user' :
                    $parse = new UserParse();
                    $obj = $parse->getUser($objectId);
                    break;
                case 'video' :
                    $parse = new VideoParse();
                    $obj = $parse->getVideo($objectId);
                    break;
            }
            
            $str = "".$obj;
            $this->response(array('status' => "OK", "objectReturned" => $str), 200);
        } catch (Exception $e) {
            $this->response(array('status' => "KO", "objectReturned" => $e), 200);
        }
    }

}

?>