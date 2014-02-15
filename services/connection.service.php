<?php

/* ! \par		Info Generali:
 *  \author		Luca Gianneschi
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Servizio commessione DB
 *  \details		Servizio commessione DB
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo		inserire dati connessione DB corretti
 *
 */

class ConnectionService {

    private $host = "localhost";
    private $user = "username";
    private $password = "password";
    private $database = "database";
    private $active = false;
    private $error = null;

    /**
     * \fn	connect()
     * \brief	connet to the database
     * \return	true or errors
     */
    public function connect() {
	if (!$this->active) {
	    mysqli_connect($this->host, $this->user, $this->password, $this->database);
	    if (mysqli_connect_errno()) {
		$this->error = mysqli_connect_error();
		exit();
	    } else {
		$this->active = true;
		return true;
	    }
	} else {
	    $this->active = true;
	    return true;
	}
    }

    /**
     * \fn	disconnect()
     * \brief	disconnet from the database
     * \return	true
     */
    public function disconnect() {
	if ($this->active) {
	    if (mysqli_close()) {
		$this->active = false;
		return true;
	    } else {
		return false;
	    }
	}
    }

}
?>