<?php

/* ! \par               Info Generali:
 * \author              Luca Gianneschi
 * \version             0.3
 * \date                2013
 * \copyright           Jamyourself.com 2013
 * \par                 Info Classe:
 * \brief               box caricamento review event e record
 * \details             Recupera le informazioni sulla review dell'event, le inserisce in un array da passare alla view
 * \par                 Commenti:
 * \warning
 * \bug
 * \todo                
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * \brief        ReviewEventBox class
 * \details      box class to pass info to the view
 */
class ReviewEventBox {

    public $error = null;
    public $reviewArray = array();

    /**
     * \fn        initForMediaPage($id, $className, $limit, $skip)
     * \brief        Init ReviewBox instance for Media Page
     * \param        $id of the review to display information, Event or Record class
     * \param   $className, $limit, $skip,$currentUserId
     * \todo        
     */
    public function initForMediaPage($id, $limit = 3, $skip = 0) {
	$reviews = selectComments(null, array('event' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($reviews instanceof Error) {
	    $this->error = $reviews->getErrorMessage();
	}
	$this->reviewArray = $reviews;
    }

    /**
     * \fn        initForPersonalPage($id, $type, $className)
     * \brief        Init ReviewBox instance for Personal Page
     * \param        $id of the user who owns the page, $type of user, $className Record or Event class
     * \param	    $type, $className
     * \todo        fare la query per il proprietario dell'event
     */
    function init($id, $type, $limit = 3, $skip = 0) {
	if ($type == 'SPOTTER') {
	    $reviews = selectReviewEvent(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	} else {
	    //TODO
	    $reviews = selectReviewEvent(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	}
	if ($reviews instanceof Error) {
	    $this->error = $reviews->getErrorMessage();
	}
	$this->reviewArray = $reviews;
    }

}

/**
 * \brief        ReviewRecordBox class
 * \details      box class to pass info to the view
 */
class ReviewRecordBox {

    public $error = null;
    public $reviewArray = array();

    /**
     * \fn        initForMediaPage($id, $className, $limit, $skip)
     * \brief        Init ReviewBox instance for Media Page
     * \param        $id of the review to display information, Event or Record class
     * \param   $className, $limit, $skip,$currentUserId
     * \todo        
     */
    public function initForMediaPage($id, $limit = 3, $skip = 0) {
	$reviews = selectComments(null, array('record' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($reviews instanceof Error) {
	    $this->error = $reviews->getErrorMessage();
	}
	$this->reviewArray = $reviews;
    }

    /**
     * \fn        initForPersonalPage($id, $type, $className)
     * \brief        Init ReviewBox instance for Personal Page
     * \param        $id of the user who owns the page, $type of user, $className Record or Event class
     * \param	    $type, $className
     * \todo        fare la query per il proprietario dell'event
     */
    function initForPersonalPage($id, $type, $limit = 3, $skip = 0) {
	if ($type == 'SPOTTER') {
	    $reviews = selectReviewRecord(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	} else {
	    //TODO
	    $reviews = selectReviewRecord(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	}
	if ($reviews instanceof Error) {
	    $this->error = $reviews->getErrorMessage();
	}
	$this->reviewArray = $reviews;
    }

}

?>