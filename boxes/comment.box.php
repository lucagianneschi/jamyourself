<?php/* ! \par		Info Generali: * \author		Luca Gianneschi * \version		1.0 * \date		2013 * \copyright		Jamyourself.com 2013 * \par			Info Classe: * \brief		box commenti * \details		Recupera le informazioni del commento e le mette in oggetto commentBox * \par			Commenti: * \warning * \bug * \todo			 * */if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../');require_once ROOT_DIR . 'config.php';require_once CLASSES_DIR . 'comment.class.php';require_once CLASSES_DIR . 'commentParse.class.php';/** * \brief	CommentBox class  * \details	box class to pass info to the view  * \todo	 */class CommentBox {    public $commentArray;    public $config;    public $error;    /**     * \fn	__construct()     * \brief	class construct to import config file     */    function __construct() {	$this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/comment.config.json"), false);    }    /**     * \fn	init($className, $objectId, $limit, $skip)     * \brief	Init CommentBox instance all over the website     * \param	$className for the instance of the class that has been commented, $objectId for object that has been commented,     * \param   $limit number of objects to retreive, $skip number of objects to skip     */    public function init($objectId, $className, $limit = DEFAULTQUERY, $skip = 0) {	$info = array();	$commentP = new CommentParse();	switch ($className) {	    case 'Album':		$field = 'album';		break;	    case 'Comment':		$field = 'comment';		break;	    case 'Event':		$field = 'event';		break;	    case 'Image':		$field = 'image';		break;	    case 'Record':		$field = 'record';		break;	    case 'Song':		$field = 'song';		break;	    case 'Status':		$field = 'status';		break;	    case 'Video':		$field = 'video';		break;	}	$commentP->wherePointer($field, $className, $objectId);	$commentP->where('type', 'C');	$commentP->where('active', true);	$commentP->setLimit((!is_null($limit) && is_int($limit) && $limit >= MIN && MAX >= $limit ) ? $limit : DEFAULTQUERY);	$commentP->setSkip((!is_null($skip) && is_int($skip) && $skip >= 0) ? $skip : 0);	$commentP->whereInclude('fromUser');	$commentP->orderByDescending('createdAt');	$comments = $commentP->getComments();	if ($comments instanceof Error) {	    $this->commentArray = null;	    $this->error = $comments->getErrorMessage();	    return;	} elseif (is_null($comments)) {	    $this->commentArray = null;	    $this->error = null;	    return;	} else {	    foreach ($comments as $comment) {		if (!is_null($comment->getFromUser()))		    array_push($info, $comment);	    }	    $this->commentArray = $info;	    $this->error = null;	}    }}?>