<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento playlist utente
 * \details		Recupera la playlist utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo	    comprendere i profili premium, uso whereInclude	
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';

require_once CLASSES_DIR . 'userParse.class.php';
session_start();

/**
 * \brief	SongInfo class 
 * \details	info for the song to be displayed in the playlistBox 
 */
class SongInfo {

    public $author;
    public $thumbnail;
    public $title;

    /**
     * \fn	__construct($author, $thumbnail,$title)
     * \brief	construct for the SongInfo class
     * \param	$author, $thumbnail,$title
     */
    function __construct($author, $thumbnail, $title) {
        global $boxes;
        is_null($author) ? $this->author = $boxes['NODATA'] : $this->author = $author;
        is_null($thumbnail) ? $this->thumbnail = DEFSONGTHUMB : $this->thumbnail = $thumbnail;
        is_null($title) ? $this->title = $boxes['NODATA'] : $this->title = $title;
    }

}

/**
 * \brief	PlaylistBox class 
 * \details	box to display user's playlist in each page of the website 
 */
class PlaylistBox {

    public $config;
    public $error;
    public $name;
    public $tracklist;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "boxes/playlist.config.json"), false);
    }

    /**
     * \fn	init($objectId)
     * \brief	Init Playslist Box instance
     * \param	$objectId
     * \return	playlistBox
     * \todo    implementare la differenziazione della lunghezza della query in base alla proprety premium dell'utente, usa una variabile in più $premium che deve essere un BOOL
     */
    public function init() {
        global $boxes;
        $tracklist = array();
        $currentUserObjectId = sessionChecker();
        if ($currentUserObjectId == $boxes['NOID']) {
            $this->tracklist = array();
            $this->name = null;
            $this->error = $boxes['ONLYIFLOGGEDIN'];
        }
        $playlist = new PlaylistParse();
        $playlist->wherePointer('fromUser', '_User', $currentUserObjectId);
        $playlist->where('active', true);
        $playlist->orderByDescending('createdAt');
        $playlist->setLimit($this->config->limitForPlaylist);
        $playlists = $playlist->getPlaylists();
        if ($playlists instanceof Error) {
            $this->tracklist = array();
            $this->name = null;
            $this->error = $playlists->getErrorMessage();
            return;
        } elseif (is_null($playlists)) {
            $this->tracklist = array();
            $this->name = null;
            $this->error = null;
            return;
        } else {
            foreach ($playlists as $playlist) {
                require_once CLASSES_DIR . 'song.class.php';
                require_once CLASSES_DIR . 'songParse.class.php';
                $this->name = ($playlist->getName());
                $song = new SongParse();
                $song->whereRelatedTo('songs', 'Playlist', $playlist->getObjectId());
                $song->where('active', true);
                $song->orderByDescending('createdAt');
                $song->setLimit($this->config->limitForTracklist);
                $song->whereInclude('fromUser,record');
                $songs = $song->getSongs();
                if ($songs instanceof Error) {
                    $this->tracklist = array();
                    $this->name = null;
                    $this->error = $songs->getErrorMessage();
                    return;
                } elseif (is_null($songs)) {
                    $this->tracklist = array();
                } else {
                    foreach ($songs as $song) {
                        $title = $song->getTitle();
                        $songId = $song->getFromUser()->getObjectId();
                        $thumbnail = $song->getFromUser()->getProfileThumbnail();
                        $type = $song->getFromUser()->getType();
                        $username = $song->getFromUser()->getUsername();
                        $author = new UserInfo($songId, $thumbnail, $type, $username);
                        $thumbnailRec = $song->getRecord()->getThumbnailCover();
                        $newSong = new SongInfo($author, $thumbnailRec, $title);
                        array_push($tracklist, $newSong);
                    }
                }
            }
            $this->tracklist = $tracklist;
            $this->error = null;
        }
    }

}

?>