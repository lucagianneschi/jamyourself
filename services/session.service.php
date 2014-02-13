<?php

/* ! \par		Info Generali:
 * \author		Daniele Caldelli
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		classe per la gestione delle operazioni iniziali
 * \details		
 * \par			
 * \warning
 * \bug
 * \todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'userParse.class.php';

if (session_id() == '')
    session_start();

if (!isset($_SESSION['currentUser']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
    header('Location: ' . ROOT_DIR . 'index.php?login');
} elseif (isset($_SESSION['currentUser']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
    header('Location: ' . VIEWS_DIR . 'stream.php');
}
?>