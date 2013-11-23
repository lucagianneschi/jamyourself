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
 * \brief	PostInfo class 
 * \details	contains info for post to be displayed 
 */
class PostInfo {

    public $counters;
    public $createdAt;
    public $fromUserInfo;
    public $objectId;
    public $showLove;
    public $text;

    /**
     * \fn	__construct($counters, $createdAt, $fromUserInfo, $objectId, $showLove, $text)
     * \brief	construct for the PostInfo class
     * \param	$counters, $createdAt, $fromUserInfo, $objectId, $showLove, $text
     */
    function __construct($counters, $createdAt, $fromUserInfo, $objectId, $showLove, $text) {
	global $boxes;
	is_null($counters) ? $this->counters = $boxes['NODATA'] : $this->counters = $counters;
	is_null($createdAt) ? $this->createdAt = $boxes['NODATA'] : $this->createdAt = $createdAt;
	is_null($fromUserInfo) ? $this->fromUserInfo = $boxes['NODATA'] : $this->fromUserInfo = $fromUserInfo;
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	is_null($showLove) ? $this->showLove = true : $this->showLove = $showLove;
	is_null($text) ? $this->text = $boxes['NODATA'] : $this->text = ($text);
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
	is_null($objectId) ? $this->objectId = $boxes['NODATA'] : $this->objectId = $objectId;
	switch ($type) {
	    case 'SPOTTER':
		$imageDefault = DEFTHUMBSPOTTER;
		break;
	    case 'JAMMER':
		$imageDefault = DEFTHUMBJAMMER;
		break;
	    case 'VENUE':
		$imageDefault = DEFTHUMBVENUE;
		break;
	}
	is_null($thumbnail) ? $this->thumbnail = $imageDefault : $this->thumbnail = $thumbnail;
	is_null($type) ? $this->type = $boxes['NODATA'] : $this->type = $type;
	is_null($username) ? $this->username = $boxes['NODATA'] : $this->username = ($username);
    }

}

/**
 * \fn	getRelatedUsers($objectId, $field, $className, $all, $limit, $skip)
 * \brief	Convenience method to get all kind of related User to a class for each page
 * \param	$objectId for the istance of the class the user is supposed to be related to, $field to be related to, $all BOOL: Yes to retrieve all related users or using the limit from config file, $page the page which calls the method
 * \return	userArray array of userInfo object
 * \todo        prevere la possibilità di avere più di 1000 utenti in lista
 */
function getRelatedUsers($objectId, $field, $className, $all, $limit, $skip) {
    global $boxes;
    $userArray = array();
    require_once CLASSES_DIR . 'user.class.php';
    require_once CLASSES_DIR . 'userParse.class.php';
    $parseUser = new UserParse();
    $parseUser->whereRelatedTo($field, $className, $objectId);
    $parseUser->where('active', true);
    ($all == true) ? $parseUser->setLimit(1000) : $parseUser->setLimit((is_null($limit) && is_int($limit) && $limit >= MIN && MAX <= $limit) ? DEFAULTQUERY : $limit);
    $parseUser->setSkip((is_null($skip) && is_int($skip)) ? 0 : $skip);
    $users = $parseUser->getUsers();
    if ($users instanceof Error) {
	return $users;
    } elseif (is_null($users)) {
	if ($className == 'Record') {
	    $users = $boxes['NOFEATRECORD'];
	} else {
	    switch ($field) {
		case 'attendee':
		    $users = $boxes['NOATTENDEE'];
		    break;
		case 'featuring':
		    $users = $boxes['NOFEATEVE'];
		    break;
		case 'invited':
		    $users = $boxes['NOINVITED'];
		    break;
	    }
	}
	return $users;
    } else {
	foreach ($users as $user) {
	    $userId = $user->getObjectId();
	    $thumbnail = $user->getProfileThumbnail();
	    $type = $user->getType();
	    $username = $user->getUsername();
	    $userInfo = new UserInfo($userId, $thumbnail, $type, $username);
	    array_push($userArray, $userInfo);
	}
    }
    return $userArray;
}

/**
 * \fn		sessionChecker()
 * \brief	The function returns a string wiht the objectId of the user in session, if there's no user return a invalid ID used (valid for the code)
 * \return	string $currentUserId;
 */
function sessionChecker() {
    require_once SERVICES_DIR . 'lang.service.php';
    require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
    require_once CLASSES_DIR . 'userParse.class.php';
    global $boxes;
    $currentUserId = $boxes['NOID'];
    session_start();
    if (isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	$currentUserId = $currentUser->getObjectId();
    }
    return $currentUserId;
}

?>