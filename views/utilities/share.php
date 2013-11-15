<?php
function getShareParameters($classType, $objectId, $imgPath) {
	
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
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/views/mediaEvent.php?objectIdMedia=' . $objectId;
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
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/views/mediaRecord.php?objectIdMedia=' . $objectId;
			#TODO
			//$parameters['img'] = <settare il valore corretto dell'immagine del record>
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultBackground.png';
		break;
		case 'Song':
			$parameters['title'] = 'Titolo di un Song';
			$parameters['description'] = 'Descrizione della pagina di Song';
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/views/mediaRecord.php?objectIdMedia=' . $objectId;
			#TODO
			//$parameters['img'] = <settare il valore corretto dell'immagine della song>
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultBackground.png';
		break;
	}
	
	return $parameters;
}
?>