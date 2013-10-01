<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'review.controller.php';

session_start();

$controller = new ReviewController();
$controller->processApi();
?>
