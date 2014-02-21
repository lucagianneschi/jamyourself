<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
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

/**
 * \brief	CommentBox class 
 * \details	box class to pass info to the view 
 * \todo	
 */
class CommentBox {

    public $commentArray = array();
    public $error = null;

    /**
     * \fn	init($id, $limit, $skip)
     * \brief	Init CommentBox instance all over the website
     * \param	$className for the instance of the class that has been commented, $id for object that has been commented,
     * \param   $limit number of objects to retreive, $skip number of objects to skip
     */
    public function init($id, $limit = DEFAULTQUERY, $skip = 0) {
	$comments = selectComments(null, array('album' => $id), array('createad' => 'DESC'), $limit, $skip);
	if ($comments instanceof Error) {
	    $this->error = $comments->getErrorMessage();
	}
	$this->commentArray = $comments;
    }

}

?>