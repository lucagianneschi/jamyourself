<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		0.3
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione della playlist
 * \details		gestisce l'inserimento e la cancellazione di una song dalla tracklist di una playlist
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		 fare API su Wiki, controllare codice removeSong()
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	PlaylistController class 
 * \details	controller di gestione playlist
 */
class PlaylistController extends REST {

    public $config;

    /**
     * \fn		construct()
     * \brief   load config file for the controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "playlistController.config.json"), false);
    }

    /**
     * \fn      addSong()
     * \brief   add song to playlist
     * \todo    utilizzare il servizio insert.service per scrivere sul DB
     */
    public function addSong() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['currentUser'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 403);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    } elseif (!isset($_SESSION['playlist'])) {
		//creare la playlist
	    }
	    $playlistId = $_SESSION['playlist']['id'];
	    $songId = $this->request['songId'];
	    $currentUser = $_SESSION['currentUser'];
	    require_once CLASSES_DIR . 'playlist.class.php';
	    $playlist = selectPlaylists($playlistId);
	    if ($playlist instanceof Error) {
		$this->response(array('status' => $controllers['NOPLAYLIST']), 503);
	    } elseif (in_array($songId, $playlist->getSongsArray())) {
		$this->response(array('status' => $controllers['SONGALREADYINTRACKLIST']), 503);
	    }

	    $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * \fn	removeSong()
     * \brief   remove song to playlist 
     * \todo   
     */
    public function removeSong() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['songId'])) {
		$this->response(array('status' => $controllers['NOSONGID']), 403);
	    }
	    $playlistId = $_SESSION['playlist']['id'];
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

	    $this->response(array($controllers['SONGADDEDTOPLAYLIST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>