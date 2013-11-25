<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box commenti
 * \details		Recupera le informazioni del commento e le mette in oggetto commentBox
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
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once BOXES_DIR . 'utilsBox.php';

/**
 * \brief	CommentInfo class 
 * \details	contains info for comment to be displayed 
 */
class CommentInfo {

    public $fromUserInfo;
    public $counters;
    public $createdAt;
    public $showLove;
    public $text;

    /**
     * \fn	__construct($counters, $fromUserInfo, $createdAt, $showLove, $text)
     * \brief	construct for the CommentInfo class
     * \param	$counters, $fromUserInfo, $createdAt, $showLove, $text
     */
    function __construct($counters, $fromUserInfo, $createdAt, $showLove, $text) {
        global $boxes;
        is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
        is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
        is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
        is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
        is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = $text;
    }

}

/**
 * \brief	CommentBox class 
 * \details	box class to pass info to the view 
 * \todo	usare whereInclude per il fromUSer per evitare di fare una ulteriore get 
 */
class CommentBox {

    public $commentInfoArray;
    public $config;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/comment.config.json"), false);
    }

    /**
     * \fn	init($className, $objectId, $limit, $skip)
     * \brief	Init CommentBox instance all over the website
     * \param	$className for the instance of the class that has been commented, $objectId for object that has been commented,
     * \param   $limit number of objects to retreive, $skip number of objects to skip
     * \todo    usare forma compatta di scrittura per showLove 
     * \return	commentBox
     */
    public function init($className, $objectId, $limit, $skip) {
        global $boxes;
        $currentUserId = sessionChecker();
        $info = array();
        $commentBox = new CommentBox();
        $commentP = new CommentParse();
        switch ($className) {
            case 'Album':
                $field = 'album';
                break;
            case 'Comment':
                $field = 'comment';
                break;
            case 'Event':
                $field = 'event';
                break;
            case 'Image':
                $field = 'image';
                break;
            case 'Record':
                $field = 'record';
                break;
            case 'Song':
                $field = 'song';
                break;
            case 'Status':
                $field = 'status';
                break;
            case 'Video':
                $field = 'video';
                break;
        }
        $commentP->wherePointer($field, $className, $objectId);
        $commentP->where('type', 'C');
        $commentP->where('active', true);
        $commentP->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $this->config->defaultLimit : $limit);
        $commentP->setSkip((is_null($skip) && is_int($skip)) ? 0 : $skip);
        $commentP->whereInclude('fromUser');
        $commentP->orderByDescending('createdAt');
        $comments = $commentP->getComments();
        if ($comments instanceof Error) {
            return $comments;
        } elseif (is_null($comments)) {
            $commentBox->commentInfoArray = $boxes['NODATA'];
            return $commentBox;
        } else {
            foreach ($comments as $comment) {
                if (!is_null($comment->getFromUser())) {
                    $createdAt = $comment->getCreatedAt()->format('d-m-Y H:i:s');
                    $commentCounter = $boxes['NDB'];
                    $loveCounter = $comment->getLoveCounter();
                    $reviewCounter = $boxes['NDB'];
                    $shareCounter = $boxes['NDB'];
                    $counters = new Counters($commentCounter, $loveCounter, $reviewCounter, $shareCounter);
                    $text = $comment->getText();
                    $userId = $comment->getFromUser()->getObjectId();
                    $thumbnail = $comment->getFromUser()->getProfileThumbnail();
                    $type = $comment->getFromUser()->getType();
                    $username = $comment->getFromUser()->getUsername();
                    $fromUserInfo = new UserInfo($userId, $thumbnail, $type, $username);
                    $showLove = in_array($currentUserId, $comment->getLovers()) ? false : true;
                    $commentInfo = new CommentInfo($counters, $fromUserInfo, $createdAt, $showLove, $text);
                    array_push($info, $commentInfo);
                }
            }
            $commentBox->commentInfoArray = $info;
        }
        return $commentBox;
    }

}

?>