<?php

require_once 'path.php';

##################
# GENERIC FOLDER #
##################
define('BOXES_DIR', ROOT_DIR . 'boxes/');
define('CLASSES_DIR', ROOT_DIR . 'classes/');
define('CONFIG_DIR', ROOT_DIR . 'config/');
define('CONTROLLERS_DIR', ROOT_DIR . 'controllers/');
define('DEBUG_DIR', ROOT_DIR . 'debug/');
define('LANGUAGES_DIR', ROOT_DIR . 'languages/'); 
define('MEDIA_DIR', ROOT_DIR . 'media/');
define('PARSE_DIR', ROOT_DIR . 'parse/');
define('SERVICES_DIR', ROOT_DIR . 'services/');
define('STDHTML_DIR', SERVICES_DIR . 'mail/standardHTML/');
define('TESTS_DIR', ROOT_DIR . 'tests/');
define('VIEWS_DIR', ROOT_DIR . 'views/');
define('USERS_DIR', ROOT_DIR . 'users/');

################
# MEDIA FOLDER #
################
define('IMAGES_DIR', ROOT_DIR . 'media/images/');
define('SONGS_DIR', ROOT_DIR . 'media/songs/');
 
#################
# DEFAULT IMAGE #
#################
//USER
define('DEFAVATAR', MEDIA_DIR . 'images/default/defaultAvatar.jpg');
define('DEFTHUMB', MEDIA_DIR . 'images/default/defaultAvatarThumb.jpg');
define('DEFBGD', MEDIA_DIR . 'images/default/defaultBackground.jpg');
//ALBUM
define('DEFALBUMCOVER', MEDIA_DIR . 'images/default/defaultAlbumCover.jpg');
define('DEFALBUMTHUMB', MEDIA_DIR . 'images/default/defaultAlbumThumb.jpg');
//EVENT
define('DEFEVENTTHUMB', MEDIA_DIR . 'images/default/defaultEventThumb.jpg');
define('DEFEVENTIMAGE', MEDIA_DIR . 'images/default/defaultEventImage.jpg');
//RECORD
define('DEFRECORDCOVER', MEDIA_DIR . 'images/default/defaultRecordCover.jpg');
define('DEFRECORDTHUMB', MEDIA_DIR . 'images/default/defaultRecordThumb.jpg');
//SONG
define('DEFSONGTHUMB', MEDIA_DIR . 'images/default/defaultSongThumb.jpg');
//IMAGE 
define('DEFIMAGE', MEDIA_DIR . 'images/default/defaultImage.jpg'); 
?>
