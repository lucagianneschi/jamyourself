<?php

/* ! \par		Info Generali:
 *  @author		Daniele Caldelli
 *  @version            0.3
 *  \date		2013
 *  \copyright          Jamyourself.com 2013
 *  \par		Info :
 *  \brief		Debub function
 *  \details            Funzione per scrivere su file un bug
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';

/**
 * \fn		jamLog($where, $lineError, $error)
 * \brief	log servive
 * @return	connection or false
 */
function jamLog($where, $lineError, $error) {
    if (LOG) {
	if (!is_dir(LOG_DIR)) {
	    mkdir(LOG_DIR);
	}
	$fp = fopen(LOG_DIR . date('Ymd') . '.txt', 'a+');
	fwrite($fp, '[' . date('Y-m-d H:i:s') . ' | ' . substr($where, strrpos($where, '\\') + 1) . ' (' . $lineError . ')] => ' . $error . "\n");
	fclose($fp);
    }
}

/**
 * \fn		jamDebug($file, $msg)
 * \brief	debug service
 * @return	connection or false
 */
function jamDebug($file, $msg) {
    if (!is_dir(DEBUG_DIR)) {
	mkdir(DEBUG_DIR);
    }
    $fp = fopen(DEBUG_DIR . $file, 'a+');
    fwrite($fp, '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n");
    fclose($fp);
}

?>