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
 * \todo	    comprendere i profili premium	
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

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
    function __construct($author, $thumbnail,$title) {
		is_null($author) ? $this->author = NODATA : $this->author = $author;
		is_null($thumbnail) ? $this->thumbnail = DEFSONGTHUMB : $this->thumbnail = $thumbnail;
		is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

/**
 * \brief	PlaylistBox class 
 * \details	box to display user's playlist in each page of the website 
 */
class PlaylistBox {
	
	public $name;
	public $tracklist;

	/**
     * \fn	init($objectId)
     * \brief	Init Playslist Box instance
     * \param	$objectId
     * \return	playlistBox
     */
    public function init($objectId) {
	$playlistBox = new PlaylistBox();
	$tracklist = array();
	
	$playlist = new PlaylistParse();
	$playlist->wherePointer('fromUser','_User', $objectId);
	$playlist->where('active', true);
	$playlist->orderByDescending('createdAt');
	$playlist->setLimit(1);
	$playlists = $playlist->getPlaylists();
	if (get_class($playlists) == 'Error') {
	    return $playlists;
	} else {
	    foreach ($playlists as $playlist) {
			$encodedName = $playlist->getName();
			$name = parse_decode_string($encodedName);
			
			$song = new SongParse();
			$song->whereRelatedTo('songs', 'Playlist', $playlist->getObjectId());
			$song->where('active', true);
			$song->orderByDescending('createdAt');
			$song->setLimit(50);
			$songs = $song->getSongs();
			if (get_class($songs) == 'Error') {
				return $songs;
			} else {
				foreach ($songs as $song) {
					$encodedTitle = $song->getTitle();
					$title = parse_decode_string($encodedTitle);
					
					$authorP = new UserParse();
					$user = $authorP->getUser($song->getFromUser());
					$objectId = $user->getObjectId();
					$thumbnail= $user->getProfileThumbnail;
					$type= $user->getType;
					$encodedUsername = $user->getUsername;
					$username = parse_decode_string($encodedUsername);
					$author = new UserInfo($objectId, $thumbnail, $type, $username);
					
					$recordP = new RecordParse();
					$record = $recordP->getRecord($song->getRecord());
					$thumbnail = $record->getThumbnailCover();
				
					$newSong = new SongInfo($author, $thumbnail, $title);
					array_push($tracklist, $newSong);
				}
			}
		}
	$playlistBox->tracklist = $tracklist;
	$playlistBox->name = $name;
	return $playlistBox;
	}
}

}

?>