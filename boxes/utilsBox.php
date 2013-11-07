<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		file utilities box 
 * \details		file utilities box
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

/**
 * \brief	Counters class 
 * \details	counters shared beetwen many boxes 
 */
class Counters {

    public $commentCounter;
    public $loveCounter;
    public $reviewCounter;
    public $shareCounter;

    /**
     * \fn	__construct($commentCounter, $loveCounter,$reviewCounter, $shareCounter)
     * \brief	construct for the Counter class
     * \param	$commentCounter, $loveCounter,$reviewCounter, $shareCounter
     */
    function __construct($commentCounter, $loveCounter, $reviewCounter, $shareCounter) {
        is_null($commentCounter) ? $this->commentCounter = 0 : $this->commentCounter = $commentCounter;
        is_null($loveCounter) ? $this->loveCounter = 0 : $this->loveCounter = $loveCounter;
        is_null($reviewCounter) ? $this->reviewCounter = 0 : $this->reviewCounter = $reviewCounter;
        is_null($shareCounter) ? $this->shareCounter = 0 : $this->shareCounter = $shareCounter;
    }

}

/**
 * \brief	UserInfo class 
 * \details	user info to be displayed in thumbnail view over all the website 
 */
class UserInfo {

    public $objectId;
    public $thumbnail;
    public $type;
    public $username;

    /**
     * \fn	__construct($objectId, $thumbnail, $type, $username)
     * \brief	construct for the UserInfo class
     * \param	$objectId, $thumbnail, $type, $username
     */
    function __construct($objectId, $thumbnail, $type, $username) {
        require_once SERVICES_DIR . 'lang.service.php';
        require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
        global $boxes;
        global $default_img;
        is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
        is_null($thumbnail) ? $this->thumbnail = $default_img['DEFAVATARTHUMB'] : $this->thumbnail = $thumbnail;
        is_null($type) ? $this->type = $boxes['NODATA'] : $this->type = $type;
        is_null($username) ? $this->username = $boxes['NODATA'] : $this->username = $username;
    }

}

/**
 * \fn		string parse_decode_string($string)
 * \brief	The function returns a string read from Parse that can be interpreted by the user
 * \param	$string 	represent the string from Parse to decode
 * \return	string		the decoded string
 */
function parse_decode_string($string) {
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    $decodedString = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    return $decodedString;
}

/**
 * \fn		sessionChecher()
 * \brief	The function returns a string wiht the objectId of the user in session, if there's no user return a invalid ID used (valid for the code)
 * \return	string $currentUserId;
 */
function sessionChecher() {
    require_once SERVICES_DIR . 'lang.service.php';
    require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
    require_once CLASSES_DIR . 'userParse.class.php';
    global $boxes;
    $currentUserId = $boxes['NOID'];
    session_start();
    if (isset($_SESSION['currentUser'])) {
        $currentUser = $_SESSION['currentUser'];
        $currentUserId = $currentUser->getObjectId();
        echo 'OK SESSION';
    }
    echo 'KO SESSION';
    return $currentUserId;
}

?>