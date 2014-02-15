<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione del player
 * \details		gestisce la creazione dell'activity legata al player
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		 completare ed implementare
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
 

/**
 * \brief	PlayerController class 
 * \details	controller del player musicale
 */
class PlayerController extends REST {

    /**
     * \fn      play()
     * \brief   add song to playlist
     * \todo    
     */
    public function play() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    }
	    $songId = $this->request['songId'];
	    $currentUser = $_SESSION['currentUser'];
	    require_once CLASSES_DIR . 'song.class.php';
	    require_once CLASSES_DIR . 'songParse.class.php';
	    $songParse = new SongParse();
	    $song = $songParse->getSong($songId);
	    if ($song instanceof Error) {
		$this->response(array('status' => $controllers['ERRORSONGINFO']), 503);
	    }
	    $activity = $this->createActivity($currentUser->getId(), $song->getRecord(), $songId);
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->response(array('status' => $controllers['ACTSONGNOTPLAYED']), 503);
	    }
	    $this->response(array($controllers['SONGPLAYED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	createActivity($type, $fromuser, $recordId, $songId)
     * \brief   create activity for playslitControlelr
     * \param   $type, $fromuser, $recordId, $songId
     * \return  $activity     
     */
    private function createActivity($fromuser, $recordId, $songId) {
	require_once CLASSES_DIR . 'activity.class.php';
	$activity = new Activity();
	$activity->setActive(true);
	$activity->setAlbum(null);
	$activity->setComment(null);
	$activity->setCounter(0);
	$activity->setEvent(null);
	$activity->setFromuser($fromuser);
	$activity->setImage(null);
	$activity->setPlaylist(null);
	$activity->setQuestion(null);
	$activity->setRead(true);
	$activity->setRecord($recordId);
	$activity->setSong($songId);
	$activity->setStatus('A');
	$activity->setToUser(null);
	$activity->setType("SONGLISTENED");
	$activity->setVideo(null);
	return $activity;
    }

}

?>