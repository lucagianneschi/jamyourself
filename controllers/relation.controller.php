<?php

/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di invio/ricezione delle relazioni
 * \details		incrementa/decrementa il loveCounter di una classe e istanza corrispondente activity
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		 terminare funzioni, verificare che siano state istanziate tutte le activity
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	RelationController class
 * \details	controller per invio e ricezione relazioni
 * \todo        introdurre le rollback per le varie funzioni
 */
class RelationController extends REST {

    /**
     * \fn	acceptRelationRequest()
     * \brief   accept relationship request
     * \todo    test
     */
    public function acceptRelationRequest() {
        global $controllers;
        global $mail_files;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['activityId'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOACTIVITYID']), 403);
            } elseif (!isset($this->request['toUser'])) {
                $this->response(array('status' => $controllers['NOTOUSER']), 403);
            } elseif (!isset($this->request['toUserType'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSERTYPE']), 403);
            }
            $currentUser = $this->request['currentUser'];
            $activityId = $this->request['activityId'];
            $toUserId = $this->request['toUser'];
            $toUserType = $this->request['toUserType'];
            if ($this->relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserType, $toUserId)) {
                $this->response(array('status' => $controllers['ALREADYINREALTION']), 403);
            }
            $toUserP = new UserParse();
            $toUser = $toUserP->getUser($toUserId);
            $sessionTokenA = $currentUser->getSessionToken();
            if ($toUser instanceof Error) {
                $this->response(array('status' => $controllers['USERNOTFOUND']), 503);
            }
            $sessionTokenB = $toUserP->getSessionToken();
            if (!isset($sessionTokenB)) {
                $this->response(array('status' => $controllers['NOSESSIONTOKEN']), 503);
            }
            $fromUserA = new UserParse();
            if ($currentUser->getType() == 'SPOTTER' && $toUserType == 'SPOTTER') {
                $type = 'FRIENDSHIPACCEPTED';
                $HTMLFile = $mail_files['FRIENDSHIPACCEPTEDEMAIL'];
                $field = 'friendship';
                $resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'add', '_User');
                $counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'friendshipCounter', ($currentUser->getFriedshipCounter() + 1));
                $resB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'add', '_User');
                $counterB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'friendshipCounter', ($toUser->getFriedshipCounter() + 1));
                if ($resA instanceof Error) {
                    $this->response(array('status' => $controllers['NOFRIENDSHIPUPDATE']), 503);
                } elseif ($resB instanceof Error) {
                    $this->response(array('status' => $controllers['NOFRIENDSHIPUPDATE']), 503);
                } elseif ($counterA instanceof Error) {
                    $this->response(array('status' => $controllers['NOFRIENDSHIPCOUNTERUPDATE']), 503);
                } elseif ($counterB instanceof Error) {
                    $this->response(array('status' => $controllers['NOFRIENDSHIPCOUNTERUPDATE']), 503);
                }
            } else {
                $type = 'COLLABORATIONACCEPTED';
                $field = 'collaboration';
                $HTMLFile = $mail_files['COLLABORATIONACCEPTEDEMAIL'];
                //aggiungo alla relazione collaboration per entrambi e aumento il contatore collaboration per entrambi
                $counterCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'collaborationCounter', ($currentUser->getFriedshipCounter() + 1));
                $counterCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'collaborationCounter', ($toUser->getFriedshipCounter() + 1));
                $resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'add', '_User');
                $resB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'add', '_User');
                if ($resA instanceof Error) {
                    $this->response(array('status' => $controllers['NOCOLLABORATIONUPDATE']), 503);
                } elseif ($resB instanceof Error) {
                    $this->response(array('status' => $controllers['NOCOLLABORATIONUPDATE']), 503);
                } elseif ($counterCollaborationA instanceof Error) {
                    $this->response(array('status' => $controllers['NOCOLLABORATIONCOUNTERUPDATE']), 503);
                } elseif ($counterCollaborationB instanceof Error) {
                    $this->response(array('status' => $controllers['NOCOLLABORATIONCOUNTERUPDATE']), 503);
                }
                if ($currentUser->getType() == 'VENUE' && $toUserType == 'VENUE') {
                    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'venueCounter', ($currentUser->getVenueCounter() + 1));
                    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'venueCounter', ($toUser->getVenueCounter() + 1));
                } elseif ($currentUser->getType() == 'JAMMER' && $toUserType == 'JAMMER') {
                    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'jammerCounter', ($currentUser->getJammerCounter() + 1));
                    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'jammerCounter', ($toUser->getJammerCounter() + 1));
                } elseif ($currentUser->getType() == 'VENUE' && $toUserType == 'JAMMER') {
                    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'jammerCounter', ($currentUser->getJammerCounter() + 1));
                    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'venueCounter', ($toUser->getVenueCounter() + 1));
                } elseif ($currentUser->getType() == 'JAMMER' && $toUserType == 'VENUE') {
                    $specificCollaborationA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'venueCounter', ($currentUser->getVenueCounter() + 1));
                    $specificCollaborationB = $toUserP->updateField($toUser->getObjectId(), $sessionTokenB, 'jammerCounter', ($toUser->getJammerCounter() + 1));
                }
                if ($specificCollaborationA instanceof Error) {
                    $this->response(array('status' => $controllers['NOSPECIFICCOLLABORATIONCOUNTERUPDATE']), 503);
                } elseif ($specificCollaborationB instanceof Error) {
                    $this->response(array('status' => $controllers['NOSPECIFICCOLLABORATIONCOUNTERUPDATE']), 503);
                }
                require_once CLASSES_DIR . 'activityParse.class.php';
                $activityP = new ActivityParse();
                $res = $activityP->updateField($activityId, 'status', 'A');
                if ($res instanceof Error) {
                    $this->response(array('status' => $controllers['NOACTUPDATE']), 503);
                }
                $res1 = $activityP->updateField($activityId, 'read', true);
                if ($res1 instanceof Error) {
                    $this->response(array('status' => $controllers['NOACTUPDATE']), 503);
                }
                require_once SERVICES_DIR . 'mail.service.php';
                $mail = new MailService(true);
                $mail->IsHTML(true);
                $mail->AddAddress($toUser->getEmail());
                $mail->Subject = $controllers['SBJOK'];
                $mail->MsgHTML(file_get_contents(STDHTML_DIR . $HTMLFile));
                $resMail = $mail->Send();
                if ($resMail instanceof phpmailerException) {
                    $this->response(array('status' => $controllers['NOMAIL']), 403);
                }
                $mail->SmtpClose();
                unset($mail);
                require_once CLASSES_DIR . 'activity.class.php';
                $activity = new Activity();
                $activity->setActive(true);
                $activity->setAlbum(null);
                $activity->setComment(null);
                $activity->setCounter(0);
                $activity->setEvent(null);
                $activity->setFromUser($currentUser->getObjectId());
                $activity->setImage(null);
                $activity->setPlaylist(null);
                $activity->setQuestion(null);
                $activity->setRecord(null);
                $activity->setRead(true);
                $activity->setSong(null);
                $activity->setStatus('A');
                $activity->setToUser($toUser);
                $activity->setType($type);
                $activity->setUserStatus(null);
                $activity->setVideo(null);
                $activityP1 = new ActivityParse();
                $act = $activityP1->saveActivity($activity);
                if ($act instanceof Error) {
                    $this->response(array('status' => $controllers['NOACSAVE']), 503);
                }
                $this->response(array($controllers['RELACCEPTED']), 200);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	declineRelationRequest()
     * \brief   decline relationship request
     * \todo    test
     */
    public function declineRelationRequest() {
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['activityId'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOACTIVITYID']), 403);
            }
            $currentUser = $this->request['currentUser'];
            $toUser = $this->request['toUser'];
            $activityId = $this->request['activityId'];
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activityP = new ActivityParse();
            $res = $activityP->updateField($activityId, 'status', 'R');
            if ($res instanceof Error) {
                $this->response(array('status' => $controllers['NOACTUPDATE']), 503);
            }
            $res1 = $activityP->updateField($activityId, 'read', true);
            if ($res1 instanceof Error) {
                $this->response(array('status' => $controllers['NOACTUPDATE']), 503);
            }
            require_once CLASSES_DIR . 'activity.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRecord(null);
            $activity->setRead(true);
            $activity->setSong(null);
            $activity->setStatus('A');
            $activity->setToUser($toUser);
            $activity->setType('RELDELINED');
            $activity->setUserStatus(null);
            $activity->setVideo(null);
            $activityP1 = new ActivityParse();
            $res2 = $activityP1->saveActivity($activity);
            if ($res2 instanceof Error) {
                $this->response(array('status' => $controllers['NOACSAVE']), 403);
            }
            $this->response(array('RELDECLINED'), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	relationChecker($currentUserId, $currentUserType,$toUserType, $toUserId)
     * \brief   check if 2 users are in a relationship (any kind)
     * \param   $currentUserId,$currentUserType,$toUserType, $toUserId
     * \return  true if a relation exist, false otherwise
     * \todo    test
     */
    public function relationChecker($currentUserId, $currentUserType, $toUserType, $toUserId) {
        global $controllers;
        $inRelation = false;
        switch ($fromUserType) {
            case 'SPOTTER':
                if ($toUserType == 'SPOTTER') {
                    $fromField = 'friendship';
                } else {
                    $fromField = 'following';
                }
                break;
            default :
                if ($toUserType == 'SPOTTER') {
                    $this->response(array($controllers['RELDENIED']), 503);
                } else {
                    $fromField = 'collaboration';
                }
                break;
        }
        $array = fromParseRelation('_User', $fromField, $currentUserId, '_User');
        if ($array instanceof Error) {
            $this->response(array('status' => $controllers['RELATIONCHECKERROR']), 503);
        } elseif (in_array($toUserId, $array)) {
            $inRelation = true;
        }
        return $inRelation;
    }

    /**
     * \fn	removeRelationship ()
     * \brief   remove an existing relationship
     * \todo    test    
     */
    public function removeRelationship() {
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['toUser'])) {
                $this->response(array('status' => $controllers['NOTOUSER']), 403);
            } elseif (!isset($this->request['toUserType'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSERTYPE']), 403);
            }
            $currentUser = $this->request['currentUser'];
            $toUserId = $this->request['toUser'];
            $toUserType = $this->request['toUserType'];
            $fromUserType = $currentUser->getType();
            if (!($this->relationChecker($currentUser->getObjectId(), $fromUserType, $toUserId))) {
                $this->response(array('status' => $controllers['NORELFOUNDFORREMOVING']), 503);
            }
            $toUserB = new UserParse();
            $toUser = $toUserB->getUser($toUserId);
            $sessionTokenA = $currentUser->getSessionToken();
            $sessionTokenB = $toUserB->getSessionToken();
            $fromUserA = new UserParse();
            $userA = $fromUserA->getUser($currentUser->getObjectId());
            if ($toUser instanceof Error) {
                $this->response(array('status' => $controllers['USERNOTFOUND']), 503);
            } elseif (!isset($sessionTokenB)) {
                $this->response(array('status' => $controllers['NOSESSIONTOKEN']), 503);
            } elseif ($userA instanceof Error) {
                $this->response(array('status' => $controllers['USERNOTFOUND']), 503);
            } elseif (!isset($sessionTokenA)) {
                $this->response(array('status' => $controllers['NOSESSIONTOKEN']), 503);
            }
            if ($fromUserType == 'SPOTTER' && $toUserType == 'SPOTTER') {
                $field = 'friendship';
                $type = 'FRIENDSHIPREMOVED';
                $resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'remove', '_User');
                $counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'friendshipCounter', ($currentUser->getFriedshipCounter() - 1));
                $resB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'remove', '_User');
                $counterB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, 'friendshipCounter', ($toUser->getFriedshipCounter() - 1));
            } elseif ($fromUserType == 'SPOTTER' && $toUserType != 'SPOTTER') {
                $field = 'followers';
                $field1 = 'following';
                $type = 'FOLLOWINGREMOVED';
                $resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'remove', '_User');
                $counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'followingCounter', ($currentUser->getFollowingCounter() - 1));
                $resB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, $field1, $currentUser->getObjectId(), true, 'remove', '_User');
                $counterB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, 'followersCounter', ($toUser->getFollowersCounter() - 1));
            } elseif ($fromUserType != 'SPOTTER') {
                $field = 'collaboration';
                $type = 'COLLABORATIONREMOVED';
                $resA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, $field, $toUser->getObjectId(), true, 'remove', '_User');
                $counterA = $fromUserA->updateField($currentUser->getObjectId(), $sessionTokenA, 'collaborationCounter', ($currentUser->getCollaborationCounter() - 1));
                $resB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, $field, $currentUser->getObjectId(), true, 'remove', '_User');
                $counterB = $toUserB->updateField($toUser->getObjectId(), $sessionTokenB, 'collaborationCounter', ($toUser->getCollaborationCounter() - 1));
            }//prevedere delle rollback
            if ($resA instanceof Error) {
                $this->response(array('status' => $controllers['ERROREMOVINGREL']), 503);
            } elseif ($resB instanceof Error) {
                $this->response(array('status' => $controllers['ERROREMOVINGREL']), 503);
            } elseif ($counterA instanceof Error) {
                $this->response(array('status' => $controllers['ERROREMOVINGREL']), 503);
            } elseif ($counterB instanceof Error) {
                $this->response(array('status' => $controllers['ERROREMOVINGREL']), 503);
            }
            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRecord(null);
            $activity->setRead(true);
            $activity->setSong(null);
            $activity->setStatus('A');
            $activity->setToUser($toUser);
            $activity->setType($type);
            $activity->setUserStatus(null);
            $activity->setVideo(null);
            $activityP = new ActivityParse();
            $res = $activityP->saveActivity($activity);
            if ($res instanceof Error) {
                $this->response(array('status' => $controllers['NOACSAVE']), 503);
            }
            $this->response(array($controllers['RELDELETED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	sendRelationRequest()
     * \brief   send request for relationships
     * \todo    test
     */
    public function sendRelationRequest() {
        global $controllers;
        global $mail_files;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['toUser'])) {
                $this->response(array('status' => $controllers['NOTOUSER']), 403);
            } elseif (!isset($this->request['toUserType'])) {
                $this->response(array('status' => "Bad Request", "msg" => $controllers['NOTOUSERTYPE']), 403);
            }
            $currentUser = $this->request['currentUser'];
            $toUser = $this->request['toUser'];
            $toUserType = $this->request['toUserType'];
            if ($currentUser->getObjectId() == $toUser) {
                $this->response(array('status' => $controllers['SELF']), 503);
            }
            if ($this->relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserType, $toUser)) {
                $this->response(array('status' => $controllers['ALREADYINREALTION']), 503);
            }
            require_once CLASSES_DIR . 'activity.class.php';
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activity = new Activity();
            $activity->setActive(true);
            $activity->setAlbum(null);
            $activity->setComment(null);
            $activity->setCounter(0);
            $activity->setEvent(null);
            $activity->setFromUser($currentUser->getObjectId());
            $activity->setImage(null);
            $activity->setPlaylist(null);
            $activity->setQuestion(null);
            $activity->setRecord(null);
            $activity->setRead(false);
            $activity->setSong(null);
            $activity->setStatus('P');
            $activity->setToUser($toUser);
            $activity->setUserStatus(null);
            $activity->setVideo(null);
            switch ($currentUser->getType()) {
                case 'SPOTTER':
                    if ($toUserType == 'SPOTTER') {
                        $activity->setType("FRIENDSHIPREQUEST");
                        $HTMLFile = $mail_files['FRIENDSHIPREQUESTEMAIL'];
                    } else {
                        $activity->setType("FOLLOWING");
                        $HTMLFile = $mail_files['FOLLOWINGEMAIL'];
                    }
                    break;
                default :
                    if ($toUserType == 'SPOTTER') {
                        $this->response(array($controllers['RELDENIED']), 503);
                    } else {
                        $activity->setType("COLLABORATIONREQUEST");
                        $HTMLFile = $mail_files['COLLABORATIONREQUESTEMAIL'];
                    }
                    break;
            }
            $activityParse = new ActivityParse();
            $resActivity = $activityParse->saveActivity($activity);
            if ($resActivity instanceof Error) {
                $this->response(array('NOACSAVE'), 503);
            } else {
                require_once SERVICES_DIR . 'mail.service.php';
                $mail = new MailService(true);
                $mail->IsHTML(true);
                $mail->AddAddress($toUser->getEmail());
                $mail->Subject = $controllers['SBJ'];
                $mail->MsgHTML(file_get_contents(STDHTML_DIR . $HTMLFile));
                $resMail = $mail->Send();
                if ($resMail instanceof phpmailerException) {
                    $this->response(array('status' => $controllers['NOMAIL']), 403);
                }
                $mail->SmtpClose();
                unset($mail);
                $this->response(array($controllers['RELSAVED']), 200);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

}

?>