<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'update.service.php';
require_once SERVICES_DIR . 'delete.service.php';
require_once SERVICES_DIR . 'utils.service.php';

/**
 * LoveController class
 * controller di love/unlove
 * 
 * @author		Daniele Caldelli
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */

/**
 * LoveController class 
 * controller di love/unlove
 */
class LoveController extends REST {

    /**
     * increments loveCounter property of an istance of a class
     * @todo    invio mail? creazione notifica per proprietario media
     */
    public function incrementLove() {
        $startTimer = microtime();
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "No POST action"');
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['id'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "No User in session"');
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            }
            $classTypeAdmitted = array('Album', 'Comment', 'Event', 'Image', 'Record', 'Song', 'Video');
            if (!isset($this->request['classType'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "No class type"');
                $this->response(array('status' => 'NOCLASSTYPE'), 400);
            } elseif (!isset($this->request['id'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "No object id"');
                $this->response(array('status' => 'NOOBJECTID'), 400);
            } elseif (!in_array($this->request['classType'], $classTypeAdmitted)) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "Class type not admitted"');
                $this->response(array('status' => 'CLASSTYPEKO'), 400);
            }
            $fromuserId = $_SESSION['id'];
            $classType = $this->request['classType'];
            $id = $this->request['id'];
            $connectionService = new ConnectionService();
            if (existsRelation($connectionService, 'user', $fromuserId, strtolower($classType), $id, 'LOVE')) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "The relation exists"');
                $this->response(array('status' => 'ALREADYLOVED'), 400);
            }
            $connection = $connectionService->connect();
            if ($connection === false) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "Unable to connect"');
                $this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
            }
            $connection->autocommit(false);
            $connectionService->autocommit(false);
            $updateCounter = update($connection, strtolower($classType), array('updatedat' => date('Y-m-d H:i:s')), array('lovecounter' => 1), null, $id);
            $selectCounter = query($connection, 'SELECT lovecounter FROM ' . strtolower($classType) . ' WHERE id = ' . $id);
            $relation = createRelation($connectionService, 'user', $fromuserId, strtolower($classType), $id, 'LOVE');
            if ($updateCounter === false || $relation === false || $selectCounter === false) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "Unable to execute query"');
                $this->response(array('status' => $controllers['COMMENTERR']), 503);
            } else {
                $connection->commit();
                $connectionService->commit();
            }
            $connectionService->disconnect($connection);
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] incrementLove executed');
            $this->response(array('status' => $selectCounter[0]['lovecounter']), 200);
        } catch (Exception $e) {
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during incrementLove "Exception" => ' . $e->getMessage());
            $this->response(array('status' => $e->getMessage()), 501);
        }
    }

    /**
     * decrements loveCounter property of an istance of a class
     * 
     * @todo testare
     */
    public function decrementLove() {
        $startTimer = microtime();
        global $controllers;
        try {
            if ($this->get_request_method() != "POST") {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "No POST action"');
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['id'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "No User in session"');
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            }
            $classTypeAdmitted = array('Album', 'Comment', 'Event', 'Image', 'Record', 'Song', 'Video');
            if (!isset($this->request['classType'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "No class type"');
                $this->response(array('status' => 'NOCLASSTYPE'), 400);
            } elseif (!isset($this->request['id'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "No object id"');
                $this->response(array('status' => 'NOOBJECTID'), 400);
            } elseif (!in_array($this->request['classType'], $classTypeAdmitted)) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "Class type not admitted"');
                $this->response(array('status' => 'CLASSTYPEKO'), 400);
            }
            $fromuserId = $_SESSION['id'];
            $classType = $this->request['classType'];
            $id = $this->request['id'];
            $connectionService = new ConnectionService();
            if (!existsRelation($connectionService, 'user', $fromuserId, strtolower($classType), $id, 'LOVE')) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "The relation not exists"');
                $this->response(array('status' => 'NOLOVE'), 400);
            }
            $connection = $connectionService->connect();
            if ($connection === false) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "Unable to connect"');
                $this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
            }
            $connection->autocommit(false);
            $connectionService->autocommit(false);
            $updateCounter = update($connection, strtolower($classType), array('updatedat' => date('Y-m-d H:i:s')), null, array('lovecounter' => 1), $id);
            $selectCounter = query($connection, 'SELECT lovecounter FROM ' . strtolower($classType) . ' WHERE id = ' . $id);
            $relation = deleteRelation($connectionService, 'user', $fromuserId, strtolower($classType), $id, 'LOVE');
            if ($updateCounter === false || $selectCounter=== false || $relation === false) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "Unable to execute query"');
                $this->response(array('status' => $controllers['COMMENTERR']), 503);
            } else {
                $connection->commit();
                $connectionService->commit();
            }
            $connectionService->disconnect($connection);
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] decrementLove executed');
            $this->response(array('status' => $selectCounter[0]['lovecounter']), 200);
        } catch (Exception $e) {
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during decrementLove "Exception" => ' . $e->getMessage());
            $this->response(array('status' => $e->getMessage()), 500);
        }
    }

}

?>