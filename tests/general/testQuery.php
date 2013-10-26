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
$activityParse->setLimit(1000);
$activityParse->whereInclude('fromUser');
$resGets = $activityParse->getActivities();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $album) {
		echo '<br />' . $album->getObjectId() . '<br />';
		$user = $album->getFromUser();
		echo '<br />' . $user->getUserName() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Activity<br />';
echo '<br />-------------------------------------------------------------------------------<br />';
?>