<?php

/* ! \par		Info Generali:
 * \author		Stefano Muscas
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
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
require_once CONTROLLERS_DIR . 'upload.controller.php';


////////////////////////////////////////////////////////////////////////////////
//
// ESECUZIONE DELLO SCRIPT 
//  
//////////////////////////////////////////////////////////////////////////////// 
//inizializza la sessione
try {
    session_start();

// Initiiate Library
    $controller = new UploadController();
    $controller->processApi();
} catch (Exception $e) {
    //log di sistema
}
?>
