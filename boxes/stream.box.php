<?php
/**
 * 
 * Box per lo stream
 * 
 * @author Daniele Caldelli
 * @version		0.2
 * @since		2014-03-17
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * box class to pass info to the view for timelinePage
 */
class StreamBox {

    public $activitiesArray = array();
    public $config;
    public $error = null;

    /**
     * class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "streamBox.config.json"), false);
    }

    /**
     * @param 	int $limit numero di record da prendere
     * @todo
     */
    public function init($limit = DEFAULTQUERY) {
        $startTimer = microtime();
        $currentUser = $_SESSION['id'];
        $connectionService = new ConnectionService();
        $query = "
                     MATCH (n1:user)-[r1]->(n2:user)-[r2]->(n3)
                     WHERE n1.id = {currentUser}
                       AND TYPE(r2) IN ['ADD', 'CREATE', 'COLLABORATION', 'FOLLOWING', 'FRIENDSHIP']
                       AND TYPE(r1) IN ['COLLABORATION']
            OPTIONAL MATCH (n1)-[r3:LOVE]->(n3)
                    RETURN n2.id, LABELS(n3), n3.id, TYPE(r2), CASE WHEN r3 IS NULL THEN 0 ELSE 1 END
                  ORDER BY r2.createdat DESC
                     LIMIT " . $limit;
        $params = array(
            'currentUser' => (int)$currentUser
        );
        $res = $connectionService->curl($query, $params);
        if ($res === false) {
            $endTimer = microtime();
            jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $query);
            $this->error = 'Unable to execute query';
            return;
        }
        $couples = array();
	    $connection = $connectionService->connect();
	    foreach ($res['data'] as $couple) {
            $fromuserId = $couple[0];
            $class = $couple[1][0];
            $id = $couple[2];
            $relationType = $couple[3];
            $love = $couple[4];
            $type = null;
            $object = null;
            $referredObject = null;
            
            /*
            Lista delle activity con annesse relazioni/nodi
            ALBUMCREATED                user-CREATE->album
            COLLABORATIONREQUEST        user-COLLABORATION->user
            COMMENTEDONALBUM            user-ADD->comment
            COMMENTEDONEVENT            user-ADD->comment
            COMMENTEDONEVENTREVIEW      user-ADD->comment
            COMMENTEDONIMAGE            user-ADD->comment
            COMMENTEDONPOST             user-ADD->comment
            COMMENTEDONRECORD           user-ADD->comment
            COMMENTEDONRECORDREVIEW     user-ADD->comment
            COMMENTEDONVIDEO            user-ADD->comment
            EVENTCREATED                user-CREATE->event
            FOLLOWING                   user-FOLLOWING->user
            FRIENDSHIPREQUEST           user-FRIENDSHIP->user
            IMAGEADDEDTOALBUM           user-ADD->image
            NEWEVENTREVIEW              user-ADD->comment
            NEWRECORDREVIEW             user-ADD->comment
            POSTED                      user-ADD->comment
            RECORDCREATED               user-CREATE->record
            SONGADDEDTORECORD          user-ADD->song
            */
            
            jamDebug('debug.txt', 'stream.box class => ' . $class);
            jamDebug('debug.txt', 'stream.box id => ' . $id);
            jamDebug('debug.txt', 'stream.box relationType => ' . $relationType);
            jamDebug('debug.txt', 'stream.box love => ' . $love);
            
            switch ($class) {
                case 'album':
                    $albums = selectAlbums($connection, $id);
                    if ($albums === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectAlbums su id => ' . $id);
                        $this->error = 'Unable to execute query';
                        return;
                    }
                    $object = $albums[$id];
                    $type = 'ALBUMCREATED';
                    break;
                case 'comment':
                    $comments = selectComments($connection, $id);
                    if ($comments === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectComments su id => ' . $id);
                        $this->error = 'Unable to execute query';
                        return;
                    }
                    $object = $comments[$id];
                    if ($object->getType() == 'P') {
                        $type = 'POSTED';
                    } elseif ($object->getType() == 'RE') {
                        $events = selectEvents($connection, $object->getEvent());
                        if ($events === false) {
                            $endTimer = microtime();
                            jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectEvents su id => ' . $object->getEvent());
                            $this->error = 'Unable to execute query';
                            return;
                        }
                        $referredObject = $events[$object->getEvent()];
                        $type = 'NEWEVENTREVIEW';
                    } elseif ($object->getType() == 'RR') {
                        $records = selectRecords($connection, $object->getRecord());
                        if ($records === false) {
                            $endTimer = microtime();
                            jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectRecords su id => ' . $object->getRecord());
                            $this->error = 'Unable to execute query';
                            return;
                        }
                        $referredObject = $records[$object->getRecord()];
                        $type = 'NEWRECORDREVIEW';
                    } elseif ($object->getType() == 'C') {
                        if ($object->getAlbum()) {
                            $albums = selectAlbums($connection, $object->getAlbum());
                            if ($albums === false) {
                                $endTimer = microtime();
                                jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectAlbums su id => ' . $object->getAlbum());
                                $this->error = 'Unable to execute query';
                                return;
                            }
                            $referredObject = $albums[$object->getAlbum()];
                            $type = 'COMMENTEDONALBUM';
                        } elseif ($object->getComment()) {
                            $comments = selectComments($connection, $object->getComment());
                            if ($comments === false) {
                                $endTimer = microtime();
                                jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectComments su id => ' . $object->getComment());
                                $this->error = 'Unable to execute query';
                                return;
                            }
                            $referredObject = $comments[$object->getComment()];
                            if ($referredObject->getType() == 'RE') {
                                $type = 'COMMENTEDONEVENTREVIEW';
                            } elseif ($referredObject->getType() == 'RR') {
                                $type = 'COMMENTEDONRECORDREVIEW';
                            } elseif ($referredObject->getType() == 'P') {
                                $type = 'COMMENTEDONPOST';
                            }
                        } elseif ($object->getEvent()) {
                            $events = selectEvents($connection, $object->getEvent());
                            if ($events === false) {
                                $endTimer = microtime();
                                jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectEvents su id => ' . $object->getEvent());
                                $this->error = 'Unable to execute query';
                                return;
                            }
                            $referredObject = $events[$object->getEvent()];
                            $type = 'COMMENTEDONEVENT';
                        } elseif ($object->getImage()) {
                            $images = selectImages($connection, $object->getImage());
                            if ($images === false) {
                                $endTimer = microtime();
                                jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectImages su id => ' . $object->getImage());
                                $this->error = 'Unable to execute query';
                                return;
                            }
                            $referredObject = $images[$object->getImage()];
                            $type = 'COMMENTEDONIMAGE';
                        } elseif ($object->getRecord()) {
                            $records = selectRecords($connection, $object->getRecord());
                            if ($records === false) {
                                $endTimer = microtime();
                                jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectRecords su id => ' . $object->getRecord());
                                $this->error = 'Unable to execute query';
                                return;
                            }
                            $referredObject = $records[$object->getRecord()];
                            $type = 'COMMENTEDONRECORD';
                        } elseif ($object->getVideo()) {
                            $videos = selectVideos($connection, $object->getVideo());
                            if ($videos === false) {
                                $endTimer = microtime();
                                jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectVideos su id => ' . $object->getVideo());
                                $this->error = 'Unable to execute query';
                                return;
                            }
                            $referredObject = $videos[$object->getVideo()];
                            $type = 'COMMENTEDONVIDEO';
                        }
                    }
                    break;
                case 'event':
                    $events = selectEvents($connection, $id);
                    if ($events === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectEvents su id => ' . $id);
                        $this->error = 'Unable to execute query';
                        return;
                    }
                    $object = $events[$id];
                    $type = 'EVENTCREATED';
                    break;
                case 'image':
                    $images = selectImages($connection, $id);
                    if ($images === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectImages su id => ' . $id);
                        $this->error = 'Unable to execute query';
                        return;
                    }
                    $object = $images[$id];
                    $type = 'IMAGEADDEDTOALBUM';
                    break;
                case 'record':
                    $records = selectRecords($connection, $id);
                    if ($records === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectRecords su id => ' . $id);
                        $this->error = 'Unable to execute query';
                        return;
                    }
                    $object = $records[$id];
                    $type = 'RECORDCREATED';
                    break;
                case 'song':
                    $songs = selectSongs($connection, $id);
                    if ($songs === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectSongs su id => ' . $id);
                        $this->error = 'Unable to execute query';
                        return;
                    }
                    $object = $songs[$id];
                    $type = 'SONGADDEDTORECORD';
                    break;
                case 'user':
                    $users = selectUsers($connection, null, array('id' => array($id, $fromuserId)));
                    if ($users === false) {
                        $endTimer = microtime();
                        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute selectUsers su id => ' . $id);
                        $this->error = 'Unable to execute query';
                        return;
                    }
                    $object = $users[$id];
                    $referredObject = $users[$fromuserId];
                    if ($relationType == 'COLLABORATION') {
                        $type = 'COLLABORATIONREQUEST';
                    } elseif ($relationType == 'FOLLOWING') {
                        $type = 'FOLLOWING';
                    } elseif ($relationType == 'FRIENDSHIP') {
                        $type = 'FRIENDSHIPREQUEST';
                    }
                    break;
            }
            
            jamDebug('debug.txt', 'stream.box type => ' . $type);
                        
            $couples[] = array('object' => $object,
                               'referredObject' => $referredObject,
                               'type' => $type,
                               'love' => $love);
	    }
	    $endTimer = microtime();
        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($couples) . ' rows returned');
        $this->activitiesArray = $couples;
    }

    /**
     * \fn	createActivityArray($userType)
     * \brief	private funtion for creating the activity type array based on the user type
     * \param	$userType
     * \todo
     */
    /*
      private function createActivityArray($userType) {
      $sharedActivities = $this->config->sharedActivities;
      switch ($userType) {
      case 'SPOTTER':
      $specificActivities = $this->config->spotterActivities;
      break;
      case 'VENUE':
      $specificActivities = $this->config->venueActivities;
      break;
      case 'JAMMER':
      $specificActivities = $this->config->jammerActivities;
      break;
      }
      $actArray = array_merge($sharedActivities, $specificActivities);
      return $actArray;
      }
     */
}
?>