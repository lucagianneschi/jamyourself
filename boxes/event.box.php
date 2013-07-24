<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		sistemare il campo featuring	
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

class eventBox {

    public function sendInfo($objectId) {
	$resultArray = array();
	$eventParse = new EventParse();
	$eventParse->wherePointer('fromUser', '_User', $objectId);
	$eventParse->where('active', true);
	$eventParse->setLimit(1000);
	$eventParse->orderByDescending('createdAt');
	$events = $eventParse->getEvents();
	if (count($events) != 0) {
	    if (get_class($events) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
	    } else {
		foreach ($events as $event) {
		    $thumbnail = $event->getThumbnail();
		    $locationName = $event->getLocationName();
		    $title = $event->getTitle();
		    $eventDate = $event->getEventDate()->format('d-m-Y H:i:s');
		    $city = $event->getCity();
		    $address = $event->getAddress();
		    $loveCounter = $event->getLoveCounter();
		    $commentCounter = $event->getCommentCounter();
		    $shareCounter = $event->getShareCounter();
		    $reviewCounter = $event->getReviewCounter();
		    $tags = array();
		    if ($event->getTags() != 0) {
			foreach ($event->getTags() as $tag) {
			    array_push($tags, $tag);
			}
		    }

		    $feats = array();
		    $parseUser = new UserParse();
		    $parseUser->whereRelatedTo('featuring', 'Event', $objectId);
		    $parseUser->where('active', true);
		    $parseUser->setLimit(1000);
		    $featuring = $parseUser->getUsers();
		    if (count($featuring) != 0) {
			foreach ($featuring as $user) {
			    $username = $user->getUsername();
			    array_push($feats, $username);
			}
		    }
		    $eventInfo = array('thumbnail' => $thumbnail,
			'locationName' => $locationName,
			'title' => $title,
			'eventDate' => $eventDate,
			'city' => $city,
			'address' => $address,
			'loveCounter' => $loveCounter,
			'commentCounter' => $commentCounter,
			'shareCounter' => $shareCounter,
			'reviewCounter' => $reviewCounter,
			'tags' => $tags,
			'featuring' => $feats);
		    array_push($resultArray, $eventInfo);
		}
	    }
	}
	return $resultArray;
    }
}

?>
