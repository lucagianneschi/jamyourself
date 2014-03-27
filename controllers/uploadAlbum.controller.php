<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'album.class.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'insert.service.php';

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
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response($controllers['USERNOSES'], 402);
	    } elseif (!isset($this->request['albumTitle']) || is_null($this->request['albumTitle']) || !(strlen($this->request['albumTitle']) > 0)) {
		$this->response(array('status' => $controllers['NOALBUMTITLE']), 403);
	    } elseif (!isset($this->request['description']) || is_null($this->request['description']) || !(strlen($this->request['description']) > 0)) {
		$this->response(array('status' => $controllers['NOALBUMDESCRIPTION']), 404);
	    } elseif (!isset($this->request['images']) || is_null($this->request['images']) || !is_array($this->request['images']) || !(count($this->request['images']) > 0) || !$this->validateAlbumImages($this->request['images'])) {
		$this->response(array('status' => $controllers['NOALBUMIMAGES']), 406);
	    }
	    $currentUserId = $_SESSION['id'];
	    $album = new Album();
	    $album->setActive(1);
	    $album->setCommentcounter(0);
	    $album->setCounter(0);
	    $album->setCover(DEFALBUMCOVER);
	    $album->setDescription($this->request['description']);
	    if (isset($this->request['featuring']) && is_array($this->request['featuring']) && count($this->request['featuring']) > 0) {
		$album->setFeaturing($this->request['featuring']);
	    }
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
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $result = insertAlbum($connection, $album);
	    $albumId = $result;
	    $node = createNode($connectionService, 'album', $albumId);
	    $relation = createRelation($connectionService, 'user', $currentUserId, 'album', $albumId, 'ADD');
	    if ($result === false || $relation === false || $node === false) {
		$this->response(array('status' => $controllers['COMMENTERR']), 503);
	    } else {
		$connection->commit();
		$connectionService->commit();
	    }
	    $connectionService->disconnect($connection);
	    $errorImages = $this->saveImagesList($connection, $connectionService, $this->request['images'], $albumId, $currentUserId);
	    if (count($errorImages) == count($this->request['images'])) {
		$this->response(array("status" => $controllers['ALBUMSAVENOIMGSAVED'], "id" => $albumId), 200);
	    } elseif (count($errorImages) > 0) {
		$this->response(array("status" => $controllers['ALBUMSAVEDWITHERRORS'], "id" => $albumId), 200);
	    } else {
		$this->response(array("status" => $controllers['ALBUMSAVED'], "id" => $albumId), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    /**
     * aggiorna l'album
     */
    public function updateAlbum() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response($controllers['USERNOSES'], 402);
	    } elseif (!isset($this->request['albumId']) || is_null($this->request['albumId']) || !(strlen($this->request['albumId']) > 0)) {
		$this->response(array('status' => $controllers['NOALBUMID']), 403);
	    } elseif (!isset($this->request['images']) || is_null($this->request['images']) || !is_array($this->request['images']) || !(count($this->request['images']) > 0) || !$this->validateAlbumImages($this->request['images'])) {
		$this->response(array('status' => $controllers['NOALBUMIMAGES']), 404);
	    }
	    $connectionService = new ConnectionService();
	    $connection = $connectionService->connect();
	    if ($connection === false) {
		$this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
	    }
	    $connection->autocommit(false);
	    $connectionService->autocommit(false);
	    $currentUserId = $_SESSION['id'];
	    $albumId = $this->request['albumId'];
	    $album = selectAlbums($connection, $albumId);
	    if ($album == false) {
		$this->response(array('status' => $controllers['NOALBUMFOUNDED']), 405);
	    }
	    $errorImages = $this->saveImagesList($connection, $connectionService, $this->request['images'], $albumId, $currentUserId);
	    $connectionService->disconnect($connection);
	    if (count($errorImages) == count($this->request['images'])) {
		$this->response(array("status" => $controllers['NOIMAGESAVED'], "id" => $albumId), 200);
	    } elseif (count($errorImages) > 0) {
		$this->response(array("status" => $controllers['IMAGESSAVEDWITHERRORS'], "id" => $albumId), 200);
	    } else {
		$this->response(array("status" => $controllers['IMAGESSAVED'], "id" => $albumId), 200);
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 500);
	}
    }

    public function getAlbums() {
	global $controllers;
	if ($this->get_request_method() != "POST") {
	    $this->response(array("status" => $controllers['NOPOSTREQUEST']), 401);
	} elseif (!isset($_SESSION['id'])) {
	    $this->response($controllers['USERNOSES'], 402);
	}
	require_once BOXES_DIR . "album.box.php";
	$albumBox = new AlbumBox();
	$albumBox->init($_SESSION['id'], $limit = 10);
	$albumList = array();
	if (is_null($albumBox->error) && count($albumBox->albumArray) > 0) {
	    foreach ($albumBox->albumArray as $album) {
		$retObj = array();
		$retObj["thumbnail"] = $this->getAlbumThumbnailURL(sessionChecker(), $album->getThumbnail());
		$retObj["title"] = $album->getTitle();
		$retObj["images"] = $album->getImagecounter();
		$retObj["albumId"] = $album->getId();
		$albumList[] = $retObj;
	    }
	}

	$this->response(array("status" => $controllers['GETALBUMSSOK'], "albumList" => $albumList, "count" => count($albumList)), 200);
    }

    private function getAlbumThumbnailURL($userId, $albumCoverThumb) {
	try {
	    if (!is_null($albumCoverThumb) && strlen($albumCoverThumb) > 0 && !is_null($userId) && strlen($userId) > 0) {
		$fileManager = new FileManagerService();
		$path = $fileManager->getPhotoPath($userId, $albumCoverThumb);
		if (!file_exists($path)) {
		    return DEFALBUMTHUMB;
		}
	    } else {
		return DEFALBUMTHUMB;
	    }
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    /**
     * recupera una lista di immagini
     */
    public function getImagesList() {
	try {
	    global $controllers;
	    if ($this->get_request_method() != "POST") {
		$this->response(array("status" => $controllers['NOPOSTREQUEST']), 405);
	    } elseif (!isset($_SESSION['id'])) {
		$this->response($controllers['USERNOSES'], 403);
	    } elseif (!isset($this->request['albumId']) || is_null($this->request['albumId']) || !(strlen($this->request['albumId']) > 0)) {
		$this->response(array("status" => $controllers['NOOBJECTID']), 403);
	    }
	    $albumId = $this->request['albumId'];
	    $imagesList = $this->getImagesByAlbumId($albumId);
	    if ($imagesList == null) {
		$this->response(array("status" => $controllers['nodata']), 200);
	    } elseif (is_null($imagesList) || count($imagesList) == 0) {
		$this->response(array("status" => $controllers['NOIMAGEFORALBUM'], "imageList" => null, "count" => 0), 200);
	    }
	    $returnInfo = array();
	    foreach ($imagesList as $image) {
		// info utili
		// mi serve: id, src,
		$returnInfo[] = json_encode(array("id" => $image->getId(), "src" => $image->getPath()));
	    }
	    $this->response(array("status" => $controllers['COUNTALBUMOK'], "imageList" => $returnInfo, "count" => count($imagesList)), 200);
	} catch (Exception $e) {
	    $this->response(array('status' => $e->getMessage()), 503);
	}
    }

    private function moveFile($userId, $albumId, $fileInCache) {
	if (file_exists(CACHE_DIR . $fileInCache)) {
	    if (!is_null($userId) && !is_null($albumId) && !is_null($fileInCache)) {
		list($width, $height, $type, $attr) = getimagesize(CACHE_DIR . $fileInCache);
		require_once SERVICES_DIR . 'cropImage.service.php';
		$cis = new CropImageService();
		$jpg = $cis->resizeImageFromSrc($fileInCache, $width);
		$fileManager = new FileManagerService();
		$destName = $fileManager->getPhotoPath($userId, $fileInCache) . $jpg;
		$res_1 = rename(CACHE_DIR . $jpg, $destName);
		$thumbnail = $cis->resizeImageFromSrc($fileInCache, THUMBNAIL_IMG_SIZE);
		$destName = $fileManager->getPhotoPath($userId, $fileInCache) . $thumbnail;
		$res_2 = rename(CACHE_DIR . $thumbnail, $destName);
		unlink(CACHE_DIR . $fileInCache);
		if ($res_1 && $res_2) {
		    return array("image" => $jpg, "thumbnail" => $thumbnail);
		} else {
		    return array("image" => DEFIMAGE, "thumbnail" => DEFIMAGETHUMB);
		}
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
	try {
	    global $controllers;
	    $currentUserId = $_SESSION['id'];
	    $cachedFile = CACHE_DIR . $imgInfo['src'];
	    if (!file_exists($cachedFile)) {
		return null;
	    } else {
		$imgMoved = $this->moveFile($currentUserId, $albumId, $imgInfo['src']);
		$connectionService = new ConnectionService();
		$connection = $connectionService->connect();
		if ($connection === false) {
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
		if (isset($imgInfo['featuring']) && is_array($imgInfo['featuring']) && count($imgInfo['featuring']) > 0) {
		    $image->setFeaturing($imgInfo['featuring']);
		} else {
		    $image->setFeaturing(null);
		}
		$image->setPath($imgMoved['image']);
		$image->setFromuser($currentUserId);
		$image->setLatitude(null);
		$image->setLongitude(null);
		$image->setLovecounter(0);
		$image->setLovers(array());
		$image->setSharecounter(0);
		$image->setTag(array());
		$image->setThumbnail($imgMoved['thumbnail']);
		$result = insertImage($connection, $image);
		$node = createNode($connectionService, 'image', $result->getId());
		$relation = createRelation($connectionService, 'user', $currentUserId, 'image', $result->getId(), 'ADD');
		if ($result === false || $relation === false || $node === false) {
		    return false;
		} else {
		    $connection->commit();
		    $connectionService->commit();
		}
		$connectionService->disconnect($connection);
		return $result;
	    }
	} catch (Exception $e) {
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
    private function saveImagesList($connection, $connectionService, $imagesList, $albumId, $currentUser) {
	$errorImages = array();
	global $controllers;
	if (!is_null($imagesList) && is_array($imagesList) && count($imagesList) > 0) {
	    foreach ($imagesList as $image) {
		$resImage = $this->saveImage($image, $albumId);
		if (!$resImage || is_null($resImage)) {
		    array_push($errorImages, $image);
		} else {
		    if ($image['isCover'] == "true") {
			$this->createAlbumCoverFiles($currentUser->getId(), $albumId, $resImage->getPath(), $resImage->getThumbnail());
			$connectionService = new ConnectionService();
			$connection = $connectionService->connect();
			if ($connection === false) {
			    $this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
			}
			$connection->autocommit(false);
			$connectionService->autocommit(false);
			$resUpdateCover = update($connection, 'album', array('updatedat' => date('Y-m-d H:i:s')), null, null, $albumId, array('cover' => $resImage->getPath()));
			$resUpdateThumb = update($connection, 'album', array('updatedat' => date('Y-m-d H:i:s')), null, null, $albumId, array('cover' => $resImage->getThumbnail()));
			$node = createNode($connectionService, 'image', $resImage->getId());
			$relation = createRelation($connectionService, 'album', $albumId, 'image', $resImage->getId(), 'ADD');
			if (!$resUpdateCover || !$resUpdateThumb || !$node || $relation) {
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

    private function validateAlbumImages($imageList) {
	if (is_array($imageList) && count($imageList) > 0) {
	    foreach ($imageList as $elem) {
		if (!isset($elem["description"]) || is_null($elem["description"])) {
		    return false;
		}
		if (!isset($elem["src"]) || is_null($elem["src"]) || !( strlen($elem["src"]) > 0)) {
		    return false;
		}
// featuring non obbligatori
//                if (!isset($elem["featuring"]) || is_null($elem["featuring"]) || !is_array($elem["featuring"])) {
//                    return false;
//                }
		if (!isset($elem["isCover"]) || is_null($elem["isCover"]) || !(strlen($elem["isCover"]) > 0)) {
		    return false;
		}
	    }
	}
	return true;
    }

}

?>