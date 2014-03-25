<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once CLASSES_DIR . 'user.class.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'song.class.php';
require_once BOXES_DIR . 'record.box.php';
require_once SERVICES_DIR . 'mp3.service.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'select.service.php';

/**
 * UploadRecordController class
 * si collega al form di upload di un record, effettua controlli, scrive su DB
 * 
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */

class UploadRecordController extends REST {

    public $viewRecordList;

    /**
     * inizializzazione della pagina
     */
    public function init() {
	if (!isset($_SESSION['id'])) {
	    header('Location: login.php?from=uploadRecord.php');
	    exit;
	}
    }

    /**
     * funzione per pubblicazione del record
     */
    private function createRecord($record) {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 400);
	    } elseif (!isset($record['recordTitle']) || is_null($record['recordTitle']) || !(strlen($record['recordTitle']) > 0)) {
		$this->response(array("status" => $controllers['NOTITLE']), 403);
	    } elseif (!isset($record['description']) || is_null($record['description']) || !(strlen($record['description']) > 0)) {
		$this->response(array("status" => $controllers['NODESCRIPTION']), 404);
	    } elseif (!isset($record['tags']) || is_null($record['tags']) || !is_array($record['tags']) || !(count($record['tags']) > 0)) {
		$this->response(array("status" => $controllers['NOTAGS']), 405);
	    } elseif ($_SESSION['type'] != "JAMMER") {
		$this->response(array("status" => $controllers['CLASSTYPEKO']), 406);
	    }
	    $newRecord = json_decode(json_encode($record), false);
	    $userId = $_SESSION['id'];
	    $imgInfo = getCroppedImages($newRecord);
	    $infoLocation = GeocoderService::getCompleteLocationInfo($newRecord->city);
	    $record = new Record();
	    $record->setActive(true);
	    $record->setBuyLink((strlen($newRecord->urlBuy) ? $newRecord->urlBuy : null));
	    $record->setCity($infoLocation['city']);
	    $record->setCommentcounter(0);
	    $record->setCounter(0);
	    $record->setCover($imgInfo['picture']);
	    $record->setDescription($newRecord->description);
	    $record->setDuration(0);
	    if (isset($newRecord->albumFeaturing) && !is_null($newRecord->albumFeaturing) && count($newRecord->albumFeaturing) > 0)
		$record->setFeaturing($newRecord->albumFeaturing);
	    $record->setFromuser($userId);
	    $record->setGenre($this->getTags($newRecord->tags));
	    $record->setLabel($newRecord->label);
	    $record->setLatitude($infoLocation["latitude"]);
	    $record->setLongitude($infoLocation["longitude"]);
	    $record->setLovecounter(0);
	    $record->setReviewcounter(0);
	    $record->setSharecounter(0);
	    $record->setSongcounter(0);
	    $record->setThumbnail($imgInfo['thumbnail']);
	    $record->setTitle($newRecord->recordTitle);
	    $record->setYear($newRecord->year);
	    $filemanager = new FileManagerService();
	    $res_image = $filemanager->saveRecordPhoto($userId, $record->getCover());
	    $res_thumb = $filemanager->saveRecordPhoto($userId, $record->getThumbnail());
	    if (!$res_image || !$res_thumb) {
		$this->response(array("status" => $controllers['RECORDCREATEERROR']), 503);
	    }
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $result = insertRecord($connection, $record);
	    $node = createNode($connectionService, 'record', $record->getId());
	    $relation = createRelation($connectionService, 'user', $userId, 'record', $record->getId(), 'ADD');
	    if ($result === false) {
		$this->response(array("status" => $controllers['RECORDCREATEERROR']), 503);
	    } elseif ($node === false) {
		$this->response(array('status' => $controllers['NODEERROR']), 503);
	    } elseif ($relation === false) {
		$this->response(array('status' => $controllers['RELATIONERROR']), 503);
	    }
	    $connectionService->disconnect($connection);
	    $this->response(array('status' => $controllers['RECORDCREATED']), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * funzione per pubblicazione di song
     */
    public function publish() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 400);
	    } elseif ($this->get_request_method() != "POST") {
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response(array('status' => $controllers['USERNOSES']), 400);
	    } elseif (!isset($this->request['list'])) {
		$this->response(array('status' => $controllers['NOSONGLIST']), 400);
	    } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || strlen($this->request['recordId']) == 0) {
		if (!isset($this->request['record']) || is_null($this->request['record'])) {
		    $this->response(array('status' => $controllers['NORECORDID']), 400);
		}
	    } elseif (!isset($this->request['count'])) {
		$this->response(array('status' => $controllers['NOCOUNT']), 400);
	    }
	    $recordId = null;
	    $record = null;
	    if (!isset($this->request['recordId']) || is_null($this->request['recordId']) || strlen($this->request['recordId']) == 0) {
		$record = $this->createRecord($this->request['record']);
		$recordId = $record->getId();
	    } elseif (isset($this->request['recordId'])) {
		$recordId = $this->request['recordId'];
	    }
	    $currentUserId = $_SESSION['id'];
	    $songList = $this->request['list'];
	    if (is_null($record)) {
		$record = $this->getRecord($recordId);
	    }
	    if ($record instanceof Error) {
		$this->response(array('status' => $controllers['NORECORD']), 204);
	    }
	    $position = $record->getSongcounter();
	    $latitude = $record->getLatitude();
	    $longitude = $record->getLongitude();
	    $songErrorList = array(); //lista canzoni non caricate
	    $songSavedList = array(); //lista canzoni salvate correttamente
	    if (count($songList) > 0) {
		$connectionService = new ConnectionService();
		$connection = $connectionService->connect();
		if ($connection === false) {
		    $this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
		}
		foreach ($songList as $songIstance) {
		    $element = json_decode(json_encode($songIstance), false);
		    $cachedFile = CACHE_DIR . $element->src;
		    if (!file_exists($cachedFile) || !isset($element->tags) || !isset($element->title)) {
			$songErrorList[] = $element;
		    } else {
			$song = new Song();
			$song->setActive(1);
			$song->setCommentcounter(0);
			$song->setCounter(0);
			$song->setDuration($this->getRealLength($cachedFile));
			if (isset($element->featuring) && is_array($element->featuring)) {
			    $song->setFeaturing($element->featuring);
			} else {
			    $song->setFeaturing(array());
			}
			$song->setFromuser($currentUserId);
			$song->setGenre($element->tags);
			$song->setLatitude($latitude);
			$song->setLongitude($longitude);
			$song->setLovecounter(0);
			$position++;
			$song->setPath($element->src);
			$song->setPosition($position);
			$song->setRecord($recordId);
			$song->setSharecounter(0);
			$song->setTitle($element->title);
			$fileManager = new FileManagerService();
			$res = $fileManager->saveSong($currentUserId, $song->getId());
			if (!$res) {
			    $songErrorList[] = $element;
			    $position--;
			}
			$result = insertSong($connection, $song);
			$node = createNode($connectionService, 'song', $song->getId());
			$relation = createRelation($connectionService, 'user', $currentUserId, 'song', $song->getId(), 'ADD');
			if ($result === false || $node === false || $relation === false) {
			    $songErrorList[] = $element;
			    $position--;
			    unlink(CACHE_DIR . $element->src);
			}
			$element->id = $result;
			$songSavedList[] = $element;
		    }
		}
	    }
	    $connectionService->disconnect($connection);
	    if (count($songErrorList) == 0) {
		$this->response(array("status" => $controllers['ALLSONGSSAVED'], "errorList" => null, "savedList" => $songSavedList, "id" => $recordId), 200);
	    } else {
		foreach ($songErrorList as $toRemove) {
		    $this->deleteMp3FromCache($toRemove->src);
		}
		if (count($songSavedList) == 0) {
		    $this->response(array("status" => $controllers['NOSONGSAVED'], "id" => $recordId), 200);
		} else {
		    $this->response(array("status" => $controllers['SONGSAVEDWITHERROR'], "errorList" => $songErrorList, "savedList" => $songSavedList, "id" => $recordId), 200);
		}
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 200);
	}
    }

    /**
     * funzione per cancellazione di song
     */
    public function deleteSong() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response($controllers['USERNOSES'], 402);
	    } elseif ($_SESSION['type'] != "JAMMER") {
		$this->response(array("status" => $controllers['CLASSTYPEKO']), 403);
	    } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || !(strlen($this->request['recordId']) > 0)) {
		$this->response(array("status" => $controllers['NORECORDID']), 404);
	    } elseif (!isset($this->request['songId']) || is_null($this->request['songId']) || !(strlen($this->request['songId']) > 0)) {
		$this->response(array("status" => $controllers['NOSONGID']), 405);
	    }
	    $songId = $this->request['songId'];
	    $recordId = $this->request['recordId'];
	    $record = $this->getRecord($recordId);
	    if ($record instanceof Error) {
		$this->response(array('status' => $controllers['NORECORD']), 406);
	    }

	    #TODO: mancano le funzioni di rimozione
	    //cancello la canzone
	    $song = $this->getSong($songId);
	    if (is_null($song)) {
		$this->response(array('status' => $controllers['NOSONG']), 406);
	    }


	    //@TODO: $resDelete = risultato cancellazione song;
	    $resDelete = false;
	    if ($resDelete == false) {
		$this->response(array("status" => $controllers['NOSONGFORDELETE']), 407);
	    }
	    //rimuovo la relazione tra song e record
	    //@TODO: rimuovere relazione tra record e song
	    $resRemoveRelation = false;
	    if ($resRemoveRelation == false) {
		$this->response(array("status" => $controllers['NOREMOVERELATIONFROMRECORD']), 408);
	    }
	    $this->response(array("status" => $controllers['SONGREMOVEDFROMRECORD'], "id" => $songId), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * funzione per aggiunta song a record esistente
     * @param   $record, instance of record.class
     * @param   $songId
     */
    private function addSongToRecord($record, $song) {
	try {
	    $currentUser = $_SESSION['id'];
	    $recordId = $record->getId();
	    //@TODO: aggiorno la relazione record/song
	    $resRelationCreation = false;
	    if ($resRelationCreation == false) {
		return false;
	    }
	    //@TODO: aggiungere activity per aggiunta song ad un record
	    $resCreationActivity = false;
	    if ($resCreationActivity == false) {
		return false;
	    }

	    //@TODO: aggiornare il contatore delle song nel record (in attesa update service)
	    //@TODO: aggiorno la durata del record
	    $resUpdate = false;
	    if ($resUpdate == false) {
		return false;
	    }
	    return true;
	} catch (Exception $e) {
	    return $e;
	}
    }

    /**
     * funzione per cancellazione mp3 dalla cache
     * 
     * @param   $userId, 
     * @param   $recordId, 
     * @param   $songId
     */
    private function deleteMp3FromCache($songId) {
	if (file_exists(CACHE_DIR . $songId)) {
	    unlink(CACHE_DIR . $songId);
	}
    }

    /**
     * funzione per il recupero della durata di mp3
     * @param $cachedFile string per indicare il file dal eliminare
     * @return int durata in secondi del file
     */
    private function getRealLength($cachedFile) {
	$mp3Analysis = new Mp3file($cachedFile);
	$metaData = $mp3Analysis->get_metadata();
	return (int) $metaData['Length'];
    }

    /**
     * funzione per il recupero delle immagini della lista canzoni
     */
    public function getSongsList() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response($controllers['USERNOSES'], 403);
	    } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || !(strlen($this->request['recordId']) > 0)) {
		$this->response(array("status" => $controllers['NOOBJECTID']), 403);
	    } elseif ($_SESSION['type'] != "JAMMER") {
		$this->response(array("status" => $controllers['CLASSTYPEKO']), 400);
	    }
	    $recordId = $this->request['recordId'];
	    $songsList = $this->getSongsByRecordId($recordId);
	    if (is_null($songsList)) {
		$this->response(array("status" => $controllers['NOSONGFORRECORD'], "songList" => null, "count" => 0), 200);
	    }
	    $returnInfo = array();
	    foreach ($songsList as $song) {
		// info utili
		// mi serve: titolo, durata, lista generi, id
		$seconds = $song->getDuration();
		$hours = floor($seconds / 3600);
		$mins = floor(($seconds - ($hours * 3600)) / 60);
		$secs = floor($seconds % 60);
		$duration = $hours == 0 ? $mins . ":" . $secs : $hours . ":" . $mins . ":" . $secs;
		$genre = $song->getGenre();
		$returnInfo[] = json_encode(array("title" => $song->getTitle(), "duration" => $duration, "genre" => $genre, "id" => $song->getId()));
	    }
	    $this->response(array("status" => $controllers['COUNTSONGOK'], "songList" => $returnInfo, "count" => count($songsList)), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * funzione per il recupero dei tags
     */
    private function getTags($list) {
	if (is_array($list) && count($list) > 0) {
	    return implode(",", $list);
	}
	else
	    return "";
    }

    /**
     * funzione per il recupero dei record dell'utente che fa upload record/song
     */
    public function getUserRecords() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response($controllers['USERNOSES'], 403);
	    }
	    $currentUserId = $_SESSION['id'];
	    $recordIdList = $this->getRecordsByUserId($currentUserId);
	    $fileManager = new FileManagerService();
	    if (!is_null($recordIdList) && count($recordIdList) > 0) {
		foreach ($recordIdList as $record) {
		    $retObj = array();
		    $retObj["thumbnail"] = $fileManager->getRecordPhotoURL($currentUserId, $record->getThumbnail());
		    $retObj["title"] = $record->getTitle();
		    $retObj["songs"] = $record->getSongCounter();
		    $retObj["recordId"] = $record->getId();
		    $recordIdList[] = $retObj;
		}
	    }

	    $this->response(array("status" => $controllers['GETRECORDSOK'], "recordList" => $recordIdList, "count" => count($recordIdList)), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * funzione per la rimozione di una song da un record
     * @param   $record, 
     * @param   $songId
     */
    private function removeSongFromRecord($record, $song) {
	try {
	    $currentUser = $_SESSION['id'];
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $recordId = $record->getId();

	    //@todo: update del recordo per settarlo non attivo
	    $resUpdateInactive = false;
	    if ($resUpdateInactive == false) {
		return false;
	    }

	    //@TODO: sostituzione activity SONGREMOVEDFROMRECORD
	    //aggiorno il contatore del record
	    //@TODO: update per decrementare il numero di record dell'album

	    $resUpdateTrackNum = false;
	    if ($resUpdateTrackNum == false) {
		return false;
	    }
	    //aggiorno la durata del record
	    //@TODO: update per decrementare il numero di record dell'album

	    $resUpdateDuration = false;
	    if ($resUpdateDuration == false) {
		return false;
	    }
	    return true;
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * funzione privata per il recupero della song dal DB
     * @param   $songId
     */
    private function getSong($songId) {
	require_once SERVICES_DIR . 'connection.service.php';
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection != false) {
	    require_once SERVICES_DIR . 'select.service.php';
	    $songs = selectSongs($connection, $songId);
	    if (count($songs) > 0) {
		return $songs[0];
	    }
	}
	return null;
    }

    /**
     * funzione privata per il recupero del record dal DB
     * @param   $recordId
     */
    private function getRecord($recordId) {
	require_once SERVICES_DIR . 'connection.service.php';
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection != false) {
	    require_once SERVICES_DIR . 'select.service.php';
	    $records = selectRecords($connection, $recordId);
	    if (count($records) > 0) {
		return $records[0];
	    }
	}
	return null;
    }

    /**
     * funzione privata per il recupero della lista di song del record dal DB
     * @param   $recordId
     */
    private function getSongsByRecordId($recordId) {
	require_once SERVICES_DIR . 'connection.service.php';
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection != false) {
	    require_once SERVICES_DIR . 'select.service.php';
	    $where = array("record" => $recordId);
	    $orderBy = "position";
	    $songs = selectSongs($connection, null, $where, $orderBy);
	    if (count($songs) > 0) {
		return $songs;
	    }
	}
	return null;
    }

    /**
     * funzione privata per il recupero del record dal DB
     * @param   $recordId
     */
    private function getRecordsByUserId($userId) {
	require_once SERVICES_DIR . 'connection.service.php';
	$connectionService = new ConnectionService();
	$connection = $connectionService->connect();
	if ($connection != false) {
	    require_once SERVICES_DIR . 'select.service.php';
	    $where = array("id_u" => $userId);
	    $orderBy = "createdat";
	    $records = selectRecords($connection, null, $where, $orderBy);
	    if (count($records) > 0) {
		return $records;
	    }
	}
	return null;
    }

}

?>