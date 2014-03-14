<?php

/**
 * Debub & log function
 * 
 * author Daniele Caldelli
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

/**
 * @param file $file File in cui scrive il debug
 * @param string $msg messaggio di errore
 * @return	void
 */
function jamDebug($file, $msg) {
    if (!is_dir(DEBUG_DIR)) {
	mkdir(DEBUG_DIR);
    }
    $fp = fopen(DEBUG_DIR . $file, 'a+');
    fwrite($fp, '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n");
    fclose($fp);
}

/**
 * @param string $where Posizione del log nel codice
 * @param int $lineError Riga del codice in cui ho errore
 * @param string $error Tipo di errore
 * @return	void
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

?>