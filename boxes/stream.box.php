﻿<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
 * \par			Commenti:
 * \warning
 * \bug
 * \todo	        	        
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * \brief	StreamBox class
 * \details	box class to pass info to the view for timelinePage
 */
class StreamBox {

    public $activitiesArray = array();
    public $config;
    public $error = null;

    /**
     * \fn	__construct()
     * \brief	class construct to import config file
     */
    function __construct() {
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "streamBox.config.json"), false);
    }

    /**
     * \fn	init
     * \brief	timeline init
     * \param	$limit, $skip
     * \todo
     */
    public function init($limit = DEFAULTQUERY) {
        $currentUser = $_SESSION['id'];
        $connectionService = new ConnectionService();
        
        $query = "
           MATCH (n1:user)-[r1]->(n2:user)-[r2]->(n3)
           WHERE n1.id = {currentUser}
             AND TYPE(r2) IN ['ADD', 'CREATE', 'POST']
             AND TYPE(r1) IN ['COLLABORATION']
          RETURN LABELS(n3), n3.id
        ORDER BY r2.createdat DESC
           LIMIT " . $limit;
        $params = array(
            'currentUser' => $currentUser
        );
        $res = $connectionService->curl($query, $params);
        if ($res === false) {
            $this->error = 'Unable to execute query';
        } else {
            $couples = array();
            $connection = $connectionService->connect();
            foreach($res['data'] as $couple) {
                $class = $couple[0][0];
                $id = $couple[1];
                switch($class) {
                    case 'comment':
                        $comments = selectComments($connection, $id);
                        $object = $comments[$id];
                        break;
                }
                $couples[] = array('class' => $class, 'id' => $id, 'object' => $object);
            }
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