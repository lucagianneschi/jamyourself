<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * ConnectionService class, for DB connections
 * 
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class ConnectionService {

    /**
     * @var BOOL 
     */
    public $commit;

    /**
     * @var BOOL 
     */
    private $autocommit;

    /**
     * Costruttore dell'oggetto
     */
    function __construct() {
	$this->commit = array();
	$this->autocommit = true;
    }

    /**
     * Set autcommit
     * @return BOOL true if ok, false otherwise
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
     * Set commit
     * @return BOOL true if ok, false otherwise
     */
    public function commit() {
	foreach ($this->commit as $url) {
	    $c = curl_init();
	    curl_setopt($c, CURLOPT_URL, $url);
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
	    $response = curl_exec($c);
	    if ($response === false) {
		jamLog(__FILE__, __LINE__, 'Unable to connect to ' . NEO4J_HOST);
		return false;
	    } else {
		return true;
	    }
	}
	$this->commit = array();
    }

    /**
     * Set connection
     * @return BOOL true if ok, false otherwise
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
	    jamLog(__FILE__, __LINE__, 'Unable to connect to ' . MYSQL_HOST);
	    return false;
	}
    }

    /**
     * Query on graph db
     * @return BOOL true if ok, false otherwise
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
	    curl_setopt($c, CURLOPT_URL, 'http://' . NEO4J_HOST . ':' . NEO4J_PORT . '/db/data/transaction');
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
		    $this->commit[] = $data['commit'];
		}
		return $data;
	    } else {
		jamLog(__FILE__, __LINE__, 'Unable to execute transaction to ' . NEO4J_HOST);
		return false;
	    }
	}
    }

    /**
     * Disconnection
     * @return void
     */
    public function disconnect($connection) {
	@mysqli_close($connection);
    }

    /**
     * get autocommit value
     */
    public function getAutocommit() {
	return $this->autocommit;
    }

}

?>