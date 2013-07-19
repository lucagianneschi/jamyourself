<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		File di caricamento informazioni pagina Jammer
 * \details		Recupera le informazioni da mostrare per il profilo selezionato
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
$i_end = microtime();

$id = '7fes1RyY77';
$user_start = microtime();
$userParse = new UserParse();
$user = $userParse->getUser($id);
$user_stop = microtime();
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
$album_start = microtime();
$album = new AlbumParse();
$album->wherePointer('fromUser', '_User', $id);
$album->setLimit(4);
$album->orderByDescending('createdAt');
$albums = $album->getAlbums();
if ($albums != 0) {
    if (get_class($albums) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $albums->getErrorMessage() . '<br/>';
    } else {
	foreach ($albums as $album) {
	    echo '<br />[thumbnailCover] => ' . $album->getThumbnailCover() . '<br />';
	    echo '<br />[title] => ' . $album->getTitle() . '<br />';
	    echo '<br />[loveCounter] => ' . $album->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $album->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $album->getShareCounter() . '<br />';
	}
    }
}
$album_stop = microtime();

$post_start = microtime();
$parsePost = new CommentParse();
$parsePost->wherePointer('toUser', '_User', $id);
$parsePost->where('type', 'P');
$parsePost->setLimit(3);
$parsePost->orderByDescending('createdAt');
$parsePost->whereInclude('fromUser');
$last3post = $parsePost->getComments();
if ($last3post != 0) {
    if (get_class($last3post) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $last3post->getErrorMessage() . '<br/>';
    } else {
	foreach ($last3post->fromUser as $fromUser) {
	    echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
	    echo '<br />[type] => ' . $fromUser->getType() . '<br />';
	    echo '<br />[thumb] => ' . $fromUser->getProfileThumbnail() . '<br />';
	}
	foreach ($last3post as $post) {
	    echo '<br />[testo] => ' . $post->getText() . '<br />';
	    echo '<br />[data creazione] => ' . $post->getCreatedAt() . '<br />';
	    echo '<br />[loveCounter] => ' . $post->getLoveCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $post->getShareCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $post->getCommentCounter() . '<br />';
	}
    }
}
$post_stop = microtime();
//qui carichi solo la roba che interessa a quel tipo di utente
$type = $user->getType();
switch ($type) {
    case 'SPOTTER':
	$include_start = microtime();
	require_once CLASSES_DIR . 'activity.class.php';
	require_once CLASSES_DIR . 'activityParse.class.php';
	$include_stop = microtime();

	$following_start = microtime();
	$activityParse = new ActivityParse();
	$activityParse->setLimit(4);
	$activityParse->whereEqualTo('type', 'FOLLOWING');
	$activityParse->wherePointer('fromUser', '_User', $id);
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
	echo '<br />[followingCounter] => ' . $user->getFollowingCounter() . '<br />';
	$following_stop = microtime();

	$friendship_start = microtime();
	$activityParse1 = new ActivityParse();
	$activityParse1->setLimit(4);
	$activityParse->wherePointer('fromUser', '_User', $id);
	$activityParse1->whereEqualTo('type', 'FRIENDSHIP');
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
	//echo '<br />[frindshipCounter] => ' . $user->getFriendshipCounter(). '<br />';
	$friendship_stop = microtime();
	echo '<br />----------------------SPOTTER---------------------------<br />';
	break;
    case 'VENUE':
	$include_start = microtime();
	require_once CLASSES_DIR . 'event.class.php';
	require_once CLASSES_DIR . 'eventParse.class.php';
	$include_stop = microtime();

	echo '<br />[localType] => ' . $user->getlocalType() . '<br />';
	$eventVenue_start = microtime();
	$eventParse = new EventParse();
	$eventParse->setLimit(4);
	$eventParse->wherePointer('fromUser', '_User', $id);
	$eventParse->orderByDescending('createdAt');
	$events = $eventParse->getEvents();
	if ($events != 0) {
	    if (get_class($events) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
	    } else {
		foreach ($events as $event) {
		    echo '<br />[title] => ' . $event->getTitle() . '<br />';
		    echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
		    echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
		    echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
		    echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
		    echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
		    $geopoint = $event->getLocation();
		    $string = '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
		    echo $string;
		    if ($event->getFeaturing() != 0) {
			echo '<br />----------------------!=0---------------------------<br />';
			foreach ($event->getFeaturing() as $user) {
			    $userParse = new UserParse();
			    $feat = $userParse->getUser($user);
			    echo '<br />[feat] => ' . $feat->getUsername() . '<br />';
			}
		    }
		}
	    }
	}
	$eventVenue_stop = microtime();
	echo '<br />----------------------VENUE---------------------------<br />';
	break;
    case 'JAMMER':
	$include_start = microtime();
	require_once CLASSES_DIR . 'event.class.php';
	require_once CLASSES_DIR . 'eventParse.class.php';
	require_once CLASSES_DIR . 'record.class.php';
	require_once CLASSES_DIR . 'recordParse.class.php';
	$include_stop = microtime();

	echo '<br />[followersCounter] => ' . $user->getFollowersCounter() . '<br />'; //BOX 4
	$musicGenres = $user->getMusic();
	if (empty($musicGenres) != true) {
	    foreach ($musicGenres as $genre) {
		echo '<br />[genre] => ' . $genre . '<br />';
	    }
	}

	$record_start = microtime();
	$record = new RecordParse();
	$record->wherePointer('fromUser', '_User', $id);
	$record->setLimit(4);
	$record->orderByDescending('createdAt');
	$resGets = $record->getRecords();
	if ($resGets != 0) {
	    if (get_class($resGets) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
	    } else {
		foreach ($resGets as $record) {
		    echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
		    echo '<br />[title] => ' . $record->getTitle() . '<br />';
		    echo '<br />[loveCounter] => ' . $record->getLoveCounter() . '<br />';
		    echo '<br />[commentCounter] => ' . $record->getCommentCounter() . '<br />';
		    echo '<br />[shareCounter] => ' . $record->getShareCounter() . '<br />';
		    echo '<br />[year] => ' . $record->getYear() . '<br />';
		    echo '<br />[songCounter] => ' . $record->getSongCounter() . '<br />';
		}
	    }
	}
	$record_stop = microtime();
	$eventJammer_start = microtime();
	$eventParse = new EventParse();
	$eventParse->setLimit(4);
	$eventParse->wherePointer('fromUser', '_User', $id);
	$eventParse->orderByDescending('createdAt');
	$events = $eventParse->getEvents();
	if ($events != 0) {
	    if (get_class($events) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
	    } else {
		foreach ($events as $event) {
		    echo '<br />[title] => ' . $event->getTitle() . '<br />';
		    echo '<br />[eventDate] => ' . $event->getEventDate()->format('d-m-Y H:i:s') . '<br />';
		    echo '<br />[locationName] => ' . $event->getLocationName() . '<br />';
		    echo '<br />[loveCounter] => ' . $event->getLoveCounter() . '<br />';
		    echo '<br />[commentCounter] => ' . $event->getCommentCounter() . '<br />';
		    echo '<br />[shareCounter] => ' . $event->getShareCounter() . '<br />';
		    if ($event->getFeaturing() != 0) {
			echo '<br />----------------------!=0---------------------------<br />';
			foreach ($event->getFeaturing() as $user) {
			    $userParse = new UserParse();
			    $feat = $userParse->getUser($user);
			    echo '<br />[feat] => ' . $feat->getUsername() . '<br />';
			}
		    }
		}
	    }
	}
	$eventJammer_stop = microtime();

	echo '<br />----------------------JAMMER---------------------------<br />';
	break;
    default:
	break;
}
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero User proprietario pagina ' . executionTime($user_start, $user_stop) . '<br />';
echo 'Tempo include specifico ' . executionTime($include_start, $include_stop) . '<br />';
echo 'Tempo ultimi 4 album ' . executionTime($album_start, $album_stop) . '<br />';
echo 'Tempo ultimi 3 post ' . executionTime($post_start, $post_stop) . '<br />';
switch ($type) {
    case 'SPOTTER':
	echo '<br />----------------------SPOTTER---------------------------<br />';
	echo 'Tempo ultimi 4 following ' . executionTime($following_start, $following_stop) . '<br />';
	echo 'Tempo ultimi 4 friends ' . executionTime($friendship_start, $friendship_stop) . '<br />';
	break;
    case 'VENUE':
	echo '<br />----------------------VENUE---------------------------<br />';
	echo 'Tempo ultimi 4 eventi ' . executionTime($eventVenue_start, $eventVenue_stop) . '<br />';
	break;
    case 'JAMMER':
	echo '<br />----------------------JAMMER---------------------------<br />';
	echo 'Tempo ultimi 4 record ' . executionTime($record_start, $record_stop) . '<br />';
	echo 'Tempo ultimi 4 eventi ' . executionTime($eventJammer_start, $eventJammer_stop) . '<br />';
	break;
    default:
	break;
}
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>
