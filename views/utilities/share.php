<?php
function getShareParameters($classType) {
	
	$parameters = array();
	
	switch ($classType) {
		case 'Album':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
		break;
		case 'AlbumReview':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
		break;
		case 'Event':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
		break;
		case 'EventReview':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
		break;
		case 'Image':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
		break;
		case 'Record':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
		break;
		case 'Song':
			$parameters['title'] = 'Titolo della pagina da condividere: ' . $classType;
			$parameters['description'] = 'Descrizione della pagina da condividere ' . $classType;
			$parameters['url'] = 'http://www.socialmusicdiscovering.com/?classType=' . $classType;
		break;
	}
	
	return $parameters;
}
?>