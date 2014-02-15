<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di ricerca
 * \details		effettua la ricerca di elementi nel sito
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		terminare, implementare; fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
 

/**
 * \brief	SearchController class 
 * \details	controller di inserimento di una review 
 */
class SearchController extends REST {

    public $config;

    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "searchController.config.json"), false);
    }

    /**
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
	session_start();
    }

    /**
     * \fn		search()
     * \brief   effettua la ricerca
     * \todo    tutto
     */
    public function search() {
	try {
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['text'])) {
		$this->response(array('status' => $controllers['NOSEARCHTEXT']), 400);
	    } elseif (strlen($text) < $this->config->minSearchTextSize) {
		$this->response(array($controllers['SHORTSEARCHTEXT'] . strlen($text)), 200);
	    }
	    $classType = $this->request['classType'];
	    $text = $this->request['text'];
	    require_once CLASSES_DIR . 'activity.class.php';
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activity = new Activity();
	    $activity->setActive(true);
	    $activity->setAlbum(null);
	    $activity->setComment(null);
	    $activity->setCounter(0);
	    $activity->setEvent(null);
	    $activity->setFromuser(null);
	    $activity->setImage(null);
	    $activity->setPlaylist(null);
	    $activity->setQuestion(null);
	    $activity->setRead(false);
	    $activity->setRecord(null);
	    $activity->setSong(null);
	    $activity->setStatus('A');
	    $activity->setToUser(null);
	    $activity->setType('SEARCH');
	    $activity->setVideo(null);
	    $activityParse = new ActivityParse();
	    $resActivity = $activityParse->saveActivity($activity);
	    if ($resActivity instanceof Error) {
		$this->response(array('status' => $controllers['SEARCHOK']), 200);
	    }
	    $this->response(array('status' => $controllers['SEARCHOK']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>