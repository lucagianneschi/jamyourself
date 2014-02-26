<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file di request per il controller di social riferite alla classe utente
 * \par			Commenti:
 * \warning
 * \bug
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'social.controller.php';
session_start();

$controller = new SocialController();
$controller->processApi();
?>