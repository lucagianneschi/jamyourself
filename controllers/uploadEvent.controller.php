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
require_once BOXES_DIR . "utilsBox.php";



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
            } elseif (!isset($this->request['tags']) || is_null($this->request['tags']) || !is_array($this->request['tags']) || !(count($this->request['tags'])>0)) {
                $this->response(array('status' => $controllers['NOEVENTTAGS']), 400);
            } elseif (!isset($this->request['jammers']) || is_null($this->request['jammers']) || !is_array($this->request['jammers']) || !(count($this->request['jammers']) > 0)) {
                $this->response(array('status' => $controllers['NOEVENTURL']), 400);
            } elseif (!isset($this->request['venue']) || is_null($this->request['venue']) || !(strlen($this->request['venue']) > 0)) {
                $this->response(array('status' => $controllers['NOEVENTVENUE']), 400);
            } elseif (!isset($this->request['image']) || is_null($this->request['image'])) {
                $this->response(array('status' => $controllers['NOEVENTIMAGE']), 400);
            } elseif (!isset($this->request['crop']) || is_null($this->request['crop'])) {
                $this->response(array('status' => $controllers['NOEVENTTHUMB']), 400);
            } elseif (!isset($this->request['city']) || is_null($this->request['city'])) {
                $this->response(array('status' => $controllers['NOEVENTADDRESS']), 400);
            }
            $currentUser = $_SESSION['currentUser'];
            $userId = $currentUser->getObjectId();
            require_once CLASSES_DIR . 'event.class.php';
            $event = new Event();
            $event->setActive(true);
            $event->setAttendee(null);
            $event->setCommentCounter(0);
            $event->setCommentators(null);
            $event->setComments(null);
            $event->setCounter(0);
            $event->setDescription($this->request['description']);
            $event->setEventDate($this->getDate($this->request['date'], $this->request['hours'])); //tipo Date su parse
            $event->setFeaturing($this->request['jammers']);
            $event->setFromUser($userId);

            $imgInfo = $this->getImages($this->request);
            $event->setImage($imgInfo['EventPicture']);
            $event->setThumbnail($imgInfo['EventThumbnail']);

            $event->setInvited(null);
            $event->setLocationName($this->request['venue']);

            require_once SERVICES_DIR . 'geocoder.service.php';
            $infoLocation = GeocoderService::getCompleteLocationInfo($this->request['city']);
            $parseGeoPoint = new parseGeoPoint($infoLocation["latitude"], $infoLocation["longitude"]);
            $event->setLocation($parseGeoPoint);
            $event->setAddress($infoLocation["address"] . ", " . $infoLocation['number']);
            $event->setCity($infoLocation["city"]);

            $event->setLoveCounter(0);
            $event->setLovers(null);
            $event->setRefused(null);
            $event->setReviewCounter(0);
            $event->setShareCounter(0);
            $event->setTags($this->request['tags']);
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
            $activity->setFromUser($userId);
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

//SPOSTO LE IMMAGINI NELLE RISPETTIVE CARTELLE                


            $dirThumbnailDest = USERS_DIR . $userId . "/images/eventcover";
            $dirCoverDest = USERS_DIR . $userId . "/images/eventcoverthumb";

            $thumbSrc = $event->getThumbnail();
            $imageSrc = $event->getImage();
            if (!is_null($thumbSrc) && (strlen($thumbSrc) > 0) && !is_null($imageSrc) && (strlen($imageSrc) > 0)) {
                rename(MEDIA_DIR . "cache/" . $thumbSrc, $dirThumbnailDest . DIRECTORY_SEPARATOR . $thumbSrc);
                rename(MEDIA_DIR . "cache/" . $imageSrc, $dirCoverDest . DIRECTORY_SEPARATOR . $imageSrc);
            }

            unset($_SESSION['currentUserFeaturingArray']);

            $this->response(array('status' => $controllers['EVENTCREATED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }

    private function getDate($day, $hours) {
        try {
            if (!isset($day) || is_null($day) || !(strlen($day) > 0)) {
                return null;
            } elseif (!isset($hours) || is_null($hours) || !(strlen($hours) > 0)) {
                return DateTime::createFromFormat("d/m/Y", $day);
            } else {
                return DateTime::createFromFormat("d/m/Y H:m", $day . " " . $hours);
            }
        } catch (Exception $e) {
            return null;
        }
    }

    private function getImages($decoded) {
//in caso di anomalie ---> default
        if (!isset($decoded['crop']) || is_null($decoded['crop']) ||
                !isset($decoded['image']) || is_null($decoded['image'])) {
            return array("RecordPicture" => null, "RecordThumbnail" => null);
        }
        if (is_array($decoded)) {
            $decoded = json_decode(json_encode($decoded), false);
        }
        $PROFILE_IMG_SIZE = 300;
        $THUMBNAIL_IMG_SIZE = 150;

//recupero i dati per effettuare l'editing
        $cropInfo = json_decode(json_encode($decoded->crop), false);

        if (!isset($cropInfo->x) || is_null($cropInfo->x) || !is_numeric($cropInfo->x) ||
                !isset($cropInfo->y) || is_null($cropInfo->y) || !is_numeric($cropInfo->y) ||
                !isset($cropInfo->w) || is_null($cropInfo->w) || !is_numeric($cropInfo->w) ||
                !isset($cropInfo->h) || is_null($cropInfo->h) || !is_numeric($cropInfo->h)) {
            return array("EventPicture" => null, "EventThumbnail" => null);
        }
        $cacheDir = MEDIA_DIR . "cache/";
        $cacheImg = $cacheDir . $decoded->image;
        require_once SERVICES_DIR . 'cropImage.service.php';

//Preparo l'oggetto per l'editign della foto
        $cis = new CropImageService();

//gestione dell'immagine di profilo
        $coverId = $cis->cropImage($cacheImg, $cropInfo->x, $cropInfo->y, $cropInfo->w, $cropInfo->h, $PROFILE_IMG_SIZE);
        $coverUrl = $cacheDir . $coverId;

//gestione del thumbnail
        $thumbId = $cis->cropImage($coverUrl, 0, 0, $PROFILE_IMG_SIZE, $PROFILE_IMG_SIZE, $THUMBNAIL_IMG_SIZE);
        $thumbUrl = $cacheDir . $thumbId;

//CANCELLAZIONE DELLA VECCHIA IMMAGINE
        unlink($cacheImg);
//RETURN        
        return array('EventPicture' => $coverId, 'EventThumbnail' => $thumbId);
    }

    public function getFeaturingJSON() {
        try {
            global $controllers;
            $force = false;
            if (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 400);
            }

            if (isset($this->request['force']) && !is_null($this->request['force']) && $this->request['force'] == "true") {
                $force = true;
            }

            $currentUserFeaturingArray = null;
            if ($force == false && isset($_SESSION['currentUserFeaturingArray']) && !is_null($_SESSION['currentUserFeaturingArray'])) {//caching dell'array
                $currentUserFeaturingArray = $_SESSION['currentUserFeaturingArray'];
            } else {
                $currentUserFeaturingArray = $this->getFeaturingArray();
                $_SESSION['currentUserFeaturingArray'] = $currentUserFeaturingArray;
            }
            echo json_encode($currentUserFeaturingArray);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    private function getFeaturingArray() {
        error_reporting(E_ALL ^ E_NOTICE);
        if (isset($_SESSION['currentUser'])) {
            $currentUser = $_SESSION['currentUser'];
            $currentUserId = $currentUser->getObjectId();
            $userArray = getRelatedUsers($currentUserId, 'collaboration', '_User');
            if (($userArray instanceof Error) || is_null($userArray)) {
                return array();
            } else {
                $userArrayInfo = array();
                foreach ($userArray as $user) {
                    $username = $user->getUsername();
                    $userId = $user->getObjectId();
                    array_push($userArrayInfo, array("key" => $userId, "value" => $username));
                }
                return $userArrayInfo;
            }
        }
        else
            return array();
    }

}

?>
