<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di login e logout
 * \details		effettua operazioni di login e logut utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		implementare i parametri di sessione (es currentUser)
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

/**
 * \brief	ReviewController class 
 * \details	controller di inserimento di una review 
 */
class AccessController extends REST {

    /**
     * \fn		init()
     * \brief   start the session
     */
    public function init() {
	session_start();
    }

    /**
     * \fn		login()
     * \brief   user login
     * \todo    usare la sessione
     */
    public function login() {

	#TODO
	//in questa fase di debug, il fromUser e il toUser sono uguali e passati staticamente
	//questa sezione prima del try-catch dovrà sparire
	$userParse = new UserParse();
	$fromUser = $userParse->getUser($this->request['fromUser']);
	$toUser = $fromUser;

	try {
	    $this->response(array('Your review has been saved'), 200);
	} catch (Exception $e) {
	    $this->response(array('Error: ' . $e->getMessage()), 503);
	}
    }

    /**
     * \fn		logout()
     * \brief   user logout
     * \todo    usare la sessione
     */
    public function logout() {

	#TODO
	//in questa fase di debug, il fromUser e il toUser sono uguali e passati staticamente
	//questa sezione prima del try-catch dovrà sparire
	$userParse = new UserParse();
	$fromUser = $userParse->getUser($this->request['fromUser']);
	$toUser = $fromUser;

	try {
	    $this->response(array('Your review has been saved'), 200);
	} catch (Exception $e) {
	    $this->response(array('Error: ' . $e->getMessage()), 503);
	}
    }

}

?>