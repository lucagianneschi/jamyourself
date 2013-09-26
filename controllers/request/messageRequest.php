<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'message.controller.php';

session_start();

$controller = new MessageController();
$controller->processApi();
?>
