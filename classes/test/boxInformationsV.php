<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Box informazioni
 * \details		Recupera le informazioni da mostrare per il profilo selezionato
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

$id = 'feny292KyY';
echo '<br />----------------------BOX------------INFORMATIONS-------------------------------------<br />';
$userParse = new UserParse();
$user = $userParse->getUser($id);
echo '<br />[username] => ' . $user->getUsername() . '<br />';//BOX 5
echo '<br />[backGround] => ' . $user->getBackGround() . '<br />';//BOX 5
echo '<br />[profilePicture] => ' . $user->getProfilePicture() . '<br />';//BOX 5
echo '<br />[username] => ' . $user->getUsername() . '<br />';
echo '<br />[description] => ' . $user->getDescription() . '<br />';
echo '<br />[localType] => ' . $user->getlocalType() . '<br />'; 
echo '<br />[city] => ' . $user->getCity() . '<br />';
echo '<br />[country] => ' . $user->getCountry() . '<br />';
echo '<br />[faceBook Page] => ' . $user->getFbPage() . '<br />';
echo '<br />[Twitter Page] => ' . $user->getTwitterPage() . '<br />';
echo '<br />[WebSite Page] => ' . $user->getWebsite() . '<br />';
echo '<br />[Youtube Channel] => ' . $user->getYoutubeChannel() . '<br />';
echo '<br />[punteggio] => ' . $user->getLevel() . '<br />';//BOX 4 
echo '<br />----------------FINE------BOX------------INFORMATIONS---------------------------------<br />'
?>
