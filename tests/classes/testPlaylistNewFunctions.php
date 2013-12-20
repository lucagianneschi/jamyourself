<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';


echo 'TEST ADD<br />';

$playlistParse1 = new PlaylistParse();
echo $playlistParse1->addOjectIdToArray('EWlkBSXQJt', 'songsArray', 'MSJfcWb9Qk', false, 20);
//echo $playlistParse1->addSongIdFromSongsArray('EWlkBSXQJt', 'songsArray', 'MSJfcWb9Qk', false, 20);
//echo $playlistParse1->addSongIdFromSongsArray('EWlkBSXQJt', 'ciao', 'MSJfcWb9Qk', false, 20);
//echo $playlistParse1->addSongIdFromSongsArray('EWlkBSXQJt', 'songsArray', 'MSJfcWb9Qk', false, 20);
//echo 'TEST ADD ERRORE OBJECT ID NULL<br />';
//echo $playlistParse1->addSongIdFromSongsArray(null, 'songsArray', 'MSJfcWb9Qk', false, 20);
//echo 'TEST ADD ERRORE FIELD NULL ID NULL<br />';
//echo $playlistParse1->addSongIdFromSongsArray('EWlkBSXQJt', null, 'MSJfcWb9Qk', false, 20);
//echo 'TEST ADD ERRORE VALUE NULL ID NULL<br />';
//echo $playlistParse1->addSongIdFromSongsArray('EWlkBSXQJt', 'songsArray', null, false, 20);
//echo 'TEST ADD ERRORE PLAYLIST NON TROVATA ID NULL<br />';
//echo $playlistParse1->addSongIdFromSongsArray('pippo', 'songsArray', null, false, 20);

echo 'TEST REMOVE<br />';
echo $playlistParse1->removeObjectIdFromArray('EWlkBSXQJt', 'songsArray', 'MSJfcWb9Qk');
?>