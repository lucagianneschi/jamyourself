<?php

$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();


$id = '7fes1RyY77'; //LDF

$user_start = microtime();
$userParse = new UserParse();
$user = $userParse->getUser($id);
echo '<br />[username] => ' . $user->getUsername() . '<br />'; //BOX 5
echo '<br />[backGround] => ' . $user->getBackGround() . '<br />'; //BOX 5
echo '<br />[profilePicture] => ' . $user->getProfilePicture() . '<br />'; //BOX 5
echo '<br />[description] => ' . $user->getDescription() . '<br />';
echo '<br />[city] => ' . $user->getCity() . '<br />';
echo '<br />[country] => ' . $user->getCountry() . '<br />';
echo '<br />[faceBook Page] => ' . $user->getFbPage() . '<br />';
echo '<br />[Twitter Page] => ' . $user->getTwitterPage() . '<br />';
echo '<br />[WebSite Page] => ' . $user->getWebsite() . '<br />';
echo '<br />[Youtube Channel] => ' . $user->getYoutubeChannel() . '<br />';
echo '<br />[punteggio] => ' . $user->getLevel() . '<br />'; //BOX 4
$user_stop = microtime();

$type = $user->getType();
switch ($type) {
    case 'SPOTTER':
	echo '<br />[followingCounter] => ' . $user->getFollowingCounter() . '<br />';
	echo '<br />[frindshipCounter] => ' . $user->getFriendshipCounter() . '<br />';
	$musicGenres = $user->getMusic();
	if (empty($musicGenres) != true) {
	    foreach ($musicGenres as $genre) {
		echo '<br />[music] => ' . $genre . '<br />';
	    }
	}
	break;
    case 'JAMMER':
	echo '<br />[jammerType] => ' . $user->getJammerType() . '<br />'; //BOX 4
	echo '<br />[followersCounter] => ' . $user->getFollowersCounter() . '<br />'; //BOX 4
	echo '<br />[collaborationCounter] => ' . $user->getCollaborationCounter() . '<br />';
	echo '<br />[venueCounter] => ' . $user->getVenueCounter() . '<br />';
	echo '<br />[jammerCounter] => ' . $user->getJammerCounter() . '<br />';
	$musicGenres = $user->getMusic();
	if (empty($musicGenres) != true) {
	    foreach ($musicGenres as $genre) {
		echo '<br />[music] => ' . $genre . '<br />';
	    }
	}
	break;
    case 'VENUE':
	echo '<br />[localType] => ' . $user->getlocalType() . '<br />';
	echo '<br />[followersCounter] => ' . $user->getFollowersCounter() . '<br />'; //BOX 4
	echo '<br />[collaborationCounter] => ' . $user->getCollaborationCounter() . '<br />';
	echo '<br />[venueCounter] => ' . $user->getVenueCounter() . '<br />';
	echo '<br />[jammerCounter] => ' . $user->getJammerCounter() . '<br />';
	break;
    default:
	break;
}
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero User proprietario pagina ' . executionTime($user_start, $user_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>
