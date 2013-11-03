<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione della playlist
 * \details		gestisce l'inserimento e la cancellazione di una song dalla tracklist di una playlist
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser); check numero di canzoni; check per vedere se song presente già presente nella tracklist
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	LoveController class 
 * \details	controller di love/unlove
 */
class PlaylistController extends REST {

    /**
     * \fn      addSong()
     * \brief   add song to playlist
     * \todo    usare la sessione
     */
    public function addSong() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['playlistId'])) {
		$this->response(array('status' => $controllers['NOPLAYLISTID']), 403);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGTID']), 403);
	    }
	    $playlistId = $this->request['playlistId'];
	    $songId = $this->request['songId'];
	    $currentUser = $this->request['currentUser'];
	    require_once CLASSES_DIR . 'playlistParse.class.php';
	    $playlistP = new PlaylistParse();
	    $playlist = $playlistP->getPlaylist($playlistId);
	    if ($playlist instanceof Error) {
		$this->response(array('NOPLAYLIST'), 503);
	    }
	    //devo controllare che la song sia presente, se è presente non l'aggiungo oppure avrei errore dalla update?
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
	    if ($res instanceof Error) {
		$this->response(array('NOADDSONGTOPLAY'), 503);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    //qui va aggiunto il check sul numero di canzoni, se sono più di 20 va cancellata la prima in ordine cronologico di aggiunta (come vengono inserire nell'arrau le song??)
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($currentUser->getObjectId());
	    $activity->setImage(null);
	    $activity->setPlaylist($playlistId);
	    $activity->setQuestion(null);
	    $activity->setRead(true);
	    $activity->setRecord(null);
	    $activity->setSong($songId);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType("SONGADDEDTOPLAYLIST");
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->rollback($playlistId, $songId, 'add');
	    }
	    $this->response(array('SONGADDEDTOPLAYLIST'), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		removeSong()
     * \brief   remove song to playlist 
     * \todo    usare la sessione
     */
    public function removeSong() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['playlistId'])) {
		$this->response(array('status' => $controllers['NOPLAYLISTID']), 403);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGTID']), 403);
	    }
	    $playlistId = $this->request['playlistId'];
	    $songId = $this->request['songId'];
	    $currentUser = $this->request['currentUser'];
	    require_once CLASSES_DIR . 'playlistParse.class.php';
	    $playlistP = new PlaylistParse();
	    $playlist = $playlistP->getPlaylist($playlistId);
	    if ($playlist instanceof Error) {
		$this->response(array('NOPLAYLIST'), 503);
	    }
	    //devo controllare che la song sia presente, se è presente non la tolgo
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
	    if ($res instanceof Error) {
		$this->response(array('NOREMOVESONGTOPLAY'), 503);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAccepted(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromUser($currentUser->getObjectId());
	    $activity->setImage(null);
	    $activity->setPlaylist($playlistId);
	    $activity->setQuestion(null);
	    $activity->setRead(true);
	    $activity->setRecord(null);
	    $activity->setSong($songId);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType("SONGREMOVEDFROMPLAYLIST");
	    $activity->setUserStatus(null);
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->rollback($playlistId, $songId, 'remove');
	    }
	    $this->response(array('SONGADDEDTOPLAYLIST'), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn		rollback($objectId, $operation)
     * \brief   rollback for addSong() e removeSong()
     * \param   $playslitId-> playlist objectId, $songId -> song objectId , $operation -> add, if you are calling rollback from addSong() or remove if are calling rollback from removeSong())
     * \todo    usare la sessione
     */
    private function rollback($playlistId, $songId, $operation) {
	global $controllers;
	$playlistP = new PlaylistParse();
	if ($operation == 'add') {
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
	} else {
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
	}
	if ($res instanceof Error) {
	    $this->response(array($controllers['ROLLKO']), 503);
	} else {
	    $this->response(array($controllers['ROLLOK']), 503);
	}
    }

}

?>