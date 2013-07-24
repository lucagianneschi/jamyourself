<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box informazioni record
 * \details		Recupera le informazioni da mostrare per la pagina del record
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
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$i_end = microtime();


$id = 'b8r9q9b5se';
$record_start = microtime();
$recordP = new RecordParse();
$record = $recordP->getRecord($id);
$record_stop = microtime();

echo '<br />----------------------DX---------------------------<br />';
echo '<br />[title] => ' . $record->getTitle() . '<br />';
echo '<br />[cover] => ' . $record->getCover() . '<br />';
echo '<br />[genre] => ' . $record->getGenre() . '<br />';
echo '<br />[record in year] => ' . $record->getYear() . '<br />';
echo '<br />[description] => ' . $record->getDescription() . '<br />';
echo '<br />[buyLink] => ' . $record->getBuyLink() . '<br />';
echo '<br />[locationName] => ' . $record->getLocationName() . '<br />';
$fromUserP = new UserParse();
$fromUser = $fromUserP->getUser($record->getFromUser());
echo '<br />[username] => ' . $fromUser->getUsername() . '<br />';
echo '<br />[thumbnail] => ' . $fromUser->getProfileThumbnail() . '<br />';
echo '<br />[type] => ' . $fromUser->getProfileThumbnail() . '<br />';


$tracklist = new SongParse();
$tracklist->wherePointer('record', 'Record', $id);
$tracklist->setLimit(50);
$tracklist->where('active', true);
$tracklist->orderByAscending('createdAt');
$songs = $tracklist->getSongs();
echo '<br />[count] => ' . count($songs) . '<br />';
if(count($songs) != 0){
    foreach ($songs as $song){
	echo '<br />[title] => ' . $song->getTitle() . '<br />';
	echo '<br />[duration] => ' . $song->getDuration() . '<br />';
	echo '<br />[loveCounter] => ' . $song->getLoveCounter() . '<br />';
	echo '<br />[shareCounter] => ' . $song->getShareCounter() . '<br />';
    }
}
echo '<br />----------------------DX---------------------------<br />';

echo '<br />----------------------SX---------------------------<br />';
echo '<br />[loveCounter] => ' . $record->getLoveCounter() . '<br />';
echo '<br />[commentCounter] => ' . $record->getCommentCounter() . '<br />';
echo '<br />[shareCounter] => ' . $record->getShareCounter() . '<br />';
echo '<br />----------------------SX---------------------------<br />';

$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero info record ' . executionTime($record_start, $record_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>