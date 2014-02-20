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

/** \def HOST('HOST', jam-mysql-dev.cloudapp.net)
 *  Define the host for the DB
 */
define('HOST', 'jam-mysql-dev.cloudapp.net');

/** \def USER('USER', jamyourself)
 *  Define the user for DB
 */
define('USER', 'jamyourself');

/** \def PSW('PSW', j4my0urs3lf)
 *  Define the Password for DB
 */
define('PSW', 'j4my0urs3lf');

/** \def DB('DB', jamdatabase)
 *  Define the Mdatabase name
 */
define('DB', 'jamdatabase');

class ConnectionService {

    private $host = HOST;
    private $user = USER;
    private $password = PSW;
    private $database = DB;
    private $active = false;
    private $error = null;
    private $connection = null;

    /**
     * \fn	connect()
     * \brief	connet to the database
     * \return	true or errors
     */
    public function connect() {
        if (!$this->active) {
            $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);
            if (mysqli_connect_errno($this->connection)) {
            $this->error = mysqli_connect_error();
            exit();
            } else {
            $this->active = true;
            }
        }
        return true;
    }

    /**
     * \fn	disconnect($connection)
     * \brief	disconnet from the database
     * \return	true
     */
    public function disconnect() {
        if ($this->active) {
            mysqli_close($this->connection);
            $this->active = false;
        }
        return true;
    }

}
?>