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
 * \todo		test approfonditi
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'activityParse.class.php';

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
    $relationActivity = new ActivityParse();
    $relationActivity->wherePointer('fromUser', '_User', $currentUserId);
    $relationActivity->wherePointer('toUser', '_User', $toUserId);
    $relationActivity->where('active', true);
    $relationActivity->where('type', $type);
    $relationActivity->where('status', 'A');
    $check = $relationActivity->getCount();
    $relation = ($check != 0) ? true : false;
    return $relation;
}

?>