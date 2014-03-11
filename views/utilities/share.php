<?php

/* ! \par		Info Generali:
 * @author		Daniele Caldelli
 * @version		1.0
 * @since		2013
 * @copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		define the share parameters
 */

/**
 * \fn		getShareParameters($classType, $id, $imgPath)
 * \brief	define the share parameters
 * @param	$classType:	the type of the Parse class
 * 			$id:	the id of the object of the $classType
 * 			$imgPath:	the path of the image to share in case that $classType is Event, Image, Record and Song
 */
function getShareParameters($classType, $id, $imgPath) {

    $parameters = array();

    switch ($classType) {
	case 'Album':
	    #TODO
	    /*
	      $parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
	      $parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
	      $parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
	      $parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
	     */
	    break;
	case 'AlbumReview':
	    #TODO
	    /*
	      $parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
	      $parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
	      $parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
	      $parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
	     */
	    break;
	case 'Event':
	    $parameters['title'] = 'Titolo di un Event';
	    $parameters['description'] = 'Descrizione della pagina di Event';
	    $parameters['url'] = 'http://www.socialmusicdiscovering.com/views/mediaEvent.php?objectIdMedia=' . $id;
	    #TODO
	    //$parameters['img'] = <settare il valore corretto dell'immagine dell'evento>
	    $parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultBackground.png';
	    break;
	case 'EventReview':
	    #TODO
	    /*
	      $parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
	      $parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
	      $parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
	      $parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
	     */
	    break;
	case 'Image':
	    $parameters['title'] = 'Titolo di una Image';
	    $parameters['description'] = 'Descrizione di una Image';
	    #TODO
	    //$parameters['url'] = 'http://www.socialmusicdiscovering.com/media/images/image/' . $imgPath;
	    $parameters['url'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultImage.jpg';
	    //$parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/image/' . $imgPath;
	    $parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultImage.jpg';
	    break;
	case 'Record':
	    $parameters['title'] = 'Titolo di un Record';
	    $parameters['description'] = 'Descrizione della pagina di Record';
	    $parameters['url'] = 'http://www.socialmusicdiscovering.com/views/mediaRecord.php?objectIdMedia=' . $id;
	    #TODO
	    //$parameters['img'] = <settare il valore corretto dell'immagine del record>
	    $parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultBackground.png';
	    break;
	case 'Song':
	    $parameters['title'] = 'Titolo di un Song';
	    $parameters['description'] = 'Descrizione della pagina di Song';
	    $parameters['url'] = 'http://www.socialmusicdiscovering.com/views/mediaRecord.php?objectIdMedia=' . $id;
	    #TODO
	    //$parameters['img'] = <settare il valore corretto dell'immagine della song>
	    $parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultBackground.png';
	    break;
    }

    return $parameters;
}

?>