<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione delle azioni di invito per event
 * \details		gestisce le azioni di invio, rifiuto e accettazione delle richieste di partecipazione ad event
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
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	EventManagementController class 
 * \details	gestisce le azioni di invio, rifiuto e accettazione delle richieste di partecipazione ad event
 */
class EventManagementController extends REST {

    /**
     * \fn	declineInvitationRequest()
     * \brief   decline invitation request
     * \todo    test
     */
    public function invitationRequestResponse() {
        global $controllers;
        try {
            $allowedResponse = array('R', 'A', 'MAYBE');
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($this->request['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['activityId'])) {
                $this->response(array('status' => $controllers['NOACTIVITYID']), 403);
            } elseif (!isset($this->request['response'])) {
                $this->response(array('status' => $controllers['NORESPONSE']), 403);
            }
            $currentUser = $this->request['currentUser'];
            $toUser = $this->request['toUser'];
            $activityId = $this->request['activityId'];
            $response = $this->request['response'];
            if (!in_array($response, $allowedResponse)) {
                $this->response(array('status' => $controllers['INVALIDRESPONSE']), 403);
            }
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activityP = new ActivityParse();
            $res = $activityP->updateField($activityId, 'status', $response);
            $res1 = $activityP->updateField($activityId, 'read', true);
            if ($res instanceof Error || $res1 instanceof Error) {
                $this->response(array('status' => $controllers['NOACTUPDATE']), 503);
            }
            $responseType = ($response == 'R') ? 'INVITATIONDECLINED' : 'INVITATIONACCEPTED';
            $activity = $this->createActivity($responseType, $toUser, $currentUser->getObjectId(), 'A', null, true);
            $activityP1 = new ActivityParse();
            $res2 = $activityP1->saveActivity($activity);
            if ($res2 instanceof Error) {
                require_once CONTROLLERS_DIR . 'rollBack.controller.php';
                $rollBackController = new RollBackController();
                $rollBackController->rollbackEventManagementController($activity->getObjectId(), 'managementRequest');
            }
            $this->response(array($responseType), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	sendRelationRequest()
     * \brief   send request for relationships
     * \todo    test
     */
    public function sendInvitationRequest() {
        global $controllers;
        global $mail_files;
        try {
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($this->request['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['toUser'])) {
                $this->response(array('status' => $controllers['NOTOUSER']), 403);
            } elseif (!isset($this->request['toUserType'])) {
                $this->response(array('status' => $controllers['NOTOUSERTYPE']), 403);
            } elseif (!isset($this->request['eventId'])) {
                $this->response(array('status' => $controllers['NOEVENTID']), 403);
            }
            $currentUser = $this->request['currentUser'];
            $toUserId = $this->request['toUser'];
            $toUserType = $this->request['toUserType'];
            $eventId = $this->request['eventId'];
            if ($currentUser->getObjectId() == $toUserId) {
                $this->response(array('status' => $controllers['SELF']), 503);
            } elseif (!relationChecker($currentUser->getObjectId(), $currentUser->getType(), $toUserId, $toUserType)) {
                $this->response(array('status' => $controllers['NOTINRELATION']), 503);
            }
            $activity = $this->createActivity("INVITED", $toUserId, $currentUser->getObjectId(), 'P', $eventId, false);
            $HTMLFile = $mail_files['EVENTINVITATION'];
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activityParse = new ActivityParse();
            $resActivity = $activityParse->saveActivity($activity);
            if ($resActivity instanceof Error) {
                $this->response(array('status' => $controllers['NOACSAVE']), 503);
            } else {
                require_once CLASSES_DIR . 'userParse.class.php';
                $userParse = new UserParse();
                $user = $userParse->getUser($toUserId);
                if ($user instanceof Error) {
                    $this->response(array('status' => $controllers['NOUSERFORMAIL']), 503);
                }
                require_once SERVICES_DIR . 'mail.service.php';
                $mail = new MailService(true);
                $mail->IsHTML(true);
                $mail->AddAddress($user->getEmail());
                $mail->Subject = $controllers['SBJ']; //da modificare
                $mail->MsgHTML(file_get_contents(STDHTML_DIR . $HTMLFile));
                $resMail = $mail->Send();
                if ($resMail instanceof phpmailerException) {
                    require_once CONTROLLERS_DIR . 'rollBack.controller.php';
                    $rollBAckController = new RollBackController();
                    $rollBAckController->rollbackEventManagementController($activity->getObjectId(), 'sendInvitation');
                }
                $mail->SmtpClose();
                unset($mail);
                $this->response(array($controllers['INVITATIONSENT']), 200);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn      createActivity($type, $toUserId, $currentUserId, $status, $eventId, $readr)
     * \brief   private function to create ad hoc activity
     * \param   $type, $toUserId, $currentUserId, $status, $eventId, $read
     */
    private function createActivity($type, $toUserId, $currentUserId, $status, $eventId, $read) {
        require_once CLASSES_DIR . 'activity.class.php';
        $activity = new Activity();
        $activity->setActive(true);
        $activity->setAlbum(null);
        $activity->setComment(null);
        $activity->setCounter(0);
        $activity->setEvent($eventId);
        $activity->setFromUser($currentUserId);
        $activity->setImage(null);
        $activity->setPlaylist(null);
        $activity->setQuestion(null);
        $activity->setRecord(null);
        $activity->setRead($read);
        $activity->setSong(null);
        $activity->setStatus($status);
        $activity->setToUser($toUserId);
        $activity->setType($type);
        $activity->setUserStatus(null);
        $activity->setVideo(null);
        return $activity;
    }

}

?>