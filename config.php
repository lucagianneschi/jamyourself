<?php

/**
 * File di configurazione
 *
 * @author Maria Laura Fresu
 * @author Stefano Muscas
 * @author Luca Gianneschi
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @
 */
require_once 'path.php';

/**
 *  Define the Maintenance Mode state
 */
define('MANTAINANCE_MODE', 0);

/**
 *  Define the boxes directory, php files for queries
 */
define('BOXES_DIR', ROOT_DIR . 'boxes/');

/**
 *  Define the classes directory, php files for defining the model
 */
define('CLASSES_DIR', ROOT_DIR . 'classes/');

/**
 *  Define the config directory, json file for configuring the initial stato of controllers and boxes
 */
define('CONFIG_DIR', ROOT_DIR . 'config/');

/**
 *  Define the controllers directory, php files for actions
 */
define('CONTROLLERS_DIR', ROOT_DIR . 'controllers/');

/**
 *  Define the debug directory, output for debug operation
 */
define('DEBUG_DIR', ROOT_DIR . 'debug/');

/**
 *  Define the languages directory, for translating php files
 */
define('LANGUAGES_DIR', ROOT_DIR . 'languages/');

/**
 *  Define the services directory, php files for cleaner code
 */
define('SERVICES_DIR', ROOT_DIR . 'services/');

/**
 *  Define the standard HTML files directory, HTML files to be sent to users
 */
define('STDHTML_DIR', SERVICES_DIR . 'mail/standardHTML/');

/**
 *  Define the test directory
 */
define('TESTS_DIR', ROOT_DIR . 'tests/');

/**
 *  Define the views directory, php files, everything to be seen by the user
 */
define('VIEWS_DIR', ROOT_DIR . 'views/');

/**
 *  Define the cache directory, where files are cached before moving them to the right folder
 */
define('CACHE_DIR', ROOT_DIR . 'cache/');

/**
 *  Define the users directory, each user has his own folder to sotre his own files
 */
define('USERS_DIR', ROOT_DIR . 'users/');

/**
 *  Define the default image directory
 */
define('DEF_IMAGES_DIR', ROOT_DIR . 'views/resources/images/default/');

/**
 *  Define the default background image
 */
define('DEFBGD', DEF_IMAGES_DIR . 'defaultBackground.jpg');

/**
 *  Define the default avatar for JAMMER
 */
define('DEFAVATARJAMMER', DEF_IMAGES_DIR . 'defaultAvatarJammer.jpg');

/**
 *  Define the default avatar thumb for JAMMER
 */
define('DEFTHUMBJAMMER', DEF_IMAGES_DIR . 'defaultAvatarThumbJammer.jpg');

/**
 *  Define the default avatar for VENUE
 */
define('DEFAVATARVENUE', DEF_IMAGES_DIR . 'defaultAvatarVenue.jpg');

/**
 *  Define the default avatar thumb for JAMMER
 */
define('DEFTHUMBVENUE', DEF_IMAGES_DIR . 'defaultAvatarThumbVenue.jpg');

/**
 *  Define the default avatar for SPOTTER
 */
define('DEFAVATARSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarSpotter.jpg');

/**
 *  Define the default avatar thumb for SPOTTER
 */
define('DEFTHUMBSPOTTER', DEF_IMAGES_DIR . 'defaultAvatarThumbSpotter.jpg');

/**
 *  Define the default cover for Album
 */
define('DEFALBUMCOVER', DEF_IMAGES_DIR . 'defaultAlbumCover.jpg');

/**
 *  Define the default cover thumb for Album
 */
define('DEFALBUMTHUMB', DEF_IMAGES_DIR . 'defaultAlbumThumb.jpg');

/**
 *  Define the default cover thumb for Event
 */
define('DEFEVENTTHUMB', DEF_IMAGES_DIR . 'defaultEventThumb.jpg');

/**
 *  Define the default cover for Event
 */
define('DEFEVENTIMAGE', DEF_IMAGES_DIR . 'defaultEventImage.jpg');

/**
 *  Define the default cover for Record
 */
define('DEFRECORDCOVER', DEF_IMAGES_DIR . 'defaultRecordCover.jpg');

/**
 *  Define the default cover thumb for Record
 */
define('DEFRECORDTHUMB', DEF_IMAGES_DIR . 'defaultRecordThumb.jpg');

/**
 *  Define the default cover thumb for Song
 */
define('DEFSONGTHUMB', DEF_IMAGES_DIR . 'defaultSongThumb.jpg');

/**
 *  Define the default iamge for Image
 */
define('DEFIMAGE', DEF_IMAGES_DIR . 'defaultImage.jpg');

/** \def 'DEFIMAGETHUMB', DEF_IMAGES_DIR . 'defaultImageThumb.jpg'
 *  Define the default thumb for image
 */
define('DEFIMAGETHUMB', DEF_IMAGES_DIR . 'defaultImageThumb.jpg');

/**
 *  Define the default thumb for Video
 */
define('DEFVIDEOTHUMB', DEF_IMAGES_DIR . 'defaultVideoThumb.jpg');

/**
 *  Define the default directory for BAGDGE images
 */
define('BADGE_DIR', ROOT_DIR . 'views/resources/images/badge/');

/**
 *  white badge
 */
define('BADGE0', BADGE_DIR . 'badgeDefault.png');

/**
 *  OLD SCHOOL badge
 */
define('BADGE1', BADGE_DIR . 'badgeOldSchool.png');

/**
 *  WELCOME badge
 */
define('BADGE2', BADGE_DIR . 'badgeWelcome.png');

/**
 *  PUB badge
 */
define('BADGE3', BADGE_DIR . 'badgePub.png');

/**
 *  NIGHTLIFE badge
 */
define('BADGE4', BADGE_DIR . 'badgeNightLife.png');

/**
 *  LIVE badge
 */
define('BADGE5', BADGE_DIR . 'badgeLive.png');

/**
 *  ROCK badge
 */
define('BADGE6', BADGE_DIR . 'badgeRock.png');

/**
 *  JAMSESSION badge
 */
define('BADGE7', BADGE_DIR . 'badgeJamSession.png');

/**
 *  JAMMEDIN badge
 */
define('BADGE8', BADGE_DIR . 'badgeJammedIn.png');

/**
 *  HAPPYHOUR badge
 */
define('BADGE9', BADGE_DIR . 'badgeHappyHour.png');

/**
 *  PRODUCER badge
 */
define('BADGE10', BADGE_DIR . 'badgeProducer.png');

/**
 *  DJ badge
 */
define('BADGE11', BADGE_DIR . 'badgeDj.png');

/**
 *  DINER badge
 */
define('BADGE12', BADGE_DIR . 'badgeDinner.png');

/**
 *  CONTEST badge
 */
define('BADGE13', BADGE_DIR . 'badgeContest.png');

/**
 *  DANCE badge
 */
define('BADGE14', BADGE_DIR . 'badgeDance.png');

/**
 *  ELECTRO badge
 */
define('BADGE15', BADGE_DIR . 'badgeElectro.png');

/**
 *  POP badge
 */
define('BADGE16', BADGE_DIR . 'badgePop.png');

/**
 *  METAL badge
 */
define('BADGE17', BADGE_DIR . 'badgeMetal.png');

/**
 *  JAZZ badge
 */
define('BADGE18', BADGE_DIR . 'badgeJazz.png');

/**
 *  INDEMAND badge
 */
define('BADGE19', BADGE_DIR . 'badgeInDemand.png');

/**
 *  TEAMUP badge
 */
define('BADGE20', BADGE_DIR . 'badgeTeamUp.png');

/**
 *  PHOTOGRAPHER badge
 */
define('BADGE21', BADGE_DIR . 'badgePhotographer.png');

/**
 *  PR badge
 */
define('BADGE22', BADGE_DIR . 'badgePr.png');

/**
 *  JOURNALIST badge
 */
define('BADGE23', BADGE_DIR . 'badgeJournalist.png');

/**
 *  MAX Query limit
 */
define('MAX', 1000);

/**
 *  MIN Query limit
 */
define('MIN', 1);

/**
 *  DEAFULT Query limit
 */
define('DEFAULTQUERY', 100);

/**
 *  Playlist limit for standard users
 */
define('PLAYLISTLIMIT', 20);

/**
 *  Error String for Location
 */
define('LOCATIONNOTFOUND', 'Location Not Found');

/**
 *  Error String for unlogged users
 */
define('ONLYIFLOGGEDIN', 'Just for logged Users');

/**
 *  Image size width
 */
define('PROFILE_IMG_SIZE', 300);

/**
 *  Thumbnail size width
 */
define('THUMBNAIL_IMG_SIZE', 150);

/**
 *  Max Image size
 */
define('MAX_IMG_UPLOAD_FILE_SIZE', 6291456); //6 Mb

/**
 *  Max MP3 size
 */
define('MAX_MP3_UPLOAD_FILE_SIZE', 12582912); //12 Mb

/**
 * Facebook Address
 */
define('FACEBOOK', 'https://www.facebook.com/Jamyourselfcom');

/**
 * TWITTER Address
 */
define('TWITTER', 'https://twitter.com/Jamyourself');

/**
 * BLOG Address
 */
define('BLOG', 'http://blog.jamyourself.com/');

/**
 * Deafult Name for playlist
 */
define('DEF_PLAY', 'Playslist');

/**
 * Deafult Name for record
 */
define('DEF_REC', 'Default Record');

/**
 * Deafult Name for album
 */
define('DEF_ALBUM', 'Default Album');

/**
 * Deafult Subscribe string
 */
define('SUB_SBJ', 'SUBSCRIBE NUOVO UTENTE');

/**
 * Deafult Subscribe address
 */
define('SUB_ADD', 'subscribe@jamyourself.com');

/**
 * Define if write the Log
 */
define('LOG', 1);

/**
 * Define if write the Log
 */
define('LOG_DIR', ROOT_DIR . 'logs/');

/**
 *  Define the host for the DB
 */
define('MYSQL_HOST', 'jam-db-dev.cloudapp.net');

/**
 *  Define the Username for DB
 */
define('MYSQL_USER', 'jamyourself');

/**
 *  Define the Password for DB
 */
define('MYSQL_PSW', 'j4my0urs3lf');

/**
 *  Define the Database name
 */
define('MYSQL_DB', 'jamdatabase');

/**
 *  Define the host for Node DB
 */
define('NEO4J_HOST', 'jam-db-dev.cloudapp.net');

/**
 *  Define the Post for Node DB
 */
define('NEO4J_PORT', '7474');

/**
 *  Define the Username for Node DB
 */
define('NEO4J_USER', 'jamyourself');

/**
 *  Define the Password for Node DB
 */
define('NEO4J_PSW', 'j4my0urs3lf');

/**
 *  Set the timezone for server side
 */
ini_set('date.timezone', 'GMT');
?>