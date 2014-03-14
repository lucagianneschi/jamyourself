<?php

/**
 * classe per la gestione delle operazioni iniziali
 * 
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-03-14
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

if (MANTAINANCE_MODE) {
    header('Location: ' . VIEWS_DIR . 'mantainance.php');
}
?>