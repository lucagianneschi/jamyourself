<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Post
 * \details		Recupera gli ultimi 3 post attivi (valido per ogni tipologia di utente)
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

/**
 * \brief	PostBox class 
 * \details	box class to pass info to the view for personal page
 */
class PostBox {

    public $config;
    public $error;
    public $postArray;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/post.config.json"), false);
    }

    /**
     * \fn	initForPersonalPage($objectId, $limit, $skip, $currentUserId)
     * \brief	Init PostBox instance for Personal Page
     * \param	$objectId for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * \return	postBox
     * \todo
     */
    public function init($objectId, $limit, $skip) {
        $info = array();
        $value = array(array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)),
            array('toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $objectId)));
        $post = new CommentParse();
        $post->whereOr($value);
        $post->where('type', 'P');
        $post->where('active', true);
        $post->whereInclude('fromUser');
        $post->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? $limit : $this->config->limitForPersonalPage);
        $post->setSkip((!is_null($skip) && is_int($skip)) ? $skip : 0);
        $post->orderByDescending('createdAt');
        $posts = $post->getComments();
        if ($posts instanceof Error) {
            $this->error = $posts->getErrorMessage();
            $this->postArray = array();
            return;
        } elseif (is_null($posts)) {
            $this->error = null;
            $this->postArray = array();
            return;
        } else {
            foreach ($posts as $post) {
                if (!is_null($post->getFromUser()))
                    array_push($info, $post);
            }
            $this->error = null;
            $this->postArray = $info;
        }
    }

}
?>