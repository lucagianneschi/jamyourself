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
 *  \todo		
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

/** \def DB('URL', 'jam-neo4j-dev.cloudapp.net')
 *  Define the URL for Node DB
 */
define('URL', 'jam-neo4j-dev.cloudapp.net');

/** \def DB('PORT', '7474')
 *  Define the Post for Node DB
 */
define('PORT', '7474');

class ConnectionService {

    private $active = false;
    private $connection = null;
    private $data = array();
    private $database = DB;
    private $error = null;
    private $host = HOST;
    private $password = PSW;
    private $user = USER;

    /**
     * \fn	curl($query, $params)
     * \brief	connet to the database
     * \return	true or errors
     */
    public function curl($query, $params) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, 'http://' . URL . ':' . PORT . '/db/data/cypher');
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_HTTPHEADER, array(
	    'Accept: application/json; stream=true',
	    'Content-type: application/json',
	    'X-Stream: true'
	));
	curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($c, CURLOPT_POST, false);
	curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($c, CURLOPT_USERPWD, USER . ':' . PSW);
	$dataString = json_encode(array('query' => $query, 'params' => $params));
	curl_setopt($c, CURLOPT_POSTFIELDS, $dataString);
	$response = curl_exec($c);
	if ($response === false) {
	    $this->error = new Exception("Can't open connection to " . URL);
	}
	$data = json_decode($response, true);
	$this->data = $data;
    }

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

    /**
     * \fn	getActive()
     * \brief	Return the active value
     * \return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	getConnection()
     * \brief	Return the connection value
     * \return	BOOL
     */
    public function getConnection() {
	return $this->connection;
    }

    /**
     * \fn	getDatabase()
     * \brief	Return the database name
     * \return	string
     */
    public function getDatabase() {
	return $this->database;
    }

    /**
     * \fn	getError()
     * \brief	Return the error
     * \return	string
     */
    public function getError() {
	return $this->error;
    }

    /**
     * \fn	getHost()
     * \brief	Return the host name
     * \return	string
     */
    public function getHost() {
	return $this->host;
    }

    /**
     * \fn	getPassword()
     * \brief	Return the password to access the DB
     * \return	string
     */
    public function getPassword() {
	return $this->password;
    }

    /**
     * \fn	getUser() 
     * \brief	Return the user to access the DB
     * \return	string
     */
    public function getUser() {
	return $this->user;
    }

    /**
     * \fn	setActive($active)
     * \brief	Set the active state 
     * \return	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn	setConnection($connection)
     * \brief	Set the connection state 
     * \return	BOOL
     */
    public function setConnection($connection) {
	$this->connection = $connection;
    }

    /**
     * \fn	setDatabase($database)
     * \brief	Set the database name in case of error connection
     * \return	string
     */
    public function setDatabase($database) {
	$this->database = $database;
    }

    /**
     * \fn	setError($error)
     * \brief	Set the error in case of error connection
     * \return	string
     */
    public function setError($error) {
	$this->error = $error;
    }

    /**
     * \fn	setHost($host) 
     * \brief	Set the host to access the DB
     * \return	string
     */
    public function setHost($host) {
	$this->host = $host;
    }

    /**
     * \fn	setPassword($password) 
     * \brief	Set the $password to access the DB
     * \return	string
     */
    public function setPassword($password) {
	$this->password = $password;
    }

    /**
     * \fn	setUser($user) 
     * \brief	Set the user to access the DB
     * \return	string
     */
    public function setUser($user) {
	$this->user = $user;
    }

}

?>