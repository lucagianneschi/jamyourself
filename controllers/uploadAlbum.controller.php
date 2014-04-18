<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'image.class.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

/**
 * UploadAlbumController class
 * si collega al form di upload di un album, effettua controlli, scrive su DB
 *
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 */
class UploadAlbumController extends REST {

    /**
     * inizializzazione della pagina
     */
    public function init() {
	if (!isset($_SESSION['id'])) {
	    header('Location: login.php?from=uploadAlbum.php');
	    exit;
	}
    }

    /**
     * funzione per pubblicazione dell'album
     */
    public function createAlbum() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "No POST action"');
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "No User in session"');
		$this->response($controllers['USERNOSES'], 400);
	    } elseif (!isset($this->request['albumTitle']) || is_null($this->request['albumTitle']) || !(strlen($this->request['albumTitle']) > 0)) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "No album title set"');
		$this->response(array('status' => $controllers['NOALBUMTITLE']), 400);
	    } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "No description title set"');
		$this->response(array('status' => $controllers['NOALBUMDESCRIPTION']), 400);
	    } elseif (!isset($this->request['images']) || is_null($this->request['images']) || !is_array($this->request['images']) || !(count($this->request['images']) > 0) || !$this->validateAlbumImages($this->request['images'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "Images Error"');
		$this->response(array('status' => $controllers['NOALBUMIMAGES']), 400);
	    }
	    $currentUserId = $_SESSION['id'];
	    $album = new Album();
	    $album->setActive(1);
	    $album->setCommentcounter(0);
	    $album->setCounter(0);
	    $album->setCover(DEFALBUMCOVER);
	    $album->setDescription($this->request['description']);
	    $album->setFromuser($currentUserId);
	    $album->setImagecounter(0);
	    if (isset($this->request['city']) && !is_null($this->request['city'])) {
		$infoLocation = GeocoderService::getCompleteLocationInfo($this->request['city']);
		$latitude = $infoLocation['latitude'];
		$longitude = $infoLocation['longitude'];
	    } else {
		$latitude = null;
		$longitude = null;
	    }
	    $album->setLovecounter(0);
	    $album->setLatitude($latitude);
	    $album->setLongitude($longitude);
	    $album->setSharecounter(0);
	    $album->setTag(array());
	    $album->setThumbnail(DEFALBUMTHUMB);
	    $album->setTitle($this->request['albumTitle']);
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $result = insertAlbum($connection, $album);
	    $albumId = $result;
	    $node = createNode($connectionService, 'album', $albumId);
	    $relation = createRelation($connectionService, 'user', $currentUserId, 'album', $albumId, 'CREATE');
	    if (isset($this->request['featuring']) && is_array($this->request['featuring']) && count($this->request['featuring']) > 0) {
		foreach ($this->request['featuring'] as $userId) {
		    $featuring = createRelation($connectionService, 'user', $userId, 'album', $result, 'FEATURE');
		    if ($featuring == false)
			$this->response(array('status' => $controllers['COMMENTERR']), 503);
		}
	    }
	    if ($result === false || $relation === false || $node === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "Unable to commit"');
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $errorImages = $this->saveImagesList($connection, $connectionService, $this->request['images'], $albumId, $currentUserId);
	    $imagesSaved = count($this->request['images']) - count($errorImages);
	    if ($imagesSaved > 0) {
		require_once SERVICES_DIR . 'update.service.php';
		$resUpdateCover = update($connection, 'album', array('updatedat' => date('Y-m-d H:i:s')), array('imagecounter' => $imagesSaved), null, $albumId, null);
		if ($resUpdateCover == false) {
		    $this->response(array('status' => $controllers['COMMENTERR']), 503);
		}
		else
		    $connection->commit();
	    }
	    $connectionService->disconnect($connection);
	    if (count($errorImages) == count($this->request['images'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] createAlbum  not executed');
		$this->response(array("status" => $controllers['ALBUMSAVENOIMGSAVED'], "id" => $albumId), 200);
	    } elseif (count($errorImages) > 0) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] createAlbum executed partially');
		$this->response(array("status" => $controllers['ALBUMSAVEDWITHERRORS'], "id" => $albumId), 200);
	    } else {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] createAlbum executed');
		$this->response(array("status" => $controllers['ALBUMSAVED'], "id" => $albumId), 200);
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during createAlbum "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * aggiorna l'album
     */
    public function updateAlbum() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during updateAlbum "No POST action"');
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 400);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during updateAlbum "No User in session"');
		$this->response($controllers['USERNOSES'], 400);
	    } elseif (!isset($this->request['albumId']) || is_null($this->request['albumId']) || !(strlen($this->request['albumId']) > 0)) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during updateAlbum "No album id"');
		$this->response(array('status' => $controllers['NOALBUMID']), 400);
	    } elseif (!isset($this->request['images']) || is_null($this->request['images']) || !is_array($this->request['images']) || !(count($this->request['images']) > 0) || !$this->validateAlbumImages($this->request['images'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during updateAlbum "Images error"');
		$this->response(array('status' => $controllers['NOALBUMIMAGES']), 400);
	    }
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during updateAlbum "Unable to connect"');
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $currentUserId = $_SESSION['id'];
	    $albumId = $this->request['albumId'];
	    $album = selectAlbums($connection, $albumId);
	    if ($album == false) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during updateAlbum "Unable to excecute selectAlbums"');
		$this->response(array('status' => $controllers['NOALBUMFOUNDED']), 405);
	    }
	    $errorImages = $this->saveImagesList($connection, $connectionService, $this->request['images'], $albumId, $currentUserId);
	    $imagesSaved = count($this->request['images']) - count($errorImages);
	    if ($imagesSaved > 0) {
		require_once SERVICES_DIR . 'update.service.php';
		$resUpdateCover = update($connection, 'album', array('updatedat' => date('Y-m-d H:i:s')), array('imagecounter' => $imagesSaved), null, $albumId, null);
		if ($resUpdateCover == false) {
		    $this->response(array('status' => $controllers['COMMENTERR']), 503);
		}
		else
		    $connection->commit();
	    }
	    $connectionService->disconnect($connection);
	    if (count($errorImages) == count($this->request['images'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] updateAlbum  not executed');
		$this->response(array("status" => $controllers['NOIMAGESAVED'], "id" => $albumId), 200);
	    } elseif (count($errorImages) > 0) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] updateAlbum executed partially');
		$this->response(array("status" => $controllers['IMAGESSAVEDWITHERRORS'], "id" => $albumId), 200);
	    } else {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] updateAlbum executed');
		$this->response(array("status" => $controllers['IMAGESSAVED'], "id" => $albumId), 200);
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during updateAlbum "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * recupera una lista di immagini, recupera ID e src
     */
    public function getImagesList() {
	$startTimer = microtime();
	global $controllers;
	try {
	    if ($this->get_request_method() != "POST") {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during getImagesList "No POST action"');
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during getImagesList "No user in session"');
		$this->response($controllers['USERNOSES'], 403);
	    } elseif (!isset($this->request['albumId']) || is_null($this->request['albumId']) || !(strlen($this->request['albumId']) > 0)) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during getImagesList "No album id selected"');
		$this->response(array("status" => $controllers['NOOBJECTID']), 403);
	    }
	    $albumId = $this->request['albumId'];
	    $imagesList = $this->getImagesByAlbumId($albumId);
	    if ($imagesList == null) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during getImagesList "unable to execute getImagesByAlbumId"');
		$this->response(array("status" => $controllers['nodata']), 200);
	    } elseif (is_null($imagesList) || count($imagesList) == 0) {
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during getImagesList "getImagesByAlbumId gave no images"');
		$this->response(array("status" => $controllers['NOIMAGEFORALBUM'], "imageList" => null, "count" => 0), 200);
	    }
	    $returnInfo = array();
	    foreach ($imagesList as $image) {
		$returnInfo[] = json_encode(array("id" => $image->getId(), "src" => $image->getPath()));
	    }
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] getImagesList executed');
	    $this->response(array("status" => $controllers['COUNTALBUMOK'], "imageList" => $returnInfo, "count" => count($imagesList)), 200);
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during getImagesList "Exception" => ' . $e->getMessage());
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * sposta il file dalla chace alla corretta cartella di destinazione
     * reperisco le info sull'immagine, Preparo l'oggetto per l'editing della foto, gestisco immagine
     * creo thumbnail,cancello il vecchio file dalla cache
     *
     * @param $userId
     * @param $albumId
     * @return $fileInCache
     */
    private function moveFile($userId, $albumId, $fileInCache) {
	if (file_exists(CACHE_DIR . $fileInCache)) {
	    if (!is_null($userId) && !is_null($albumId) && !is_null($fileInCache)) {
		list($width, $height, $type, $attr) = getimagesize(CACHE_DIR . $fileInCache);
		require_once SERVICES_DIR . 'cropImage.service.php';
		$cis = new CropImageService();
		$jpg = $cis->resizeImageFromSrc($fileInCache, $width);
		$thumbnail = $cis->resizeImageFromSrc($fileInCache, THUMBNAIL_IMG_SIZE);
		$fileManager = new FileManagerService();
		if (file_exists(CACHE_DIR . $jpg) && file_exists(CACHE_DIR . $thumbnail)) {
		    $res_1 = $fileManager->savePhoto($userId, $jpg);
		    $res_2 = $fileManager->savePhoto($userId, $thumbnail);
		    unlink(CACHE_DIR . $fileInCache);
		    unlink(CACHE_DIR . $jpg);
		    unlink(CACHE_DIR . $thumbnail);
		    if ($res_1 && $res_2) {
			return array("image" => $jpg, "thumbnail" => $thumbnail);
		    } else {
			return array("image" => DEFIMAGE, "thumbnail" => DEFIMAGETHUMB);
		    }
		}
		else
		    array("image" => DEFIMAGE, "thumbnail" => DEFIMAGETHUMB);
	    }
	} else {
	    return array("image" => DEFIMAGE, "thumbnail" => DEFIMAGETHUMB);
	}
    }

    /**
     * salva un'immagine
     *
     * @param $imgInfo
     * @param $albumId
     * @return $imageId or
     */
    private function saveImage($imgInfo, $albumId) {
	$startTimer = microtime();
	global $controllers;
	try {
	    $currentUserId = $_SESSION['id'];
	    $cachedFile = CACHE_DIR . $imgInfo['src'];
	    if (!file_exists($cachedFile)) {
		return null;
	    } else {
		$imgMoved = $this->moveFile($currentUserId, $albumId, $imgInfo['src']);
		$connectionService = new ConnectionService();
		$connection = $connectionService->connect();
		if ($connection === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during saveImage "Unable to connect"');
		    $this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
		}
		$connection->autocommit(false);
		$connectionService->autocommit(false);
		$image = new Image();
		$image->setActive(1);
		$image->setAlbum($albumId);
		$image->setCommentcounter(0);
		$image->setCounter(0);
		$image->setDescription($imgInfo['description']);
		$image->setPath($imgMoved['image']);
		$image->setFromuser($currentUserId);
		$image->setLatitude(null);
		$image->setLongitude(null);
		$image->setLovecounter(0);
		$image->setSharecounter(0);
		$image->setTag(array());
		$image->setThumbnail($imgMoved['thumbnail']);
		$result = insertImage($connection, $image);
		if ($result === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during saveImage "Unable to execute insertImage"');
		    $this->response(array('status' => $controllers['INSERT_ERROR']), 500);
		}
		$node = createNode($connectionService, 'image', $result);
		$relation = createRelation($connectionService, 'user', $currentUserId, 'image', $result, 'ADD');
		if (isset($imgInfo['featuring']) && is_array($imgInfo['featuring']) && count($imgInfo['featuring']) > 0) {
		    foreach ($imgInfo['featuring'] as $userId) {
			$featuring = createRelation($connectionService, 'user', $userId, 'image', $result, 'FEATURE');
			if ($featuring == false)
			    return false;
		    }
		}
		if ($result === false || $relation === false || $node === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during saveImage "Unable to execute graph database operations"');
		    return false;
		} else {
		    $connection->commit();
		    $connectionService->commit();
		}
		$connectionService->disconnect($connection);
		$endTimer = microtime();
		jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] saveImage executed');
		return $result;
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during saveImage "Exception" => ' . $e->getMessage());
	    return false;
	}
    }

    /**
     * sposta il file dalla chace alla corretta cartella di destinazione
     * reperisco le info sull'immagine, Preparo l'oggetto per l'editing della foto, gestisco immagine
     * creo thumbnail,cancello il vecchio file dalla cache
     *
     * @param $userId
     * @param $albumId
     * @return $fileInCache
     */
    private function saveImagesList($connection, $connectionService, $imagesList, $albumId) {
	$startTimer = microtime();
	$errorImages = array();
	global $controllers;
	if (!is_null($imagesList) && is_array($imagesList) && count($imagesList) > 0) {
	    foreach ($imagesList as $image) {
		$resImage = $this->saveImage($image, $albumId);
		if (!$resImage || is_null($resImage)) {
		    array_push($errorImages, $image);
		} else {
		    if ($image['isCover'] == "true") {
			//		$this->createAlbumCoverFiles($currentUser->getId(), $albumId, $resImage->getPath(), $resImage->getThumbnail());
			$connectionService = new ConnectionService();
			$connection = $connectionService->connect();
			if ($connection === false) {
			    $endTimer = microtime();
			    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during saveImagesList "Unable to connect"');
			    $this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
			}
			$connection->autocommit(false);
			$connectionService->autocommit(false);
			require_once SERVICES_DIR . 'update.service.php';
			$resUpdateCover = update($connection, 'album', array('updatedat' => date('Y-m-d H:i:s'), 'cover' => $resImage->getPath()), null, null, $albumId, null);
			$resUpdateThumb = update($connection, 'album', array('updatedat' => date('Y-m-d H:i:s'), 'thumbnail' => $resImage->getThumbnail()), null, null, $albumId, null);
			//	$node = createNode($connectionService, 'image', $resImage->getId());
			//	$relation = createRelation($connectionService, 'album', $albumId, 'image', $resImage->getId(), 'ADD');
			//	if (!$resUpdateCover || !$resUpdateThumb || !$node || !$relation) {
			if (!$resUpdateCover || !$resUpdateThumb) {
			    array_push($errorImages, $image);
			    continue;
			} else {
			    $connection->commit();
			    $connectionService->commit();
			}
		    }
		}
	    }
	}
	return $errorImages;
    }

    /**
     * Validazione dell'album in base alle info che sono obbligatorie dal form
     *
     * @param $imageList
     * @return true or false in case of error 
     */
    private function validateAlbumImages($imageList) {
	if (is_array($imageList) && count($imageList) > 0) {
	    foreach ($imageList as $elem) {
		if (!isset($elem["description"]) || is_null($elem["description"])) {
		    return false;
		}
		if (!isset($elem["src"]) || is_null($elem["src"]) || !( strlen($elem["src"]) > 0)) {
		    return false;
		}
		if (!isset($elem["isCover"]) || is_null($elem["isCover"]) || !(strlen($elem["isCover"]) > 0)) {
		    return false;
		}
	    }
	}
	return true;
    }

}

?>