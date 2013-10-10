<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file di request per il controller message
 * \par			Commenti:
 * \warning
 * \bug
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
	
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'message.controller.php';

$controller = new MessageController();
$controller->processApi();
?>
