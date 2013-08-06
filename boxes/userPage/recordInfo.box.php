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

class SongInfo {

    public $duration;
    public $title;
    public $loveCounter;
    public $shareCounter;

    function __construct($duration, $loveCounter, $shareCounter, $title) {
	is_null($duration) ? $this->duration = NODATA : $this->duration = $duration;
	is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
	is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
	is_null($title) ? $this->title = NODATA : $this->title = $title;
    }

}

class UserInfo {

    public $thumbnail;
    public $type;
    public $username;

    function __construct($thumbnail, $type, $username) {
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($type) ? $this->type = NODATA : $this->type = $type;
	is_null($username) ? $this->username = NODATA : $this->username = $username;
    }

}

class RecordInfoBox {

    public $buylink;
    public $cover;
    public $description;
    public $featuring;
    public $genre;
    public $songList;
    public $thumbnail;
    public $title;
    public $type;
    public $username;
    public $year;

    public function init($objectId) {

	$recordInfoBox = new RecordInfoBox ();

	$recordP = new RecordParse();
	$record = $recordP->getRecord($objectId);

	if ($record->getActive() == true) {
	    is_null($record->getBuylink()) ? $recordInfoBox->buylink = NODATA : $recordInfoBox->buylink = $record->getBuylink();
	    is_null($record->getCover()) ? $recordInfoBox->cover = NODATA : $recordInfoBox->cover = $record->getCover();
	    is_null($record->getDescription()) ? $recordInfoBox->description = NODATA : $recordInfoBox->description = $record->getDescription();
	    is_null($record->getFeaturing()) ? $recordInfoBox->featuring = NODATA : $recordInfoBox->featuring = $record->getFeaturing();
	    is_null($record->getGenre()) ? $recordInfoBox->genre = NODATA : $recordInfoBox->genre = $record->getGenre();
	    is_null($record->getTitle()) ? $recordInfoBox->title = NODATA : $recordInfoBox->title = $record->getTitle();
	    is_null($record->getYear()) ? $recordInfoBox->year = NODATA : $recordInfoBox->year = $record->getYear();

	    $fromUserP = new UserParse();
	    $fromUser = $fromUserP->getUser($record->getFromUser);
	    if ($fromUser != null) {
		is_null($fromUser->thumbnail) ? $recordInfoBox->thumbnail = NODATA : $recordInfoBox->thumbnail = $fromUser->thumbnail;
		is_null($fromUser->type) ? $recordInfoBox->type = NODATA : $recordInfoBox->type = $fromUser->type;
		is_null($fromUser->username) ? $recordInfoBox->username = NODATA : $recordInfoBox->username = $fromUser->username;
		
	    }

	    $featuring = array();
	    $parseUser = new UserParse();
	    $parseUser->whereRelatedTo('featuring', 'Record', $objectId);
	    $parseUser->where('active', true);
	    $parseUser->setLimit(1000);
	    $feats = $parseUser->getUsers();
	    if (count($feats) == 0) {
		$recordInfoBox->featuring = NODATA;
	    } elseif (get_class($feats) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $feats->getErrorMessage() . '<br/>';
	    } else {
		foreach ($feats as $user) {
		    $thumbnail = $user->getProfilePictureThumbnail();
		    $type = $user->getType();
		    $username = $user->getUsername();
		    $userInfo = new UserInfo($thumbnail, $type, $username);
		    array_push($featuring, $userInfo);
		}
		$recordInfoBox->featuring = $featuring;
	    }
	}

	$songList = array();
	$parseSong = new SongParse();
	$parseSong->wherePointer('record', 'Record', $objectId);
	$parseSong->where('active', true);
	$parseSong->setLimit(50);
	$songs = $parseSong->getSongs();
	if (count($songs) == 0) {
	    $recordInfoBox->songList = NODATA;
	} elseif (get_class($songs) == 'Error') {
	    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $songs->getErrorMessage() . '<br/>';
	} else {
	    foreach ($songs as $song) {
		$duration = $song->getDuration();
		$title = $song->getTitle();
		$loveCounter = $song->getLoveCounter();
		$shareCounter = $song->getShareCounter();
		$songInfo = new SongInfo($duration, $loveCounter, $shareCounter, $title);
		array_push($songList, $songInfo);
	    }
	    $recordInfoBox->songList = $songList;
	}
	return $recordInfoBox;
    }

}

?>