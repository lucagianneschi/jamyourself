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
            $currentUser = $_SESSION['currentUser'];
            require_once CLASSES_DIR . 'playlistParse.class.php';
            $playlistP = new PlaylistParse();
            $playlist = $playlistP->getPlaylist($playlistId);
            if ($playlist instanceof Error) {
                $this->response(array('status' => $controllers['NOPLAYLIST']), 503);
            } elseif (in_array($songId, $playlist->getSongsArray())) {
                $this->response(array('status' => $controllers['SONGALREADYINTRACKLIST']), 503);
            }
            if (count($playlist->songsArray) >= PLAYLISTLIMIT && $currentUser->getPremium() != true) {
                $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
                if ($res instanceof Error) {
                    $this->response(array('status' => $controllers['NOADDSONGTOPLAYREL']), 503);
                }
                $res1 = $playlistP->addOjectIdToArray($playlistId, 'songsArray', $songId, $currentUser->getPremium(), $this->config->songsLimit);
                if ($res1 instanceof Error) {
                    $this->response(array('status' => $controllers['NOADDSONGTOPLAYARRAY']), 503);
                }
            } else {
                $this->response(array('status' => $controllers['TOMANYSONGS']), 503);
            }
            $activity = $this->createActivity("SONGADDEDTOPLAYLIST", $currentUser->getObjectId(), $playlistId, $songId);
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activityParse = new ActivityParse();
            $resActivity = $activityParse->saveActivity($activity);
            if ($resActivity instanceof Error) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackPlaylistController($playlistId, $songId, 'add', $currentUser->getPremium(), $this->config->songsLimit);
                $this->response(array('status' => $message), 503);
            }
            $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn		removeSong()
     * \brief   remove song to playlist 
     * \todo   
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
            $currentUser = $_SESSION['currentUser'];
            require_once CLASSES_DIR . 'playlistParse.class.php';
            $playlistP = new PlaylistParse();
            $playlist = $playlistP->getPlaylist($playlistId);
            if ($playlist instanceof Error) {
                $this->response(array($controllers['NOPLAYLIST']), 503);
            } elseif (!in_array($songId, $playlist->getSongsArray())) {
                $this->response(array('status' => $controllers['ERRORCHECKINGSONGINTRACKLIST']), 503);
            }
            if (count($playlist->songsArray) == 0) {
                $this->response(array('status' => $controllers['NOTHINGTOREMOVE']), 503);
            }
            $res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
            if ($res instanceof Error) {
                $this->response(array('status' => $controllers['NOREMOVESONGTOPLAYREL']), 503);
            }
            $res1 = $playlistP->removeObjectIdFromArray($playlistId, 'songsArray', $songId);
            if ($res1 instanceof Error) {
                $this->response(array('status' => $controllers['NOREMOVESONGTOPLAYARRAY']), 503);
            }
            $activity = $this->createActivity("SONGREMOVEDFROMPLAYLIST", $currentUser->getObjectId(), $playlistId, $songId);
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activityParse = new ActivityParse();
            $resActivity = $activityParse->saveActivity($activity);
            if ($resActivity instanceof Error) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackPlaylistController($playlistId, $songId, 'remove', $currentUser->getPremium(), $this->config->songsLimit);
                $this->response(array('status' => $message), 503);
            }
            $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	createActivity($type, $fromUser, $playlistId, $songId)
     * \brief   create activity for playslitControlelr
     * \param   $type, $fromUser, $playlistId, $songId
     * \return  $activity     
     */
    private function createActivity($type, $fromUser, $playlistId, $songId) {
        require_once CLASSES_DIR . 'activity.class.php';
        $activity = new Activity();
        $activity->setActive(true);
        $activity->setAlbum(null);
        $activity->setComment(null);
        $activity->setCounter(0);
        $activity->setEvent(null);
        $activity->setFromUser($fromUser);
        $activity->setImage(null);
        $activity->setPlaylist($playlistId);
        $activity->setQuestion(null);
        $activity->setRead(true);
        $activity->setRecord(null);
        $activity->setSong($songId);
        $activity->setStatus('A');
        $activity->setToUser(null);
        $activity->setType($type);
        $activity->setUserStatus(null);
        $activity->setVideo(null);
        return $activity;
    }

}

?>