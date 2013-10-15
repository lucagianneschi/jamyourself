<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di ricerca
 * \details		effettua la ricerca di elementi nel sito
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once DEBUG_DIR . 'debug.php';

/**
 * \brief	SearchController class 
 * \details	controller di inserimento di una review 
 */
class SearchController extends REST {

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
				
		} catch (Exception $e){
			$this->response(array('status' => "Service Unavailable", "msg" => $e->getMessage()), 503);
		}
	}
	
}

?>