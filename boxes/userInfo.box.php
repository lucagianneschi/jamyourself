<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * UserInfoBox class, box class to pass info to the view
 * Recupera le informazioni del post e le mette in oggetto postBox
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class UserInfoBox {

    public $error = null;
    public $user = null;

    /**
     * Init InfoBox instance for Personal Page
     * @param	int $id for user that owns the page
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