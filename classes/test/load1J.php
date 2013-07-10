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
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';

$id = '7fes1RyY77';
echo '<br />----------------------BOX------------INFORMATIONS-------------------------------------<br />';
$userParse = new UserParse();
$user = $userParse->getUser($id);
echo '<br />[username] => ' . $user->getUsername() . '<br />';//BOX 5
echo '<br />[backGround] => ' . $user->getBackGround() . '<br />';//BOX 5
echo '<br />[profilePicture] => ' . $user->getProfilePicture() . '<br />';//BOX 5
echo '<br />[username] => ' . $user->getUsername() . '<br />';
echo '<br />[description] => ' . $user->getDescription() . '<br />';
$musicGenres = $user->getMusic();
foreach ($musicGenres as $genre) {
	   echo '<br />[genre] => ' . $genre . '<br />'; 
}
echo '<br />[city] => ' . $user->getCity() . '<br />';
echo '<br />[country] => ' . $user->getCountry() . '<br />';
echo '<br />[faceBook Page] => ' . $user->getFbPage() . '<br />';
echo '<br />[Twitter Page] => ' . $user->getTwitterPage() . '<br />';
echo '<br />[WebSite Page] => ' . $user->getWebsite() . '<br />';
echo '<br />[Youtube Channel] => ' . $user->getYoutubeChannel() . '<br />';
echo '<br />[punteggio] => ' . $user->getLevel() . '<br />';//BOX 4 
#echo '<br />[followersCounter] => ' . $user->getFollowersCounter() . '<br />';//BOX 4
echo '<br />----------------FINE------BOX------------INFORMATIONS---------------------------------<br />';
echo '<br />----------------------BOX------------RECORD---------------------------<br />';
$record = new RecordParse();
$record->wherePointer('fromUser', '_User', $id);
$record->setLimit(4);
$record->orderByDescending('updatedAt');
$resGets0 = $record->getRecords();
if ($resGets0 != 0) {
    if (get_class($resGets0) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets0->getErrorMessage() . '<br/>';
    } else {
	foreach ($resGets0 as $record) {
            echo '<br />[thumbnailCover] => ' . $record->getThumbnailCover() . '<br />';
	    echo '<br />[title] => ' . $record->getTitle() . '<br />';
	    echo '<br />[loveCounter] => ' . $record->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $record->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $record->getShareCounter() . '<br />';
	    echo '<br />[year] => ' . $record->getYear() . '<br />';
	}
    }
}
echo '<br />----------------FINE------BOX------------RECORD---------------------------------<br />';
echo '<br />----------------------BOX------------ALBUM------FOTO---------------------------<br />';
$album = new AlbumParse();
$album->wherePointer('fromUser', '_User', $id);
$album->setLimit(4);
$album->orderByDescending('createdAt');
$resGets = $album->getAlbums();
if ($resGets != 0) {
    if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
    } else {
	foreach ($resGets as $album) {
            echo '<br />[thumbnailCover] => ' . $album->getThumbnailCover() . '<br />';
	    echo '<br />[title] => ' . $album->getTitle() . '<br />';
	    echo '<br />[loveCounter] => ' . $album->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $album->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $album->getShareCounter() . '<br />';
	}
    }
}
echo '<br />----------------FINE------BOX------------FOTO---------------------------------<br />';
echo '<br />----------------------BOX------------EVENT-------------------------------------<br />';
$eventParse = new EventParse();
$eventParse->wherePointer('fromUser', '_User', $id);
$eventParse->orderByDescending('createdAt');
$eventParse->setLimit(4);
$resGets1 = $eventParse->getEvents();
if ($resGets1 != 0) {
    if (get_class($resGets1) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
    } else {
	foreach ($resGets1 as $event) {
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
echo '<br />----------------------BOX------------POST---------------------------<br />';
$parsePost = new CommentParse();
$parsePost->wherePointer('fromUser', '_User', $id);
$parsePost->where('type', 'P');
$parsePost->setLimit(3);
$parsePost->orderByDescending('createdAt');
$last3post =$parsePost->getComments();
foreach ($last3post as $post) {
    $user = new UserParse();
    $userStamp = $user->getUser($post->getFromUser());
    echo '<br />[username] => ' . $userStamp->getUsername() . '<br />';
    echo '<br />[type] => ' . $userStamp->getType() . '<br />';
    echo '<br />[thumb] => ' . $userStamp->getProfileThumbnail() . '<br />';
    echo '<br />[testo] => ' . $post->getText() . '<br />';
    echo '<br />[data creazione] => ' . $post->getCreatedAt() . '<br />';
    echo '<br />[loveCounter] => ' . $post->getLoveCounter() . '<br />';
    echo '<br />[shareCounter] => ' . $post->getShareCounter() . '<br />';
    echo '<br />[commentCounter] => ' . $post->getCommentCounter() . '<br />';   
}
echo '<br />----------------------BOX------------POST---------------------------<br />';
?>