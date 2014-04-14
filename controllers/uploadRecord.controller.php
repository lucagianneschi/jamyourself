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
require_once CLASSES_DIR . 'record.class.php';
require_once BOXES_DIR . 'record.box.php';
require_once SERVICES_DIR . 'mp3.service.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'log.service.php';

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
	global $controllers;
	$startTimer = microtime();
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "No POST action"');
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "No User in session"');
		$this->response(array('status' => $controllers['USERNOSES']), 400);
	    } elseif (!isset($this->request['recordTitle']) || is_null($this->request['recordTitle']) || !(strlen($this->request['recordTitle']) > 0)) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "No record title"');
		$this->response(array("status" => $controllers['NOTITLE']), 403);
	    } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "No record description"');
		$this->response(array("status" => $controllers['NODESCRIPTION']), 404);
	    } elseif (!isset($this->request['tags']) || is_null($this->request['tags']) || !is_array($this->request['tags']) || !(count($this->request['tags']) > 0)) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "No record tags"');
		$this->response(array("status" => $controllers['NOTAGS']), 405);
	    } elseif ($_SESSION['type'] != "JAMMER") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "wrong user type"');
		$this->response(array("status" => $controllers['CLASSTYPEKO']), 406);
	    }
	    $newRecord = json_decode(json_encode($record), false);
	    $userId = $_SESSION['id'];
	    $imgInfo = getCroppedImages($newRecord);
	    $infoLocation = GeocoderService::getCompleteLocationInfo($this->request['city']);
	    $record = new Record();
	    $record->setActive(true);
	    $urlBuy = $this->request['urlBuy'];
	    $record->setBuyLink((strlen($urlBuy) ? $urlBuy : null));
	    $record->setCity($infoLocation['city']);
	    $record->setCommentcounter(0);
	    $record->setCounter(0);
	    $record->setCover($imgInfo['picture']);
	    $record->setDescription($this->request['description']);
	    $record->setDuration(0);
	    /*
	      if (isset($newRecord->albumFeaturing) && !is_null($newRecord->albumFeaturing) && count($newRecord->albumFeaturing) > 0)
	      $record->setFeaturing($newRecord->albumFeaturing);
	     * */
	    $record->setFromuser($userId);
	    $record->setGenre($this->getTags($this->request['tags']));
	    $record->setLabel($this->request['label']);
	    $record->setLatitude($infoLocation["latitude"]);
	    $record->setLongitude($infoLocation["longitude"]);
	    $record->setLovecounter(0);
	    $record->setReviewcounter(0);
	    $record->setSharecounter(0);
	    $record->setSongcounter(0);
	    $record->setThumbnail($imgInfo['thumbnail']);
	    $record->setTitle($this->request['recordTitle']);
	    $record->setYear($this->request['year']);
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $result = insertRecord($connection, $record);
	    $node = createNode($connectionService, 'record', $result);
	    $relation = createRelation($connectionService, 'user', $userId, 'record', $result, 'CREATE');
	    if (isset($newRecord->albumFeaturing) && !is_null($newRecord->albumFeaturing) && count($newRecord->albumFeaturing) > 0) {
		foreach ($newRecord->albumFeaturing as $userId) {
		    $featuring = createRelation($connectionService, 'user', $userId, 'record', $result, 'FEATURE');
		    if ($featuring == false)
			$this->response(array('status' => $controllers['RECORDCREATEERROR']), 503);
		}
	    }
	    $filemanager = new FileManagerService();
	    $res_image = $filemanager->saveRecordPhoto($userId, $record->getCover());
	    $res_thumb = $filemanager->saveRecordPhoto($userId, $record->getThumbnail());
	    if (!$res_image || !$res_thumb) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "Unable to save thumb and image"');
		$this->response(array("status" => $controllers['RECORDCREATEERROR']), 503);
	    }
	    if ($result === false || $relation === false || $node === false || $res_image === false || $res_thumb === false) {
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    $record->setId($result);
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] createRecord executed');
	    $this->response(array('status' => $controllers['RECORDSAVED']), 200);
	    return $record;
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * funzione per pubblicazione di song
     */
    public function publish() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "No POST action"');
		$this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "No User in session"');
		$this->response(array('status' => $controllers['USERNOSES']), 400);
	    } elseif (!isset($this->request['list'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "No list set"');
		$this->response(array('status' => $controllers['NOSONGLIST']), 400);
	    } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || strlen($this->request['recordId']) == 0) {
		if (!isset($this->request['record']) || is_null($this->request['record'])) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "No record id set"');
		    $this->response(array('status' => $controllers['NORECORDID']), 400);
		}
	    } elseif (!isset($this->request['count'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "No song set"');
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
	    if ($record === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createRecord "Exception" => ' . $e->getMessage());
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
			/* #TODO da aggiungere le featuring su neo4j
			  if (isset($element->featuring) && is_array($element->featuring)) {
			  $song->setFeaturing($element->featuring);
			  } else {
			  $song->setFeaturing(array());
			  } */
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
			$result = insertSong($connection, $song);
			$node = createNode($connectionService, 'song', $result);
			$relation = createRelation($connectionService, 'user', $currentUserId, 'song', $result, 'ADD');
			if (isset($element->featuring) && is_array($element->featuring)) {
			    foreach ($element->featuring as $userId) {
				$featuring = createRelation($connectionService, 'user', $userId, 'song', $result, 'FEATURE');
				if ($featuring == false)
				    $this->response(array('status' => $controllers['COMMENTERR']), 503);
			    }
			}
			$fileManager = new FileManagerService();
			$res = $fileManager->saveSong($currentUserId, $result);
			if ($result === false || $node === false || $relation === false || $res = false) {
			    $songErrorList[] = $element;
			    $position--;
			    unlink(CACHE_DIR . $element->src);
			}
			$element->id = $result;
			$songSavedList[] = $element;
		    }
		}
	    }
	    $songsSaved = count($songList) - count($songErrorList);
	    if ($songsSaved > 0) {
		require_once SERVICES_DIR . 'update.service.php';
		$resUpdate = update($connection, 'record', array('updatedat' => date('Y-m-d H:i:s')), array('songcounter' => $songsSaved), null, $recordId, null);
		if ($resUpdate == false)
		    $this->response(array('status' => $controllers['COMMENTERR']), 503);
	    }
	    $connectionService->disconnect($connection);
	    if (count($songErrorList) == 0) {
		$this->response(array("status" => $controllers['ALLSONGSSAVED'], "errorList" => null, "savedList" => $songSavedList, "id" => $recordId), 200);
	    } else {
		foreach ($songErrorList as $toRemove) {
		    $this->deleteMp3FromCache($toRemove->src);
		}
		if (count($songSavedList) == 0) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] publish but non song saved');
		    $this->response(array("status" => $controllers['NOSONGSAVED'], "id" => $recordId), 200);
		} else {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] publish executed');
		    $this->response(array("status" => $controllers['SONGSAVEDWITHERROR'], "errorList" => $songErrorList, "savedList" => $songSavedList, "id" => $recordId), 200);
		}
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 200);
	}
    }

    /**
     * funzione per cancellazione di song
     */
    public function deleteSong() {
	global $controllers;
	$startTimer = microtime();
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "No POST action"');
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
    private function addSongToRecord(Record $record, Song $song) {
	global $controllers;
	$startTimer = microtime();
	try {
	    $resRelationCreation = false;
	    if ($resRelationCreation == false) {
		return false;
	    }
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $node = createNode($connectionService, 'song', $song->getId());
	    $relation = createRelation($connectionService, 'record', $record->getId(), 'song', $song->getId(), 'ADD');
	    if ($relation === false || $node === false) {
		return true;
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }

	    require_once SERVICES_DIR . 'select.service.php';
	    $record->setDuration($record->getDuration() + $song->getDuration());
	    $songcounter = $record->getSongcounter() + 1;
	    $record->setSongcounter($songcounter);
	    updateRecord($connection, $record);

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
	global $controllers;
	$startTimer = microtime();
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during publish "No POST action"');
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
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during getSongsList "Exception" => ' . $e->getMessage());
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
     * funzione per la rimozione di una song da un record
     * @param   $record, 
     * @param   $songId
     */
    private function removeSongFromRecord($record, $song) {
	$startTimer = microtime();
	try {
	    $currentUser = $_SESSION['id'];
	    require_once CLASSES_DIR . 'record.class.php';
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
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during removeSongFromRecord "Exception" => ' . $e->getMessage());
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
		return $records[$recordId];
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

}

?>