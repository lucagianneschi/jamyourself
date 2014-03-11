<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		0.3
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file di request per il controller playlist
 * \par			Commenti:
 * @warning
 * @bug
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'playlist.controller.php';
session_start();

$controller = new PlaylistController();
$controller->processApi();
?>
