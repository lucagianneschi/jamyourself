<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info utente
 * \details		Recupera le informazioni dell'utente, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * \brief	UserInfoBox class 
 * \details	box class to pass info to the view 
 */
class UserInfoBox {

    public $error = null;
    public $user = null;

    /**
     * \fn	init($id)
     * \brief	Init InfoBox instance for Personal Page
     * \param	$id for user that owns the page
     * @return  instance of UserInfoBox
     */
    public function init($id) {
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection === false) {
	    $this->error = 'Errore nella connessione';
	}
	$user = selectUsers($connection, $id);
	if ($user === false) {
	    $this->error = 'Errore nella query';
	}
	$this->user = $user;
    }

}

?>