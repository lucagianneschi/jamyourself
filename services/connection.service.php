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

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'log.service.php';

class ConnectionService {

    /**
     * \fn	connect()
     * \brief	connect to the database
     * \return	connection or false
     */
    public function connect() {
	try {
	    $connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PSW, MYSQL_DB);
	    if (mysqli_connect_errno($connection)) {
		jam_log(__FILE__, __LINE__, 'Unable to connect to ' . MYSQL_HOST);
		return false;
	    } else {
		return $connection;
	    }
	} catch (Exception $e) {
	    jam_log(__FILE__, __LINE__, 'Unable to connect to ' . MYSQL_HOST);
	    return false;
	}
    }

    /**
     * \fn	curl($query, $params)
     * \brief	connet to the database
     * \return	true or errors
     */
    public function curl($query, $params) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, 'http://' . NEO4J_HOST . ':' . NEO4J_PORT . '/db/data/cypher');
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_HTTPHEADER, array(
	    'Accept: application/json; stream=true',
	    'Content-type: application/json',
	    'X-Stream: true'
	));
	curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($c, CURLOPT_POST, false);
	curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($c, CURLOPT_USERPWD, NEO4J_USER . ':' . NEO4J_PSW);
	$dataString = json_encode(array('query' => $query, 'params' => $params));
	curl_setopt($c, CURLOPT_POSTFIELDS, $dataString);
	$response = curl_exec($c);
	if ($response === false) {
	    jam_log($_SERVER['SCRIPT_NAME'], __LINE__, 'Unable to connect to ' . NEO4J_HOST);
	    return false;
	} else {
	    $data = json_decode($response, true);
	    $this->data = $data;
	}
    }

    /**
     * \fn	disconnect($connection)
     * \brief	disconnet from the database
     * \return	void
     */
    public function disconnect($connection) {
	@mysqli_close($connection);
    }

}

?>