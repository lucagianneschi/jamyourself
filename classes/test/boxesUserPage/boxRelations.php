<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Relations
 * \details		Recupera le ultime relazioni per tipologia di utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo        utilizzare le variabili di sessione e non fare la get dello user
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();

$id = '7fes1RyY77';//LDF
$userParse = new UserParse();
$user = $userParse->getUser($id);
$type = $user->getType();
switch ($type) {
    case 'SPOTTER':
		$following_start = microtime();
		$activityParse = new ActivityParse();
		$activityParse->setLimit(4);
		$activityParse->whereEqualTo('type', 'FOLLOWING');
		$activityParse->wherePointer('fromUser', '_User', $id);
		$activityParse->where('active', true);
		$activityParse->whereInclude('toUser');
		$activityParse->orderByDescending('createdAt');
		$activities = $activityParse->getActivities();
		if ($activities != 0) {
			if (get_class($activities) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
			foreach ($activities->toUser as $toUser) {
				echo '<br />[username] => ' . $toUser->getUsername() . '<br />';
				echo '<br />[thumbnail] => ' . $toUser->getProfileThumbnail() . '<br />';
			}
			}
		}
		$following_stop = microtime();
	
		$friendship_start = microtime();
		$activityParse1 = new ActivityParse();
		$activityParse1->setLimit(4);
		$activityParse1->wherePointer('fromUser', '_User', $id);
		$activityParse1->whereEqualTo('type', 'FRIENDSHIPREQUEST');
		$activityParse1->where('active', true);
		$activityParse1->whereEqualTo('status', 'A');
		$activityParse1->whereInclude('toUser');
		$activityParse1->orderByDescending('createdAt');
		$activities1 = $activityParse1->getActivities();
		if ($activities1 != 0) {
			if (get_class($activities1) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $activities->getErrorMessage() . '<br/>';
			} else {
			foreach ($activities->toUser as $toUser) {
				echo '<br />[username] => ' . $toUser->getUsername() . '<br />';
				echo '<br />[thumbnail] => ' . $toUser->getProfileThumbnail() . '<br />';
			}
			}
		}
	
		$friendship_stop = microtime();
		echo '<br />----------------------SPOTTER---------------------------<br />';
	break;
    case 'VENUE':
		$collaborationVenueVenue_start = microtime();
		$parseUser = new UserParse();
		$parseUser->whereRelatedTo('collaboration', '_User', $id);
		$parseUser->whereEqualTo('type', 'VENUE');
		$parseUser->where('active', true);
		$parseUser->setLimit(4);
		$parseUser->orderByDescending('createdAt');
		$last4venues = $parseUser->getUsers();
		foreach ($last4venues as $venue) {
			echo '<br />[username] => ' . $venue->getUsername() . '<br />';
			echo '<br />[thumbnail] => ' . $venue->getProfileThumbnail() . '<br />';
		}
		echo '<br />[venue count] => ' . $venueCount . '<br />'; //mettere opportuno contatore nello User
		$collaborationVenueVenue_stop = microtime();
		$collaborationVenueJammer_start = microtime();
		$parseUser1 = new UserParse();
		$parseUser1->whereRelatedTo('collaboration', '_User', $id);
		$parseUser1->whereEqualTo('type', 'JAMMER');
		$parseUser1->setLimit(4);
		$parseUser1->orderByDescending('createdAt');
		$last4jammers = $parseUser1->getUsers();
		foreach ($last4jammers as $jammer) {
			echo '<br />[username] => ' . $jammer->getUsername() . '<br />';
			echo '<br />[thumbnail] => ' . $jammer->getProfileThumbnail() . '<br />';
		}
		
		echo '<br />[jammer count] => ' . $jammerCount . '<br />'; //mettere contatore nello User
	
		$collaborationVenueJammer_stop = microtime();
	
		$followingVenue_start = microtime();
		$parseActivity = new ActivityParse();
		$parseActivity->wherePointer('toUser', '_User', $id);
		$parseActivity->whereEqualTo('type', 'FOLLOWING');
		$parseActivity->where('active', true);
		$parseActivity->whereInclude('fromUser');
		$parseActivity->setLimit(4);
		$parseActivity->orderByDescending('createdAt');
		$last4followers = $parseActivity->getActivities();
		foreach ($last4followers->fromUser as $fromUser) {
			echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
			echo '<br />[thumbnail] => ' . $fromUser->getProfileThumbnail() . '<br />';
		}
		$followingVenue_stop = microtime();
		echo '<br />----------------------VENUE---------------------------<br />';
	break;
    case 'JAMMER':


	$collaborationJammerVenue_start = microtime();
	$parseUser = new UserParse();
	$parseUser->whereRelatedTo('collaboration', '_User', $id);
	$parseUser->whereEqualTo('type', 'VENUE');
	$parseUser->where('active', true);
	$parseUser->setLimit(4);
	$parseUser->orderByDescending('createdAt');
	$last4venues = $parseUser->getUsers();
	if ($last4venues != 0) {
	    if (get_class($last4venues) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last4venues->getErrorMessage() . '<br/>';
	    } else {
		foreach ($last4venues as $venue) {
		    echo '<br />[username] => ' . $venue->getUsername() . '<br />';
		    echo '<br />[thumbnail] => ' . $venue->getProfileThumbnail() . '<br />';
		}
	    }
	}
	$collaborationJammerVenue_stop = microtime();

	$collaborationJammerJammer_start = microtime();
	$parseUser1 = new UserParse();
	$parseUser1->whereRelatedTo('collaboration', '_User', $id);
	$parseUser1->whereEqualTo('type', 'JAMMER');
	$parseUser1->where('active', true);
	$parseUser1->setLimit(4);
	$parseUser1->orderByDescending('createdAt');
	$last4jammers = $parseUser1->getUsers();
	if ($last4jammers != 0) {
	    if (get_class($last4jammers) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last4jammers->getErrorMessage() . '<br/>';
	    } else {
		foreach ($last4jammers as $jammer) {
		    echo '<br />[username] => ' . $jammer->getUsername() . '<br />';
		    echo '<br />[thumbnail] => ' . $jammer->getProfileThumbnail() . '<br />';
			
		}	
	    }
	}
	$collaborationJammerJammer_stop = microtime();

	$followingVenue_start = microtime();
	$parseActivity = new ActivityParse();
	$parseActivity->wherePointer('toUser', '_User', $id);
	$parseActivity->whereEqualTo('type', 'FOLLOWING');
	$parseActivity->where('active', true);
	$parseActivity->whereInclude('fromUser');
	$parseActivity->setLimit(4);
	$parseActivity->orderByDescending('createdAt');
	$last4followers = $parseActivity->getActivities();
	if ($last4followers != 0) {
	    if (get_class($last4followers) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last4followers->getErrorMessage() . '<br/>';
	    } else {
		foreach ($last4followers->fromUser as $fromUser) {
			if($fromUser->getActive != false){
		    echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
		    echo '<br />[thumbnail] => ' . $fromUser->getProfileThumbnail() . '<br />';
		}
		}
	    }
	}
	$followingVenue_stop = microtime();
	echo '<br />----------------------JAMMER---------------------------<br />';
	break;
    default:
	break;
}
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
switch ($type) {
    case 'SPOTTER':
		echo '<br />----------------------SPOTTER---------------------------<br />';
		echo 'Tempo ultimi 4 following ' . executionTime($following_start, $following_stop) . '<br />';
		echo 'Tempo ultimi 4 friends ' . executionTime($friendship_start, $friendship_stop) . '<br />';
	break;
    case 'VENUE':
		echo '<br />----------------------VENUE---------------------------<br />';
		echo 'Tempo recupero relazione following ' . executionTime($followingVenue_start, $followingVenue_stop) . '<br />';
		echo 'Tempo recupero relazione relazione Venue - Venue ' . executionTime($collaborationVenueVenue_start, $collaborationVenueVenue_stop) . '<br />';
		echo 'Tempo recupero relazione Venue - Jammer ' . executionTime($collaborationVenueJammer_start, $collaborationVenueJammer_stop) . '<br />';
		echo 'Tempo recupero relazione Following' . executionTime($followingVenue_start, $followingVenue_stop) . '<br />';
	break;
    case 'JAMMER':
		echo '<br />----------------------JAMMER---------------------------<br />';
		echo 'Tempo recupero relazione relazione Jammer - Venue' . executionTime($collaborationJammerVenue_start, $collaborationJammerVenue_stop) . '<br />';
		echo 'Tempo recupero relazione Jammer - Jammer' . executionTime($collaborationJammerJammer_start, $collaborationJammerJammer_stop) . '<br />';
		echo 'Tempo recupero relazione Following ' . executionTime($followingVenue_start, $followingVenue_stop) . '<br />';
	break;
    default:
	break;
}
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>