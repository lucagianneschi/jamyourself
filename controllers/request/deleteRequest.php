<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'delete.controller.php';

// Initiate Library
$controller = new DeleteController();
$controller->processApi();
?>
