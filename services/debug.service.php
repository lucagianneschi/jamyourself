<?php

/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version            1.0
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

function debug($path, $file, $msg) {
    $fp = fopen($path . $file, 'a+');
    fwrite($fp, $msg . "\n");
    fclose($fp);
}

?>