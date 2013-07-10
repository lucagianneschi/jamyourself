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
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';

$id = '7fes1RyY77';

$parseActivity = new ActivityParse();
$parseActivity->whereEqualTo('type', 'FOLLOWING');
$parseActivity->wherePointer('toUser', '_User', $id);
$parseActivity->setLimit(4);
$parseActivity->orderByDescending('createdAt');
$last4spotter = $parseActivity->getActivities();
foreach ($last4spotter as $spotter){
    $parseUser = new UserParse();
    $fromUser = $parseUser->getUser($spotter->getFromUser());
    echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
    echo '<br />[thumbnail] => ' . $fromUser->getProfileThumbnail() . '<br />';
}
$spottersCount = $parseActivity->getCount();
echo '<br />[spotters count] => ' .$spottersCount . '<br />';
echo '<br />-----------FINE----------BOX---FOLLOWERS-&-COLLABORATORS--------------------------<br />';
?>
