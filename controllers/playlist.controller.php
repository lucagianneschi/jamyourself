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
                $this->response(array('status' => $controllers['NOSONGID']), 403);
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
            if (in_array($songId, $playlist->getSongsArray())) {
                $this->response(array('SONGALREADYINTRACKLIST'), 503);
            }
            $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
            if ($res instanceof Error) {
                $this->response(array('NOADDSONGTOPLAYREL'), 503);
            }
            $songs = $playlist->getSongsArray();
            if ($currentUser->getPremium() == false && count($songs) >= $this->config->songLimit) {
                array_pop($songs);
            }
            array_push($songs, $songId);
            $res1 = $playlistP->updateField($playlistId, 'songsArray', array_unique($songs));
            if ($res1 instanceof Error) {
                $this->response(array('NOADDSONGTOPLAYARRAY'), 503);
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
                $this->response(array('status' => $controllers['NOSONGID']), 403);
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
            if (!in_array($songId, $playlist->getSongsArray())) {
                $this->response(array('ERRORCHECKINGSONGINTRACKLIST'), 503);
            }
            $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
            if ($res instanceof Error) {
                $this->response(array('NOREMOVESONGTOPLAYREL'), 503);
            }
            $songsToUpdate = $playlist->getSongsArray();
            unset($songsToUpdate[array_search($songId, $songsToUpdate)]);
            $songs = array_values($songsToUpdate);
            $res1 = $playlistP->updateField($playlistId, 'songsArray', array_unique($songs));
            if ($res1 instanceof Error) {
                $this->response(array('NOREMOVESONGTOPLAYARRAY'), 503);
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
        $playlist = $playlistP->getPlaylist($playlistId);
        if ($playlist instanceof Error) {
            $this->response(array($controllers['ROLLKO']), 503);
        }
        $songsToUpdate = $playlist->getSongsArray();
        if ($operation == 'add') {
            $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
            if ($res instanceof Error) {
                $this->response(array($controllers['ROLLKO']), 503);
            }
            unset($songsToUpdate[array_search($songId, $songsToUpdate)]);
            $songs = array_values($songsToUpdate);
            $res1 = $playlistP->updateField($playlistId, 'songsArray', array_unique($songs));
            if ($res1 instanceof Error) {
                $this->response(array($controllers['ROLLKO']), 503);
            }
        } else {
            $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
            if ($res instanceof Error) {
                $this->response(array($controllers['ROLLKO']), 503);
            }
            array_push($songsToUpdate, $songId);
            $res1 = $playlistP->updateField($playlistId, 'songsArray', array_unique($songsToUpdate));
            if ($res1 instanceof Error) {
                $this->response(array($controllers['ROLLKO']), 503);
            }
        }
        $this->response(array($controllers['ROLLOK']), 503);
    }

}

?>