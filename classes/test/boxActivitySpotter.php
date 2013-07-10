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
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'event.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'activity.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

$id = '7wi6AvviK4';
echo '<br />----------------------BOX------------ACTIVITY------EVENT---------------------------<br />';
$parseActivity = new ActivityParse();
$parseActivity->wherePointer('fromUser', '_User', $id);
$parseActivity->where('type', 'ATTENDENCECONFIRMED');
$parseActivity->orderByDescending('updatedAt');
$parseActivity->setLimit(1);
$res = $parseActivity->getActivities();
foreach ($res as $pippo) {
    $eventP = new EventParse();
    $event = $pippo->getEvent();
    $eventStamp = $eventP->getEvent($event);
    echo '<br />[titolo Evento] => ' . $eventStamp->getTitle() . '<br />';
    echo '<br />[locationName] => ' . $eventStamp->getLocationName() . '<br />';
    $geopoint = $eventStamp->getLocationName();
    $string = '[location] => ' . $geopoint->location['latitude'] . ', ' . $geopoint->location['longitude'] . '<br />';
    echo $string;
}
echo '<br />---------------FINE-------BOX------------ACTIVITY------EVENT---------------------------<br />';
echo '<br />----------------------BOX------------ACTIVITY------ALBUM---------------------------<br />';
$parseAlbum = new AlbumParse();
$parseAlbum->wherePointer('fromUser', '_User', $id);
$parseAlbum->orderByDescending('updatedAt');
$parseAlbum->setLimit(4);
$res1 = $parseAlbum->getAlbums();
foreach ($res1 as $pippo) {
    echo '<br />[titolo Album] => ' . $pippo->getTitle() . '<br />';
    $images = $pippo->getImages();
    foreach ($images as $image) {
	$imageP = new ImageParse();
	$img = $imageP->getImage($image);
	echo '<br />[titolo record] => ' . $img->getFilePath() . '<br />';
    }  
}
echo '<br />---------------FINE-------BOX------------ACTIVITY------ALBUM---------------------------<br />';

?>
