<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	MessageInfo class 
 * \details	contains info for message to be displayed in Message Page
 */
class MessageInfo {

    public $createdAt;
    public $objectId;
    public $send;
    public $text;
    public $title;

    /**
     * \fn	__construct($createdAt, $objectId, $send, $text, $title)
     * \brief	construct for the MessageInfo class
     * \param	$address, $city, $eventDate, $locationName, $objectId,$showLove, $thumbnail, $title
     */
    function __construct($createdAt, $objectId, $send, $text, $title) {
        global $boxes;
        is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($send) ? $this->send = 'S' : $this->send = $send;
        is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = parse_decode_string($text);
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = parse_decode_string($title);
    }

}

/**
 * \brief	MessageBox class 
 * \details	box class to pass info to the view for messagePage 
 */
class MessageBox {

    public $config;
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
    public function initForUserList($objectId, $limit, $skip) {
        global $boxes;
        $currentUserId = sessionChecker();
        if($currentUserId == $boxes['']){
            
        }
        $messageBox = new MessageBox();
        $userInfoArray = array();
        $messageBox->messageArray = $boxes['NDB'];
        $value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)),
            array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)));
        $messageP = new CommentParse();
        $messageP->whereOr($value);
        $messageP->where('type', 'M');
        $messageP->where('active', true);
        $messageP->whereInclude('fromUser,toUser');
        $limite = (is_null($limit)) ? $this->config->limitUsersForMessagePage : $limit;
        $skipper = (is_null($skip)) ? 0 : $skip;
        $messageP->setLimit($limite);
        $messageP->setSkip($skipper);
        $messageP->orderByDescending('createdAt');
        $messages = $messageP->getComments();
        if ($messages instanceof Error) {
            return $messages;
        } elseif (is_null($messages)) {
            $messageBox->messageArray = $boxes['NODATA'];
            return $messageBox;
        } else {
            $userIdArray = array();
            foreach ($messages as $message) {
                $user = ($message->getFromUser()->getObjectId() == $objectId) ? $message->getToUser() : $message->getFromUser();
                $objectId = $user->getObjectId();
                if (!in_array($objectId, $userIdArray)) {
                    array_push($objectId, $userIdArray);
                    $thumbnail = $user->getProfileThumbnail();
                    $type = $user->getType();
                    $username = parse_decode_string($user->getUsername());
                    $userInfo = new UserInfo($objectId, $thumbnail, $type, $username);
                    array_push($userInfo, $userInfoArray);
                }
            }
            $messageBox->userInfoArray = $userIdArray;
        }
        return $messageBox;
    }

    /**
     * \fn	initForMessageList($objectId, $otherId, $limit, $skip)
     * \brief	Init MessageBox instance for Message Page, right column
     * \param	$objectId for user that owns the page, $otherId the id if the user who the currentUser is messaging with, $limit, $skip
     * \todo    
     * \return	MessageBox, error in case of error
     */
    public function initForMessageList($objectId, $otherId, $limit, $skip) {
        global $boxes;
        $value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)),
            array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)));
        $value1 = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $otherId)),
            array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $otherId)));
        $messageBox = new MessageBox();
        $messageBox->userInfoArray = $boxes['NDB'];
        $messageP = new CommentParse();
        $messageP->whereOr($value);
        $messageP->whereOr($value1);
        $messageP->where('type', 'M');
        $messageP->where('active', true);
        $limite = (is_null($limit)) ? $this->config->limitMessagesForMessagePage : $limit;
        $skipper = (is_null($skip)) ? 0 : $skip;
        $messageP->setLimit($limite);
        $messageP->setSkip($skipper);
        $messageP->orderByDescending('createdAt');
        $messages = $messageP->getComments();
        if ($messages instanceof Error) {
            return $messages;
        } elseif (is_null($messages)) {
            $messageBox->messageArray = $boxes['NODATA'];
            return $messageBox;
        } else {
            $messagesArray = array();
            foreach ($messages as $message) {
                $userId = ($message->getFromUser()->getObjectId() == $objectId) ? $message->getToUser()->getObjectId() : $message->getFromUser()->getObjectId();
                $send = ($userId == $objectId) ? 'S' : 'R';
                $createdAt = $message->getCreatedAt();
                $objectId = $message->getObjectId();
                $text = $message->getText();
                $title = $message->getTitle();
                $messageInfo = new MessageInfo($createdAt, $objectId, $send, $text, $title);
                array_push($messagesArray, $messageInfo);
            }
            $messageBox->messageArray = $messagesArray;
        }
        return $messageBox;
    }

}

?>