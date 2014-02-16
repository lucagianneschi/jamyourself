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
 * \todo	        discutere se necessario fare check su correttezza della classe commentata
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	CommentBox class 
 * \details	box class to pass info to the view 
 * \todo	
 */
class CommentBox {

    public $commentArray = array();
    public $error = null;

    /**
     * \fn	init($className, $id, $limit, $skip)
     * \brief	Init CommentBox instance all over the website
     * \param	$className for the instance of the class that has been commented, $id for object that has been commented,
     * \param   $limit number of objects to retreive, $skip number of objects to skip
     */
    public function init($id, $className, $limit = DEFAULTQUERY, $skip = 0) {

    }

}

?>