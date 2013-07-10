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

$id = '7fes1RyY77';
echo '<br />----------------------B--------------------------<br />';
$parseUser = new UserParse();
$parseUser->whereRelatedTo('collaboration', '_User', $id);
$parseUser->whereEqualTo('type', 'JAMMER');
$parseUser->setLimit(4);
$parseUser->orderByDescending('createdAt');
$last4jammers = $parseUser->getUsers();
foreach ($last4jammers as $jammer){
    echo '<br />[username] => ' . $jammer->getUsername() . '<br />';
    echo '<br />[thumbnail] => ' . $jammer->getProfileThumbnail() . '<br />';
}
$jammerCount = $parseUser->getCount();
echo '<br />[jammer count] => ' .$jammerCount . '<br />';
?>
