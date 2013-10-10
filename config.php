<?php

require_once 'path.php';

//------------- GENERIC FOLDER ----------------------------- 
 define('BOXES_DIR', PROJECTFOLDER.'boxes/');
 define('CLASSES_DIR', PROJECTFOLDER.'classes/');
 define('CONTROLLERS_DIR', PROJECTFOLDER.'controllers/');
 define('LANGUAGES_DIR', PROJECTFOLDER.'languages/'); 
 define('MEDIA_DIR', PROJECTFOLDER.'media/');
 define('PARSE_DIR', PROJECTFOLDER.'parse/');
 define('SERVICES_DIR', PROJECTFOLDER.'services/');
 define('TESTS_DIR', PROJECTFOLDER.'tests/');
 define('VIEWS_DIR', PROJECTFOLDER.'views/');


//------------- MEDIA FOLDER ------------------------------
 define('IMAGES_DIR', PROJECTFOLDER.'media/images/');
 define('SONGS_DIR', PROJECTFOLDER.'media/songs/');
 
//------------- DEFAULT IMAGE -------------------------------------
//USER
define('DEFAVATAR', MEDIA_DIR.'images/default/defaultAvatar.jpg');
define('DEFTHUMB', MEDIA_DIR.'images/default/defaultAvatarThumb.jpg');
define('DEFBGD', MEDIA_DIR.'images/default/defaultBackground.jpg');
//ALBUM
define('DEFALBUMCOVER', MEDIA_DIR.'images/default/defaultAlbumCover.jpg');
define('DEFALBUMTHUMB', MEDIA_DIR.'images/default/defaultAlbumThumb.jpg');
//EVENT
define('DEFEVENTTHUMB', MEDIA_DIR.'images/default/defaultEventThumb.jpg');
define('DEFEVENTIMAGE', MEDIA_DIR.'images/default/defaultEventImage.jpg');
//RECORD
define('DEFRECORDCOVER', MEDIA_DIR.'images/default/defaultRecordCover.jpg');
define('DEFRECORDTHUMB', MEDIA_DIR.'images/default/defaultRecordThumb.jpg');
//SONG
define('DEFSONGTHUMB', MEDIA_DIR.'images/default/defaultSongThumb.jpg');
//IMAGE 
define('DEFIMAGE', MEDIA_DIR.'images/default/defaultImage.jpg'); 



?>