<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info utente 
 * \details		Recupera le informazioni dell'utente, le inserisce in oggetto e le passa agli altri oggetti
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */

class Counters {

    public $commentCounter;
    public $loveCounter;
    public $shareCounter;

    function __construct($commentCounter, $loveCounter, $shareCounter) {
	is_null($commentCounter) ? $this->commentCounter = 0 : $this->commentCounter = $commentCounter;
	is_null($loveCounter) ? $this->loveCounter = 0 : $this->loveCounter = $loveCounter;
	is_null($shareCounter) ? $this->shareCounter = 0 : $this->shareCounter = $shareCounter;
    }

}

class UserInfo {

    public $thumbnail;
    public $type;
    public $username;

    function __construct($thumbnail, $type, $username) {
	is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
	is_null($type) ? $this->type = NODATA : $this->type = $type;
	is_null($username) ? $this->username = NODATA : $this->username = $username;
    }

}

?>