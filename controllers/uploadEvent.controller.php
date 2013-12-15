<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activityParse.class.php';


require_once BOXES_DIR . "record.box.php";

class UploadEventController extends REST {

    public function init() {
//utente non loggato

        if (!isset($_SESSION['currentUser'])) {
            /* This will give an error. Note the output
             * above, which is before the header() call */
            header('Location: login.php?from=uploadEvent.php');
            exit;
        }
    }

    public function createEvent() {
        try {
            global $controllers;

            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 400);
            } elseif (!isset($this->request['title']) || is_null($this->request['title']) || !(strlen($this->request['title']) > 0)) {
                $this->response(array('status' => $controllers['NOEVENTTITLE']), 400);
            } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
                $this->response(array('status' => $controllers['NOEVENTDESCRIPTION']), 400);
            } elseif (!isset($this->request['date']) || is_null($this->request['date'])) {
                $this->response(array('status' => $controllers['NOEVENTDATE']), 400);
            } elseif (!isset($this->request['hours']) || is_null($this->request['hours'])) {
                $this->response(array('status' => $controllers['NOEVENTHOURS']), 400);
            } elseif (!isset($this->request['music']) || is_null($this->request['music'])) {
                $this->response(array('status' => $controllers['NOEVENTMUSIC']), 400);
            } elseif (!isset($this->request['url']) || is_null($this->request['url']) || !(strlen($this->request['url']) > 0)) {
                $this->response(array('status' => $controllers['NOEVENTURL']), 400);
            } elseif (!isset($this->request['venue']) || is_null($this->request['venue']) || !(strlen($this->request['venue']) > 0)) {
                $this->response(array('status' => $controllers['NOEVENTVENUE']), 400);
            } elseif (!isset($this->request['address']) || is_null($this->request['address']) || !(strlen($this->request['address']) > 0)) {
                $this->response(array('status' => $controllers['NOEVENTADDRESS']), 400);
            } elseif (!isset($this->request['image']) || is_null($this->request['image'])) {
                $this->response(array('status' => $controllers['NOEVENTIMAGE']), 400);
            } elseif (!isset($this->request['thumbnail']) || is_null($this->request['thumbnail'])) {
                $this->response(array('status' => $controllers['NOEVENTTHUMB']), 400);
            }
            $currentUser = $_SESSION['currentUser'];

            require_once CLASSES_DIR . 'event.class.php';
            $event = new Event();
            $event->setActive(true);
            $event->setAttendee(null);

            $address = $this->request['address'];

            $event->setAddress();
            $event->setCity();
            $event->setCommentCounter(0);
            $event->setCommentators(null);
            $event->setComments(null);
            $event->setCounter(0);
            $event->setDescription($this->request['description']);
            $event->setEventDate($this->getDate($this->request['date'],$this->request['hours'])); //tipo Date su parse
            $event->setFeaturing(null);
            $event->setFromUser($currentUser->getObjectId());
            $event->setImage($this->request['image']);
//            $event->setImageFile();
            $event->setInvited(null);
            $event->setLocation();
            $event->setLocationName();
            $event->setLoveCounter(0);
            $event->setLovers(null);
            $event->setRefused(null);
            $event->setReviewCounter(0);
            $event->setShareCounter(0);
            $event->setTags(array());
            $event->setThumbnail($this->request['thumbnail']);
            $event->setTitle($this->request['title']);
//            $event->setACL();
            require_once CLASSES_DIR . 'eventParse.class.php';
            $pEvent = new EventParse();

            $event = $pEvent->saveEvent($event);
            if ($event instanceof Error) {
                $this->response(array("status" => $controllers['EVENTCREATEERROR']), 503);
            }

            require_once CLASSES_DIR . 'activity.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(0);
            $activity->setCounter(0);
            $activity->setEvent($event->getObjectId());
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRead(true);
            $activity->setRecord(null);
            $activity->setSong(null);
            $activity->setStatus("A");
            $activity->setToUser(null);
            $activity->setType("EVENTCREATED");
            $activity->setUserStatus(null);
            $activity->setVideo(null);
//            $activity->setACL(toParseDefaultACL());
            require_once CLASSES_DIR . 'activityParse.class.php';


            $resFSCreation = $this->createFolderForEvent($currentUser->getObjectId(), $event->getObjectId());
            if ($resFSCreation instanceof Exception || !$resFSCreation) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackUploadEventController($event->getObjectId());
                $this->response(array("status" => $message), 503);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }

    private function getDate($day, $hours) {
        try {
            if (!isset($day) || is_null($day) || !(strlen($day) > 0)) {
                return null;
            } elseif (!isset($hours) || is_null($hours) || !(strlen($hours) > 0)) {
                return DateTime::createFromFormat("d/m/Y", $day)->format('Y-m-d');
            } else {
                return DateTime::createFromFormat("d/m/Y H:m", $day . " " . $hours)->format('Y-m-d HH:MM');
            }
        } catch (Exception $e) {
            return null;
        }
    }

}

?>
