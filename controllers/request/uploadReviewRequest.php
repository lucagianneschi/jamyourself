<?php

/* ! \par		Info Generali:
 * @author		Stefano Muscas
 * @version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file di request per il controller uopload
 * \par			Commenti:
 * \warning
 * \bug
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'uploadReview.controller.php';
session_start();

$controller = new uploadReviewController();
$controller->processApi();
?>
