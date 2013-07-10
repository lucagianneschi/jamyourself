<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Activity
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
$eventParse = new EventParse();
$eventParse->wherePointer('fromUser', '_User', $id);
$eventParse->orderByDescending('updatedAt');
$eventParse->setLimit(4);
$resGets = $eventParse->getEvents();
if ($resGets != 0) {
    if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
    } else {
	foreach ($resGets as $event) {
	    echo '<br />[title] => ' . $event->getTitle() . '<br />';
	    echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
	    if ($event->getFeaturing() != 0) {
		foreach ($event->getFeaturing() as $user) {
                   $userParse = new UserParse();
		   $feat = $userParse->getUser($user);
		   echo '<br />[feat] => ' . $feat->getUsername() . '<br />';
		}
	    }
	    echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
	    echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
	}
    }
}

echo '<br />----------------FINE------BOX------------EVENT---------------------------------<br />';
?>

