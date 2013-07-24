<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
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
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';

class albumBox {

    public function sendInfo($objectId) {
	$resultArray = array();
	$album = new AlbumParse();
	$album->wherePointer('fromUser', '_User', $objectId);
	$album->where('active', true);
	$album->setLimit(1000);
	$album->orderByDescending('createdAt');
	$albums = $album->getAlbums();
	if (count($albums) != 0) {
	    if (get_class($albums) == 'Error') {
		echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $albums->getErrorMessage() . '<br/>';
	    } else {
		foreach ($albums as $album) {
		    $thumbnailCover = $album->getThumbnailCover();
		    $title = $album->getTitle();
		    $imageCounter = $album->getImageCounter();
		    $loveCounter = $album->getLoveCounter();
		    $commentCounter = $album->getCommentCounter();
		    $shareCounter = $album->getShareCounter();
		    $albumInfo = array('thumbnailCover' => $thumbnailCover,
			'title' => $title,
			'imageCounter' => $imageCounter,
			'loveCounter' => $loveCounter,
			'commentCounter' => $commentCounter,
			'shareCounter' => $shareCounter);
		    array_push($resultArray, $albumInfo);
		}
	    }
	    return $resultArray;
	}
    }
}

?>
