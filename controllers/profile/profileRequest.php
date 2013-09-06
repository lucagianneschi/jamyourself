<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'profile/profile.controller.php';

// Initiate Library
$controller = new ProfileController();
$controller->processApi();
?>
