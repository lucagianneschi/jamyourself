<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		servizio di lazy loading delle classi
 * \details		effettua la require_once solo al momento necessario
 * \par			Commenti:
 * \warning
 * \bug			non carica i file di lingua
 * \todo		testare tutte le classi, gestione dei servizi
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
ini_set('display_errors', '1');
spl_autoload_register(null, false);
spl_autoload_extensions('.php, .class.php, .box.php, .controller.php, .classes.lang.php, .boxes.lang.php, .controllers.lang.php');

function dynamicLoading($className) {
    require_once ROOT_DIR . 'config.php';
    require_once PARSE_DIR . 'parse.php';
    require_once SERVICES_DIR . 'debug.service.php';
    require_once SERVICES_DIR . 'lang.service.php';
    if (strpos($className, 'Parse') !== false) {
	require_once CLASSES_DIR . 'utilsClass.php';
	require_once LANGUAGES_DIR . 'classes/' . getLanguage() . '.classes.lang.php';
	$file = CLASSES_DIR . lcfirst($className) . '.class.php';
    } elseif (strpos($className, 'Box') !== false) {
	require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
	require_once BOXES_DIR . 'utilsBox.php';
	$filename = strtolower(str_replace('Box', '', $className));
	$file = BOXES_DIR . lcfirst($filename) . '.box.php';
    } elseif (strpos($className, 'Controller') !== false) {
	require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
	require_once CONTROLLERS_DIR . 'restController.php';
	$file = CONTROLLERS_DIR . lcfirst($className) . '.box.php';
    } else {
	$file = CLASSES_DIR . strtolower($className) . '.class.php';
    }
    //mancano da gestire i servizi
    echo $file;
    if (!is_readable($file)) {
	die();
    }
    require_once $file;
}

spl_autoload_register('dynamicLoading');
?>