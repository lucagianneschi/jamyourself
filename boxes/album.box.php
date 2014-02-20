<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info album
 * \details		Recupera le informazioni dell'album, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

/**
 * \brief	AlbumBox class 
 * \details	box class to pass info to the view 
 */
class AlbumBox {

    public $albumArray = array();
    public $error = null;
    public $imageArray = array();

    /**
     * \fn	init($id, $limit = 3, $skip = 0, $upload = false)
     * \brief	Init AlbumBox instance for Personal Page or UploadPage
     * \param	$id for user that owns the page, $limit, $skip, $upload
     * \todo    inserire orderby
     */
    public function init($id, $limit = 3, $skip = 0, $upload = false) {
	if ($upload == true) {
	    require_once SERVICES_DIR . 'utils.service.php';
	    $currentUserId = sessionChecker();
	    if (is_null($currentUserId)) {
		$this->error = ONLYIFLOGGEDIN;
		return;
	    }
	}
	$albums = selectAlbums(null, array('fromuser' => $id), array('createdat' => 'DESC'), $limit, $skip);
	if ($albums instanceof Error) {
	    $this->error = $albums->getErrorMessage();
	}
	$this->albumArray = $albums;
    }

    /**
     * \fn	initForDetail($id $limit - optional, $skip - optional)
     * \brief	Init AlbumBox instance for Personal Page, detailed view
     * \param	$id of the album to display information,$limit, $skip
     * \todo    inserire orderby
     */
    public function initForDetail($id, $limit = 15, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT id,
                           active,
                           album,
                           commentcounter,
                           counter,
                           description,
                           fromuser,
                           latitude,
                           longitude,
                           lovecounter,
                           path,
                           sharecounter,
                           thumbnail,
                           createdat,
                           updatedat
                      FROM image
                     WHERE album = " . $id . "
                  ORDER BY created DESC
                     LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row_image = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows_image[] = $row_image;
	    $images = array();
	    foreach ($rows_image as $row_image) {
		require_once 'image.class.php';
		$image = new Image();
		$image->setId($row_image['id']);
		$image->setActive($row_image['active']);
		$image->setAlbum($row_image['album']);
		$image->setCommentcounter($row_image['commentcounter']);
		$image->setCounter($row_image['counter']);
		$image->setDescription($row_image['description']);
		$image->setFromuser($row_image['fromuser']);
		$image->setImagecounter($row_image['imagecounter']);
		$image->setLatitude($row_image['latitude']);
		$image->setLongitude($row_image['longitude']);
		$image->setLovecounter($row_image['lovecounter']);
		$image->getPath($row_image['path']);
		$image->setSharecounter($row_image['sharecounter']);
		$sql = "SELECT tag
                          FROM image_tag
                         WHERE id = " . $row_image['id'];
		$results = mysqli_query($connectionService->connection, $sql);
		while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
		    $rows_tag[] = $row_tag;
		$tags = array();
		foreach ($rows_tag as $row_tag) {
		    $tags[] = $row_tag;
		}
		$image->setTag($row_tag);
		$image->setThumbnail($row_image['thumbnail']);
		$image->setCreatedat($row_image['createdat']);
		$image->setUpdatedat($row_image['updatedat']);
		$images[$row_image['id']] = $image;
	    }
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->imageArray = $images;
	    }
	}
    }

}

?>