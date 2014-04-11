<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'utils.service.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'insert.service.php';
require_once SERVICES_DIR . 'update.service.php';

/**
 * CommentController class
 * controller di inserimento commenti
 * 
 * @author		Luca Gianneschi
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class CommentController extends REST {

    /**
     * @property array Array di config values
     */
    public $config;

    /**
     * Configura oggetto CommentController
     */
    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "commentController.config.json"), false);
    }

    /**
     * Salva un commento sul DB mySQL, crea nodi sul grafo, crea relazione nodi utente - nodo commento
     * @todo    testare e prevedere rollback
     */
    public function comment() {
        $startTimer = microtime();
        global $controllers, $mail_files;
        try {
            if ($this->get_request_method() != "POST") {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "No POST action"');
                $this->response(array('status' => $controllers['NOPOSTREQUEST']), 405);
            } elseif (!isset($_SESSION['id'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "No User in session"');
                $this->response(array('status' => $controllers['USERNOSES']), 403);
            } elseif (!isset($this->request['comment'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "No comment write"');
                $this->response(array('status' => $controllers['NOCOMMENT']), 400);
            } elseif (!isset($this->request['id'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "No object id"');
                $this->response(array('status' => $controllers['NOOBJECTID']), 403);
            } elseif (!isset($this->request['classType'])) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "No class type"');
                $this->response(array('status' => $controllers['NOCLASSTYPE']), 403);
            }
            $fromuserId = $_SESSION['id'];
            $levelValue = $_SESSION['levelvalue'];
            $comment = $this->request['comment'];
            $classType = $this->request['classType'];
            $id = $this->request['id'];
            if (strlen($comment) < $this->config->minCommentSize) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "Comment too short"');
                $this->response(array('status' => $controllers['SHORTCOMMENT'] . strlen($comment)), 406);
            } elseif (strlen($comment) > $this->config->maxCommentSize) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "Comment too long"');
                $this->response(array('status' => $controllers['LONGCOMMENT'] . strlen($comment)), 406);
            }
            $connectionService = new ConnectionService();
            $connection = $connectionService->connect();
            if ($connection === false) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "Unable to connect"');
                $this->response(array('status' => $controllers['CONNECTION ERROR']), 403);
            }
            
            switch (strtolower($classType)) {
                case 'comment':
                    $comments = selectComments($connection, $id);
                    if ($comments === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "Unable to execute selectComments"');
                        $this->response(array('status' => 'NOSELECT'), 403);
                    }
                    $object = $comments[$id];
            }
            
            require_once CLASSES_DIR . 'comment.class.php';
            $cmt = new Comment();
            $cmt->setActive(1);
            $cmt->setCommentcounter(0);
            $cmt->setCounter(0);
            $cmt->setFromuser($fromuserId);
            $cmt->setLatitude(null);
            $cmt->setLongitude(null);
            $cmt->setLovecounter(0);
            $cmt->setSharecounter(0);
            $cmt->setTag(array());
            $cmt->setTitle(null);
            $cmt->setText($comment);
            $cmt->setTouser($object->getFromuser()->getId());
            $cmt->setType('C');
            $cmt->setVote(null);
            switch (strtolower($classType)) {
                case 'album':
                    $cmt->setAlbum($id);
                    break;
                case 'comment':
                    $cmt->setComment($id);
                    break;
                case 'event':
                    $cmt->setEvent($id);
                    break;
                case 'image':
                    $cmt->setImage($id);
                    break;
                case 'record':
                    $cmt->setRecord($id);
                    break;
                case 'video':
                    $cmt->setVideo($id);
                    break;
            }
            $connection->autocommit(false);
            $connectionService->autocommit(false);
            $resCmt = insertComment($connection, $cmt);
            $commentCounter = update($connection, strtolower($classType), array('updatedat' => date('Y-m-d H:i:s')), array('commentcounter' => 1, 'counter' => 1 * $levelValue), null, $id);
            $node = createNode($connectionService, 'comment', $resCmt);
            $relation = createRelation($connectionService, 'user', $fromuserId, 'comment', $resCmt, 'ADD');
            if ($resCmt === false || $commentCounter === false || $node === false || $relation === false) {
                $endTimer = microtime();
                jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during comment "Unable to commit"');
                $this->response(array('status' => $controllers['COMMENTERR']), 503);
            } else {
                $connection->commit();
                $connectionService->commit();
            }
            #invio il commento in un altro punto del codice
            /*
            $users = selectUsers($connection, $toUserId);
            $address = $users[$toUserId]->getEmail();
            $subject = $controllers['SBJCOMMENT'];
            $html = $mail_files['COMMENTEMAIL'];
            sendMailForNotification($address, $subject, $html);
            */
            $connectionService->disconnect($connection);
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] comment executed');
            $this->response(array('status' => $controllers['COMMENTSAVED']), 200);
        } catch (Exception $e) {
            $this->response(array('status' => $e->getErrorMessage()), 503);
        }
    }

}

?>