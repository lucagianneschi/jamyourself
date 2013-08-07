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
