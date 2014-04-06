<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'error.class.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * Servizio inserimento dei record nel DB
 *
 * @author Daniele Caldelli
 * @author Maria Laura Fresu
 * @version 0.2
 * @since 2014-03-12
 * @copyright Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 */

/**
 * Delete node and all it relation on the node4J DB
 * 
 * @param  $nodeType string tipo del nodo
 * @param  $nodeId int id del nodo
 * @todo
 */
function deleteNode($connection, $nodeType, $nodeId) {
    $startTimer = microtime();
    $query = '
    MATCH (n:' . $nodeType . ' {id:' . $nodeId . '})
    OPTIONAL MATCH (n)-[r]-()
    DELETE n, r
	';
    $res = $connection->curl($query);
    if ($res === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute deleteNode between ' . $nodeId . 'query' . $query);
	return false;
    } else {
	return true;
    }
}

/**
 * Delete relation between nodes on the node4J DB
 * 
 * @param $fromNodeType string tipo di nodo di partenza 
 * @param $fromNodeId int id del nodo di partenza 
 * @param $toNodeType string tipo di nodo di arrivo
 * @param $toNodeId int id del nodo di arrivo
 * @param $relType string nome della relazione tra i 2 nodi
 * @todo
 */
function deleteRelation($connection, $fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relType) {
    $startTimer = microtime();
    $query = '
	MATCH (n:' . $fromNodeType . ' {id:' . $fromNodeId . '})-[r:' . $relType . ']->(m:' . $toNodeType . ' {id:' . $toNodeId . '})
	DELETE r
	';
    $res = $connection->curl($query);
    if ($res === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute deleteRelation between ' . $fromNodeId . 'and' . $toNodeId . 'relazione di tipo' . $relType . 'query' . $query);
	return false;
    } else {
	return true;
    }
}

/**
 * Delete an object logically setting active to false
 * 
 * @param connection $connection Connessione
 * @param  $class string  the class to delete
 * @param  $id int  the id of the class to delete
 * @todo
 */
function delete($connection, $class, $id) {
    $startTimer = microtime();
    $sql = "UPDATE " . $class . "
               SET active = 0,
                   updatedat = NOW()
             WHERE id = " . $id;
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute delete of ' . $class . 'instance, SQL query is' . $sql);
	return false;
    } else {
	return true;
    }
}

?>