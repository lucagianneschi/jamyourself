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
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	LoveController class 
 * \details	controller di love/unlove
 */
class PlaylistController extends REST {

    public $config;

    /**
     * \fn		construct()
     * \brief   load config file for the controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/playlist.config.json"), false);
    }

    /**
     * \fn      addSong()
     * \brief   add song to playlist
     * \todo    vedere se va fatto controllo su + o meno 20 valori nella relation
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
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    }
	    $playlistId = $this->request['playlistId'];
	    $songId = $this->request['songId'];
	    $currentUser = $this->request['currentUser'];
	    require_once CLASSES_DIR . 'playlistParse.class.php';
	    $playlistP = new PlaylistParse();
	    $playlist = $playlistP->getPlaylist($playlistId);
	    if ($playlist instanceof Error) {
		$this->response(array('status' =>$controllers['NOPLAYLIST']), 503);
	    }
	    if (in_array($songId, $playlist->getSongsArray())) {
		$this->response(array('status' =>$controllers['SONGALREADYINTRACKLIST']), 503);
	    }
	    //qui va fatto check che non ci siano + di 20 elementi nella relation ? posso omettere perchè tanto mostro solo gli ultimi 20 nel box??? DA CAPIRE
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
	    if ($res instanceof Error) {
		$this->response(array('status' =>$controllers['NOADDSONGTOPLAYREL']), 503);
	    }
	    $res1 = $playlistP->addOjectIdToArray($playlistId, 'songsArray', $songId, $currentUser->getPremium(), $this->config->songsLimit);
	    if ($res1 instanceof Error) {
		$this->response(array('status' =>$controllers['NOADDSONGTOPLAYARRAY']), 503);
	    }
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
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
		$this->rollback($playlistId, $songId, 'add', $currentUser->getPremium(), $this->config->songsLimit);
	    }
	    $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
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
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    }
	    $playlistId = $this->request['playlistId'];
	    $songId = $this->request['songId'];
	    $currentUser = $this->request['currentUser'];
	    require_once CLASSES_DIR . 'playlistParse.class.php';
	    $playlistP = new PlaylistParse();
	    $playlist = $playlistP->getPlaylist($playlistId);
	    if ($playlist instanceof Error) {
		$this->response(array($controllers['NOPLAYLIST']), 503);
	    }
	    if (!in_array($songId, $playlist->getSongsArray())) {
		$this->response(array('status' => $controllers['ERRORCHECKINGSONGINTRACKLIST']), 503);
	    }
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
	    if ($res instanceof Error) {
		$this->response(array('status' => $controllers['NOREMOVESONGTOPLAYREL']), 503);
	    }
	    $res1 = $playlistP->removeObjectIdFromArray($playlistId, 'songsArray', $songId);
	    if ($res1 instanceof Error) {
		$this->response(array('status' => $controllers['NOREMOVESONGTOPLAYARRAY']), 503);
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
		$this->rollback($playlistId, $songId, 'remove', $currentUser->getPremium(), $this->config->songsLimit);
	    }
	    $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	rollback($playlistId, $songId, $operation, $premium, $limit)
     * \brief   rollback for addSong() e removeSong()
     * \param   $playslitId-> playlist objectId, $songId -> song objectId , $operation -> add, if you are calling rollback from addSong() or remove if are calling rollback from removeSong())$premium, $limit for the currentUser
     * \todo    
     */
    private function rollback($playlistId, $songId, $operation, $premium, $limit) {
	global $controllers;
	$playlistP = new PlaylistParse();
	$playlist = $playlistP->getPlaylist($playlistId);
	if ($playlist instanceof Error) {
	    $this->response(array('status' =>$controllers['ROLLKO']), 503);
	}
	if ($operation == 'add') {
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
	    if ($res instanceof Error) {
		$this->response(array('status' =>$controllers['ROLLKO']), 503);
	    }
	    $res1 = $playlistP->removeObjectIdFromArray($playlistId, 'songsArray', $songId);
	    if ($res1 instanceof Error) {
		$this->response(array('status' =>$controllers['ROLLKO']), 503);
	    }
	} else {
	    $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
	    if ($res instanceof Error) {
		$this->response(array('status' =>$controllers['ROLLKO']), 503);
	    }
	    $res1 = $playlistP->addOjectIdToArray($playlistId, 'songsArray', $songId, $premium, $limit);
	    if ($res1 instanceof Error) {
		$this->response(array('status' =>$controllers['ROLLKO']), 503);
	    }
	}
	$this->response(array('status' =>$controllers['ROLLOK']), 503);
    }

}

?>