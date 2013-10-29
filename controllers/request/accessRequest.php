<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file di request per il controller di login e logout
 * \par			Commenti:
 * \warning
 * \bug
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

session_start();

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'access.controller.php';

$controller = new AccessController();
$controller->processApi();
?>
