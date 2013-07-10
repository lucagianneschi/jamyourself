<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		Box Album
 * \details		Box per mostrare gli ultimi album inseriti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';

$id = '7fes1RyY77';
echo '<br />----------------------BOX------------ALBUM------FOTO---------------------------<br />';
$album = new AlbumParse();
$album->wherePointer('fromUser', '_User', $id);
$album->setLimit(4);
$album->orderByDescending('updatedAt');
$resGets = $album->getAlbums();
if ($resGets != 0) {
    if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
    } else {
	foreach ($resGets as $album) {
            echo '<br />[thumbnailCover] => ' . $album->getThumbnailCover() . '<br />';
	    echo '<br />[title] => ' . $album->getTitle() . '<br />';
	    echo '<br />[loveCounter] => ' . $album->getLoveCounter() . '<br />';
	    echo '<br />[commentCounter] => ' . $album->getCommentCounter() . '<br />';
	    echo '<br />[shareCounter] => ' . $album->getShareCounter() . '<br />';
	}
    }
}
echo '<br />----------------FINE------BOX------------FOTO---------------------------------<br />';
?>
