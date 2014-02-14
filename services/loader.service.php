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
    require_once SERVICES_DIR . 'debug.service.php';
    require_once SERVICES_DIR . 'lang.service.php';
 if (strpos($className, 'Box') !== false) {
	$classFile = BOXES_DIR . lcfirst(strtolower(str_replace('Box', "", $className))) . '.box.php';
    } elseif (strpos($className, 'Controller') !== false) {
	$utils = CONTROLLERS_DIR . 'utilsController.php';
	$languageFile = LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
	$classFile = CONTROLLERS_DIR . lcfirst(strtolower(str_replace('Controller', "", $className))) . '.controller.php';
    } else {
	$classFile = CLASSES_DIR . strtolower($className) . '.class.php';
    }
    if (!is_readable($utils) || !is_readable($languageFile) || !is_readable($classFile)) {
	return false;
    }
    require_once $utils;
    require_once $languageFile;
    require_once $classFile;
    return true;
}

spl_autoload_register('dynamicLoading');
?>