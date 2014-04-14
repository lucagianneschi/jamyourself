<?php

/**
 * Servizio commessione DB
 * 
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-04-14
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'log.service.php';

class ConnectionService {

    /**
     * @property int 
     */
    public $numberCommit;

    /**
     * @property int 
     */
    private $autocommit;

    /**
     * constructor for the class
     * 
     */
    function __construct() {
	$this->numberCommit = -1;
	$this->autocommit = true;
    }

    /**
     * autocommit management
     * 
     * @return	true, false in case of error
     */
    public function autocommit($value) {
	if (is_bool($value)) {
	    $this->autocommit = $value;
	    return true;
	} else {
	    jamLog(__FILE__, __LINE__, 'The parameter must be bool');
	    return false;
	}
    }

    /**
     * connet to the database
     * 
     * @return	true or errors
     */
    public function commit() {
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, 'http://' . NEO4J_HOST . ':' . NEO4J_PORT . '/db/data/transaction/' . $this->numberCommit . '/commit');
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_HTTPHEADER, array(
	    'Accept: application/json; charset=UTF-8',
	    'Content-type: application/json',
	    'X-Stream: true'
	));
	curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($c, CURLOPT_POST, false);
	curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($c, CURLOPT_USERPWD, NEO4J_USER . ':' . NEO4J_PSW);
	$response = curl_exec($c);
	if ($response === false) {
	    jamLog(__FILE__, __LINE__, 'Unable to connect to ' . NEO4J_HOST . ' => ' . json_encode(curl_error($c)));
	    return false;
	} else {
	    return true;
	}
	$this->numberCommit = -1;
    }

    /**
     * connet to the database
     * 
     * @return	true or errors
     */
    public function connect() {
	try {
	    $connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PSW, MYSQL_DB);
	    if (mysqli_connect_errno($connection)) {
		jamLog(__FILE__, __LINE__, 'Unable to connect to ' . MYSQL_HOST);
		return false;
	    } else {
		return $connection;
	    }
	} catch (Exception $e) {
	    jamLog(__FILE__, __LINE__, ' "Exception" => ' . $e->getMessage() . 'Unable to connect to ' . MYSQL_HOST);
	    return false;
	}
    }

    /**
     * Query on graph DB
     * 
     * @return	true or errors
     */
    public function curl($query, $params = null) {
	$c = curl_init();
	if ($this->autocommit) {
	    curl_setopt($c, CURLOPT_URL, 'http://' . NEO4J_HOST . ':' . NEO4J_PORT . '/db/data/cypher');
	    if (is_null($params)) {
		$dataString = json_encode(array('query' => $query));
	    } else {
		$dataString = json_encode(array('query' => $query, 'params' => $params));
	    }
	} else {
	    $url = 'http://' . NEO4J_HOST . ':' . NEO4J_PORT . '/db/data/transaction';
	    if ($this->numberCommit > -1) {
		$url = $url . '/' . $this->numberCommit;
	    }
	    curl_setopt($c, CURLOPT_URL, $url);
	    if (is_null($params)) {
		$dataString = json_encode(array('statements' => array(array('statement' => $query))));
	    } else {
		$dataString = json_encode(array('statements' => array(array('statement' => $query, 'parameters' => $params))));
	    }
	}
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
	curl_setopt($c, CURLOPT_POSTFIELDS, $dataString);
	$response = curl_exec($c);
	if ($response === false) {
	    jamLog(__FILE__, __LINE__, 'Unable to connect to ' . NEO4J_HOST);
	    return false;
	} else {
	    if (empty($data['errors'])) {
		$data = json_decode($response, true);
		if (!$this->autocommit) {
		    $resExploded = explode('/', $data['commit']);
		    $this->numberCommit = $resExploded[count($resExploded) - 2];
		    //$this->commit[] = $data['commit'];
		}
		return $data;
	    } else {
		jamLog(__FILE__, __LINE__, 'Unable to execute transaction to ' . NEO4J_HOST);
		return false;
	    }
	}
    }

    /**
     * disconnet to the database
     */
    public function disconnect($connection) {
	@mysqli_close($connection);
    }

    /**
     * get the autocommit value
     */
    public function getAutocommit() {
	return $this->autocommit;
    }

}

?>