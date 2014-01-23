<?php

/* ! \par		Info Generali:
 * \author		Stefano Muscas
 * \version		1.0
 * \date		2013
 * \copyright           Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di upload record 
 * \details		si collega al form di upload di un record, effettua controlli, scrive su DB
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'activityParse.class.php';
require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
require_once BOXES_DIR . "record.box.php";
require_once BOXES_DIR . "utilsBox.php";
require_once SERVICES_DIR . 'mp3.service.php';

/**
 * \brief	UploadRecordController class 
 * \details	controller di upload record
 */
class UploadRecordController extends REST {

    public $viewRecordList;

    /**
     * \fn	init()
     * \brief   inizializzazione della pagina
     */
    public function init() {
//utente non loggato

        if (!isset($_SESSION['currentUser'])) {
            /* This will give an error. Note the output
             * above, which is before the header() call */
            header('Location: login.php?from=uploadRecord.php');
            exit;
        }

//        $currentUser = $_SESSION['currentUser'];
//caching dell'array dei featuring: tolto per velocizzare la pagina, verra' chiamato
//in maniera asincrona
//        $_SESSION['currentUserFeaturingArray'] = $this->getFeaturingArray();
//        $recordBox = new RecordBox();
//        $recordBox->initForUploadRecordPage($currentUser->getObjectId());
//        $this->viewRecordList = $recordBox->recordArray;
    }

    /**
     * \fn	createEvent()
     * \brief   funzione per pubblicazione dell'event
     * \modificare il nome in createRecord
     */
    private function createRecord($record) {
        try {
            global $controllers;
            if (!isset($record['recordTitle']) || is_null($record['recordTitle']) || !(strlen($record['recordTitle']) > 0)) {
                $this->response(array("status" => $controllers['NOTITLE']), 403);
            } elseif (!isset($record['description']) || is_null($record['description']) || !(strlen($record['description']) > 0)) {
                $this->response(array("status" => $controllers['NODESCRIPTION']), 404);
            } elseif (!isset($record['tags']) || is_null($record['tags']) || !is_array($record['tags']) || !(count($record['tags']) > 0)) {
                $this->response(array("status" => $controllers['NOTAGS']), 405);
            } elseif ($_SESSION['currentUser']->getType() != "JAMMER") {
                $this->response(array("status" => $controllers['CLASSTYPEKO']), 406);
            }
            $newRecord = json_decode(json_encode($record), false);

            $user = $_SESSION['currentUser'];
            $userId = $user->getObjectId();
            $pRecord = new RecordParse();
            $record = new Record();
            $record->setActive(true);
            $record->setBuyLink((strlen($newRecord->urlBuy) ? $newRecord->urlBuy : null));
            $record->setCounter(0);
            require_once CONTROLLERS_DIR . "utilsController.php";
            $imgInfo = getCroppedImages($newRecord);
            $record->setCover($imgInfo['picture']);
            $record->setThumbnailCover($imgInfo['thumbnail']);
            $record->setSongCounter(0);
            $record->setDescription($newRecord->recordTitle);
            $record->setDuration(0);
            if (isset($newRecord->albumFeaturing) && !is_null($newRecord->albumFeaturing) && count($newRecord->albumFeaturing) > 0)
                $record->setFeaturing($newRecord->albumFeaturing);
            $record->setFromUser($userId);
            $record->setGenre($this->getTags($newRecord->tags));
            $record->setLabel($newRecord->label);
            $infoLocation = GeocoderService::getCompleteLocationInfo($newRecord->city);
            $parseGeoPoint = new parseGeoPoint($infoLocation["latitude"], $infoLocation["longitude"]);
            $record->setLocation($parseGeoPoint);
            $record->setCity($infoLocation['city']);
            $record->setLoveCounter(0);
            $record->setReviewCounter(0);
            $record->setShareCounter(0);
            $record->setTitle($newRecord->recordTitle);
            $record->setYear($newRecord->year);
            $savedRecord = $pRecord->saveRecord($record);
            if ($savedRecord instanceof Error) {
                $this->response(array("status" => $controllers['RECORDCREATEERROR']), 503);
            }
            $resFSCreation = $this->createFolderForRecord($userId, $savedRecord->getObjectId());
            if ($resFSCreation instanceof Exception || !$resFSCreation) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackUploadRecordController($savedRecord->getObjectId(), "Record");
                $this->response(array("status" => $message), 503);
            }

            $dirCoverDest = USERS_DIR . $userId . "/images/recordcover";
            $dirThumbnailDest = USERS_DIR . $userId . "/images/recordcoverthumb";

            //SPOSTO LE IMMAGINI NELLE RISPETTIVE CARTELLE 
            $thumbSrc = $savedRecord->getThumbnailCover();
            $imageSrc = $savedRecord->getCover();
            //SPOSTO LE IMMAGINI NELLE RISPETTIVE CARTELLE         
            if (!is_null($thumbSrc) && (strlen($thumbSrc) > 0) && !is_null($imageSrc) && (strlen($imageSrc) > 0)) {
                rename(MEDIA_DIR . "cache/" . $thumbSrc, $dirThumbnailDest . DIRECTORY_SEPARATOR . $thumbSrc);
                rename(MEDIA_DIR . "cache/" . $imageSrc, $dirCoverDest . DIRECTORY_SEPARATOR . $imageSrc);
            }
            unset($_SESSION['currentUserFeaturingArray']);
            //se va a buon fine salvo una nuova activity 
            $pActivity = $this->createActivity($userId, $savedRecord->getObjectId());
            if ($pActivity instanceof Error) {
                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                $message = rollbackUploadRecordController($savedRecord->getObjectId(), "Record");
                $this->response(array("status" => $message), 503);
            }
            return $savedRecord;
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }

    /**
     * \fn	publishSongs()
     * \brief   funzione per pubblicazione di song
     */
    public function publish() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 400);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 400);
            } elseif (!isset($this->request['list'])) {
                $this->response(array('status' => $controllers['NOSONGLIST']), 400);
            } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || strlen($this->request['recordId']) == 0) {
                //se non c'e' recordId allora sto creando un nuovo album
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
                $recordId = $record->getObjectId();
            } elseif (isset($this->request['recordId'])) {
                $recordId = $this->request['recordId'];
            }

            $currentUser = $_SESSION['currentUser'];
            $songList = $this->request['list'];
            if (is_null($record)) {
                $pRecord = new RecordParse();
                $record = $pRecord->getRecord($recordId);
            }
            if ($record instanceof Error) {
                $this->response(array('status' => $controllers['NORECORD']), 204);
            }
            $position = $record->getSongCounter();
            $songErrorList = array(); //lista canzoni non caricate
            $songSavedList = array(); //lista canzoni salvate correttamente
            if (count($songList) > 0) {
                $pSong = new SongParse();
                foreach ($songList as $songIstance) {
                    $element = json_decode(json_encode($songIstance), false);
                    $cachedFile = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $element->src;
                    if (!file_exists($cachedFile) || !isset($element->tags) || !isset($element->title)) {
                        //errore... il file non e' piu' in cache... :(
                        // tags non presenti
                        // titolo non presente
                        $songErrorList[] = $element;
                    } else {
                        $song = new Song();
                        $song->setActive(true);
                        $song->setCounter(0);
                        $song->setDuration($this->getRealLength($cachedFile));
                        if (isset($element->featuring) && is_array($element->featuring)) {
                            $song->setFeaturing($element->featuring);
                        } else {
                            $song->setFeaturing(array());
                        }
                        $song->setFilePath($element->src);
                        $song->setFromUser($currentUser->getObjectId());
                        $song->setGenre($element->tags);
                        $song->setLocation(null);
                        $song->setLovers(array());
                        $song->setLoveCounter(0);
                        $position++;
                        $song->setPosition($position);
                        $song->setRecord($recordId);
                        $song->setCounter(0);
                        $song->setShareCounter(0);
                        $song->setTitle($element->title);
                        $savedSong = $pSong->saveSong($song);
                        if ($savedSong instanceof Error) {
                            //errore: inserire una rollback per la cancellazione di tutti gli mp3? 
                            //come gestire?
                            //idea: salvo una lista degli mp3 il cui salvataggio e' fallito
                            $songErrorList[] = $element;
                            //decremento il contatore
                            $position--;
                            //cancello l'mp3 dalla cache
                            unlink(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $element->src);
                        } else {
                            if (!$this->saveMp3($currentUser->getObjectId(), $recordId, $song->getFilePath()) || $this->createActivity($currentUser->getObjectId(), $recordId, "SONGUPLOADED", $savedSong->getObjectId()) instanceof Error) {
                                require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                                rollbackUploadRecordController($savedSong->getObjectId(), "Song");
                                $songErrorList[] = $element;
                                $position--;
                            } else {
                                //aggiungo il songId alla lista degli elementi salvati
                                $resAddRelation = $this->addSongToRecord($record, $savedSong);
                                if ($resAddRelation instanceof Error || $resAddRelation instanceof Exception || !$resAddRelation) {
                                    //errore creazione relazione fra record e song
                                    rollbackUploadRecordController($savedSong->getObjectId(), "Song");
                                    $songErrorList[] = $element;
                                    $position--;
                                } else {
                                    //tutto bene
                                    $element->id = $savedSong->getObjectId();
                                    $songSavedList[] = $element;
                                }
                            }
                        }
                    }
                }
            }
            //gestione risposte
            if (count($songErrorList) == 0) {
                //nessun errore
                $this->response(array("status" => $controllers['ALLSONGSSAVED'], "errorList" => null, "savedList" => $songSavedList), 200);
            } else {
                foreach ($songErrorList as $toRemove) {
                    $this->deleteMp3($currentUser->getObjectId(), $recordId, $toRemove->src);
                }
                if (count($songSavedList) == 0) {
                    //nessuna canzone salvata => tutti errori  
                    $this->response(array("status" => $controllers['NOSONGSAVED']), 200);
                } else {
                    //salvate parzialmente, qualche errore
                    $this->response(array("status" => $controllers['SONGSAVEDWITHERROR'], "errorList" => $songErrorList, "savedList" => $songSavedList), 200);
                }
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 200);
        }
    }

    /**
     * \fn	deleteSong()
     * \brief   funzione per pubblicazione di song
     */
    public function deleteSong() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response($controllers['USERNOSES'], 402);
            } elseif ($_SESSION['currentUser']->getType() != "JAMMER") {
                $this->response(array("status" => $controllers['CLASSTYPEKO']), 403);
            } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || !(strlen($this->request['recordId']) > 0)) {
                $this->response(array("status" => $controllers['NORECORDID']), 404);
            } elseif (!isset($this->request['songId']) || is_null($this->request['songId']) || !(strlen($this->request['songId']) > 0)) {
                $this->response(array("status" => $controllers['NOSONGID']), 405);
            }
            $songId = $this->request['songId'];
            $recordId = $this->request['recordId'];
            $pRecord = new RecordParse();
            $record = $pRecord->getRecord($recordId);
            if ($record instanceof Error) {
                $this->response(array('status' => $controllers['NORECORD']), 406);
            }
            $pSong = new SongParse();
            //cancello la canzone

            $song = $pSong->getSong($songId);
            if ($song instanceof Error) {
                $this->response(array('status' => $controllers['NOSONG']), 406);
            }

            if ($pSong->deleteSong($songId) instanceof Error) {
                $this->response(array("status" => $controllers['NOSONGFORDELETE']), 407);
            }
            //rimuovo la relazione tra song e record
            $resRemoveRelation = $this->removeSongFromRecord($record, $song);

            if ($resRemoveRelation instanceof Error || $resRemoveRelation instanceof Exception || !$resRemoveRelation) {
                $this->response(array("status" => $controllers['NOREMOVERELATIONFROMRECORD']), 408);
            }
            $this->response(array("status" => $controllers['SONGREMOVEDFROMRECORD'], "id" => $songId), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }

    /**
     * \fn	addSongToRecord($record, $songId)
     * \brief   funzione per aggiunta song a record esistente
     * \param   $record, instance of record.class e songId
     */
    private function addSongToRecord($record, $song) {
        try {
            $currentUser = $_SESSION['currentUser'];
            $pRecord = new RecordParse();
            $recordId = $record->getObjectId();

            //recupero la tracklist
//            $tracklist = $record->getTracklist();
//            if (is_null($tracklist) || !is_array($tracklist)) {
//                $tracklist = array();
//            }
//            //verifico che la canzone non sia gia' presente nella tracklist
//            if (in_array($songId, $tracklist)) {
//                return false;
//            }
            //aggiorno la relazione record/song
            $res = $pRecord->updateField($recordId, 'tracklist', array($song->getObjectid()), true, 'add', 'Song');
            if ($res instanceof Error) {
                return $res;
            }
            //creo l'activity specifica 
            require_once CLASSES_DIR . 'activityParse.class.php';
            $resActivity = $this->createActivity($currentUser->getObjectId(), $recordId, "SONGADDEDTORECORD", $song->getObjectId());
            if ($resActivity instanceof Error) {
                return $resActivity;
            }
            //aggiorno il contatore del record
            $resIncrSongCounter = $pRecord->incrementRecord($recordId, "songCounter", 1);
            if ($resIncrSongCounter instanceof Error) {
                return $resIncrSongCounter;
            }
            //aggiorno la durata del record
            $resIncrDuration = $pRecord->incrementRecord($recordId, "duration", $song->getDuration());
            if ($resIncrDuration instanceof Error) {
                return $resIncrDuration;
            }
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * \fn	createActivity($fromUser, $recordId, $type = 'RECORDUPLOADED', $songId = null)
     * \brief   funzione per creazione activity per questo controller
     * \param   $fromUser, $recordId, $type = 'RECORDUPLOADED', $songId = null
     */
    private function createActivity($fromUser, $recordId, $type = 'RECORDUPLOADED', $songId = null) {
        require_once CLASSES_DIR . 'activity.class.php';
        require_once CLASSES_DIR . 'activityParse.class.php';
        $activity = new Activity();
        $activity->setActive(true);
        $activity->setAlbum(null);
        $activity->setCounter(0);
        $activity->setEvent(null);
        $activity->setFromUser($fromUser);
        $activity->setImage(null);
        $activity->setPlaylist(null);
        $activity->setQuestion(null);
        $activity->setRead(true);
        $activity->setRecord($recordId);
        $activity->setSong($songId);
        $activity->setStatus(null);
        $activity->setToUser(null);
        $activity->setType($type);
        $activity->setVideo(null);
        $pActivity = new ActivityParse();
        return $pActivity->saveActivity($activity);
    }

    /**
     * \fn	createFolderForRecord($userId, $recordId)
     * \brief   funzione per creazione filesystem dopo aggiunta record
     * \param   $userId, $recordId
     */
    private function createFolderForRecord($userId, $recordId) {
        try {
            if (!is_null($userId) && strlen($userId) > 0) {
                //creazione cartella del record
                if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $recordId, 0777, true)) {
                    return false;
                }
                //creazione cartella delle cover del record
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover")) {
                    //se la cartella non esiste la creo
                    if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcover", 0777, true)) {
                        return false;
                    }
                }
                //creazione cartella delle thumbnail del record                
                if (!is_dir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb")) {
                    //se la cartella non esiste la creao
                    if (!mkdir(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb", 0777, true)) {
                        return false;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * \fn	deleteMp3($userId, $recordId, $songId)
     * \brief   funzione per cancellazione mp3 dal filesystem
     * \param   $userId, $recordId, $songId
     */
    private function deleteMp3($userId, $recordId, $songId) {
        if (file_exists(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $songId)) {
            unlink(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $songId);
        }
        if (file_exists(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $recordId . DIRECTORY_SEPARATOR . $songId)) {
            unlink(USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $recordId . DIRECTORY_SEPARATOR . $songId);
        }
    }

    /**
     * \fn	getFeaturingJSON() 
     * \brief   funzione per il recupero dei featuring per l'event
     * \todo check possibilità utilizzo di questa funzione come pubblica e condivisa tra più controller
     */
    public function getFeaturingJSON() {
        try {
            global $controllers;
            error_reporting(E_ALL ^ E_NOTICE);
            $force = false;
            $filter = null;

            if (!isset($_SESSION['currentUser'])) {
                $this->response(array('status' => $controllers['USERNOSES']), 400);
            }
            if (isset($this->request['force']) && !is_null($this->request['force']) && $this->request['force'] == "true") {
                $force = true;
            }
            if (isset($this->request['term']) && !is_null($this->request['term']) && (strlen($this->request['term']) > 0)) {
                $filter = $this->request['term'];
            }
            $currentUserFeaturingArray = null;
            if ($force == false && isset($_SESSION['currentUserFeaturingArray']) && !is_null($_SESSION['currentUserFeaturingArray'])) {//caching dell'array
                $currentUserFeaturingArray = $_SESSION['currentUserFeaturingArray'];
            } else {
                require_once CONTROLLERS_DIR . 'utilsController.php';
                $currentUserFeaturingArray = getFeaturingArray();
                $_SESSION['currentUserFeaturingArray'] = $currentUserFeaturingArray;
            }

            if (!is_null($filter)) {
                require_once CONTROLLERS_DIR . 'utilsController.php';
                echo json_encode(filterFeaturingByValue($currentUserFeaturingArray, $filter));
            } else {
                echo json_encode($currentUserFeaturingArray);
            }
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	getRealLength($cachedFile) 
     * \brief   funzione per il recupero della durata di mp3
     */
    private function getRealLength($cachedFile) {
        $mp3Analysis = new Mp3file($cachedFile);
        $metaData = $mp3Analysis->get_metadata();
        return (int) $metaData['Length'];
    }

    /**
     * \fn	getRecordThumbnailURL($userId, $recordCoverThumb)
     * \brief   funzione per il recupero delle immagini del record dal filesystem
     * \param   $userId, $recordCoverThumb
     */
    private function getRecordThumbnailURL($userId, $recordCoverThumb) {
        try {
            if (!is_null($recordCoverThumb) && strlen($recordCoverThumb) > 0 && !is_null($userId) && strlen($userId) > 0) {
                $path = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $recordCoverThumb;
                if (!file_exists($path)) {
                    return DEFRECORDTHUMB;
                } else {
                    return "../users/" . $userId . "/images/recordcoverthumb/" . $recordCoverThumb;
                }
            } else {
                $path = DEFRECORDTHUMB;
            }

            return DEFRECORDTHUMB;
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	getSongsList()
     * \brief   funzione per il recupero delle immagini della lista canzoni
     */
    public function getSongsList() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response($controllers['USERNOSES'], 403);
            } elseif (!isset($this->request['recordId']) || is_null($this->request['recordId']) || !(strlen($this->request['recordId']) > 0)) {
                $this->response(array("status" => $controllers['NOOBJECTID']), 403);
            } elseif ($_SESSION['currentUser']->getType() != "JAMMER") {
                $this->response(array("status" => $controllers['CLASSTYPEKO']), 400);
            }
            $recordId = $this->request['recordId'];
            $songsList = tracklistGenerator($recordId);
            if ($songsList instanceof Error) {
                $this->response(array("status" => $controllers['NODATA']), 200);
            } elseif (is_null($songsList) || count($songsList) == 0) {
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
                $returnInfo[] = json_encode(array("title" => $song->getTitle(), "duration" => $duration, "genre" => $genre, "id" => $song->getObjectId()));
            }
            $this->response(array("status" => $controllers['COUNTSONGOK'], "songList" => $returnInfo, "count" => count($songsList)), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	getSongsList()
     * \brief   funzione per il recupero dei tags
     */
    private function getTags($list) {
        if (is_array($list) && count($list) > 0) {
            return implode(",", $list);
        }
        else
            return "";
    }

    /**
     * \fn	getUserRecords()
     * \brief   funzione per il recupero dei record dell'utente che fa upload record/song
     */
    public function getUserRecords() {
        try {
            global $controllers;
            if ($this->get_request_method() != "POST") {
                $this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['currentUser'])) {
                $this->response($controllers['USERNOSES'], 403);
            }
            $currentUser = $_SESSION['currentUser'];
            $recordBox = new RecordBox();
            $recordBox->initForUploadRecordPage($currentUser->getObjectId());
            $recordIdList = array();
            if (is_null($recordBox->error) && count($recordBox->recordArray) > 0) {
                foreach ($recordBox->recordArray as $record) {
                    $retObj = array();
                    $retObj["thumbnail"] = $this->getRecordThumbnailURL($currentUser->getObjectId(), $record->getThumbnailCover());
                    $retObj["title"] = $record->getTitle();
                    $retObj["songs"] = $record->getSongCounter();
                    $retObj["recordId"] = $record->getObjectId();
                    $recordIdList[] = $retObj;
                }
            }

            $this->response(array("status" => $controllers['GETRECORDSOK'], "recordList" => $recordIdList, "count" => count($recordIdList)), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	removeSongFromRecord($record, $songId)
     * \brief   funzione per la rimozione di una song da un record
     * param   $record, $songId
     */
    private function removeSongFromRecord($record, $song) {
        try {
            $currentUser = $_SESSION['currentUser'];
            require_once CLASSES_DIR . 'recordParse.class.php';
            $pRecord = new RecordParse();
            $recordId = $record->getObjectId();
//            $tracklist = $record->getTracklist();
//            if (is_null($tracklist) || !in_array($songId, $tracklist)) {
//                return false;
//            }
//            if (count($tracklist) == 0) {
//                return false;
//            }
            $res = $pRecord->updateField($recordId, 'tracklist', array($song->getObjectId()), true, 'remove', 'Song');
            if ($res instanceof Error) {
                return $res;
            }

            require_once CLASSES_DIR . 'activityParse.class.php';
            $resActivity = $this->createActivity($currentUser->getObjectId(), $recordId, "SONGREMOVEDFROMRECORD", $song->getObjectId());
            if ($resActivity instanceof Error) {
                return $resActivity;
            }
            //aggiorno il contatore del record
            $resDecrSongCounter = $pRecord->decrementRecord($recordId, "songCounter", 1);
            if ($resDecrSongCounter instanceof Error) {
                return $resDecrSongCounter;
            }
            //aggiorno la durata del record
            $resDecrDuration = $pRecord->decrementRecord($recordId, "duration", $song->getDuration());
            if ($resDecrDuration instanceof Error) {
                return $resDecrDuration;
            }
            return true;
        } catch (Exception $e) {
            $this->response(array('status' => $e->getMessage()), 503);
        }
    }

    /**
     * \fn	$userId, $recordId, $songId
     * \brief   funzione per il salvataggio di un mp3
     * param   $userId, $recordId, $songId
     */
    private function saveMp3($userId, $recordId, $songId) {
        if (file_exists(MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $songId)) {
            $dir = USERS_DIR . $userId . DIRECTORY_SEPARATOR . "songs" . DIRECTORY_SEPARATOR . $recordId;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (!is_null($userId) && !is_null($recordId) && !is_null($songId)) {
                $oldName = MEDIA_DIR . "cache" . DIRECTORY_SEPARATOR . $songId;
                $newName = $dir . DIRECTORY_SEPARATOR . $songId;
                return rename($oldName, $newName);
            }
        }
        else
            return false;
    }

}

?>