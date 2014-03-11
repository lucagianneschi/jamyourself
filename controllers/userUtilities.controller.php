<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di operazioni legate all'utente
 * \details		controller di utilities riferite alla classe utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		Fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');



require_once ROOT_DIR . 'config.php';

require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';

/**
 * \brief	UserUtilitiesController class 
 * \details	controller di utilities riferite alla classe utente
 */
class UserUtilitiesController extends REST {

    /**
     * \fn		passwordReset()
     * \brief   esegue una richiesta di reset della password
     * \todo    usare la sessione
     */
    public function passwordReset() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($this->request['email'])) {
		$this->response(array('status' => $controllers['NOEMAILFORRESETPASS']), 403);
	    }
	    $email = $this->request['email'];




	    $this->response(array($controllers['OKPASSWORDRESETREQUEST']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

}

?>