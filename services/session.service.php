<?php

/**
 * Servizio verfica della sessione
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

if (session_id() == '')
    session_start();

if (!isset($_SESSION['id']) && basename($_SERVER['PHP_SELF']) != 'index.php' && basename($_SERVER['PHP_SELF']) != 'signup.php') {
    header('Location: ' . ROOT_DIR . 'index.php?login');
} elseif (isset($_SESSION['id']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
    header('Location: ' . VIEWS_DIR . 'stream.php');
}
?>