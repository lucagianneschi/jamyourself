<?php

/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file di request per il controller love/unlove
 * \par			Commenti:
 * \warning
 * \bug
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'love.controller.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$controller = new LoveController();
$controller->processApi();
?>
