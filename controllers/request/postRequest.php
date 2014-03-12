<?php

/**
 * PostController request
 * 
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'post.controller.php';
session_start();

$controller = new PostController();
$controller->processApi();
?>