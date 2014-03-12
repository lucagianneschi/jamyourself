<?php

/* ! \par		Info Generali:
 * @author		Daniele Caldelli
 * @version		1.0
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		classe per la gestione delle operazioni iniziali
 * \details		
 * \par			
 * @warning
 * @bug
 * @todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

if (MANTAINANCE_MODE) {
    header('Location: ' . VIEWS_DIR . 'mantainance.php');
}
?>