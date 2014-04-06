<?php

/**
 * 
 * Funzione per gestione operazioni iniziali
 * 
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-03-17
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