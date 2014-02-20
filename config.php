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
 *  \todo       keep this file up to date
 */

require_once 'path.php';

/** \def MANTAINANCE_MODE('MANTAINANCE_MODE', 0)
 *  Define the Maintenance Mode state
 */
define('MANTAINANCE_MODE', 0);

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

/** \def 'BADGE0', BADGE_DIR . 'badgeDefault.png'
 *  white badge
 */
define('BADGE0', BADGE_DIR . 'badgeDefault.png');

/** \def 'BADGE1', BADGE_DIR . 'badgeOldSchool.png'
 *  OLD SCHOOL badge
 */
define('BADGE1', BADGE_DIR . 'badgeOldSchool.png');

/** \def 'BADGE2', BADGE_DIR . 'badgeWelcome.png'
 *  WELCOME badge
 */
define('BADGE2', BADGE_DIR . 'badgeWelcome.png');

/** \def 'BADGE3', BADGE_DIR . 'badgePub.png'
 *  PUB badge
 */
define('BADGE3', BADGE_DIR . 'badgePub.png');

/** \def 'BADGE4', BADGE_DIR . 'badgeNightLife.png'
 *  NIGHTLIFE badge
 */
define('BADGE4', BADGE_DIR . 'badgeNightLife.png');

/** \def 'BADGE5', BADGE_DIR . 'badgeLive.png'
 *  LIVE badge
 */
define('BADGE5', BADGE_DIR . 'badgeLive.png');

/** \def 'BADGE6', BADGE_DIR . 'badgeRock.png'
 *  ROCK badge
 */
define('BADGE6', BADGE_DIR . 'badgeRock.png');

/** \def 'BADGE7', BADGE_DIR . 'badgeJamSession.png'
 *  JAMSESSION badge
 */
define('BADGE7', BADGE_DIR . 'badgeJamSession.png');

/** \def 'BADGE8', BADGE_DIR . 'badgeJammedIn.png'
 *  JAMMEDIN badge
 */
define('BADGE8', BADGE_DIR . 'badgeJammedIn.png');

/** \def 'BADGE9', BADGE_DIR . 'badgeHappyHour.png'
 *  HAPPYHOUR badge
 */
define('BADGE9', BADGE_DIR . 'badgeHappyHour.png');

/** \def 'BADGE10', BADGE_DIR . 'badgeProducer.png'
 *  PRODUCER badge
 */
define('BADGE10', BADGE_DIR . 'badgeProducer.png');

/** \def 'BADGE11', BADGE_DIR . 'badgeDj.png'
 *  DJ badge
 */
define('BADGE11', BADGE_DIR . 'badgeDj.png');

/** \def 'BADGE12', BADGE_DIR . 'badgeDinner.png'
 *  DINER badge
 */
define('BADGE12', BADGE_DIR . 'badgeDinner.png');

/** \def 'BADGE13', BADGE_DIR . 'badgeContest.png'
 *  CONTEST badge
 */
define('BADGE13', BADGE_DIR . 'badgeContest.png');

/** \def 'BADGE14', BADGE_DIR . 'badgeDance.png'
 *  DANCE badge
 */
define('BADGE14', BADGE_DIR . 'badgeDance.png');

/** \def 'BADGE15', BADGE_DIR . 'badgeElectro.png'
 *  ELECTRO badge
 */
define('BADGE15', BADGE_DIR . 'badgeElectro.png');

/** \def  'BADGE16', BADGE_DIR . 'badgePop.png'
 *  POP badge
 */
define('BADGE16', BADGE_DIR . 'badgePop.png');

/** \def  'BADGE17', BADGE_DIR . 'badgeMetal.png'
 *  METAL badge
 */
define('BADGE17', BADGE_DIR . 'badgeMetal.png');

/** \def  'BADGE18', BADGE_DIR . 'badgeJazz.png'
 *  JAZZ badge
 */
define('BADGE18', BADGE_DIR . 'badgeJazz.png');

/** \def  'BADGE19', BADGE_DIR . 'badgeInDemand.png'
 *  INDEMAND badge
 */
define('BADGE19', BADGE_DIR . 'badgeInDemand.png');

/** \def  'BADGE20', BADGE_DIR . 'badgeTeamUp.png'
 *  TEAMUP badge
 */
define('BADGE20', BADGE_DIR . 'badgeTeamUp.png');

/** \def  'BADGE21', BADGE_DIR . 'badgePhotographer.png'
 *  PHOTOGRAPHER badge
 */
define('BADGE21', BADGE_DIR . 'badgePhotographer.png');

/** \def  'BADGE22', BADGE_DIR . 'badgePr.png'
 *  PR badge
 */
define('BADGE22', BADGE_DIR . 'badgePr.png');

/** \def  'BADGE23', BADGE_DIR . 'badgeJournalist.png'
 *  JOURNALIST badge
 */
define('BADGE23', BADGE_DIR . 'badgeJournalist.png');

/** \def  'MAX', 1000
 *  MAX Query limit 
 */
define('MAX', 1000);

/** \def  'MIN', 1000
 *  MIN Query limit 
 */
define('MIN', 1);

/** \def  'DEFAULTQUERY', 1000
 *  DEAFULT Query limit 
 */
define('DEFAULTQUERY', 100);

/** \def  'PLAYLISTLIMIT', 20
 *  Playlist limit for standard users 
 */
define('PLAYLISTLIMIT', 20);

/** \def  'LOCATIONNOTFOUND', 'Location Not Found'
 *  Error String for Location
 */
define('LOCATIONNOTFOUND', 'Location Not Found');

/** \def  'ONLYIFLOGGEDIN', 'Just for logged Users'
 *  Error String for unlogged users
 */
define('ONLYIFLOGGEDIN', 'Just for logged Users');

/** \def  'PROFILE_IMG_SIZE', 300
 *  Image size width
 */
define('PROFILE_IMG_SIZE', 300);

/** \def  'THUMBNAIL_IMG_SIZE', 150
 *  Thumbnail size width
 */
define('THUMBNAIL_IMG_SIZE', 150);

/** \def  'MAX_IMG_UPLOAD_FILE_SIZE', 6291456
 *  Max Image size 
 */
define('MAX_IMG_UPLOAD_FILE_SIZE', 6291456); //6 Mb

/** \def  'MAX_MP3_UPLOAD_FILE_SIZE', 12582912
 *  Max MP3 size 
 */
define('MAX_MP3_UPLOAD_FILE_SIZE', 12582912); //12 Mb

/** \def  'FACEBOOK', 'https://www.facebook.com/Jamyourselfcom'
 * Facebook Address
 */
define('FACEBOOK', 'https://www.facebook.com/Jamyourselfcom');

/** \def  'TWITTER', 'https://twitter.com/Jamyourself'
 * TWITTER Address
 */
define('TWITTER', 'https://twitter.com/Jamyourself');

/** \def  'BLOG', 'http://blog.jamyourself.com/'
 * BLOG Address
 */
define('BLOG', 'http://blog.jamyourself.com/');

/** \def  'DEF_PLAY', 'Playslist'
 * Deafult Name for playlist
 */
define('DEF_PLAY', 'Playslist');

/** \def  'DEF_REC', 'Default Record'
 * Deafult Name for record
 */
define('DEF_REC', 'Default Record');

/** \def  'DEF_ALBUM', 'Default Album'
 * Deafult Name for album
 */
define('DEF_ALBUM', 'Default Album');

/** \def  'SUB_SBJ', 'SUBSCRIBE NUOVO UTENTE'
 * Deafult Subscribe string
 */
define('SUB_SBJ', 'SUBSCRIBE NUOVO UTENTE');

/** \def  'SUB_ADD', 'subscribe@jamyourself.com'
 * Deafult Subscribe address
 */
define('SUB_ADD', 'subscribe@jamyourself.com');

/** \def  'DEBUG', true
 * LOG LEVEL
 */
define('DEBUG', true);
?>