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
                   AND TYPE(r2) IN ['ADD', 'CREATE', 'POST']
                   AND TYPE(r1) IN ['COLLABORATION']
        OPTIONAL MATCH (n1)-[r3:LOVE]->(n3)
                RETURN LABELS(n3), n3.id, CASE WHEN r3 IS NULL THEN 0 ELSE 1 END
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
	} else {
        $couples = array();
	    $connection = $connectionService->connect();
	    foreach ($res['data'] as $couple) {
            $class = $couple[0][0];
            $id = $couple[1];
            switch ($class) {
                case 'album':
                    $albums = selectAlbums($connection, $id);
                    $object = $albums[$id];
                    break;
                case 'comment':
                    $comments = selectComments($connection, $id);
                    $object = $comments[$id];
                    break;
                case 'image':
                    $images = selectImages($connection, $id);
                    $object = $images[$id];
                    break;
                case 'record':
                    $records = selectRecords($connection, $id);
                    $object = $records[$id];
                    break;
                case 'song':
                    $songs = selectSongs($connection, $id);
                    $object = $songs[$id];
                    break;
                case 'video':
                    $videos = selectVideos($connection, $id);
                    $object = $videos[$id];
                    break;
            }
            $love = $couple[2];
            $couples[] = array('class' => $class, 'id' => $id, 'love' => $love, 'object' => $object);
	    }
	    $endTimer = microtime();
        jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($couples) . ' rows returned');
        $this->activitiesArray = $couples;
	}
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