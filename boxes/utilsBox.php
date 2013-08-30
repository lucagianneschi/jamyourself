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
    function __construct($commentCounter, $loveCounter,$reviewCounter, $shareCounter) {
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

    public $thumbnail;
    public $type;
    public $username;

    /**
     * \fn	__construct($thumbnail, $type, $username)
     * \brief	construct for the UserInfo class
     * \param	$thumbnail, $type, $username
     */
    function __construct($thumbnail, $type, $username) {
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($type) ? $this->type = NODATA : $this->type = $type;
	is_null($username) ? $this->username = NODATA : $this->username = $username;
    }

}

?>