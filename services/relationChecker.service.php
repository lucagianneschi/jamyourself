<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Funzione:
 * \brief		servizio di check sull'esistenza relazione tra 2 user
 * \details		
 * \par			Commenti:
 * \warning
 * \bug			
 * \todo		utilizzare la sessione per il currentUserId e per currentUserType
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';

require_once CLASSES_DIR . 'activityParse.class.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \fn	relationChecker($currentUserId, $currentUserType, $toUserId, $toUserType)
 * \brief	check if 2 users ara in a relationship (any kind)
 * \param	$currentUserId, $currentUserType, $toUserId, $toUserType
 * \return  true if there's a relation between users, false otherwise
 */
function relationChecker($currentUserId, $currentUserType, $toUserId, $toUserType) {
    if ($currentUserType == 'SPOTTER') {
	$type = ($toUserType == 'SPOTTER') ? 'FRIENDSHIPREQUEST' : 'FOLLOWING';
    } else {
	$type = ($toUserType == 'SPOTTER') ? 'FOLLOWING' : 'COLLABORATIONREQUEST';
    }
    $compoundQuery = array(
	array('objectId' => array('$select' => array('query' => array('where' => array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $currentUserId), 'toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $toUserId)), 'className' => 'Activity'), 'key' => 'objectId'))),
	array('objectId' => array('$select' => array('query' => array('where' => array('fromUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $toUserId), 'toUser' => array('__type' => 'Pointer', 'className' => '_User', 'objectId' => $currentUserId)), 'className' => 'Activity'), 'key' => 'objectId'))));
    $relationActivity = new ActivityParse();
    $relationActivity->whereOr($compoundQuery);
    $relationActivity->where('active', true);
    $relationActivity->where('type', $type);
    $relationActivity->where('status', 'A');
    $check = $relationActivity->getCount();
    $relation = ($check != 0) ? true : false;
    return $relation;
}

?>