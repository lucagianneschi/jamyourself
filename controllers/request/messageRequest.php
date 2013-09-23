<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'message/message.controller.php';


////////////////////////////////////////////////////////////////////////////////
//
// ESECUZIONE DELLO SCRIPT 
//  
//////////////////////////////////////////////////////////////////////////////// 
//inizializza la sessione
session_start();

// Initiate Library
$controller = new MessageController();
$controller->processApi();

?>
