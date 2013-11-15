<?php
function getShareParameters($classType, $imgPath) {
	
	$parameters = array();
	
	switch ($classType) {
		case 'Album':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
		break;
		case 'AlbumReview':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
		break;
		case 'Event':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
		break;
		case 'EventReview':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
		break;
		case 'Image':
			$parameters['title'] = 'Titolo di una Image';
			$parameters['description'] = 'Descrizione di una Image';
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
			#TODO
			//$parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/image/' . $imgPath;
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/media/images/default/defaultImage.jpg';
		break;
		case 'Record':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
		break;
		case 'Song':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
			$parameters['img'] = 'http://www.socialmusicdiscovering.com/views/resources/images/logo.png';
		break;
	}
	
	return $parameters;
}
?>