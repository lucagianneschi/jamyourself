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
require_once SERVICES_DIR . 'debug.service.php';

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
            }elseif (!isset($this->request['objectId'])) {
                $this->response(array('status' => $controllers['NOOBJECTID']), 403);
            }
            $objectId = $this->request['objectId'];
            $classType = $this->request['classType'];
            $currentUser = $this->request['currentUser'];
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
                    if ($act instanceof Error) {
                        $this->response(array('status' =>$controllers['NOACTIVITFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $act->getFromUser()) {
                        $res = $activityParse->deleteActivity($objectId);
                        $activity->setType("DELETEDACTIVITY");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Album':
                    require_once CLASSES_DIR . 'albumParse.class.php';
                    $albumParse = new AlbumParse();
                    $album = $albumParse->getAlbum($objectId);
                    if ($album instanceof Error) {
                        $this->response(array('status' =>$controllers['NOALBUMFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $album->getFromUser()) {
                        $res = $albumParse->deleteAlbum($objectId);
                        $activity->setAlbum($objectId);
                        $activity->setType("DELETEDALBUM");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Comment':
                    require_once CLASSES_DIR . 'commentParse.class.php';
                    $commentParse = new CommentParse();
                    $comment = $commentParse->getComment($objectId);
                    if ($comment instanceof Error) {
                        $this->response(array('status' =>$controllers['NOCOMMENTFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $comment->getFromUser()) {
                        $res = $commentParse->deleteComment($objectId);
                        $activity->setComment($objectId);
                        $activity->setType("DELETEDCOMMENT");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Event':
                    require_once CLASSES_DIR . 'eventParse.class.php';
                    $eventParse = new EventParse();
                    $event = $eventParse->getEvent($objectId);
                    if ($event instanceof Error) {
                        $this->response(array('status' =>$controllers['NOEVENTFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $event->getFromUser()) {
                        $res = $eventParse->deleteEvent($objectId);
                        $activity->setEvent($objectId);
                        $activity->setType("DELETEDEVENT");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Image':
                    require_once CLASSES_DIR . 'imageParse.class.php';
                    $imageParse = new ImageParse();
                    $image = $imageParse->getImage($objectId);
                    if ($image instanceof Error) {
                        $this->response(array('status' =>$controllers['NOIMAGEFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $image->getFromUser()) {
                        $res = $imageParse->deleteImage($objectId);
                        $activity->setImage($objectId);
                        $activity->setType("DELETEDIMAGE");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Playlist':
                    require_once CLASSES_DIR . 'playlistParse.class.php';
                    $playlistParse = new PlaylistParse();
                    $playlist = $playlistParse->getPlaylist($objectId);
                    if ($playlist instanceof Error) {
                        $this->response(array($controllers['NOPLAYLISTFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $playlist->getFromUser()) {
                        $res = $playlistParse->deletePlaylist($objectId);
                        $activity->setPlaylist($objectId);
                        $activity->setType("DELETEDPLAYLIST");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Record':
                    require_once CLASSES_DIR . 'recordParse.class.php';
                    $recordParse = new RecordParse();
                    $record = $recordParse->getRecord($objectId);
                    if ($record instanceof Error) {
                        $this->response(array('status' =>$controllers['NORECORDFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $record->getFromUser()) {
                        $res = $recordParse->deleteRecord($objectId);
                        $activity->setRecord($objectId);
                        $activity->setType("DELETEDRECORD");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Song':
                    require_once CLASSES_DIR . 'songParse.class.php';
                    $songParse = new SongParse();
                    $song = $songParse->getSong($objectId);
                    if ($song instanceof Error) {
                        $this->response(array('status' =>$controllers['NOSONGFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $song->getFromUser()) {
                        $res = $songParse->deleteSong($objectId);
                        $activity->setSong($objectId);
                        $activity->setType("DELETEDSONG");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Status':
                    require_once CLASSES_DIR . 'statusParse.class.php';
                    $statusParse = new StatusParse();
                    $status = $statusParse->getStatus($objectId);
                    if ($status instanceof Error) {
                        $this->response(array('status' =>$controllers['NOSTATUSFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $status->getFromUser()) {
                        $res = $statusParse->deleteStatus($objectId);
                        $activity->setUserStatus($objectId);
                        $activity->setType("DELETEDSTATUS");
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'User':
                    require_once CLASSES_DIR . 'userParse.class.php';
                    require_once CLASSES_DIR . 'utils.php';
                    require_once SERVICES_DIR . 'mail.service.php';
                    global $mail_files;
                    if ($currentUser->getObjectId() === $objectId) {
                        $userParse = new UserParse();
                        $res = $userParse->deleteUser($objectId);
                        $activity->setType("DELETEDUSER");
                        $activity->setToUser($objectId);
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
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
                case 'Video':
                    require_once CLASSES_DIR . 'videoParse.class.php';
                    $videoParse = new VideoParse();
                    $video = $videoParse->getVideo($objectId);
                    if ($video instanceof Error) {
                        $this->response(array('status' =>$controllers['NOVIDEOFORDELETE']), 503);
                    }
                    if ($currentUser->getObjectId() == $video->getFromUser()) {
                        $res = $videoParse->deleteVideo($objectId);
                        $activity->setType("DELETEDVIDEO");
                        $activity->setVideo($objectId);
                    } else {
                        $this->response(array('status' =>$controllers['CND']), 401);
                    }
                    break;
            }
            if ($res instanceof Error) {
                $this->response(array('status' =>$controllers['DELERR']), 503);
            } else {
                $activityParse = new ActivityParse();
                $resActivity = $activityParse->saveActivity($activity);
                if ($resActivity instanceof Error) {
//		    require_once CONTROLLERS_DIR . 'rollBack.controller.php';
//		    $rollBackController = new RollBackController();
//		    $rollBackController->rollbackDeleteController($classType, $objectId);
                    $this->rollback($classType, $objectId);
                }
            }
            $this->response(array($controllers['DELETEOK']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
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
        if ($res instanceof Error) {
            $this->response(array('status' =>$controllers['ROLLKO']), 503);
        } else {
            $this->response(array('status' =>$controllers['ROLLOK']), 503);
        }
    }

}

?>