<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Box Album
 * \details		Box per mostrare gli ultimi album inseriti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

$id = 'GuUAj83MGH';
echo '<br />----------------------BOX------------EVENT-------------------------------------<br />';

$eventParse = new parseQuery('Event');
$eventParse->wherePointer('fromUser', '_User', $id);
$eventParse->orderByDescending('updatedAt');
$eventParse->setLimit(4);
$resGets = $eventParse->find();
if ($resGets != 0) {
    if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
    } else {
	foreach ($resGets as $event) {
	    var_dump($event);
	}
    }
}
echo '<br />----------------FINE------BOX------------EVENT---------------------------------<br />';
?>
