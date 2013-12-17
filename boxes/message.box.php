<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento messaggi
 * \details		Recupera le informazioni dei messaggi per la pagina messaggi
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	ElementList
 * \details	contains info for message to be displayed in Message Page
 */
class ElementList {

    public $userInfo;
    public $read;

    /**
     * \fn	__construct($read,$userInfo)
     * \brief	construct for the ElementList
     * \param	$read,$userInfo
     */
    function __construct($read, $userInfo) {
        is_null($read) ? $this->read = false : $this->read = $read;
        is_null($userInfo) ? $this->userInfo = null : $this->userInfo = $userInfo;
    }

}

/**
 * \brief	MessageInfo class 
 * \details	contains info for message to be displayed in Message Page
 */
class MessageInfo {

    public $createdAt;
    public $objectId;
    public $send;
    public $text;

    /**
     * \fn	__construct($createdAt, $objectId, $send, $text)
     * \brief	construct for the MessageInfo class
     * \param	$createdAt, $objectId, $send, $text, $title
     */
    function __construct($createdAt, $objectId, $send, $text) {
        is_null($createdAt) ? $this->createdAt = null : $this->createdAt = $createdAt;
        is_null($objectId) ? $this->objectId = null : $this->objectId = $objectId;
        is_null($send) ? $this->send = 'S' : $this->send = $send;
        is_null($text) ? $this->text = null : $this->text = $text;
    }

}

/**
 * \brief	MessageBox class 
 * \details	box class to pass info to the view for messagePage 
 */
class MessageBox {

    public $config;
    public $error;
    public $messageArray;
    public $userInfoArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/message.config.json"), false);
    }

    /**
     * \fn	initForUserList($objectId, $otherId, $limit, $skip)
     * \brief	Init MessageBox instance for Message Page, left column
     * \param	$objectId for user that owns the page $limit, $skip
     * \todo    
     * \return	MessageBox, error in case of error
     */
    public function initForUserList($limit = null, $skip = null) {
        $currentUserId = sessionChecker();
        if (is_null($currentUserId)) {
            $this->errorManagement(ONLYIFLOGGEDIN);
            return;
        }
        require_once CLASSES_DIR . 'activity.class.php';
        require_once CLASSES_DIR . 'activityParse.class.php';
        $userList = array();
        $value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $currentUserId)),
            array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $currentUserId)));
        $activityP = new ActivityParse();
        $activityP->whereOr($value);
        $activityP->where('type', 'MESSAGESENT');
        $activityP->where('active', true);
        $activityP->whereInclude('fromUser,toUser');
        $activityP->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitUsersForMessagePage);
        $activityP->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
        $activityP->orderByDescending('createdAt');
        $activities = $activityP->getActivities();
        if ($activities instanceof Error) {
            $this->errorManagement($activities->getErrorMessage());
            return;
        } elseif (is_null($activities)) {
            $this->errorManagement();
            return;
        } else {
            foreach ($activities as $act) {
                if (!is_null($act->getFromUser()) && !is_null($act->getToUser())) {
                    $user = ($act->getFromUser()->getObjectId() == $currentUserId) ? $act->getToUser() : $act->getFromUser();
                    $userId = $user->getObjectId();
                    $thumbnail = $user->getProfileThumbnail();
                    $type = $user->getType();
                    $username = $user->getUsername();
                    $userInfo = new UserInfo($userId, $thumbnail, $type, $username);
                    $read = $act->getRead();
                    $elementList = new ElementList($read, $userInfo);
                    if (array_key_exists($userId, $userList) && !$read) {
                        $userList[$userId] = $elementList;
                    } else {
                        $userList[$userId] = $elementList;
                    }
                }
            }
        }
        $this->error = null;
        $this->messageArray = array();
        $this->userInfoArray = $userList;
    }

    /**
     * \fn	initForMessageList($objectId, $otherId, $limit, $skip)
     * \brief	Init MessageBox instance for Message Page, right column
     * \param	$objectId for user that owns the page, $otherId the id if the user who the currentUser is messaging with, $limit, $skip
     * \todo    
     * \return	MessageBox, error in case of error
     */
    public function initForMessageList($otherId, $limit = null, $skip = null) {
        $currentUserId = sessionChecker();
        if (is_null($currentUserId)) {
            $this->errorManagement(ONLYIFLOGGEDIN);
            return;
        }
        require_once CLASSES_DIR . 'comment.class.php';
        require_once CLASSES_DIR . 'commentParse.class.php';
        $value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $currentUserId)),
            array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $currentUserId)));
        $value1 = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $otherId)),
            array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $otherId)));
        $messageP = new CommentParse();
        $messageP->whereOr(array_merge($value, $value1));
        $messageP->where('type', 'M');
        $messageP->where('active', true);
        $messageP->whereInclude('fromUser');
        $messageP->orderByDescending('createdAt');
        $messageP->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit) ? $limit : $this->config->limitMessagesForMessagePage);
        $messageP->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);
        $messages = $messageP->getComments();
        if ($messages instanceof Error) {
            $this->errorManagement($messages->getErrorMessage());
            return;
        } elseif (is_null($messages)) {
            $this->errorManagement();
            return;
        } else {
            $messagesArray = array();
            foreach ($messages as $message) {
                if (!is_null($message->getFromUser())) {
                    $send = ($message->getFromUser()->getObjectId() == $currentUserId) ? 'S' : 'R';
                    $createdAt = $message->getCreatedAt();
                    $messageId = $message->getObjectId();
                    $text = $message->getText();
                    $messageInfo = new MessageInfo($createdAt, $messageId, $send, $text);
                    array_push($messagesArray, $messageInfo);
                }
            }
        }
        $this->error = null;
        $this->messageArray = $messagesArray;
        $this->userInfoArray = array();
    }

    /**
     * \fn	function errorManagement($errorMessage)
     * \brief	set values in case of error or nothing to send to the view
     * \param	$errorMessafe
     * \todo    
     */
    private function errorManagement($errorMessage = null) {
        $this->error = $errorMessage;
        $this->messageArray = array();
        $this->userInfoArray = array();
    }

}

?>