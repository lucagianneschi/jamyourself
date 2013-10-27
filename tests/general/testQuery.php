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
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';


echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Activity<br />';

$activityParse = new ActivityParse();
$activityParse->whereExists('objectId');
$activityParse->orderByDescending('createdAt');
$activityParse->setLimit(1);
$activityParse->whereInclude('fromUser,toUser');
$resGets = $activityParse->getActivities();
if (get_class($resGets) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
    foreach ($resGets as $act) {
	var_dump($act);
//	echo '<br />' . $act->getObjectId() . '<br />';
//	$fromUser = $act->getFromUser();
//	echo '<br />' . $fromUser->getUserName() . '<br />';
//	$toUser = $act->getToUser();
//	echo '<br />' . $toUser->getUserName() . '<br />';
    }
}

echo '<br />FINITO IL RECUPERO DI PIU\' Activity<br />';
echo '<br />-------------------------------------------------------------------------------<br />';
?>