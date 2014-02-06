<?php

/* ! \par Info  Generali:
 *  \author     Luca Gianneschi
 *  \version    1.0
 *  \date       2013
 *  \copyright  Jamyourself.com 2013
 *  \par        Info:
 *  \brief      basic config file 
 *  \warning
 *  \bug
 *  \todo       keep the file update
 */

require_once 'path.php';

/** \def MANTAINANCE_MODE('MANTAINANCE_MODE', 0)
 *  Define the Maintenance Mode state
 */
#def
define('MANTAINANCE_MODE', 0);

/** \def ('SERVER_NAME', 'www.jamyourself.com')
 *  Define the server name for stating URL
 */
define('SERVER_NAME', 'www.jamyourself.com');

/** \def ('BOXES_DIR', ROOT_DIR . 'boxes/')
 *  Define the boxes directory, php files for queries
 */
define('BOXES_DIR', ROOT_DIR . 'boxes/');

/** \def ('CLASSES_DIR', ROOT_DIR . 'classes/')
 *  Define the classes directory, php files for defining the model
 */
define('CLASSES_DIR', ROOT_DIR . 'classes/');

/** \def ('CONFIG_DIR', ROOT_DIR . 'config/')
 *  Define the config directory, json file for configuring the initial stato of controllers and boxes
 */
define('CONFIG_DIR', ROOT_DIR . 'config/');

/** \def ('CONTROLLERS_DIR', ROOT_DIR . 'controllers/')
 *  Define the controllers directory, php files for actions
 */
define('CONTROLLERS_DIR', ROOT_DIR . 'controllers/');

/** \def ('DEBUG_DIR', ROOT_DIR . 'debug/'
 *  Define the debug directory, output for debug operation
 */
define('DEBUG_DIR', ROOT_DIR . 'debug/');

/** \def ('LANGUAGES_DIR', ROOT_DIR . 'languages/'))
 *  Define the languages directory, for translating php files
 */
define('LANGUAGES_DIR', ROOT_DIR . 'languages/');

/** \def ('PARSE_DIR', ROOT_DIR . 'parse/')
 *  Define the parse libraty directory
 */
define('PARSE_DIR', ROOT_DIR . 'parse/');

/** \def ('SERVICES_DIR', ROOT_DIR . 'services/');
 *  Define the services directory, php files for cleaner code
 */
define('SERVICES_DIR', ROOT_DIR . 'services/');

/** \def ('STDHTML_DIR', SERVICES_DIR . 'mail/standardHTML/');
 *  Define the standard HTML files directory, HTML files to be sent to users
 */
define('STDHTML_DIR', SERVICES_DIR . 'mail/standardHTML/');

/** \def 'TESTS_DIR', ROOT_DIR . 'tests/'
 *  Define the test directory
 */
define('TESTS_DIR', ROOT_DIR . 'tests/');

/** \def ('VIEWS_DIR', ROOT_DIR . 'views/')
 *  Define the views directory, php files, everything to be seen by the user
 */
define('VIEWS_DIR', ROOT_DIR . 'views/');

/** \def ('CACHE_DIR', ROOT_DIR . 'cache/')
 *  Define the cache directory, where files are cached before moving them to the right folder
 */
define('CACHE_DIR', ROOT_DIR . 'cache/');

/** \def ('USERS_DIR', ROOT_DIR . 'users/')
 *  Define the users directory, each user has his own folder to sotre his own files
 */
define('USERS_DIR', ROOT_DIR . 'users/');

/** \def ('DEF_IMAGES_DIR', ROOT_DIR . 'views/resources/images/default/')
 *  Define the default image directory
 */
define('DEF_IMAGES_DIR', ROOT_DIR . 'views/resources/images/default/');

/** \def ('DEFBGD', DEF_IMAGES_DIR . 'defaultBackground.jpg')
 *  Define the default background image
 */
define('DEFBGD', DEF_IMAGES_DIR . 'defaultBackground.jpg');

/** \def ('DEFAVATARJAMMER', DEF_IMAGES_DIR . 'defaultAvatarJammer.jpg')
 *  Define the default avatar for JAMMER
 */
define('DEFAVATARJAMMER', DEF_IMAGES_DIR . 'defaultAvatarJammer.jpg');

/** \def ('DEFTHUMBJAMMER', DEF_IMAGES_DIR . 'defaultAvatarThumbJammer.jpg')
 *  Define the default avatar thumb for JAMMER
 */
define('DEFTHUMBJAMMER', DEF_IMAGES_DIR . 'defaultAvatarThumbJammer.jpg');

/** \def ('DEFAVATARVENUE', DEF_IMAGES_DIR . 'defaultAvatarVenue.jpg'
 *  Define the default avatar for VENUE
 */
define('DEFAVATARVENUE', DEF_IMAGES_DIR . 'defaultAvatarVenue.jpg');

/** \def ('DEFTHUMBVENUE', DEF_IMAGES_DIR . 'defaultAvatarThumbVenue.jpg')
 *  Define the default avatar thumb for JAMMER
 */
define('DEFTHUMBVENUE', DEF_IMAGES_DIR . 'defaultAvatarThumbVenue.jpg');

/** \def ('DEFAVATARSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarSpotter.jpg')
 *  Define the default avatar for SPOTTER
 */
define('DEFAVATARSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarSpotter.jpg');

/** \def ('DEFTHUMBSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarThumbSpotter.jpg')
 *  Define the default avatar thumb for SPOTTER
 */
define('DEFTHUMBSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarThumbSpotter.jpg');

/** \def ('DEFALBUMCOVER', DEF_IMAGES_DIR . 'defaultAlbumCover.jpg')
 *  Define the default cover for Album
 */
define('DEFALBUMCOVER', DEF_IMAGES_DIR . 'defaultAlbumCover.jpg');

/** \def ('DEFALBUMCOVER', DEF_IMAGES_DIR . 'defaultAlbumCover.jpg')
 *  Define the default cover thumb for Album
 */
define('DEFALBUMTHUMB', DEF_IMAGES_DIR . 'defaultAlbumThumb.jpg');

/** \def ('DEFEVENTTHUMB', DEF_IMAGES_DIR . 'defaultEventThumb.jpg')
 *  Define the default cover thumb for Event
 */
define('DEFEVENTTHUMB', DEF_IMAGES_DIR . 'defaultEventThumb.jpg');

/** \def ('DEFEVENTIMAGE', DEF_IMAGES_DIR . 'defaultEventImage.jpg')
 *  Define the default cover for Event
 */
define('DEFEVENTIMAGE', DEF_IMAGES_DIR . 'defaultEventImage.jpg');

/** \def ('DEFRECORDCOVER', DEF_IMAGES_DIR . 'defaultRecordCover.jpg')
 *  Define the default cover for Record
 */
define('DEFRECORDCOVER', DEF_IMAGES_DIR . 'defaultRecordCover.jpg');

/** \def ('DEFRECORDTHUMB', DEF_IMAGES_DIR . 'defaultRecordThumb.jpg');
 *  Define the default cover thumb for Record
 */
define('DEFRECORDTHUMB', DEF_IMAGES_DIR . 'defaultRecordThumb.jpg');

/** \def 'DEFSONGTHUMB', DEF_IMAGES_DIR . 'defaultSongThumb.jpg'
 *  Define the default cover thumb for Song
 */
define('DEFSONGTHUMB', DEF_IMAGES_DIR . 'defaultSongThumb.jpg');

/** \def 'DEFIMAGE', DEF_IMAGES_DIR . 'defaultImage.jpg'
 *  Define the default iamge for Image
 */
define('DEFIMAGE', DEF_IMAGES_DIR . 'defaultImage.jpg');

/** \def 'DEFIMAGETHUMB', DEF_IMAGES_DIR . 'defaultImageThumb.jpg'
 *  Define the default thumb for image
 */
define('DEFIMAGETHUMB', DEF_IMAGES_DIR . 'defaultImageThumb.jpg');

/** \def 'DEFVIDEOTHUMB', DEF_IMAGES_DIR . 'defaultVideoThumb.jpg'
 *  Define the default thumb for Video
 */
define('DEFVIDEOTHUMB', DEF_IMAGES_DIR . 'defaultVideoThumb.jpg');

/** \def 'BADGE_DIR', ROOT_DIR . 'views/resources/images/badge/'
 *  Define the default directory for BAGDGE images
 */
define('BADGE_DIR', ROOT_DIR . 'views/resources/images/badge/');

define('BADGE0', BADGE_DIR . 'badgeDefault.png');
define('BADGE1', BADGE_DIR . 'badgeOldSchool.png');
define('BADGE2', BADGE_DIR . 'badgeWelcome.png');
define('BADGE3', BADGE_DIR . 'badgePub.png');
define('BADGE4', BADGE_DIR . 'badgeNightLife.png');
define('BADGE5', BADGE_DIR . 'badgeLive.png');
define('BADGE6', BADGE_DIR . 'badgeRock.png');
define('BADGE7', BADGE_DIR . 'badgeJamSession.png');
define('BADGE8', BADGE_DIR . 'badgeJammedIn.png');
define('BADGE9', BADGE_DIR . 'badgeHappyHour.png');
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

//STRINGHE TITOLI PAGINA
define('HOME_TITLE', 'Jamyourself: Meritocratic Social Music Discovering');

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
define('MAX_MP3_UPLOAD_FILE_SIZE', 12582912); //12 Mb
#########################
# SOCIAL NETWORK  & BLOG#
#########################
define('FACEBOOK', 'https://www.facebook.com/Jamyourselfcom');
define('TWITTER', 'https://twitter.com/Jamyourself');
define('BLOG', 'http://blog.jamyourself.com/');

################
# DEFAULT NAMES#
################
define('DEF_PLAY', 'Playslist');
define('DEF_REC', 'Default Record');
define('DEF_ALBUM', 'Default Album');
define('SUB_SBJ', 'SUBSCRIBE NUOVO UTENTE');
define('SUB_ADD', 'subscribe@jamyourself.com');

##################
#  LOG LEVEL     #
##################

define('DEBUG', true);
?>