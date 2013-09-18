<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'post/post.controller.php';


////////////////////////////////////////////////////////////////////////////////
//
// ESECUZIONE DELLO SCRIPT 
//  
//////////////////////////////////////////////////////////////////////////////// 
//inizializza la sessione
session_start();

// Initiiate Library
$controller = new PostController();
$controller->processApi();

?>
