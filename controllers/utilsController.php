<?php

/* ! \par Info	Generali:
 *  \author		Luca Gianneschi
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *
 *  \par		Info Classe:
 *  \brief		Utils class
 *  \details	Classe di utilità sfruttata dai controller  per snellire il codice
 *
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo       
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \fn	rollbackCommentInstanceController($objectId)
 * \brief   rollback for CommentController e PostController
 * \param   $objectId dell'oggetto su cui fare delete
 */
function rollbackCommentController($objectId, $classType) {
    global $controllers;
    require_once CLASSES_DIR . 'commentParse.class.php';
    $commentParse = new CommentParse();
    $resCmt = $commentParse->deleteComment($objectId);
    switch ($classType) {
	case 'Album':
	    require_once CLASSES_DIR . 'albumParse.class.php';
	    $albumParse = new AlbumParse();
	    $res = $albumParse->decrementAlbum($objectId, 'commentCounter', 1);
	    break;
	case 'Comment':
	    $res = $commentParse->decrementComment($objectId, 'commentCounter', 1);
	    break;
	case 'Event':
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventParse = new EventParse();
	    $res = $eventParse->decrementEvent($objectId, 'commentCounter', 1);
	    break;
	case 'Image':
	    require_once CLASSES_DIR . 'imageParse.class.php';
	    $imageParse = new ImageParse();
	    $res = $imageParse->decrementImage($objectId, 'commentCounter', 1);
	    break;
	case 'Status':
	    require_once CLASSES_DIR . 'statusParse.class.php';
	    $statusParse = new StatusParse();
	    $res = $statusParse->decrementStatus($objectId, 'commentCounter', 1);
	    break;
	case 'Record':
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $recordParse = new RecordParse();
	    $res = $recordParse->decrementRecord($objectId, 'commentCounter', 1);
	    break;
	case 'Video':
	    require_once CLASSES_DIR . 'videoParse.class.php';
	    $videoParse = new VideoParse();
	    $res = $videoParse->incrementVideo($objectId, 'commentCounter', 1);
	    break;
    }
    $message = ($res instanceof Error || $resCmt instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}



/**
 * \fn		string parse_encode_string($string)
 * \brief	The function returns a string that can be saved to Parse
 * \param	$string 	represent the string to be saved
 * \return	string		the string encoded for Parse
 */
function parse_encode_string($string) {
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
    return $string;
}




?>