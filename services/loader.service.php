<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.1
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		servizio di lazy loading delle classi
 * \details		effettua la require_once solo al momento necessario
 * \par			Commenti:
 * \warning
 * \bug			
 * \todo		testare tutte le classi, gestione dei servizi
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
ini_set('display_errors', '1');
spl_autoload_register(null, false);
spl_autoload_extensions('.php, .class.php, .box.php, .controller.php');

function dynamicLoading($className) {
    require_once SERVICES_DIR . 'log.service.php';
    $boxString = strpos($className, 'Box');
    if ($boxString == true) {
	require_once ROOT_DIR . 'config.php';
	require_once SERVICES_DIR . 'connection.service.php';
    }
    
}

spl_autoload_register('dynamicLoading');
?>