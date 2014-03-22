<?php/** * Funzione per determinare la lingua da visualizzare *  * author Daniele Caldelli * @version		0.2 * @since		2014-03-14 * @copyright		Jamyourself.com 2013	 * @warning * @bug * @todo  * @link               http://msdn.microsoft.com/en-us/library/windows/desktop/dd318693(v=vs.85).aspx * @return string language to display           */function getLanguage() {    $langAccepted = array('en', 'it', 'fr', 'de', 'es');    $lang = 'en';    if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {	$langBrowser = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);	if (in_array($langBrowser, $langAccepted)) {	    $lang = $langBrowser;	}    } else {	$settings = $_SESSION['settings'];	$langUser = strtolower($settings[0]);	if (in_array($langUser, $langAccepted)) {	    $lang = $langUser;	}    }    switch ($lang) {	case 'it':	    setlocale(LC_TIME, 'it_IT.utf8');	    break;	default:	    setlocale(LC_TIME, 'en_EN.utf8');	    break;    }    return $lang;}?>