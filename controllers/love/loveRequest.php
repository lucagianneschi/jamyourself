<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'love/love.controller.php';

// Initiate Library
$controller = new LoveController();
$controller->processApi();
?>
