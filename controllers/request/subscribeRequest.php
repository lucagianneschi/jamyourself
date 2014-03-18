<?php

/**
 * SubscribeController request
 * 
 * @author Stefano Muscas
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
require_once CONTROLLERS_DIR . 'subscribe.controller.php';

$controller = new SubscribeController();
$controller->processApi();
?>