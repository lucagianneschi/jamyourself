<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event per pagina event
 * \details		Recupera le informazioni dell'evento, le inserisce in un oggetto e le passa alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo			
 *
 */


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

class SongInfo{
   
   public $duration;
   public $title;
   public $loveCounter;
   public $shareCounter;
   
   function __construct($duration,$loveCounter,$shareCounter,$title){
		is_null($duration) ? $this->duration = NODATA : $this->duration = $duration;
		is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
		is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
		is_null($title) ? $this->title = NODATA : $this->title = $title;
   }
}

class UserInfo{
	
	public $thumbnail;
	public $type;
	public $username;

	function __construct($thumbnail,$type,$username){
		is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
		is_null($type) ? $this->type = NODATA : $this->type = $type;
		is_null($username) ? $this->username= NODATA : $this->username = $username;
	}
}

class RecordInfoBox {

	public $buylink;
	public $cover;
	public $description;
	public $featuring;
	public $genre;
	public $songList;
    public $title;
	public $year;
	
	public function init($objectId) {
	
	$recordInfoBox = new RecordInfoBox ();
	$songList = array();
	
	$recordP = new RecordParse();
	$record = $recordP->getRecord($objectId);
	
	if($record->getActive() = true){
		is_null($event->getBuylink()) ? $eventInfoBox->buylink = NODATA : $eventInfoBox->$buylink = $event->getBuylink();
		is_null($event->getCover()) ? $eventInfoBox->cover = NODATA : $eventInfoBox->$cover = $event->getCover();
		is_null($event->getDescription()) ? $eventInfoBox->description = NODATA : $eventInfoBox->description = $event->getDescription();
		is_null($event->getFeaturing()) ? $eventInfoBox->featuring = NODATA : $eventInfoBox->featuring = $event->getFeaturing();
		is_null($event->getGenre()) ? $eventInfoBox->genre = NODATA : $eventInfoBox->genre = $event->getGenre();
		is_null($event->getTitle()) ? $eventInfoBox->title = NODATA : $eventInfoBox->$title = $event->getTitle();
		
		$fromUserP = new UserParse();
		$fromUser = $fromUserP->getUser($event->getFromUser);
		if ($fromUser != null){
			is_null($user->getUsername()) ? $eventInfoBox->username = NODATA : $eventInfoBox->username = $user->getUsername();
			is_null($user->getProfilePictureThumbnail) ? $eventInfoBox->thumbnail = NODATA : $eventInfoBox->thumbnail = $user->getProfilePictureThumbnail;
		}
				
		$featuring = array();
		$parseUser = new UserParse();
		$parseUser->whereRelatedTo('featuring','Record', $objectId);
		$parseUser->where('active', true);
		$parseUser->setLimit(1000);
		$feats = $parseUser->getUsers();
		if(count($feats) == 0) {
			$eventInfoBox->featuring = NODATA;
		}elseif(get_class($feats) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
		} else {
			foreach ($feats as $user) {
				$thumbnail = $user->getProfilePictureThumbnail();
				$type = $user->getType();
				$username = $user->getUsername();
				$userInfo = new UserInfo($thumbnail,$type,$username);
				array_push($featuring, $userInfo);
			}
			$eventInfoBox->featuring = $featuring;
		}	
	}	
	
		$songList = array();
		$parseSong = new SongParse();
		$parseSong->where('active', true);
		$parseSong->setLimit(50);
		$songs = $parseSong->getSongs();
		if(count($songs) == 0){
			$eventInfoBox->songList = NODATA;
		} elseif(get_class($songs) == 'Error'){
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $events->getErrorMessage() . '<br/>';
		} else {
			foreach ($songs as $song) {
				$duration = $song->getDuration();
				$title = song->getTitle();
				$loveCounter = $song->getLoveCounter();
				$shareCounter = $song->getShareCounter();
				$songInfo = new SongInfo($duration,$loveCounter,$shareCounter,$title);
				array_push($songList, $songInfo);
			}
			$eventInfoBox->songList = $songList;
		}
	return $recordInfoBox;
	}

}

?>