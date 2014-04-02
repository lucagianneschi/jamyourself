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
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 */

/**
 * Delete node and all it relation on the node4J DB
 * 
 * @param  $nodeType, $nodeId
 * @todo
 */
function deleteNode($connection, $nodeType, $nodeId) {
    $query = '
    MATCH (n:' . $nodeType . ' {id:' . $nodeId . '})
    OPTIONAL MATCH (n)-[r]-()
    DELETE n, r
	';
    $res = $connection->curl($query);
    if ($res === false) {
	return false;
    } else {
	return true;
    }
}

/**
 * Delete relation between nodes on the node4J DB
 * 
 * @param  $fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relType
 * @todo
 */
function deleteRelation($connection, $fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relType) {
    $query = '
	MATCH (n:' . $fromNodeType . ' {id:' . $fromNodeId . '})-[r:' . $relType . ']->(m:' . $toNodeType . ' {id:' . $toNodeId . '})
	DELETE r
	';
    $res = $connection->curl($query);
    if ($res === false) {
	return false;
    } else {
	return true;
    }
}

/**
 * Delete an object logically setting active to false
 * 
 * @param  $class   the class to delete
 * @param  $id      the id of the class to delete
 * @todo
 */
function delete($connection, $class, $id) {
    $sql = "UPDATE " . $class . "
               SET active = 0,
                   updatedat = NOW()
             WHERE id = " . $id;
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
        jamLog(__FILE__, __LINE__, 'Unable to execute delete');
        return false;
    } else {
        return true;
    }
}
?>