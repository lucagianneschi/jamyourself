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
 * \todo		Fare API su Wiki
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once CLASSES_DIR . 'user.class.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once CLASSES_DIR . 'song.class.php';
require_once BOXES_DIR . "record.box.php";
require_once SERVICES_DIR . 'mp3.service.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'utils.service.php';

/**
 * \brief	UploadRecordController class 
 * \details	controller di upload record
 */
class UploadRecordController extends REST {

    public $viewRecordList;
    private $connection;

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
    }

    /**
     * \fn	createRecord($record)
     * \brief   funzione per pubblicazione del record
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
            $userId = $user->getId();
            $record = new Record();
            $record->setActive(true);
            $record->setBuyLink((strlen($newRecord->urlBuy) ? $newRecord->urlBuy : null));
            $record->setCounter(0);
            require_once CONTROLLERS_DIR . "utilsController.php";
            $imgInfo = getCroppedImages($newRecord);
            $record->setCover($imgInfo['picture']);
            $record->setThumbnail($imgInfo['thumbnail']);
            $record->setSongcounter(0);
            $record->setDescription($newRecord->description);
            $record->setDuration(0);
            if (isset($newRecord->albumFeaturing) && !is_null($newRecord->albumFeaturing) && count($newRecord->albumFeaturing) > 0)
                $record->setFeaturing($newRecord->albumFeaturing);
            $record->setFromuser($userId);
            $record->setGenre($this->getTags($newRecord->tags));
            $record->setLabel($newRecord->label);
            $infoLocation = GeocoderService::getCompleteLocationInfo($newRecord->city);
            $record->setLatitude($infoLocation["latitude"]);
            $record->setLongitude($infoLocation["longitude"]);
            $record->setCity($infoLocation['city']);
            $record->setLovecounter(0);
            $record->setLovers(array());
            $record->setReviewcounter(0);
            $record->setSharecounter(0);
            $record->setTitle($newRecord->recordTitle);
            $record->setYear($newRecord->year);

            //SPOSTO LE IMMAGINI NELLE RISPETTIVE CARTELLE         
            $filemanager = new FileManagerService();
            $res_image = $filemanager->saveRecordPhoto($userId, $record->getCover());
            $res_thumb = $filemanager->saveRecordPhoto($userId, $record->getThumbnail());
            if (!$res_image || !$res_thumb) {
                $this->response(array("status" => $controllers['RECORDCREATEERROR']), 503);
            }

            $result = $this->saveRecord($record); //non funziona perché non mi rende nessun id o record...
            if ($result == false) {
                $this->response(array("status" => $controllers['RECORDCREATEERROR']), 503);
            }

            unset($_SESSION['currentUserFeaturingArray']);

//@TODO SALVARE IL NODO COME LA VECCHIA ACTIVITY

            return $result;
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
                $recordId = $record->getId();
            } elseif (isset($this->request['recordId'])) {
                $recordId = $this->request['recordId'];
            }

            $currentUser = $_SESSION['currentUser'];
            $songList = $this->request['list'];
            if (is_null($record)) {
                $record = $this->getRecord($recordId);
            }

            if ($record instanceof Error) {
                $this->response(array('status' => $controllers['NORECORD']), 204);
            }
            $position = $record->getSongCounter();
            $songErrorList = array(); //lista canzoni non caricate
            $songSavedList = array(); //lista canzoni salvate correttamente
            if (count($songList) > 0) {
                foreach ($songList as $songIstance) {
                    $element = json_decode(json_encode($songIstance), false);
                    $cachedFile = CACHE_DIR . $element->src;
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
                        $song->setPath($element->src);
                        $song->setFromuser($currentUser->getId());
                        $song->setGenre($element->tags);
                        $song->setLocation(null);
                        $song->setLovers(array());
                        $song->setLovecounter(0);
                        $position++;
                        $song->setPosition($position);
                        $song->setRecord($recordId);
                        $song->setCounter(0);
                        $song->setSharecounter(0);
                        $song->setTitle($element->title);
                        $result = $this->saveSong($song);
                        if ($result == false) {
                            //errore
                            $songErrorList[] = $element;
                            //decremento il contatore
                            $position--;
                            //cancello l'mp3 dalla cache
                            unlink(CACHE_DIR . $element->src);
                        } else {
                            
                            $fileManager = new FileManagerService();
                            
                            if ($fileManager->saveSong($currentUser->getId(), $song->getPath()) == false) {
                                //@TODO : GESTIRE LA CALLBACK SE SERVONO ANCORA
                                //require_once CONTROLLERS_DIR . 'rollBackUtils.php';
                                //rollbackUploadRecordController($savedSong->getId(), "Song");
                                $songErrorList[] = $element;
                                $position--;
                            } else {
                                //aggiungo il songId alla lista degli elementi salvati
                                #TODO: ggiungere relazione tra record e song
                                $resAddRelation = false;
                                if ($resAddRelation == false) {
                                    //errore creazione relazione fra record e song
                                    $songErrorList[] = $element;
                                    $position--;
                                } else {
                                    //tutto bene
                                    $element->id = $savedSong->getId();
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
                $this->response(array("status" => $controllers['ALLSONGSSAVED'], "errorList" => null, "savedList" => $songSavedList, "id" => $recordId), 200);
            } else {
                foreach ($songErrorList as $toRemove) {
                    $this->deleteMp3FromCache($toRemove->src);
                }
                if (count($songSavedList) == 0) {
                    //nessuna canzone salvata => tutti errori  
                    $this->response(array("status" => $controllers['NOSONGSAVED'], "id" => $recordId), 200);
                } else {
                    //salvate parzialmente, qualche errore
                    $this->response(array("status" => $controllers['SONGSAVEDWITHERROR'], "errorList" => $songErrorList, "savedList" => $songSavedList, "id" => $recordId), 200);
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
     * \fn	addSongToRecord($record, $songId)
     * \brief   funzione per aggiunta song a record esistente
     * \param   $record, instance of record.class e songId
     */
    private function addSongToRecord($record, $song) {
        try {
            $currentUser = $_SESSION['currentUser'];

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
     * \fn	deleteMp3($userId,  $songId)
     * \brief   funzione per cancellazione mp3 dalla cache
     * \param   $userId, $recordId, $songId
     */
    private function deleteMp3FromCache($songId) {
        if (file_exists(CACHE_DIR . $songId)) {
            unlink(CACHE_DIR . $songId);
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
            $recordIdList = $this->getRecordsByUserId($currentUser->getId());
            $fileManager = new FileManagerService();
            if (!is_null($recordIdList) && count($recordIdList) > 0) {
                foreach ($recordIdList as $record) {
                    $retObj = array();
                    $retObj["thumbnail"] = $fileManager->getRecordPhotoURL($currentUser->getId(), $record->getThumbnail());
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
     * \fn	removeSongFromRecord($record, $songId)
     * \brief   funzione per la rimozione di una song da un record
     * \param   $record, $songId
     */
    private function removeSongFromRecord($record, $song) {
        try {
            $currentUser = $_SESSION['currentUser'];
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
     * \fn	saveSong()
     * \brief   funzione privata per il salvataggio nel DB di un commento
     * \param   $song
     */
    private function saveSong($song) {
        require_once SERVICES_DIR . 'connection.service.php';
        $connectionService = new ConnectionService();
        $connection = $connectionService->connect();

        if ($connection != false) {
            require_once SERVICES_DIR . 'insert.service.php';
            $result = insertSong($connection, $song);
            $connectionService->disconnect();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * \fn	getSong()
     * \brief   funzione privata per il recupero della song dal DB
     * \param   $songId
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
     * \fn	getSongsByRecordId()
     * \brief   funzione privata per il recupero della lista di song del record dal DB
     * \param   $recordId
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
     * \fn	getRecord()
     * \brief   funzione privata per il recupero del record dal DB
     * \param   $recordId
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

    /**
     * \fn	saveRecord()
     * \brief   funzione privata per il salvataggio nel DB di un record
     * \param   $record
     */
    private function saveRecord($record) {
        require_once SERVICES_DIR . 'connection.service.php';
        $connectionService = new ConnectionService();
        $connection = $connectionService->connect();

        if ($connection != false) {
            require_once SERVICES_DIR . 'insert.service.php';
            $result = insertRecord($connection, $record);
            $connectionService->disconnect();
            return $result;
        } else {
            return false;
        }
    }

}

?>