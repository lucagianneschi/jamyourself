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
define('DEF_IMAGES_DIR', ROOT_DIR . 'views/resources/images/default/');

#################
# DEFAULT IMAGEs #
#################
//USER
define('DEFBGD', DEF_IMAGES_DIR . 'defaultBackground.jpg');
define('DEFAVATARJAMMER', DEF_IMAGES_DIR . 'defaultAvatarJammer.jpg');
define('DEFTHUMBJAMMER', DEF_IMAGES_DIR . 'defaultAvatarThumbJammer.jpg');
define('DEFAVATARVENUE', DEF_IMAGES_DIR . 'defaultAvatarVenue.jpg');
define('DEFTHUMBVENUE', DEF_IMAGES_DIR . 'defaultAvatarThumbVenue.jpg');
define('DEFAVATARSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarSpotter.jpg');
define('DEFTHUMBSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarThumbSpotter.jpg');
//ALBUM
define('DEFALBUMCOVER', DEF_IMAGES_DIR . 'defaultAlbumCover.jpg');
define('DEFALBUMTHUMB', DEF_IMAGES_DIR . 'defaultAlbumThumb.jpg');
//EVENT
define('DEFEVENTTHUMB', DEF_IMAGES_DIR . 'defaultEventThumb.jpg');
define('DEFEVENTIMAGE', DEF_IMAGES_DIR . 'defaultEventImage.jpg');
//RECORD
define('DEFRECORDCOVER', DEF_IMAGES_DIR . 'defaultRecordCover.jpg');
define('DEFRECORDTHUMB', DEF_IMAGES_DIR . 'defaultRecordThumb.jpg');
//SONG
define('DEFSONGTHUMB', DEF_IMAGES_DIR . 'defaultSongThumb.jpg');
//IMAGE 
define('DEFIMAGE', DEF_IMAGES_DIR . 'defaultImage.jpg');
define('DEFIMAGETHUMB', DEF_IMAGES_DIR . 'defaultImageThumb.jpg');
//VIDEO
define('DEFVIDEOTHUMB', DEF_IMAGES_DIR . 'defaultVideoThumb.jpg');
//BADGE
define('BADGE_DIR', ROOT_DIR . 'views/resources/images/badge/');
define('BADGE0',  BADGE_DIR . 'badgeDefault.png');
define('BADGE1',  BADGE_DIR . 'badgeOldSchool.png');
define('BADGE2',  BADGE_DIR . 'badgeWelcome.png');
define('BADGE3',  BADGE_DIR . 'badgePub.png');
define('BADGE4',  BADGE_DIR . 'badgeNightLife.png');
define('BADGE5',  BADGE_DIR . 'badgeLive.png');
define('BADGE6',  BADGE_DIR . 'badgeRock.png');
define('BADGE7',  BADGE_DIR . 'badgeJamSession.png');
define('BADGE8',  BADGE_DIR . 'badgeJammedIn.png');
define('BADGE9',  BADGE_DIR . 'badgeHappyHour.png');
define('BADGE10', BADGE_DIR . 'badgeProducer.png');
define('BADGE11', BADGE_DIR . 'badgeDj.png');
define('BADGE12', BADGE_DIR . 'badgeDinner.png');
define('BADGE13', BADGE_DIR . 'badgeContest.png');
define('BADGE14', BADGE_DIR . 'badgeDance.png');
define('BADGE15', BADGE_DIR . 'badgeElectro.png');
define('BADGE16', BADGE_DIR . 'badgePop.png');
define('BADGE17', BADGE_DIR . 'badgeMetal.png');
define('BADGE18', BADGE_DIR . 'badgeJazz.png');
define('BADGE19', BADGE_DIR . 'badgeInDemand.png');
define('BADGE20', BADGE_DIR . 'badgeTeamUp.png');
define('BADGE21', BADGE_DIR . 'badgePhotographer.png');
define('BADGE22', BADGE_DIR . 'badgePr.png');
define('BADGE23', BADGE_DIR . 'badgeJournalist.png');

##################
#  QUERY LIMITS  #
##################
define('MAX', 1000);
define('MIN', 1);
define('DEFAULTQUERY', 100);
define('PLAYLISTLIMIT', 20);

//STRINGHE DI ERRORE
define('LOCATIONNOTFOUND', 'Location Not Found');
define('ONLYIFLOGGEDIN', 'Just for logged Users');
##################
#  CROP SIZES    #
##################

define('PROFILE_IMG_SIZE', 300);
define('THUMBNAIL_IMG_SIZE', 150);

##################
#  FILES SIZES   #
##################

define('MAX_IMG_UPLOAD_FILE_SIZE', 6291456); //6 Mb
define('MAX_MP3_UPLOAD_FILE_SIZE', 12582912);//12 Mb

##################
#  LOG LEVEL     #
##################

define('DEBUG', true);

?>