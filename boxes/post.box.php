<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Post
 * \details		Recupera gli ultimi post attivi
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * \brief	PostBox class 
 * \details	box class to pass info to the view for personal page
 */
class PostBox {

    public $error = null;
    public $postArray = array();

    /**
     * \fn	init($id)
     * \brief	Init PostBox instance for Personal Page
     * \param	$id for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * \return	postBox
     * \todo
     */
    public function init($id, $limit = 5, $skip = 0) {
	$posts = selectPosts(null, array('touser' => $id, 'type' => 'P'), array('createad' => 'DESC'), $limit, $skip);
	if ($posts instanceof Error) {
	    $this->error = $posts->getErrorMessage();
	}
	$this->postArray = $posts;
    }

}

?>